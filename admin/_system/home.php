<section class="container main_home">
    <section class="main_estatistica">
        <h1 class="title-header"><span class="title-color">Estatística de Acesso</span></h1>
        <div class="boxshadow main_estat_content">
            <h2>Conteúdo:</h2>

            <?php
            //Leitura geral
            $read = new Read;

            //Visitas no site
            $read->FullRead("SELECT SUM(siteviews_views) AS views FROM ml_siteviews");
            $Views = $read->getResult()[0]['views'];

            //Leitura de usuários futuros para o admin
            $read->FullRead("SELECT SUM(siteviews_users) AS users FROM ml_siteviews");
            $Users = $read->getResult()[0]['users'];

            //Média de pageviews
            $read->FullRead("SELECT SUM(siteviews_pages) AS pages FROM ml_siteviews");
            $ResPages = $read->getResult()[0]['pages'];
            $Pages = substr($ResPages / $Users, 0, 5);

            //Artigos do site
            $read->ExeRead("ml_posts");
            $Postes = $read->getRowCount();
            ?>
            <article class="main_estat_item">
                <i class="icon-visitas"></i>
                <p><?= $Views; ?> visitas</p>
            </article>

            <article class="main_estat_item">
                <i class="icon-pageviews"></i>
                <p><?= $Pages; ?> pageviews</p>
            </article>

            <article class="main_estat_item">
                <i class="icon-poste"></i>
                <p><?= $Postes; ?> postes</p>
            </article>
        </div>

        <div class="boxshadow main_estat_browser">
            <h2>Conteúdo:</h2>

            <?php
            $read->FullRead("SELECT SUM(agent_views) AS TotalViews FROM ml_siteviews_agent");
            $TotalViews = $read->getResult()[0]['TotalViews'];

            $read->ExeRead("ml_siteviews_agent", "ORDER BY agent_views DESC LIMIT 4");
            if (!$read->getResult()):
                WSErro("Oppsss, ainda não existem estatísticas de navegação!", WS_INFOR);
            else:
                echo "<ul class=\"graphic_browser\">";
                foreach ($read->getResult() as $nav):
                    extract($nav);
                
                    $percent = substr(($agent_views / $TotalViews) * 100, 0, 5);
                    ?>
                    <li>
                        <p><?= $agent_name; ?></p>
                        <p><?= $agent_views; ?> Visitas</p>
                        <div class="border-radius skill">
                            <div class="border-radius skill_level" style="width: <?= $percent; ?>%;"><span><?= $percent; ?> %</span></div>
                        </div>
                    </li>
                    <?php
                endforeach;
                echo "</ul>";
            endif;
            ?>
        </div>
    </section>

    <section class="main_public">
        <h1 class="title-header"><span class="title-color">Publicações</span></h1>

        <div class="boxshadow article_recent">
            <h2>Artigos Recentes:</h2>

            <?php
            $read->ExeRead("ml_posts", "ORDER BY post_date DESC LIMIT 3");
            if ($read->getResult()):
                foreach ($read->getResult() as $re):
                    extract($re);
                    ?>
                    <article class="article_recent_item">
                        <div class="article_capa radius">
                            <?= Check::Image('../uploads/' . $post_cover, $post_title, 150, 100); ?>
                        </div>

                        <div class="article_desc">
                            <h3><a href="../artigo/<?= $post_title; ?>" title="Ver Poste" target="_blank"><?= Check::Words($post_title, 10); ?></a></h3>
                            <p><b>Data:</b> <?= date('d/m/Y H:i:s', strtotime($post_date)); ?>hs</p>
                            <ul class="article_actions">
                                <li><a href="../artigo/<?= $post_name; ?>" title="Ver no site" target="_blank" class="radius"><i class="icon-ver-site"></i></a></li>
                                <li><a href="painel.php?exe=postes/update&postid=<?= $post_id; ?>" title="Editar" class="radius"><i class="icon-editar"></i></a></li>

                                <?php if (!$post_status): ?>
                                    <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=active" title="Ativar" class="radius"><i class="icon-ativar"></i></a></li>
                                <?php else: ?>
                                    <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=inative" title="Inativar" class="radius"><i class="icon-inativar"></i></a></li>
                                <?php endif; ?>

                                <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=delete" title="Deletar" class="radius"><i class="icon-excluir"></i></a></li>
                            </ul>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>

        <div class="boxshadow article_vist">
            <h2>Artigos Mais Vistos:</h2>

            <?php
            $read->ExeRead("ml_posts", "ORDER BY post_views DESC LIMIT 3");
            if ($read->getResult()):
                foreach ($read->getResult() as $re):
                    extract($re);
                    ?>
                    <article class="article_vist_item">
                        <div class="radius article_capa">
                            <?= Check::Image('../uploads/' . $post_cover, $post_title, 150, 100); ?>
                        </div>

                        <div class="article_desc">
                            <h3><a href="../artigo/<?= $post_name; ?>" title="Ver Poste" target="_blank"><?= Check::Words($post_title, 10); ?></a></h3>
                            <p><b>Data:</b> <?= date('d/m/Y H:i:s', strtotime($post_date)); ?>hs</p>
                            <ul class="article_actions">
                                <li><a href="../artigo/<?= $post_name; ?>" title="Ver no site" target="_blank" class="radius"><i class="icon-ver-site"></i></a></li>
                                <li><a href="painel.php?exe=postes/update&postid=<?= $post_id; ?>" title="Editar" class="radius"><i class="icon-editar"></i></a></li>

                                <?php if (!$post_status): ?>
                                    <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=active" title="Ativar" class="radius"><i class="icon-ativar"></i></a></li>
                                <?php else: ?>
                                    <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=inative" title="Inativar" class="radius"><i class="icon-inativar"></i></a></li>
                                <?php endif; ?>

                                <li><a href="painel.php?exe=postes/index&post=<?= $post_id; ?>&action=delete" title="Deletar" class="radius"><i class="icon-excluir"></i></a></li>
                            </ul>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </section>
</section>