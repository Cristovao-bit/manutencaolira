<?php
ob_start();
session_start();
require ('../_app/Config.inc.php');

$login = new Login(3);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin'];
endif;

if ($logoff):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção Lira | Painel</title>
        
        <!--[if lt IE 9]>
            <script src="../_cdn/html5shiv.js"></script>
        <![endif]-->
        
        <link rel="stylesheet" href="_css/icons.css"/>
        <link rel="stylesheet" href="_css/reset.css"/>
        <link rel="stylesheet" href="_css/admin.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <header class="text-shadow">
            <div class="main_painel_header">
                <div class="main_painel_header_user">
                    <a href="painel.php?exe=usuario/profile" class="cursor">
                        <div class="circle foto_perfil">
                            <img title="<?= $userlogin['user_name']; ?>" alt="[<?= $userlogin['user_name']; ?>]" class="circle" src="_img/perfil.jpg"/>
                        </div>
                        <p><?= $userlogin['user_name']; ?> <?= $userlogin['user_lastname']; ?></p>
                        <i class="icon_right icon-indicador"></i>
                    </a>
                </div>
            </div>
            
            <nav class="main_painel_nav">
                <div class="main_painel_nav_logo">
                    <img title="MANUTENÇÃO LIRA | Suporte Técnico em Informática" alt="[MANUTENÇÃO LIRA | Suporte Técnico em Informática]" src="_img/logo_preta.png"/>
                </div>
                
                <?php
                if(isset($getexe)):
                    $linkto = explode('/', $getexe);
                else:
                    $linkto = array();
                endif;
                ?>
                
                <ul class="main_painel_sidebar_menu">
                    <li><a href="painel.php" title="Dashboard"><i class="icon_left icon-dashboard"></i>Dashboard</a></li>
                    <li class="<?php if(in_array('categorias', $linkto)); ?>"><a title="Manutenção Lira | Categorias"><i class="icon_left icon-categorias"></i>Categorias<i class="icon_right icon-indicador"></i></a>
                        <ul>
                            <li><a href="painel.php?exe=categorias/create" title="Manutenção Lira | Criar uma categoria">Criar Categoria</a></li>
                            <li><a href="painel.php?exe=categorias/index" title="Manutenção Lira | Listar / Editar Categoria">Listar / Editar Categoria</a></li>
                        </ul>
                    </li>
                    <li class="<?php if(in_array('postes', $linkto)); ?>"><a title="Manutenção Lira | Postes"><i class="icon_left icon-postes"></i>Postes<i class="icon_right icon-indicador"></i></a>
                        <ul>
                            <li><a href="painel.php?exe=postes/create" title="Manutenção Lira | Criar Poste">Criar Poste</a></li>
                            <li><a href="painel.php?exe=postes/index" title="Manutenção Lira | Listar / Editar Poste">Listar / Editar Poste</a></li>
                        </ul>
                    </li>
                    <li><a href="painel.php?exe=" title="Manutenção Lira | Ver Site"><i class="icon_left icon-site"></i>Ver Site</a></li>
                    <li><a href="painel.php?logoff=true" title="Manutenção Lira | Sair"><i class="icon_left icon-power"></i>Sair</a></li>
                </ul>
                
                <button class="cursor painel_btn"><i class="icon-side"></i></button>
            </nav>
        </header>
        
        <main class="text-shadow">
            <?php
            if(!empty($getexe)):
                $includepath = __DIR__ . '\\_system\\' . strip_tags(trim($getexe) . '.php');
            else:
                $includepath = __DIR__ . '\\_system\\home.php';
            endif;
            
            if(file_exists($includepath)):
                require_once ($includepath);
            else:
                echo "<div class=\"container notfound\">";
                WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
                echo "</div>";
            endif;
            ?>
        </main>
        
        <footer class="text-shadow main_painel_footer">
            <div>
                <p>&COPY; Campus Manutenção Lira - Todos os direitos reservados</p>
            </div>
        </footer>
        
        <script src="../_cdn/jquery.js"></script>
        <script src="../_cdn/jmask.js"></script>
        <script src="../_cdn/combo.js"></script>
        <script src="_js/tiny_mce/tiny_mce.js"></script>
        <script src="_js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
        <script src="_js/admin.js"></script>
    </body>
</html>
<?php
ob_end_flush();