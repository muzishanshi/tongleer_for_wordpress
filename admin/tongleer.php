<?php
$themename = $dname.'主题';

$options = array(
    "config_description","config_keywords","config_nav","config_favicon","config_bg",
	"config_headBg","config_headImgUrl","config_nickname","config_follow_links","config_fans_readers","config_follow_qrcode","config_home_name",
	"config_home_link","config_album_name","config_album_link","config_other_1_name","config_other_1_link",
	"config_weiboname","config_address","config_birthday","config_detail","config_foot_info",
	"config_login","config_sex","config_about","config_is_ajax","config_is_pjax","config_is_play",
	"config_is_play_auto","config_is_play_defaultMode","config_playjson",
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
<script src="https://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script>
$(function(){
	$.post("<?php bloginfo('template_url'); ?>/ajax/update.php",{action:"update",version:8},function(data){
		$("#versionCode").html(data);
	});
});
</script>
<div>
    <h2><?php echo $themename; ?>设置</h2>
	<p>
		<small>
		作者：<a href="http://www.tongleer.com/" target="_blank">二呆</a><br />
		版本检测：<span id="versionCode"></span>
		</small>
	</p>

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
					<td>是否开启PJAX无刷新加载</td>
					<td>
						<input type="radio" id="config_is_pjax" name="config_is_pjax" value="y" <?php if(do_option('config_is_pjax')=='y'){?>checked<?php }?>>是
						<input type="radio" id="config_is_pjax" name="config_is_pjax" value="n" <?php if(do_option('config_is_pjax')=='n'){?>checked<?php }?>>否
						（支持pjax评论，但只能评论完一次后返回再继续评论，并且启用后暂不支持发表表情。）
					</td>
				</tr>
				<tr>
					<td>是否开启音乐播放器</td>
					<td>
						<input type="radio" id="config_is_play" name="config_is_play" value="y" <?php if(do_option('config_is_play')=='y'){?>checked<?php }?>>是
						<input type="radio" id="config_is_play" name="config_is_play" value="n" <?php if(do_option('config_is_play')=='n'){?>checked<?php }?>>否
					</td>
				</tr>
				<tr>
					<td>是否开启AJAX分页加载</td>
					<td>
						<input type="radio" id="config_is_ajax" name="config_is_ajax" value="y" <?php if(do_option('config_is_ajax')=='y'){?>checked<?php }?>>是
						<input type="radio" id="config_is_ajax" name="config_is_ajax" value="n" <?php if(do_option('config_is_ajax')=='n'){?>checked<?php }?>>否（暂时与图片放大功能不兼容）
					</td>
				</tr>
				<tr>
					<td>是否自动播放</td>
					<td>
						<input type="radio" id="config_is_play_auto" name="config_is_play_auto" value="true" <?php if(do_option('config_is_play_auto')=='true'){?>checked<?php }?>>自动
						<input type="radio" id="config_is_play_auto" name="config_is_play_auto" value="false" <?php if(do_option('config_is_play_auto')=='false'){?>checked<?php }?>>手动
					</td>
				</tr>
				<tr>
					<td>播放模式</td>
					<td>
						<input type="radio" id="config_is_play_defaultMode" name="config_is_play_defaultMode" value="1" <?php if(do_option('config_is_play_defaultMode')=='1'){?>checked<?php }?>>列表循环
						<input type="radio" id="config_is_play_defaultMode" name="config_is_play_defaultMode" value="2" <?php if(do_option('config_is_play_defaultMode')=='2'){?>checked<?php }?>>随机播放
						<input type="radio" id="config_is_play_defaultMode" name="config_is_play_defaultMode" value="3" <?php if(do_option('config_is_play_defaultMode')=='3'){?>checked<?php }?>>单曲循环
					</td>
				</tr>
				<tr>
					<td>播放器音乐数据</td>
					<td>
						<?php
						$config_playjson=do_option('config_playjson');
						if($config_playjson==''){
							$config_playjson='
								[{
									"title":"花下舞剑",
									"singer":"童可可",
									"cover":"https://img3.kuwo.cn/star/albumcover/240/49/7/2753401394.jpg",
									"src":"http://other.web.rf01.sycdn.kuwo.cn/resource/n1/84/87/3802376964.mp3",
									"lyric":"'.get_bloginfo('template_url').'/assets/smusic/data/tongkeke-huaxiawujian.lrc"
								},{
									"title":"萌二代",
									"singer":"童可可",
									"cover":"https://img3.kuwo.cn/star/albumcover/240/35/65/238194684.jpg",
									"src":"http://other.web.rg01.sycdn.kuwo.cn/resource/n3/21/49/2096701565.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-mengerdai.lrc"
								},{
									"title":"吃货进行曲",
									"singer":"童可可",
									"cover":"https://img3.kuwo.cn/star/albumcover/240/26/34/1695727344.jpg",
									"src":"http://other.web.rh01.sycdn.kuwo.cn/resource/n3/15/72/1780780959.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-chihuojinxingqu.lrc"
								},{
									"title":"小秘密",
									"singer":"童可可",
									"cover":"https://img3.kuwo.cn/star/albumcover/240/55/73/500614479.jpg",
									"src":"http://other.web.rh01.sycdn.kuwo.cn/resource/n1/74/68/3330561514.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-xiaomimi.lrc"
								},{
									"title":"听你爱听的歌",
									"singer":"童可可",
									"cover":"https://img1.kuwo.cn/star/starheads/240/16/85/44330486.jpg",
									"src":"http://other.web.rh01.sycdn.kuwo.cn/resource/n2/80/39/46671518.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-tingniaitingdege.lrc"
								},{
									"title":"别让我放不下",
									"singer":"童可可",
									"cover":"https://img1.kuwo.cn/star/albumcover/240/9/59/996272309.jpg",
									"src":"http://other.web.rh01.sycdn.kuwo.cn/resource/n1/15/60/2541949312.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-bierangwofangbuxia.lrc"
								},{
									"title":"非主恋",
									"singer":"童可可",
									"cover":"https://img4.kuwo.cn/star/albumcover/240/21/10/339989310.jpg",
									"src":"http://other.web.rh01.sycdn.kuwo.cn/resource/n2/34/93/1218459911.mp3",
									"lyric":"'.$row["value"].'/assets/smusic/data/tongkeke-feizhulian.lrc"
								}]
							';
						}
						?>
						<textarea name="config_playjson" id="config_playjson" placeholder="" rows="10" cols="100"><?=$config_playjson;?></textarea><br /><small>自定义歌单需要至少2首，可到<a href="http://api.tongleer.com/music/" target="_blank">http://api.tongleer.com/music/</a>下载歌曲，专辑图片网络有现成的就用现成的，没有就上传微博图床后设置到此处，歌词文件一般酷狗、酷我等软件即可生成。</small>
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
					<td>性别</td>
					<td>
						<input type="radio" id="config_sex" name="config_sex" value="boy" <?php if(do_option('config_sex')=='boy'){?>checked<?php }?>>男
						<input type="radio" id="config_sex" name="config_sex" value="girl" <?php if(do_option('config_sex')=='girl'){?>checked<?php }?>>女
					</td>
				</tr>
				<tr>
					<td>关注链接</td>
					<td>
						<input name="config_follow_links" id="config_follow_links" type="text" value="<?php echo do_option('config_follow_links'); ?>">
						<br /><small>在这里填入头部资料卡关注的链接，一般指向友情链接。</small>
					</td>
				</tr>
				<tr>
					<td>粉丝链接</td>
					<td>
						<input name="config_fans_readers" id="config_fans_readers" type="text" value="<?php echo do_option('config_fans_readers'); ?>">
						<br /><small>在这里填入头部资料卡粉丝的链接，一般指向读者墙。</small>
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
					<td>更多资料</td>
					<td>
						<input type="text" id="config_about" name="config_about" value="<?=do_option('config_about');?>">
					</td>
				</tr>
				<tr>
					<td>底部信息</td>
					<td>
						<textarea name="config_foot_info" id="config_foot_info" placeholder="" rows="2" cols="100"><?=do_option('config_foot_info');?></textarea>
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