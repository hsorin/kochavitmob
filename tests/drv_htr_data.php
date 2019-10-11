<?php
    include ('../includes/db.php');
    include ('../includes/functions.php');

    if (isset($_POST['htr_datedone'])) {
        setlocale(LC_ALL, 'he');

        $htr_datedone = strtotime(str_replace("/", "-", escape($_POST['htr_datedone'])));
        $htr_datedone = date('Y-m-d', $htr_datedone);
        $htr_datetodo = strtotime(str_replace("/", "-", escape($_POST['htr_datetodo'])));
        $htr_datetodo = date('Y-m-d', $htr_datetodo);
        $htr_id = escape($_POST['htr_id']);

        if (!($stmt = $connection->prepare("INSERT INTO htr_done (drv_htr_id, htr_datedone, htr_datetodo) VALUES(?,?,?)"))) {
            echo "Prepare failed" . $connection->errno . "---" . $connection->error;
        }
        $stmt->bind_param("iss", $htr_id, $htr_datedone, $htr_datetodo);
        confirm($stmt);

        $stmt = $connection->prepare("DELETE FROM drv_htr WHERE htr_id = ?");
        $stmt->bind_param("i", $htr_id);
        confirm($stmt);

        $stmt->close();
  };
?>