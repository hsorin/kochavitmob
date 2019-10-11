<?php  include ('includes/header.php'); ?>
<?php $user_id =  $_SESSION['user_id']; ?>

<?php
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    $stmt = $connection->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param('s', $delete_id);
    confirm($stmt);
}
?>

<div class="container">
    <div class="col-12 col-sm-12 col-md-10">
        <a href="login_admin.php"><span class="fas fa-arrow-left"></span></a>
        <h4 class="text-right">רשימת משתמשים</h4>
        <hr class="colorgraph">
    </div>
</div>
<div class="container text-right">
    <div class="col-12 col-sm-12 col-md-12 ">
        <table class="table-fit table-sm table-bordered table-hover">
            <thead class="bg-primary text-light">
                <tr>
                    <th>שם קצין הבטיחות</th>
                    <th>שם המשתמש</th>
                    <th>הרשאה</th>
                    <th><button><a href="forms/user_add.php"><span class="fas fa-user-plus"></span></a></button></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

<?php
    $query = "SELECT * FROM users ORDER BY user_full_name";
    $result = mysqli_query($connection, $query);
    if (!$result = mysqli_query($connection, $query)) {
        echo "Error: " . "<br>" . mysqli_error($connection);
    }
 ?>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    $id = $row['user_id'];
                    $user_full_name = $row['user_full_name'];
                    $username = $row['username'];
                    $user_password = $row['user_password'];
                    $user_role = $row['user_role'];
                    if ($user_role == 'admin') { $user_role_trg = 'מנהל'; }
                        else { $user_role_trg = 'משתמש'; }

                    echo "<tr>";
                    echo "<td>{$user_full_name}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$user_role_trg}</td>";
                    echo "<td><button><a href = 'forms/user_edit.php?id={$id}'><span class='fas fa-user-edit'></a></span></button></td>";                   
                    echo "<td><button class='btnDelete' var1=$user_full_name var2=$id><a href='#'><span class='fas fa-user-minus'></a></span></button>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $('.btnDelete').on('click', function(){
        //useBootstrap: false;
        var name = $(this).attr('var1');
        var id = $(this).attr('var2');
        rtl = true;
        $.confirm({
            useBootstrap: false,
            rtl: true,
            title: 'אישור ביטול',
            content: 'למחוק כרטיס '+name+'?',
            buttons: {
                confirm: {
                    text: 'כן',
                    btnClass: 'btn-blue',
                    action: function () {
                    //    $.alert('לחצת אישו');
                        window.location.href = 'users.php?delete='+id+'';
                    }
                },
                cancel: {
                    text: 'לא',
                    action: function () {
                    }
                }
            }
            });
        });
</script>

<!--
<script>
function confirmDelete(id, name) {
    if (confirm("למחוק סופית כרטיס של "+name+'?')){
        window.location.href = 'users.php?delete='+id+'';
        return true;
    }
}
</script>
-->
   
<?php  include 'includes/footer.php'; ?>