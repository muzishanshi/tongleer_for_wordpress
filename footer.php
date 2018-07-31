<!-- footer -->
<footer class="am-footer am-footer-default">
	<a style="position:fixed;right: 50px;bottom: 50px;" href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up" id="amz-go-top"></a>
	<div class="am-footer-miscs ">
		<?=printLinks();?>
    </div>
    <div class="am-footer-miscs ">
        <p>
			CopyRight©2018 <a href="<?php bloginfo('url'); ?>"><?=bloginfo('name');?></a>
		</p>
    </div>
	<div class="am-footer-miscs ">
		<!--尊重以下网站版权是每一个合法公民应尽的义务，请不要去除以下版权。-->
		<p>
			Powered by <a href="https://cn.wordpress.org/" title="WordPress" target="_blank" rel="nofollow">WordPress</a> Theme By <a id="rightdetail" href="http://www.tongleer.com" title="同乐儿" target="_blank">同乐儿</a>
		</p>
    </div>
	<div style="display:none;"><?=do_option('config_foot_info');?></div>
</footer>
<!--pjax刷新开始-->
<?php if(do_option('config_is_pjax')=='y'){?>
<style>
.pjax_loading {position: fixed;top: 45%;left: 45%;display: none;z-index: 999999;width: 124px;height: 124px;background: url('<?php echo get_template_directory_uri(); ?>/assets/images/pjax_loading.gif') 50% 50% no-repeat;}
.pjax_loading1 {position: fixed;top: 0;left: 0;z-index: 999999;display: none;width: 100%;height: 100%;opacity: .2}
</style>
<script src="http://cdn.bootcss.com/jquery.pjax/1.9.5/jquery.pjax.min.js"></script>
<script type="text/javascript" language="javascript">
$(function() {
	$(document).pjax('a[target!=_blank]', '#content', {fragment:'#content', timeout:6000});
	$(document).on('submit', 'form[id!=loginForm][id!=comment-form][id!=reply-form]', function (event) {
		$.pjax.submit(event, '#content', {fragment:'#content', timeout:6000});
	});
	$(document).on('pjax:send', function() {
		$(".pjax_loading,.pjax_loading1").css("display", "block");
	});
	$(document).on('pjax:complete', function() {
		$(".pjax_loading,.pjax_loading1").css("display", "none");
	});
});
</script>
<div class="pjax_loading"></div>
<div class="pjax_loading1"></div>
<?php }?>
<!--pjax刷新结束-->
<!--音乐播放器开始-->
<?php if(do_option('config_is_play')=='y'){?>
<link href="http://apps.bdimg.com/libs/fontawesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/smusic/css/smusic.css"/>
<div class="grid-music-container f-usn" id="music">
	<a id="hidemusic" href="#" onClick="doAct();"><i class="fa fa-music suo"></i></a>
    <div class="m-music-play-wrap">
        <div class="u-cover"></div>
        <div class="m-now-info">
            <h1 class="u-music-title"><strong>标题</strong><small>歌手</small></h1>
            <div class="m-now-controls">
                <div class="u-control u-process">
                    <span class="buffer-process"></span>
                    <span class="current-process"></span>
                </div>
                <div class="u-control u-time">00:00/00:00</div>
                <div class="u-control u-volume">
                    <div class="volume-process" data-volume="0.50">
                        <span class="volume-current"></span>
                        <span class="volume-bar"></span>
                        <span class="volume-event"></span>
                    </div>
                    <a class="volume-control"></a>
                </div>
            </div>
            <div class="m-play-controls">
                <a class="u-play-btn prev" title="上一曲"></a>
                <a class="u-play-btn ctrl-play play" title="暂停"></a>
                <a class="u-play-btn next" title="下一曲"></a>
                <a class="u-play-btn mode mode-list current" title="列表循环"></a>
                <a class="u-play-btn mode mode-random" title="随机播放"></a>
                <a class="u-play-btn mode mode-single" title="单曲循环"></a>
            </div>
        </div>
    </div>
    <div class="f-cb">&nbsp;</div>
    <div class="m-music-list-wrap" style="display:none;"></div>
    <div class="m-music-lyric-wrap" style="display:none;">
        <div class="inner">
            <ul class="js-music-lyric-content">
                <li class="eof">暂无歌词...</li>
            </ul>
        </div>
    </div>
</div>
<script>
function doAct(){
	var s=document.getElementById('hidemusic');
	var t = document.getElementById('music'),
	c = s.className;
	if(c != null && c.indexOf('more') > -1){
		s.className = c.replace('more', '');
		t.className = t.className.replace('grid-music-container-active', '');
	}else{
		s.className = c + ' more';
		t.className = t.className + ' grid-music-container-active';
		var t=setTimeout("doAct()",5000);
	}
}
</script>
<script>
/*
 * 自定义歌单需要至少2首，可到http://api.tongleer.com/music/下载歌曲；
 * 专辑图片网络有现成的就用现成的，没有就上传微博图床后设置到此处，歌词文件一般酷狗、酷我等软件即可生成。
 */
var musicList = [
    {
        title : '花下舞剑',
        singer : '童可可',
        cover  : 'http://img3.kuwo.cn/star/albumcover/240/49/7/2753401394.jpg',
        src    : 'http://other.web.rf01.sycdn.kuwo.cn/resource/n1/84/87/3802376964.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-huaxiawujian.lrc"
    },
    {
        title : '萌二代',
        singer : '童可可',
        cover  : 'http://img3.kuwo.cn/star/albumcover/240/35/65/238194684.jpg',
        src    : 'http://other.web.rg01.sycdn.kuwo.cn/resource/n3/21/49/2096701565.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-mengerdai.lrc"
    },
    {
        title : '吃货进行曲',
        singer : '童可可',
        cover  : 'http://img3.kuwo.cn/star/albumcover/240/26/34/1695727344.jpg',
        src    : 'http://other.web.rh01.sycdn.kuwo.cn/resource/n3/15/72/1780780959.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-chihuojinxingqu.lrc"
    },
    {
        title : '小秘密',
        singer : '童可可',
        cover  : 'http://img3.kuwo.cn/star/albumcover/240/55/73/500614479.jpg',
        src    : 'http://other.web.rh01.sycdn.kuwo.cn/resource/n1/74/68/3330561514.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-xiaomimi.lrc"
    },
    {
        title : '听你爱听的歌',
        singer : '童可可',
        cover  : 'http://img1.kuwo.cn/star/starheads/240/16/85/44330486.jpg',
        src    : 'http://other.web.rh01.sycdn.kuwo.cn/resource/n2/80/39/46671518.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-tingniaitingdege.lrc"
    },
    {
        title : '别让我放不下',
        singer : '童可可',
        cover  : 'http://img1.kuwo.cn/star/albumcover/240/9/59/996272309.jpg',
        src    : 'http://other.web.rh01.sycdn.kuwo.cn/resource/n1/15/60/2541949312.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-bierangwofangbuxia.lrc"
    },
    {
        title : '非主恋',
        singer : '童可可',
        cover  : 'http://img4.kuwo.cn/star/albumcover/240/21/10/339989310.jpg',
        src    : 'http://other.web.rh01.sycdn.kuwo.cn/resource/n2/34/93/1218459911.mp3',
		lyric  : "<?php echo get_template_directory_uri(); ?>/assets/smusic/data/tongkeke-feizhulian.lrc"
    }
];
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/smusic/js/smusic.js"></script>
<script>
   new SMusic({
        musicList : musicList,
        autoPlay  : false,  /*是否自动播放*/
        defaultMode : 2,   /*默认播放模式，随机*/
        callback   : function (obj) {  /*返回当前播放歌曲信息*/
            console.log(obj);
        }
    });
</script>
<?php }?>
<!--音乐播放器结束-->
<!--[if lt IE 9]>-->
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/amazeui.ie8polyfill.min.js"></script>
<!--[endif]-->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/amazeui.widgets.helper.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/amazeui.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/app.js"></script>
</body>
</html>