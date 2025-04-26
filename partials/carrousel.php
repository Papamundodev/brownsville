<?php
if(function_exists('get_field')){$insurances = get_field('insurances', 'option');}
if(function_exists('get_field')){$insurances_info = get_field('inssurance_info', 'option');}

?>

    <div class="section-title d-flex flex-column gap-2" >
        <?php if (function_exists('get_field')){$section_insurances_title = get_field('section_insurances_title', 'option') ?? __('Our Insurances', 'theme_base');}?>
        <h2><?=$section_insurances_title?></h2>
        <p><?=$insurances_info?></p>
    </div>
<div class="swiper init-swiper">
    <script type="application/json" class="swiper-config">
    {
        "loop": true,
        "speed": 600,
        "autoplay": {
            "delay": 2500,
            "disableOnInteraction": false
        },
        "slidesPerView": "1",
        "pagination": {
        "el": ".swiper-pagination",
        "type": "bullets",
        "clickable": true
        },
        "breakpoints": {

        "768": {
            "slidesPerView": 3,
            "spaceBetween": 40
        },
        "1200": {
            "slidesPerView": 4,
            "spaceBetween": 1
        }
        }
    }
    </script>
    
    <div class="swiper-wrapper">
        <?php if(is_array($insurances) && count($insurances) > 0): ?>
            <?php foreach ($insurances as $insurance) : ?>
            <div class="swiper-slide">
                <div class="carrousel-item">
                    <h3><?= $insurance['name'] ?></h3>
                </div>
            </div><!-- End carrousel item -->
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
