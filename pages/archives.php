<?php
/*
    template name: 文章存档
    description: template for tongleer.com TleWeiboForWordPress theme 
*/
get_header(); 
?>
<style>
.page-main{
	background-color:#fff;
	width:960px;
	margin:0px auto 0px auto;
}
@media screen and (max-width: 960px) {
	.page-main {width: 100%;}
}
</style>
<!-- content section -->
<section class="page-main">
	<?php while (have_posts()) : the_post(); ?>
	<ol class="am-breadcrumb">
		<li><a href="<?php bloginfo('url'); ?>" class="am-icon-home">首页</a></li>
		<li class="am-active"><?php the_title(); ?></li>
	</ol>
	<article class="am-article am-paragraph am-paragraph-default" data-am-widget="paragraph" data-am-paragraph="{ tableScrollable: true, pureview: true }">
	  <div class="am-article-hd">
		<h1 class="am-article-title"><?php the_title(); ?></h1>
		<p class="am-article-meta">
			<div>
				<small>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="author"><?php echo get_the_author() ?></a> 发布 | <?php the_time('Y-m-d');?> | 评论数：<?php echo get_comments_number('0', '1', '%');?> | 阅读数：<?php tle_views(''); ?>
				</small>
			</div>
		</p>
	  </div>
	  <div class="am-article-bd">
		<?php
		//$content=get_post($id)->post_content;echo $content;
		the_content();
		?>
	  </div>
	  <div class="am-panel-group" id="accordion">
		  <?php
			$previous_year = $year = 0;
			$previous_month = $month = 0;
			$ul_open = false;
			 
			$myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
			
			foreach($myposts as $post) :
				setup_postdata($post);
			 
				$year = mysql2date('Y', $post->post_date);
				$month = mysql2date('n', $post->post_date);
				$day = mysql2date('j', $post->post_date);
				
				if($year != $previous_year || $month != $previous_month) :
					if($ul_open == true) : 
						echo '</ul></div>';
					endif;
			 
					echo '<div><h3>'; echo the_time('F Y'); echo '</h3>';
					echo '<ul>';
					$ul_open = true;
			 
				endif;
			 
				$previous_year = $year; $previous_month = $month;
			?>
				<li>
					<time><?php the_time('j'); ?>日</time>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php comments_number('', '1评论', '%评论'); ?></span>
				</li>
			<?php endforeach; ?>
			</ul>
		  </div>
	  </div>
	</article>
	<?php endwhile;  ?>
</section>
<?php get_footer(); ?>