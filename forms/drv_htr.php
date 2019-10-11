<?php
    $query = ("SELECT * FROM drv_htr WHERE car_id = $car_id");
    if (!$result = mysqli_query($connection, $query)) {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };
?>

<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-primary col-sm-12">
            <table class="table table-bordered table-hover table-responsive table-condensed">
                <thead>
                    <tr class="bg-primary">
                        <th style="text-align:right">שם הנהג</th>
                        <th style="text-align:right">שם ההיתר</th>
                        <th style="text-align:right">לחדש בתאריך</th>
                     </tr>
                </thead>
                <body>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $htr_id = $row['htr_id'];
                            $drv_name = $row['drv_name'];
                            $htr_name = $row['htr_name'];
                            $htr_date = new DateTime($row['htr_date']);

                            echo "<tr>";
                            echo "<td>{$drv_name}</td>";
                            echo "<td>{$htr_name}</td>";
                            echo "<td>{$htr_date->format('d/m/Y')}</td>";
                            echo "<td><button type='button' class='btn btn-default'><a href = 'drv_htr_edit.php?htr_id={$htr_id}'><span class='glyphicon glyphicon-edit'</a></span></button></td>";
                            echo "</tr>";
                        };
                    ?>
                </body>
            </table>
        </div>
    </div>
</div>
