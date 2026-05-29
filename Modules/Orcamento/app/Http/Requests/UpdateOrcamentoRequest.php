<?php

namespace Modules\Orcamento\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrcamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_id' => ['required', 'exists:cad_clientes,cli_id'],
            'orc_data_emissao' => ['required', 'date'],
            'orc_data_validade' => ['required', 'date', 'after_or_equal:orc_data_emissao'],
            'orc_desconto_percentual' => ['nullable', 'regex:/^\d{1,3}(,\d{1,2}|\.\d{1,2})?$/'],
            'orc_observacoes' => ['nullable', 'string', 'max:2000'],
            'itens' => ['required', 'array', 'min:1'],
            'itens.*.prod_id' => ['required', 'exists:cad_produtos,prod_id'],
            'itens.*.oci_quantidade' => ['required', 'regex:/^\d+(,\d{1,3}|\.\d{1,3})?$/'],
            'itens.*.oci_valor_unitario' => ['required', 'regex:/^(\d{1,3}(\.\d{3})+|\d+)(,\d{1,2}|\.\d{1,2})?$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'itens.required' => 'Adicione ao menos um item ao orcamento.',
            'itens.min' => 'Adicione ao menos um item ao orcamento.',
            'orc_data_validade.after_or_equal' => 'A validade deve ser maior ou igual a data de criacao.',
        ];
    }
}
