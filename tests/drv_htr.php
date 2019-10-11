<?php  include ('../includes/header.php'); ?>
<?php
    if (isset($_GET['car_id'])) {
        $car_id = $_GET['car_id'];
        $car_number = $_GET['car_number'];
        $car_type = $_GET['car_type'];
        $_SESSION["car_id"] = $car_id;
        $_SESSION["car_number"] = $car_number;
        $_SESSION["car_type"] = $car_type;
    } else {
        $car_id = $_SESSION["car_id"];
        $car_number = $_SESSION["car_number"];
        $car_type = $_SESSION["car_type"];
    };
 ?>

<div align="left" style="margin-left: 20px;">
    <a href="tests.php"><span class="fas fa-arrow-left"></span></a>
</div>
<div class="container">
        <h4>היתרי נהגים צמודים</h4>
        <h5>רכב מספר: <?php echo $car_number ?> סוג רכב: <?php echo $car_type ?></h5>
        <hr class="colorgraph">

<?php
    $query = ("SELECT * FROM drv_htr WHERE car_id = $car_id");
    if (!$result = mysqli_query($connection, $query)) {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };
?>

    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-primary text-light">
                    <th>שם הנהג</th>
                    <th>סוג היתר</th>
                    <th>תאריך לביצוע</th>
                 </tr>
            </thead>
            <tbody>
<?php
    while ($row = mysqli_fetch_assoc($result)) {
        $htr_id = $row['htr_id'];
        $drv_name = $row['drv_name'];
        $htr_name = $row['htr_name'];
        $htr_date = new DateTime($row['htr_date']);
        $tedirut = $row['tedirut'];
        $drv_id = $row['drv_id'];

        echo "<tr>";
        echo "<td>{$drv_name}</td>";
        echo "<td>{$htr_name}</td>";
        echo "<td>{$htr_date->format('d/m/Y')}</td>";
        echo "<td><button'><a href='drv_htr_edit.php?htr_id={$htr_id}&tedirut={$tedirut}&htr_name={$htr_name}&drv_id={$drv_id}&drv_name={$drv_name}'><span class='fas fa-edit'></span></a></button></td>";
        echo "</tr>";
    };
?>
            </tbody>
        </table>
    </div>
</div>

<?php  include '../includes/footer.php'; ?>