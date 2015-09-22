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
            <li <?php if(CONTROLLER_NAME == 'Index'): ?>class="current"<?php endif; ?>><a href="<?php echo U('Index/index');?>">首页</a></li>
            <li <?php if(CONTROLLER_NAME == 'ProList'): ?>class="current"<?php endif; ?>><a href="<?php echo U('pro_list/rmlist');?>">产品</a></li>

            <li <?php if(CONTROLLER_NAME == 'Order'): ?>class="current"<?php endif; ?>><a href="<?php echo U('Order/ordlist');?>">订单</a></li>

            <li <?php if(CONTROLLER_NAME == 'User'): ?>class="current"<?php endif; ?>><a href="<?php echo U('User/updatepassword');?>">账户</a></li>

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
                <?php if(CONTROLLER_NAME == 'User'): ?><h3><i class="icon icon-unfold"></i>账户管理</h3>
                    <ul class="side-sub-menu">
                        <li class="">
                            <a class="item" href="<?php echo U('user/updatepassword');?>">修改密码</a>
                        </li>
                        <li class="">
                            <a class="item" href="<?php echo U('user/updatenickname');?>">修改昵称</a>
                        </li>
                    </ul>
                <?php elseif(CONTROLLER_NAME == 'ProList'): ?>
                    <h3><i class="icon icon-unfold"></i>产品管理</h3>
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
        <h2>订单号:<?php echo ($info["order_number"]); ?></h2>
    </div>
    <!-- <div class="cf">
        <div class="fl">
            <button class="btn ajax-post confirm" url="<?php echo U('Order/ord_changeStatus',array('method'=>'deleteUser'));?>" target-form="ids">删 除</button>
        </div>
    </div> -->
    <!-- 数据列表 -->
    <div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
        <th class=""></th>
        <th class="">名称</th>
        <th class="">数量</th>
        <th class="">单价</th>
        <th class="">总价</th>
        <th class="">折扣价</th>
        <th class="">产品类型</th>
        <th class="">状态</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td><?php echo ($info["pro_name"]); ?> </td>
            <td><?php echo ($info["number"]); ?></td>
            <td>x&nbsp;&nbsp;<?php echo ($info["unit_price"]); ?></td>
            <td><?php echo ($info["total_price"]); ?></td>
            <td><?php echo ($info["discount_price"]); ?></td>
            <td><?php echo ($info["title"]); ?></td>
            <td><?php echo ($info["status_text"]); ?></td>
        </tr>
        <tr>
            <td colspan="8">
                <div style="margin-bottom: 20px;">
                    使用积分：&nbsp;&nbsp;&nbsp;<?php echo intval($info['score']);?><br />
                    积分折扣(￥)：&nbsp;&nbsp;&nbsp;<?php echo ($info["score_price"]); ?>
                    <hr />
                </div>
                <?php if($info['pro_type'] == 2): ?><div style="margin-bottom: 20px;">
                        代金券折扣(￥)：&nbsp;&nbsp;&nbsp;<?php echo intval($info['voucher_price']);?>&nbsp;&nbsp;x&nbsp;&nbsp;<?php echo intval($info['voucher']);?>张
                        <hr />
                    </div><?php endif; ?>
                <?php if($info['uid'] == 1): ?><div style="margin-bottom: 20px;">商家：海乐游管理员<hr /></div>
                <?php else: ?>
                    <div style="margin-bottom: 20px;">
                        商家姓名：<?php echo ($memberInfo["realname"]); ?><br />
                        商家联系电话：<?php echo ($memberInfo["pro_tel"]); ?>/<?php echo ($memberInfo["tel"]); ?><br />
                        商家注册手机号：<?php echo ($memberInfo["mobile"]); ?><br />
                        商家身份证号码：<?php echo ($memberInfo["IDcard"]); ?><br />
                        <hr />
                    </div><?php endif; ?>
                <div style="margin-bottom: 20px;">
                    购买者姓名：<?php echo ($info["name"]); if($vip['status']): ?>(<?php echo ($vip["msg"]); ?>)<?php endif; ?><br />
                    购买者联系电话：<?php echo ($info["tel"]); ?><br />
                    购买者注册手机号：<?php echo ($buyerInfo["mobile"]); ?><br />
                    购买者身份证号码：<?php echo ($info["IDcard"]); ?><br />
                    购买者下单时间：<?php echo time_format($info['insert_time']);?><br />
                    <hr />
                </div>
                <?php if($vip['status']): ?>vip类型：<?php echo ($vip["vip_name"]); ?><br />
                    vip状态：<?php echo ($vip["status_msg"]); ?><br />
                    vip开始时间：<?php echo ($vip["start_date"]); ?><br />
                    vip结束时间：<?php echo ($vip["end_date"]); ?><br />
                    <hr /><?php endif; ?>
                <div style="margin-bottom: 20px;">
                    <?php if($info['pro_type'] == 1): ?>人数：<?php echo ($info["adult"]); ?><br />
                        天数：<?php echo ($info["number"]); ?>
                        开始时间：<?php echo time_format($info['start_time'],'Y-m-d');?><br />
                        结束时间：<?php echo time_format($info['end_time'],'Y-m-d');?><br />
                    <?php elseif($info['pro_type'] == 2): ?>
                        数量：<?php echo ($info["number"]); ?><br />
                        开始时间：<?php echo time_format($info['start_time'],'Y-m-d H:i');?><br />
                    <?php elseif($info['pro_type'] == 3): ?>
                        数量：<?php echo ($info["number"]); ?><br />
                        开始时间：<?php echo time_format($info['start_time'],'Y-m-d');?><br />
                    <?php elseif($info['pro_type'] == 4): ?>
                        人数：<?php echo ($info["number"]); ?><br />
                        出发地点：<?php echo ($info["starting_city"]); ?><br />
                        开始时间：<?php echo time_format($info['start_time'],'Y-m-d');?><br />
                    <?php elseif($info['pro_type'] == 5): ?>
                        数量：<?php echo ($info["number"]); endif; ?>
                    
                </div>
            </td>
        </tr>
    </tbody>
    </table> 
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
    //导航高亮
    $('.side-sub-menu').find('a[href="<?php echo U('Order/ordlist');?>"]').closest('li').addClass('current');
    </script>

</body>
</html>