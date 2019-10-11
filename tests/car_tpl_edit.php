<?php  include ('../includes/header.php'); ?>
<script type="text/javascript" src='../js/index.js'></script>

<?php
    if (isset($_GET['test_id'])) {
        $test_id = $_GET['test_id'];
        $tedirut = $_GET['tedirut'];
        $test_name = $_GET['test_name'];
        $car_id = $_GET['car_id'];
    };
?>

<?php 
    if (isset($_POST['save'])){
        $tpl_datedone = strtotime(str_replace("/", "-", escape($_POST['tpl_datedone'])));
        $tpl_datedone = date('Y-m-d', $tpl_datedone);
        $tpl_datetodo = strtotime(str_replace("/", "-", escape($_POST['tpl_datetodo'])));
        $tpl_datetodo = date('Y-m-d', $tpl_datetodo);
        
        if (!($stmt = $connection->prepare("INSERT INTO tpl_done (car_tpl_id, tpl_datedone, tpl_datetodo) VALUES(?,?,?)"))) {
            echo "Prepare failed" . $connection->errno . "---" . $connection->error;
        }
        $stmt->bind_param("iss", $test_id, $tpl_datedone, $tpl_datetodo);
        confirm($stmt);
        $stmt = $connection->prepare("DELETE FROM car_tpl WHERE test_id = ?");
        $stmt->bind_param("i", $test_id);
        confirm($stmt);
        $stmt->close();
        
        header("Location: car_tpl.php");
    }
?>

<div align="left" style="margin-left: 20px;">
    <a href="car_tpl.php"><span class="fas fa-arrow-left"></span></a>
</div>

<div class="container">
    <h4>עדכון טיפול רכב</h4>
    <h5> טיפול: <?php echo $test_name; ?></h5>
    <hr class="colorgraph">

    <div>
        <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-5">
                    <label for="tpl_datedone"><span class="badge badge-primary"><big>תאריך ביצוע טיפול:</big></span></label>
                    <input type="text" name="tpl_datedone" id="tpl_datedone" class="form-control date" tabindex="1" required>
                    <h5 style="color:red"><?php echo isset($error['tpl_datedone']) ? $error['tpl_datedone'] : '' ?></h5>
                </div>
                <div class="col-12 col-md-5">
                    <label for="tpl_datetodo"><span class="badge badge-primary"><big>תאריך לטיפול הבא:</big></span></label>
                    <input type="text" name="tpl_datetodo" id="tpl_datetodo" class="form-control date" tabindex="2">
                    <h5 style="color:red"><?php echo isset($error['tpl_datetodo']) ? $error['tpl_datetodo'] : '' ?></h5>
                    <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
                </div>
            </div>
            <br>
            <div class="row  justify-content-md-center">
                <div class="col-10 col-md-6">
                    <button class="btn btn-primary btn-sm btn-block" id="files" onclick="$('#file_input').click(); return false;">צרף תמונות</button>
                    <input id="file_input" name="file" type="file" accept="image/*" style="visibility:hidden;" onchange="loadFile()" />
                    <img id="photo" src="" style="display:none" class="img-fluid">
                    <div id="save_images" style="display:none">
                        <input type="text" id="image_name" name="image_name" class="col-8 col-md-8" placeholder="שם המסמך">
                        <input id="image_save" name="save_image" class="btn btn-primary btn-sm col-2 col-md-2" value="שמור">
                    </div>
                    <div class="progress" style="display:none">
                        <div class="progress-bar progress-bar-strriped" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar">0%</div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row justify-content-md-center">
                <div class="col-10 col-md-6">
                    <input name="save" class="btn btn-primary btn-sm btn-block" type="submit" value="שמור">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function loadFile() {
        var output = document.getElementById('photo');
        photo.src = URL.createObjectURL(event.target.files[0]);
        $("#photo").attr("style", "display:true");
        $("#save_images").attr("style", "display:true");
        $(".progress").attr("style", "display:true");
    };

</script>


<script>
    $(document).on("click", "#image_save", function() {
        var car_id = <?php echo $car_id ?>;
        var newName = $("#image_name").val() + "_C" + car_id;
        var form_data = new FormData($('form')[0]);
        form_data.append("newName", newName);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
                    }
                    //        console.log("Bytes: " + e.loaded);
                });
                return xhr;
            },
            url: "upload_file.php",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                $("#photo").attr("style", "display:none");
                $("#save_images").attr("style", "display:none");
                $(".progress").attr("style", "display:none");
                $("#image_name").val("");
            }
        })
    })

</script>

<!--<script src="../js/dateutil.js"></script>-->

<script>
    var tedirut = <?php echo $tedirut ?>;
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
    $("#tpl_datedone").datepicker('setDate', 'today');
    //$("#tpl_datetodo").datepicker('setDate', '+<?php echo $tedirut ?>m');
    $("#tpl_datetodo").datepicker('setDate', +tedirut + 'm');


    $("#tpl_datedone").change(function() {
        var dateNew = $("#tpl_datedone").datepicker('getDate');
        //dateNew.setMonth(dateNew.getMonth() +<?php echo $tedirut ?>);
        dateNew.setMonth(dateNew.getMonth() + tedirut);
        $("#tpl_datetodo").datepicker('setDate', dateNew);
    });

</script>

<?php  include ('../includes/footer.php'); ?>
