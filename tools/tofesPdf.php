<?php include ('../includes/header.php'); ?>

<?php
    function get_data(){
        global $connection;
        $output = '';
        $query = "SELECT * FROM bikoret_dtl_tbl LEFT JOIN bikoret_tbl ON bikoret_dtl_tbl.bikoret_id = bikoret_tbl.bikoret_id ORDER BY bikoret_tbl.bikoret_id";
        $result = mysqli_query($connection, $query);
        $bikoret_id = '';
        while ($row = mysqli_fetch_array($result)){
            $pass = ' <img src="../images/checkmark.png"  width="20" height="20">
';                        
            if (in_array($row['bikoret_dtl_id'], $_SESSION['arBkrDtlFault_id'])){
                $pass = '<img src="../images/uncheckmark.png"  width="20" height="20">
';
            }
            
            if ($row["bikoret_id"] != $bikoret_id) {
                $output .= '
                    <tr>
                        <td colspan="2" align="center"><h4>'.$row["bikoret"].'</h4></td>
                    </tr>
                    <tr>
                        <td width="80%">'.$row["bikoret_dtl"].'</td>
                        <td width="20%">'.$pass.'</td>
                    </tr>
                ';
                $bikoret_id = $row["bikoret_id"];
            } else {
                $output .= '
                    <tr>
                        <td>'.$row["bikoret_dtl"].'</td>
                        <td>'.$pass.'</td>
                    </tr>
                ';
            }
        }
        return $output;
    }
?>

<?php
require_once '../tcpdf/tcpdf.php';

if (isset($_GET['inspect_done'])) {    
    $inspect_done = $_GET['inspect_done'];
    $remark = str_replace('\n', PHP_EOL, $_SESSION['remarks']);    
    $remark = str_replace('\r', '', $remark);
    $client_name =  $_GET['client_name'];
    $car_type =  $_GET['car_type'];
    $car_km =  $_GET['car_km'];
    if ($car_km == NULL){
        $car_km = '';
    }
    
    $query = "SELECT name, tel1, tel2, email FROM company";
    $result = mysqli_query($connection, $query);
    if (!$result = mysqli_query($connection, $query)) {
        echo "Error: " . "<br>" . mysqli_error($connection);
    }
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $tel1 = $row['tel1'];
    $tel2 = $row['tel2'];
    $email = $row['email'];
};

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setRTL(true);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setPrintHeader(false);

$pdf->AddPage();
$pdf->SetFont('dejavusans', 'BI', 16);
$pdf->Write(0, $name);
$pdf->Ln(7);
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->Write(0, 'טלפונים: ');
$pdf->Write(0, $tel1 . '  ');
$pdf->Write(0, '    '.$tel2);
$pdf->Write(0, 'דואר אלקטרוני: ');
$pdf->Write(0, $email);

$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(5, 25, 200, 25, $style);

$pdf->Ln(14);
$pdf->SetFont('dejavusans', 'B', 14);
$pdf->Write(0, 'ביקורת קצין בטיחות לרכב: ');
$pdf->SetFont('dejavusans', '', 14);
$pdf->Write(0, '98765432');
$pdf->Write(0, '                ');
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Write(0, 'תאריך ביקורת: ');
$pdf->SetFont('dejavusans', '', 12);
$pdf->Write(0, $inspect_done);

$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Ln(16);
$pdf->Write(0, 'שם החברה: ');
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->Write(0, $client_name);
$pdf->Ln(8);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Write(0, 'סוג הרכב: ');
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->Write(0, $car_type);
$pdf->Ln(8);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Write(0, 'מד אוץ בבדיקה: ');
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->Write(0, $car_km);
$pdf->Ln(8);

$pdf->SetFont('dejavusans', 'BU', 12);
$pdf->Ln(15);
$pdf->Write(0, 'ליקויים שנמצאו בביקורת');
$pdf->SetFont('dejavusans', 'I', 12);
$pdf->Ln(10);
$pdf->Write(0, $remark);

$pdf->SetFont('dejavusans', 'BU', 12);
$pdf->Ln(5);
$pdf->Write(0, 'רשימת בדיקות: ');
$pdf->Ln(10);
$pdf->SetFont('dejavusans', 'I', 12);

    $content = '';
    $content .= '<table border="1" width="80%" cellpadding="5">';
    $content .= get_data();
    $content .= '</table>';
    $pdf->writeHTML($content);

$pdf->setXY(120, 250);
$pdf->SetFont('dejavusans', '', 12);
$pdf->Write(0, 'חתימת איש קשר');
$pdf->setJPEGQuality(75);
$pdf->Image('../images/signature.png', 95, 255, 45, 15, 'PNG');

ob_end_clean();
$path=$_SERVER['DOCUMENT_ROOT'].'kochavitmob/files_from_web/documents/';

$pdf->Output($path . 'ביקורת חודשית ' . date("F") .' ' . date("Y") . '_C' . $_SESSION['car_id'] . '.pdf', 'F');

header('Location: ../tests/tests.php');
 ?>
 
<?php include '../includes/footer.php'; ?>