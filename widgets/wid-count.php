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
		?>
			<section class="am-panel am-panel-default web-info" style="margin-bottom:5px;">
				<li id="btnCommentShow" class="frinum">
					<a href="javascript:void(0)"><?=$comtsnum;?>
					<span>评论</span></a>
				</li>
				<li id="btnUserShow" class="vitnum">
					<a href="javascript:void(0)"><?=$usersnum;?>
					<span>粉丝</span></a>
				</li>
				<li id="btnArticleShow" class="ptnum">
					<a href="javascript:void(0)"><?=$postsnum;?>
					<span>文章</span></a>
				</li>
				<div id="commentShowDiv">
					<?php
					$rowsComments = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."comments WHERE comment_approved='1' order by comment_date desc limit 0,5");
					if($rowsComments){
						?>
						<span style="text-align: center;"><small><b>最新评论</b></small></span>
						<?php
						foreach($rowsComments as $value){
						?>
						<div>
							<?php
							$hash = md5($value->comment_author_email);
							$avatar = "https://secure.gravatar.com/avatar/$hash?s=40d=mm&r=g";
							?>
							<img src="<?=$avatar;?>" alt="" class="am-circle" width="18" height="18">
							<small><a href="<?=$value->comment_author_url!=""?$value->comment_author_url:"javascript:;";?>" title="<?=$value->comment_author;?>" target="_blank" rel="nofollow"><?=$value->comment_author;?></a>说：<?=subString(str_replace('', '', strip_tags($value->comment_content)),0,20);?></small>
						</div>
						<?php
						}
					}
					?>
				</div>
				<div id="userShowDiv" style="display:none;">
					<?php
					$rowsUser = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."users as u,".$wpdb->prefix."usermeta as um WHERE u.ID=um.user_id AND meta_key='description' order by user_registered desc limit 0,5");
					if($rowsUser){
						?>
						<span style="text-align: center;"><small><b>最新粉丝</b></small></span>
						<?php
						foreach($rowsUser as $value){
						?>
						<div>
							<?php
							$hash = md5($value->user_email);
							$avatar = "https://secure.gravatar.com/avatar/$hash?s=40d=mm&r=g";
							?>
							<img src="<?=$avatar;?>" alt="" class="am-circle" width="18" height="18">
							<small>
								<a href="javascript:;" target="_blank" title="<?=$value->user_nicename;?><?php if($value->user_url){?>（<?=$value->user_url;?>）<?php }?>">
									<?=$value->user_nicename;?>
									<font color="#aaa">
										<?php if($value->meta_value!=''){?>
											（<?=subString(str_replace('', '', strip_tags($value->meta_value)),0,20);?>）
										<?php }else{?>
											（Ta暂无介绍）
										<?php }?>
									</font>
								</a>
							</small>
						</div>
						<?php
						}
					}
					?>
				</div>
				<div id="articleShowDiv" style="display:none;">
					<?php
					$rowsContents = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts as p,".$wpdb->prefix."users as u WHERE u.ID=p.post_author AND post_status='publish' AND post_type='post' order by post_date desc limit 0,5");
					if($rowsContents){
						?>
						<span style="text-align: center;"><small><b>最新文章</b></small></span>
						<?php
						foreach($rowsContents as $value){
						?>
						<div>
							<?php
							$hash = md5($value->user_email);
							$avatar = "https://secure.gravatar.com/avatar/$hash?s=40d=mm&r=g";
							?>
							<img src="<?=$avatar;?>" alt="" class="am-circle" width="18" height="18">
							<small><?=$value->user_nicename;?>于<?=$value->post_date;?>发表：<a href="<?=$value->guid;?>" title="<?=$value->post_title;?>"><?=$value->post_title;?></a><font color="#aaa"><?=subString(str_replace('', '', strip_tags($value->post_content)),0,35);?></font></small>
						</div>
						<?php
						}
					}
					?>
				</div>
			</section>
			<script>
			$("#btnCommentShow").click(function(){
				if($("#commentShowDiv").css("display")=="none"){
					$("#commentShowDiv").css("display","block");
					$("#userShowDiv").css("display","none");
					$("#articleShowDiv").css("display","none");
				}else{
					$("#commentShowDiv").css("display","none");
				}
			});
			$("#btnUserShow").click(function(){
				if($("#userShowDiv").css("display")=="none"){
					$("#userShowDiv").css("display","block");
					$("#commentShowDiv").css("display","none");
					$("#articleShowDiv").css("display","none");
				}else{
					$("#userShowDiv").css("display","none");
				}
			});
			$("#btnArticleShow").click(function(){
				if($("#articleShowDiv").css("display")=="none"){
					$("#articleShowDiv").css("display","block");
					$("#commentShowDiv").css("display","none");
					$("#userShowDiv").css("display","none");
				}else{
					$("#articleShowDiv").css("display","none");
				}
			});
			</script>
		<?php
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