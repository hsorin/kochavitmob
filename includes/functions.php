<?php

function confirm($stmt){
    global $connection;
    if (!$stmt->execute()) {
        die("Error: <br>" . mysqli_error($connection));
    }
}

function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function value_exists($table, $field_name, $field_val){
    global $connection;

    $stmt = $connection->prepare("SELECT * FROM $table WHERE $field_name = ?");
    $stmt->bind_param('s', $field_val);
    confirm($stmt);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function insert_bikoret(){
    global $connection;
    if (isset($_POST['submit'])) {
        $bikoret = $_POST['bikoret'];
        if ($bikoret == "" || empty($bikoret)) {
            $error['msg'] = 'חובה להקליד ערך';
        } else {
            $query = "INSERT INTO bikoret_tbl (bikoret) VALUES ('{$bikoret}')";
            $result_insert = mysqli_query($connection, $query);
            header("Location: bikoret_tbl.php");
        }
    }
}

function delete_bikoret(){
    global $connection;
    if (isset($_GET['delete'])) {
        $del_bikoret_id = $_GET['delete'];
        $query = "DELETE FROM bikoret_tbl WHERE bikoret_id = {$del_bikoret_id}";
        $result_del = mysqli_query($connection, $query);
        header("Location: bikoret_tbl.php");
    }
}
?>