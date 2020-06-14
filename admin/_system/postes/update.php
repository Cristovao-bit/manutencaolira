<form method="post" action="" name="PostForm" enctype="multipart/form-data" class="container main_class_form">
    <fieldset>
        <legend>Atualizar Poste</legend>

        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

        if (isset($post) && $post['SendPostForm']):
            $post['post_status'] = ($post['SendPostForm'] == 'Atualizar' ? '0' : '1');
            $post['post_cover'] = ($_FILES['post_cover']['tmp_name'] ? $_FILES['post_cover'] : 'null');
            unset($post['SendPostForm']);

            require('_models/AdminPost.class.php');
            $cadastra = new AdminPost;
            $cadastra->ExeUpdate($postid, $post);

            WSErro($cadastra->getError()[0], $cadastra->getError()[1]);

            if (!empty($_FILES['gallery_covers']['tmp_name'])):
                $sendGallery = new AdminPost;
                $sendGallery->gbSend($_FILES['gallery_covers'], $postid);
            endif;
        else:
            $read = new Read;
            $read->ExeRead("ml_posts", "WHERE post_id = :id", "id={$postid}");
            if (!$read->getResult()):
                header("Location: painel.php?exe=postes/index&empty=true");
            else:
                $post = $read->getResult()[0];
                $post['post_date'] = date("d/m/Y H:i:s", strtotime($post['post_date']));
            endif;
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastra)):
            WSErro("O post <b>{$post['post_title']}</b> foi cadastrado com sucesso no sistema!", WS_SUCCESS);
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
                <input type="text" name="post_date" value="<?php
                if (isset($post['post_date'])): echo $post['post_date'];
                else: echo date('d/m/Y H:i:s');
                endif;
                ?>"/>
            </label>

            <label>
                <span>Categoria:</span>
                <select name="post_category">
                    <option value=""> Selecione a categoria </option> 
                    <?php
                    $readSes = new Read;
                    $readSes->ExeRead("ml_categories", "WHERE category_parent IS NULL ORDER BY category_title ASC");
                    if ($readSes->getRowCount() >= 1):
                        foreach ($readSes->getResult() as $ses):
                            echo "<option disabled=\"disabled\" value=\"\"> {$ses['category_title']} </option>";
                            $readCat = new Read;
                            $readCat->ExeRead("ml_categories", "WHERE category_parent = :parent ORDER BY category_title ASC", "parent={$ses['category_id']}");
                            if ($readCat->getRowCount() >= 1):
                                foreach ($readCat->getResult() as $cat):
                                    echo "<option ";

                                    if ($post['post_category'] == $cat['category_id']):
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
                    if ($readAut->getRowCount() >= 1):
                        foreach ($readAut->getResult() as $aut):
                            echo "<option ";

                            if ($post['post_author'] == $aut['user_id']):
                                echo "selected=\"selected\" ";
                            endif;

                            echo "value=\"{$aut['user_id']}\"> {$aut['user_name']} {$aut['user_lastname']} </option> ";
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>
        </div>

        <label class="main_class_form_label" id="gbfoco">
            <span>Enviar Galeria:</span>
            <input type="file" name="gallery_covers[]" multiple/>
        </label>
        
        <?php
        $delGb = filter_input(INPUT_GET, 'gbdel', FILTER_VALIDATE_INT);
        if($delGb):
            require_once ('_models/AdminPost.class.php');
            $DelGallery = new AdminPost;  
            $DelGallery->gbRemove($delGb);
            
            WSErro($DelGallery->getError()[0], $DelGallery->getError()[1]);
        endif;
        ?>

        <ul class="main_gallery">
            <?php
            $gbi = 0;
            $Gallery = new Read;
            $Gallery->ExeRead("ml_posts_gallery", "WHERE post_id = :post", "post={$postid}");
            if ($Gallery->getResult()):
                foreach ($Gallery->getResult() as $gb):
                    $gbi++;
                    ?>
                    <li class="main_gallery_item<?php if ($gbi % 4 == 0) ; ?>">
                        <div class="gallery_capa">
                            <?= Check::Image('../uploads/' . $gb['gallery_image'], $gbi, 140, 120); ?>
                        </div>
                        <a href="painel.php?exe=postes/update&postid=<?= $postid; ?>&gbdel=<?= $gb['gallery_id']; ?>#gbfoco" class="del"><i class="icon-excluir"></i></a>
                    </li>
                    <?php
                endforeach;
            endif;
            ?>
        </ul>

        <input type="submit" class="btn btn-blue radius" name="SendPostForm" value="Atualizar"/>
        <input type="submit" class="btn btn-green radius" name="SendPostForm" value="Atualizar & Publicar"/>
    </fieldset>
</form>