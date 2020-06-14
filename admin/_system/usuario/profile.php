<form method="post" action="" name="UserEditForm" enctype="multipart/form-data" class="container main_class_form">
    <fieldset>
        
        <?php extract($_SESSION['userlogin']); ?>
        
        <legend>Olá <?= $user_name; ?>, atualize seu perfil</legend>

        <?php  
        $ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $userId = $_SESSION['userlogin']['user_id'];
        
        if($ClienteData && $ClienteData['SendUserForm']):
            unset($ClienteData['SendUserForm']);
            extract($ClienteData);
            
            require ('_models/AdminUser.class.php');
            $cadastra = new AdminUser;
            $cadastra->ExeUpdate($userId, $ClienteData);
            
            if($cadastra->getResult()):
                WSErro("Seus dados foram atualizados com sucesso! <b>O sistema será atualizado no próximo login!!!</b>", WS_SUCCESS);
            else:
                WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        else:
            extract($_SESSION['userlogin']);
        endif;
        ?>

        <label class="main_class_form_label">
            <span>Nome:</span>
            <input type="text" title="Informe seu nome" name="user_name" value="<?= $user_name; ?>" required/>
        </label>
        
        <label class="main_class_form_label">
            <span>Sobrenome:</span>
            <input type="text" title="Informe seu sobrenome" name="user_lastname" value="<?= $user_lastname; ?>" required/>
        </label>
        
        <label class="main_class_form_label">
            <span>Email:</span>
            <input type="email" title="Informe seu email" name="user_email" value="<?= $user_email; ?>" required/>
        </label>

        <label class="main_class_form_label">
            <span>Senha:</span>
            <input type="password" title="Informe uma senha [ de 6 a 12 caracteres! ]" name="user_password" value="<?= $user_password; ?>" pattern=".{6,12}"/>
        </label>

        <input type="submit" name="SendUserForm" class="btn btn-blue radius perfil_btn" value="Atualizar Perfil"/>
    </fieldset>
</form>