<?php  include ('../includes/header.php'); ?>

<?php
    if (isset($_POST['submit'])) {
    // $sql = "CREATE DATABASE data";
    // if (mysqli_query($connection, $sql)) {
    //     echo "Database created";
    // } else {
    //     echo "Error creating database";
    // }

    $sql = "CREATE TABLE `users` (`user_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_full_name` varchar(30) NOT NULL, `username` varchar(30) NOT NULL,
        `user_password` varchar(60) NOT NULL,`user_role` varchar(10) NOT NULL,
        PRIMARY KEY (`user_id`)) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;";
    if (mysqli_query($connection, $sql)) {
        echo "Table users created";
    } else {
        echo "Error creating users table";
    }
    mysqli_close($connection);

    }
?>

<div class="container">
    <form role="form" action="db_build.php" method="post">
        <button type="submit" name="submit">Create Tables</button>
    </form>
</div>