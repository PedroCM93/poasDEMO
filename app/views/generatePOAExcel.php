<?php
require __DIR__ . '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Path of the images of the header and the letterhead footer 
$footerLetterHeadImagePath = "../public/assets/img/footerLetterhead.png";
$headerImagePath = "../public/assets/img/head.png";

/*** GENERAL DATA OF THE POA  */
$generalDescription = $poaData['GENERALDESCRIPTION'];
$fiscalYear = $poaData['FISCALYEAR'];
$productionDate = $poaData['PRODUCTIONDATE'];
$startDate= $poaData['STARTDATE'];
$endDate = $poaData['ENDDATE'];
$mainArea = $poaData['AREA'];
$subarea = $poaData['SUBAREA'];
$budgetType = $poaData['SPENDTYPE'];
$axisName = $poaData['AXISNAME'];
$actionLine = $poaData['ACTIONLINE'];
$pdiProject = $poaData['PDIPROJECT'];
$observations = $poaData['OBSERVATIONS'];
$estimatedTotal = $poaData['ESTIMATEDTOTAL'];
$executionMonthConcept = $poaData['MONTH'];
$executionYearConcept = $poaData['YEAR'];
$userWithAcademicTitle = $poaData['ACADEMICTITLEUSER'];

// Create the document
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


/** HEADER LOGO IMAGE  */
// Set the header image at the top of the document 
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
// Set the picture name
$drawing->setName('head.png');
// Set the picture path
$drawing->setPath( $headerImagePath );
// Set the cell address where the picture will be inserted
$drawing->setCoordinates("C1");
$drawing->setWorksheet($sheet);



// Set the name of the tab
$sheet->setTitle( substr($generalDescription, 0, 15 ) );

// Set column widths
$sheet->getColumnDimension('A')->setWidth(5); 
$sheet->getColumnDimension('B')->setWidth(80.14);
$sheet->getColumnDimension('C')->setWidth(52.43);
$sheet->getColumnDimension('D')->setWidth(70.57);
$sheet->getColumnDimension('E')->setWidth(60.57);
$sheet->getColumnDimension('F')->setWidth(40.57);
$sheet->getColumnDimension('G')->setWidth(15.29);
$sheet->getColumnDimension('H')->setWidth(16.86);
$sheet->getColumnDimension('I')->setWidth(12.86);
$sheet->getColumnDimension('J')->setWidth(10.29);

// Defines the bold borderline

$borderLine = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
            'color' => array('argb' => '00000000'),
        ),
    ),
);
// Defines the font style for the title 
$titleFontSize = [
    'font' => [
        'size' => 20
    ]
];

// Inner borders style
$innerBorders = [
    'borders' => [
        'inside' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
];

//Enable the auto-size 
$sheet->getRowDimension(2)->setRowHeight(-1); 

// Title 
$sheet ->getStyle('B9:I9')->applyFromArray($borderLine);
$sheet->getStyle("B9:I9")->applyFromArray($titleFontSize);
$sheet->setCellValue("B9","PLANEACIÓN OPERATIVO ANUAL DE ACTIVIDADES");
$sheet->mergeCells("B9:I9");
$sheet->getStyle('B9')->getFont()->setBold(true);
$sheet->getStyle('B9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Empty row
$sheet->mergeCells("B10:I10");

// General data of the POA
$sheet->setCellValue("B11", "Fecha de elaboración:");
$sheet->getStyle("B11")->getFont()->setBold(true);
$sheet->setCellValue("B12", "Descripción general:");
$sheet->getStyle('B12')->getFont()->setBold(true);
$sheet->setCellValue("B13", "Fecha de inicio:");
$sheet->getStyle('B13')->getFont()->setBold(true);
$sheet->setCellValue("B14", "Área");
$sheet->getStyle('B14')->getFont()->setBold(true);
$sheet->setCellValue("B15", "Subárea:");
$sheet->getStyle('B15')->getFont()->setBold(true);
$sheet->setCellValue("B16", "Gasto estratégico(marcar con X):");
$sheet->getStyle('B16')->getFont()->setBold(true);
$sheet->setCellValue("B17", "Eje Rector del PDI:");
$sheet->getStyle('B17')->getFont()->setBold(true);
$sheet->setCellValue("B18", "Línea de Acción del PDI");
$sheet->getStyle('B18')->getFont()->setBold(true);
$sheet->setCellValue("B19", "Proyecto o Meta del PDI:");
$sheet->getStyle('B19')->getFont()->setBold(true);

$sheet->getStyle('B20')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->setCellValue("B20", "Observaciones:");
$sheet->getStyle('B20')->getFont()->setBold(true);


$sheet->setCellValue("C11", $productionDate );
$sheet->mergeCells("C11:E11");
$sheet->setCellValue("F11","Ejercicio Fiscal:");
$sheet->getStyle("F11")->getFont()->setBold(true);

$sheet->setCellValue("G11", $fiscalYear);
$sheet->mergeCells("G11:I11");
$sheet->getStyle('G11')->getFont()->setBold(true);
$sheet->getStyle('G11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue("C12", $generalDescription);
$sheet->mergeCells("C12:I12");

$sheet->setCellValue("C13", $startDate );
$sheet->mergeCells("C13:D13");

$sheet->setCellValue("E13", "Fecha de término");
$sheet->mergeCells("E13:F13");
$sheet->getStyle('E13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E13')->getFont()->setBold(true);

$sheet->setCellValue("G13", $endDate );
$sheet->mergeCells("G13:I13");
$sheet->getStyle('G13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue("C14", $mainArea );
$sheet->mergeCells("C14:I14");

$sheet->setCellValue("C15", $subarea );
$sheet->mergeCells("C15:I15");


$sheet->setCellValue("B16","Gasto Estratégico(marcar con X):");
$sheet->getStyle('B16')->getFont()->setBold(true);

$sheet->mergeCells("C16:D16");
$sheet->getStyle('C16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C16')->getFont()->setBold(true);

$sheet->mergeCells("E16:F16");
$sheet->setCellValue("E16","Gasto corriente(marcar con X):");
$sheet->getStyle('E16')->getFont()->setBold(true);


$sheet->mergeCells("G16:I16");
$sheet->getStyle('G16')->getFont()->setBold(true);
$sheet->getStyle('G16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


// Marks the right budget type
if( $budgetType == 'corriente'){
    $sheet->setCellValue("G16","X"); // Marks the cell with the common budget account
}
else{
    $sheet->setCellValue("C16","X");// Marks the cell with the strategic budget account
}

$sheet->mergeCells("C17:I17");
$sheet->setCellValue("C17", $axisName );

$sheet->mergeCells("C18:I18");
$sheet->setCellValue("C18", $actionLine );

$sheet->mergeCells("C19:I19");
$sheet->setCellValue("C19",$pdiProject );

$sheet->getStyle('C20:I20')->getAlignment()->setWrapText(true);
$sheet->mergeCells("C20:I20");
$sheet->setCellValue("C20",$observations );


//Set the border line and the inner borders on the general data of the POA
$sheet->getRowDimension(20)->setRowHeight(50);
$sheet->getRowDimension(23)->setRowHeight(40);
$sheet ->getStyle('B11:I20')->applyFromArray($borderLine);
$sheet ->getStyle('B11:I20')->applyFromArray($innerBorders);


// Set a blank row
$sheet->mergeCells("B21:I21");

/*** CONCEPTS PART */
// Headers
$sheet->mergeCells("B22:B23");
$sheet->getStyle('B22')->getFont()->setBold(true);
$sheet->getStyle('B22')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('B22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("B22","Concepto o Actividad");

$sheet->mergeCells("C22:D22");
$sheet->getStyle('C22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C22')->getFont()->setBold(true);
$sheet->setCellValue("C22","Plan Operativo Anual(POA)");

$sheet->mergeCells("E22:I22");
$sheet->getStyle('E22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E22')->getFont()->setBold(true);
$sheet->setCellValue("E22","Presupuesto $fiscalYear");

$sheet->getStyle('C23')->getFont()->setBold(true);
$sheet->getStyle('C23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('C23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("C23","Evidencia");

$sheet->getStyle('D23')->getFont()->setBold(true);
$sheet->getStyle('D23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('D23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("D23","Fecha de ejecución");

$sheet->getStyle('E23')->getFont()->setBold(true);
$sheet->getStyle('E23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('E23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("E23","Responsable(s)");

$sheet->getStyle('F23')->getFont()->setBold(true);
$sheet->getStyle('F23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('F23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("F23","Cantidad");



$sheet->getStyle('G23')->getFont()->setBold(true);
$sheet->getStyle('G23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('G23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("G23","Unidad");

$sheet->getStyle('H23')->getFont()->setBold(true);
$sheet->getStyle('H23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('H23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("H23","Costo Unitario");

$sheet->getStyle('I23')->getFont()->setBold(true);
$sheet->getStyle('I23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('I23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("I23","Importes");


// Store the number of the concepts of the POA
$numberOfConcepts = count( $poaConcepts );
$currentRow = 24;// Current row to write the following cells values 
// And then loop through the concepts array with the respective row and cell 
for( $concept = 0, $currentRow; $concept < $numberOfConcepts ; $concept++){
    for( $cell = 0, $rowLetter = "B"; $cell < 8; $cell++, $rowLetter++ ){
        $currentCell = $rowLetter . $currentRow;
        if( $cell != 0 && $cell != 1 && $cell != 2 )// The first column ( name of the concept will not be centered )
            $sheet->getStyle( $currentCell )->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle( $currentCell )->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue($currentCell, $poaConcepts[$concept][$cell]);
    }
    $currentRow++;
}
// Set the borders of the header
$sheet->getStyle("B22:I$currentRow")->applyFromArray($borderLine);
$sheet->getStyle("B22:I$currentRow")->applyFromArray($innerBorders);
//$sheet->getStyle("B8:H8")->applyFromArray($titleFontSize);


$sheet->mergeCells("A$currentRow:H$currentRow");
$sheet->getStyle("A$currentRow")->getFont()->setBold(true);
$sheet->getStyle("A$currentRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("A$currentRow","Costo estimado del proyecto");

$sheet->setCellValue("I$currentRow", $estimatedTotal );
$sheet->getStyle("I$currentRow")->getFont()->setBold(true);
$sheet->getStyle("I$currentRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


$nextRow = $currentRow + 1;
$sheet->mergeCells("B$nextRow:I$nextRow");
$sheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

/*** FOOTER  */
//Stores the next row 
$nextRow += 1 ;
$sheet->getStyle("B$nextRow")->getFont()->setBold(true);
$sheet->setCellValue("B$nextRow", "Nota:");

$nextRow += 1;
$sheet->mergeCells("B$nextRow:I$nextRow");
$sheet->getStyle("B$nextRow")->getFont()->setBold(true);
$sheet->setCellValue("B$nextRow","\"Aprobado\" con las salvedades de que exista suficiencia presupuestal y de que no existan cambios en: precios, políticas públicas,");

$nextRow += 1;
$sheet->mergeCells("B$nextRow:I$nextRow");
$sheet->getStyle("B$nextRow")->getFont()->setBold(true);
$sheet->setCellValue("B$nextRow","planes y programas, o de cualquier otra situación interna o externa, que modifiquen o cancelen este proyecto.");



// The responsible name on the footer
$nextRow += 7;
$sheet->mergeCells("B$nextRow:F$nextRow");
$sheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("B$nextRow")->getFont()->setUnderline(true);
$sheet->getStyle("B$nextRow")->getFont()->setBold(true);
$sheet->setCellValue("B$nextRow",$userWithAcademicTitle );


$nextRow += 1;
$sheet->mergeCells("B$nextRow:F$nextRow");
$sheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("B$nextRow")->getFont()->setBold(true);
$sheet->setCellValue("B$nextRow",$subarea );



$nextRow += 8;
/*** FOOTER LETTERHEAD IMAGE  */
// Set the header image at the top of the document 
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
// Set the picture name
$drawing->setName('footerLetterhead.png');
// Set the picture path
$drawing->setPath( $footerLetterHeadImagePath );
// Set the cell address where the picture will be inserted
$drawing->setCoordinates("C$nextRow");
$drawing->setHeight(150);
$drawing->setWidth(900);
$drawing->setWorksheet($sheet);





// Clear output buffer

if (ob_get_contents()) {
    ob_clean();
}
//ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="plan_operativo_2025.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
