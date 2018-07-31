<?php

$dname = 'tongleer';

add_action( 'after_setup_theme', 'tle_setup' );

include('admin/tongleer.php');
include('widgets/index.php');

function tle_setup(){

}

if (function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar'
	));
}
//找回链接功能
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
/*缩略图调用*/
function showThumb($content){
	//若单纯匹配图片把[img|IMG]修改为img即可，这里莫名的原因匹配到了iframe。
    preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $content, $matches );
    $thumb = array();
    if(count($matches[1])<9&&count($matches[1])!=0){
        array_push($thumb,$matches[1][0]);//文章内容中抓到了图片 输出链接
    }else if(count($matches[1])>=9){
		array_push($thumb,$matches[1][0]);
		array_push($thumb,$matches[1][1]);
		array_push($thumb,$matches[1][2]);
		array_push($thumb,$matches[1][3]);
		array_push($thumb,$matches[1][4]);
		array_push($thumb,$matches[1][5]);
		array_push($thumb,$matches[1][6]);
		array_push($thumb,$matches[1][7]);
		array_push($thumb,$matches[1][8]);
	}
    return $thumb;
}

function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

function tle_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}
//输出友情链接
function printLinks(){
	global $wpdb;
	$friendlinks='';
	$rowsLinks = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."links WHERE link_visible='Y' order by link_rating,link_id,link_updated desc");
	if(count($rowsLinks)>0){
		$friendlinks.='友情链接：';
		foreach($rowsLinks as $value){
			$friendlinks.='<a href="'.$value->link_url.'" target="'.link_target.'" title="'.$value->link_description.'" rel="nofollow '.$value->link_rel.'">'.$value->link_name.'</a>&nbsp;';
		}
	}
	echo $friendlinks;
}
/*获得当前页面URL*/
function curPageURL(){
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on"){
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80"){
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}else{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length) {
	if (function_exists('mb_substr') && function_exists('mb_strlen')) {
		$sub_str = mb_substr($strings, $start, $length, 'utf8');
		return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
	}
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++) {
		if (ord($str[$i]) >= 128)
			$char++;
	}
	$str2 = substr($strings, $start, $length + 1);
	$str3 = substr($strings, $start, $length + 2);
	if ($char % 3 == 1) {
		if ($length <= strlen($strings)) {
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char % 3 == 2) {
		if ($length <= strlen($strings)) {
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char % 3 == 0) {
		if ($length <= strlen($strings)) {
			$str = $str .= '...';
		}
		return $str;
	}
}
if ( ! function_exists( 'tle_views' ) ){
	function tle_record_visitors(){
		if (is_singular()) {
		  global $post;
		  $post_ID = $post->ID;
		  if($post_ID) {
			  $post_views = (int)get_post_meta($post_ID, 'views', true);
			  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
			  {
				add_post_meta($post_ID, 'views', 1, true);
			  }
		  }
		}
	}
	add_action('wp_head', 'tle_record_visitors');
	function tle_views($after=''){
	  global $post;
	  $post_ID = $post->ID;
	  $views = (int)get_post_meta($post_ID, 'views', true);
	  echo $views, $after;
	}
}

if ( ! function_exists( 'tle_paging' ) ){
	function tle_paging() {
		$p = 4;
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; 
		echo '<ul class="am-pagination am-pagination-right">';
		if ( empty( $paged ) ) $paged = 1;
		echo '<li>'; previous_posts_link('上一页'); echo '</li>';

		if ( $paged > $p + 1 ) tle_paging_link( 1, '<li>第一页</li>' );
		if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"am-active\"><span>{$i}</span></li>" : tle_paging_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
		//if ( $paged < $max_page - $p ) tle_paging_link( $max_page, '&raquo;' );
		echo '<li id="tlenextpage">'; next_posts_link('下一页'); echo '</li>';
		// echo '<li><span>共 '.$max_page.' 页</span></li>';
		echo '</ul>';
	}
	function tle_paging_link( $i, $title = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
	}
}

function do_option($e){
	return stripslashes(get_option($e));
}

/**
 * 判断是否通过手机访问
 */
function isMobile(){ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])){ 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array ('nokia',
            'sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod',
            'blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])){ 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
            return true;
        } 
    } 
    return false;
}

//评论样式
function tle_comment_list($comment, $args, $depth) {
	if($comment->comment_parent==0){
		?>
		<li class="am-comment">
			<a href="#link-to-user-home">
				<?=str_replace(' src=', ' data-original=', get_avatar( $comment->comment_author_email, $size = '36'));?>
			</a>
			<div class="am-comment-main">
			  <header class="am-comment-hd">
				<div class="am-comment-meta">
				  <?=$comment->comment_author;?><time datetime="<?=$comment->comment_date;?>" title="<?=$comment->comment_date;?>"><?=$comment->comment_date;?></time>评论
				  <div class="am-fr">
					<a href="javascript:;" class="replyfloor" id="replyfloor<?=get_comment_ID();?>" data-coid="<?php echo get_comment_ID(); ?>" data-author="<?=$comment->comment_author;?>" data-ccreated="<?=$comment->comment_date;?>" data-ctext="<?php echo htmlspecialchars(strip_tags($comment->comment_content)); ?>">回复</a>
					此楼
				  </div>
				</div>
			  </header>
			  <div class="am-comment-bd">
				<p><?=$comment->comment_content;?></p>
				<?php
				global $wpdb,$current_user;
				$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."comments WHERE comment_parent=".get_comment_ID()." AND comment_approved='1' ORDER BY comment_date DESC");
				foreach($rows as $value){
				?>
				<header class="am-comment-hd" style="padding:10px;">
					
					<div class="am-list-item-text">
					  <a href="#link-to-user" class="am-comment-author"><?php echo $value->comment_author; ?></a><time datetime="<?php echo $value->comment_date; ?>" title="<?php echo $value->comment_date; ?>"><?php echo $value->comment_date; ?></time>评论<p><?php echo $value->comment_content; ?></p>
					</div>
					
				</header>
				<?php
				}
				?>
			  </div>
			</div>
		</li>
		<?php
	}
}
?>