<article class="bg-black border-shadow main_hero" id="particles-js">
    <header>
        <h1>SEJA BEM VINDO(a)!</h1>
        <p>Ao Seu <span class="type"></span></p>

        <div class="hero_buttons">
            <h2><a href="<?= HOME; ?>/servicos" title="SERVIÇOS | Manutenção Lira" class="cursor radius-five hero_btn">Saiba Mais</a></h2>
            <h2><a href="<?= HOME; ?>/contato" title="CONTATO | Manutenção Lira" class="cursor radius-five hero_btn_out">Fale Conosco</a></h2>
        </div>

        <a href="#servicos" class="cursor hero_icon j_hero"><i class="icon-chevron-down"></i></a>
    </header>
</article>

<section class="container text-shadow main_serv servicos">
    <header class="title-header">
        <h1 class="font-title">Nossos Serviços</h1>
        <p class="tagline">O que fazemos de melhor para você que é nosso cliente</p>
    </header>

    <article class="main_serv_item">
        <span class="bg-black radius-circle"><i class="icon-desktop"></i></span>

        <div class="main_serv_content">
            <h2>Suporte Técnico em DeskTops</h2>
            <p>Fornecemos o suporte técnico em computadores de mesa. Desde a instalação do Sistema Operacional(Formatação)
                até a substituição ou reparo de peças(Hardware). Também instalamos o computador em sua residência, cuidando
                até da parte elétrica.</p>
        </div>

        <a href="<?= HOME; ?>/servicos-desktops" title="SERVIÇOS EM DESKTOPS | Manutenção Lira" class="btn btn-yellow radius-five">Saiba Mais</a>
    </article>

    <article class="main_serv_item">
        <span class="bg-black radius-circle"><i class="icon-laptop"></i></span>

        <div class="main_serv_content">
            <h2>Suporte Técnico em Notebooks</h2>
            <p>Fornecemos o suporte técnico em notebooks, netebooks e ultrabooks em suas diferentes marcas. Desde sua formatação
                (Sistema Operacional) com instalação de utilitários e aplicativos para a usabilidade do cliente até o reparo ou 
                substituição de peças(Hardware).</p>
        </div>

        <a href="<?= HOME; ?>/servicos-notebooks" title="SERVIÇOS EM NOTEBOOKS | Manutenção Lira" class="btn btn-yellow radius-five">Saiba Mais</a>
    </article>

    <article class="main_serv_item">
        <span class="bg-black radius-circle"><i class="icon-file-code"></i></span>

        <div class="main_serv_content">
            <h2>Criação e Manutenção em WebSites</h2>
            <p>Desenvolvemos sites, blogs e portfolio online utilizando as melhores tecnologias como linguagens HTML5, CSS3, jQuery e PHP;
                Totalmente semântico e com ótima otimização para o acesso nos motores de busca, seguindo os padrões exigidos pela web(W3C).</p>
        </div>

        <a href="<?= HOME; ?>/servicos-websites" title="SERVIÇOS EM WEBSITES | Manutenção Lira" class="btn btn-yellow radius-five">Saiba Mais</a>
    </article>
</section>

<article class="bg-black" id="contato">
    <div class="main_newslleter">
        <header class="title-header">
            <h1 class="font-title">Newslleter</h1>
            <p class="tagline">Receba nossas promoções, dicas e conteúdos diretamente no seu email!</p>
        </header>

        <?php
        $Contato = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if ($Contato && $Contato['SendFormNews']):
            unset($Contato['SendFormNews']);

            $Contato['Assunto'] = 'Mensagem via Site!';
            $Contato['Mensagem'] = 'Mensagem via Site!';
            $Contato['DestinoNome'] = 'Cristovão L. Braga - MANUTENÇÃO LIRA';
            $Contato['DestinoEmail'] = 'suporte@manutencaolira.com.br';

            $SendMail = new Email;
            $SendMail->Enviar($Contato);

            if ($SendMail->getError()):
                WSErro($SendMail->getError()[0], $SendMail->getError()[1]);
            endif;
        endif;
        ?>

        <form method="post" name="FormNewslleter" action="#contato" autocomplete="off">
            <input type="text" class="radius-cylinder" title="Informe seu nome completo!" name="RemetenteNome" placeholder="Informe seu nome" required/>
            <input type="email" class="radius-cylinder" title="Informe seu nome email válido!" name="RemetenteEmail" placeholder="Informe seu email" required/>

            <input type="submit" class="radius-cylinder" title="Enviar informações!" name="SendFormNews" value="Enviar"/>
        </form>
    </div>
</article>

<section class="container text-shadow blog_container">
    <header class="title-header">
        <h1 class="font-title">Blog</h1>
        <p class="tagline">Dicas e Conteúdos para você</p>
    </header>

    <div class="msg_info no-space-msg">
        <h2>Em Construção <i class="icon-construcao"></i></h2>
    </div>

    <section class="blog_content_destaque">
        <h1 class="line-title"><span class="title-color">Confira Nossas Atualizações:</span></h1>
    </section>

    <aside class="blog_content_aside">
        <h1 class="line-title"><span class="title-color">Artigos Mais Vistos:</span></h1>
    </aside>
</section>

<section class="bg-black">
    <h1 class="font-zero">SlideShow</h1>

    <div class="main_slide">
        <ul class="slide">
            <li class="slide_item">
                <article class="caption">
                    <h2>Quem Somos</h2>
                    <p>Manutenção Lira é uma empresa de suporte técnico em informática voltado para usuários domésticos e empresas de pequeno porte.</p>
                </article>
            </li>

            <li class="slide_item">
                <article class="caption">
                    <h2>Nossa Missão</h2>
                    <p>Atuar com padrões de excelência no serviços prestados aos nossos clientes, aperfeiçoamendo processos, habilidades humanas e profissionais.</p>
                </article>
            </li>

            <li class="slide_item">
                <article class="caption">
                    <h2>Nossa Visão</h2>
                    <p>Ser reconhecido como uma das melhores fornecedoras de prestação de serviços na área de suporte técnico em informática, superando sempre as expectativas de nossos cliente.</p>
                </article>
            </li>

            <li class="slide_item">
                <article class="caption">
                    <h2>Nossos Valores</h2>
                    <p>Compromisso com nossos clientes; Ética profissional; Profissionalismo em nossos serviços.</p>
                </article>
            </li>

            <li class="slide_item">
                <article class="caption">
                    <h2>CEO: Cristovão Lira Braga</h2>
                    <p>"Estamos aqui para fazer alguma diferança no universo, se não, porque está aqui?"</p>
                    <span>Steve Jobs</span>
                </article>
            </li>
        </ul>

        <ol class="pagination"></ol>

        <div class="cursor button_left">
            <span class="icon-button-left"></span>
        </div>

        <div class="cursor button_right">
            <span class="icon-button-right"></span>
        </div>
    </div>
</section>

<section class="text-shadow book_online_container">
    <header class="title-header">
        <h1 class="font-title">Book Online</h1>
        <p class="tagline">Área reservada para o cliente acompanhar o historico do seu equipamento</p>
    </header>

    <div class="msg_info">
        <h2>Em Construção <i class="icon-construcao"></i></h2>
    </div>

    <div class="book_box">
        <article class="box-shadow book_login">
            <h2>Área de Login</h2>

            <form method="post" name="FormBookLogin" action="">
                <input type="email" class="radius-cylinder" name="user" title="Informe seu email!" placeholder="Informe seu email" required disabled/>
                <input type="password" class="radius-cylinder" name="pass" title="Informe sua senha!" placeholder="Informe sua senha" required disabled/>

                <input type="submit" class="cursor radius-cylinder" title="Logar" name="SendFormBookLogin" value="Logar"/>
            </form>

            <a href="#!" title="Recuperar seu login!">Esqueci minha senha</a>
        </article>

        <article class="box-shadow book_register">
            <h2>Área de Registro</h2>

            <form method="post" action="">
                <input type="text" class="radius-cylinder" title="Informe seu nome!" placeholder="Informe seu nome" required disabled/>
                <input type="email" class="radius-cylinder" title="Informe seu email!" placeholder="Informe seu email" required disabled/>
                <input type="password" class="radius-cylinder" title="Informe uma senha!" placeholder="Informe uma senha" required disabled/>
                <input type="password" class="radius-cylinder" title="Confirme a senha!" placeholder="Confirme a senha" required disabled/>

                <input type="submit" class="cursor radius-cylinder" title="Fazer registro!" value="Registrar"/>
            </form>
        </article>
    </div>
</section>

<section class="bg-black section-content">
    <header class="title-header">
        <h1 class="font-title">Fale Conosco</h1>
        <p class="tagline">Entre em contato com a gente e estaremos indo até você ou venha ao nosso encontro!</p>
    </header>

    <section class="container main_footer">
        <article class="main_company">
            <div class="company_header">
                <div>
                    <img title="MANUTENÇÃO LIRA - Suporte Técnico em Tecnolgia" alt="[MANUTENÇÃO LIRA - Suporte Técnico em Tecnolgia]" src="<?= INCLUDE_PATH; ?>/_img/logo-empresa.png"/>
                    <h2>Suporte técnico em Tecnologia</h2>
                </div>
                <div class="clear"></div>
            </div>                    
            <p>Manutenção Lira é uma empresa de suporte técnico em tecnologia voltado para usuários domésticos e empresas de pequeno porte.</p>
            <p>Criada no ano 2013 por Cristovão Lira Braga com o objetivo de prestar serviços tecnologicos para o meio social.Tem como missão atuar com padrões de excelência nos serviços realizado,
                Sua visão sempre será ser reconhecido como uma das melhores fornecedoras de serviços na área de informática.</p>
        </article>

        <article class="main_localy">
            <h2 class="font-zero">Encontre nós pelo mapa</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9009661330383!2d-35.85579427645072!3d-7.020926276314439!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7ac28936505bed9%3A0xe09c8e497278a4b0!2sR.+Dr.+Silvino+Ol%C3%A1vo%2C+38%2C+Esperan%C3%A7a+-+PB%2C+58135-000!5e0!3m2!1spt-BR!2sbr!4v1548017418940" frameborder="0" allowfullscreen></iframe>
        </article>

        <article class="main_contact">
            <h2>Formas de contato</h2>
            <ul>
                <li><b>Horário de Atendimento:</b> 08:00 às 17:00 hrs</li>
                <li><b>E-mail:</b> <a href="">suporte@manutencaolira.com.br</a></li>
                <li><b>Fone (Whatsapp):</b> (83) 9 9837 - 9516</li>
                <li><b>Enderço:</b> Rua Dr. Silvino Olavo, nº 38</li>
                <li>58135000 Esperança/PB</li>
                <li>Brasil</li>
                <ul class="main_contact_redes">
                    <li><a class="radius-circle" href="" target="_blank" title="Facebook | Manutenção Lira"><i class="icon icon-facebook"></i></a></li>
                    <li><a class="radius-circle" href="" target="_blank" title="Instagram | Manutenção Lira"><i class="icon icon-instagram"></i></a></li>
                    <li><a class="radius-circle" href="" target="_blank" title="Twitter | Manutenção Lira"><i class="icon icon-twitter"></i></a></li>
                    <li><a class="radius-circle" href="" target="_blank" title="Linkedin | Manutenção Lira"><i class="icon icon-linkedin"></i></a></li>
                </ul>
            </ul>
        </article>
    </section>
</section>