<?php
/*
 Plugin Name: WooCommerce Matt Hardy Photograpy
 Plugin URI: https://github.com/chrisrenga/wc-matthardyphotography
 Description: WooCommerce customisation for Matt Hardy Photography
 Author: Chris Renga
 Version: 0.0.1
 Author URI: https://www.chrisrenga.com
 License: MIT License
 */

if ( ! defined( 'ABSPATH' ) )
    exit;

/**
 * Check if WooCommerce is active
 */
if ( in_array('woocommerce/woocommerce.php', 
    apply_filters('active_plugins', get_option( 'active_plugins')) 
) ) {
    
    if ( ! class_exists( 'WC_MattHardyPhotography' ) ) {
        
        /**
         * Localisation
         **/
        load_plugin_textdomain('wc_matthardyphotography', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

        class WC_MattHardyPhotography {
            public function __construct() {
                // called only after woocommerce has finished loading
                add_action( 'woocommerce_init', array( &$this, 'woocommerce_loaded' ) );
                
                // called after all plugins have loaded
                add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );

                add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

            }
            
            /**
             * Take care of anything that needs woocommerce to be loaded.  
             * For instance, if you need access to the $woocommerce global
             */
            public function woocommerce_loaded() 
            {

                remove_action('woocommerce_before_main_content',
                    'woocommerce_output_content_wrapper', 10
                );

                remove_action( 'woocommerce_before_main_content',
                    'woocommerce_output_content_wrapper', 10
                );

                // image
                // remove_action( 'woocommerce_before_single_product_summary',
                //     'woocommerce_show_product_images', 20
                // );                

                // add to breadcrumbs
                remove_action( 'woocommerce_single_product_summary',
                    'woocommerce_template_single_title', 5
                );           
                
                add_action( 'woocommerce_before_main_content',
                    'woocommerce_template_single_title', 30
                );                
                
                remove_action( 'woocommerce_single_product_summary',
                    'woocommerce_template_single_excerpt', 20
                );

                add_action( 'woocommerce_single_product_summary',
                    'woocommerce_template_single_excerpt', 45
                );
                
                remove_action( 'woocommerce_single_product_summary',
                    'woocommerce_template_single_meta', 40
                );
                

            }
            
            /**
             * Take care of anything that needs all plugins to be loaded
             */
            public function plugins_loaded() 
            {
                // ...
            }
            
            /**
             * Load scripts and styles - frontend.
             */
            public function wp_enqueue_scripts() 
            {
                wp_enqueue_script(
                    'wc-matthardyphotography', 
                    plugins_url( 'assets/js/main.min.js', __FILE__ ), 
                    array('jquery'), 
                    '1.0.1'
                );

                wp_enqueue_style(
                    'wc-matthardyphotography', 
                    plugins_url( 'assets/css/main.min.css', __FILE__ )
                    ,
                    null, 
                    '0.1.1'
                );
            }

        }

        // finally instantiate our plugin class and add it to the set of globals
        $GLOBALS['wc-matthardyphotography'] = new WC_MattHardyPhotography();
    }
}
