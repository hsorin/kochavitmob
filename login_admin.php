<?php  include 'includes/header.php'; ?>
<?php define("ROOT", dirname(__FILE__)); ?>

<?php
if ((isset($_POST['submitU'])) or (isset($_POST['submitT'])) or (isset($_POST['submitC'])))  {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);
    if ($username && $password) {
        $stmt = $connection->prepare("SELECT user_id, user_password FROM users WHERE username = ? && user_role = 'admin'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                $user_password = $row['user_password'];
                if (password_verify($password, $user_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $stmt->close();
                    if ($_POST['submitU']) {
                        header('Location:' . '/kochavitmob/users.php');
                    }
                    elseif ($_POST['submitT'])  {
                         header('Location:' . '/kochavitmob/transfer.php');
                    }
                    elseif ($_POST['submitC'])  {
                         header('Location:' . '/kochavitmob/company.php');
                    }
                } else {
                    $error['msg'] = "סיסמה לא תואמת לשם המשתמש. הקלד שוב...";
                }
            };
        } else {
            $error['msg'] = "שם משתמש לא מופיעה במערכת";
        }
    } else {
        $error['msg'] = 'חובה להכניס את כל הנתונים';
    }
}
?>

<div class="container">
<div class="row" style="margin-top:20px">
    <div class="col-12 col-sm-8 col-md-6 text-right">
        <form role="form" action="login_admin.php" method="post">
            <fieldset>
                <h4>כניסת מנהל המערכת</h4>
                <hr class="colorgraph">
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control input-lg" placeholder="שם משתמש">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="סיסמה">
                </div>
                <div><h6 id="msg" style="color:red"><?php echo isset($error['msg']) ? $error['msg'] : '' ?></h6></div>
                <hr class="colorgraph">
                
                <div class="row justify-content-md-center">
                    <div class="col-10 col-md-6">
                        <input type="submit" name="submitU" class="btn btn-sm btn-primary btn-block" value="רשימת מטפלים">
                        <br>
                        <input type="submit" name="submitT" class="btn btn-sm btn-primary btn-block" value="העברת נתונים">
                        <br>
                        <input type="submit" name="submitC" class="btn btn-sm btn-primary btn-block" value="פרטי חברה">
                    </div>
                    <p id="errorNoData"></p>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</div>
<?php  include 'includes/footer.php'; ?>