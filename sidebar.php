<style>
.web-info{
    margin: 10px 0 0 0;
    font-size: 14px;
    color: #444;
    background-color: #fff;
    padding:8px;
    border: 1px solid #E1E8ED;
    list-style: none;
    overflow: hidden;
}
.web-info li{
    width: 33%;
    text-align: center;
    float: left;
    font-size: 13px;
    letter-spacing: 1px;
}
li.frinum, li.vitnum {
    border-right: 1px solid #EFEFEF;
}
.web-info span{
    display: block;
}
@media screen and (max-width: 960px) {
	.web-info {margin: 0 0 0 0;}
}
</style>
<div class="am-u-md-3 am-u-md-pull-9">
    <div class="am-panel-group">
		<?php 
		if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sitesidebar')) : endif; 

		if (is_single()){
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_postsidebar')) : endif; 
		}else if (is_page()){
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_pagesidebar')) : endif; 
		}else if (is_home()){
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : endif; 
		}else {
			if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_othersidebar')) : endif; 
		}
		?>
    </div>
</div>
