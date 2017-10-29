<?php
header("Content-Type:text/html;charset=utf8");
function add_user(){
    //验证非空
    if(empty($_POST['name'])){
        $GLOBALS['message'] = '请输入姓名';
        return;
    }
    if(!(isset($_POST['gender']) && $_POST['gender'] !== '-1')){
      $GLOBALS['message'] = '请输入性别';
      return;
    }
    if(empty($_POST['birthday'])){
        $GLOBALS['message'] = '请输入出生日期';
        return;
    }
    // 取值
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    var_dump($gender);
    $birthday = $_POST['birthday'];
    // 接收文件并验证大小和格式
    if(empty($_FILES['avatar'])){
        $GLOBALS['message'] = '请上传头像';
        return;
    }
    //获取上传文件的后缀名
    // var_dump($_FILES['avatar']);
    $ext = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION); 
    // var_dump($ext);
    $target = '../crud/assets/img/' . uniqid() . '.' . $ext;
    if(!move_uploaded_file($_FILES['avatar']['tmp_name'],$target)){
        $GLOBALS['message'] = '上传头像失败';
        return;
    }
    $avatar = substr($target,2);

    // 建立连接
    $connect = mysqli_connect('127.0.0.1','root','123456','text');
    if(!$connect){
      $GLOBALS['message'] = '查询过程失败';
      return;
    }
    $query = mysqli_query($connect,"insert into users values (null,'{$name}','{$gender}','{$birthday}','{$avatar}');");

    if(!$query){
      $GLOBALS['message'] = '添加数据失败';
      return;
    }
    $affected_rows = mysqli_affected_rows($connect);
    
      if ($affected_rows !== 1) {
        $GLOBALS['message'] = '添加数据失败';
        return;
      }
    // 响应，跳转页面
    header("Location: 04-index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    add_user();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>XXX管理系统</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">XXX管理系统</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">用户管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">商品管理</a>
      </li>
    </ul>
  </nav>
  <main class="container">
    <h1 class="heading">添加用户</h1>
    <?php if (isset($message)): ?>
    <div class="alert alert-warning">
      <?php echo $message; ?>
    </div>
    <?php endif ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="avatar">头像</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
      </div>
      <div class="form-group">
        <label for="name">姓名</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="gender">性别</label>
        <select class="form-control" id="gender" name="gender">
          <option value="-1">请选择性别</option>
          <option value="1">男</option>
          <option value="0">女</option>
        </select>
      </div>
      <div class="form-group">
        <label for="birthday">生日</label>
        <input type="date" class="form-control" id="birthday" name="birthday">
      </div>
      <a href="edit.php?id=34"><button class="btn btn-info btn-sm">编辑</button></a>
      <button class="btn btn-primary">保存</button>
    </form>
  </main>
</body>
</html>