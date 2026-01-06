<article class="single-article">

    <?php if (has_post_thumbnail()): ?>
        <div class="single-featured">
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
        </div>
    <?php endif; ?>

    <div class="single-content-container">

        <h1 class="single-title"><?php the_title(); ?></h1>

        <div class="single-meta">
            <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
            <span><i class="fas fa-calendar"></i> <?php echo get_the_date(); ?></span>
            <span><i class="fas fa-folder"></i> <?php the_category(', '); ?></span>
        </div>

        <div class="single-content">
            <?php the_content(); ?>
        </div>

        <div class="single-tags">
            <?php the_tags('<span class="tag-item">', '</span><span class="tag-item">', '</span>'); ?>
        </div>


        <div class="single-navigation">
            <div class="prev-post"><?php previous_post_link('%link', '← Artículo Anterior'); ?></div>
            <div class="next-post"><?php next_post_link('%link', 'Siguiente Artículo →'); ?></div>
        </div>

    </div>

</article>