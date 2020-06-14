<?php
if (!class_exists('Login')):
    header('Location: ../../painel.php');
    die;
endif;
?>
<form method="post" action="" name="CategoryForm" enctype="multipart/form-data" class="container main_class_form">
    <fieldset>
        <legend>Atualizar Categoria</legend>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $catid = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);

        if (!empty($data['SendCategoryForm'])):
            unset($data['SendCategoryForm']);

            require ('_models/AdminCategory.class.php');
            $cadastra = new AdminCategory;
            $cadastra->ExeUpdate($catid, $data);

            WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
        else:
            $read = new Read;
            $read->ExeRead("ml_categories", "WHERE category_id = :id", "id={$catid}");
            if (!$read->getResult()):
                header('Location: painel.php?exe=categorias/index&empty=true');
            else:
                $data = $read->getResult()[0];
            endif;
        endif;
        
        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if($checkCreate && empty($cadastra)):
            $tipo = (empty($data['category_parent']) ? 'seção' : 'categoria');
            WSErro("A {$tipo} <b>{$data['category_title']}</b> foi cadastrado com sucesso no sistema!", WS_SUCCESS);
        endif;
        ?>

        <label class="main_class_form_label">
            <span>Título:</span>
            <input type="text" name="category_title" value="<?php if(isset($data)) echo $data['category_title']; ?>"/>
        </label>

        <label class="main_class_form_label">
            <span>Conteúdo:</span>
            <textarea name="category_content" rows="5"><?php if(isset($data)) echo $data['category_content']; ?></textarea>
        </label>

        <div class="main_class_form_label_line">
            <label>
                <span>Data:</span>
                <input type="text" name="category_date" value="<?= date('d/m/Y H:i:s'); ?>"/>
            </label>

            <label>
                <span>Seção:</span>
                <select name="category_parent">
                    <option value="null"> Selecione a Seção </option>
                    <?php
                    $readSes = new Read;
                    $readSes->ExeRead("ml_categories", "WHERE category_parent IS NULL ORDER BY category_title ASC");
                    if (!$readSes->getResult()):
                        echo '<option disabled="disabled" value="null"> Cadastre antes uma seção! </option>';
                    else:
                        foreach ($readSes->getResult() as $ses):
                            echo "<option value=\"{$ses['category_id']}\" ";

                            if ($ses['category_id'] == $data['category_parent']):
                                echo ' selected="selected" ';
                            endif;

                            echo "> {$ses['category_title']} </option>";
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>
        </div>

        <input type="submit" class="btn btn-blue radius" name="SendCategoryForm" value="Atualizar Categoria"/>
    </fieldset>
</form>