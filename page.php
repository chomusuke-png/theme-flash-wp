<?php get_header(); ?>

<div class="page-container">

    <main class="page-content">

        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                
                // Contenido modular
                get_template_part('template-parts/content', 'page');

            endwhile;
        else:
            ?>
            <p class="page-empty">Esta página no tiene contenido visible por ahora... misterios del universo.</p>
        <?php endif; ?>

    </main>

    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>