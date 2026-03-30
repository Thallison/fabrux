<?php

namespace Modules\Producao\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Cadastros\Models\Funcionarios;
use Modules\Cadastros\Models\Produtos;
use Modules\Base\Traits\BaseUtils;

class ProducoesController extends BaseController
{
    use BaseUtils;

     /** Set atributos da view */
    protected function getAttributesView()
    {
        return array(
            'produtos' => Produtos::where('prod_ativo', true)->orderBy('prod_nome', 'ASC')->get(['prod_id', 'prod_nome']),
            'funcionarios' => Funcionarios::where('fun_ativo', true)->orderBy('fun_nome', 'ASC')->get(['fun_id', 'fun_nome']),
            'ranking' => $this->getRanking(),
            'e' => $this
        );
    }

    public function update(Request $request, $id)
    {
        $retEntity = $this->getModel()->findData($id);

        $request->merge([
            'fun_id' => $retEntity->fun_id,
            'prod_id' => $retEntity->prod_id,
        ]);

        return parent::update($request, $id);
    }

    public function searchProdutos(Request $request)
    {
        $query = trim($request->input('q', ''));

        $produtos = Produtos::query()
            ->when($query, function ($q) use ($query) {
                $q->where('prod_nome', 'like', "%{$query}%");
            })
            ->orderBy('prod_nome', 'ASC')
            ->limit(20)
            ->get(['prod_id', 'prod_nome']);

        return response()->json($produtos);
    }

    protected function getRanking()
    {
        return $this->getModel()
            ->selectRaw('pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(pro_producoes.produ_quantidade) as total_quantidade, SUM(pro_producoes.produ_tempo_gasto) as total_tempo')
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->orderByDesc('total_quantidade')
            ->limit(10)
            ->get();
    }

    public function dashboard(Request $request)
    {
        $today = Carbon::today();
        $last7Days = $today->copy()->subDays(6);
        $last6Months = $today->copy()->subMonths(5)->firstOfMonth();
        $currentMonth = Carbon::now();
        $endOfMonth = $currentMonth->copy()->endOfMonth();

        $model = $this->getModel();

        $totalToday = (int) $model->where('produ_data', $today)->sum('produ_quantidade');
        $todayDistinctHours = (int) $model
            ->where('produ_data', $today)
            ->whereNotNull('produ_hora')
            ->selectRaw('COUNT(DISTINCT HOUR(produ_hora)) as hour_count')
            ->value('hour_count');

        $todayAveragePerHour = $todayDistinctHours ? round($totalToday / $todayDistinctHours, 2) : 0;

        $employeesToday = $model
            ->selectRaw('pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(produ_quantidade) as total_quantity, SUM(produ_tempo_gasto) as total_time')
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->where('produ_data', $today)
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->orderByDesc('total_quantity')
            ->get()
            ->map(function ($item) {
                $item->avg_seconds = $item->total_quantity ? round($item->total_time / $item->total_quantity) : 0;
                $item->production_per_hour = $item->total_time ? round($item->total_quantity / ($item->total_time / 3600), 2) : 0;
                return $item;
            });

        $topEmployeesToday = $employeesToday->take(5);
        $averageEmployeeToday = $employeesToday->count() ? round($employeesToday->avg('total_quantity'), 2) : 0;
        $employeesBelowAverage = $employeesToday
            ->where('total_quantity', '<', $averageEmployeeToday)
            ->values();

        $totalMonth = (int) $model
            ->whereYear('produ_data', $currentMonth->year)
            ->whereMonth('produ_data', $currentMonth->month)
            ->sum('produ_quantidade');

        $daysElapsed = $currentMonth->day;
        $averageDailyMonth = $daysElapsed ? round($totalMonth / $daysElapsed, 2) : 0;
        $daysRemaining = $today->diffInDays($endOfMonth);
        $projectedMonth = round($totalMonth + ($averageDailyMonth * $daysRemaining));
        $monthProgress = $averageDailyMonth && $daysElapsed ? min(100, ($totalMonth / ($averageDailyMonth * $daysElapsed)) * 100) : 0;

        $dailyProduction = [];
        for ($date = $last7Days->copy(); $date->lte($today); $date->addDay()) {
            $dailyProduction[$date->format('Y-m-d')] = [
                'label' => $date->format('d/m'),
                'total_quantity' => 0,
            ];
        }

        $dailyRecords = $model
            ->selectRaw('produ_data as date, SUM(produ_quantidade) as total_quantity')
            ->whereBetween('produ_data', [$last7Days, $today])
            ->groupBy('produ_data')
            ->orderBy('produ_data')
            ->get();

        foreach ($dailyRecords as $record) {
            $dailyProduction[$record->date]['total_quantity'] = (int) $record->total_quantity;
        }

        $dailyProductionLabels = array_values(array_map(fn($item) => $item['label'], $dailyProduction));
        $dailyProductionData = array_values(array_map(fn($item) => $item['total_quantity'], $dailyProduction));

        $monthlyProduction = [];
        for ($months = 5; $months >= 0; $months--) {
            $date = $today->copy()->subMonths($months);
            $monthlyProduction[$date->format('Y-m')] = [
                'label' => $date->format('M/Y'),
                'total_quantity' => 0,
            ];
        }

        $monthlyRecords = $model
            ->selectRaw("DATE_FORMAT(produ_data, '%Y-%m') as month, SUM(produ_quantidade) as total_quantity")
            ->whereBetween('produ_data', [$last6Months, $today])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($monthlyRecords as $record) {
            if (isset($monthlyProduction[$record->month])) {
                $monthlyProduction[$record->month]['total_quantity'] = (int) $record->total_quantity;
            }
        }

        $monthlyProductionLabels = array_values(array_map(fn($item) => $item['label'], $monthlyProduction));
        $monthlyProductionData = array_values(array_map(fn($item) => $item['total_quantity'], $monthlyProduction));

        $productStats = $model
            ->selectRaw('pro_producoes.prod_id, cad_produtos.prod_nome, SUM(produ_quantidade) as total_quantity, SUM(produ_tempo_gasto) as total_time')
            ->join('cad_produtos', 'cad_produtos.prod_id', '=', 'pro_producoes.prod_id')
            ->groupBy('pro_producoes.prod_id', 'cad_produtos.prod_nome')
            ->orderByDesc('total_quantity')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                $item->avg_seconds = $item->total_quantity ? round($item->total_time / $item->total_quantity) : 0;
                return $item;
            });

        $hourlyProduction = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $hourlyProduction[$hour] = [
                'label' => sprintf('%02d:00', $hour),
                'total_quantity' => 0,
            ];
        }

        $hourlyRecords = $model
            ->selectRaw('HOUR(produ_hora) as hour, SUM(produ_quantidade) as total_quantity')
            ->whereNotNull('produ_hora')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        foreach ($hourlyRecords as $record) {
            $hourlyProduction[$record->hour]['total_quantity'] = (int) $record->total_quantity;
        }

        $hourlyProductionLabels = array_values(array_map(fn($item) => $item['label'], $hourlyProduction));
        $hourlyProductionData = array_values(array_map(fn($item) => $item['total_quantity'], $hourlyProduction));

        $efficiencyRanking = $model
            ->selectRaw('pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(produ_quantidade) as total_quantity, SUM(produ_tempo_gasto) as total_time')
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->whereNotNull('produ_tempo_gasto')
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->get()
            ->map(function ($item) {
                $item->avg_seconds = $item->total_quantity ? round($item->total_time / $item->total_quantity) : 0;
                $item->production_per_hour = $item->total_time ? round($item->total_quantity / ($item->total_time / 3600), 2) : 0;
                return $item;
            })
            ->sortBy('avg_seconds')
            ->values()
            ->take(10);

        $alerts = [];
        if ($totalToday === 0) {
            $alerts[] = 'Nenhuma produção registrada hoje.';
        }

        if ($employeesBelowAverage->count()) {
            $alerts[] = 'Funcionários abaixo da média de produção hoje: '.implode(', ', $employeesBelowAverage->pluck('funcionario_nome')->toArray());
        }

        if ($totalToday < max(0, array_sum($dailyProductionData) / 7)) {
            $alerts[] = 'Produção de hoje está abaixo da média dos últimos 7 dias.';
        }

        return view($this->getRota().'.dashboard', array_merge($this->getAttributesView(), [
            'totalToday' => $totalToday,
            'todayAveragePerHour' => $todayAveragePerHour,
            'topEmployeesToday' => $topEmployeesToday,
            'employeesBelowAverage' => $employeesBelowAverage,
            'dailyProductionLabels' => $dailyProductionLabels,
            'dailyProductionData' => $dailyProductionData,
            'monthlyProductionLabels' => $monthlyProductionLabels,
            'monthlyProductionData' => $monthlyProductionData,
            'productStats' => $productStats,
            'hourlyProductionLabels' => $hourlyProductionLabels,
            'hourlyProductionData' => $hourlyProductionData,
            'efficiencyRanking' => $efficiencyRanking,
            'totalMonth' => $totalMonth,
            'averageDailyMonth' => $averageDailyMonth,
            'daysElapsed' => $daysElapsed,
            'daysRemaining' => $daysRemaining,
            'projectedMonth' => $projectedMonth,
            'monthProgress' => $monthProgress,
            'alerts' => $alerts,
            'model' => $model,
        ]));
    }

    protected function processesDataStore(array $data = [])
    {
        if (!empty($data['produ_tempo_gasto'])) {
            $data['produ_tempo_gasto'] = $this->tempoParaSegundos($data['produ_tempo_gasto']);
        }

        return $data;
    }

    protected function processesDataUpdate(array $data = [])
    {
        if (!empty($data['produ_tempo_gasto'])) {
            $data['produ_tempo_gasto'] = $this->tempoParaSegundos($data['produ_tempo_gasto']);
        }

        return $data;
    }
    
}
