<?php
    function get_data(){
        global $connection;
        $output = '';
        $query = "SELECT * FROM bikoret_dtl_tbl LEFT JOIN bikoret_tbl ON bikoret_dtl_tbl.bikoret_id = bikoret_tbl.bikoret_id ORDER BY bikoret_tbl.bikoret_id";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)){
            $bikoret_id = $row['bikoret_id'];
            
            $output .= '
                <tr>
                    <td>'.$row['bikoret'].'</td>
                    <td>'.'תקין'.'</td>
                </tr>
            '
            while (($row['bikoret_id']) = $bikoret_id){
                $output .= '
                    <tr>
                        <td>'.$row['bikoret_dtl'].'</td>
                        <td>'.'תקין'.'</td>
                    </tr>
                ';
            }
        }
    return $output;
    }
?>
      
<?php
    require '../tcpdf/tcpdf.php';

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //$pdf = new TCPDF;                   // create TCPDF object with default constructor args
    $pdf->AddPage();                    // pretty self-explanatory
    $pdf->setRTL(true);


    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    $pdf->SetFont('dejavusans', '', 14);
    $pdf->Write(1, 'ביקורת רכב קצין בטיחות בתעבורה: ');
    $pdf->Write(1, $_SESSION['user_full_name'], 'nil', 0, '', true);
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->Write(1, '', 'nil', 0, '', true);
    $pdf->Write(20, 'תאריך ביקורת: ');
    $date = date_create($inspect_done);
    $pdf->Write(20, date_format($date,"d/m/Y"), nil, 0, '', true);

    $pdf->Cell(70, 5, 'שם החברה: ', 1);
    $pdf->Cell(30, 5, 'רשיון מספר: ', 1);
    $pdf->Cell(50, 5, 'סוג רכב: ', 1);
    $pdf->Write(1, '', '', 0, '', true);

    $pdf->Cell(70, 5, $client_name, 1);
    $pdf->Cell(30, 5, $car_number, 1);
    $pdf->Cell(50, 5, $car_type, 1);
    $pdf->Write(10, '', '', 0, '', true);

    $pdf->SetFont('dejavusans', '', 14);
    $pdf->Write(10, 'רשימת הליקויים בביקורת: ', '', 0, '', true);
    $pdf->SetFont('dejavusans', '', 12);
    $remarkFix = str_replace("r", PHP_EOL, $_SESSION['remarks']);
    $remarkFix = str_replace("\\", '' , $remarkFix);
    $remarkFix = str_replace("n", '' , $remarkFix);
    $pdf->Write(1, $remarkFix, '', 0, '', true);
    
    $pdf->SetFont('dejavusans', '', 14);
    $pdf->Write(10, '', 'רשימת בדיקות: ', '0', '', true);
    
    $content = '';
    $content .= '<table border="1" cellspacing="0" cellpading="5">';
    $content .= get_data();
    $content .= '</table>';
    $pdf->writeHTML($content);

    $pdf->SetXY(175, 210);
    $pdf->Write(1, 'חתימה');
    $pdf->Image('../images/signature.png', 90, 200, 60, 20, 'PNG', '', '', false, 200, '', false, false, 0, false, false, false);
    ob_end_clean();
    $path = '/home/sorinh/public_html/kochavitmob/files_from_web/documents';
//    $path = 'D:/wamp64/www/kochavitmob/files_from_web/documents';
    $pdf->Output($path . '/Test_' . date("F") .'-' . date("y") . '_C' . $car_id . '.pdf', 'F');
    //$pdf->Output('inspect.pdf', 'I');
?>