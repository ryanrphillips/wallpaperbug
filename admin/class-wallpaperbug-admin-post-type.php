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
class WallpaperBug_Admin_Post_Type {
	
	public $meta;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {
		add_filter( 'postbox_classes_wallpaperbug_wallpaperbug_meta', array( $this, 'add_metabox_classes' ) );
		
		add_action( 'save_post_wallpaper', array( $this, 'save' ), 10, 3 );
		
	}
	
	public function register() {

		$labels = array(
			'name' => 'Wallpapers',
			'singular_name' => 'Wallpaper',
			'name_admin_bar' => 'Wallpaper',
			'add_new' => _x( 'Add New', 'wallpaper' , 'wallpaperbug' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'wallpaperbug' ), 'wallpaper' ),
			'edit_item' => sprintf( __( 'Edit %s' , 'wallpaperbug' ), 'wallpaper' ),
			'new_item' => sprintf( __( 'New %s' , 'wallpaperbug' ), 'wallpaper' ),
			'all_items' => sprintf( __( 'All %s' , 'wallpaperbug' ), 'wallpapers' ),
			'view_item' => sprintf( __( 'View %s' , 'wallpaperbug' ), 'wallpaper' ),
			'search_items' => sprintf( __( 'Search %s' , 'wallpaperbug' ), 'wallpapers' ),
			'not_found' =>  sprintf( __( 'No %s Found' , 'wallpaperbug' ), 'wallpapers' ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'wallpaperbug' ), 'wallpapers' ),
			'parent_item_colon' => sprintf( __( 'Parent %s' ), 'wallpaper' ),
			'menu_name' => 'wallpapers',
		);

		$args = array(
			'labels' => apply_filters( 'wallpaper' . '_labels', $labels ),
			'description' => 'WallpaperBug post type',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array('title'),
			'menu_position' => 3,
			'menu_icon' => 'dashicons-admin-post',
			'taxonomies' => array(
				'wallpaper-categories',
				'post_tag'
			),
			'register_meta_box_cb' => array( $this, 'wallpaperbug_meta' )
		);

		register_post_type(
			'wallpaper',
			apply_filters( 'wallpaper' . '_register_args', $args, 'wallpaper' )
		);
		
		register_taxonomy(
			'wallpaper-categories',
			'wallpaper',
			array(
				'hierarchical' 		=> true,
				'label' 			=> 'Wallpaper Categories',
				'query_var' 		=> true,
				'rewrite'			=> array(
					'slug' 			=> 'category',
					'with_front' 	=> false
				)
			)
		);

	}
				   
   	public function save($post_id, $post, $update ) {
		if (isset($_POST['wallpaperbug-meta'])) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			$meta_data = $_POST['wallpaperbug-meta'];

			$sizes = array(
				'high-definition' => array (
					'slug' => 'hd',
					'sizes' => array(
						'960x540'   => '960 x 540',
						'1024x576'  => '1024 x 576',
						'1280x720'  => '1280 x 720',
						'1366x768'  => '1366 x 768',
						'1600x900'  => '1600 x 900',
						'1920x1080' => '1920 x 1080',
						'2048x1152' => '2048 x 1152',
						'2400x1350' => '2400 x 1350',
						'2560x1440' => '2560 x 1440',
						'2880x1620' => '2880 x 1620',
						'3554x1999' => '3554 x 1999',
						'3840x2160' => '3840 x 2160'
					)
				),
				'widescreen' => array (
					'slug' => 'wide',
					'sizes' => array(
						'960x600'   => '960 x 600',
						'1152x720'  => '1152 x 720',
						'1280x768'  => '1280 x 768',
						'1280x800'  => '1280 x 800',
						'1440x900'  => '1440 x 900',
						'1680x1050' => '1680 x 1050',
						'1920x1200' => '1920 x 1200',
						'2560x1600' => '2560 x 1600',
						'2880x1800' => '2880 x 1800'
					)
				),
				'standard-definition' => array (
					'slug' => 'sd',
					'sizes' => array(
						'800x600'   => '800 x 600',
						'1024x768'  => '1024 x 768',
						'1152x864'  => '1152 x 864',
						'1280x960'  => '1280 x 960',
						'1400x1050' => '1400 x 1050',
						'1440x1080' => '1440 x 1080',
						'1600x1200' => '1600 x 1200',
						'1680x1260' => '1680 x 1260',
						'1920x1440' => '1920 x 1440',
						'2048x1536' => '2048 x 1536',
						'2560x1920' => '2560 x 1920',
						'2800x2100' => '2800 x 2100',
						'3200x2400' => '3200 x 2400'
					)
				)
			);

			if (isset($meta_data['regenerate'])) {
				
				unset($meta_data['regenerate']);
				
				foreach ($sizes as $type => $data) {
					
					if (!isset($meta_data[$type]['id']) || empty($meta_data[$type]['id'])) {
						
						if (isset($meta_data['high-definition']['id']) && !empty($meta_data['high-definition']['id'])) {
							$meta_data[$type]['url'] = $meta_data['high-definition']['url'];
							$meta_data[$type]['id'] = $meta_data['high-definition']['id'];
						} else if (isset($meta_data['widescreen']['id']) && !empty($meta_data['widescreen']['id'])) {
							$meta_data[$type]['url'] = $meta_data['widescreen']['url'];
							$meta_data[$type]['id'] = $meta_data['widescreen']['id'];
						} else if (isset($meta_data['standard-definition']['id']) && !empty($meta_data['standard-definition']['id'])) {
							$meta_data[$type]['url'] = $meta_data['standard-definition']['url'];
							$meta_data[$type]['id'] = $meta_data['standard-definition']['id'];
						}
						
						/* print "<pre>";
						print_r ($meta_data);
						print_r ($meta_data[0]);
						print "</pre>";
						die();
						//$meta_data[$type]['url'] = $meta_data['high-definition']['url'];
						//$meta_data[$type]['id'] = $meta_data['high-definition']['id'];
						$meta_data[$type]['url'] = $meta_data[0]['url'];
						$meta_data[$type]['id'] = $meta_data[0]['id']; */
						
					}

					if (isset($meta_data[$type]['id']) && !empty($meta_data[$type]['id'])) {

						$attachment_data = wp_get_attachment_metadata($meta_data[$type]['id']);

						$upload_path = 'wp-content/uploads/wallpapers/' . $post_id . '/';

						foreach ($data['sizes'] as $size => $resolution) {
							
							$img = wp_get_image_editor( get_attached_file( $meta_data[$type]['id'] ) );
							
							if (!is_wp_error( $img )) {
								$img_size = explode('x', $size);
								$width = $img_size[0];
								$height = $img_size[1];

								if ($width > $attachment_data['width'] || $height > $attachment_data['height']) {
									break;
								}

								$img->resize($width, $height, true);
								$meta_name = $data['slug'] . '-' . $width . 'x' . $height . '.' . array_pop(explode('.', $attachment_data['file']));
								$file_name = $post_id . '-' . $meta_name;
								$image = $img->save(ABSPATH . $upload_path . $file_name, 'image/jpeg');
								//$image = $img->save($img->generate_filename($img->get_suffix(), ABSPATH . $upload_path, 'jpg'));
								
								//print "<pre>";
								//print_r ($image);
								//die();
								
								//$meta_name = $data['slug'] . '-' . $width . 'x' . $height . '.' . array_pop(explode('.', $attachment_data['file']));
								//$file_name = $post_id . '-' . $meta_name;
								$meta_data[$type]['wallpapers'][$data['slug'] . '-' . $size] = str_replace(ABSPATH, "", $image['path']);
								
								//$img->save(ABSPATH . $upload_path . $file_name, 'image/jpeg');
								
								wp_set_post_terms( $post_id, array($resolution), 'post_tag', 'true' );
							}

						}

					}
					
					wp_set_post_terms( $post_id, array('Single Monitor'), 'post_tag', 'true' );

				}
				
			}
			
			
			
			update_post_meta( $post_id, 'wallpaperbug-meta', $meta_data );
	
		}
	}
	
	public function wallpaperbug_meta($post) {
		$this->meta = (array) get_post_meta($post->ID, 'wallpaperbug-meta', true);
		add_meta_box(
            'wallpaperbug_meta',
            'Select Wallpapers',
            array(
				$this,
				'add_media'
			),
            'wallpaper',
            'normal',
            'high'
        );
	}
	
	public function add_media($post) {
        ?>
        <div class="wallpaperbug_metabox">
			<input type="checkbox" checked="checked" name="wallpaperbug-meta[regenerate]" value="regenerate"> Force Regenerate
			<br/>
        	<div class="wallpaperbug_metabox_column">
				<h3 class="wallpaperbug_title">High Definition (16:9)</h3>
				<input type="text" name="wallpaperbug-meta[high-definition][url]" class="wallpaperbug_attachment_url" value="<?php echo (isset($this->meta['high-definition']['url']) && $this->meta['high-definition']['url'] != '' ? $this->meta['high-definition']['url'] : ''); ?>" />
				<input type="hidden" name="wallpaperbug-meta[high-definition][id]" class="wallpaperbug_attachment_id" value="<?php echo (isset($this->meta['high-definition']['id']) && $this->meta['high-definition']['id'] != '' ? $this->meta['high-definition']['id'] : ''); ?>" />
				<div class="wallpaperbug_image" style="background-image: url(<?php echo (isset($this->meta['high-definition']['url']) && $this->meta['high-definition']['url'] != '' ? $this->meta['high-definition']['url'] : 'http://www.placehold.it/450x250'); ?>);"></div>
				<input type="button" value="Fetch Wallpaper" class="button-primary wallpaperbug-fetch-image" />
				<input type="button" value="Upload Wallpaper" class="button-primary wallpaperbug-upload-image" />
			</div>
            <div class="wallpaperbug_metabox_column">
				<h3 class="wallpaperbug_title">Widescreen (16:10)</h3>
				<input type="text" name="wallpaperbug-meta[widescreen][url]" class="wallpaperbug_attachment_url" value="<?php echo (isset($this->meta['widescreen']['url']) && $this->meta['widescreen']['url'] != '' ? $this->meta['widescreen']['url'] : ''); ?>" />
				<input type="hidden" name="wallpaperbug-meta[widescreen][id]" class="wallpaperbug_attachment_id" value="<?php echo (isset($this->meta['widescreen']['id']) && $this->meta['widescreen']['id'] != '' ? $this->meta['widescreen']['id'] : ''); ?>" />
				<div class="wallpaperbug_image" style="background-image: url(<?php echo (isset($this->meta['widescreen']['url']) && $this->meta['widescreen']['url'] != '' ? $this->meta['widescreen']['url'] : 'http://www.placehold.it/450x250'); ?>);"></div>
				<input type="button" value="Fetch Wallpaper" class="button-primary wallpaperbug-fetch-image" />
				<input type="button" value="Upload Wallpaper" class="button-primary wallpaperbug-upload-image" />
			</div>
			<div class="wallpaperbug_metabox_column">
				<h3 class="wallpaperbug_title">Standard Definition (4:3)</h3>
				<input type="text" name="wallpaperbug-meta[standard-definition][url]" class="wallpaperbug_attachment_url" value="<?php echo (isset($this->meta['standard-definition']['url']) && $this->meta['standard-definition']['url'] != '' ? $this->meta['standard-definition']['url'] : ''); ?>" />
				<input type="hidden" name="wallpaperbug-meta[standard-definition][id]" class="wallpaperbug_attachment_id" value="<?php echo (isset($this->meta['standard-definition']['id']) && $this->meta['standard-definition']['id'] != '' ? $this->meta['standard-definition']['id'] : ''); ?>" />
				<div class="wallpaperbug_image" style="background-image: url(<?php echo (isset($this->meta['standard-definition']['url']) && $this->meta['standard-definition']['url'] != '' ? $this->meta['standard-definition']['url'] : 'http://www.placehold.it/450x250'); ?>);"></div>
				<input type="button" value="Fetch Wallpaper" class="button-primary wallpaperbug-fetch-image" />
				<input type="button" value="Upload Wallpaper" class="button-primary wallpaperbug-upload-image" />
			</div>
			<input type="text" checked="checked" name="wallpaperbug-meta[source]" value="<?php echo (isset($this->meta['source']) && $this->meta['source'] != '' ? $this->meta['source'] : ''); ?>" placeholder="Source">
        </div>
        <?php
    }

}
