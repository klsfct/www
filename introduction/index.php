<?php
include_once ('../config.php');
// 定义文件目录
define('SELF_FILE',__FILE__);
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="本站推荐了很多优秀的编程教学视频。">
    <meta name="keywords" content="编程,编程入门,自学编程,编程视频">
    <title>编程入门</title>
    <!-- source_header -->
    <?php include_once(ROOT_DIR.'template/source_header.php'); ?>
</head>

<body>
    <!-- header -->
    <?php include_once(ROOT_DIR.'template/header.php'); ?>

    <div class="page-header" style="background: linear-gradient(rgba(36, 39, 38, 0.5), rgba(36, 39, 38, 0.5)), rgba(36, 39, 38, 0.5) url(<?php echo (relative(SELF_FILE)); ?>images/program.jpg) no-repeat center; background-size: cover; margin: 0; border-bottom: none; padding-bottom: 0px;"><!-- page header -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-caption">
                        <h2 class="page-title">好好学习，天天向上</h2>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="<?php echo (relative(SELF_FILE)); ?>index.php">首页</a></li>
                                <li class="active">编程入门</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.page header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="service-block">
                        <!-- service block -->
                        <div class="service-icon mb20">
                            <!-- service img -->
                            <a href="<?php echo (relative(SELF_FILE)); ?>introduction/c.php"><img src="<?php echo (relative(SELF_FILE)); ?>images/c.png" class="program-icon" alt="C语言"> </a>
                        </div>
                        <!-- service img -->
                        <div class="service-content">
                            <!-- service content -->
                            <h2><a href="<?php echo (relative(SELF_FILE)); ?>introduction/c.php" class="title">C语言</a></h2>
                            <p>Responsive website templates free download html5 with css3 for Hair Salon and Shop website template.</p>
                            <div class="price ">$45</div>
                        </div>
                        <!-- service content -->
                    </div>
                    <!-- /.service block -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="service-block">
                        <!-- service block -->
                        <div class="service-icon mb20">
                            <!-- service img -->
                            <a href="<?php echo (relative(SELF_FILE)); ?>introduction/c++.php"><img src="<?php echo (relative(SELF_FILE)); ?>images/c++.png" class="program-icon" alt="C++"> </a>
                        </div>
                        <!-- service img -->
                        <div class="service-content">
                            <!-- service content -->
                            <h2><a href="<?php echo (relative(SELF_FILE)); ?>introduction/c++.php" class="title">C++</a></h2>
                            <p>Free Responsive HTML5 CSS3 Website Template for hair salon and beauty salon.Lorem ipsum simple dummy content for only presentations.</p>
                            <div class="price">$45</div>
                        </div>
                        <!-- service content -->
                    </div>
                    <!-- /.service block -->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="service-block">
                        <!-- service block -->
                        <div class="service-icon mb20">
                            <!-- service img -->
                            <a href="<?php echo (relative(SELF_FILE)); ?>introduction/java.php" ><img src="<?php echo (relative(SELF_FILE)); ?>images/java.png" class="program-icon" alt="Java"> </div></a>
                        <!-- service img -->
                        <div class="service-content">
                            <!-- service content -->
                            <h2><a href="<?php echo (relative(SELF_FILE)); ?>introduction/java.php"  class="title">Java</a></h2>
                            <p>Responsive website templates free download html with css. Lorem ipsum simple dummy content for only presentations.</p>
                            <div class="price ">$45</div>
                        </div>
                        <!-- service content -->
                    </div>
                    <!-- /.service block -->
                </div>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center"> <a id="show-more" class="btn btn-default"> 查看更多 </a> </div>
            </div>

            <div id="extend"></div>
        </div>
    </div>
    <div class="space-small bg-primary">
        <!-- call to action -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-7 col-md-8 col-xs-12">
                    <h1 class="cta-title">Book your online appointment</h1>
                    <p class="cta-text"> Call to action button example for booking appointment for patients.</p>
                </div>
                <div class="col-lg-4 col-sm-5 col-md-4 col-xs-12">
                    <a href="#" class="btn btn-white btn-lg mt20">Call to action Button</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- footer -->
    <?php include_once(ROOT_DIR.'template/footer.php'); ?>
    
    <!-- source_footer -->
    <?php include_once(ROOT_DIR.'template/source_footer.php'); ?>

    <script> 
    $(document).ready(function(){
        $("#show-more").click(function(){
            jQuery.ajax({
                url: "<?php echo (relative(SELF_FILE)); ?>introduction/show_more.php",
                type: "get",
                success: function(msg) {
                    $("#show-more").remove();
                    $( "#extend" ).html( msg );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if(XMLHttpRequest.status == 403){
                        $('#error403').modal('show');
                    }else if(XMLHttpRequest.status == 404){
                        $('#error404').modal('show');
                    }else if(XMLHttpRequest.status == 500){
                        $('#error500').modal('show');
                    }else{
                        alert("未知错误：" + XMLHttpRequest.status);
                    }
                },
                complete: function(XMLHttpRequest, textStatus) {
                    this; // 调用本次AJAX请求时传递的options参数
                }
            });
        });
    });
    </script>
</body>

</html>
