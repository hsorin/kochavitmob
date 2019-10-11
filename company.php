<?php include ('includes/header.php'); ?>

<?php
    $id=1;
    $stmt = $connection->prepare("SELECT name, tel1, tel2, email FROM company WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($name, $tel1, $tel2, $email);
    $stmt->fetch();
    $stmt->close();
?>

<?php
    if (isset($_POST['name'])){
        $name = $_POST['name'];
        $tel1 = escape($_POST['tel1']);
        $tel2 = escape($_POST['tel2']);
        $email = escape($_POST['email']);
        
        $stmt = $connection->prepare("UPDATE company SET name=?, tel1=?, tel2=?, email=? WHERE id=?");
        if (!$stmt->bind_param("sssss", $name, $tel1, $tel2, $email, $id)){
            echo "Error: <br>".mysqli_error($connection);
        }   
        if (!$stmt->execute()){
            echo "Error: "."<br>".mysqli_error($connection);
        } else {
            header("Location: login_admin.php");
        }
    }
?>

<div class="container">
    <div class="col-12 col-sm-12 col-md-10">
        <a href="login_admin.php"><span class="fas fa-arrow-left"></span></a>
        <h4 class="text-right">פרטי החברה</h4>
        <hr class="colorgraph">
    </div>
</div>

<div class="container text-right">
    <div class="col-12 col-sm-12 col-md-10">
        <form role="form" action="company.php" method="post" id="name" enctype="multipart/form-data">
            <div class="row">
               <div class="col-12 col-md-8">
                    <label for="name"><span class="badge badge-primary"><big>שם החברה:</big></span></label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php {echo $name;} ?>">
                </div>
            </div>
             <div class="row">
               <div class="col-12 col-md-8">
                    <label for="tel1"><span class="badge badge-primary"><big>מס' טלפון:</big></span></label>
                    <input type="text" class="form-control" name="tel1" id="tel1" value="<?php {echo $tel1;} ?>">
                </div>
            </div>
            <div class="row">
               <div class="col-12 col-md-8">
                    <label for="tel2"><span class="badge badge-primary"><big>מס' טלפון נוסף:</big></span></label>
                    <input type="text" class="form-control" name="tel2" id="tel2" value="<?php {echo $tel2;} ?>">
                </div>
            </div>
            <div class="row">
               <div class="col-12 col-md-8">
                    <label for="email"><span class="badge badge-primary"><big>דואר אלקטרוני:</big></span></label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php {echo $email;} ?>">
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

<?php include 'includes/footer.php'; ?>