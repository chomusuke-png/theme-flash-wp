<?php get_header(); ?>

<?php if ( is_home() && !is_paged() ) : ?>

<section class="news-grid">
    <?php
    $categoria_id = get_theme_mod('grid_category_id');

    $args = [
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    if (!empty($categoria_id)) {
        $args['cat'] = $categoria_id;
    }

    $destacados = new WP_Query($args);
    $pos = 0;

    if ($destacados->have_posts()):
        while ($destacados->have_posts()):
            $destacados->the_post();

            $pos++;

            if     ($pos == 1) $area = 'big';
            elseif ($pos == 2) $area = 'left1';
            elseif ($pos == 3) $area = 'left2';
            elseif ($pos == 4) $area = 'right1';
            elseif ($pos == 5) $area = 'right2';
            else               $area = '';

            // Llamada modular al grid pasando el argumento 'area'
            get_template_part('template-parts/content', 'grid', ['area' => $area]);

        endwhile;
    endif;

    wp_reset_postdata();
    ?>
</section>

<?php endif; ?>


<div class="sidebar-container">
    <div class="main-content">

        <?php if (get_theme_mod('show_blog_list', true)): ?>

            <section class="news-list">
                <?php
                if (have_posts()):
                    while (have_posts()):
                        the_post();
                        
                        // Llamada modular a la tarjeta de lista
                        get_template_part('template-parts/content', 'list');

                    endwhile;
                else:
                    ?>
                    <p>Las noticias disponibles están ocultas en este momento.</p>
                    <?php
                endif;
                ?>
            </section>

            <div class="pagination">
                <?php
                echo paginate_links([
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                    'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
                ]);
                ?>
            </div>

        <?php else: ?>

            <p>No hay noticias disponibles en este momento.</p>

        <?php endif; ?>

    </div>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>