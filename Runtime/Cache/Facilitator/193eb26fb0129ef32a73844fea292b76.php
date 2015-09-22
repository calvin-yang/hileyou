<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ((isset($meta_title) && ($meta_title !== ""))?($meta_title):'OneThink后台管理'); ?></title>
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
    <!--<![endif]-->
</head>
<body class="index-body">
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
        

    <!-- 主体 -->
    <div id="indexMain" class="index-main">
       
    </div>

    <!-- 底部版权 -->
    <div class="cont-ft">
        <div class="copyright"> ©2013 <a href="http://www.topthink.net">topthink.net</a> 上海顶想信息科技有限公司版权所有</div>
    </div>

    <script type="text/javascript">
        +function(){
            var $window = $(window);
            $window.resize(function(){
                $("#indexMain").css("min-height", $window.height() - 120);
            }).resize();

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

            /* 插件块关闭操作 */
            $(".title-opt .wm-slide").each(function(){
                $(this).click(function(){
                     $(this).closest(".columns-mod").find(".bd").toggle();
                    $(this).find("i").toggleClass("mod-up");
                });
            })
        }();
    </script>
</body>
</html>