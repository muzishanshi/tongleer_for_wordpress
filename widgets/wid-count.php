<?php  
add_action( 'widgets_init', 'tle_counts' );

function tle_counts() {
	register_widget( 'tle_count' );
}

class tle_count extends WP_Widget {
	function tle_count() {
		$widget_ops = array( 'classname' => 'tle_count', 'description' => '显示评论、用户、文章数量' );
		$this->WP_Widget( 'tle_count', 'Tle-统计', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;
		$comtsnum = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
		if (0 < $comtsnum) $comtsnum= number_format($comtsnum);
		$usersnum = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users");
		if (0 < $usersnum) $usersnum= number_format($usersnum);
		$postsnum = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status='publish' AND post_type='post'");
		if (0 < $postsnum) $postsnum= number_format($postsnum);
		echo '
			<section class="am-panel am-panel-default web-info">
				<li class="frinum">
					<a href="javascript:void(0)">'.$comtsnum.'
					<span>评论</span></a>
				</li>
				<li class="vitnum">
					<a href="javascript:void(0)">'.$usersnum.'
					<span>粉丝</span></a>
				</li>
				<li class="ptnum">
					<a href="javascript:void(0)">'.$postsnum.'
					<span>文章</span></a>
				</li>
				
			</section>
		';
	}

	function form($instance) {
		?>
		<p>
			<label>
				配置后主题设置中的内容将显示到侧边栏
			</label>
		</p>
		<?php
	}
}

?>