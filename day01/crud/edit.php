<?php
header("Content-Type:text/html;charset=utf8");
//接收要修改的数据id
if(empty($_GET['id'])){
    exit("必须传入指定参数");
}
$id = $_GET['id'];
$connect = mysqli_connect('127.0.0.1','root','123456','text');
if(!$connect){
    exit("数据库连接失败");
}
// 因为id是唯一的，只要找到满足条件的就不再继续了
$query = mysqli_query($connect,"select * from users where id = {$id} limit 1;");

if(!$query){
    exit("数据库查询失败");
}
//从结果集中取得一行作为关联数组
$user = mysqli_fetch_assoc($query);
if(!$user){
    exit("找不到你要编辑的数据");
}

// =========================================================
function edit_user(){
// 取值
$name = $_POST['name'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$id = $_GET['id'];

// 接收文件并验证
if (empty($_FILES['avatar'])) {
  $GLOBALS['error_message'] = '请上传头像';
  return;
}

$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
// => jpg
$target = '../crud/assets/img/' . uniqid() . '.' . $ext;

if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
  $GLOBALS['error_message'] = '上传头像失败';
  return;
}

$avatar = substr($target, 2);

// var_dump($name);
// var_dump($gender);
// var_dump($birthday);
// var_dump($avatar);
// 保存

// 1. 建立连接
$connect = mysqli_connect('localhost', 'root', '123456', 'text');

if (!$connect) {
  $GLOBALS['error_message'] = '连接数据库失败';
  return;
}

// var_dump("insert into users values (null, '{$name}', {$gender}, '{$birthday}', '{$avatar}');");
// 2. 开始查询
$query = mysqli_query($connect, "update users set name='{$name}',gender = '{$gender}', birthday = '{$birthday}', avatar='{$avatar}' where id = $id;");

if (!$query) {
  $GLOBALS['error_message'] = '查询过程失败';
  return;
}

$affected_rows = mysqli_affected_rows($connect);

if ($affected_rows !== 1) {
  $GLOBALS['error_message'] = '添加数据失败';
  return;
}

// 响应
header('Location: 04-index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_user();
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
    <h1 class="heading">编辑“<?php echo $user['name']; ?>”</h1>
    <?php if (isset($error_message)): ?>
    <div class="alert alert-warning">
      <?php echo $error_message; ?>
    </div>
    <?php endif ?>
    <form action="<?php echo 'edit.php?id=' . $id ?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="avatar">头像</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
      </div>
      <div class="form-group">
        <label for="name">姓名</label>
        <input type="text" class="form-control" id="name" value="<?php echo $user['name']; ?>" name="name">
      </div>
      <div class="form-group">
        <label for="gender">性别</label>
        <select class="form-control" id="gender" name="gender">
          <option value="-1">请选择性别</option>
          <option value="1"<?php echo $user['gender'] === '1' ? ' selected': ''; ?>>男</option>
          <option value="0"<?php echo $user['gender'] === '0' ? ' selected': ''; ?>>女</option>
        </select>
      </div>
      <div class="form-group">
        <label for="birthday">生日</label>
        <input type="date" class="form-control" id="birthday" value="<?php echo $user['birthday']; ?>" name="birthday">
      </div>
        <button class="btn btn-primary">保存</button>
    </form>
  </main>
</body>
</html>
