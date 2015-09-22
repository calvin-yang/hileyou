<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|海乐游管理平台</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Facilitator/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Facilitator/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Facilitator/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Facilitator/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Facilitator/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Facilitator/js/jquery.mousewheel.js"></script>
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
    </style>
    <!-- 上传图片插件 end -->
    
</head>
<body>
    <!-- 头部 -->

    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <li <?php if(CONTROLLER_NAME == 'ProList'): ?>class="current"<?php endif; ?>><a href="<?php echo U('pro_list/rmlist');?>">产品</a></li>

            <li <?php if(CONTROLLER_NAME == 'Order'): ?>class="current"<?php endif; ?>><a href="<?php echo U('Order/ordlist');?>">订单</a></li>

            <li <?php if(CONTROLLER_NAME == 'Member'): ?>class="current"<?php endif; ?>><a href="<?php echo U('Member/rmlist');?>">账户</a></li>

            <li <?php if(CONTROLLER_NAME == 'Finance'): ?>class="current"<?php endif; ?>><a href="<?php echo U('Finance/rmlist');?>">财务</a></li>
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
                
                <?php if(CONTROLLER_NAME == 'ProList'): ?><h3><i class="icon icon-unfold"></i>产品管理</h3>
                    <ul class="side-sub-menu">
                        <li class="">
                            <a class="item" href="<?php echo U('pro_list/rmlist');?>">房源列表</a>
                        </li>
                        <li class="">
                            <a class="item" href="<?php echo U('pro_list/eatlist');?>">餐饮列表</a>
                        </li>
                        <li>
                            <a class="item" href="<?php echo U('pro_list/pylist');?>">游玩列表</a>
                        </li>
                        <li>
                            <a class="item" href="<?php echo U('pro_list/relist');?>">路线列表</a>
                        </li>
                    </ul>
                

                <?php elseif(CONTROLLER_NAME == 'Order'): ?>
                    <h3><i class="icon icon-unfold"></i>订单管理</h3>
                    <ul class="side-sub-menu">
                        <li class="">
                            <a class="item" href="<?php echo U('Order/ordlist');?>">订单列表</a>
                        </li>
                    </ul>

                <?php elseif(CONTROLLER_NAME == 'Member'): ?>
                    <h3><i class="icon icon-unfold"></i>账户管理</h3>
                    <ul class="side-sub-menu">
                        <li class="">
                            <a class="item" href="<?php echo U('Member/index');?>">个人中心</a>
                        </li>
                    </ul><?php endif; ?>
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
		<h2>餐饮列表</h2>
	</div>
	<div class="cf">
		<div class="fl">
            <a class="btn" href="<?php echo U('ProList/eatadd');?>">新 增</a>
            <button class="btn ajax-post" url="<?php echo U('ProList/eat_changeStatus',array('method'=>'resumeUser'));?>" target-form="ids">上架</button>
            <button class="btn ajax-post" url="<?php echo U('ProList/eat_changeStatus',array('method'=>'forbidUser'));?>" target-form="ids">下架</button>
            <button class="btn ajax-post confirm" url="<?php echo U('ProList/eat_changeStatus',array('method'=>'deleteUser'));?>" target-form="ids">删 除</button>
        </div>

        <!-- 高级搜索 -->
        <div class="search-form fr cf">
			<div class="sleft">
				<div class="drop-down">
					<span id="sch-sort-txt" class="sort-txt" data="<?php echo ($status); ?>"><?php if(get_status_title($_GET['status']) == ''): ?>所有<?php else: echo get_status_title($_GET['status']); endif; ?></span>
					<i class="arrow arrow-down"></i>
					<ul id="sub-sch-menu" class="nav-list hidden">
						<li><a href="javascript:;" value="">所有</a></li>
						<li><a href="javascript:;" value="1">已上架</a></li>
						<li><a href="javascript:;" value="0">已下架</a></li>
						<li><a href="javascript:;" value="3">待通过</a></li>
						<li><a href="javascript:;" value="4">不通过</a></li>
					</ul>
				</div>
				<input type="text" name="title" class="search-input" value="<?php echo I('title');?>" placeholder="请输入餐饮名称">
				<a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('ProList/eatlist');?>"><i class="btn-search"></i></a>
			</div>
		</div>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
	<table class="">
    <thead>
        <tr>
		<th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
		<th class=""></th>
		<th class="">餐饮店名</th>
		<th class="">餐饮电话</th>
		<th class="">消费(￥)</th>
		<th class="">餐馆类型</th>
		<th class="">营业时间</th>
		<th class="">上传者</th>
		<th class="">状态</th>
		<th class="">操作</th>
		</tr>
    </thead>
    <tbody>
		<?php if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" /></td>
            <?php $img_url = getImgUrl($vo['logo_img_url']); ?>
            <td height="100px"><img src="<?php echo ($img_url)?$img_url[0]['url']:'';?>" width='100px';height='100px'></td>
			<td><?php echo str_cut($vo['foot_name'],20);?> </td>
			<td><?php echo ($vo["foot_tel"]); ?></td>
			<td><?php echo (ceil($vo['favorable_price']) == 0)?$vo['per_capita']:$vo['favorable_price'].'<br /><span style="color:darkgray;"><s>'.$vo['per_capita'].'</s></span>';?> </td>
			<td><?php echo ($vo["type"]); ?></td>
			<td><?php echo ($vo["business_hours"]); ?></td>
			<td><?php echo ($vo['realname'] != "")?$vo['realname']:$vo['nickname'];?></td>
			<td><?php echo ($vo["status_text"]); ?></td>
			<td>
				<a href="<?php echo U('ProList/eatedit?id='.$vo['id']);?>" target="_blank">编辑</a>
				<?php if($vo['status'] == '0'): ?><a href="<?php echo U('ProList/eat_changeStatus?method=resumeUser&id='.$vo['id']);?>" class="ajax-get">上架</a>
				<?php elseif($vo['status'] == '1'): ?>
					<a href="<?php echo U('ProList/eat_changeStatus?method=forbidUser&id='.$vo['id']);?>" class="ajax-get">下架</a><?php endif; ?>
				<a href="<?php echo U('ProList/eat_changeStatus?method=deleteUser&id='.$vo['id']);?>" class="confirm ajax-get">删除</a>
				<!-- <a href="<?php echo U('Vip/delete?id='.$vo['id']);?>" class="confirm ajax-get">删除</a> -->
                </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
    </table> 
	</div>
    <div style="text-align:center;">
        <?php echo ($_page); ?>
    </div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">海乐游</a>管理平台</div>
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
    <script type="text/javascript" src="/Public/Facilitator/js/common.js"></script>
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
                            showimg.append('<div style="float: left;margin-left: 5px;"><span class="dele" protype="product" imgurl="'+up_name+'" proid="'+data.msg.img_id+'" style="float:right;cursor:pointer;" onclick="img_delete(this);">删除</span><img src="'+img+'" width="220px" height = "111px"></div>');
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
    </script>
    
	<script src="/Public/static/thinkbox/jquery.thinkbox.js"></script>

	<script type="text/javascript">
	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
		var status = $("#sch-sort-txt").attr("data");
        var query  = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
        query = query.replace(/^&/g,'');
		if(status != ''){
			query += 'status=' + status + "&" + query;
        }
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
		window.location.href = url;
	});

	/* 状态搜索子菜单 */
	$(".search-form").find(".drop-down").hover(function(){
		$("#sub-sch-menu").removeClass("hidden");
	},function(){
		$("#sub-sch-menu").addClass("hidden");
	});
	$("#sub-sch-menu li").find("a").each(function(){
		$(this).click(function(){
			var text = $(this).text();
			$("#sch-sort-txt").text(text).attr("data",$(this).attr("value"));
			$("#sub-sch-menu").addClass("hidden");
		})
	});
    //导航高亮
    $('.side-sub-menu').find('a[href="<?php echo U('ProList/eatlist');?>"]').closest('li').addClass('current');
	</script>

</body>
</html>