<?php
session_start();
$conection = new mysqli('localhost','root','0810','restaurant');
$msg="";
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    $sql = "SELECT * FROM users WHERE username=? AND password=? AND user_type=?";
    $stmt = $conection->prepare($sql);
    $stmt->bind_param("sss",$username,$password,$userType);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    session_regenerate_id();
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['user_type'];
    session_write_close();
    if($result->num_rows==1 && $_SESSION['role']=="student"){
        header("location:student.php");
    }
    else if($result->num_rows==1 && $_SESSION['role']=="teacher"){
        header("location:teacher.php");
    }
    else if($result->num_rows==1 && $_SESSION['role']=="admin"){
        header("location:admin.php");
    }
    else{
        $msg = "Username or password in Incorrect!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi User Role Based Login System</title>
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-light mt-5 px-0">
                <h3 class="text-center text-light bg-danger p-3">Multi User Role Login System</h3>
                <form action="<?= $_SERVER['PHP_SELF']?>" method="post" class="p-4">
                    <div class="form-group mb-3">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                    </div>
                    <div class="form-group lead mb-3">
                        <label for="userType">I'm a :</label>
                        <input type="radio" name="userType" value="student" class="custom-radio" required>&nbsp;Student |
                        <input type="radio" name="userType" value="teacher" class="custom-radio" required>&nbsp;Teacher |
                        <input type="radio" name="userType" value="admin" class="custom-radio" required>&nbsp;Admin |
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-danger form-control form-control-lg">
                    </div>
                    <h5 class="text-danger text-center"><?= $msg;?></h5>
                </form>
            </div>
        </div>
    </div> 
</body>
</html>