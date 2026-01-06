<article class="page-article">

    <h1 class="page-title"><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()): ?>
        <div class="page-featured">
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>">
        </div>
    <?php endif; ?>

    <div class="page-text">
        <?php the_content(); ?>
    </div>

</article>