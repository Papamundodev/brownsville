<?php
get_header();
global $wp_query;
$posts = $wp_query->posts;
$object = get_queried_object();
$theme_template_name = basename(__FILE__, ".php");
$content = wpautop($object->description) ?? "";
?>

    <main id="main-<?=$theme_template_name?>">
        <section id="category-<?=$object->slug?>" class="category section">
            <div class="container">
                <!-- Page Title -->
                <div class="page-title">
                    <h1><?=$object->name?></h1>
                </div><!-- End Page Title -->

                            <!-- link to anchor for the services -->
            <div class="container">
                <div class="vstack gap-1 mx-auto text-center mb-5">   
                    <?php foreach ($posts as $i => $post) : setup_postdata($post); ?>
                        <a href="#service-<?=$post->ID?>" class="anchor-service"><?=$post->post_title?></a>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>

                <?php if($content) : ?>
                    <div class="container text-center mb-5">
                        <?=$content;?>
                    </div>
                <?php endif; ?>
            </div>


            <div class="container">
                <div class="vstack services-list">
                    <?php if(is_array($posts) && count($posts) > 0): ?>
                        <?php foreach ($posts as $i => $post) : setup_postdata($post); ?>
                            <div id="service-<?=$post->ID?>" class="mb-4 <?=($i % 2 == 0) ? 'dark-background img-left' : 'light-background img-right';?>" data-aos="fade-up" data-aos-delay="200">
                                <?php get_template_part('partials/article/service-preview', null, ['post' => $post]); ?>
                            </div>
                        <?php endforeach; wp_reset_postdata(); ?>
                    <?php endif; ?>

                    <?php if(is_array($posts) && count($posts) > 0): ?>
                        <?php get_template_part('pagination'); ?>
                    <?php endif; ?>
                </div>
            </div>

        </section>
        
    </main>

<?php
get_footer();