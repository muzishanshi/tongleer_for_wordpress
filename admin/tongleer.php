<?php
$themename = $dname.'主题';

$options = array(
    "config_description","config_keywords","config_nav","config_favicon","config_bg",
	"config_headBg","config_headImgUrl","config_nickname","config_follow_qrcode","config_home_name",
	"config_home_link","config_album_name","config_album_link","config_other_1_name","config_other_1_link",
	"config_weiboname","config_address","config_birthday","config_detail","config_foot_info",
	"config_login"
);

function mytheme_add_admin() {
    global $themename, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                update_option( $value, $_REQUEST[ $value ] ); 
            }
            header("Location: admin.php?page=tongleer.php&saved=true");
            die;
        }
    }
    add_theme_page($themename." Options", $themename."设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $themename, $options;
    $i=0;
    if ( $_REQUEST['saved'] ) echo '<div><p>'.$themename.'修改已保存</p></div>';
?>
<style>
table td,th{background-color:#fff;}
</style>
<div>
    <h2><?php echo $themename; ?>设置
        <span>作者：<a href="http://www.tongleer.com/" target="_blank">二呆</a></span>
    </h2>

	<form method="post">
		<table border="0" cellpadding="1" cellspacing ="1" bgcolor="#eee">
			<thead>
				<tr>
					<th width="200"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>网站描述</td>
					<td>
						<textarea name="config_description" id="config_description" type="textarea" rows="2" cols="100"><?php echo do_option('config_description'); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>网站关键字</td>
					<td>
						<input type="text" id="config_keywords" name="config_keywords" value="<?php echo do_option('config_keywords'); ?>">
					</td>
				</tr>
				<tr>
					<td>用户登录信息</td>
					<td>
						<input type="checkbox" id="config_login" name="config_login" <?php if(do_option('config_login')) echo 'checked="checked"' ?>>开启
					</td>
				</tr>
				<tr>
					<td>顶部导航链接</td>
					<td>
						<?php
						$config_nav=do_option('config_nav');
						if($config_nav==''){
							$config_nav='<li><a href="" target=_blank>导航1</a></li><li><a href="" target=_blank>导航2</a></li><li><a href="" target=_blank>导航3</a></li>';
						}
						?>
						<textarea name="config_nav" id="config_nav" placeholder="" rows="2" cols="100"><?=$config_nav;?></textarea><br /><small>在这里填入需要添加的顶部导航链接代码，如：&lt;li&gt;&lt;a href=http://baidu.com target=_blank&gt;百度&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=http://qq.com target=_blank&gt;腾讯&lt;/a&gt;&lt;/li&gt;</small>
					</td>
				</tr>
				<tr>
					<td>自定义favicon图标</td>
					<td>
						 <input name="config_favicon" id="config_favicon" type="text" value="<?php echo do_option('config_favicon'); ?>">
					</td>
				</tr>
				<tr>
					<td>网页背景图片</td>
					<td>
						<input type="text" id="config_bg" name="config_bg" value="<?=do_option('config_bg');?>">
					</td>
				</tr>
				<tr>
					<td>资料卡背景图片</td>
					<td>
						<input type="text" id="config_headBg" name="config_headBg" value="<?=do_option('config_headBg');?>">
					</td>
				</tr>
				<tr>
					<td>头像地址</td>
					<td>
						<input name="config_headImgUrl" id="config_headImgUrl" type="text" value="<?=do_option('config_headImgUrl');?>">
					</td>
				</tr>
				<tr>
					<td>昵称</td>
					<td>
						<input type="text" id="config_nickname" name="config_nickname" value="<?=do_option('config_nickname');?>">
					</td>
				</tr>
				<tr>
					<td>关注二维码url</td>
					<td>
						<input name="config_follow_qrcode" id="config_follow_qrcode" type="text" value="<?php echo do_option('config_follow_qrcode'); ?>">
						<br /><small>在这里填入头部资料卡关注的二维码图片地址</small>
					</td>
				</tr>
				<tr>
					<td>主页</td>
					<td>
						<input type="text" id="config_home_name" name="config_home_name" value="<?=do_option('config_home_name');?>">
						<br /><small>在这里填入头部资料卡关注的二维码图片地址</small>
					</td>
				</tr>
				<tr>
					<td>主页链接</td>
					<td>
						<input type="text" id="config_home_link" name="config_home_link" value="<?=do_option('config_home_link');?>">
						<br /><small>在这里填入头部资料卡关注右侧按钮的链接，如：http://www.tongleer.com</small>
					</td>
				</tr>
				<tr>
					<td>相册名称</td>
					<td>
						<input type="text" id="config_album_name" name="config_album_name" value="<?=do_option('config_album_name');?>">
						<br /><small>在这里填入自定义相册页面的名称，如：相册，模板page_album.php即为相册模板，只需建立独立页面即可。</small>
					</td>
				</tr>
				<tr>
					<td>相册链接</td>
					<td>
						<input name="config_album_link" id="config_album_link" type="text" value="<?=do_option('config_album_link');?>">
						<br /><small>在这里填入自定义相册页面的链接，模板page_album.php即为相册模板，只需建立独立页面即可。</small>
					</td>
				</tr>
				<tr>
					<td>资料卡更多下第一行名称</td>
					<td>
						<input type="text" id="config_other_1_name" name="config_other_1_name" value="<?=do_option('config_other_1_name');?>">
					</td>
				</tr>
				<tr>
					<td>资料卡更多下第一行名称的链接</td>
					<td>
						<input type="text" id="config_other_1_link" name="config_other_1_link" value="<?=do_option('config_other_1_link');?>">
					</td>
				</tr>
				<tr>
					<td>微博认证资料名称</td>
					<td>
						<input type="text" id="config_weiboname" name="config_weiboname" value="<?=do_option('config_weiboname');?>">
					</td>
				</tr>
				<tr>
					<td>地区</td>
					<td>
						<input type="text" id="config_address" name="config_address" value="<?=do_option('config_address');?>">
					</td>
				</tr>
				<tr>
					<td>生日</td>
					<td>
						<input type="text" id="config_birthday" name="config_birthday" value="<?=do_option('config_birthday');?>">
					</td>
				</tr>
				<tr>
					<td>简介</td>
					<td>
						<input type="text" id="config_detail" name="config_detail" value="<?=do_option('config_detail');?>">
					</td>
				</tr>
				<tr>
					<td>底部信息</td>
					<td>
						<?php
						$config_foot_info=do_option('config_foot_info');
						if($config_foot_info==''){
							$config_foot_info='<p>友情链接：<a href="" target=_blank>链接1</a> <a href="" target=_blank>链接2</a></p>';
						}
						?>
						<textarea name="config_foot_info" id="config_foot_info" placeholder="" rows="2" cols="100"><?=$config_foot_info;?></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div>
							<input name="save" type="submit" value="保存设置">
						</div>
						<input type="hidden" name="action" value="save">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script>
var aaa = []
jQuery('.d_wrap input, .d_wrap textarea').each(function(e){
    if( jQuery(this).attr('id') ) aaa.push( jQuery(this).attr('id') )
})
console.log( aaa )
</script>
<?php } ?>
<?php add_action('admin_menu', 'mytheme_add_admin');?>