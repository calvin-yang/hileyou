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
            

            

    <div class="main-title">
        <h2><?php echo ($info['id']?'编辑':'新增'); ?>文章</h2>
    </div>
    
    <form action="<?php echo $info['id']?U('inforedit'):U('inforadd');?>" method="post" class="form-horizontal">

        <div class="form-item cf">
            <label class="item-label">标题<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large " name="title" value="<?php echo ($info["title"]); ?>">
            </div>
        </div>
		
        
        <div class="form-item cf">
            <label class="item-label">文章封面图 *<span class="check-tips"></span></label>
            <div class="controls">
                <div id="main">
                   <div class="demo">
                        <div class="btn">
                            <span class="up_str">上传图片</span>
                             <span class="img_up"><input type="file" name="img" upUrl="<?php echo U('Home/imgUplode',array('type'=>'news'));?>" at="logo_img_url" onchange="img_upload(this,'1');"></span>
                            <input id="logo_img_url" type="hidden" name="logo_img_url" value="<?php echo ($info["logo_img_url"]); ?>" />
                        </div>
                        <div class="progress">
                            <span class="bar"></span><span class="percent">0%</span >
                        </div>
                        <div class="files"></div>
                   </div>
                   <?php $img_url = getImgUrl($info['logo_img_url']); ?>
            
                   <div class="col-md-12 column" id="showimg"><?php if(!empty($info["logo_img_url"])): ?><div style='float: left;margin-left: 5px;'><img src="<?php echo ($img_url)?$img_url[0]['url']:'';?>" width='220px' height = '111px'></div><?php endif; ?></div>
                </div>
            </div>
        </div>
        
        
        <div class="form-item cf">
            <label class="item-label">内容<span class="check-tips"></span></label>
       		<div class="controls">
       		<textarea name="content" id="myEditor" style="width:800px;height:500px;"><?php echo ($info["content"]); ?></textarea>
       		</div>
        </div>
        
        <div class="form-item cf">
            <label class="item-label">所属类型<span class="check-tips"></span></label>
            <div class="controls">
               <select class="chzn-select" id="type" name="type">
                   <option value="">--请选择--</option>
                    <?php if($sort_list != false): if(is_array($sort_list)): $i = 0; $__LIST__ = $sort_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($info['news_sort_id']) == $vo['id']): ?>selected<?php endif; ?>>┯<?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php if($vo['sorts'] != false): if(is_array($vo['sorts'])): $i = 0; $__LIST__ = $vo['sorts'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vos["id"]); ?>" <?php if(($info['news_sort_id']) == $vos['id']): ?>selected<?php endif; ?>>└<?php echo ($vos["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endif; endif; ?>
               </select>
            </div>
        </div>
        
        
        <div class="form-item cf">
            <label class="item-label">所在地<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large " name="address" value="<?php echo ($info["address"]); ?>">
            </div>
        </div>
        


        <div class="form-item cf">
            <label class="item-label">排序<span class="check-tips"></span></label>
            <div class="controls">
                <input type="number" class="text input-large " name="ord" value="<?php echo ($info["ord"]); ?>">
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">是否置顶<span class="check-tips"></span></label>
            <div class="controls">
                <div class="radio">
                  <label>
                    <input type="radio" name="stick" id="stick" value="0" <?php if(!isset($info['stick']) || $info['stick'] == '0'): ?>checked<?php endif; ?>>
                    &nbsp;否
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="stick" id="stick" value="1" <?php if(($info['stick']) == "1"): ?>checked<?php endif; ?> >
                    &nbsp;是
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                
                </div>
                
            </div>
        </div>
        
        <div class="form-item cf">
            <label class="item-label">状态<span class="check-tips"></span></label>
            <div class="controls">
                <div class="radio">
                  <label>
                    <input type="radio" name="status" id="status" value="1" <?php if(!isset($info['status']) || $info['status'] == 1): ?>checked<?php endif; ?>>
                    &nbsp;发布
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="status" id="status" value="0" <?php if(($info['status']) == "0"): ?>checked<?php endif; ?> >
                    &nbsp;禁用
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                
                </div>
                
            </div>
        </div>

         

 		
        <div class="form-item">
            <input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <a href="<?php echo U('inforList');?>"><button class="btn btn-return" type="button">返 回</button></a>
        </div>
    </form>

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
    
	<script src="/Public/ueditor/ueditor.config.js"></script>
	<script src="/Public/ueditor/ueditor.all.js"></script>
    <script type="text/javascript">
       	UE.getEditor('myEditor');
        //导航高亮
        $('.side-sub-menu').find('a[href="<?php echo U('Home/inforlist');?>"]').closest('li').addClass('current');
    </script>

</body>
</html>