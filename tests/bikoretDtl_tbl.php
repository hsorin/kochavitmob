
<?php
function showDtl(){
    global $connection;

    echo '<label for="checkList"><span class="badge badge-primary"><big>נושאים ראשים:</big></span></label>';    
    echo '<table class="table table-bordered table-hover" id="checkList">';
    echo '<tbody>';
    
    $query = "SELECT * FROM bikoret_tbl";
    $result_bikoret = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result_bikoret)){
        $bikoret_id = $row['bikoret_id'];
        $bikoret = $row['bikoret'];
        echo "<tr class='clickable' data-toggle='collapse' data-target='#d$bikoret_id' aria-expanded='false' aria-controls='d$bikoret_id'>";
        echo "<td>$bikoret</td>";
        echo "<td><span type='button' class='fas fa-ellipsis-h'></span></td>";
        echo "</tr>";
        echo "</tbody>";
        echo "<tbody id='d$bikoret_id' class='collapse'>";
        
        $query = "SELECT * FROM bikoret_dtl_tbl WHERE bikoret_id = {$bikoret_id}";
        $result_bikoret_dtl = mysqli_query($connection, $query);
        while ($rowDtl = mysqli_fetch_assoc($result_bikoret_dtl)) {
            $bikoret_dtl_id = $rowDtl['bikoret_dtl_id'];
            $bikoret_dtl = $rowDtl['bikoret_dtl'];
            array_push($_SESSION['arBkrDtl_id'], $bikoret_dtl_id);
            
            echo "<tr>";
            echo "<td>{$bikoret_dtl}</td>";
            echo "<td><input type='checkbox' name='mark_$bikoret_dtl_id' value='no'><small> לא תקין</small></input></td>";
            echo "</tr>";
        }
        echo "</tbody>";
    }
    echo "</table>";
}       
?>

