<?php  include ('../includes/header.php'); ?>

<?php 
    $user_id =  $_SESSION['user_id']; 
    $user_full_name =  $_SESSION['user_full_name']; 
    $_SESSION['arBkrDtlFault_id'] = array();
    $_SESSION['arBkrDtl_id']= array(); //$arBkrDtl_id;
?>

<?php
    if (isset($_POST['submit']) and $_POST['search'] <> '') {
        $search = $_POST['search'];

        $query = ("SELECT * FROM car_tests WHERE car_number LIKE '%$search%' AND test_inspector = '$user_full_name'");
        if (!$result = mysqli_query($connection, $query)) {
            echo "Error: " . "<br>" . mysqli_error($connection);
        }
        $num = mysqli_num_rows($result);
    } else {
        $query = "SELECT * FROM car_tests WHERE test_inspector = '$user_full_name'
            ORDER BY car_number";
        if (!$result = mysqli_query($connection, $query)) {
            echo "Error: " . "<br>" . mysqli_error($connection);
        }
    };
?>
<div align="left" style="margin-left: 20px;">
    <a href="../index.php"><span class="fas fa-arrow-left"></span></a>
</div>

<div class="container">
    <h4>רשימת התראות</h4>
    <h5>שם הקצין בטיחות: <?php echo $user_full_name ?> </h5>
    <hr class="colorgraph">

    <div class="row" style="margin-top: 20px">
        <div>
            <form role="form" action="tests.php" method="post">
                <div class="input-group">
                    <input class="form-control" id="system-search" name="search" placeholder="חפש מספר רכב">
                    <span class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <div>
            <table class="table-sm table-bordered table-hover">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>מספר רכב</th>
                        <th>סוג רכב</th>
                        <th>תאריך ביקורת</th>
                        <th>איש קשר</th>
                        <th>טלפון</th>
                        <th>שם הלקוח</th>
                        <th>אתר</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        $test_id = $row['test_id'];
        $car_number = $row['car_number'];
        $car_type = $row['car_type'];
        $test_date = new DateTime($row['test_date']);
        $car_contact = $row['car_contact'];
        $phone = $row['phone'];
        $client_name = $row['client_name'];
        $location = $row['location'];
        $test_done = $row['test_done'];
        $car_id = $row['car_id'];

        echo "<tr>";
        echo "<td>{$car_number}</td>";
        echo "<td>{$car_type}</td>";
        echo "<td>{$test_date->format('d/m/Y')}</td>";
        echo "<td>{$car_contact}</td>";
        echo "<td>{$phone}</td>";
        echo "<td>{$client_name}</td>";
        echo "<td>{$location}</td>";

        echo "<td><button><a href = 'test_bkr.php?test_id={$test_id}&car_number={$car_number}&car_id={$car_id}&car_type={$car_type}&client_name={$client_name}'><span class='fas fa-edit'></span></a></button></td>";
        echo "<td><a href='car_tpl.php?car_id={$car_id}&car_number={$car_number}&car_type={$car_type}' class='btn btn-primary btn-sm' role='button'>ט.ר.</a></td>";
        echo "<td><a href= 'drv_htr.php?car_id={$car_id}&car_number={$car_number}&car_type={$car_type}' class='btn btn-primary btn-sm' role='button'>ט.נ.</a></td>";
        echo "</tr>";
    }
?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  include '../includes/footer.php'; ?>
