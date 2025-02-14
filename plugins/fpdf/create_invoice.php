<?php
date_default_timezone_set("Africa/Kampala");


$id = htmlspecialchars(( isset( $_REQUEST['id'] ) )?  $_REQUEST['id']: null);

class PDF extends FPDF
{
function Header()
{
	//Invoice Title
	$this->SetFont('Times','B',30);
    $this->Cell(120);
	$this->SetTextColor(34,40,103);
    $this->Cell(4,30,'INVOICE',0,'C');
	$this->SetFont('Times','U',12);
	$this->SetTextColor(0);
	$this->Ln(20);
	$this->Cell(120);
	$this->Cell(4,10,'Invoice Date-Time',0,'C');
	$this->Ln(0);
    $this->Cell(170);
    $this->Cell(4,10,'No.',0,'U');
	$this->ln();
	$this->Ln(-2);
	//Content
	$this->SetFont('Times','',12);
	$this->Cell(120);
	$this->Cell(4,10,date('d-M-y H:i'),0,'C');
	$this->Ln(0);
    $this->Cell(160);
	$this->SetFont('Times','B',15);
	$this->SetTextColor(34,40,103);
    $this->Cell(4,10,'RPE'.mt_rand(111111,999999),0,'C');
    
	//Logo
    $this->Image('logo_bg_w.png',9,8,70);
	//Content below the logo
	$this->Ln(5);
	$this->SetTextColor(0);
	$this->SetFont('Times','',12);
	$this->Cell(2,5,'Suite R10, Level 4,');
	$this->ln();
	$this->Cell(2,5,'MM PLaza, Luwum Street,');
	$this->ln();
	$this->Cell(2,5,'Kampala - Uganda');
	$this->ln();
	$this->Cell(2,5,'Tell: 0753800555/0774923220');
	$this->Ln(8);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(11,15,60);
    $this->SetTextColor(255);
    //$this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(100, 20, 35);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],5,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],7,$row['name'],'LR',0,'L',$fill);
        $this->Cell($w[1],7,$row['qty'],'LR',0,'R',$fill);
		if($row['price']!=null){
        $this->Cell($w[2],7, number_format($row['price']),'LR',0,'R',$fill);
		}else{
		 $this->Cell($w[2],7, $row['price'],'LR',0,'R',$fill);
		}	
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

function grandTitle($label)
{
    $this->SetFillColor(174,209,135);
    $this->Cell(45,6,"$label",10,1,'L',true);
}
}

$pdf = new PDF();
// Column headings
$header = array('Item', 'Qty', 'Price(UGX)');
/*----------------------------Calculating package prices______________________*/
$total = 0;
$data = DB::query('Select * from client_request where client_id=%s',$id);
foreach($data as $d_price){
	$total = $total + $d_price['price'];
}
$function = DB::queryFirstRow('select * from introductions where client_id=%s',$id);
if(isset($function['package'])){
$pack_price = DB::queryFirstRow('select * from package where id=%s',$function['package']);
}
else{
$function = DB::queryFirstRow('select * from weddings where client_id=%s',$id);
$pack_price = DB::queryFirstRow('select * from package where id=%s',$function['package']);
}


$pdf->AliasNbPages();
$pdf->AddPage();
$name = DB::queryFirstRow('Select * from clients where id=%s',$id);
$pdf->SetFont('Arial','',13);
$pdf->Cell(100,10,'Bill To:  '.$name['name'].'','');
$pdf->Cell(100,10,package($id),'');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header,$data);
$pdf->Ln(1);
$pdf->cell(150);
$pdf->Cell(100,10,'Package Total: '.number_format($pack_price['price']).'/-','');
$pdf->Ln(6);
$pdf->cell(150);
$pdf->Cell(100,10,'Extras Total: '.number_format($total).'/-','');
$pdf->Ln(8);
$pdf->cell(150);
$title = 'Grand Total: '.number_format($pack_price['price'] + $total).'/-';
$pdf->grandTitle($title);
$pdf->Cell(100,10,'Notes:','');
$pdf->Ln(4);
$pdf->Cell(100,10,'All Prices are non-negotiable','');
$pdf->ln();
$pdf->Cell(100,10,'Terms and Conditions:','');
$pdf->Ln(4);
$pdf->Cell(100,10,'- 80% must be cleared before the function date.','');
$pdf->Ln(4);
$pdf->Cell(100,10,'- There will be no coverage allowed before completion of 80% payment.','');
$pdf->Ln(4);
$pdf->Cell(100,10,'- A booking fee of 20% shall be required  2 months in advance to secure any date.','');
$pdf->Ln(4);
$pdf->Cell(100,10,'- No dates shall be secured without a booking fee.','');
$pdf->Ln(10);
$pdf->cell(45);
$pdf->SetFont('Arial','i',8);
$pdf->Cell(100,10,'"In photography there is a reality so subtle that it becomes more real than reality."','');
$pdf->Ln(5);
$pdf->cell(50);
$pdf->SetFont('Arial','',8);
$pdf->Cell(100,10,'** Thank you for choosing Russell Pictures Entertainment **','');
$pdf->Output();
?>