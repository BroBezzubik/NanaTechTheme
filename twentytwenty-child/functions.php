<?php
    
    function load_child_styles() {
        wp_enqueue_style('parent-theme', get_template_directory_uri() .'/style.css' );
    }

    add_action('wp_enqueue_scripts', 'load_child_styles');

    function wps_get_comment_list_by_user($clauses) {
        if (is_admin()) {
                global $user_ID, $wpdb;
                $clauses['join'] = ", ".$wpdb->base_prefix."posts";
                $clauses['where'] .= " AND ".$wpdb->base_prefix."posts.post_author = ".$user_ID." AND ".$wpdb->base_prefix."comments.comment_post_ID = ".$wpdb->base_prefix."posts.ID";
        };
        return $clauses;
    };

    function html5_search_form( $form ) { 
        $form = '<section class="search"><form role="search" method="get" id="search-form" action="' . home_url( '/' ) . '" >
       <label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
        <input type="search" value=""' . get_search_query() . '" name="s" id="s" placeholder="Поиск" />
        <input type="submit" id="searchsubmit" value="'. esc_attr__('Go', 'domain') .'" />
        </form></section>';
        return $form;
   }
   
    add_filter( 'get_search_form', 'html5_search_form' );
    
    if(!current_user_can('edit_others_posts')) {
	    add_filter('comments_clauses', 'wps_get_comment_list_by_user');
    }

?>
