<?php  
add_action( 'widgets_init', 'tle_tags' );

function tle_tags() {
	register_widget( 'tle_tag' );
}

class tle_tag extends WP_Widget {
	function tle_tag() {
		$widget_ops = array( 'classname' => 'tle_tag', 'description' => '显示标签' );
		$this->WP_Widget( 'tle_tag', 'Tle-标签', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$tags_list = get_tags('orderby=count&order=DESC&number=10&offset='.$offset);
		
		$html='';
		$html.='
			<section class="am-panel am-panel-default" data-am-sticky="{top:60}">
				<div class="am-panel-hd">标签</div>
				<ul class="am-list blog-list">
		';
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				$html.='
					<li class="am-serif"><a href="'.get_tag_link($tag).'">'. $tag->name .' ('. $tag->count .')</a></li>
				';
			} 
		}else{
			$html.='
				<li class="am-serif">暂无标签</li>
			';
		}
		$html.='
				</ul>
			</section>
		';
		echo $html;
	}

	function form($instance) {
	}
}

?>