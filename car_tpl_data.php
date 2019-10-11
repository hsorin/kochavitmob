<?php include ('../includes/db.php'); ?>
<?php include ('../includes/functions.php'); ?>

<?php
    if (isset($_POST['tpl_datedone'])) {
        setlocale(LC_ALL, 'he');

        $tpl_datedone = strtotime(str_replace("/", "-", escape($_POST['tpl_datedone'])));
        $tpl_datedone = date('Y-m-d', $tpl_datedone);
        $tpl_datetodo = strtotime(str_replace("/", "-", escape($_POST['tpl_datetodo'])));
        $tpl_datetodo = date('Y-m-d', $tpl_datetodo);
        $test_id = escape($_POST['test_id']);

        if (!($stmt = $connection->prepare("INSERT INTO tpl_done (car_tpl_id, tpl_datedone, tpl_datetodo) VALUES(?,?,?)"))) {
            echo "Prepare failed" . $connection->errno . "---" . $connection->error;
        }
        $stmt->bind_param("iss", $test_id, $tpl_datedone, $tpl_datetodo);
        confirm($stmt);
        
        $stmt = $connection->prepare("DELETE FROM car_tpl WHERE test_id = ?");
        $stmt->bind_param("i", $test_id);
        confirm($stmt);
        $stmt->close();
  };
?>