<?php include ('../includes/header.php'); ?>
<?php
$numDtl = 0;
include 'bikoretDtl_tbl.php';
?>

<?php
    if (isset($_GET['test_id'])) {
        $test_id = $_GET['test_id'];
        $car_number = $_GET['car_number'];
        $test_name = $_GET['test_name'];
        $car_id = $_GET['car_id'];
        $client_name = $_GET['client'];
        $car_type = $_GET['type'];
    }
 ?>

<?php
    if ((isset($_POST['save'])) or (isset($_POST['showPdf']))) {
        setlocale(LC_ALL, 'he');
        $error = [
            'inspect_done'=>'',
            'inspect_todo'=>''
        ];
        $inspect_done = strtotime(escape($_POST['inspect_done']));
        $inspect_done = date('Y-m-d', $inspect_done);
        $inspect_todo = strtotime(escape($_POST['inspect_todo']));
        $inspect_todo = date('Y-m-d', $inspect_todo);
        $car_km = escape($_POST['car_km']);
        $inspect_remark = escape($_POST['inspect_remark']) . PHP_EOL;
        $numDetail = $_POST['numDetail'];

        $dtl_array = $_SESSION['dtl_array'];
        for ($i=1; $i <= $numDetail; $i++) {
            if (isset($_POST['mark'.$i])){
                $inspect_remark = $inspect_remark . $dtl_array[$i-1] . PHP_EOL;
            };
        };
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
            if (isset($_POST['showPdf'])) {
                include 'create_pdf.php';
            }

            if (isset($_POST['save'])) {
                if (!($stmt = $connection->prepare("INSERT INTO car_inspects(test_id, inspect_done, inspect_todo, car_km, inspect_remark, car_id) VALUES(?,?,?,?,?,?)"))) {
                    echo "Prepare failed" . $connection->errno . "---" . $connection->error;}
                $stmt->bind_param("ssssss", $test_id, $inspect_done, $inspect_todo, $car_km, $inspect_remark, $car_id);
                confirm($stmt);

                $stmt = $connection->prepare("DELETE FROM car_tests WHERE test_id = ?");
                $stmt->bind_param("s", $test_id);
                confirm($stmt);
                $stmt->close();

                $image = $_FILES['image']['name'];
                $imageType = $_FILES['image']['type'];
                $image_temp = $_FILES['image']['tmp_name'];
                $imageExt = explode('.', $image);
                $actualExt = end($imageExt);
                $imageNewName = ($_POST['photoName']). '_' . $test_id . '.' . $actualExt;
                move_uploaded_file($image_temp, "../files_from_web/documents/" . $imageNewName);
                header('Location: tests.php');
            };
        }
    }
?>

<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-4 col-md-offset-6">
        <h2>רישום טיפול</h2>
        <h5>רכב מספר: <?php echo $car_number ?> טיפול: <?php echo $test_name ?> </h5>
        <hr class="colorgraph">

    <form role="form" action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="row">
                <div class="form-group">
                    <div class="panel panel-primary col-sm-6 col-md-6 col-md-push-6">
                        <div class="panel-heading">תאריך ביצוע טיפול:</div>
                        <input type="text" name="inspect_done" id="inspect_done" class="date" size="17" tabindex="1">
                        <h5 style="color:red"><?php echo isset($error['inspect_done']) ? $error['inspect_done'] : '' ?></h5>
                    </div>

                    <div class="panel panel-primary col-sm-6 col-md-6 col-md-pull-6">
                        <div class="panel-heading">תאריך לטיפול הבא:</div>
                        <input type="text" name="inspect_todo" id="inspect_todo" class="date" size="17" tabindex="2">
                        <h5 style="color:red"><?php echo isset($error['inspect_todo']) ? $error['inspect_todo'] : '' ?></h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="panel panel-primary col-sm-12">
                        <div class="panel-heading">מד אוץ:</div>
                            <input type="text" class="form-control" name="car_km" placeholder="הקלד מד אוץ נוכחי:">
                        </div>
                </div>
            </div>

            <?php showDtl();?>
            <div class="row">
                <div class="form-group">
                    <div class="panel panel-primary col-sm-12">
                            <div class="panel-heading">תאור ליקויים:</div>
                            <textarea class="col-sm-12" rows="4" name="inspect_remark" placeholder="הקלד תאור הליקויים:"></textarea>
                    </div>
                    <input type="hidden" name="numDetail" value="<?php echo $numDtl ?>"/>
                </div>
            </div>

            <div class="row">
                    <button id="files" onclick="document.getElementById('file-input').click(); return false;"><span class="glyphicon glyphicon-camera"></span></button>
                    <input type="file"  name="image" id="file-input" accept="image/*" capture="camera"  style="visibility:hidden;" onchange="loadFile(event)" />
                    <img id="photo" width="150" height="150">
                    <label>שם המסמך</label>
                    <input type="text" name="photoName" id="photoName">

                    <script>
                        var loadFile = function(event){
                            var output = document.getElementById('photo');
                            photo.src = URL.createObjectURL(event.target.files[0]);
                        };
                    </script>

                    <input class="btn btn-primary" type="submit" name="showPdf" value="הצג טופס">
                    <input class="btn btn-primary" type="submit" name="save" value="שמור">
            </div>
        </fieldset>
    </form>
    </div>
</div>

<script>
    $(".date").datepicker(
        $.datepicker.regional["he"]);
    var changeMonth = $(".date").datepicker("option", "changeMonth");
    var changeYear = $(".date").datepicker("option", "changeYear");
    $(".date").datepicker("option", "changeMonth", true);
    $(".date").datepicker("option", "changeYear", true);
    $(".date").datepicker("option", "showOn", "button");
    $(".date").datepicker("option", "buttonImage", "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif");
    $("#inspect_done").datepicker('setDate', 'today');
    $("#inspect_todo").datepicker('setDate', '+1m');

    $("#inspect_done").change(function() {
        var dateNew = $("#inspect_done").datepicker('getDate');
        dateNew.setMonth(dateNew.getMonth() +1);
        $("#inspect_todo").datepicker('setDate', dateNew);
    });
</script>

<?php  include '../includes/footer.php'; ?>

