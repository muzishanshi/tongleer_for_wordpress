<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head lang="en">
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <title><?php wp_title('-', true, 'right'); echo get_option('blogname');if (is_home ()) echo ' - '.get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta property="og:image" content="<?php bloginfo('template_url'); ?>/assets/images/w-logo-blue.png"/>
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <meta name="author" content="<?=get_bloginfo('name');?>">
  <meta name="description" itemprop="description" content="<?=do_option('config_description');?>">
  <meta name="keywords" content="<?=do_option('config_keywords');?>">
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" />
  <link rel="alternate icon" href="<?=do_option('config_favicon');?>" type="image/png" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/amazeui.min.css"/>
  <!--[if lt IE 9]>-->
  <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
  <!--[endif]-->
  <!--[if (gte IE 9)|!(IE)]><!-->
  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
  <!--<![endif]-->
  <link href="<?php bloginfo('template_url'); ?>/highlight.css" rel="Stylesheet" type="text/css" />
  <?php wp_head(); ?>
</head>
<body style="background-image: url('<?=do_option('config_bg');?>');">
<style>
.banner-head{
	background-image: url(http://api.tongleer.com/picturebed/img/bg.jpg);
	width:960px;
	margin:10px auto -10px auto;
	text-align: center;
	padding:30px;
	color:#fff;
}
.banner-nav{
	width:960px;
	margin:0px auto 15px auto;
	text-align: center;
	background-color:#fff;
	border:1px solid #eee;
}
.banner-nav button{
	background-color:#fff;
	font-size:90%;
}
@media screen and (max-width: 960px) {
	.banner-head {width: 100%;}
	.banner-nav {width: 100%;}
}
.banner-head a:hover,a:link,a:active,a:visited{
	color:#fff;
}
</style>
<!-- navigation panel -->
<header class="am-topbar am-topbar-fixed-top" style="opacity:0.9;">
  <div class="am-container">
	<h1 class="am-topbar-brand">
	  <a href="<?php bloginfo('url'); ?>"><?=get_bloginfo('name');?></a>
	</h1>
	
	<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only" data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">导航切换</span> <span
        class="am-icon-bars"></span></button>

	<div class="am-topbar-collapse am-collapse" id="collapse-head">
	  <ul class="am-nav am-nav-pills am-topbar-nav">
		  <li><a href="<?php bloginfo('url'); ?>"><span class="am-icon-home"></span>首页</a></li>
		  <?=do_option('config_nav');?>
	  </ul>
	  <?php 
		if( do_option('config_login') ){ 
			global $current_user; 
			get_currentuserinfo();
			$uid = $current_user->ID;
			$u_name = get_user_meta($uid,'nickname',true);
		?>
		<div class="pull-right">
			<?php if(is_user_logged_in()){
				echo '
					<div class="am-topbar-right">
						<div class="am-topbar-btn">
							<span class="am-icon-user"></span><a href="'.site_url('/wp-admin').'">'.$u_name.'</a>
						</div>
					</div>
				';
			}else{
				echo '
					<div class="am-topbar-right">
						<div class="am-topbar-btn">
							<span class="am-icon-user"></span><a href="'.site_url('/wp-login.php').'">登录</a>
						</div>
					</div>
				';
			}; 
			?>
		</div>
	  <?php } ?>
	</div>
  </div>
</header>
<!--end navigation panel -->
<section class="banner-head" style="background-image:url('<?php if(do_option('config_headBg')){echo do_option('config_headBg');}else{echo 'http://api.tongleer.com/picturebed/img/bg.jpg';}?>')">
	<img class="am-circle" src="<?php if(do_option('config_headImgUrl')){echo do_option('config_headImgUrl');}else{echo 'https://cambrian-images.cdn.bcebos.com/39ceafd81d6813a014e747db4aa6f0eb_1524963877208.jpeg';}?>" width="100" height="100"/><br />
	<span>
		<?=do_option('config_nickname');?>
		<?php if(do_option('config_sex')=='boy'){echo "♂";}else{echo "♀";};?>
	</span><br />
	<?php
	global $wpdb;
	$usersnum = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users");
	if (0 < $usersnum) $usersnum= number_format($usersnum);
	$linksnum = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links");
	if (0 < $linksnum) $linksnum= number_format($linksnum);
	?>
	<small>
		<a href="<?=do_option('config_follow_links');?>">关注 <?=$linksnum;?></a>  |  粉丝 <?php echo $usersnum;?>
	</small><br />
	<small><?=get_bloginfo('description');?></small><br />
	<small>微博认证：<?=do_option('config_weiboname');?></small>
	<div>
		<div class="am-dropdown" data-am-dropdown>
		  <button class="am-btn am-btn-warning am-radius am-btn-xs am-dropdown-toggle">关注</button>
		  <div class="am-dropdown-content">
			<img src="<?php if(do_option('config_follow_qrcode')){echo do_option('config_follow_qrcode');}else{echo 'http://me.tongleer.com/content/uploadfile/201706/008b1497454448.png';}?>" width="150" height="150"/>
		  </div>
		</div>
		<button type="button" class="am-btn am-btn-warning am-radius am-btn-xs" onClick="location.href='<?php if(do_option('config_home_link')){echo do_option('config_home_link');}else{echo 'http://www.tongleer.com';}?>';"><?php if(do_option('config_home_name')){echo do_option('config_home_name');}else{echo '主页';}?></button>
		<div class="am-dropdown" data-am-dropdown>
			<button class="am-btn am-btn-warning am-radius am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle><span
        class="am-icon-bars"></span></button>
		  <ul class="am-dropdown-content">
			<li><a href="<?php if(do_option('config_other_1_link')){echo do_option('config_other_1_link');}else{echo 'javascript:;';}?>"><?php if(do_option('config_other_1_name')){echo do_option('config_other_1_name');}else{echo '^_^';}?></a></li>
		  </ul>
		</div>
	</div>
</section>
<div class="banner-nav">
	<div data-am-widget="tabs">
      <ul class="am-tabs-nav">
          <li><a class="am-btn am-radius" href="<?php bloginfo('url'); ?>">主页</a></li>
		  <li><a class="am-btn am-radius" target="_blank" href="<?=do_option('config_album_link');?>"><?php if(do_option('config_album_name')){echo do_option('config_album_name');}else{echo '相册';}?></a></li>
      </ul>
	</div>
</div>