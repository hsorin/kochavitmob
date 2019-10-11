<?php include 'includes/header.php'; ?>

<?php
if (isset($_POST['submit'])) {
    $username =  escape($_POST['username']);
    $password = escape($_POST['password']);
    if ($username && $password) {
        $stmt = $connection->prepare("SELECT user_id, user_password, username, user_full_name FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['user_password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_full_name'] = $row['user_full_name'];
                    $stmt->close();
                    header('Location: ' . '/kochavitmob/tests/tests.php');
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
            <form role="form" action="index.php" method="post">
                <fieldset>
                    <h4>כניסת משתמש</h4>
                    <hr class="colorgraph">
                    <div class="form-group">
                        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="שם משתמש">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="סיסמה">
                    </div>
                    <hr class="colorgraph">
                    <div>
                        <h6 id="msg" style="color:red"><?php echo isset($error['msg']) ? $error['msg'] : '' ?></h6>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="כנס למערכת">
                        </div>
                        <p id="errorNoData"></p>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php  include 'includes/footer.php'; ?>
