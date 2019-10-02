<img src="https://ws3.sinaimg.cn/large/ecabade5ly1ftt995wyw3j211i0hkh5v.jpg">

# TleWeiboForWordPress是一个Wordpress版本的WeiboForWordPress微博主题

本主题为作者个人原创，使用了Amaze UI中国首个开源 HTML5 跨屏前端框架制作。<br />
因为WeiboForWordPress微博模板主题是快速移植，所以肯定会有一些问题，不过功能都基本实现，可以使用一些日常发表功能。<br />
欢迎Emlog用户和Typecho用户使用下载Github上作者另外2款相同的微博主题。<br />
1、<a href="https://github.com/muzishanshi/tongleer">WeiboForTypecho微博主题</a><br />
2、<a href="https://github.com/muzishanshi/tongleer_for_emlog">WeiboForEmlog微博模板主题</a><br />

程序有可能会遇到bug不改版本号直接修改代码的时候，所以扫描以下二维码关注公众号“同乐儿”，可直接与作者二呆产生联系，不再为bug烦恼，随时随地解决问题。

<img src="http://me.tongleer.com/content/uploadfile/201706/008b1497454448.png">

# 主题特点
 - 模拟微博主页，适合自媒体站长使用。

 - 可自定义昵称、头像、简介、认证信息等信息

# 使用教程
 - 将本主题里的所有文件放在您网站目录的usr/themes内，注意文件夹名字必须为tongleer。

 - 后台->外观->启用本主题->进入设置外观内填写信息

 - 本主题限个人使用，公开发布请注明原作者：二呆，及链接：http://www.tongleer.com

 - 如果你喜欢这个主题，别忘记给我打赏哦：http://me.tongleer.com/qitao/index.php?payChannel=alipay

# 官方演示
http://www.tongleer.com

# 使用问题
 - 如果遇到bug或者使用问题，欢迎给我来email：diamond@tongleer.com
 
 - 作者使用的是php5.6开发，所以如果遇到php版本问题无法使用，请更换php5.6即可。
 
 - 如果您有何意见建议，欢迎告知作者，您的支持是作者无限的动力！

 - 1元入群：http://joke.tongleer.com/328.html

# 版本记录
2019-10-02 1.0.8

	修复因加载cloudflare的layer.js失效导致的bug。

2019-03-22 1.0.3

	修复了因cdn.bootcss.com中JS静态资源不可访问导致的js失效的问题。
	
2018-12-30 v1.0.6：

	1、修正pjax评论，使它不再是摆设，可以一直无刷新浏览，但不支持连续评论，可评论一次后返回继续评论，不过不会影响音乐播放器的连续播放，并且启用后暂不支持发表表情。
	2、音乐播放器新增后台可设置歌单。
	
2018-12-30 V1.0.5：

	1、优化评论为侧滑评论形式等，但那3个开关依然没有完善；
	2、此侧滑评论支持邮件通知功能，需手动在function.php中添加如下代码：
	
	```php
	//使用smtp发邮件
	if(!function_exists('mail_smtp')){
		function mail_smtp( $phpmailer ) {
			$phpmailer->IsSMTP();
			$phpmailer->From = "android@tongleer.com"; //发件人
			$phpmailer->FromName = "同乐儿"; //发件人昵称
			$phpmailer->SMTPAuth = true;//启用SMTPAuth服务
			$phpmailer->Port = 465;//MTP邮件发送端口，这个和下面的对应，如果这里填写25，则下面为空白//企业465
			$phpmailer->SMTPSecure ="";//是否验证 ssl，这个和上面的对应，如果不填写，则上面的端口须为25//ssl
			$phpmailer->Host = "ssl://smtp.exmail.qq.com";//邮箱的SMTP服务器地址，如果是QQ的则为：smtp.exmail.qq.com
			$phpmailer->Username = "android@tongleer.com";//你的邮箱地址
			$phpmailer->Password ="ly159357";//你的邮箱登陆密码
		}
		add_action('phpmailer_init', 'mail_smtp');
	}
	/* comment_mail_notify v1.0 by willin kan. (所有回复都发邮件) */
	function comment_mail_notify($comment_id) {
	  $comment = get_comment($comment_id);
	  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	  $spam_confirmed = $comment->comment_approved;
	  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
		$wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出点, no-reply 可改为可用的 e-mail.
		$to = trim(get_comment($parent_id)->comment_author_email);
		$subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
		$message = '
		<div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
		  <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
		  <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
		   . trim(get_comment($parent_id)->comment_content) . '</p>
		  <p>' . trim($comment->comment_author) . ' 给您的回复:<br />'
		   . trim($comment->comment_content) . '<br /></p>
		  <p>您可以点击 查看回复完整內容</p>
		  <p>欢迎再度光临 ' . get_option('blogname') . '</p>
		  <p>(此邮件由系统自动发送，请勿回复.)</p>
		</div>';
		  $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		  $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		  wp_mail( $to, $subject, $message, $headers );
	  }
	}
	add_action('comment_post', 'comment_mail_notify');
	```
	
v1.0.4：<br />
	新增更多分类支持到三级导航<br />
	修复个别页面及文章页内容显示方式<br />
	修改评论头像大小、新增评论支持5个层级。
	
v1.0.3：<br />
	新增侧边栏最新评论、最新粉丝、最新文章、查看更多资料页面、热门文章图文结合、横向彩色标签显示<br />
	新增微博头部添加性别、关注数、粉丝数、微博认证名称<br />
	优化评论框大小和评论列表中子评论的内边距<br />
	新增PJAX无刷新加载（未完善）<br />
	新增音乐播放器（修改歌单只能手动修改文件）<br />
	新增AJAX分页加载<br />
	增加文章列表分享按钮<br />
	新增可手动添加友情链接并显示<br />
	新增文章列表可显示优酷视频<br />
	移除谷歌字体<br />
	编辑器增强
	
v1.0.2：优化了相册页面的显示方式：时间归档、增加标题时间、AJAX分页加载等。
v1.0.1：第一个版本降世