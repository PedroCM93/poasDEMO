<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Areas table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        table tr td {
            border: 2px solid black;
        }
    </style>
</head>
<body>
<?php
if( count( $areas ) > 0 ):
?>
    <table class="table table-hover">
        <thead>
            <th>Código</th>
            <th>Área/Subárea</th>
            <th>Responsable</th>
        </thead>
        <tbody>    
<?php

endif;

$mainArea = "";
$subarea = "";

foreach( $areas as $index => $area ):
    $areaCode = $area['AREACODE'];
    $areaName = $area['MAINAREA'];
    $subareaCode = $area['SUBAREACODE'];
    $subareaName = $area['SUBAREA'];
    $derivatedAreaCode = $area['DERIVATEDAREACODE'];
    $derivatedAreaName = $area['DERIVATEDAREA'];
    $responsibleName = $area['RESPONSIBLE'];
    
    if( $mainArea != $areaName ){
        $mainArea = $areaName;
        echo "  <tr>
                    <td><h2>$areaCode</h2></td>
                    <td colspan=2><h2>$areaName</h2></td>
                </tr>";
    }
    if( $subarea != $subareaName && $derivatedAreaCode == null ){
        $subArea = $subareaName;
        echo "  <tr>
                        <td><h5>$subareaCode</h5></td>
                        <td><h5>$subareaName</h5></td>
                        <td>$responsibleName</td>
                    </tr>";
    }

    if( $derivatedAreaName != null ){
        echo "  <tr>
                    <td>$derivatedAreaCode</td>
                    <td>$derivatedAreaName</td>
                    <td>$responsibleName</td>
                </tr>";
    }

endforeach;
/*
$mainArea = "";
$subarea = "";
foreach( $areas as $index => $area ):
    if( $index == 0 )
        echo "<b>$mainArea</b><br>";
    if( $mainArea != $area['MAINAREA'] ){
        $mainArea = $area['MAINAREA'];
        echo "<b>" . $area['AREACODE'] . " - $mainArea</b><br>";
    }
    if( $subarea != $area['SUBAREA'] ){
        $subarea = $area['SUBAREA'];
        echo $area['SUBAREACODE'] . " - $subarea - " . $area['RESPONSIBLE'] . "<br>";
    }
    if( $area['DERIVATEDAREA'] != null ){
        echo "<i>" . chr(9) . chr(9)  . $area['DERIVATEDAREACODE'] . " - " . $area['DERIVATEDAREA'] . "</i> - " . $area['RESPONSIBLE'] . "<br>";
    }
endforeach;

*/

echo "  
        </tbody>
    </table>";


?>
    
</body>
</html>