<?php
/*
    template name: 读者墙
    description: template for tongleer.com TleWeiboForWordPress theme 
*/
get_header();
function readers_wall( $outer='1',$timer='100',$limit='200' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = 'javascript:;';
		$type .= '<a target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次">'.get_avatar( $count->comment_author_email, $size = '36' , get_bloginfo('template_directory').'/assets/images/default.png' ).'</a>';
	}
	echo $type;
}
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
	  <div class="am-panel-bd">
		<?php //readers_wall(); ?>
		<!-- 读者墙 -->
        <ul class="am-avg-sm-8 blog-team">
		<?php
			$query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != 'android@tongleer.com' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 40";//把android@tongleer.com改成自己的邮箱，在读者墙中排除管理员。最后的数字36是在读者墙中显示的读者个数，根据情况修改！
			$wall = $wpdb->get_results($query);   
			$maxNum = $wall[0]->cnt;   
			foreach ($wall as $comment){   
				if( $comment->comment_author_url ){
					$url = $comment->comment_author_url;
				}else{
					$url="#";
				}
				$avatarhost = 'https://secure.gravatar.com';
				$avatarurl = '/avatar/';
				$avatarsize = '50';
				$avatarrating = 'G';
				$avatarhash = md5(strtolower($comment->comment_author_email));
				$avatar = $avatarhost . $avatarurl . $avatarhash . '?s=' . $avatarsize . '&r=' . $avatarrating . '&d=mm';
				?>
				<li><a target='_blank' href='<?=$url;?>' title='查看 <?=$comment->comment_author;?> 的站点：<?php echo $comment->comment_author." ".$comment->cnt;?>'><img class='am-thumbnail' src='<?=$avatar;?>' alt='<?php echo $comment->comment_author." ".$comment->cnt;?>' /></a></li>
				<?php
			}
		?>
		</ul>
	  </div>
	  <div style="clear:both;"></div>
	  <p>
		<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a></div>
		<script>
			window._bd_share_config={
				"common":{
					"bdSnsKey":{},
					"bdText":"<?php echo $log_title; ?>",
					"bdMini":"2",
					"bdMiniList":["qzone","tsina","weixin","tqq","sqq","fbook","twi","copy"],
					"bdPic":"<?php if(showThumb($content)){echo showThumb($content)[0];};?>",
					"bdStyle":"0",
					"bdSize":"16"
				},
				"share":{},
				"image":{
					"viewList":["qzone","tqq","weixin","sqq","tsina"],
					"viewText":"分享到：",
					"viewSize":"16"
				},
				"selectShare":{
					"bdContainerClass":null,
					"bdSelectMiniList":["qzone","tqq","weixin","sqq","tsina"]
				}
			};
			with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		</script>
	  </p>
	</article>
	<?php comments_template('', true); ?>
	<?php endwhile;  ?>
</section>
<?php get_footer(); ?>