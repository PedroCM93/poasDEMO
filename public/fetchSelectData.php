<?php
require_once '../core/Database.php';


$option = $_POST['option'];
$connection = Database::connect();

switch( $option ){
    case "getAreas":
        $getAreasQuery = "  SELECT * FROM AREAS ORDER BY NAME ASC";
        $stmt = $connection->query( $getAreasQuery );
        $resultAreas = $stmt->fetchAll();
        echo json_encode( $resultAreas );
    break;

    case "getSubareas":
        $area = $_POST['selectedArea'];
        $getSubareasQuery = " SELECT * FROM SUBAREAS WHERE AREA = ? ORDER BY NAME ASC";
        $stmt = $connection->prepare( $getSubareasQuery );
        $stmt->execute([ $area ]);
        $resultSubareas = $stmt->fetchAll();
        echo json_encode( $resultSubareas );
    break;

    case "getDerivatedAreas":
        $subarea = $_POST['subarea'];
        $getDerivatedAreasQuery = " SELECT * FROM DERIVATEDAREAS WHERE SUBAREA = ?";
        $stmt = $connection->prepare( $getDerivatedAreasQuery );
        $stmt->execute( [ $subarea ]);
        $resultDerivatedAreas = $stmt->fetchAll();
        echo json_encode( $resultDerivatedAreas );

    break;

    case "getPdiAxis":
        $getPdiAxisQuery = " SELECT * FROM PDIAXIS ORDER BY ID ASC ";
        $stmt = $connection->query( $getPdiAxisQuery );
        $resultPdiAxis = $stmt->fetchAll();
        echo json_encode( $resultPdiAxis );
    break;

    case "getActionLines":
        $pdiAxis = $_POST['selectedPdiAxis'];
        $getActionLinesQuery = "    SELECT * FROM ACTIONLINES WHERE PDIAXIS = ? ORDER BY NUMBER ASC";
        $stmt = $connection->prepare( $getActionLinesQuery );
        $stmt->execute([ $pdiAxis]);
        $resultsActionLines = $stmt->fetchAll();
        echo json_encode( $resultsActionLines );
    break;

    case "getEvidences":
        $getEvidencesQuery = " SELECT * FROM EVIDENCES ORDER BY NAME ASC";
        $stmt = $connection->query( $getEvidencesQuery );
        $resultsEvidences = $stmt->fetchAll();
        echo json_encode( $resultsEvidences );
    break;

    case "getResponsibleAreas":
        session_start();
        $userName = $_SESSION['userName'];
        $getUserAreaQuery = "   SELECT a.AREACODE  AS AREACODE, s.SUBAREACODE AS SUBAREACODE
                                FROM USERS u
                                INNER JOIN SUBAREAS s ON s.SUBAREACODE = u.SUBAREA 
                                INNER JOIN AREAS a ON a.AREACODE = s.AREA 
                                WHERE u.USERNAME = ?";
        $stmt = $connection->prepare( $getUserAreaQuery );
        $stmt->execute( [ $userName ] );
        $userArea = $stmt->fetch();
        echo json_encode( $userArea );
    break;

    case "getUnits":
        $getUnitsQuery = "  SELECT * FROM UNITS ORDER BY NAME ASC";
        $stmt = $connection->query( $getUnitsQuery );
        $resultsUnits = $stmt->fetchAll();
        echo json_encode( $resultsUnits );
    break;

    case "getPdiProjects":
        $actionLine = $_POST['selectedActionLine'];
        $getPdiProjectsQuery = "    SELECT * FROM PDIPROJECTS WHERE ACTIONLINE = ? ORDER BY NUMBER ASC ";
        $stmt = $connection->prepare( $getPdiProjectsQuery );
        $stmt->execute([ $actionLine ] );
        $resultsPdiProjects = $stmt->fetchAll();
        echo json_encode( $resultsPdiProjects );
    break;

    case "getBudgetConcepts":
        $getBudgetConceptsQuery = " SELECT *  FROM BUDGETCONCEPTS ORDER BY CONCEPT ASC ";
        $stmt = $connection->query( $getBudgetConceptsQuery );
        $resultsBudgetConcepts = $stmt->fetchAll();
        echo json_encode( $resultsBudgetConcepts );
    break;
}


?>