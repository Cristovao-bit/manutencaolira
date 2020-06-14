<section class="container main_class_index">
    <h1>Categorias</h1>

    <?php
    $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
    if ($empty):
        WSErro("Você tentou editar uma categoria que não existe no sistema!", WS_INFOR);
    endif;
    
    $delCat = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
    if($delCat):
        require ('_models/AdminCategory.class.php');
        $deletar = new AdminCategory;
        $deletar->ExeDelete($delCat);
    
        WSErro($deletar->getError()[0], $deletar->getError()[1]);
    endif;
    
    $readSes = new Read;
    $readSes->ExeRead("ml_categories", "WHERE category_parent IS NULL ORDER BY category_title ASC");
    if (!$readSes->getResult()):
        WSErro("Não existe seções cadastradas!", WS_INFOR);
    else:
        foreach ($readSes->getResult() as $ses):
            extract($ses);

            $readPosts = new Read;
            $readPosts->ExeRead("ml_posts", "WHERE post_cat_parent = :parent", "parent={$category_id}");
            $countSesPosts = $readPosts->getRowCount();

            $readCats = new Read;
            $readCats->ExeRead("ml_categories", "WHERE category_parent = :parent", "parent={$category_id}");
            $countSesCats = $readCats->getRowCount();
            ?>
            <section class="main_class_index_content">
                <header>
                    <h2><?= $category_title; ?> <span>( <?= $countSesPosts; ?> postes ) ( <?= $countSesCats; ?> categorias ) </span></h2>
                    <p><?= $category_content; ?></p>

                    <ul>
                        <p><b>Data:</b> <?= date('d/m/Y H:i', strtotime($category_date)); ?> hs</p>
                        <li><a href="../categoria/<?= $category_name; ?>" title="Ver no site" target="_black" class="radius"><i class="icon-ver-site"></i></a></li>
                        <li><a href="painel.php?exe=categorias/update&catid=<?= $category_id; ?>" title="Editar" class="radius"><i class="icon-editar"></i></a></li>
                        <li><a href="painel.php?exe=categorias/index&delete=<?= $category_id; ?>" title="Deletar" class="radius"><i class="icon-excluir"></i></a></li>
                    </ul>
                </header>

                <section class="main_class_index_sub_content">
                    <h3>Sub categorias de conteúdo tecnologico</h3>

                    <?php
                    $readSub = new Read;
                    $readSub->ExeRead("ml_categories", "WHERE category_parent = :subparent", "subparent={$category_id}");
                    if (!$readSub->getResult()):
                        WSErro("Não existe categorias cadastradas!", WS_INFOR);
                    else:
                        $a = null;
                        foreach ($readSub->getResult() as $sub):
                            $a++;
                            $readCatPosts = new Read;
                            $readCatPosts->ExeRead("ml_posts", "WHERE post_category = :categoryid", "categoryid={$sub['category_id']}");
                            ?>
                            <article class="boxshadow<?php if ($a % 3 == 0) ; ?>">
                                <h1><a href="../categoria/<?= $sub['category_name']; ?>" title="Ver no site" target="_black"><?= $sub['category_title']; ?> ( <?= $readCatPosts->getRowCount(); ?> postes )</a></h1>

                                <ul>
                                    <p><b>Data:</b> <?= date('d/m/Y H:i', strtotime($sub['category_date'])); ?> hs</p>
                                    <li><a href="../categoria/<?= $sub['category_name']; ?>" title="Ver no site" target="_black" class="radius"><i class="icon-ver-site"></i></a></li>
                                    <li><a href="painel.php?exe=categorias/update&catid=<?= $sub['category_id']; ?>" title="Editar" class="radius"><i class="icon-editar"></i></a></li>
                                    <li><a href="painel.php?exe=categorias/index&delete=<?= $sub['category_id']; ?>" title="Deletar" class="radius"><i class="icon-excluir"></i></a></li>
                                </ul>
                            </article>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </section>
            </section>
            <?php
        endforeach;
    endif;
    ?>
</section>