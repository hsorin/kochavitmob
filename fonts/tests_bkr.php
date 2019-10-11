<?php
    if (isset($_POST['submit']) and $_POST['search'] <> '') {
        $search = $_POST['search'];

        $query = ("SELECT * FROM car_tests WHERE car_number LIKE '%$search%' AND est_inspector = '$user_full_name'");
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

