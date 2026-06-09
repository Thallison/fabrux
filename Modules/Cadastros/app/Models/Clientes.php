<?php

namespace Modules\Cadastros\Models;

use Modules\Base\Models\BaseModel;
use Modules\Cadastros\Database\Factories\ClientesFactory;

class Clientes extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cad_clientes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cli_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'cli_codigo',
        'cli_nome',
        'cli_cpf_cnpj',
        'cli_email',
    ];

    protected $fillable = [
        'cli_codigo',
        'cli_nome',
        'cli_tipo',
        'cli_cpf_cnpj',
        'cli_ie',
        'cli_im',
        'cli_nao_contribuinte',
        'cli_substituto_tributario_iss',
        'cli_nao_calcula_diferimento_icms',
        'cli_apura_icms',
        'cli_aliquota_icms_diferenciada_contribuinte',
        'cli_logradouro',
        'cli_numero',
        'cli_complemento',
        'cli_bairro',
        'cli_cidade',
        'cli_estado',
        'cli_cep',
        'cli_telefone',
        'cli_celular',
        'cli_email',
        'cli_ativo',
        'created_at',
    ];

    protected $casts = [
        'cli_nao_contribuinte' => 'boolean',
        'cli_substituto_tributario_iss' => 'boolean',
        'cli_nao_calcula_diferimento_icms' => 'boolean',
        'cli_apura_icms' => 'boolean',
        'cli_aliquota_icms_diferenciada_contribuinte' => 'boolean',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cli_codigo' => "nullable|unique:cad_clientes,cli_codigo,{$this->cli_id},cli_id",
            'cli_nome' => 'required|max:255',
            'cli_tipo' => 'required|in:F,J',
            'cli_cpf_cnpj' => "required|unique:cad_clientes,cli_cpf_cnpj,{$this->cli_id},cli_id",
            'cli_ie' => 'nullable|max:20',
            'cli_im' => 'nullable|max:20',
            'cli_nao_contribuinte' => 'nullable|boolean',
            'cli_substituto_tributario_iss' => 'nullable|boolean',
            'cli_nao_calcula_diferimento_icms' => 'nullable|boolean',
            'cli_apura_icms' => 'nullable|boolean',
            'cli_aliquota_icms_diferenciada_contribuinte' => 'nullable|boolean',
            'cli_logradouro' => 'required|max:255',
            'cli_numero' => 'required|max:20',
            'cli_complemento' => 'nullable|max:255',
            'cli_bairro' => 'required|max:100',
            'cli_cidade' => 'required|max:100',
            'cli_estado' => 'required|size:2',
            'cli_cep' => 'required|max:20',
            'cli_telefone' => 'nullable|max:20',
            'cli_celular' => 'nullable|max:20',
            'cli_email' => "required|email|unique:cad_clientes,cli_email,{$this->cli_id},cli_id",
            'cli_ativo' => 'required',
        ];
    }

    /**
     * Define o nome dos atributos label para utilizar nos formularios
     *
     * @return array
     */
    public function atribbutesLabel()
    {
        return [
            'cli_codigo' => __('Código'),
            'cli_nome' => __('Nome / Razão Social'),
            'cli_tipo' => __('Tipo'),
            'cli_cpf_cnpj' => __('CPF / CNPJ'),
            'cli_ie' => __('Inscrição Estadual'),
            'cli_im' => __('Inscrição Municipal'),
            'cli_nao_contribuinte' => __('Não contribuinte ?'),
            'cli_substituto_tributario_iss' => __('Substituto tributário ISS ?'),
            'cli_nao_calcula_diferimento_icms' => __('Não calcula diferimento de ICMS ?'),
            'cli_apura_icms' => __('Apura ICMS ?'),
            'cli_aliquota_icms_diferenciada_contribuinte' => __('Alíquota de ICMS diferenciada contribuinte ?'),
            'cli_logradouro' => __('Logradouro'),
            'cli_numero' => __('Número'),
            'cli_complemento' => __('Complemento'),
            'cli_bairro' => __('Bairro'),
            'cli_cidade' => __('Cidade'),
            'cli_estado' => __('Estado'),
            'cli_cep' => __('CEP'),
            'cli_telefone' => __('Telefone'),
            'cli_celular' => __('Celular'),
            'cli_email' => __('Email'),
            'cli_ativo' => __('Status'),
            'created_at' => __('Data Criação'),
        ];
    }

    /**
     * Resolve a factory para o modelo
     */
    protected static function newFactory()
    {
        return ClientesFactory::new();
    }

    /**
     * Gera um código único para o cliente
     * Formato: CLI + número sequencial com 6 dígitos
     * Exemplo: CLI000001, CLI000002, ...
     */
    public static function gerarCodigo(): string
    {
        $ultimoCliente = self::orderBy('cli_id', 'desc')->first();
        $proximoNumero = ($ultimoCliente?->cli_id ?? 0) + 1;

        return 'CLI'.str_pad($proximoNumero, 6, '0', STR_PAD_LEFT);
    }
}
