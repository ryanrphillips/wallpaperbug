<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class WallpaperBug_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Register the admin menu items
	 *
	 * @since    1.0.0
	 */
	public function register_menu() {
		//global $menu, $submenu;
        
        $wallpaperbug_menu_parent = add_menu_page(
            'WallpaperBug',
            'WallpaperBug',
            'manage_options',
            $this->plugin_name,
            null,
            'dashicons-admin-page',
            3
        );
		
		$wallpaperbug_menu_children = array(
			array(
                'parent_slug'   => $this->plugin_name,
                'page_title'    => 'Settings',
                'menu_title'    => 'Settings',
                'capability'    => 'manage_options',
                'menu_slug'     => $this->plugin_name,
                'function'      => null
            ),
            array(
                'parent_slug'   => $this->plugin_name,
                'page_title'    => '',
                'menu_title'    => 'Add Wallpaper',
                'capability'    => 'manage_options',
                'menu_slug'     => 'post-new.php?post_type=wallpaper',
                'function'      => null
            ),
            array(
                'parent_slug'   => $this->plugin_name,
                'page_title'    => '',
                'menu_title'    => 'Manage Wallpapers',
                'capability'    => 'manage_options',
                'menu_slug'     => 'edit.php?post_type=wallpaper',
                'function'      => null
            ),
            array(
                'parent_slug'   => $this->plugin_name,
                'page_title'    => '',
                'menu_title'    => 'Wallpaper Categories',
                'capability'    => 'manage_options',
                'menu_slug'     => 'edit-tags.php?taxonomy=wallpaper-categories&post_type=wallpaper',
                'function'      => null
            ),
            array(
                'parent_slug'   => $this->plugin_name,
                'page_title'    => '',
                'menu_title'    => 'Wallpaper Tags',
                'capability'    => 'manage_options',
                'menu_slug'     => 'edit-tags.php?taxonomy=post_tag&post_type=wallpaper',
                'function'      => null
            )
        );
		
		foreach($wallpaperbug_menu_children as $wallpaperbug_menu_child){
            add_submenu_page(
                $wallpaperbug_menu_child['parent_slug'],
                $wallpaperbug_menu_child['page_title'],
                $wallpaperbug_menu_child['menu_title'],
                $wallpaperbug_menu_child['capability'],
                $wallpaperbug_menu_child['menu_slug'],
                $wallpaperbug_menu_child['function']
            );
        }
	}
	
	/**
	 * Adjust the active menu
	 *
	 * @since    1.0.0
	 */
	public function adjust_active_menu($parent_file){
        global $submenu_file, $current_screen, $pagenow;

        // Set the submenu as active/current while anywhere in your Custom Post Type (nwcm_news)
        if($current_screen->post_type == 'wallpaper') {
            if($pagenow == 'post.php'){
                $submenu_file = 'edit.php?post_type='.$current_screen->post_type;
            }

            if($pagenow == 'edit-tags.php'){
                $submenu_file = 'edit-tags.php?taxonomy=wallpaper_category&post_type='.$current_screen->post_type;
            }

            $parent_file = $this->plugin_name;

        }

        return $parent_file;
    }

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wallpaperbug-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wallpaperbug-admin.js', array( 'jquery' ), $this->version, false );
	}

}
