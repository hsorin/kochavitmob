<?php  include ('includes/header.php'); ?>

<div class="container">
    <div class="col-12 col-sm-12 col-md-10">
        <a href="login_admin.php"><span class="fas fa-arrow-left"></span></a>
        <h4 class="text-right">העברת נתונים</h4>
        <hr class="colorgraph">
    </div>
</div>

<div class="container text-right">
<div class="col-12 col-sm-12 col-md-10">
    <form class="md-form" action="transfer.php" method="post" enctype="multipart/form-data">
       
        <div class="row justify-content-center">
            <input type="button" id="import" name="import" value="העלאת טיפולים לאתר" class="btn btn-primary">
        </div>
        <div class="row justify-content-center">
            <span id="success_import" style="color:red"></span>
        </div>
        <br>
                
        <div class="row justify-content-center">
            <input type="button" id="export" name="export" value="הורדת ביקורות למחשב" class="btn btn-primary">
        </div>
        <div class="row justify-content-center">
            <span id="success_export" style="color:red"></span>
        </div>
      
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='images/wait.gif' width="64" height="64" /><br></div>
        <hr class="colorgraph">
    </form>
</div>
</div>

<script>
    var spinner = $('#loader');
    $(function(){
        $('form').submit(function(e){
            e.preventDefault();
            spinner.show();            
        })
    })
</script>

<script>
    $(document).ready(function(){
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });
        
        $('#import').click(function(){            
            $.ajax({
            url: "transfer_db.php",
            type: "POST",
            data: {import: 'import'},
            success: function(data){
                $('#success_import').html(data);                
            }
        })
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
    });
        
        $('#export').click(function(){            
            $.ajax({
            url: "transfer_db.php",
            type: "POST",
            data: {export: 'export'},
            success: function(data){
                $('#success_export').html(data);                
            }
        })
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
    });  
})
</script>

<?php  include 'includes/footer.php'; ?>