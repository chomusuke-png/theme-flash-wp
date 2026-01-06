<?php
/**
 * Template part para items de la grilla destacada.
 * Recibe argumentos ($args) para definir su clase CSS de área.
 */

$area_class = isset($args['area']) ? $args['area'] : '';
?>

<a href="<?php the_permalink(); ?>" class="news-item <?php echo esc_attr($area_class); ?>">
    <?php if (has_post_thumbnail()): ?>
        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <div class="overlay">
        <h2><?php the_title(); ?></h2>
        <span class="date"><?php echo get_the_date(); ?></span>
    </div>
</a>