<?php
/**
 * Template para páginas no encontradas (Error 404).
 *
 * @package ThemeFlash
 */

get_header(); 
?>

<div class="page-container">
    
    <main class="page-content error-404-wrapper">

        <article class="page-article error-404-content">
            
            <h1 class="error-title">404</h1>
            
            <h2 class="error-subtitle">
                <?php esc_html_e('¡Ups! Página no encontrada', 'theme-flash'); ?>
            </h2>

            <div class="page-text error-text">
                <p>
                    <?php esc_html_e('Parece que la página que buscas se ha movido o ya no existe. Intenta realizar una búsqueda o vuelve al inicio.', 'theme-flash'); ?>
                </p>

                <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-back-home">
                   <i class="fas fa-home"></i> <?php esc_html_e('Volver al Inicio', 'theme-flash'); ?>
                </a>
            </div>

        </article>

    </main>

</div>

<?php get_footer(); ?>