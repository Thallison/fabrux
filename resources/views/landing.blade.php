@extends('layouts.landing')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-400 text-slate-900">
    <header class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 flex flex-col items-center">
        <div class="mb-4">@include('components.logo')</div>
        <h1 class="brand text-5xl font-extrabold tracking-tight drop-shadow-lg text-white">Fabrux</h1>
        <p class="brand text-lg md:text-xl mt-2 mb-4 text-blue-100 font-medium text-center max-w-2xl">Gestão de Produção Modular, Orçamentos, Relatórios e Customização sob medida para sua empresa crescer com tecnologia.</p>
        <nav class="flex flex-wrap items-center gap-2 text-sm mt-4">
            <a href="#contato" class="rounded-xl bg-yellow-400 px-4 py-2 font-semibold text-blue-900 hover:bg-yellow-500">Solicite uma demonstração</a>
            <a href="/login" class="rounded-xl border border-white/30 bg-white/10 px-4 py-2 font-semibold text-white hover:bg-white/20">Entrar</a>
        </nav>
        <!-- ...existing code... -->
        
        <script>
        // WhatsApp integration
        document.getElementById('whatsappBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('demoForm');
            const nome = form.nome.value;
            const email = form.email.value;
            const whatsapp = form.whatsapp.value;
            const mensagem = form.mensagem.value;
            let text = `Olá! Gostaria de solicitar uma demonstração do Fabrux.%0A`;
            text += `Nome: ${nome}%0A`;
            text += `E-mail: ${email}%0A`;
            if (whatsapp) text += `WhatsApp: ${whatsapp}%0A`;
            if (mensagem) text += `Mensagem: ${mensagem}%0A`;
            const url = `https://wa.me/SEUNUMERO?text=${text}`;
            window.open(url, '_blank');
        });
        // Sucesso fake para envio por e-mail
        document.getElementById('demoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('successMsg').classList.remove('hidden');
            this.reset();
        });
        </script>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 pb-12 sm:px-6">
        <section class="reveal grid grid-cols-1 gap-6 py-4 lg:grid-cols-[1.15fr_.85fr] lg:items-center lg:py-8">
            <div>
                <span class="inline-flex items-center rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-cyan-700">Solução SaaS Multiempresa</span>
                <h2 class="brand mt-4 text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">Controle produção, orçamentos e relatórios em um só lugar.</h2>
                <p class="mt-4 max-w-2xl text-base leading-7 text-blue-100 sm:text-lg">O Fabrux centraliza produção, funcionários, módulos, relatórios e customizações para cada cliente, com subdomínios exclusivos e segurança total.</p>

                <div class="mt-4 inline-flex items-center rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-white">
                    Modularidade • Multiempresa • Customização sob demanda
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#contato" class="hero-highlight rounded-xl px-5 py-3 text-sm font-semibold text-white bg-yellow-400 hover:bg-yellow-500 hover:-translate-y-0.5">Quero uma demonstração</a>
                    <a href="/login" class="rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/20">Entrar</a>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3 sm:max-w-xl sm:grid-cols-3">
                    <div class="landing-card metric-card rounded-2xl bg-white/80 p-4 text-center">
                        <p class="text-2xl font-bold text-blue-900">+100</p>
                        <p class="mt-1 text-xs text-blue-700">Funcionários monitorados</p>
                    </div>
                    <div class="landing-card metric-card rounded-2xl bg-white/80 p-4 text-center">
                        <p class="text-2xl font-bold text-blue-900">Dashboards</p>
                        <p class="mt-1 text-xs text-blue-700">Relatórios em tempo real</p>
                    </div>
                    <div class="landing-card metric-card rounded-2xl bg-white/80 p-4 text-center">
                        <p class="text-2xl font-bold text-blue-900">Orçamentos</p>
                        <p class="mt-1 text-xs text-blue-700">Pedidos e propostas rápidas</p>
                    </div>
                </div>
            </div>

            <div class="reveal landing-card rounded-3xl border border-slate-200 bg-white/90 p-5 shadow-xl shadow-slate-900/10 backdrop-blur-sm sm:p-7" style="animation-delay: 100ms;">
                <h2 class="brand text-2xl font-bold text-blue-900">Destaques do Fabrux</h2>
                <ul class="mt-5 space-y-2 text-sm text-blue-900">
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Controle de produção por funcionário</li>
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Orçamentos e pedidos personalizados</li>
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Relatórios e dashboards em tempo real</li>
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Segurança avançada e controle de acesso</li>
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Multiempresa e multiusuário com subdomínios</li>
                    <li class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">Customização de regras e módulos sob demanda</li>
                </ul>
            </div>
        </section>

        <section class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-3">
            <article class="landing-card rounded-3xl bg-white/90 p-5 sm:p-6">
                <h3 class="brand text-xl font-bold text-blue-900">Gestão de produção eficiente</h3>
                <p class="mt-2 text-sm text-blue-700">Acompanhe produção, funcionários e resultados em tempo real, com dashboards claros e objetivos.</p>
            </article>
            <article class="landing-card rounded-3xl bg-white/90 p-5 sm:p-6">
                <h3 class="brand text-xl font-bold text-blue-900">Orçamentos e pedidos rápidos</h3>
                <p class="mt-2 text-sm text-blue-700">Gere orçamentos, propostas e pedidos personalizados para cada cliente, com histórico e controle.</p>
            </article>
            <article class="landing-card rounded-3xl bg-white/90 p-5 sm:p-6">
                <h3 class="brand text-xl font-bold text-blue-900">Customização sob demanda</h3>
                <p class="mt-2 text-sm text-blue-700">Implemente novas regras, módulos e integrações conforme a necessidade de cada empresa.</p>
            </article>
        </section>

        <section class="landing-card mt-10 rounded-3xl border border-blue-200 bg-white/90 p-6 sm:p-8">
            <div class="max-w-3xl">
                <h2 class="brand text-3xl font-bold text-blue-900">Tudo o que sua empresa precisa para crescer com tecnologia</h2>
                <p class="mt-2 text-sm text-blue-700">Uma base pronta para operar, personalizar e escalar sua produção.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Cadastro completo de funcionários, setores e módulos</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Orçamentos, pedidos e propostas integrados</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Dashboards e relatórios personalizáveis</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Controle de acesso e permissões avançadas</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Multiempresa e multiusuário</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Customização de regras e módulos</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Integração com sistemas externos</div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">Suporte técnico especializado</div>
            </div>
        </section>

        <section class="mt-10 grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="landing-card rounded-3xl border border-blue-200 bg-white/90 p-6 sm:p-8">
                <h2 class="brand text-3xl font-bold text-blue-900">Perguntas frequentes</h2>
                <div class="mt-5 space-y-3">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="font-semibold text-blue-900">Preciso instalar alguma coisa?</p>
                        <p class="mt-1 text-sm text-blue-700">Não. O sistema é online e pode ser usado pelo navegador no computador ou no celular.</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="font-semibold text-blue-900">Posso customizar regras para minha empresa?</p>
                        <p class="mt-1 text-sm text-blue-700">Sim. O Fabrux permite customizações de módulos, regras e integrações sob demanda.</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="font-semibold text-blue-900">Funciona para várias empresas ou filiais?</p>
                        <p class="mt-1 text-sm text-blue-700">Sim. O sistema suporta multiempresa e multiusuário, cada um com seu subdomínio exclusivo.</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="font-semibold text-blue-900">Consigo acompanhar produção em tempo real?</p>
                        <p class="mt-1 text-sm text-blue-700">Sim. Dashboards e relatórios mostram produção, funcionários e resultados em tempo real.</p>
                    </div>
                </div>
            </div>

            <div class="landing-card rounded-3xl border border-emerald-200 bg-emerald-50 p-6 sm:p-8">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Teste sem compromisso</p>
                <h2 class="brand mt-2 text-3xl font-bold text-blue-900">Solicite uma demonstração e veja na prática.</h2>
                <p class="mt-3 text-sm text-blue-700">Experimente o Fabrux, valide os fluxos e veja como podemos personalizar para sua empresa.</p>

                <ul class="mt-5 space-y-2 text-sm text-blue-900">
                    <li class="rounded-xl border border-emerald-200 bg-white px-4 py-3">Demonstração gratuita e personalizada</li>
                    <li class="rounded-xl border border-emerald-200 bg-white px-4 py-3">Customização sob demanda</li>
                    <li class="rounded-xl border border-emerald-200 bg-white px-4 py-3">Suporte técnico especializado</li>
                </ul>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="#contato" class="rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">Solicitar demonstração</a>
                </div>
            </div>
        </section>

        <section class="hero-highlight mt-10 rounded-3xl px-6 py-8 text-white sm:px-8 bg-blue-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-cyan-200">Comece agora</p>
                    <h2 class="brand mt-2 text-3xl font-bold">Solicite uma demonstração e veja sua produção mais organizada já na primeira semana.</h2>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="#contato" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-blue-900 hover:bg-slate-100">Solicitar demonstração</a>
                </div>
            </div>
        </section>
        <!-- Seção de destaque para conversão: Solicite uma Demonstração -->
        <section id="contato" class="mt-24 flex flex-col items-center justify-center">
            <div class="landing-card max-w-2xl w-full rounded-3xl border-2 border-yellow-400 bg-white/95 p-10 shadow-2xl shadow-yellow-200/40">
                <h2 class="brand text-3xl font-extrabold text-blue-900 mb-2 text-center">Pronto para transformar sua gestão?</h2>
                <p class="text-blue-700 mb-6 text-lg text-center">Solicite uma demonstração gratuita e descubra como o Fabrux pode revolucionar o controle de produção, orçamentos e relatórios da sua empresa.<br><span class="font-semibold text-yellow-500">Sem compromisso!</span></p>
                <form id="demoForm" class="flex flex-col gap-4" method="POST" action="mailto:seu@email.com">
                    <div class="flex flex-col md:flex-row gap-4">
                        <input type="text" name="nome" placeholder="Seu nome" required class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-blue-900 bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <input type="email" name="email" placeholder="Seu e-mail" required class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-blue-900 bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <input type="text" name="whatsapp" placeholder="WhatsApp (opcional)" class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-blue-900 bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <textarea name="mensagem" rows="2" placeholder="Conte um pouco sobre sua necessidade..." class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-blue-900 bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 mt-2">
                        <button type="submit" class="flex-1 rounded-xl bg-yellow-400 px-4 py-3 font-bold text-blue-900 text-lg hover:bg-yellow-500 transition">Enviar por e-mail</button>
                        <a id="whatsappBtn" href="#" target="_blank" class="flex-1 rounded-xl bg-green-500 px-4 py-3 font-bold text-white text-lg hover:bg-green-600 text-center transition">Enviar pelo WhatsApp</a>
                    </div>
                </form>
                <div id="successMsg" class="hidden mt-4 rounded-xl bg-green-100 px-4 py-2 text-green-800 text-center font-semibold">Solicitação enviada! Em breve entraremos em contato.</div>
            </div>
        </section>
    </main>

    <footer class="text-white/80 text-sm mt-auto mb-4">
        &copy; {{ date('Y') }} Fabrux. Todos os direitos reservados.
    </footer>
</div>
@endsection
