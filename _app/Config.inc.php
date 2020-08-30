<?php
define('HOME', 'http://localhost/manutencao_lira/hospedagem');
define('THEMES', 'manutencaolira');
define('INCLUDE_PATH', HOME . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEMES);
define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEMES);

define('MAILUSER', 'suporte@manutencaolira.com.br');
define('MAILPASS', 'unumestnecessarium');
define('MAILPORT', '587');
define('MAILHOST', 'mail.manutencaolira.com.br');

define('WS_SUCCESS', 'trigger-success');
define('WS_INFOR', 'trigger-infor');
define('WS_ALERT', 'trigger-alert');
define('WS_ERROR', 'trigger-error');

$pg_google_author = '144619932';
$pg_name = 'MANUTENÇÃO LIRA | Suporte Técnico em Tecnologia';
$pg_ceo = 'Cristovão Lira Braga';
$pg_site = 'ML - Manutenção Lira';
$pg_sitekit = INCLUDE_PATH . "_img/sitekit";
$pg_fb_app = '334510347391174';
$pg_fb_author = 'ManutencaoLira';
$pg_fb_page = 'Manutencaoliraemtecnologia';
$pg_twitter = '@LiraTecnico';
$pg_domain = 'wwww.manutencaolira.com.br';

function __autoload($Class) {

    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . ".class.php") && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . ".class.php")):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . ".class.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("<i class=\"icon-error\"></i>Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

function WSErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));

    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}</p>";

    if ($ErrDie):
        die;
    endif;
}

function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));

    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na linha: {$ErrLine} ::</b> {$ErrMsg}</p>";
    echo "<small>{$ErrFile}</small>";
    echo "</p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');

$getUrl = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setUrl = (empty($getUrl) ? 'index' : $getUrl);
$Url = explode("/", $setUrl);

switch ($Url[0]):
    case'index':
        $pg_title = $pg_name;
        $pg_desc = 'Manutenção Lira é uma empresa de suporte técnico em informática voltado para usuários domésticos e empresas de pequeno porte.
                    Nosso Core Bussiness é baseado no relacionamento direto com o cliente ou empresa, propocionando ao mesmo serviços técnicos e acessórios
                    que podemos oferecer dentro da nossa área, procurando na medida do impossível, adaptar serviços existentes para as suas necessidades, promovendo
                    sempre a sua satisfação.';
        $pg_image = $pg_sitekit . '/index.jpg';
        $pg_url = HOME;
        break;
    
    case'empresa':
        $pg_title = 'MANUTENÇÃO LIRA | Empresa';
        $pg_desc = 'Manutenção Lira é uma empresa que está a mais de 7 anos no mercado de informática, aperfeiçoando os serviços e oferecendo a mesma, tentando na medida do impossível 
                    adaptar os serviços de informática e suas tecnologias para cada perfil de seus clientes.';
        $pg_image = $pg_sitekit . '/empresa.jpg';
        $pg_url = HOME. '/empresa';
        break;
    
    case'servicos':
        $pg_title = 'MANUTENÇÃO LIRA | Serviços';
        $pg_desc = 'Trabalhamos com o suporte técnico em computadores domésticos (Pcs), desde de sua formatação até a montagem na residência com instalação de periféricos e aterramento.
                    O suporte técnico em Técnologia em notebooks, netebooks e ultrabooks, desde de sua formatação até o reparo e update de peças e criação e manutenção em sites, blogs e 
                    portfólios online.';
        $pg_image = $pg_sitekit . '/serviços.jpg';
        $pg_url = HOME . '/serviços';
        break;
    
    case'servicos-desktops':
        $pg_title = 'MANUTENÇÃO LIRA | Serviços Desktops';
        $pg_desc = 'Trabalhamos com o suporte técnico em computadores domésticos (Pcs), desde de sua formatação até a montagem na residência com instalação de periféricos e aterramento.';
        $pg_image = $pg_sitekit . '/serviços-desktops.jpg';
        $pg_url = HOME . '/serviços';
        break;
    
    case'servicos-notebooks':
        $pg_title = 'MANUTENÇÃO LIRA | Serviços Notebooks';
        $pg_desc = 'O suporte técnico em Técnologia em notebooks, netebooks e ultrabooks, desde de sua formatação até o reparo e update de peças.';
        $pg_image = $pg_sitekit . '/serviços-notebooks.jpg';
        $pg_url = HOME . '/serviços';
        break;
    
    case'servicos-websites':
        $pg_title = 'MANUTENÇÃO LIRA | Serviços Websites';
        $pg_desc = 'Criação e manutenção em sites.';
        $pg_image = $pg_sitekit . '/serviços-websites.jpg';
        $pg_url = HOME . '/serviços';
        break;
    
    case'blog':
        $pg_title = 'MANUTENÇÃO LIRA | Blog';
        $pg_desc = 'Dicas e conteúdos separados para você que quer entender mais sobre o mundo da tecnologia.';
        $pg_image = $pg_sitekit . '/blog.jpg';
        $pg_url = HOME . '/blog';
        break;
    
    case'contato':
        $pg_title = 'MANUTENÇÃO LIRA | Fale Conosco';
        $pg_desc = 'Entre em contato conosco pelos meios disponibilizados ou venha até nós e desfrute de nossos serviços.';
        $pg_image = $pg_sitekit . '/fale_conosco.jpg';
        $pg_url = HOME . '/fale_conosco';
        break;
    
    case'bookonline':
        $pg_title = 'MANUTENÇÃO LIRA | Book Online';
        $pg_desc = 'Tenha acesso ao histórico de serviços realizados em seu equipamento na manutenção
                    lira, configurações que ele possui e outros serviços disponibilizados na plataforma.';
        $pg_image = $pg_sitekit . '/book_online.jpg';
        $pg_url = HOME . '/book_online';
        break;
    
    default:
        $pg_title = 'Erro 404! Página não encontrada';
        $pg_desc = 'A página <b>' . $setUrl . '</b> que você tentou acessar está indisponível ou não existe, mas não
                    saia ainda. Temos algumas dicas para te ajudar com a pesquisa!';
        $pg_image = $pg_sitekit . '/404.jpg';
        $pg_url = HOME . '/404';
        break;
endswitch;