<?php

namespace Modules\Orcamento\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCabecalhoOrcamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orc_cab_nome' => ['nullable', 'string', 'max:255'],
            'orc_cab_documento' => ['nullable', 'string', 'max:30'],
            'orc_cab_endereco' => ['nullable', 'string', 'max:255'],
            'orc_cab_telefone' => ['nullable', 'string', 'max:30'],
            'orc_cab_email' => ['nullable', 'email', 'max:255'],
            'orc_cab_site' => ['nullable', 'string', 'max:255'],
            'orc_cab_rodape' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
