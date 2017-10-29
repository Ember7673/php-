<?php
header("Content-Type:text/html;charset=utf-8");
$connect = mysqli_connect('127.0.0.1','root','123456','text');
mysqli_set_charset($connect,"utf8");
if(!$connect){
    exit("连接数据库失败");
}
$query = mysqli_query($connect,'select * from users');
if(!$query){
    exit("查询失败");
}

if($_SERVER['REQUEST_METHOD'] == 'get'){
  $checkbox = $_GET['checkbox'];
  $checkbox1 = implode(',',$checkbox);
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
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method = "get">
    <h1 class="heading">用户管理 
      <a class="btn btn-link btn-sm" href="add.php">添加</a>
      <input class="btn btn-link btn-sm" type="submit" value="筛选">
      <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){ ?>
      <a class="btn btn-link btn-sm" href="delete.php?id=<?php echo $checkbox1; ?>">删除</a>
      <?php } ?>
    </h1>
    <table class="table table-hover">
      <thead>
        <tr>
          <th><input type="checkbox" name="all" value =""></th>
          <th>#</th>
          <th>头像</th>
          <th>姓名</th>
          <th>性别</th>
          <th>年龄</th>
          <th class="text-center" width="140">操作</th>
        </tr>
      </thead>
      <tbody>
      <?php while($item = mysqli_fetch_assoc($query)): ?>
        <tr>
          <th><input type="checkbox" name="checkbox[]" value = <?php echo $item['id']; ?>></th>
          <th scope="row"><?php echo $item['id']; ?></th>
          <td><img src="<?php echo substr($item['avatar'],6); ?>" class="rounded" alt="<?php echo $item['name'] ?>"></td>
          <td><?php echo $item['name']; ?></td>
          <td><?php echo $item['gender'] == 0 ? '♀' : '♂'; ?></td>
          <td><?php echo $item['birthday']; ?></td>
          <td class="text-center">
            <a href="edit.php?id=<?php echo $item['id']; ?>"><button class="btn btn-info btn-sm">编辑</button></a>
            <a href="delete.php?id=<?php echo $item['id']; ?>"><button class="btn btn-danger btn-sm">删除</button></a>
          </td>
        </tr>
     
      <?php endwhile ?>
      </tbody>
    </table>
    <ul class="pagination justify-content-center">
      <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
    </ul>
  </main>
  </form>
</body>
</html>
