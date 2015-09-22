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
            

            

    <div class="main-title">
        <h2><?php echo ($info['id']?'编辑':'新增'); ?>餐饮</h2>
    </div>
    
    <form action="/index.php?s=/pro_list/eatedit/id/8.html" method="post" class="form-horizontal">

        <div class="form-item cf">
            <label class="item-label">餐饮封面图 *<span class="check-tips"></span></label>
            <div class="controls">
                <div id="main">
                   <div class="demo">
                        <div class="btn">
                            <span class="up_str">上传图片</span>
                             <span class="img_up"><input type="file" name="img" upUrl="<?php echo U('ProList/imgUplode',array('type'=>'eat'));?>" at="logo_img_url" onchange="img_upload(this,'1');"></span>
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
            <label class="item-label">餐饮图片<span class="check-tips"></span></label>
            <div class="controls">
                <div id="main">
                   <div class="demo">
                        <div class="btn">
                            <span class="up_str">上传图片</span>
                            <span class="img_up"><input type="file" name="img" upUrl="<?php echo U('ProList/imgUplode',array('type'=>'eat'));?>" at="foot_img_url" dele="" onchange="img_upload(this,'2');"></span>
                            <input id="foot_img_url" type="hidden" name="foot_img_url" value="<?php echo ($info["foot_img_url"]); ?>" />
                        </div>
                        <div class="progress">
                            <span class="bar"></span><span class="percent">0%</span >
                        </div>
                        <div class="files"></div>
                   </div>
                   <div class="col-md-12 column" id="showimg">
                        <?php if($info['foot_img_url'] != ''){ $imgUrl = getImgUrl($info['foot_img_url']); foreach($imgUrl as $hel_img_list){ echo "<div style='float: left;margin-left: 5px;'><span class='dele' img_delete='".U('ProList/img_delete')."' protype='eat2' imgurl='foot_img_url' proid='".$hel_img_list['id']."' style='float:right;cursor:pointer;' onclick='img_delete(this);'>删除</span><img src='".$hel_img_list['url']."' class='img' width='220px' height = '111px'></div>"; } } ?>
                       
                   </div>
                </div>
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">环境图片<span class="check-tips"></span></label>
            <div class="controls">
                <div id="main">
                   <div class="demo">
                        <div class="btn">
                            <span class="up_str">上传图片</span>
                            <span class="img_up"><input type="file" name="img" upUrl="<?php echo U('ProList/imgUplode',array('type'=>'eat'));?>" at="environment_img_url" dele="" onchange="img_upload(this,'2');"></span>
                            <input id="environment_img_url" type="hidden" name="environment_img_url" value="<?php echo ($info["environment_img_url"]); ?>" />
                        </div>
                        <div class="progress">
                            <span class="bar"></span><span class="percent">0%</span >
                        </div>
                        <div class="files"></div>
                   </div>
                   <div class="col-md-12 column" id="showimg">
                        <?php if($info['environment_img_url'] != ''){ $imgUrl = getImgUrl($info['foot_img_url']); foreach($imgUrl as $environment_img_list){ echo "<div style='float: left;margin-left: 5px;'><span class='dele' img_delete='".U('ProList/img_delete')."' protype='eat1' imgurl='environment_img_url' proid='".$environment_img_list['id']."' style='float:right;cursor:pointer;' onclick='img_delete(this);'>删除</span><img src='".$environment_img_list['url']."' class='img' width='220px' height = '111px'></div>"; } } ?>
                       
                   </div>
                </div>
            </div>
        </div>

        


        <div class="form-item cf">
            <label class="item-label">餐饮店名<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large " name="foot_name" value="<?php echo ($info["foot_name"]); ?>">*
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">营业时间<span class="check-tips"></span></label>
            <div class="controls">
                <input type="time" class="text input-large " style="width:100px" name="business_hours1" value="<?php echo ($info["business_hours1"]); ?>">-
                <input type="time" class="text input-large " style="width:100px" name="business_hours2" value="<?php echo ($info["business_hours2"]); ?>">
            </div>
        </div>
        
        
        <div class="form-item cf">
            <label class="item-label">餐饮电话<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large " name="foot_tel" value="<?php echo ($info["foot_tel"]); ?>">*
            </div>
        </div>


        <div class="form-item cf">
            <label class="item-label">餐饮类型<span class="check-tips"></span></label>
            <div class="">
                <select style="width: 300px" class="chzn-select" id="type" name="type">
                    <?php if(is_array($eat_type_list['name'])): $i = 0; $__LIST__ = $eat_type_list['name'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>" <?php if($info["type"] == $vo): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>*
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">省份<span class="check-tips"></span></label>
            <div class="">
                <select style="width: 300px" class="chzn-select" id="provinces" name="provinces">
                        <option value="">--请选择--</option>
                </select>
            </div>
        </div>
        <!-- 市 -->
        <div class="form-item cf city"></div>
        <!-- 区 -->
        <div class="form-item cf county"></div>

        <div class="form-item cf">
            <label class="item-label">所在地址<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large " name="address" value="<?php echo ($info["address"]); ?>">*
            </div>
        </div>
        
        
        <div class="form-item cf">
            <label class="item-label">附近交通<span class="check-tips"></span></label>
            <div class="controls">
                <label class="textarea input-large">
                    <textarea name="nearby_traffic"><?php echo ((isset($info["nearby_traffic"]) && ($info["nearby_traffic"] !== ""))?($info["nearby_traffic"]):''); ?></textarea>
                </label>
            </div>
        </div>
        


        <div class="form-item cf">
            <label class="item-label">(￥)消费<span class="check-tips"></span></label>
            <div class="controls">
                <input type="number" class="text input-large price" name="per_capita" value="<?php echo ((isset($info["per_capita"]) && ($info["per_capita"] !== ""))?($info["per_capita"]):0); ?>">*
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">(￥)优惠价<span class="check-tips">(0：无优惠价)</span>
                <input type="number" class="text input-large " name="zhekou" value="0"  style="width:50px;" oninput="OnInput (this,event)" onpropertychange="OnPropChanged (this,event)" >%
            </label>
            <div class="controls">
                <input type="number" class="text input-large favorable_price" name="favorable_price" value="<?php echo ((isset($info["favorable_price"]) && ($info["favorable_price"] !== ""))?($info["favorable_price"]):0); ?>">
            </div>
        </div>


        <!-- vip价 start -->
        <?php if(is_array($vip_list)): $i = 0; $__LIST__ = $vip_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-item cf">
                <label class="item-label">(%折)<?php echo ($vo["name"]); ?>价<span class="check-tips">(0：无vip价)</span></label>
                <div class="controls">
                    <input type="number" class="text input-large " name="vip[]" value="<?php echo $vo['discount'];?>">
                    <input type="hidden" class="text input-large " name="vip_id[]" value="<?php echo ($vo["id"]); ?>">
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <!-- vip价 end-->

        <div class="form-item cf">
            <label class="item-label">(￥)现金劵<span class="check-tips">(/一百元)</span></label>
            <div class="controls">
                <input type="number" class="text input-large" name="voucher" value="<?php echo ($info["voucher"]); ?>">*
            </div>
        </div>

        <div class="form-item cf">
            <label class="item-label">现金券有效时间<span class="check-tips"></span></label>
            <div class="controls date" id="datetimepicker" style="display:inline-block">
                <input type="text" id="time-end" name="effective_time" class="text input-large" value="<?php echo time_format($info['effective_time'],'Y-m-d');?>" placeholder="有效时间" />
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>

        

        <div class="form-item cf">
            <label class="item-label">排序<span class="check-tips"></span></label>
            <div class="controls">
                <input type="number" class="text input-large " name="sort" value="<?php echo ($info["sort"]); ?>">
            </div>
        </div>
        

        <div class="form-item">
            <input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>

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
    
     <!-- 日历插件 -->
    <link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
    <link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <!-- 日历插件 -->

    <script type="text/javascript">

        // 运用日历插件
        $('#datetimepicker').datetimepicker({
           format: 'yyyy-mm-dd',
            language:"zh-CN",
            minView:2,
            autoclose:true,
            pickerPosition:'bottom-left'
        });
        
        $("#submit").click(function(){
            $("#facilities").val($("#facilitie").val());
        });

       	
        //导航高亮
        $('.side-sub-menu').find('a[href="<?php echo U('ProList/eatlist');?>"]').closest('li').addClass('current');
        // 然后在select元素上启用chose
        jQuery("#facilitie").chosen({disable_search_threshold: 5});
        jQuery("#type").chosen({disable_search_threshold: 5});
        jQuery("#bed_type").chosen({disable_search_threshold: 5});
        
        function img_delete(_this){
            var img_url = $(_this).parent().find('.img').attr('src');
            var img_delete_url = $(_this).attr('img_delete');
            var id = "<?php echo $_GET['id'];?>";
            $(_this).parent().remove();
            $.ajax({
                url : img_delete_url,
                data : {'img_url' : img_url,'type' : 'ProList','id' : id},
                type : 'POST',
                success : function(data){
                    
                    $("#hel_img_url").val(data);
                }

            });
        };


        $("document").ready(function(){
            var provinces = "<?php echo $info['provinces'];?>";
            var citys = "<?php echo $info['citys'];?>";
            var countys = "<?php echo $info['countys'];?>";
            $.ajax({
                type: "get",
                url: "<?php echo U('Region/action');?>", // type=1表示查询省份
                data: {"parent_id": "1", "type": "1"},
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, item) {
                        $("#provinces").append("<option value='" + item.region_id + "'>" + item.region_name + "</option>");
                    });
                    $("#provinces").val(provinces);
                    jQuery("#provinces").chosen({disable_search_threshold: 5});
                }
            });

            $.ajax({
                type: "get",
                url: "<?php echo U('Region/action');?>", // type =2表示查询市
                data: {"parent_id": provinces, "type": "2"},
                dataType: "json",
                success: function(data) {
                    $(".city").html('<label class="item-label">市区<span class="check-tips"></span></label><div class=""><select style="width: 300px" class="chzn-select" id="citys" name="citys" onchange="citys_change(this);"><option value="">--请选择--</option></select></div>');
                    $.each(data, function(i, item) {
                        $("#citys").append("<option value='" + item.region_id + "'>" + item.region_name + "</option>");
                    });
                    $("#citys").val(citys);
                    jQuery("#citys").chosen({disable_search_threshold: 5});
                }
            });

            $.ajax({
                type: "get",
                url: "<?php echo U('Region/action');?>", // type =2表示查询市
                data: {"parent_id": citys, "type": "3"},
                dataType: "json",
                success: function(data) {
                    $(".county").html('<label class="item-label">县区<span class="check-tips"></span></label><div class=""><select style="width: 300px" class="chzn-select" id="countys" name="countys"><option value="">--请选择--</option></select></div>');
                    $.each(data, function(i, item) {
                        $("#countys").append("<option value='" + item.region_id + "'>" + item.region_name + "</option>");
                    });
                    $("#countys").val(countys);
                    jQuery("#countys").chosen({disable_search_threshold: 5});
                }
            });

        });

        $("#provinces").change(function() {
            $.ajax({
                type: "get",
                url: "<?php echo U('Region/action');?>", // type =2表示查询市
                data: {"parent_id": $(this).val(), "type": "2"},
                dataType: "json",
                success: function(data) {
                    $(".city").html('<label class="item-label">市区<span class="check-tips"></span></label><div class=""><select style="width: 300px" class="chzn-select" id="citys" name="citys" onchange="citys_change(this);"><option value="">--请选择--</option></select></div>');
                    $.each(data, function(i, item) {
                        $("#citys").append("<option value='" + item.region_id + "'>" + item.region_name + "</option>");
                    });

                    jQuery("#citys").chosen({disable_search_threshold: 5});
                }
            });
        });

        function citys_change(_this){
            $.ajax({
                type: "get",
                url: "<?php echo U('Region/action');?>", // type =2表示查询市
                data: {"parent_id": $(_this).val(), "type": "3"},
                dataType: "json",
                success: function(data) {
                    $(".county").html('<label class="item-label">县区<span class="check-tips"></span></label><div class=""><select style="width: 300px" class="chzn-select" id="countys" name="countys"><option value="">--请选择--</option></select></div>');
                    $.each(data, function(i, item) {
                        $("#countys").append("<option value='" + item.region_id + "'>" + item.region_name + "</option>");
                    });
                    jQuery("#countys").chosen({disable_search_threshold: 5});
                }
            });
        }
    </script>

     <script type="text/javascript">
    // Firefox, Google Chrome, Opera, Safari, Internet Explorer from version 9
        function OnInput (_this,event) {
            var price = $(".price").val();

            if(price != ""){
                var favorable_price = price * ($(_this).val()/100);
                $('.favorable_price').val(favorable_price);
            }
        }
    // Internet Explorer
        function OnPropChanged (_this,event) {
            if (event.propertyName.toLowerCase () == "value") {
                var price = $(".price").val();
                if($price != ""){
                    var favorable_price = price * $(_this).val();
                    $('favorable_price').val(favorable_price);
                }
            }
        }
    </script>


</body>
</html>