<?php

namespace Modules\Base\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CepService
{
    /**
     * URL base da API ViaCEP
     *
     * @var string
     */
    private const VIACEP_API_URL = 'https://viacep.com.br/ws';

    /**
     * Buscar endereço pelo CEP
     */
    public static function buscarEnderecoPorCep(string $cep): ?array
    {
        try {
            // Remover formatação do CEP
            $cepLimpo = preg_replace('/\D/', '', $cep);

            // Validar se o CEP tem 8 dígitos
            if (strlen($cepLimpo) !== 8) {
                return null;
            }

            // Formatar CEP para a API (XXXXX-XXX)
            $cepFormatado = substr($cepLimpo, 0, 5).'-'.substr($cepLimpo, 5);

            // Fazer requisição para a API
            $response = Http::timeout(10)->get(
                self::VIACEP_API_URL.'/'.$cepFormatado.'/json'
            );

            // Validar resposta
            if (! $response->successful()) {
                return null;
            }

            $dados = $response->json();

            // ViaCEP retorna "erro" => true se CEP não for encontrado
            if (isset($dados['erro']) && $dados['erro'] === true) {
                return null;
            }

            // Retornar dados formatados
            return [
                'cep' => $dados['cep'] ?? null,
                'logradouro' => $dados['logradouro'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'localidade' => $dados['localidade'] ?? null, // Cidade
                'uf' => $dados['uf'] ?? null, // Estado
                'ibge' => $dados['ibge'] ?? null,
                'gia' => $dados['gia'] ?? null,
                'ddd' => $dados['ddd'] ?? null,
                'siafi' => $dados['siafi'] ?? null,
            ];
        } catch (\Exception $e) {
            // Log do erro
            Log::error('Erro ao buscar CEP: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Validar se o CEP existe
     */
    public static function validarCep(string $cep): bool
    {
        return self::buscarEnderecoPorCep($cep) !== null;
    }
}
