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
//谷歌字体移除
function remove_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );
//增强编辑器开始
function add_editor_buttons($buttons) {
$buttons[] = 'fontselect';
$buttons[] = 'fontsizeselect';
$buttons[] = 'cleanup';
$buttons[] = 'styleselect';
$buttons[] = 'hr';
$buttons[] = 'del';
$buttons[] = 'sub';
$buttons[] = 'sup';
$buttons[] = 'table';
$buttons[] = 'copy';
$buttons[] = 'paste';
$buttons[] = 'cut';
$buttons[] = 'undo';
$buttons[] = 'image';
$buttons[] = 'anchor';
$buttons[] = 'backcolor';
$buttons[] = 'wp_page';
$buttons[] = 'charmap';
return $buttons;
}
add_filter("mce_buttons_3", "add_editor_buttons");
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
	?>
	<style>
	.friendlink{margin:0 auto;width:calc(100% - 100px);}
	@media screen and (max-width:calc(100% - 100px);) {
		.friendlink{width: calc(100% - 100px);}
	}
	</style>
	<?php
	global $wpdb;
	$friendlinks='';
	$rowsLinks = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."links WHERE link_visible='Y' AND link_rating!=0 order by link_rating,link_id,link_updated desc");
	if(count($rowsLinks)>0){
		$friendlinks.='<div class="friendlink"><marquee direction="up" behavior="scroll" scrollamount="1" scrolldelay="10" loop="-1" onMouseOver="this.stop()" onMouseOut="this.start()" width="100%" height="30" style="text-align:center;">友情链接：';
		foreach($rowsLinks as $value){
			$friendlinks.='<a href="'.$value->link_url.'" target="'.$value->link_target.'" title="'.$value->link_description.'" rel="nofollow '.$value->link_rel.'">'.$value->link_name.'</a>&nbsp;';
		}
		$friendlinks.='</marquee></div>';
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
//隐藏admin Bar
add_filter('show_admin_bar','__return_false');
/*侧滑评论开始*/
//自动勾选 
function tle_add_checkbox() {
  echo '<label for="comment_mail_notify" class="checkbox inline" style="padding-top:0"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}
//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}
function tle_comment_list($comment, $args, $depth) {
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //头像
  $host = 'https://secure.gravatar.com';
  $url = '/avatar/';
  $size = '50';
  $rating = 'g';
  $hash = md5(strtolower($comment->comment_author_email));
  $avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
  echo '<div class="c-avatar">';
  //echo str_replace(' src=', ' data-original=', get_avatar( $comment->comment_author_email, $size = '36' , $avatar)); 
  echo '<img src="'.$avatar.'" />';
  echo '</div>';
  //内容
  echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
	echo str_replace(' src=', ' data-original=', convert_smilies(get_comment_text()));
	if ($comment->comment_approved == '0'){
	  echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
	}
	//信息
	echo '<div class="c-meta">';
		echo '<span class="c-author">'.get_comment_author_link().'</span>';
		echo get_comment_time('Y-m-d H:i '); echo time_ago(); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
		echo edit_comment_link(__('(编辑)'),' - ','');
		} 
	echo '</div>';
  echo '</div>';
}
/*侧滑评论结束*/
?>