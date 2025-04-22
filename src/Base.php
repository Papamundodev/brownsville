<?php

namespace Theme_base;
    
class Base
{
    private string $theme_name;
    private string $theme_slug; 

    public function __construct(string $theme_name, string $theme_slug)
    {
        $this->theme_name = $theme_name;
        $this->theme_slug = $theme_slug;
    
        // add excerpt
        add_action('init', function () {
            add_post_type_support('page', 'excerpt');
        });
    }

    public function includeStyles() : void
    {
        add_action('wp_enqueue_scripts', function () {
            //aos
            wp_enqueue_style('aos', get_template_directory_uri() . '/node_modules/aos/dist/aos.css', [], null);
            // Bootstrap
            wp_enqueue_style('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css', [], null);
            // Main
            wp_enqueue_style('main', get_template_directory_uri() . '/assets/build/css/main.css', [], null);
        });
    }   

    public function includeScripts() : void
    {
        add_action('wp_enqueue_scripts', function () {
            // Bootstrap uniquement si nécessaire
            wp_register_script('popper', get_template_directory_uri() . '/node_modules/@popperjs/core/dist/umd/popper.min.js', [], null, true);
            wp_register_script('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', ['popper'], null, true);
            // AOS
            wp_register_script('aos', get_template_directory_uri() . '/node_modules/aos/dist/aos.js', [], null, true);
            
            // Charge Swiper uniquement sur la page d'accueil
            if (is_front_page() || is_category()) {
                wp_register_script('swiper', get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.js', [], null, true);
                wp_register_script('main', get_template_directory_uri() . '/assets/build/js/main.js', ['swiper', 'aos'], null, true);
            } else {
                wp_register_script('main', get_template_directory_uri() . '/assets/build/js/main.js', ['aos'], null, true);
            }
            
            wp_localize_script('main', 'ajaxurl', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('aas_ajax_nonce'),
            ));
            
            wp_enqueue_script('popper');
            wp_enqueue_script('bootstrap');
            wp_enqueue_script('aos');
            wp_enqueue_script('main');
        });
    }

    public function themeSupports() : void
    {
        add_action('after_setup_theme', function () {
            // Menus
            add_theme_support('menus');
            add_theme_support('post-thumbnails');
            add_theme_support('title-tag');
            // Enables post and comment RSS feed links to head
            add_theme_support('automatic-feed-links');
            // I18N
            load_theme_textdomain('theme_base', get_template_directory() . '/languages');
    
            // Content width
            if ( ! isset ($content_width)) {
                $content_width = 800;
            }

            // Activer le lazy loading natif
            add_theme_support('lazy-loading-images');
            
            // Ajouter des tailles d'images optimisées
            add_image_size('tiny', 50, 50, true);  // Pour les miniatures très petites
            add_image_size('mobile', 576, '', true); // Pour les mobiles
            add_image_size('tablet', 768, '', true); // Pour les tablettes
            add_image_size('medium', 250, '', true); // Medium Thumbnail
            add_image_size('small', 120, '', true); // Small Thumbnail
            add_image_size('large', 1024, '', true); // Large Thumbnail 

        }, 99);
    }



    public function registerMenus() : void
    {
        register_nav_menus([
            'header' => __('Header', 'theme_base'),
            'footer' => __('Footer', 'theme_base'),
        ]);
    }

    public function allowSVGUploads() :void
    {
        add_action('init', function () {

            add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
                global $wp_version;
                if ($wp_version !== '4.7.1') {
                    return $data;
                }

                $filetype = wp_check_filetype($filename, $mimes);

                return [
                    'ext'             => $filetype['ext'],
                    'type'            => $filetype['type'],
                    'proper_filename' => $data['proper_filename']
                ];
            }, 10, 4);

        });

    }

    public function addSVGSupport() :void
    {
        add_action('init', function () {

            add_filter('upload_mimes', function ($mimes) {
                $mimes['svg'] = 'image/svg+xml';

                return $mimes;
            });

        });

    }

        /**
     * currentYear
     *
     * function footer copyright to get current year
     * Used in footer.php
     */

    public static function currentYear() :string
    {
        return date('Y');
    }


   
    /**
     * Get nav menu items by location
     *
     * @param string|null $location The menu location id
     */
    public static function  wp_get_menu_array(?string $location = null, $args = []) : array
    {
        
        // Get all locations
        $locations = get_nav_menu_locations();

        if ($location === null || !array_key_exists($location, $locations)) {
            return [];
        }

        // Get object id by location
        $object = wp_get_nav_menu_object($locations[$location]);
        // Get menu items by menu name
        $menu_items = wp_get_nav_menu_items($object->name, array( 'update_post_term_cache' => false ));
        _wp_menu_item_classes_by_context( $menu_items );
        // Return menu post objects
        $menu = [];

        foreach ($menu_items as $m) {
       
            if (empty($m->menu_item_parent)) {
                $menu[$m->ID] = [];
                $menu[$m->ID]['ID'] = intval($m->ID);
                $menu[$m->ID]['title'] = $m->title;
                $menu[$m->ID]['classes'] = $m->classes;
                $menu[$m->ID]['url'] = $m->url;
                $menu[$m->ID]['object_id'] = intval($m->object_id);
                $object = get_post($m->object_id);
                $menu[$m->ID]['target'] = $m->target;
                if(gettype($m) === "WP_Post"){
                    $menu[$m->ID]['children'] = self::populate_children($menu_items, $m);
                }
            }
        }
        return $menu;

    }

    /**
     * Populate children
     *
     */

    public static function populate_children( array $menu_array = null, \WP_Post $menu_item = null) : array
    {
        $children = [];
        if (!empty($menu_array)) {
            foreach ($menu_array as $k => $m) {
                if ($m->menu_item_parent == $menu_item->ID) {
                    $children[$m->ID] = [];
                    $children[$m->ID]['ID'] = intval($m->ID);
                    $children[$m->ID]['title'] = $m->title;
                    $children[$m->ID]['classes'] = $m->classes;
                    $children[$m->ID]['url'] = $m->url;
                    $children[$m->ID]['parent'] = intval($menu_item->ID);
                    $children[$m->ID]['target'] = $m->target;
                    $children[$m->ID]['object_id'] = intval($m->object_id);
                    unset($menu_array[$k]);
                    $children[$m->ID]['children'] = self::populate_children($menu_array, $m);
                }
            }
        };
        return $children;
    }

    public static function get_active_class($item) : string
    {
        if(in_array('current-menu-item', $item['classes'] ?? [])){
            return 'active';
        }
        return '';
    }

    /**
     * Add class to pagination link
     */
    public function my_theme_posts_link_attributes() : string
    {
        return 'class="btn btn-primary"';
    }

    public function add_pagination_link_attributes() : void
    {   
        add_filter('next_posts_link_attributes', [$this, 'my_theme_posts_link_attributes']);
        add_filter('previous_posts_link_attributes', [$this, 'my_theme_posts_link_attributes']);
    }


    /**
     * Register sidebars and widgetized areas.
     *
     * search
     *
     */
    public function registerWidgets() :void
    {
        add_action('widgets_init', function () {

            //add sidebars and widgets here

        });
    }

    /**
     * @return void
     * add widget for language selector if wpml is active
     */
    public function sidebar_widgets_wpml_init() : void
    {
        add_action( 'widgets_init',  function(){
            register_sidebar( array(
                'name'          => 'wpml_theme_base',
                'id'            => 'wpml',
                'before_widget' => '<ul class="language-selector">',
                'after_widget'  => '</ul>',
                'before_title'  => '<li>',
                'after_title'   => '</li>',
            ) );
        });
    }


    public static function get_meta_description(){
        if (is_category()){
            return get_queried_object()->description;
        }elseif(is_page() || is_single()){
            return get_the_excerpt();
        }else{
            return bloginfo('description');
        }
    }

    public static function get_breadcrumbs(){
        $links = array();
        $home_link = array(
            'url' => home_url(),
            'text' => __('Home', 'theme_base')
        );
        array_push($links, $home_link);
        $cats = get_the_category();
        if ( ! empty( $cats ) ) {
            $cat_link = array(
            'url' => get_category_link( $cats[0]->term_id ),
            'text' => $cats[0]->name
            );
            array_push($links, $cat_link);
        }
        $current_page = array(
            'url' => get_permalink(),
            'text' => get_the_title()
        );
        array_push($links, $current_page);
        return $links;
    }
    /*
    fin
    */

}