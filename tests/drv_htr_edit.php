<?php  include ('../includes/header.php'); ?>

<?php
    if (isset($_GET['htr_id'])) {
        $htr_id = $_GET['htr_id'];
        $tedirut = $_GET['tedirut'];
        $htr_name = $_GET['htr_name'];
        $drv_id = $_GET['drv_id'];
        $drv_name = $_GET['drv_name'];
    };
?>

<?php 
    if (isset($_POST['save'])){
        $htr_datedone = strtotime(str_replace("/", "-", escape($_POST['htr_datedone'])));
        $htr_datedone = date('Y-m-d', $htr_datedone);
        $htr_datetodo = strtotime(str_replace("/", "-", escape($_POST['htr_datetodo'])));
        $htr_datetodo = date('Y-m-d', $htr_datetodo);
        
        if (!($stmt = $connection->prepare("INSERT INTO htr_done (drv_htr_id, htr_datedone, htr_datetodo) VALUES(?,?,?)"))) {
            echo "Prepare failed" . $connection->errno . "---" . $connection->error;
        }
        $stmt->bind_param("iss", $htr_id, $htr_datedone, $htr_datetodo);
        confirm($stmt);
        $stmt = $connection->prepare("DELETE FROM drv_htr WHERE htr_id = ?");
        $stmt->bind_param("i", $htr_id);
        confirm($stmt);
        $stmt->close();
        
        header("Location: drv_htr.php");
    }
?>

<div align="left" style="margin-left: 20px;">
    <a href="drv_htr.php"><span class="fas fa-arrow-left"></span></a>
</div>
<div class="container">
        <h4>עדכון היתר נהג <?php echo $drv_name; ?></h4>
        <h5> היתר: <?php echo $htr_name; ?></h5>
        <hr class="colorgraph">

    <div>
        <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="row">    
               <div class="col-12 col-md-5">
                    <label for="htr_datedone"><span class="badge badge-primary"><big>תאריך ביצוע טיפול:</big></span></label>
                    <input type="text" name="htr_datedone" id="htr_datedone" class="form-control date" tabindex="1" required>
                        <h5 style="color:red"><?php echo isset($error['htr_datedone']) ? $error['htr_datedone'] : '' ?></h5>
                </div>
                <div class="col-12 col-md-5">
                    <label for="htr_datetodo"><span class="badge badge-primary"><big>תאריך לטיפול הבא:</big></span></label>
                    <input type="text" name="htr_datetodo" id="htr_datetodo" class="form-control date" tabindex="2">
                        <h5 style="color:red"><?php echo isset($error['htr_datetodo']) ? $error['htr_datetodo'] : '' ?></h5>
                    <input type="hidden" name="htr_id" value="<?php echo $htr_id; ?>">
                </div>
            </div>
            <br>
            <div class="row  justify-content-md-center">
                <div class="col-8 col-md-6">
                    <button class="btn btn-primary btn-sm btn-block" id="files" onclick="$('#file_input').click(); return false;">צרף תמונות</button>
                    <input id="file_input" type="file" name="file" accept="image/*" style="visibility:hidden;" onchange="loadFile()" />  
                    <img id="photo" src="" style="display:none" class="img-fluid">
                    <div id="save_images" class="row justify-content-md-center mt-2 mb-1" style="display:none">
                        <input type="text" id="image_name" name="image_name" class="col-8 col-md-8" placeholder="שם המסמך">
                        <input id="image_save" name="save_image" class="btn btn-primary btn-sm col-2 col-md-2" value="שמור"> 
                    </div>  
                </div>
            </div>

<script>
    function loadFile(){
        var output = document.getElementById('photo');
        photo.src = URL.createObjectURL(event.target.files[0]);
        $("#photo").attr("style", "display:true");
        $("#save_images").attr("style", "display:true");
        
    };
</script>
           
<script>
    $(document).ready(function() {
        $(document).on("click", "#image_save", function(){
            var property = $("#file_input")[0].files[0];
            var drv_id = <?php echo $drv_id ?>;
            var newName = $("#image_name").val() +"_D"+drv_id;
            var form_data = new FormData();
            form_data.append("file", property);
            form_data.append("newName", newName);
            form_data.append("drv_id", drv_id);

            $.ajax({
                url: "upload_file.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false
//                success: function(data){
//                    $('#message').html(data);
//                }
            })
            $("#photo").attr("style", "display:none");
            $("#save_images").attr("style", "display:none");
            $("#image_name").val("");
        })        
    })
</script>   
                   
            <div class="row justify-content-md-center">
                <div class="col-10 col-md-6">
                    <input name="save" class="btn btn-primary btn-sm btn-block"     type="submit" value="שמור">
                </div> 
            </div>
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
    $(".date").datepicker("option", "buttonImageOnly", "true");
    $(".date").datepicker("option", "buttonText", "סמן תאריך");
    $("#htr_datedone").datepicker('setDate', 'today');
    $("#htr_datetodo").datepicker('setDate', '+<?php echo $tedirut ?>m');

    $("#htr_datedone").change(function() {
        var dateNew = $("#tpl_datedone").datepicker('getDate');
        dateNew.setMonth(dateNew.getMonth() +<?php echo $tedirut ?>);
        $("#htr_datetodo").datepicker('setDate', dateNew);
    });
</script>

<?php  include ('../includes/footer.php'); ?>
