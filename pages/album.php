<?php
/*
    template name: 微博相册
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
	<ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-overlay" data-am-gallery="{ pureview: true }" >
	  <?php
		global $wpdb,$current_user;
		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='publish' AND post_type='post' ORDER BY post_modified DESC");
		$page_now = isset($_GET['page_now']) ? intval($_GET['page_now']) : 1;
		if($page_now<1){
			$page_now=1;
		}
		$page_rec=20;
		$totalrec=count($rows);
		$page=ceil($totalrec/$page_rec);
		if($page_now>$page){
			$page_now=$page;
		}
		if($page_now<=1){
			$before_page=1;
			if($page>1){
				$after_page=$page_now+1;
			}else{
				$after_page=1;
			}
		}else{
			$before_page=$page_now-1;
			if($page_now<$page){
				$after_page=$page_now+1;
			}else{
				$after_page=$page;
			}
		}
		$i=($page_now-1)*$page_rec<0?0:($page_now-1)*$page_rec;
		$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='publish' AND post_type='post' ORDER BY post_modified DESC LIMIT $i,$page_rec");
		$i=1;
		?>
		<?php
		foreach($rows as $value){
			$match_str = "/((http)+.*?((.gif)|(.jpg)|(.bmp)|(.png)|(.GIF)|(.JPG)|(.PNG)|(.BMP)))/";
			preg_match_all ($match_str,$value->post_content,$matches,PREG_PATTERN_ORDER);
			if(count($matches[1])==0){
				continue;
			}
			
			for($j=0;$j<count($matches[1]);$j++){
				?>
				<li>
				<div class="am-gallery-item" style="width:100%;height:0px;padding-bottom:100%;position:relative;">
					<a href="<?=$matches[1][$j];?>">
					  <img src="<?=$matches[1][$j];?>" style="width:100%;height:100%;position:absolute;" />
					</a>
				</div>
				</li>
				<?php
				$i++;
			}
		}
		?>
	</ul>
</section>
<!-- end content section -->
<?php get_footer(); ?>