<?php  

include('wid-count.php');
include('wid-info.php');
include('wid-postlist.php');
include('wid-tags.php');

add_action('widgets_init','unregister_tle_widget');
function unregister_tle_widget(){
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
	
	unregister_widget('WP_Widget_Media_Audio');
    unregister_widget('Wp_Widget_Calendar');
	unregister_widget('Wp_Widget_Archives');
    unregister_widget('Wp_Widget_Links');
    unregister_widget('Wp_Widget_Meta');
	unregister_widget('Wp_Widget_Categories');
    unregister_widget('Wp_Widget_Text');
	unregister_widget('Wp_Widget_Rss');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Custom_HTML');
	unregister_widget('WP_Widget_Media');
	unregister_widget('WP_Widget_Media_Gallery');
	unregister_widget('WP_Widget_Media_Image');
	unregister_widget('WP_Widget_Media_Video');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Posts');
}

?>