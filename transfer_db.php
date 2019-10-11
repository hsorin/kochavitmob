<?php  include ('includes/header.php'); ?>

<?php
    if (isset($_POST['import'])) {
        deleteBkrs();
        updateBkrs();
        deleteTests();
        updateTests();
        deleteCarTpl();
        updateCarTpl();
        deleteDrvHtr();
        updateDrvHtr();
        echo "העלאת הנתונים לאתר בוצעה...";
    }
    function deleteBkrs(){
        global $connection;
        $query = "DELETE FROM bikoret_dtl_tbl";
        mysqli_query($connection, $query);
        $query = "DELETE FROM bikoret_tbl";
        mysqli_query($connection, $query);
    }
    function deleteTests(){
        global $connection;
        $query = "DELETE FROM car_tests";
        mysqli_query($connection, $query);
    }
    function deleteCarTpl(){
        global $connection;
        $query = "DELETE FROM car_tpl";
        mysqli_query($connection, $query);
    }
    function deleteDrvHtr(){
        global $connection;
        $query = "DELETE FROM drv_htr";
        mysqli_query($connection, $query);
    }

    function updateBkrs(){
        global $connection;
        $jsondata = file_get_contents('./files_to_web/tbl_bkr.json', FILE_USE_INCLUDE_PATH);
        $data = json_decode($jsondata, true);
        if (is_array($data)){
            $idBikoret = 0;
            foreach ($data as $value) {
                $id = $value['Id'];
                $bikoret = $value['Bikoret'];
                $dtl_id = $value['DtlId'];
                $bikoretDtl = $value['BikoretDtl'];
                
                if ($id <> $idBikoret){
                    $stmtBkr = $connection->prepare("INSERT INTO bikoret_tbl (bikoret_id, bikoret) VALUES (?,?)");
                if (!$stmtBkr->bind_param("is", $id, $bikoret)){
                    echo "Error: " . $stmtBkr . "<br>" . mysqli_error($connection);
                    }
                    if (!$stmtBkr->execute()){
                        echo "Error: " . "<br>" . mysqli_error($connection); 
                    }
                    $idBikoret = $id;
                }
                $stmtBkrDtl = $connection->prepare("INSERT INTO bikoret_dtl_tbl (bikoret_dtl_id, bikoret_id, bikoret_dtl) VALUES (?,?,?)");
                if (!$stmtBkrDtl->bind_param("iis", $dtl_id, $id, $bikoretDtl)) {
                    echo "Error: " . $stmtBkrDtl . "<br>" . mysqli_error($connection);
                    }
                    if (!$stmtBkrDtl->execute()){
                        echo "Error: " . "<br>" . mysqli_error($connection);           
                    }
            }
        }
    }

    function updateTests(){
        global $connection;
        $jsondata = file_get_contents('./files_to_web/car_inspects.json', FILE_USE_INCLUDE_PATH);
        $data = json_decode($jsondata, true);
        if (is_array($data)){
            foreach ($data as $value){
                $test_id = $value['test_id'];
                $car_id = $value['car_id'];
                $inspector_id = $value['inspector_id'];
                $test_tpl_id = $value['test_tpl_id'];
                $client_id = $value['client_id'];
                $test_inspector = $value['test_inspector'];
                $car_number = $value['car_number'];
                $car_type = $value['car_type'];
                $test_date =  date('Y-m-d', strtotime(str_replace('/', '-', $value['test_date'])));
                $car_contact = $value['car_contact'];
                $phone = $value['phone'];
                $client_name = $value['client_name'];
                $phone1 = $value['phone1'];
                $phone2 = $value['phone2'];
                $location = $value['location'];
                $remarks = $value['remarks'];

                $stmtIns = $connection->prepare("INSERT INTO car_tests (test_id, test_tpl_id, car_id, inspector_id, client_id, test_inspector, car_number, car_type, test_date, car_contact, phone, client_name, phone1, phone2, location, remarks) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                if (!$stmtIns->bind_param("ssssssssssssssss", $test_id, $test_tpl_id, $car_id, $inspector_id, $client_id, $test_inspector, $car_number, $car_type, $test_date, $car_contact, $phone, $client_name, $phone1, $phone2, $location, $remarks)){
                        echo "Error: " . $stmtIns . "<br>" . mysqli_error($connection);
                    }
                    if (!$stmtIns->execute()){
                        echo "Error: " . "<br>" . mysqli_error($connection);
                    }
            }
        }
    }
    
    function updateCarTpl(){
        global $connection;
        $jsondata = file_get_contents('./files_to_web/car_tpl.json', FILE_USE_INCLUDE_PATH);
        $data = json_decode($jsondata, true);
        if (is_array($data)){
            foreach ($data as $value) {
                $test_id = $value['test_id'];
                $car_tpl_id = $value['car_tpl_id'];
                $car_id = $value['car_id'];
                $test_name = $value['test_name'];
                $test_date =  date('Y-m-d', strtotime(str_replace('/', '-', $value['test_date'])));
                $tedirut = $value['tedirut'];

                $stmtIns = $connection->prepare("INSERT INTO car_tpl (test_id, car_tpl_id, car_id, test_name, test_date, tedirut) VALUES (?,?,?,?,?,?)");
                if (!$stmtIns->bind_param("ssssss", $test_id, $car_tpl_id, $car_id, $test_name, $test_date, $tedirut)) {
                        echo "Error: " . $stmtIns . "<br>" . mysqli_error($connection);
                    }
                    if (!$stmtIns->execute()){
                        echo "Error: " . "<br>" . mysqli_error($connection);
                    }
            }
        }
    }

    function updateDrvHtr(){
        global $connection;
        $jsondata = file_get_contents('./files_to_web/drv_htr.json', FILE_USE_INCLUDE_PATH);
        $data = json_decode($jsondata, true);
        if (is_array($data)){
            foreach ($data as $value) {
                $htr_id = $value['htr_id'];
                $drv_htr_id = $value['drv_htr_id'];
                $drv_id = $value['drv_id'];
                $car_id = $value['car_id'];
                $drv_name = $value['drv_name'];
                $htr_name = $value['htr_name'];
                $htr_date =  date('Y-m-d', strtotime(str_replace('/', '-', $value['htr_date'])));
                $tedirut = $value['tedirut'];

                $stmtIns = $connection->prepare("INSERT INTO drv_htr (htr_id, drv_htr_id, drv_id, car_id, drv_name, htr_name, htr_date, tedirut) VALUES (?,?,?,?,?,?,?,?)");
                    if (!$stmtIns->bind_param("ssssssss", $htr_id, $drv_htr_id, $drv_id, $car_id, $drv_name, $htr_name, $htr_date, $tedirut)) {
                        echo "Error: " . $stmtIns . "<br>" . mysqli_error($connection);
                    }
                    if (!$stmtIns->execute()){
                        echo "Error: " . "<br>" . mysqli_error($connection);
                    }
            }
        }
    }
?>

<?php
    if (isset($_POST['export'])) {
        exportTests();
        deleteExTests();
        exportTpls();
        deleteExTpls();
        exportHtrs();
        deleteExHtrs();
        echo "הורדת התנונים למחשב בוצעה...";
    };

    function exportTests(){
        global $connection;
        $stmt = "SELECT * FROM car_inspects";
        $result = mysqli_query($connection, $stmt);
        for ($set = array ();
            $row = $result->fetch_assoc(); $set[] = $row);
        $json_array = json_encode($set);
        file_put_contents('./files_from_web/car_inspects.json', $json_array, FILE_USE_INCLUDE_PATH);
    };
    function deleteExTests(){
        global $connection;
        $query = "DELETE FROM car_inspects";
        mysqli_query($connection, $query);
    };

    function exportTpls(){
        global $connection;
        $stmt = "SELECT * FROM tpl_done";
        $result = mysqli_query($connection, $stmt);
        for ($set = array ();
            $row = $result->fetch_assoc(); $set[] = $row);
        $json_array = json_encode($set);
        file_put_contents('./files_from_web/car_tpls.json', $json_array, FILE_USE_INCLUDE_PATH);
    };
    function deleteExTpls(){
        global $connection;
        $query = "DELETE FROM tpl_done";
        mysqli_query($connection, $query);
    };

    function exportHtrs(){
        global $connection;
        $stmt = "SELECT * FROM htr_done";
        $result = mysqli_query($connection, $stmt);
        for ($set = array ();
            $row = $result->fetch_assoc(); $set[] = $row);
        $json_array = json_encode($set);
        file_put_contents('./files_from_web/drv_htrs.json', $json_array, FILE_USE_INCLUDE_PATH);
    };
    function deleteExHtrs(){
        global $connection;
        $query = "DELETE FROM htr_done";
        mysqli_query($connection, $query);
    };
?>

<?php  include 'includes/footer.php'; ?>