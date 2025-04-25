<?php
$post = $args['post'];
$title = get_the_title($post);
$content = get_the_excerpt($post);
$content = wpautop($content);
?>

<article class="card-service row">
    <div class="col-12 col-lg-7 px-lg-0">
        <div class="d-flex justify-content-center align-items-center h-100 flex-column position-relative">
            <div class="w-100 position-relative card-service__img">
            <?php if (has_post_thumbnail($post)) : ?>
                <img src="<?=get_the_post_thumbnail_url($post, 'large'); ?>" 
                    alt="<?=esc_attr($title); ?>" 
                    class="img-fluid" 
                    loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5 px-lg-0 py-5">
        <div class="d-flex flex-column justify-content-between h-100 p-5 p-lg-0">
            <div class="vstack">
                <h4 class=""><?=$title; ?></h4>
                <p class=""><?=$content; ?></p>
            </div>
            <?php if (get_permalink($post)) : ?>
            <div class="d-flex justify-content-start align-items-center">
                <a href="<?=get_permalink($post); ?>" class="btn btn-primary ">
                    <span class=""><?=__('Read more', 'theme_base');?></span><span class="visually-hidden"> about <?=$title;?></span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</article>