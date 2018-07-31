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
			<section class="am-panel am-panel-success" data-am-sticky="{top:60}">
				<div class="am-panel-hd"><small>标签</small></div>
					<div style="padding:10px;">
		';
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				$html.='
					<a style="color: rgb('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).')" href="'.get_tag_link($tag).'" title="'.$value['tagname'].'">'. $tag->name .' ('. $tag->count .')</a>
				';
			} 
		}else{
			$html.='
				暂无标签
			';
		}
		$html.='
				</div>
			</section>
		';
		echo $html;
	}

	function form($instance) {
	}
}

?>