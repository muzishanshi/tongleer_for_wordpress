<?php get_header(); ?>
<script type="text/javascript">
	$(function(){
		/*鼠标移入和移出事件*/
		$('.menu li').hover(function(){	
			$(this).find('.two').show();
			/*鼠标移入和移出事件*/
			$('.two li').hover(function(){
				var content=$(this).find('.hide li:first small').text();
				if(content != null && content.length != 0){
					$(this).find('.hide').show();
				}
			},function(){
				$(this).find('.hide').hide();
			});
		},function(){
			$(this).find('.two').hide();
		});
	});
</script>
<style>
#nav ul.menu li ul{
		position: relative; 
		top: 0px; 
		background: #fff; 
		border: 1px solid #eee;
		border-radius: 0 0 3px 3px; 
	}
	#nav ul.menu li ul li{
		position: relative;
	}
	#nav ul.menu li ul li .hide{
		position: relative; 
		top: 0px; 
		left: 0px;
		border: 1px solid #eee;
		border-radius: 0 0 3px 3px; 
	}
	.two,.hide{
		display:none;
	}
</style>
<style>
	a{
		color:#000;
	}
	.boxes {
	  width: 180px;
	}
	.boxes .box {
	  height: 60px;
	  color: #eee;
	  line-height: 60px;
	  text-align: center;
	  font-weight: bold;
	  transition: all .2s ease;
	}
	.boxes .box img{
		width:100%;
		height:100%;
	}
	.boxes .box:hover {
	  font-size: 250%;
	  transform: rotate(360deg);
	}
	
	.cat-nav{
		width:0.9;
		margin:0px auto 10px auto;
		background-color:#eeeeee;
	}
	.cat-nav button{
		background-color:#eeeeee;
		font-size:90%;
	}
	@media screen and (max-width: 0.9;) {
		.cat-nav {width: 100%;}
	}
</style>
<div class="am-g am-g-fixed" style="word-wrap:break-word;">
  <div class="am-u-md-9 am-u-md-push-3">
	<div class="cat-nav am-round" data-am-sticky="{top:60}">
		<div data-am-widget="tabs">
		  <ul class="am-tabs-nav">
			  <li><button type="button" class="am-btn am-radius" onClick="location.href='<?php bloginfo('url'); ?>';">全部</button></li>
			  <li id="nav" class="am-dropdown" data-am-dropdown>
				<a class="am-dropdown-toggle am-btn am-radius" data-am-dropdown-toggle><small>更多</small><span class="am-icon-caret-down"></span></a>
				<ul class="am-dropdown-content menu">
					<?php
					global $wpdb,$current_user;
					$categories=get_categories();
					//$categories = $wpdb->get_results("SELECT * FROM ".$wpdb->terms." AS t,".$wpdb->term_taxonomy." AS tt WHERE t.term_id=tt.term_id AND tt.taxonomy = 'category' AND parent=0");
					foreach($categories as $category) {
						if($category->parent!=0){
							continue;
						}
						?>
						<!--
						<li><a href="<?php echo get_category_link($category->term_id);?>" title="<?php echo $category->name;?>"><small><?php echo $category->name;?></small></a></li>
						-->
						<li>
						<a href="<?php echo get_category_link($category->term_id);?>" title="<?php echo $category->name;?>"><small><?php echo $category->name;?></small></a>
							<?php
							$twocate = $wpdb->get_results("SELECT * FROM ".$wpdb->terms." AS t,".$wpdb->term_taxonomy." AS tt WHERE t.term_id=tt.term_id AND tt.taxonomy = 'category' AND parent=".$category->term_id);
							if($twocate){
								?>
								<ul class="two">
								<?php foreach ($twocate as $two) {?>
								<li>
									<a href="<?php echo get_category_link($two->term_id);?>" title="<?php echo $two->name;?>"><small><?php echo $two->name; ?></small></a>
									<ul class="hide">
										<?php
										$threecate = $wpdb->get_results("SELECT * FROM ".$wpdb->terms." AS t,".$wpdb->term_taxonomy." AS tt WHERE t.term_id=tt.term_id AND tt.taxonomy = 'category' AND parent=".$two->term_id);
										foreach ($threecate as $three) {
										?>
										<li><a href="<?php echo get_category_link($three->term_id);?>" title="<?php echo $three->name;?>"><small><?php echo $three->name; ?></small></a></li>
										<?php
										}
										?>
									</ul>
								</li>
								<?php }?>
								</ul>
								<?php
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>
			  </li>
			  <li>
				<form class="am-fr" id="search-header" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" name="search-header">
					<input class="am-form-field am-round am-input-sm" type="text" name="s" placeholder="搜文章" />
				</form>
			  </li>
		  </ul>
		</div>
	</div>
    <section id="content">
		<?php while (have_posts()) : the_post(); ?>
		<ol class="am-breadcrumb" style="background-color:#fff;">
		  <li><a href="<?php bloginfo('url'); ?>" class="am-icon-home">首页</a></li>
		  <li>
			<?php 
				if( !is_category() ) {
					$category = get_the_category();
					if($category[0]){
						echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
					}
				};
			?>
		  </li>
		  <li class="am-active">
			<?php
			$title = get_post($id)->post_title;
			echo $title;
			?>
		  </li>
		</ol>
		<div class="am-cf am-article" style="padding:10px;background-color:#fff;">
			<h6><?php the_title(); ?></h6>
			<div>
				<small>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="author"><?php echo get_the_author(); ?></a> 发布 | <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) )?> | 阅读数：<?php tle_views(''); ?> | 评论数：<?php echo get_comments_number('0', '1', '%'); ?>
				</small>
			</div>
			<p>
				<?php
				$video_youku = get_post_meta($post->ID, 'video_youku', true);
				$video_mp4 = get_post_meta($post->ID, 'video_mp4', true);
				if($video_youku){
					echo "<iframe height=400 width=100% src='".$video_youku."' frameborder=0 'allowfullscreen'></iframe>";
				}else if($video_mp4){
					echo '<video src="'.$video_mp4.'" controls="controls">您的浏览器不支持 video 标签。</video>';
				}
				?>
				<?php
				//$content=get_post($id)->post_content;echo $content;
				the_content();
				?>
			</p>
			<hr />
			<p>
				<small><?php the_tags('<div>继续浏览有关 ',',',' 的文章</div>'); ?></small>
			</p>
			<p>
				<small>分享至:</small>
				<?php $sharecontent=subString(str_replace('', '', strip_tags($content)),0,140);?>
				<a href="http://service.weibo.com/share/share.php?url=<?=curPageURL();?>&title=<?php echo the_title(); ?>" onclick="window.open(this.href, 'share', 'width=550,height=335');return false;" ><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_sina.png" alt="" /></a>
				<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?=curPageURL();?>&title=<?php echo the_title(); ?>&site=<?php bloginfo('url'); ?>&desc=这是一篇神奇的文章&summary=<?php echo $sharecontent; ?>&pics=<?php if(showThumb($content)){echo showThumb($content)[0];}?>" onclick="window.open(this.href, 'share', 'width=550,height=335');return false;" ><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_qzone.png" alt="" /></a>
				<a href="http://connect.qq.com/widget/shareqq/index.html?url=<?=curPageURL();?>&title=<?php echo the_title(); ?>&site=<?php bloginfo('url'); ?>&desc=这是一篇神奇的文章&summary=<?php echo $sharecontent; ?>&pics=<?php if(showThumb($content)){echo showThumb($content)[0];}?>" onclick="window.open(this.href, 'share', 'width=550,height=335');return false;" ><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_qq.png" alt="" /></a>
			</p>
		</div>
		<?php endwhile;  ?>
		<?php comments_template('', true); ?>
	</section>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>