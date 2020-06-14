<?php
ob_start();
session_start();
require ('./_app/Config.inc.php');
?>
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="https://schema.org/Article">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="index, follow"/>
        <meta name="description" content="manutenção lira, informática, manutenção, tecnologia, serviços de informática, assistência têcnica, suporte técnico em Tecnologia, suporte técnico em informática, manutenção em notebooks, web, site, desktops"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- GOOGLE SEARCH CONSOLE -->

        <meta itemprop="name" content="<?= $pg_site; ?>"/>
        <meta itemprop="description" content="<?= $pg_desc; ?>"/>
        <meta itemprop="image" content="<?= $pg_image; ?>"/>
        <meta itemprop="url" content="<?= $pg_url; ?>"/>

        <meta property="og:type" content="article"/>
        <meta property="og:title" content="<?= $pg_title; ?>"/>
        <meta property="og:description" content="<?= $pg_desc; ?>"/>
        <meta property="og:image" content="<?= $pg_image; ?>"/>
        <meta property="og:url" content="<?= $pg_url; ?>"/>
        <meta property="og:site_name" content="<?= $pg_name; ?>"/>
        <meta property="og:locale" content="pt_BR"/>

        <meta property="og:app_id" content="<?= $pg_fb_app; ?>"/>
        <meta property="article:author" content="https://www.facebook.com/<?= $pg_fb_author; ?>"/>
        <meta property="article:publisher" content="https://www.facebook.com/<?= $pg_fb_page; ?>"/>

        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:site" content="<?= $pg_twitter; ?>"/>
        <meta property="twitter:domain" content="<?= $pg_domain; ?>"/>
        <meta property="twitter:title" content="<?= $pg_title; ?>"/>
        <meta property="twitter:description" content="<?= $pg_desc; ?>"/>
        <meta property="twitter:image" content="<?= $pg_image; ?>"/>
        <meta property="twitter:url" content="<?= $pg_url; ?>"/>

        <!--[if lt IE 9]>
            <script src="_cdn/html5shiv.js"></script>
        <![endif]-->

        <title><?= $pg_title; ?></title>
        <link rel="base" href="<?= HOME; ?>"/>
        <link rel="canonical" href="<?= $pg_url; ?>"/>
        <link rel="shortcut icon" href="<?= INCLUDE_PATH; ?>/_img/favicon.ico"/>
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/_css/icons.css"/>
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/_css/reset.css"/>
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/_css/boot.css"/>
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/_css/style.css"/>
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/_css/resolution.css"/>  
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900i" rel="stylesheet"/>
    </head>
    <body>
        <!--BOTÃO DE ROLAGEM-->
        <p class="cursor text-shadow radius-five j_back backTop"><i class="icon-rolagem"></i></p>
        <!--BOTÃO DE ROLAGEM-->

        <!--BOTÃO DO WHATSAPP-->
        <a href="https://api.whatsapp.com/send?l=pt&amp;phone=5583998379516" target="_blank" class="cursor text-shadow radius-circle btn_what"><i class="icon-whatsapp"></i></a>
        <!--BOTÃO DO WHATSAPP-->

        <!--HEADER | MANUTENÇÃO LIRA-->
        <header class="main_header">
            <h1 class="main_header_logo">
                <a href="<?= HOME; ?>" class="font-zero">
                    <?= $pg_name; ?>
                    <img title="<?= $pg_name; ?>" alt="[<?= $pg_name; ?>]" src="<?= INCLUDE_PATH; ?>/_img/logo.png"/>
                </a>
            </h1>

            <span class="text-shadow cursor menu_toggle"><i class="icon-bars"></i></span>

            <ul class="text-shadow main_header_menu">
                <li><a href="<?= HOME; ?>" title="<?= $pg_name; ?>">Home</a></li>
                <li><a href="<?= HOME; ?>/empresa" title="EMPRESA | Manutenção Lira">Empresa</a></li>
                <li><a href="<?= HOME; ?>/servicos" title="SERVIÇOS | Manutenção Lira">Serviços</a></li>
                <li><a href="<?= HOME; ?>/blog" title="BLOG | Manutenção Lira">Blog</a></li>
                <li><a href="<?= HOME; ?>/contato" title="CONTATO | Manutenção Lira">Fale Conosco</a></li>
                <li><a href="<?= HOME; ?>/bookonline" title="BOOK ONLINE | Manutenção Lira">Book Online</a></li>
            </ul>

            <div class="text-shadow border-shadow sidebar">
                <div class="sidebar_logo">
                    <img title="" alt="" src="<?= INCLUDE_PATH; ?>/_img/logo_sidebar.png"/>
                </div>

                <ul class="sidebar_menu">
                    <li><a href="<?= HOME; ?>" title="<?= $pg_name; ?>"><i class="icon-home"></i>Home</a></li>
                    <li><a href="<?= HOME; ?>/empresa" title="EMPRESA | Manutenção Lira"><i class="icon-empresa"></i>Empresa</a></li>
                    <li><a href="<?= HOME; ?>/servicos" title="SERVIÇOS | Manutenção Lira"><i class="icon-servicos"></i>Serviços</a></li>
                    <li><a href="<?= HOME; ?>/blog" title="BLOG | Manutenção Lira"><i class="icon-blog"></i>Blog</a></li>
                    <li><a href="<?= HOME; ?>/contato" title="CONTATO | Manutenção Lira"><i class="icon-contato"></i>Fale Conosco</a></li>
                    <li><a href="<?= HOME; ?>/bookonline" title="BOOK ONLINE | Manutenção Lira"><i class="icon-bookonline"></i>Book Online</a></li>
                </ul>
            </div>
        </header>
        <!--HEADER | MANUTENÇÃO LIRA-->

        <!--CONTEUDO | MANUTENÇÃO LIRA-->
        <?php
        $Url[1] = (empty($Url[1]) ? NULL : $Url[1]);

        if (file_exists(REQUIRE_PATH . '/' . $Url[0] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '.php';
        elseif (file_exists(REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php';
        else:
            require REQUIRE_PATH . '/404.php';
        endif;
        ?>
        <!--CONTEUDO | MANUTENÇÃO LIRA-->

        <article class="bg-yellow">
            <h1 class="font-zero">Divulgação do Site</h1>

            <?php
            $pg_share = str_replace('/404', '', $pg_url);
            ?>

            <ul class="container_share text-shadow main_divulg">
                <li class="radius-five main_divulg_item facebook">
                    <a href="<?= urlencode($pg_share); ?>&app_id=<?= $pg_fb_app; ?>" target="_blank" rel="nofollow" title="Compartilhe no Facebook!">
                        <i class="icon-facebook"></i>
                        <h2>Facebook<span class="count">0</span></h2>
                    </a>
                </li>
            </ul>
        </article>

        <!--FOOTER | MANUTENÇÃO LIRA-->
        <footer class="bg-black">
            <section class="main_footer">
                <h1 class="font-zero">FOOTER | Manutenção Lira - Suporte Técnico em Tecnologia</h1>
                <p>Copyright &COPY; 2019 - Criado por <span><?= $pg_ceo; ?></span> | Manutenção lira, todos os direitos reservados</p>
            </section>
        </footer>
        <!--FOOTER | MANUTENÇÃO LIRA-->

        <!--SCRIPT | MANUTENÇÃO LIRA-->
        <script src="<?= HOME; ?>/_cdn/jquery.js"></script>
        <script src="<?= HOME; ?>/_cdn/script.js"></script>
        <script src="<?= HOME; ?>/_cdn/share.js"></script>
        <script src="<?= HOME; ?>/_cdn/particles.js"></script>
        <script src="<?= HOME; ?>/_cdn/typed.js"></script>
        <script src="<?= HOME; ?>/_cdn/app.js"></script>
        <script src="<?= HOME; ?>/_cdn/swiper.js"></script>
        <!--SCRIPT | MANUTENÇÃO LIRA-->
    </body>
</html>
<?php
ob_end_flush();
