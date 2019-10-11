<?php  include ('../includes/header.php'); ?>

<?php
function get_htmlTbl(){
    global $connection;
    $output = '';
    $query = "SELECT * FROM bikoret_tbl";
    $result_bikoret = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result_bikoret)){
        $bikoret_id = $row['bikoret_id'];
        $bikoret = $row['bikoret'];
        
        $output .= '
            <tr>
                <td>'.$bikoret.'</td>
            </tr>';
    
    $query_dtl = "SELECT * FROM bikoret_dtl_tbl WHERE bikoret_id = {$bikoret_id}";
    $result_bikoret_dtl = mysqli_query($connection, $query_dtl);
    while ($rowDtl = mysqli_fetch_assoc($result_bikoret_dtl)) {
        $bikoret_dtl_id = $rowDtl['bikoret_dtl_id'];
        $bikoret_dtl = $rowDtl['bikoret_dtl'];
        $output .= '
            <tr>
                <td>'.$bikoret_dtl.'</td>
                <td>'."תקין".'</td>
            </tr>';   
        }
    }
    return $output;
}
?>

<div class="container">
<table class="table table-bordered">
    <?php
        echo get_htmlTbl();
    ?>
</table>
</div>

<?php  include ('../includes/footer.php'); ?>