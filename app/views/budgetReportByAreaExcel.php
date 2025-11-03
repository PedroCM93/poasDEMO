<?php
require __DIR__ . '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Path of the images of the header and the letterhead footer 
$footerLetterHeadImagePath = "../public/assets/img/footerLetterhead.png";
$headerImagePath = "../public/assets/img/head.png";

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
$drawing->setCoordinates("D1");
$drawing->setWorksheet($sheet);


// Set the name of the tab
$sheet->setTitle( substr("Planeación Operativa Anual", 0, 15 ) );

// Set column widths
$sheet->getColumnDimension('A')->setWidth(5); // First column ( Empty )
$sheet->getColumnDimension('B')->setWidth( 10 ); // Second column( Area code )
$sheet->getColumnDimension('C')->setWidth(90.43); // Third column ( Area name )
$sheet->getColumnDimension('D')->setWidth(70.57); // Fourth column( Strategic budget  )
$sheet->getColumnDimension('E')->setWidth(40.57); // Fifth column ( Common budget )
$sheet->getColumnDimension('F')->setWidth(40.57); // Sixth column ( Total amount )
$sheet->getColumnDimension('G')->setWidth(15.29); // Seventh column ( blank space )
$sheet->getColumnDimension('H')->setWidth(60.43); // Eight column ( Responsibles )


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
        'size' => 12
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
$sheet->getStyle("C9:E9")->applyFromArray($titleFontSize);
$sheet->setCellValue("C9","Planeación Operativa Anual 2025");
$sheet->mergeCells("C9:E9");
$sheet->getStyle('C9')->getFont()->setBold(true);
$sheet->getStyle('C9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Subtitle
$sheet->getStyle("C10:E10")->applyFromArray($titleFontSize);
$sheet->setCellValue("C10","Presupuestos por Área");
$sheet->mergeCells("C10:E10");
$sheet->getStyle('C10')->getFont()->setBold(true);
$sheet->getStyle('C10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



/*** TABLE HEADER  */
/*
$sheet->mergeCells("B12:B13");
$sheet->setCellValue("B12", "Código");
$sheet->getStyle('B12')->getFont()->setBold(true);
$sheet->getStyle('B12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('B12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
*/
// Writes the header of the table
writeLine( $sheet, "H", "Y", "Y", "B12", "Código", "B13");
writeLine( $sheet, "H", "Y", "Y", "C12", "Área/Subárea", "C13");
writeLine( $sheet, "H", "Y", "Y", "D12", "Tipo de Gasto", "F12");
writeLine( $sheet, "H", "Y", "Y", "D13", "Estratégico");
writeLine( $sheet, "H", "Y", "Y", "E13", "Corriente");
writeLine( $sheet, "H", "Y", "Y", "F13", "Total");   
writeLine( $sheet, "H", "Y", "Y", "H12", "Firma del responsable");   


/*** AREAS AND SUBAREAS( WITH DERIVATED AREAS )  */
$mainArea = "";
$subarea = "";
$currentRow = 14;
foreach( $areas as $area ):
    $areaCode = $area['AREACODE'];
    $areaName = $area['MAINAREA'];
    $subareaCode = $area['SUBAREACODE'];
    $subareaName = $area['SUBAREA'];
    $derivatedAreaCode = $area['DERIVATEDAREACODE'];
    $derivatedAreaName = $area['DERIVATEDAREA'];
    $responsibleName = $area['RESPONSIBLE'] ?? "";
    // Write the main area name in bold 
    if( $mainArea !=  $areaName ){
        $currentRow++;
        $mainArea = $areaName;
        writeLine( $sheet, "H", "N", "Y", "B$currentRow", $areaCode );
        writeLine( $sheet, "H", "N", "Y", "C$currentRow", $areaName );
    }
    // Write the subareas name 
    if( $subarea != $subareaName && $derivatedAreaCode == null  ){
        $currentRow++;
        $subArea = $subareaName;
        writeLine( $sheet,"N", "N", "Y", "B$currentRow", $subareaCode );
        writeLine( $sheet,"N", "N", "Y", "C$currentRow", $subareaName );
        writeLine( $sheet,"N", "N", "N", "H$currentRow", $responsibleName ); // Responsible name without the border ( Like the printed format )
    }
    // Write the derivated areas ( from the subareas )
    if( $derivatedAreaName != null ){
        $currentRow++;
        writeLine( $sheet, "N","N","Y","B$currentRow", $derivatedAreaCode );
        writeLine( $sheet, "N","N","Y","C$currentRow", $derivatedAreaName );
        writeLine( $sheet, "N","N","N","H$currentRow", $responsibleName );// Same for the derivated areas 
    }
endforeach;

// Clear output buffer
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="plan_operativo_2025.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;




// Auxiliar function that writes a line in the document, take  7 parameters ( 6 required, 1 optional )
/**
 * 
 * First parameter is the active sheet
 * Second parameter means if the cell is a header( H or h value ) or a normal cell ( other value )
 * Third parameter if you want the call value horizontally centered ( Y or y value )
 * Fourth paramter if you want the cell value with borders ( inner and outside )
 * Fifth parameter is the cell location
 * Sixth parameter is the value that will store the cell
 * Seventh parameter if you want to merge the selected cell with a range of cells ( one or several ) 
 * 
 */
function writeLine(  &$activesheet, string $type, string $horizontalCenter,  string $withBorders, string $cell, string $cellValue, string $mergeCell = "" ): void{
    // Inner borders style
    $innerBorders = [
        'borders' => [
            'inside' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
    // Defines the bold borderline
    $borderLine = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                'color' => array('argb' => '00000000'),
            ),
        ),
    );
    // If there's a range of cells then apply
    if( $mergeCell != "" ){ 
        $activesheet->mergeCells("$cell:$mergeCell");
    }
    // If want the cell to have borders 
    if( $withBorders == 'Y' || $withBorders == 'y' ){
        $activesheet->getStyle( ( $mergeCell != "" ? "$cell:$mergeCell" : "$cell"  ) )->applyFromArray($innerBorders);
        $activesheet->getStyle( ( $mergeCell != "" ? "$cell:$mergeCell" : "$cell"  ) )->applyFromArray($borderLine);
    }
    // Set the value on the cell 
    $activesheet->setCellValue( $cell, $cellValue );
    // If its a header cell 
    if( $type == "H" || $type == 'h')
        $activesheet->getStyle($cell)->getFont()->setBold(true);
    // Vertically centers the value on the cell 
    $activesheet->getStyle($cell)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // If want to horizontally center the content 
    if( $horizontalCenter == 'Y' || $horizontalCenter == 'y' )
        $activesheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}
?>
