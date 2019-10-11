<?php  include ('../includes/header.php'); ?>

<?php $user_id =  $_SESSION['user_id']; ?>

<?php
    if (isset($_GET['test_id'])) {
        $test_id = $_GET['test_id'];
        $car_number = $_GET['car_number'];
        $car_id = $_GET['car_id'];
        $car_type = $_GET['car_type'];
    }
 ?>

<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <h4><strong>ביקורת חודשית</strong></h4>
        <h5>רכב מספר: <?php echo $car_number ?> סוג רכב: <?php echo $car_type ?></h5>
        <hr class="colorgraph">
    </div>
</div>

<!--Nav tabs-->
<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li class="active"><a href="#test_bkr" role="tab" data-toggle="tab">פרטי בקורת</a></li>
    <li><a href="#test_lky" role="tab" data-toggle="tab">ליקויים</a></li>
    <li><a href="#car_tpl" role="tab" data-toggle="tab">טיפולים נוספים</a></li>
    <li><a href="#drv_htr" role="tab" data-toggle="tab">טיפולי נהג</a></li>
 </ul>
</div>
<!--end Nav tabs-->

<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="test_bkr">
        <?php include 'test_bkr.php'; ?>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="test_lky">
        <?php include 'test_lky.php'; ?>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="car_tpl">
        <?php include 'car_tpl.php'; ?>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="drv_htr">
        <?php include 'drv_htr.php'; ?>
    </div>
</div>

<script>
    $(function(){
        $('a[data-toggle="tab"]').on('click', function(e){
            window.localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab");
        }
    });
</script>


<?php  include '../includes/footer.php'; ?>