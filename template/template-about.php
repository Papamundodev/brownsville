<?php
/**
 * Template Name: About Page
 */
if (function_exists('get_field')) {
    $about_title = get_the_title() ?? __('About Us', 'theme_base');
    $about_description = get_the_content() ?? "";
}
$content = wpautop(get_the_content());
get_header();
?>

<main id="main" class="about">

    <section id="contact" class="contact section">
        <!-- Page Title -->
        <div class="container page-title">
            <h1><?=$about_title?></h1>
        </div><!-- End Page Title -->

        <?php if($content) : ?>
                <div class="container text-center mb-5">
                    <?=$content;?>
                </div>
         <?php endif; ?>

        <div class="container">
            <?php if(function_exists('get_field')) : ?>
                <?php
                $adress = get_field('adress', 'option') ?? __('95 E. Price Rd., Bldg E, Brownsville, TX 78521', 'theme_base') ?? '';
                $phone = get_field('phone_number', 'option') ?? __('(956) 504 - 4800', 'theme_base') ?? '';
                $google_maps_embed = get_field('google_maps_embed', 'option') ?? "";
                $google_maps_link = get_field('google_maps_link', 'option') ?? "";
                ?>
            <?php endif; ?>
            <div class="row gy-4">
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-wrap h-100">
                        <div class="info-item d-flex">
                            <a href="<?=$google_maps_link?>" target="_blank" class="text-decoration-none d-flex align-items-center ">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3><?=__('Address', 'theme_base');?></h3>
                                    <p><?=$address;?></p>
                                </div>
                            </a>
                        </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                    <a href="tel:<?=$phone?>" class="text-decoration-none d-flex align-items-center">
                    <i class="bi bi-telephone flex-shrink-0"></i>
                    <div>
                        <h3><?=__('Call Us', 'theme_base');?></h3>
                        <p><?=$phone;?></p>
                    </div>
                    </a>
                    </div><!-- End Info Item -->

                    <?php if($google_maps_embed): ?>    
                    <?php echo $google_maps_embed; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(function_exists('get_field')) : ?>
                <?php
                $opening_hours = get_field('opening_hours', 'option') ?? __('Office Hours: Monday - Friday 8 - 5', 'theme_base') ?? '';
                $opening_hours_text = get_field('opening_hours_text', 'option') ?? __('Walk-ins Welcomed, Accepting New Patients', 'theme_base') ?? '';
                ?>
            <?php endif; ?>
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                <div class="info-wrap d-flex flex-column-reverse h-100">
                    <div class="info-item d-flex">
                        <i class="bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h3><?=$opening_hours?></h3>
                            <p><?=$opening_hours_text?></p>
                        </div>
                    </div><!-- End Info Item -->
                    <?php if(get_the_post_thumbnail_url()) : ?>
                    <div class="about-img mb-4">
                        <img src="<?=get_the_post_thumbnail_url()?>" alt="<?=$about_title ?? 'Decorative Image'?>">
                    </div>
                    <?php endif; ?>
                    <?php if($about_description) : ?>
                    <div class="quoted-text text-center mb-3">
                        <?=$about_description?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!-- /Contact Section -->

    <?php
    /**
     * Section Team members 
     * ACF repeater field "team_members"
     */
    $team_members = get_field('team_members', 'option') ?? [];
    ?>
    <section id="team" class="team section light-background ">
        <div class="container">

            <!-- Section Title -->
            <div class="section-title text-center" >
                <h2><?=__('Our Team', 'theme_base');?></h2>
            </div><!-- End Section Title -->
            <?php if(is_array($team_members) && count($team_members) > 0): ?>
                <div class="vstack">
                    <?php foreach ($team_members as $i => $team_member) : ?>
                        <div class="mb-4 data-aos="fade-up" data-aos-delay="200">
                            <div class="team-member row">
                                <div class="col-12 col-lg-3">
                                    <div class="d-flex h-100 flex-lg-column gap-4 gap-lg-0 align-items-center align-items-lg-start"> 
                                        <div class="team-member__img mb-3">
                                            <img src="<?=$team_member['photo']['sizes']['large']?>" alt="<?=$team_member['full_name']?>">
                                        </div>
                                        <div class="team-member__info">
                                            <h3><?=$team_member['full_name']?></h3>
                                            <p><?=$team_member['job_title']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9 d-flex align-items-center">
                                    <div class="quoted-text text-center">
                                        <?=$team_member['description']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
</section>
</main>

<!-- Preloader -->
<div id="preloader"></div>

<?php get_footer(); 