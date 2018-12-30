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
			  <li><a class="am-btn am-radius" href="<?php bloginfo('url'); ?>"><small>全部</small></a></li>
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
    <section id="content" class="am-u-md-12">
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
		  <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left tleajaxpage" style="background-color:#fff;margin-bottom:10px;">
			<div <?php if(isMobile()){?>class="am-u-sm-3 am-list-thumb"<?php }else{?>class="am-u-sm-2 am-list-thumb"<?php }?>>
			  <a href="<?php if( !is_author()){echo get_author_posts_url( get_the_author_meta( 'ID' ) );} ?>">
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
				$youku='player.youku.com';
				$miaopai='miaopai.com';
				$douyin='aweme.snssdk.com';
				$qq='v.qq.com';
				if(count($thumb)<9&&count($thumb)!=0){
					if(strpos($thumb[0],$youku)===false&&strpos($thumb[0],$miaopai)===false&&strpos($thumb[0],$douyin)===false&&strpos($thumb[0],$qq)===false){
					?>
					<div class="am-avg-sm-3" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
					  <img src="<?=$thumb[0];?>"  alt="" width="180" />
					</div>
					<?php
					}else if(strpos($thumb[0],$youku)||strpos($thumb[0],$qq)){
						?>
						<iframe height="400" width="100%" src="<?=$thumb[0];?>" frameborder="0" "allowfullscreen"></iframe>
						<?php
					}else if(strpos($thumb[0],'miaopai.com')){
						?>
						<video src="<?=$thumb[0];?>" controls="controls"></video>
						<?php
					}
				}else if(count($thumb)>=9){
					?>
					<ul class="am-avg-sm-3 boxes" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
						<?php
						for($i=0;$i<count($thumb);$i++){
							if(strpos($thumb[$i],$youku)===false&&strpos($thumb[$i],$miaopai)===false&&strpos($thumb[$i],$douyin)===false){
							?>
							<li class="box box-1"><img src="<?=$thumb[$i];?>"  alt="" /></li>
							<?php
							}
						}
						?>
					</ul>
					<?php
				}
				?>
			</div>
			<ul class="am-avg-sm-3" style="text-align:center;">
			  <li style="border-right:1px solid #ddd;border-top:1px solid #ddd;">
				<a class="am-list-item-text" href="<?php the_permalink() ?>">阅读 <?php tle_views(''); ?></a>
			  </li>
			  <li style="border-right:1px solid #ddd;border-top:1px solid #ddd;">
				<a class="am-list-item-text" href="<?php echo get_comments_link(); ?>#comments">
					评论 <?php if ( comments_open() ){echo get_comments_number('0', '1', '%');} ?>
				</a>
			  </li>
			  <li style="border-top:1px solid #ddd;"><a class="am-list-item-text" rel="nofollow" href="http://service.weibo.com/share/share.php?url=<?php the_permalink() ?>&title=<?php the_title(); ?>" onclick="window.open(this.href, 'share', 'width=550,height=335');return false;" >分享 <span class="am-icon-share-square-o"></span></a></li>
			</ul>
		  </li>
		  <?php $k++;endwhile;wp_reset_query(); ?>
		</ul>
		<?php tle_paging(); ?>
		<?php if(do_option('config_is_ajax')=='y'){?>
		<!--ajax分页加载-->
		<script>
		var ias = $.ias({
			container: "#content", /*包含所有文章的元素*/
			item: ".tleajaxpage", /*文章元素*/
			pagination: ".am-pagination", /*分页元素*/
			next: ".am-pagination #tlenextpage a", /*下一页元素*/
		});
		ias.extension(new IASTriggerExtension({
			text: '<div class="cat-nav am-round"><small></small></div>', /*此选项为需要点击时的文字*/
			offset: false, /*设置此项后，到 offset+1 页之后需要手动点击才能加载，取消此项则一直为无限加载*/
		}));
		ias.extension(new IASSpinnerExtension());
		ias.extension(new IASNoneLeftExtension({
			text: '<div class="cat-nav am-round"><small></small></div>', /*加载完成时的提示*/
		}));
		</script>
		<?php }?>
	  <?php
	  }else{
	  ?>
		<?php include "templates/404_include.php";?>
	  <?php
	  }
	  ?>  
	</section>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
