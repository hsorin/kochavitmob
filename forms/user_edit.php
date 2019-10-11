<?php include ('../includes/header.php'); ?>
<?php $user_id = $_SESSION['user_id']; ?>


<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $connection->prepare("SELECT user_full_name, username, user_password, user_role FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($user_full_name, $username, $user_password, $user_role);
        $stmt->fetch();
        $stmt->close();
    }
?>

<?php
    if (isset($_POST['save'])) {
        $error = [
            'user_full_name'=>'',
            'username'=>'',
            'user_password'=>'',
            'user_role'=>''
        ];
        $user_full_name = escape($_POST['user_full_name']);
        $username = escape($_POST['username']);
        $user_password = escape($_POST['user_password']);
        $user_role = escape($_POST['user_role']);

        if ($user_full_name =='') {
            $error['user_full_name'] = 'חובה לרשום שם קצין בטיחות'; }
        if (strlen($username) <6) {
            $error['username'] = 'שם משתמש חייב להכיל מינימום 6 תווים'; }
        if ($username =='') {
            $error['username'] = 'חובה לרשום שם משתמש'; }
        if (strlen($user_password) <6) {
            $error['user_password'] = 'סיסמה חייבת להכיל מינימום 6 תווים'; }
        if ($user_password =='') {
            $error['user_password'] = 'חובה לרשום סיסמה'; }

        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }        
        if (empty($error)) {
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            $stmt = $connection->prepare("UPDATE users SET user_full_name=?, username=?, user_password=?, user_role=? WHERE user_id = ?");
            if (!$stmt->bind_param("sssss", $user_full_name, $username, $user_password, $user_role, $id)){
                echo "Error: <br>".mysqli_error($connection);
            }
            confirm($stmt);
            $stmt->close();
            header('Location: ../users.php');
        }
    }
?>

<div class="container">
    <div class="col-12 col-sm-12 col-md-10">
        <a href="../users.php"><span class="fas fa-arrow-left"></span></a>
        <h4  class="text-right">שינוי פרטים</h4>
        <hr class="colorgraph">
    </div>
</div>

<div class="container text-right">
    <div class="col-12 col-sm-12 col-md-10">
        <form role="form" action="user_edit.php" method="post" id="add_user" enctype="multipart/form-data">
            <div class="row">
               <div class="col-12 col-md-8">
                    <label for="user_full_name"><span class="badge badge-primary"><big>שם קצין הבטיחות:</big></span></label>
                    <input type="text" class="form-control" name="user_full_name" id="user_full_name" value="<?php {echo $user_full_name;} ?>">
                    <h5 style="color:red"><?php echo isset($error['user_full_name']) ? $error['user_full_name'] : '' ?></h5>
                </div>
            </div>                
            <div class="row">
               <div class="col-12 col-md-8">
                    <label for="username"><span class="badge badge-primary"><big>שם משתמש:</big></span></label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php {echo $username;} ?>">
                    <h5 style="color:red"><?php echo isset($error['username']) ? $error['username'] : '' ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <label for="user_password"><span class="badge badge-primary"><big>סיסמה:</big></span></label>
                    <input type="password" class="form-control" name="user_password" id="user_password" value="<?php {echo $user_password;} ?>">
                    <h5 style="color:red"><?php echo isset($error['user_password']) ? $error['user_password'] : '' ?></h5>
                </div>
            </div>
             <div class="row">
                <div class="col-12 col-md-8">
                    <label for="user_role"><span class="badge badge-primary"><big>הרשאה:</big></span></label>
                    <select class="form-control" name="user_role" id="user_role">
                        <?php if ($user_role == 'admin') {
                                echo "<option value='admin'>מנהל</option>";
                                echo "<option value='user'>משתמש</option>";
                            } else {
                                echo "<option value='user'>משתמש</option>";
                                echo "<option value='admin'>מנהל</option>";
                        }  ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row justify-content-md-center">
                <div class="col-10 col-md-6">
                    <input class="btn btn-primary" type="submit" name="save" value="שמור">
                </div>
            </div>
        </form>
    </div>
</div>

<?php  include '../includes/footer.php'; ?>
