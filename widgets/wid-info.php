<?php  
add_action( 'widgets_init', 'tle_infos' );

function tle_infos() {
	register_widget( 'tle_info' );
}

class tle_info extends WP_Widget {
	function tle_info() {
		$widget_ops = array( 'classname' => 'tle_info', 'description' => '显示微博认证资料' );
		$this->WP_Widget( 'tle_info', 'Tle-资料', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		echo '
			<section class="am-panel am-panel-default">
				<ul class="am-list am-list-static am-list-border">
				  <li>
					<span><img src="'.get_template_directory_uri().'/assets/images/weiboauth.png" /></span><br />
					<small>'.do_option("config_weiboname").'</small>
				  </li>
				  <li><i class="am-icon-map-marker am-icon-fw"></i><small>'.do_option("config_address").'</small></li>
				  <li><i class="am-icon-birthday-cake am-icon-fw"></i><small>'.do_option("config_birthday").'</small></li>
				  <li><i class="am-icon-info am-icon-fw"></i><small>'.do_option("config_detail").'</small></li>
				  <li style="text-align:center;"><small><a href="'.do_option("config_about").'">查看更多 ></a></small></li>
				</ul>
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