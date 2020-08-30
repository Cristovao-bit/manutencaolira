<form method="post" action="" name="PostForm" enctype="multipart/form-data" class="container main_class_form">
    <fieldset>
        <legend>Criar Poste</legend>

        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($post) && $post['SendPostForm']):
            $post['post_status'] = ($post['SendPostForm'] == 'Cadastrar' ? '0' : '1');
            $post['post_cover'] = ($_FILES['post_cover']['tmp_name'] ? $_FILES['post_cover'] : null);
            unset($post['SendPostForm']);
            
            require('_models/AdminPost.class.php');
            $cadastra = new AdminPost;
            $cadastra->ExeCreate($post);
            
            if($cadastra->getResult()):
                if(!empty($_FILES['gallery_covers']['tmp_name'])):
                    $sendGallery = new AdminPost;
                    $sendGallery->gbSend($_FILES['gallery_covers'], $cadastra->getResult());
                endif;
                
                header('Location: painel.php?exe=postes/update&create=true&postid=' . $cadastra->getResult());
            else:
                WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        endif;
        ?>

        <label class="main_class_form_label">
            <span>Enviar Capa:</span>
            <input type="file" name="post_cover"/>
        </label>

        <label class="main_class_form_label">
            <span>Título:</span>
            <input type="text" name="post_title" value="<?php if (isset($post['post_title'])) echo $post['post_title']; ?>"/>
        </label>

        <label class="main_class_form_label">
            <span>Conteúdo:</span>
            <textarea name="post_content" class="js_editor" rows="20"><?php if (isset($post['post_content'])) echo htmlspecialchars($post['post_content']); ?></textarea>
        </label>

        <div class="main_class_form_label_line_true">
            <label>
                <span>Data:</span>
                <input type="text" name="post_date" value="<?php if(isset($post['post_date'])): echo $post['post_date']; else: echo date('d/m/Y H:i:s'); endif; ?>"/>
            </label>

            <label>
                <span>Categoria:</span>
                <select name="post_category">
                    <option value=""> Selecione a categoria </option> 
                    <?php
                    $readSes = new Read;
                    $readSes->ExeRead("ml_categories", "WHERE category_parent IS NULL ORDER BY category_title ASC");
                    if($readSes->getRowCount() >= 1):
                        foreach ($readSes->getResult() as $ses):
                            echo "<option disabled=\"disabled\" value=\"\"> {$ses['category_title']} </option>";
                            $readCat= new Read;
                            $readCat->ExeRead("ml_categories", "WHERE category_parent = :parent ORDER BY category_title ASC", "parent={$ses['category_id']}");
                            if($readCat->getRowCount() >= 1):
                                foreach ($readCat->getResult() as $cat):
                                    echo "<option ";
                            
                                    if($post['post_category'] == $cat['category_id']):
                                        echo "selected=\"selected\" ";
                                    endif;
                            
                                    echo "value=\"{$cat['category_id']}\"> &raquo;&raquo; {$cat['category_title']} </option>";
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>

            <label>
                <span>Autor:</span>
                <select name="post_author">
                    <option value="<?= $_SESSION['userlogin']['user_id']; ?>"> <?= "{$_SESSION['userlogin']['user_name']} {$_SESSION['userlogin']['user_lastname']}"; ?> </option>
                    <?php
                    $readAut = new Read;
                    $readAut->ExeRead("ml_users", "WHERE user_id != :id AND user_level >= :level ORDER BY user_name ASC", "id={$_SESSION['userlogin']['user_id']}&level=2");
                    if($readAut->getRowCount() >= 1):
                        foreach ($readAut->getResult() as $aut):
                            echo "<option ";
                    
                            if($post['post_author'] == $aut['user_id']):
                                echo "selected=\"selected\" ";
                            endif;
                    
                            echo "value=\"{$aut['user_id']}\"> {$aut['user_name']} {$aut['user_lastname']} </option> ";
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>
        </div>

        <label class="main_class_form_label">
            <span>Enviar Galeria:</span>
            <input type="file" name="gallery_covers[]" multiple/>
        </label>

        <input type="submit" class="btn btn-blue radius" name="SendPostForm" value="Cadastrar"/>
        <input type="submit" class="btn btn-green radius" name="SendPostForm" value="Cadastrar & Publicar"/>
    </fieldset>
</form>