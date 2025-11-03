<?php


require __DIR__ . '../../../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Path of the images of the header and the letterhead footer 
$footerLetterHeadImagePath = "../public/assets/img/footerLetterhead.png";
$headerImagePath = "../public/assets/img/head.png";




// Create the spreadsheet 
$spreadsheet = new SpreadSheet();

foreach( $poasFromSubarea as $poa ):
    $newSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $poa['SHEETNAME'] );
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    // Set the picture name
    $drawing->setName('head.png');
    // Set the picture path
    $drawing->setPath( $headerImagePath );
    // Set the cell address where the picture will be inserted
    $drawing->setCoordinates("C1");

    $drawing->setWorksheet($newSheet);
    $spreadsheet->addSheet($newSheet);
    $generalDescription = $poa['GENERALDATA']['GENERALDESCRIPTION'];
    $fiscalYear = $poa['GENERALDATA']['FISCALYEAR'];
    $productionDate = $poa['PRODUCTIONDATE'];
    $startDate= $poa['GENERALDATA']['STARTDATE'];
    $endDate = $poa['GENERALDATA']['ENDDATE'];
    $mainArea = $poa['GENERALDATA']['AREA'];
    $subarea = $poa['GENERALDATA']['SUBAREA'];
    $budgetType = $poa['SPENDTYPE'];
    $axisName = $poa['GENERALDATA']['AXISNAME'];
    $actionLine = $poa['GENERALDATA']['ACTIONLINE'];
    $pdiProject = $poa['GENERALDATA']['PDIPROJECT'];
    $observations = $poa['OBSERVATIONS'];
    $estimatedTotal = $poa['GENERALDATA']['ESTIMATEDTOTAL'];
    $executionMonthConcept = $poa['GENERALDATA']['MONTH'];
    $executionYearConcept = $poa['GENERALDATA']['YEAR'];
    $userWithAcademicTitle = $poa['GENERALDATA']['ACADEMICTITLEUSER'];
    // Set column widths
    $newSheet->getColumnDimension('A')->setWidth(5); 
    $newSheet->getColumnDimension('B')->setWidth(80.14);
    $newSheet->getColumnDimension('C')->setWidth(52.43);
    $newSheet->getColumnDimension('D')->setWidth(70.57);
    $newSheet->getColumnDimension('E')->setWidth(60.57);
    $newSheet->getColumnDimension('F')->setWidth(40.57);
    $newSheet->getColumnDimension('G')->setWidth(15.29);
    $newSheet->getColumnDimension('H')->setWidth(16.86);
    $newSheet->getColumnDimension('I')->setWidth(12.86);
    $newSheet->getColumnDimension('J')->setWidth(10.29);

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
    $newSheet->getRowDimension(2)->setRowHeight(-1); 
    // Title 
    $newSheet ->getStyle('B9:I9')->applyFromArray($borderLine);
    $newSheet->getStyle("B9:I9")->applyFromArray($titleFontSize);
    $newSheet->setCellValue("B9","PLANEACIÓN OPERATIVO ANUAL DE ACTIVIDADES");
    $newSheet->mergeCells("B9:I9");
    $newSheet->getStyle('B9')->getFont()->setBold(true);
    $newSheet->getStyle('B9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    // Empty row
    $newSheet->mergeCells("B10:I10");

    // General data of the POA
    $newSheet->setCellValue("B11", "Fecha de elaboración:");
    $newSheet->getStyle("B11")->getFont()->setBold(true);
    $newSheet->setCellValue("B12", "Descripción general:");
    $newSheet->getStyle('B12')->getFont()->setBold(true);
    $newSheet->setCellValue("B13", "Fecha de inicio:");
    $newSheet->getStyle('B13')->getFont()->setBold(true);
    $newSheet->setCellValue("B14", "Área");
    $newSheet->getStyle('B14')->getFont()->setBold(true);
    $newSheet->setCellValue("B15", "Subárea:");
    $newSheet->getStyle('B15')->getFont()->setBold(true);
    $newSheet->setCellValue("B16", "Gasto estratégico(marcar con X):");
    $newSheet->getStyle('B16')->getFont()->setBold(true);
    $newSheet->setCellValue("B17", "Eje Rector del PDI:");
    $newSheet->getStyle('B17')->getFont()->setBold(true);
    $newSheet->setCellValue("B18", "Línea de Acción del PDI");
    $newSheet->getStyle('B18')->getFont()->setBold(true);
    $newSheet->setCellValue("B19", "Proyecto o Meta del PDI:");
    $newSheet->getStyle('B19')->getFont()->setBold(true);

    $newSheet->getStyle('B20')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->setCellValue("B20", "Observaciones:");
    $newSheet->getStyle('B20')->getFont()->setBold(true);


    $newSheet->setCellValue("C11", $productionDate );
    $newSheet->mergeCells("C11:E11");
    $newSheet->setCellValue("F11","Ejercicio Fiscal:");
    $newSheet->getStyle("F11")->getFont()->setBold(true);

    $newSheet->setCellValue("G11", $fiscalYear);
    $newSheet->mergeCells("G11:I11");
    $newSheet->getStyle('G11')->getFont()->setBold(true);
    $newSheet->getStyle('G11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $newSheet->setCellValue("C12", $generalDescription);
    $newSheet->mergeCells("C12:I12");

    $newSheet->setCellValue("C13", $startDate );
    $newSheet->mergeCells("C13:D13");

    $newSheet->setCellValue("E13", "Fecha de término");
    $newSheet->mergeCells("E13:F13");
    $newSheet->getStyle('E13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle('E13')->getFont()->setBold(true);

    $newSheet->setCellValue("G13", $endDate );
    $newSheet->mergeCells("G13:I13");
    $newSheet->getStyle('G13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $newSheet->setCellValue("C14", $mainArea );
    $newSheet->mergeCells("C14:I14");

    $newSheet->setCellValue("C15", $subarea );
    $newSheet->mergeCells("C15:I15");


    $newSheet->setCellValue("B16","Gasto Estratégico(marcar con X):");
    $newSheet->getStyle('B16')->getFont()->setBold(true);

    $newSheet->mergeCells("C16:D16");
    $newSheet->getStyle('C16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle('C16')->getFont()->setBold(true);

    $newSheet->mergeCells("E16:F16");
    $newSheet->setCellValue("E16","Gasto corriente(marcar con X):");
    $newSheet->getStyle('E16')->getFont()->setBold(true);


    $newSheet->mergeCells("G16:I16");
    $newSheet->getStyle('G16')->getFont()->setBold(true);
    $newSheet->getStyle('G16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


    // Marks the right budget type
    if( $budgetType == 'corriente'){
        $newSheet->setCellValue("G16","X"); // Marks the cell with the common budget account
    }
    else{
        $newSheet->setCellValue("C16","X");// Marks the cell with the strategic budget account
    }

    $newSheet->mergeCells("C17:I17");
    $newSheet->setCellValue("C17", $axisName );

    $newSheet->mergeCells("C18:I18");
    $newSheet->setCellValue("C18", $actionLine );

    $newSheet->mergeCells("C19:I19");
    $newSheet->setCellValue("C19",$pdiProject );

    $newSheet->getStyle('C20:I20')->getAlignment()->setWrapText(true);
    $newSheet->mergeCells("C20:I20");
    $newSheet->setCellValue("C20",$observations );


    //Set the border line and the inner borders on the general data of the POA
    $newSheet->getRowDimension(20)->setRowHeight(50);
    $newSheet->getRowDimension(23)->setRowHeight(40);
    $newSheet ->getStyle('B11:I20')->applyFromArray($borderLine);
    $newSheet ->getStyle('B11:I20')->applyFromArray($innerBorders);
    // Set a blank row
    $newSheet->mergeCells("B21:I21");

    /*** CONCEPTS PART */
    // Headers
    $newSheet->mergeCells("B22:B23");
    $newSheet->getStyle('B22')->getFont()->setBold(true);
    $newSheet->getStyle('B22')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('B22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("B22","Concepto o Actividad");

    $newSheet->mergeCells("C22:D22");
    $newSheet->getStyle('C22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle('C22')->getFont()->setBold(true);
    $newSheet->setCellValue("C22","Plan Operativo Anual(POA)");

    $newSheet->mergeCells("E22:I22");
    $newSheet->getStyle('E22')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle('E22')->getFont()->setBold(true);
    $newSheet->setCellValue("E22","Presupuesto $fiscalYear");

    $newSheet->getStyle('C23')->getFont()->setBold(true);
    $newSheet->getStyle('C23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('C23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("C23","Evidencia");

    $newSheet->getStyle('D23')->getFont()->setBold(true);
    $newSheet->getStyle('D23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('D23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("D23","Fecha de ejecución");

    $newSheet->getStyle('E23')->getFont()->setBold(true);
    $newSheet->getStyle('E23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('E23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("E23","Responsable(s)");

    $newSheet->getStyle('F23')->getFont()->setBold(true);
    $newSheet->getStyle('F23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('F23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("F23","Cantidad");



    $newSheet->getStyle('G23')->getFont()->setBold(true);
    $newSheet->getStyle('G23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('G23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("G23","Unidad");

    $newSheet->getStyle('H23')->getFont()->setBold(true);
    $newSheet->getStyle('H23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('H23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("H23","Costo Unitario");

    $newSheet->getStyle('I23')->getFont()->setBold(true);
    $newSheet->getStyle('I23')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $newSheet->getStyle('I23')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("I23","Importes");    

    $poaConcepts = $poa['CONCEPTS'];
    // Store the number of the concepts of the POA
    $numberOfConcepts = count( $poaConcepts );
    $currentRow = 24;// Current row to write the following cells values 
    // And then loop through the concepts array with the respective row and cell 
    for( $concept = 0, $currentRow; $concept < $numberOfConcepts ; $concept++){
        for( $cell = 0, $rowLetter = "B"; $cell < 8; $cell++, $rowLetter++ ){
            $currentCell = $rowLetter . $currentRow;
            if( $cell != 0 && $cell != 1 && $cell != 2 )// The first column ( name of the concept will not be centered )
                $newSheet->getStyle( $currentCell )->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $newSheet->getStyle( $currentCell )->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $newSheet->setCellValue($currentCell, $poaConcepts[$concept][$cell]);
        }
        $currentRow++;
    }
    // Set the borders of the header
    $newSheet->getStyle("B22:I$currentRow")->applyFromArray($borderLine);
    $newSheet->getStyle("B22:I$currentRow")->applyFromArray($innerBorders);
    //$newSheet->getStyle("B8:H8")->applyFromArray($titleFontSize);


    $newSheet->mergeCells("A$currentRow:H$currentRow");
    $newSheet->getStyle("A$currentRow")->getFont()->setBold(true);
    $newSheet->getStyle("A$currentRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->setCellValue("A$currentRow","Costo estimado del proyecto");

    $newSheet->setCellValue("I$currentRow", $estimatedTotal );
    $newSheet->getStyle("I$currentRow")->getFont()->setBold(true);
    $newSheet->getStyle("I$currentRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


    $nextRow = $currentRow + 1;
    $newSheet->mergeCells("B$nextRow:I$nextRow");
    $newSheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    /*** FOOTER  */
    //Stores the next row 
    $nextRow += 1 ;
    $newSheet->getStyle("B$nextRow")->getFont()->setBold(true);
    $newSheet->setCellValue("B$nextRow", "Nota:");

    $nextRow += 1;
    $newSheet->mergeCells("B$nextRow:I$nextRow");
    $newSheet->getStyle("B$nextRow")->getFont()->setBold(true);
    $newSheet->setCellValue("B$nextRow","\"Aprobado\" con las salvedades de que exista suficiencia presupuestal y de que no existan cambios en: precios, políticas públicas,");

    $nextRow += 1;
    $newSheet->mergeCells("B$nextRow:I$nextRow");
    $newSheet->getStyle("B$nextRow")->getFont()->setBold(true);
    $newSheet->setCellValue("B$nextRow","planes y programas, o de cualquier otra situación interna o externa, que modifiquen o cancelen este proyecto.");



    // The responsible name on the footer
    $nextRow += 7;
    $newSheet->mergeCells("B$nextRow:F$nextRow");
    $newSheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle("B$nextRow")->getFont()->setUnderline(true);
    $newSheet->getStyle("B$nextRow")->getFont()->setBold(true);
    $newSheet->setCellValue("B$nextRow",$userWithAcademicTitle );


    $nextRow += 1;
    $newSheet->mergeCells("B$nextRow:F$nextRow");
    $newSheet->getStyle("B$nextRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $newSheet->getStyle("B$nextRow")->getFont()->setBold(true);
    $newSheet->setCellValue("B$nextRow",$subarea );



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
    $drawing->setWorksheet($newSheet);


endforeach;
$spreadsheet->setActiveSheetIndex(1); // 0 = first sheet, 1 = second, etc.


// Remove the first sheet 
$spreadsheet->removeSheetByIndex(0);




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