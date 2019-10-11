<?php
    function showDtl(){
        global $connection;
        global $numDtl;
        $dtl_array = array();
        $query = "SELECT * FROM bikoret_tbl";
        $result_bikoret = mysqli_query($connection, $query);

            echo '<div class="row">';
            echo '<div class="form-group">';
            echo '<div class="panel panel-primary col-sm-12">';
            echo '<table class="table table-bordered table-hover">';
            echo  '<thead class="bg-primary">';
            echo '<th style="text-align: right;">נושאים ראשים</th>';
            echo '</thead>';
            echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result_bikoret)){
                    $bikoret_id = $row['bikoret_id'];
                    $bikoret = $row['bikoret'];

                    echo "<tr class='accordion-toggle' data-toggle='collapse' data-target='#{$bikoret_id}'>";
                    echo "<td>{$bikoret}</td>";
                    echo "</tr>";

                    echo "<td class='accordion-body collapse' id='{$bikoret_id}'>";
                    echo "<table class='table table-bordered table-hover table-responsive'>";
                    echo "<thead class='bg-info'>";
                    echo "<td>פרוט סעיפים</td>";
                    echo "<td>לא תקין</td>";
                    echo "</thead>";
                    echo "<tbody>";

                    $query = "SELECT * FROM bikoret_dtl_tbl WHERE bikoret_id = {$bikoret_id}";
                    $result_bikoret_dtl = mysqli_query($connection, $query);
                    while ($rowDtl = mysqli_fetch_assoc($result_bikoret_dtl)) {
                        $bikoret_dtl_id = $rowDtl['bikoret_dtl_id'];
                        $bikoret_dtl = $rowDtl['bikoret_dtl'];
                        $mark = $rowDtl['mark'];
                        $numDtl = $numDtl+1;
                        array_push($dtl_array, $bikoret_dtl);
                        echo "<tr>";
                        echo "<td>{$bikoret_dtl}</td>";
                        echo "<td><input type='checkbox' name='mark$numDtl' value='no'></input></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</tr>";
                }
            echo    '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        $_SESSION['dtl_array'] = $dtl_array;
    echo '</div>';
}?>