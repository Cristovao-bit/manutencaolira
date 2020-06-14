<section class="container main_class_index">
    <h1>Postes</h1>

    <section class="main_class_box">
        <?php
        $postid = 0;
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager('painel.php?exe=postes/index&page=');
        $Pager->ExePager($getPage, 12);

        $readPosts = new Read;
        $readPosts->ExeRead("ml_posts", "ORDER BY post_status ASC, post_date DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if ($readPosts->getResult()):
            foreach ($readPosts->getResult() as $post):
                $postid++;
                extract($post);
                $status = (!$post_status ? 'style="background: #fffed8; padding: 15px;"' : '');
                ?>
                <article class="main_class_box_item<?php if ($postid % 2 == 0) ; ?>" <?= $status; ?>>
                    <div class="radius main_class_box_capa">
                        <?= Check::Image('../uploads/' . $post_cover, $post_title, 120, 100); ?>
                    </div>

                    <div class="article_desc">
                        <h2><a target="_black" href="../artigo/<?= $post_name; ?>"><?= $post_title; ?></a></h2>
                        <p><b>Data:</b> <?= date('Y-m-d H:i', strtotime($post_date)); ?> hs</p>
                        <ul class="article_actions">
                            <li><a href="../artigo/<?= $post_name; ?>" title="Ver no site [<?= $post_name; ?>]" class="radius" target="_black"><i class="icon-ver-site"></i></a></li>
                            <li><a href="painel.php?exe=postes/update&postid=<?= $post_id; ?>" title="Editar artigo" class="radius"><i class="icon-editar"></i></a></li>

                            <?php if (!$post_status): ?>
                                <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=active" title="Ativar artigo" class="radius"><i class="icon-ativar"></i></a></li>
                            <?php else: ?>
                                <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&iaction=inative" title="Torna rascunho" class="radius"><i class="icon-inativar"></i></a></li>
                            <?php endif; ?>

                            <li><a href="painel.php?exe=postes/index&delete=<?= $post_id; ?>" title="Excluir artigo" class="radius"><i class="icon-excluir"></i></a></li>
                        </ul>
                    </div>
                </article>
                <?php
            endforeach;
        else:
            $Pager->returnPage();
            WSErro("Desculpa, ainda não existem postes cadastrados!", WS_INFOR);
        endif;
        ?>

        <?php
        $Pager->ExePaginator("ml_posts");
        echo $Pager->getPaginator();
        ?>
    </section>
</section>