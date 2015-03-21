<?php
function wallpaperbug_list_wallpapers($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'post_type' => 'wallpaper',
            'posts_per_page' => '-1',
            'tax_query' => array()
        ), $atts
	);
    
    $query = new WP_Query($atts);
    ?>
    <ul id="list" class="list clearfix">
        <?php
        while($query->have_posts()) {
            $query->the_post();
            global $post;
			
			$meta = (array) get_post_meta($post->ID, 'wallpaperbug-meta', true);
			
			/* if ($post->ID == 214) {
				print "<pre>";
				print_r ($meta);
				die();
			} */
			
			$get_categories = get_the_terms($post->ID, 'wallpaper_category');
			$get_tags = get_the_terms($post->ID, 'post_tag');
			
			$categories = array();
			$tags = array();
			
			if (is_array($get_categories)) {
				foreach ($get_categories as $category) {
					$categories[] = $category->slug;
				}
			}
			
			$categories = implode(' ', $categories);
			
			if (is_array($get_tags)) {
				foreach ($get_tags as $tag) {
					$tags[] = $tag->slug;
				}
			}
			
			$tags = implode(' ', $tags);
            ?>
            <li class="item" data-permalink="<?php echo the_permalink(); ?>" data-source="<?php echo get_post_meta($post->ID, "source-url", true); ?>" data-category="<?php echo $categories; ?>" data-tags="<?php echo $tags; ?>">
                <div class="image">
                     <a href="<?php echo the_permalink(); ?>">
                         <img src="<?php echo $meta['high-definition']['wallpapers']['hd-960x540']; ?>">
                     </a>
                 </div>
             </li>
        <?php } ?>
    </ul>
    <?php
}
add_shortcode('wallpapers', 'wallpaperbug_list_wallpapers');