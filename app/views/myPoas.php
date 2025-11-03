<?php
// index.php
//setlocale(LC_TIME, "es_MX.UTF-8");
setlocale(LC_TIME, "es_MX.UTF-8"); // Optional fallback
date_default_timezone_set("America/Mexico_City");

$date = new IntlDateFormatter(
    'es_MX',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'America/Mexico_City',
    IntlDateFormatter::GREGORIAN,
    "EEEE, dd 'de' MMMM 'del' yyyy"
);

$currentDate = $date->format(new DateTime());

$userRealName = $_SESSION['userRealName'];


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planeación Operativa Anual</title>
    <script src='assets/scripts/myPoas.js'></script>
    <link rel="stylesheet" href="assets/styles/myPoas.css">
    <link href="assets/styles/conceptsModalStyles.css" rel="stylesheet">
    <link href="assets/styles/viewConceptsModalStyles.css" rel="stylesheet">
     <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- Datatables stuff-->
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>
<body class="flex bg-gray-100 min-h-screen font-roboto text-white">
    <?php
        include('components/lateralBar.php');
    ?>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col px-10 py-6 bg-white text-gray-800">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h1 class="text-2xl font-semibold text-gray-700">Planeación Operativa Anual de Actividades</h1>
            <div class="text-right text-sm font-medium text-gray-600">
                <?php echo $userRealName; ?><br>
                <?php echo ucfirst($currentDate); ?>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex flex-1 pt-6 justify-around">
            <div>
            <!-- Include Form and modals-->
            <?php 
                $userProfiles = $_SESSION['userProfiles'];
                if( in_array( "Director", array_column( $userProfiles, "PROFILE")) && $numberOfPoas > 0 ):
                    echo "  <div id='containerBuildConcentratedPoasButton'>
                                <button class='btn btn-success' id='buildConcentratedDocumentPoas' data-fiscalyear='2025'>
                                    <i class='fas fa-file-excel'></i> Generar concentrado
                                </button>
                            </div>";
                endif;
                include_once("components/myPoasTable.php");
            ?>

            <!-- Field Description -->
            <!--<div class="bg-gray-700 shadow-custom_medium rounded-md p-10 basis-3/12 h-fit self-start text-white text-sm min-h-[60px] max-h-[200px] overflow-y-auto">
                <h3 class="text-green-500 text-lg font-semibold mb-2">Descripción del campo</h3>
                <p id="selectDescription" class="text-white text-sm">
                    Selecciona un campo para visualizar su descripción
                </p>
            </div>
-->
            </div>
        </div>
    </main>
</body>
</html>
