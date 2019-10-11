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
    <h4>טיפולים קרובים נוספים</h4>
    <h5>רכב מספר: <?php echo $car_number ?> סוג רכב: <?php echo $car_type ?></h5>
    <hr class="colorgraph">

<?php
    $query = ("SELECT * FROM car_tpl WHERE car_id = $car_id");
    if (!$result = mysqli_query($connection, $query)) {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };
?>

    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-primary text-light">
                    <th>סוג הטיפול</th>
                    <th>תאריך לביצוע</th>
                </tr>
            </thead>
            <tbody>
                <?php
    while ($row = mysqli_fetch_assoc($result)) {
        $test_id = $row['test_id'];
        $test_name = $row['test_name'];
        $test_date = new DateTime($row['test_date']);
        $tedirut = $row['tedirut'];

        echo "<tr>";
        echo "<td>{$test_name}</td>";
        echo "<td>{$test_date->format('d/m/Y')}</td>";
        echo "<td><button><a href='car_tpl_edit.php?test_id={$test_id}&tedirut={$tedirut}&test_name={$test_name}&car_id={$car_id}'><span class='fas fa-edit'></span></a></button></td>";
        echo "</tr>";
    };
?>
            </tbody>
        </table>
    </div>
</div>

<?php  include '../includes/footer.php'; ?>
