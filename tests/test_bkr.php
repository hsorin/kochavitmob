<?php  
    include ('../includes/header.php'); 
    include 'bikoretDtl_tbl.php';
?>

<?php
    if (isset($_GET['test_id'])) {
        $test_id = $_GET['test_id'];
        $car_number = $_GET['car_number'];
        $car_id = $_GET['car_id'];
        $car_type = $_GET['car_type'];
        $client_name = $_GET['client_name'];
        
        $_SESSION['test_id'] = $test_id;
        $_SESSION['car_number'] = $car_number;
        $_SESSION['car_type'] = $car_type;
        $_SESSION['car_id'] = $car_id;
        
        $prev_remarks = get_remarks($test_id);
        $hide = false;
        if  (empty($prev_remarks)){
            $hide = true;
        }
    }
    else {
        $car_number = $_SESSION['car_number'];
        $car_type = $_SESSION['car_type'];
    }
    $user_id =  $_SESSION['user_id'];
 ?>

<?php
    function get_remarks($id){
        global $connection;
        $query = "SELECT remarks FROM car_tests WHERE test_id = {$id}";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
?>

<?php
    function get_dtlValue($id){
        global $connection;
        $query = "SELECT bikoret_dtl FROM bikoret_dtl_tbl WHERE bikoret_dtl_id = {$id}";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
?>

<?php
    if (isset($_POST['save'])) {
        setlocale(LC_ALL, 'he');
                $error = [
            'inspect_done'=>'',
            'inspect_todo'=>''
        ];
                
        $inspect_done = strtotime(str_replace("/", "-", escape($_POST['inspect_done'])));
        $inspect_done = date('Y-m-d', $inspect_done);
        $inspect_todo = strtotime(str_replace("/", "-", escape($_POST['inspect_todo'])));
        $inspect_todo = date('Y-m-d', $inspect_todo);
        $car_km = escape($_POST['car_km']);
        if ($car_km == ''){
            $car_km = NULL;
        }
        $inspect_remark = escape($_POST['inspect_remark']) . PHP_EOL;
        
        if ($inspect_done =='') {
            $error['inspect_done'] = 'חובה לרשום תאריך ביצוע';}
        if ($inspect_todo =='') {
            $error['inspect_todo'] = 'חובה לרשום תאריך לטיפול הבא'; }
        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }

        if (empty($error)) {
            $remarks = '';
            foreach ($_SESSION['arBkrDtl_id'] as $value){
                if (isset($_POST['mark_'.$value])){
                    array_push($_SESSION['arBkrDtlFault_id'], $value);
                    $remarks = $remarks . get_dtlValue($value) .PHP_EOL;
                }
            }
            $_SESSION['remarks'] = $remarks;
            $remarks = $remarks . $inspect_remark;
        
            if (!($stmt = $connection->prepare("INSERT INTO car_inspects(test_id, inspect_done, inspect_todo, car_km, inspect_remark, car_id) VALUES(?,?,?,?,?,?)"))) {
                echo "Prepare failed" . $connection->errno . "---" . $connection->error;}
            $stmt->bind_param("ssssss", $test_id, $inspect_done, $inspect_todo, $car_km, $remarks, $car_id);
            confirm($stmt);

            $stmt = $connection->prepare("DELETE FROM car_tests WHERE test_id = ?");
            $stmt->bind_param("s", $test_id);
            confirm($stmt);
            $stmt->close();
            
            $_SESSION['remarks'] = $remarks;
            header('Location: ../tools/tofesPdf.php?inspect_done='.$_POST['inspect_done'].'&client_name='.$client_name.'&car_type='.$car_type.'&car_km='.$car_km);
        };
    };
?>

<div align="left" style="margin-left: 20px;">
    <a href="tests.php"><span class="fas fa-arrow-left"></span></a>
</div>

<div class="container">
    <h4>ביקורת חודשית</h4>
    <h5>רכב מספר: <?php echo $car_number ?> סוג רכב: <?php echo $car_type ?></h5>
    <hr class="colorgraph">

    <div class="col-12 col-md-8a" id="prev_div">
        <label for="remarks"><span class="badge badge-primary"><big>ליקויים בביקורת קודמת</big></span></label>
        <br>
        <textarea readonly id="prev_test"><?php echo $prev_remarks ?></textarea>
    </div>

    <script>
        //$("#prev_div").focus(function(){
        $(document).ready(function() {
            var hide = <?php echo $hide ?>;
            //alert(hide); 
            if (hide == true) {
                $("#prev_div").hide();
            }
        })

    </script>

    <div class="col-12 col-sm-12 col-md-10">
        <form role="form" action="" method="post" enctype="multipart/form-data" id="bkr_form">
            <div class="row">
                <div class="col-12 col-md-5">
                    <label for="inspect_done"><span class="badge badge-primary"><big>תאריך ביצוע טיפול:</big></span></label>
                    <input type="text" name="inspect_done" id="inspect_done" class="form-control date" tabindex="1" required>
                    <h5 style="color:red"><?php echo isset($error['inspect_done']) ? $error['inspect_done'] : '' ?></h5>
                </div>
                <div class="col-12 col-md-5">
                    <label for="inspect_todo"><span class="badge badge-primary"><big>תאריך לטיפול הבא:</big></span></label>
                    <input type="text" name="inspect_todo" id="inspect_todo" class="form-control date" tabindex="2">
                    <h5 style="color:red"><?php echo isset($error['inspect_todo']) ? $error['inspect_todo'] : '' ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-5">
                    <label for="car_km"><span class="badge badge-primary"><big>מד אוץ:</big></span></label>
                    <input type="text" class="form-control" name="car_km" id="car_km" placeholder="הקלד מד אוץ נוכחי:">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-10"><br>
                    <?php showDtl();?>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-12">
                    <label for="inspect_remark"><span class="badge badge-primary"><big>תאור ליקויים:</big></span></label>
                    <textarea id="inspect_remark" class="col-sm-12" rows="4" name="inspect_remark" placeholder="הקלד תאור הליקויים:"></textarea>
                </div>
            </div>
            <br>
            <div class="row justify-content-md-center">
                <div class="col-10 col-md-6">
                    <button class="btn btn-primary btn-sm btn-block" id="files" onclick="$('#file_input').click(); return false;">צרף תמונות</button>
                    <input id="file_input" name="file" type="file" accept="image/*" style="visibility:hidden;" onchange="loadFile()">
                    <img id="photo" src="" style="display:none" class="img-fluid">
                    <div id="save_images" class="row justify-content-md-center mt-2 mb-1" style="display:none">
                        <input type="text" id="image_name" name="image_name" class="col-8 col-md-8" placeholder="שם המסמך">
                        <input id="image_save" name="save_image" class="btn btn-primary btn-sm col-2 col-md-2" value="שמור">
                    </div>
                </div>
            </div>

            <script>
                function loadFile() {
                    var output = document.getElementById('photo');
                    photo.src = URL.createObjectURL(event.target.files[0]);
                    $("#photo").attr("style", "display:true");
                    $("#save_images").attr("style", "display:true");

                };

            </script>

            <script>
                $(document).ready(function() {
                    $(document).on("click", "#image_save", function() {
                        var property = $("#file_input")[0].files[0];
                        var car_id = <?php echo $car_id ?>;
                        var newName = $("#image_name").val() + "_C" + car_id;
                        var form_data = new FormData();
                        form_data.append("file", property);
                        form_data.append("newName", newName);
                        form_data.append("car_id", car_id);

                        $.ajax({
                            url: "upload_file.php",
                            method: "POST",
                            data: form_data,
                            contentType: false,
                            cache: false,
                            processData: false
                            //                if success: function(data){
                            //                    if(response != 0){
                            //                        alert('Saved');
                            //                    } else {
                            //                        alert('Failed');
                            //                    }   
                            //                    $('#message').html(data);
                            //              }
                        })
                        $("#photo").attr("style", "display:none");
                        $("#save_images").attr("style", "display:none");
                        $("#image_name").val("");
                    })
                })

            </script>

            <div class="row justify-content-md-center">
                <div class="col-10 col-md-6">
                    <button type="button" class=" formsaver btn btn-primary btn-sm btn-block" onclick="windowOpen()"><span>צרף חתימה</span></button>
                    <br>
                    <input type="submit" name="save" class="btn btn-primary btn-sm btn-block" value="צור מסמך ושמור">
                    <br><br>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function windowOpen() {
        window.open("../tools/signature.php");
    }

</script>

<script>
    $(".date").datepicker(
        $.datepicker.regional["he"]);
    var changeMonth = $(".date").datepicker("option", "changeMonth");
    var changeYear = $(".date").datepicker("option", "changeYear");
    $(".date").datepicker("option", "changeMonth", true);
    $(".date").datepicker("option", "changeYear", true);

    $(".date").datepicker("option", "showOn", "button");
    $(".date").datepicker("option", "buttonImage", "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif");
    $(".date").datepicker("option", "buttonImageOnly", "true");
    $(".date").datepicker("option", "buttonText", "סמן תאריך");
    $("#inspect_done").datepicker('setDate', 'today');
    $("#inspect_todo").datepicker('setDate', '+1m');

    $("#inspect_done").change(function() {
        var dateNew = $("#inspect_done").datepicker('getDate');
        dateNew.setMonth(dateNew.getMonth() + 1);
        $("#inspect_todo").datepicker('setDate', dateNew);
    });

</script>

<?php  include ('../includes/footer.php'); ?>
