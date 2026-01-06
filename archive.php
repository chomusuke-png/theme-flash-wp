<?php
/**
 * Template para mostrar archivos (Categorías, Etiquetas, Autores).
 *
 * @package ThemeFlash
 */

get_header(); 
?>

<div class="sidebar-container">
    <div class="main-content">

        <header class="archive-header">
            <?php
            the_archive_title( '<h1 class="archive-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <section class="news-list">
            <?php if ( have_posts() ) : ?>
                
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <?php 
                    // Reutilizamos el diseño de lista existente
                    get_template_part( 'template-parts/content', 'list' ); 
                    ?>

                <?php endwhile; ?>

                <div class="pagination">
                    <?php
                    echo paginate_links([
                        'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                        'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
                    ]);
                    ?>
                </div>

            <?php else : ?>
                
                <div class="widget-item">
                    <h3><?php esc_html_e('No se encontraron resultados', 'theme-flash'); ?></h3>
                    <p><?php esc_html_e('Lo sentimos, no hay noticias en esta sección todavía.', 'theme-flash'); ?></p>
                </div>

            <?php endif; ?>
        </section>

    </div>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>