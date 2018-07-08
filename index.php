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
<div class="am-g am-g-fixed">
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
    <section class="am-u-md-12">
	  <?php
	  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	  $args = array(
	      'caller_get_posts' => 1,
	      'paged' => $paged
	  );
	  query_posts($args);
	  if (have_posts()){
	  ?>
		<ul class="am-list">
		  <?php $k=0;while ( have_posts() ) : the_post(); ?>
		  <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left" style="background-color:#fff;margin-bottom:10px;">
			<div <?php if(isMobile()){?>class="am-u-sm-3 am-list-thumb"<?php }else{?>class="am-u-sm-2 am-list-thumb"<?php }?>>
			  <a href="">
				<img class="am-circle" src="<?=do_option('config_headImgUrl');?>"/>
			  </a>
			</div>
			<div <?php if(isMobile()){?>class="am-u-sm-9 am-list-main"<?php }else{?>class="am-u-sm-10 am-list-main"<?php }?> style="margin-bottom:5px;">
				<h3 class="am-list-item-hd">
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<small class="am-list-item-text">
					<?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?> 来自 
					<?php 
						if( !is_category() ) {
							$category = get_the_category();
							if($category[0]){
								echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
							}
						};
					?>
					<?php if( !is_author()){ ?><span class="am-icon-user"></span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a><?php } ?>&nbsp;&nbsp;
				</small>
				<div>
					<small>
						<?php 
						if( !post_password_required() ){
							echo tle_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 140, '...'); 
						}else{
							echo '密码保护文章，暂无摘要！';
						}
						?>
					</small>
				</div>
				<?php
				$thumb=showThumb($post->post_content);
				if(count($thumb)<9&&count($thumb)!=0){
					?>
					<div class="am-avg-sm-3" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
					  <img src="<?=$thumb[0];?>"  alt="" width="180" />
					</div>
					<?php
				}else if(count($thumb)>=9){
					?>
					<ul class="am-avg-sm-3 boxes" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
						<?php for($i=0;$i<count($thumb);$i++){?>
							<li class="box box-1"><img src="<?=$thumb[$i];?>"  alt="" /></li>
						<?php }?>
					</ul>
					<?php
				}
				?>
			</div>
			<ul class="am-avg-sm-2" style="text-align:center;">
			  <li style="border-right:1px solid #ddd;border-top:1px solid #ddd;">
				<a class="am-list-item-text" href="">阅读 <?php tle_views(''); ?></a>
			  </li>
			  <li style="border-top:1px solid #ddd;">
				<a class="am-list-item-text" href="<?php echo get_comments_link(); ?>#comments">
					评论 <?php if ( comments_open() ){echo get_comments_number('0', '1', '%');} ?>
				</a>
			  </li>
			</ul>
		  </li>
		  <?php $k++;endwhile;wp_reset_query(); ?>
		</ul>
		<?php tle_paging(); ?>
	  <?php
	  }else{
	  ?>
		<style>
		.page-main{
			background-color:#fff;
			margin:0px auto 0px auto;
		}
		@media screen and (max-width: 960px) {
			.page-main {width: 100%;}
		}
		</style>
		<section class="page-main">
		  <div class="admin-content">
			<div class="admin-content-body">
			  <div class="am-cf am-padding am-padding-bottom-0">
				<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">404</strong> / <small>That’s an error</small></div>
			  </div>

			  <hr>

			  <div class="am-g">
				<div class="am-u-sm-12">
				  <h2 class="am-text-center am-text-xxxl am-margin-top-lg">404. Not Found</h2>
				  <p class="am-text-center">没有找到你要的页面</p>
				<pre class="page-404">
				  .----.
			   _.'__    `.
		   .--($)($$)---/#\
		 .' @          /###\
		 :         ,   #####
		  `-..__.-' _.-\###/
				`;_:    `"'
			  .'"""""`.
			 /,  ya ,\\
			//  404!  \\
			`-._______.-'
			___`. | .'___
		   (______|______)
				</pre>
				</div>
			  </div>
			</div>
		  </div>
		<!-- content end -->
		</section>
	  <?php
	  }
	  ?>  
	</section>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
