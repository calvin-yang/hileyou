<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|海乐游管理平台</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->

    <!-- chosen start -->
    <script src="/Public/Admin/chosen/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
      </script>
    <link rel="stylesheet" href="/Public/Admin/chosen/chosen.css">
      <!-- chosen end -->

    <!-- 上传图片插件 start -->
    <script type="text/javascript" src="/Public/jquery.form.js"></script>
    <style>
    .demo{width:620px;}
    .demo p{line-height:32px}
    .btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
    .progress { position:relative; margin-left:100px; margin-top:-24px; width:200px;padding: 1px; border-radius:3px; display:none}
    .bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
    .percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
    .files{height:22px; line-height:22px; margin:10px 0}

    .model{  
            position: absolute; 
            z-index: 1003;   
            width:500px; 
            height:300px;   
            background-color:peru; 
            display: none;  
        } 

        span.tan {
                    text-align:center;
                    float: right;
                    display: block;
                    border: solid 1px;
                    width: 20px;
                    height: 20px;
                    cursor:pointer;
                }
        .model .cento {
            margin-top: 20px;
            margin-left: 20px;
        }
        .percent{color: coral;}
        .progress{width: 80%;}
    </style>
    <!-- 上传图片插件 end -->
    
</head>
<body>
    <!-- 头部 -->
    <?php $__base_menu__ = $__controller__->getMenus(); ?>
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__base_menu__["main"])): $i = 0; $__LIST__ = $__base_menu__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__base_menu__); endif; ?>
                <?php if(is_array($__base_menu__["child"])): $i = 0; $__LIST__ = $__base_menu__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<!-- 标题栏 -->
	<div class="main-title">
		<h2>用户列表</h2>
	</div>
	<div class="cf">
		<div class="fl">
            <a class="btn" href="<?php echo U('User/add');?>">新 增</a>
            <button class="btn ajax-post" url="<?php echo U('User/changeStatus',array('method'=>'resumeUser'));?>" target-form="ids">启 用</button>
            <button class="btn ajax-post" url="<?php echo U('User/changeStatus',array('method'=>'forbidUser'));?>" target-form="ids">禁 用</button>
            <button class="btn" url="" onclick="setDivCenter('0','#model')" target-form="ids">发送通知</button>
            <button class="btn ajax-post confirm" url="<?php echo U('User/changeStatus',array('method'=>'deleteUser'));?>" target-form="ids">删 除</button>
        </div>

        <!-- 高级搜索 -->
		<div class="search-form fr cf">
			<div class="sleft">
				<input type="text" name="mobile" class="search-input" value="<?php echo I('mobile');?>" placeholder="请输入手机号">
				<a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('index');?>"><i class="btn-search"></i></a>
			</div>
		</div>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
	<table class="">
    <thead>
        <tr>
		<th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
		<th class="">UID</th>
		<th class="">手机号</th>
		<th class="">积分</th>
		<th class="">登录次数</th>
		<th class="">最后登录时间</th>
		<th class="">最后登录IP</th>
		<th class="">类型</th>
		<th class="">状态</th>
		<th class="">操作</th>
		</tr>
    </thead>
    <tbody>
		<?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input class="ids" type="checkbox" name="id[]" uid="<?php echo ($vo["uid"]); ?>" value="<?php echo ($vo["uid"]); ?>" /></td>
			<td><?php echo ($vo["uid"]); ?> </td>
			<td><?php echo ($vo['mobile'] == '')?$vo['nickname']:$vo['mobile'];?></td>
			<td><?php echo ($vo["score"]); ?></td>
			<td><?php echo ($vo["login"]); ?></td>
			<td><span><?php echo (time_format($vo["last_login_time"])); ?></span></td>
			<td><span><?php echo long2ip($vo['last_login_ip']);?></span></td>
			<td>
				<?php if($vo['type'] == 1): ?>会员
				<?php elseif($vo['type'] == 2): ?>
					服务商

				<?php elseif($vo['type'] == 4): ?>
					VIP<?php endif; ?>
			</td>
			<td><?php echo ($vo["status_text"]); ?></td>
			<td>
				<a href="<?php echo U('User/edit?uid='.$vo['uid']);?>" target="_blank">编辑</a>
				<?php if(($vo["status"]) == "1"): ?><a href="<?php echo U('User/changeStatus?method=forbidUser&id='.$vo['uid']);?>" class="ajax-get">禁用</a>
				<?php else: ?>
				<a href="<?php echo U('User/changeStatus?method=resumeUser&id='.$vo['uid']);?>" class="ajax-get">启用</a><?php endif; ?>
				<a href="<?php echo U('User/changeStatus?method=deleteUser&id='.$vo['uid']);?>" class="confirm ajax-get">删除</a>

				<a href="javascript:;" onclick="setDivCenter(<?php echo $vo['uid'];?>,'#model')">发送通知</a>
                </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
    </table> 
	</div>
    <div class="page">
        <?php echo ($_page); ?>
    </div>
	
	<!-- 发送信息窗口 -->
    <div>  
	    <div id="model" class="model">  
	        <span class="tan" onclick="setDivHidden('#model')">X</span>
	        <div class="cento">
	        	<form action="<?php echo U('sendMessgae');?>" method="post" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-item cf">
			            <label class="item-label">发送理由<span class="check-tips"></span></label>
			            <div class="controls">
			                <label class="textarea input-large">
			                    <textarea class="message_text" name="message_text"></textarea>
			                </label>
			            </div>
			        </div>


			        <div class="form-item cf">
			            <label class="item-label">发送类型<span class="check-tips"></span></label>
			            <div class="controls">
			                <div class="radio">
			                  <label>
			                    <input type="radio" name="type" id="type" value="1" >
			                    &nbsp;短 信
			                  </label>&nbsp;&nbsp;
			                  <label>
			                    <input type="radio" name="type" id="type" value="2" checked>
			                    &nbsp;邮 箱
			                  </label>&nbsp;&nbsp;
			                </div>
			            </div>
			        </div>
					
					<div class="form-item">
						<input type="hidden" name="uid" class="uid" value="" />
			            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">发 送</button>
			            
			        </div>

	        	</form>
	        </div>  
	    </div>  
	</div> 

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/index.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(".html", "")
                .replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)/, "");
            $subnav.find("a[href^='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>

    <!-- 图片上传 -->
    <script type="text/javascript">

        function img_upload(_this,_type){
            //_type 上传一张/多张图片（1：一张；2：多张）
            var _html = $(_this).parent().html();
            var url = $(_this).attr("upUrl");
            var par = $(_this).parent().parent().parent();
            var bar = par.find('.bar');//$('.bar');
            var percent = par.find('.percent');
            var showimg = par.parent().find('#showimg');
            var progress = par.find(".progress");
            var files = par.find(".files");
            var btn = par.find(".btn span");
            percent.html('');
            $(_this).wrap("<form id='myupload' action="+url+" method='post' enctype='multipart/form-data'></form>");
            $("#myupload").ajaxSubmit({
                dataType:  'json',
                beforeSend: function() {
                    progress.show();
                    // var percentVal = '0%';
                    // bar.width(percentVal);
                    // percent.html(percentVal);
                    $(_this).parent().html(_html);
                    //btn.html("上传中...");
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    // var percentVal = percentComplete + '%';
                    // bar.width(percentVal);
                    // percent.html(percentVal);
                },
                success: function(data) {
                    if(data.status == '1'){
                        var img = data.msg.info;
                        var up_name = $(_this).attr("at");
                        var delete_img_url = "<?php echo U('Product/img_delete');?>";
                        if(_type == '1'){
                            showimg.html("<div style='float: left;margin-left: 5px;'><img src='"+img+"' width='220px' height = '111px'></div>");
                            $("#"+up_name).val(data.msg.img_id);
                            par.find('.img_up').html(_html);
                            par.find('.up_str').text('重新上传');
                        }else{
                            showimg.append('<div style="float: left;margin-left: 5px;"><span class="dele" img_delete="'+delete_img_url+'" protype="product" imgurl="'+up_name+'" proid="'+data.msg.img_id+'" style="float:right;cursor:pointer;" onclick="img_delete(this);">删除</span><img src="'+img+'" width="220px" height = "111px"></div>');
                            var a = $("#"+up_name).val();
                            $("#"+up_name).val(a+data.msg.img_id+",");
                            par.find('.img_up').html(_html);
                            par.find('.up_str').text('继续上传');
                        }
                        
                    }else{
                        percent.html(data.info);
                        par.find('.img_up').html(_html);
                        par.find('.up_str').text('重新上传');
                    }
                },
                error:function(xhr){
                    par.find('.img_up').html(_html);
                    // btn.html("重新上传");
                    bar.width('0')
                    files.html(xhr.responseText);
                }
            });
        
        }
        function img_delete(_this){
            var img_url = String($(_this).attr("proid")+',');
            var imgurl = $(_this).attr('imgurl');
            var imgurlval = $("#"+imgurl).val();
            data = imgurlval.replace(img_url,'');
            $("#"+imgurl).val(data);
            $(_this).parent().remove();
            
            
        }

     //让指定的DIV始终显示在屏幕正中间   
    function setDivCenter(_id,divName){
        if(_id == '0'){
            jqchk();
            if($('.uid').val() == "")
                return false;
        }else{
            $('.uid').val(_id);
        }
        
        var top = ($(window).height() - $(divName).height())/2;   
        var left = ($(window).width() - $(divName).width())/2;   
        var scrollTop = $(document).scrollTop();   
        var scrollLeft = $(document).scrollLeft();   
        $(divName).css( { position : 'absolute', 'top' : top + scrollTop, left : left + scrollLeft } ).show(); 
    }
    // 隐藏指定的DIV
    function setDivHidden(divName){
        $('.uid').val('');
        $('.message_text').val('');
        $(divName).css({'display':'none'});
    }

    function jqchk(){ //jquery获取复选框值 
        var chk_value =[]; 
        $('.ids:checked').each(function(){ 
            chk_value.push($(this).attr('uid')); 
            }); 
            if(chk_value.length==0){
                alert('你还没有选择任何内容！');
                return false;
            }else{
                $('.uid').val(chk_value);
            } 
        } 
    </script>
    
	<script src="/Public/static/thinkbox/jquery.thinkbox.js"></script>

	<script type="text/javascript">
	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
        var query  = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
        query = query.replace(/^&/g,'');
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
		window.location.href = url;
	});
	//回车搜索
	$(".search-input").keyup(function(e){
		if(e.keyCode === 13){
			$("#search").click();
			return false;
		}
	});
	 
    //导航高亮
    $('.side-sub-menu').find('a[href="<?php echo U('User/index');?>"]').closest('li').addClass('current');
	</script>

</body>
</html>