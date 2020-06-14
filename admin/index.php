<?php
ob_start();
session_start();
require ('../_app/Config.inc.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Manutenção Lira | Login</title>
        <link rel="stylesheet" href="_css/icons.css"/>
        <link rel="stylesheet" href="_css/reset.css"/>
        <link rel="stylesheet" href="_css/admin.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <section class="text-shadow main_login" id="particles-js">
            <div class="radius main_login_box">
                <span><i class="icon-user"></i></span>
                <h1>Administrador</h1>
                
                <?php
                $login = new Login(3);
                
                if($login->CheckLogin()):
                    header('Location: painel.php');
                endif;
                
                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if(!empty($dataLogin['AdminLogin'])):
                    echo md5($dataLogin['pass']);
                    
                    $login->ExeLogin($dataLogin);
                    if(!$login->getResult()):
                        WSErro($login->getError()[0], $login->getError()[1]);
                    else:
                        header('Location: painel.php');
                    endif;
                endif;
                
                $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                if(!empty($get)):
                    if($get == 'restrito'):
                        WSErro("<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!", WS_ALERT);
                    elseif($get == 'logoff'):
                        WSErro("<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!", WS_SUCCESS);
                    endif;
                endif;
                ?>                
                
                <form method="post" action="" name="AdminLoginForm">
                    <input type="email" class="border-radius" name="user" placeholder="Informe seu email"/>
                    <input type="password" class="border-radius" name="pass" placeholder="Informe sua senha"/>
                    
                    <input type="submit" class="btn btn-black border-radius" name="AdminLogin" value="Login"/>
                </form>
                
                <a href="#!">Esqueci minha senha</a>
                <a href="#!">Retornar ao site</a>
            </div>
            
            <div class="main_login_footer">
                <p>Copyright &COPY; Manutenção Lira - Suporte Técnico em Informática | Todos os direitos reservados</p>
            </div>
        </section>
        
        <script src="_js/particles.js"></script>            
        <script src="_js/app.js"></script>            
    </body>
</html>