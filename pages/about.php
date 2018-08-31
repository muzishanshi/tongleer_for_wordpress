<?php
/*
    template name: 更多资料
    description: template for tongleer.com TleWeiboForWordPress theme 
*/
?>
<?php get_header(); ?>
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
			  <li class="am-dropdown" data-am-dropdown>
				<button type="button" class="am-dropdown-toggle am-btn am-radius" data-am-dropdown-toggle>更多<span class="am-icon-caret-down"></span></button>
				<ul class="am-dropdown-content">
					<?php
					$categories=get_categories();
					foreach($categories as $category) {
						if($category->parent!=0){
							continue;
						}
						?>
						<li><a href="<?php echo get_category_link($category->term_id);?>" title="<?php echo $category->name;?>"><?php echo $category->name;?></a></li>
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
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="author"><?php echo get_the_author(); ?></a> 发布 | <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) )?> | 阅读数：<?php tle_views(''); ?>
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
				
			</p>
		</div>
		<?php endwhile;  ?>
	</section>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>