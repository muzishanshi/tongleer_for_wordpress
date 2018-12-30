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
<!-- content section -->
<section class="page-main">
	<?php
	global $wpdb,$current_user;
	$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='publish' AND post_type='post' ORDER BY post_date DESC");
	$album=array();
	$temi=0;
	foreach($rows as $value){
		$match_str = "/((http)+.*?((.gif)|(.jpg)|(.bmp)|(.png)|(.GIF)|(.JPG)|(.PNG)|(.BMP)))/";
		preg_match_all ($match_str,$value->post_content,$matches,PREG_PATTERN_ORDER);
		if(count($matches[1])==0){
			continue;
		}
		for($j=0;$j<count($matches[1]);$j++){
			$album[$temi]['src']=$matches[1][$j];
			$album[$temi]['post_title']=$value->post_title;
			$album[$temi]['post_date']=$value->post_date;
			$temi++;
		}
	}
	$page_now = isset($_GET['page_now']) ? intval($_GET['page_now']) : 1;
	if($page_now<1){
		$page_now=1;
	}
	$page_rec=16;
	$totalrec=count($album);
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
	$albumArr = array_slice($album, ($page_now-1)*$page_rec, $page_rec);
	$i=1;
	?>
	<?php
	$i=1;$year=0; $mon=0;
	$output = "";
	foreach($albumArr as $value){
		$year_tmp = date('Y',strtotime($value["post_date"]));
		$mon_tmp = date('m',strtotime($value["post_date"]));
		if ($mon != $mon_tmp && $mon > 0){
			$output .= '
						</ul>
					</div>
				</div>
			</div>
			';  //结束拼接
		}
		if ($year != $year_tmp && $year > 0){
		}
		if ($year != $year_tmp) {
			$year = $year_tmp;
		}
		if ($mon != $mon_tmp) {
			$mon = $mon_tmp;
			$output .= "
				<div class=\"am-panel am-panel-default\">
					<div class=\"am-panel-hd\" style=\"background:#fff;color:#aaa;border:1px solid #fff;\">
						<h4 class=\"am-panel-title\" data-am-collapse=\"{parent: '#accordion', target: '#do-not-say-".$i."'}\">".$year."年".$mon."月
						</h4>
					</div>
					<div id=\"do-not-say-".$i."\" class=\"am-panel-collapse am-collapse  am-in\">
						<div class=\"am-panel-bd\">
							<ul data-am-widget=\"gallery\" class=\"am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-overlay\" data-am-gallery=\"{ pureview: true }\" >
			";
		}
		$output .= "
			<li class=\"albumitem\">
				<div class=\"am-gallery-item\" style=\"width:100%;height:0px;padding-bottom:100%;position:relative;\">
					<a href=\"javascript:;\">
						<img src=\"".$value['src']."\" style=\"width:100%;height:100%;position:absolute;\"  alt=\"".$value["post_title"]."（".$value["post_date"]."）"."\" />
						<h3 class=\"am-gallery-title\">".$value["post_title"]."（".$value["post_date"]."）"."</h3>
					</a>
				</div>
			</li>
		";
		$i++;
	}
	echo $output.'
				</ul>
			</div>
		</div>
	</div>
	';
	?>
	<ul class="am-pagination blog-pagination">
	  <?php if($page_now!=1){?>
		<li class="am-pagination-prev"><a href="?page_now=1">首页</a></li>
	  <?php }?>
	  <?php if($page_now>1){?>
		<li class="am-pagination-prev"><a href="?page_now=<?=$before_page;?>">&laquo; 上一页</a></li>
	  <?php }?>
	  <?php if($page_now<$page){?>
		<li class="am-pagination-next"><a id="tlenextpage" href="?page_now=<?=$after_page;?>">下一页 &raquo;</a></li>
	  <?php }?>
	  <?php if($page_now!=$page){?>
		<li class="am-pagination-next"><a href="?page_now=<?=$page;?>">尾页</a></li>
	  <?php }?>
	</ul>
	<!--
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.ias.min.js" type="text/javascript"></script>
	<script>
	var ias = $.ias({
		container: ".page-main", /*包含所有文章的元素*/
		item: ".albumitem", /*文章元素*/
		pagination: ".am-pagination", /*分页元素*/
		next: ".am-pagination a#tlenextpage", /*下一页元素*/
	});
	ias.extension(new IASTriggerExtension({
		text: '<div class="cat-nav am-round"><small></small></div>', /*此选项为需要点击时的文字*/
		offset: false, /*设置此项后，到 offset+1 页之后需要手动点击才能加载，取消此项则一直为无限加载*/
	}));
	ias.extension(new IASSpinnerExtension());
	ias.extension(new IASNoneLeftExtension({
		text: '', /*加载完成时的提示*/
	}));
	</script>
	-->
</section>
<!-- end content section -->
<?php get_footer(); ?>