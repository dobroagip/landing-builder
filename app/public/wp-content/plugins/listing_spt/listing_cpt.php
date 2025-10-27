<?php
/**
 * Plugin Name: Listing Custom Post Type
 * Description: Custom Post Type for listings with multisite support
 * Version: 1.0.0
 * Author: Serg Bard
 * License: GPL v2 or later
 * Text Domain: listing-cpt
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Listing_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_listing_cpt'));
        add_action('init', array($this, 'register_taxonomy'));
        
        // Только для сети - добавляем меню в сетевую админку
        if (is_multisite()) {
            add_action('network_admin_menu', array($this, 'add_network_admin_menu'));
        }
        
        // Активация для каждого сайта сети
        register_activation_hook(__FILE__, array($this, 'activate_on_multisite'));
    }
    
    // Register Custom Post Type
    public function register_listing_cpt() {
        $labels = array(
            'name'                  => __('Listings', 'listing-cpt'),
            'singular_name'         => __('Listing', 'listing-cpt'),
            'menu_name'             => __('Listings', 'listing-cpt'),
            'name_admin_bar'        => __('Listing', 'listing-cpt'),
            'archives'              => __('Listing Archives', 'listing-cpt'),
            'add_new'               => __('Add New', 'listing-cpt'),
            'add_new_item'          => __('Add New Listing', 'listing-cpt'),
            'edit_item'             => __('Edit Listing', 'listing-cpt'),
            'view_item'             => __('View Listing', 'listing-cpt'),
            'all_items'             => __('All Listings', 'listing-cpt'),
            'search_items'          => __('Search Listings', 'listing-cpt'),
            'not_found'             => __('No listings found', 'listing-cpt'),
            'not_found_in_trash'    => __('No listings found in Trash', 'listing-cpt'),
            'parent_item_colon'     => __('Parent Listings:', 'listing-cpt'),
        );
        
        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'has_archive'           => true,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-admin-home',
            'show_in_nav_menus'     => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'capability_type'       => 'post',
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'rewrite'               => array('slug' => 'listings'),
            'query_var'             => true,
            'show_in_rest'          => true,
        );
        
        register_post_type('listing', $args);
    }
    
    // Register Taxonomy
    public function register_taxonomy() {
        $labels = array(
            'name'              => __('Listing Categories', 'listing-cpt'),
            'singular_name'     => __('Listing Category', 'listing-cpt'),
            'search_items'      => __('Search Listing Categories', 'listing-cpt'),
            'all_items'         => __('All Listing Categories', 'listing-cpt'),
            'parent_item'       => __('Parent Listing Category', 'listing-cpt'),
            'parent_item_colon' => __('Parent Listing Category:', 'listing-cpt'),
            'edit_item'         => __('Edit Listing Category', 'listing-cpt'),
            'update_item'       => __('Update Listing Category', 'listing-cpt'),
            'add_new_item'      => __('Add New Listing Category', 'listing-cpt'),
            'new_item_name'     => __('New Listing Category Name', 'listing-cpt'),
            'menu_name'         => __('Listing Categories', 'listing-cpt'),
        );
        
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'listing-category'),
            'show_in_rest'      => true,
        );
        
        register_taxonomy('listing_category', array('listing'), $args);
    }
    
    // Multisite activation
    public function activate_on_multisite($network_wide) {
        if (is_multisite() && $network_wide) {
            // Активируем для всех сайтов сети
            $sites = get_sites(array('number' => 0));
            foreach ($sites as $site) {
                switch_to_blog($site->blog_id);
                $this->register_listing_cpt();
                $this->register_taxonomy();
                flush_rewrite_rules();
                restore_current_blog();
            }
        } else {
            // Одиночный сайт или активация для одного сайта в сети
            $this->register_listing_cpt();
            $this->register_taxonomy();
            flush_rewrite_rules();
        }
    }
    
    // Add network admin menu
    public function add_network_admin_menu() {
        add_menu_page(
            'Listing CPT Network Settings',
            'Listing CPT',
            'manage_network_options',
            'listing-cpt-network-settings',
            array($this, 'network_settings_page'),
            'dashicons-admin-generic',
            80
        );
    }
    
    // Network settings page callback
    public function network_settings_page() {
        echo '<div class="wrap"><h1>Listing CPT Network Settings</h1>';
        echo '<p>Custom Post Type "listing" is active on all sites in the network.</p>';
        
        // Show statistics
        echo '<h2>Listings Count by Site</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Site</th><th>Listings Count</th></tr></thead>';
        echo '<tbody>';
        
        $sites = get_sites(array('number' => 50));
        foreach ($sites as $site) {
            switch_to_blog($site->blog_id);
            $count = wp_count_posts('listing');
            $published = $count->publish;
            echo '<tr>';
            echo '<td>' . get_bloginfo('name') . ' (' . $site->domain . ')</td>';
            echo '<td>' . $published . '</td>';
            echo '</tr>';
            restore_current_blog();
        }
        
        echo '</tbody></table>';
        echo '</div>';
    }
}

// Initialize the plugin
new Listing_CPT();

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    if (is_multisite()) {
        $sites = get_sites(array('number' => 0));
        foreach ($sites as $site) {
            switch_to_blog($site->blog_id);
            flush_rewrite_rules();
            restore_current_blog();
        }
    } else {
        flush_rewrite_rules();
    }
});