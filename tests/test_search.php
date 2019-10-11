<?php include '../includes/db.php'; ?>


<?php
    $search = $_POST['search'];
    if (!empty($search)) {

        $query = "SELECT car_number FROM car_tests WHERE car_number LIKE '$search%'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die('Query failed' . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_array($result)) {
            $car_number = $row['car_number'];
?>
            <ul class="list-unstyled">
                <?php
                echo "<li>{$car_number}</li>";
                ?>
            </ul>
       <?php }
    }
 ?>