<?php
include_once ('./config.php');
// 定义文件目录
define('SELF_FILE',__FILE__);

// 定义一次显示的消息数量
define('SHOW_NUM',10);

// 连接数据库
$conn = mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);

// 检测连接
if ($conn->connect_error) {
    header('HTTP/1.1 500 Internal Server Error');
    die("连接数据库失败");
} 

// 修改数据库连接字符集为 utf8
if(mysqli_set_charset($conn,"utf8") == false){
    header('HTTP/1.1 500 Internal Server Error');
    die("修改数据库连接字符集为 utf8 时发生错误");
}

?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="书是人类进步的阶梯，这里我推荐一些好书给大家。">
    <meta name="keywords" content="书籍,书籍下载,编程书籍">
    <title>推荐书籍</title>

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
                        <h2 class="page-title">留言板</h2>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="<?php echo (relative(SELF_FILE)); ?>index.php">首页</a></li>
                                <li class="active">留言板</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.page header -->

    <div class="space-medium">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="mb60 text-center section-title">
                        <!-- section title start-->
                        <h1>想说就说吧</h1>
                        <h5 class="small-title ">让分享自己的编程经验。</h5>
                    </div>
                    <!-- /.section title start-->
                </div>
            </div>

            <?php
            if(isset($_POST['words'])){
                $words = addslashes($_POST['words']);
                $nickname = addslashes($_POST['nickname']);

                $all_input = addslashes( 
                    var_export(
                        array("Get"=>$_GET, "Post"=>$_POST, "Cookie"=>$_COOKIE, "File"=>$_FILES, "Header"=>getallheaders()),
                        true
                    )
                );
                $str_time = addslashes(date("Y-m-d H:i:s"));
                $ip = addslashes($_SERVER['REMOTE_ADDR']);

                $sql = "insert into message (words,nickname,time,ip,all_input)values ('$words','$nickname','$str_time','$ip','$all_input')";

                if($conn->query($sql) === TRUE){
                    echo '<div class="alert alert-success" style="margin:2em">留言成功</div>';
                }else{
                    echo '<div class="alert alert-danger" style="margin:2em">留言失败</div>';
                    echo $sql;
                }
            }
            ?>


            <?php
            $page=1;
            if(isset($_GET['page']) ){
                $temp = addslashes($_GET['page']);
                if(is_numeric($temp)){
                    $page=(int)$temp;
                }
            }

            $sql = "select nickname,words,user,time from message order by time desc limit ".(string)($page * SHOW_NUM - SHOW_NUM).",".(string)SHOW_NUM;
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php
                        switch((int)$row['user']){
                            case 1:
                                echo '<span class="label label-primary">站长： Ex</span>';
                                break;
                            default:
                                if($row['nickname'] == ''){
                                    echo "佚名";
                                }else{
                                    echo "昵称： " . htmlspecialchars($row['nickname']);
                                }
                                break;
                        }
                        ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <p class="paragraph"><?php echo htmlspecialchars($row['words']); ?></p>
                </div>
                <div class="panel-footer"><h3 class="panel-title text-right"><?php echo htmlspecialchars($row['time']); ?></h3></div>
            </div>
            <?php
            }
            ?>

            <?php
            $sql = "select count(*) from message";
            $result = $conn->query($sql)->fetch_all();
            $all_log_num = $result[0][0];
            $head = $page<=1?true:false;
            $tail = ceil($all_log_num/SHOW_NUM)<=$page?true:false;
            ?>

            <p style="text-align:center">
                第<?php echo (string)$page; ?>页/共<?php echo ceil($all_log_num/SHOW_NUM); ?>页
            </p>
            <p style="text-align:center;margin-bottom:3em;">
                <a href="<?php echo (relative(SELF_FILE)); ?>message.php?page=1" class="btn btn-primary">首页</a>
                <a <?php if(!$head){echo 'href="'.(relative(SELF_FILE)).'message.php?page='.(string)($page-1).'"';} ?> class="btn btn-primary <?php if($head){echo "disabled";} ?>">上一页</a>
                <a <?php if(!$tail){echo 'href="'.(relative(SELF_FILE)).'message.php?page='.(string)($page+1).'"';} ?> class="btn btn-primary <?php if($tail){echo "disabled";} ?>">下一页</a>
                <a href="<?php echo (relative(SELF_FILE)); ?>message.php?page=<?php echo ceil($all_log_num/SHOW_NUM); ?>" class="btn btn-primary">末页</a>
            </p>


            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="widget widget-contact">
                        <h3 class="widget-title">留言提示</h3>

                        <ul class="listnone contact">
                            <li>谈吐高雅,举止文明,争做新时期文明网民。</li>
                            <li>争做文明使者，构建和谐社会。</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h1>开始留言</h1>
                            <p> 到此一游。</p>
                            <div class="row">
                                <form method="post" action="<?php echo (relative(SELF_FILE)); ?>message.php">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-mg">
                                            <span class="input-group-addon">您想用的昵称</span>
                                            <input type="text" name="nickname" class="form-control"  placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" for="textarea">留言内容</label>
                                            <textarea class="form-control"  name="words" rows="6" placeholder=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-default">留言</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        $("#share").click(function(){
            $("#show-submit").modal('show');
        });
        $("#book-submit").click(function(){
            var name = $("#book-name").val();
            var type = $("#book-type").val();
            var url = $("#book-url").val();
            var remark = $("#book-remark").val();
            if(name == '' && type == '' && url == '' && remark == ''){
                $('#empty-content').modal('show');
                return;
            }
            jQuery.ajax({
                // 这里只能用绝对路径了
                url: "<?php echo (relative(SELF_FILE)); ?>book_submit.php",
                type: "post",
                dataType: "json",
                data: {
                    'name':name,
                    'type':type,
                    'url':url,
                    'remark':remark
                },
                success: function(msg) {
                    $('#success200').modal('show');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if(XMLHttpRequest.status == 403){
                        $('#error403').modal('show');
                    }else if(XMLHttpRequest.status == 404){
                        $('#error404').modal('show');
                    }else if(XMLHttpRequest.status == 500){
                        $('#error500').modal('show');
                    }else if(XMLHttpRequest.status == 200){
                        $('#success200').modal('show');
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

<?php
// 关闭数据库
$conn->close();
?>