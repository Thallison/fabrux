App._flgGrid = function (value) {
    var ativo = '<span style="color:#dc3545;font-weight: bold;">Não</span>';
    if(value == 1){
        ativo = '<span  style="color:#28a745;font-weight: bold;">Sim</span>';
    }
    return [
        ativo
    ].join("");
}

App.tipoMensagem = function(value, row, index)
{
    let msg;
    switch (value) {
        case 1:
            msg = '<span class="badge bg-success">Ativo</span>';
            break;
        case 0:
            msg = '<span class="badge bg-danger">Inativo</span>';
            break;
        default:
            msg = '<span class="badge"> </span>';
            break;
    }

    return msg;
}

App.tipoPessoaMensagem = function(value) {
    switch (value) {
        case 'F':
            return '<span class="badge bg-info">Pessoa Fisica</span>';
        case 'J':
            return '<span class="badge bg-warning text-dark">Pessoa Juridica</span>';
        default:
            return value || '-';
    }
}

App.segundosParaTime = function(segundos) {
    if(segundos == null)
        return '-';

    const horas = Math.floor(segundos / 3600);
    const minutos = Math.floor((segundos % 3600) / 60);

    return String(horas).padStart(2, '0') + ':' + 
        String(minutos).padStart(2, '0');
}

App.maskCpf = function(value) {
    value = value.replace(/\D/g, '').slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return value;
}

App.maskCnpj = function(value) {
    value = value.replace(/\D/g, '').slice(0, 14);
    value = value.replace(/(\d{2})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1/$2');
    value = value.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
    return value;
}

App.maskCep = function(value) {
    value = value.replace(/\D/g, '').slice(0, 8);
    value = value.replace(/(\d{5})(\d{1,3})$/, '$1-$2');
    return value;
}

App.maskTelefone = function(value) {
    value = value.replace(/\D/g, '').slice(0, 11);

    if (value.length > 10) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d{1,4})$/, '$1-$2');

        return value;
    }

    value = value.replace(/(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d{4})(\d{1,4})$/, '$1-$2');

    return value;
}

App.getTipoContatoCategoria = function(tipoContato) {
    const tipo = String(tipoContato || '').toLowerCase();

    if (tipo.includes('whatsapp') || tipo.includes('celular')) {
        return 'celular';
    }

    if (tipo.includes('telefone')) {
        return 'telefone';
    }

    if (tipo.includes('mail')) {
        return 'email';
    }

    return 'texto';
}

App.maskByContactType = function(value, tipoContato) {
    const categoria = App.getTipoContatoCategoria(tipoContato);

    if (categoria === 'telefone' || categoria === 'celular') {
        return App.maskTelefone(value);
    }

    if (categoria === 'email') {
        return String(value || '').trim().toLowerCase();
    }

    return value;
}

App.getContactInputType = function(tipoContato) {
    return App.getTipoContatoCategoria(tipoContato) === 'email' ? 'email' : 'text';
}

App.isValidEmail = function(value) {
    const email = String(value || '').trim();

    if (!email) {
        return false;
    }

    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

App.isValidCpf = function(value) {
    const cpf = String(value || '').replace(/\D/g, '');

    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }

    for (let tamanho = 9; tamanho < 11; tamanho++) {
        let soma = 0;

        for (let indice = 0; indice < tamanho; indice++) {
            soma += Number(cpf.charAt(indice)) * ((tamanho + 1) - indice);
        }

        const digito = ((10 * soma) % 11) % 10;

        if (Number(cpf.charAt(tamanho)) !== digito) {
            return false;
        }
    }

    return true;
}

App.isValidCnpj = function(value) {
    const cnpj = String(value || '').replace(/\D/g, '');

    if (cnpj.length !== 14 || /^(\d)\1{13}$/.test(cnpj)) {
        return false;
    }

    const calcularDigito = function(base, pesos) {
        const soma = base.split('').reduce((total, numero, indice) => {
            return total + (Number(numero) * pesos[indice]);
        }, 0);

        const resto = soma % 11;

        return resto < 2 ? 0 : 11 - resto;
    };

    const primeiroDigito = calcularDigito(cnpj.slice(0, 12), [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
    const segundoDigito = calcularDigito(cnpj.slice(0, 13), [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);

    return Number(cnpj.charAt(12)) === primeiroDigito && Number(cnpj.charAt(13)) === segundoDigito;
}

App.toggleLoading = function(element, loading, text = 'Carregando...') {
    if (!element) {
        return;
    }

    if (loading) {
        element.classList.remove('d-none');
        element.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>${text}`;
        return;
    }

    element.classList.add('d-none');
    element.innerHTML = '';
}

App.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
}

App.buscarEnderecoPorCep = async function(cep, options = {}) {
    try {
        const cepLimpo = String(cep || '').replace(/\D/g, '');

        if (cepLimpo.length !== 8) {
            if (options.onError) {
                options.onError('CEP deve ter 8 dígitos');
            }
            return null;
        }

        // Mostrar loader
        if (options.loaderSelector) {
            const loader = document.querySelector(options.loaderSelector);
            if (loader) {
                loader.style.display = 'inline-block';
            }
        }

        const response = await fetch(`/api/cep/buscar?cep=${cepLimpo}`);
        const result = await response.json();

        // Esconder loader
        if (options.loaderSelector) {
            const loader = document.querySelector(options.loaderSelector);
            if (loader) {
                loader.style.display = 'none';
            }
        }

        if (!result.success) {
            if (options.onError) {
                options.onError(result.message || 'CEP não encontrado');
            }
            return null;
        }

        if (options.onSuccess) {
            options.onSuccess(result.data);
        }

        return result.data;
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);

        // Esconder loader em caso de erro
        if (options.loaderSelector) {
            const loader = document.querySelector(options.loaderSelector);
            if (loader) {
                loader.style.display = 'none';
            }
        }

        if (options.onError) {
            options.onError('Erro ao buscar CEP. Tente novamente.');
        }

        return null;
    }
}

App.preencherEnderecoPorCep = function(cep, config = {}) {
    const defaultConfig = {
        cepSelector: '#cli_cep',
        loaderSelector: '#cepLoader',
        logradouroSelector: '#cli_logradouro',
        bairroSelector: '#cli_bairro',
        cidadeSelector: '#cli_cidade',
        estadoSelector: '#cli_estado',
    };

    const finalConfig = Object.assign(defaultConfig, config);

    App.buscarEnderecoPorCep(cep, {
        loaderSelector: finalConfig.loaderSelector,
        onSuccess: function(endereco) {
            const logradouro = document.querySelector(finalConfig.logradouroSelector);
            const bairro = document.querySelector(finalConfig.bairroSelector);
            const cidade = document.querySelector(finalConfig.cidadeSelector);
            const estado = document.querySelector(finalConfig.estadoSelector);

            if (logradouro && endereco.logradouro) {
                logradouro.value = endereco.logradouro;
                logradouro.classList.remove('is-invalid');
            }

            if (bairro && endereco.bairro) {
                bairro.value = endereco.bairro;
                bairro.classList.remove('is-invalid');
            }

            if (cidade && endereco.localidade) {
                cidade.value = endereco.localidade;
                cidade.classList.remove('is-invalid');
            }

            if (estado && endereco.uf) {
                estado.value = endereco.uf;
                estado.classList.remove('is-invalid');
            }

            if (config.onSuccess) {
                config.onSuccess(endereco);
            }
        },
        onError: function(mensagem) {
            const cepInput = document.querySelector(finalConfig.cepSelector);

            if (cepInput) {
                cepInput.classList.add('is-invalid');
            }

            if (config.onError) {
                config.onError(mensagem);
            } else {
                console.warn('CEP não encontrado:', mensagem);
            }
        },
    });
}

App.defaultMessageDuration = 4000;