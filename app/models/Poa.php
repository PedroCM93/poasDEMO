<?php

include( __DIR__ . "/../../core/Database.php");


class Poa{
    private PDO $connection;

    public function __construct(){
        $this->connection = Database::connect();

    }

    public function validateSession( string $userName ,  string $password ):bool {
        $checkUserQuery = " SELECT * FROM USERS WHERE USERNAME = ? AND PASSWORD = ? ";
        $stmt = $this->connection->prepare( $checkUserQuery );
        $stmt->execute( [ $userName, $password ] );
        // Fetch one result and check if it's valid
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user !== false;
    }
    // Get the appropriate POAS for the user profile ( Get all by default, but you can pass an array for the allowed status  )
    /**
     *  Auxiliar ( Auxiliary staff ) = Can only see the POAS that he has created
     *  Director( Area director ) = Can see all the POAS from the subareas that he manages
     *  Financiero ( Financial ) = Can see all the POAS approved by the directors
     */
    public function getAllPoas( array $statusAllowed = NULL, int $fiscalYear = NULL ): ?array{


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userName = $_SESSION['userName'];
        $userData = $this->getUserData( $userName );
        $userProfiles = $this->getUserProfiles( $userName );
        $userAreas = $this->getUserAreas($userName);
        $userId = $userData['USERID'];
        $getPoasQuery = "   SELECT  P.ID AS ID, P.PRODUCTIONDATE AS PRODUCTIONDATE, P.PRODUCTIONHOUR AS PRODUCTIONHOUR, P.GENERALDESCRIPTION AS GENERALDESCRIPTION , 
                            P.FISCALYEAR AS FISCALYEAR , P.ENDDATE AS ENDDATE , P.MINORAREA AS MINORAREA,P.SPENDTYPE AS SPENDTYPE, P.PDIPROJECT AS PDIPROJECT,
                            P.OBSERVATIONS AS OBSERVATIONS, S.NAME AS STATUS, S.ID AS STATUSID, CONCAT(P.MINORAREA, '-', P.ID ) AS SHEETNAME
                            FROM POAS P
                            INNER JOIN STATUS S ON S.ID = P.STATUS
                            INNER JOIN USERS U ON U.ID = P.USER
                            LEFT JOIN SUBAREAS SU ON SU.SUBAREACODE = P.MINORAREA 
                            LEFT JOIN DERIVATEDAREAS DA ON DA.CODE  = P.MINORAREA 
                            WHERE 1 = 1
                            AND P.USER = $userId ";


        // If the user's a director, then can view all the POA's of their subarea/derivated area(s)
        if( in_array( "Director", array_column( $userProfiles, "PROFILE"))):
            foreach( $userAreas as $subarea ):
                $subareaCode = $subarea['SUBAREACODE'];
                $getPoasQuery .= "  OR ( SU.SUBAREACODE = '$subareaCode' OR DA.CODE = '$subareaCode')  ";
            endforeach;
        endif;
        // If the user's belongs to the finantial department, then can see the POAS of the subareas that already have been approved by their bosses
        if( in_array("Financiero" , array_column( $userProfiles, "PROFILE") ) ):
            
        endif;

        // If the status is set with allowed status on it 
        if( isset( $statusAllowed ) ){
            $statusString = ""; // String that will store the allowed status on the IN sentece 
            foreach( $statusAllowed as $status ):
                $statusString .= "'$status',"; 
            endforeach;
            $statusString = rtrim( $statusString, ',' ); // Remove the last comma from the string 
            $getPoasQuery .= " AND S.NAME IN( $statusString ) "; // Include the condition on the query
        }
        if( $fiscalYear !== NULL ){
            $getPoasQuery .= " AND P.FISCALYEAR = $fiscalYear ";
        }
        else {
            $getPoasQuery .= " AND P.FISCALYEAR = ( YEAR( CURRENT_DATE ) + 1 ) ";
        }

        
        $stmt = $this->connection->query( $getPoasQuery );
        return $stmt->fetchAll() ?? null;
    }

    // Get the amount of POAS from the subareas 
    public function getTotalPoasPerSubareas( ): int {
        $subareasUser = $this->getSubareasCodes(); // Get the subareas array of the user
        $subAreasAmount = count( $subareasUser ); // Amount of subareas of the user
        $placeholders = implode(',', array_fill( 0, $subAreasAmount, "?" ) ); // Creates an array with the placeholders for the query 
        // Now, the query is builded taking the fiscal year ( next year ), and only the poas on hold ( EN espera ) and the approved ones ( Aprobados )
        $queryNumberOfPoas = "  SELECT COUNT(*) AS TOTALPOAS
                                FROM POAS P
                                INNER JOIN STATUS S ON S.ID = P.STATUS 
                                WHERE FISCALYEAR  = YEAR( CURRENT_DATE ) + 1 
                                AND ( S.NAME = 'En espera' OR S.NAME = 'Aprobado' )
                                AND P.MINORAREA IN( $placeholders ) ";
        $stmt = $this->connection->prepare( $queryNumberOfPoas );
        $subareasUser = $this->getSubareasCodes();
        $stmt->execute( $subareasUser );
        $queryResult = $stmt->fetch();
        $amountOfPoas = $queryResult['TOTALPOAS']; // Only stores the amount of the POAS
        return $amountOfPoas;
    }

    // Get the general data from the POA
    public function getPoaData( int $poaId ): ?array{
        $getPoaDataQuery = "    SELECT 	P.GENERALDESCRIPTION AS GENERALDESCRIPTION , CONCAT(LPAD(DAY(PRODUCTIONDATE), 2, '0'),'/', LPAD(MONTH(PRODUCTIONDATE), 2, '0'),'/', YEAR( P.PRODUCTIONDATE )) AS PRODUCTIONDATE,		
                                        P.FISCALYEAR AS FISCALYEAR, CONCAT( LPAD( DAY(P.STARTDATE),2, '0' ), '-', SUBSTR(mes(P.STARTDATE, 'es_ES'), 1, 3 ), '-', SUBSTR(YEAR(P.STARTDATE),-2,2) ) AS STARTDATE,
                                        CONCAT( LPAD( DAY(P.ENDDATE),2, '0' ), '-', SUBSTR(mes(P.ENDDATE, 'es_ES'), 1, 3 ), '-', SUBSTR(YEAR(P.ENDDATE),-2,2) ) AS ENDDATE,
                                        COALESCE( S.NAME, DA.NAME ) AS SUBAREA, COALESCE( A.NAME, S2.NAME ) AS AREA,                                        
                                        CONCAT( AL.`NUMBER`, ' ', AL.NAME ) AS ACTIONLINE,PP.DESCRIPTION AS PDIPROJECT, P.OBSERVATIONS AS OBSERVATIONS,
                                        mes( P.PRODUCTIONDATE, 'es_ES' ) AS MONTH,YEAR( PRODUCTIONDATE ) AS YEAR, U.REALNAME AS POAUSER, 
                                        AD.ABBREVIATION AS ACADEMICTITLE, P.STATUS AS STATUS,CONCAT('$', FORMAT(SUM( PC.AMOUNT * PC.UNITPRICE),2 ) ) AS ESTIMATEDTOTAL,
                                        CONCAT( AD.ABBREVIATION, ' ', U.REALNAME ) AS ACADEMICTITLEUSER,CONCAT( mes(P.PRODUCTIONDATE, 'es_ES'), '-', YEAR(PRODUCTIONDATE ) ) AS EXECUTIONDATE,
                                        CONCAT( SUBSTR(mes(P.STARTDATE , 'es_ES'),1,3), '-', YEAR(PRODUCTIONDATE ) ) AS EXECUTIONDATE, PA.AXISNAME AS AXISNAME 
                                FROM POAS P
                                LEFT JOIN SUBAREAS S ON S.SUBAREACODE = P.MINORAREA 
                                LEFT JOIN DERIVATEDAREAS DA ON DA.CODE = P.MINORAREA 
                                LEFT JOIN AREAS A ON A.AREACODE = S.AREA 
                                LEFT JOIN SUBAREAS S2 ON S2.SUBAREACODE = DA.SUBAREA 
                                INNER JOIN PDIPROJECTS PP ON PP.ID = P.PDIPROJECT 
                                INNER JOIN ACTIONLINES AL ON AL.ID = PP.ACTIONLINE 
                                INNER JOIN PDIAXIS PA ON PA.ID = AL.PDIAXIS 
                                INNER JOIN USERS U ON U.ID = P.`USER` 
                                INNER JOIN ACADEMICDEGREES AD ON AD.ID = U.ACADEMICDEGREE 
                                INNER JOIN POACONCEPTS PC ON PC.POA  = P.ID 
                                WHERE P.ID = ?";
        $stmt = $this->connection->prepare( $getPoaDataQuery );
        $stmt->execute([ $poaId ] );
        return $stmt->fetch() ?? null;
    }

    // Get the concepts/activities from a POA  
    public function getPoaConcepts( int $poaId ) : ?array{
        $getPoaConceptsQuery = "    SELECT 	PC.CONCEPT AS CONCEPT, E.NAME AS EVIDENCE, PC.EXECUTION_MONTHS  AS EXECUTIONDATE, 
                                    COALESCE (S.NAME, D.NAME ) AS SUBAREA, PC.AMOUNT AS AMOUNT,U.ABBREVIATION  AS UNIT, CONCAT('$',FORMAT(PC.UNITPRICE,2)) AS UNITPRICE,
                                    CONCAT('$',FORMAT(( PC.AMOUNT * PC.UNITPRICE), 2 )) AS IMPORT 
                                    FROM POACONCEPTS PC
                                    INNER JOIN UNITS U ON U.ID = PC.UNIT 
                                    INNER JOIN POAS P ON P.ID = PC.POA 
                                    LEFT JOIN SUBAREAS S ON S.SUBAREACODE = P.MINORAREA 
                                    LEFT JOIN DERIVATEDAREAS D ON D.CODE = P.MINORAREA 
                                    INNER JOIN EVIDENCES E ON E.ID = PC.EVIDENCE 
                                    WHERE PC.POA =  ? ";
        $stmt = $this->connection->prepare( $getPoaConceptsQuery );
        $stmt->execute( [ $poaId ] );
        return $stmt->fetchAll(PDO::FETCH_NUM) ?? null; // It is more convenient to fetch the concepts in a numeric way to loop more easily with the excel document 
    }

    // Method that gets all the POAS and their respective concepts in order to generate a concentrated excel file with all the POAS
    public function getAllPoasWithConcepts( array $userAreas, int $fiscalYear ): ?array{
        /*$inSentenceAreas = ""; // Will store the areas in a sentence to be used in the query
        // Loop through the user's areas and create a sentence with the subarea codes
        foreach( $userAreas as $area ):
            $inSentenceAreas .= "'$area',";
        endforeach;
        $inSentenceAreas = rtrim($inSentenceAreas, ","); // Remove the last comma  
        */
        $numberOfAreas = count( $userAreas ); // Stores the amount of subareas of the user
        $placeholders = implode(',', array_fill( 0, $numberOfAreas, '?' ) ); // Makes the placeholders ( For the query ) string 
        /*** Gets ALL the POAS and theis concepts from the subareas where the users belongs and the fiscal year of that POAS */
        $getAllPoasWithConceptsQuery = "    SELECT  P.ID AS POAID, P.GENERALDESCRIPTION AS GENERALDESCRIPTION, P.FISCALYEAR AS FISCALYEAR, P.STARTDATE AS STARTDATE, P.ENDDATE AS ENDDATE,
                                                    COALESCE( S.NAME, DA.NAME ) AS SUBAREA, COALESCE( A.NAME, S2.NAME ) AS AREA,
                                                    CONCAT( AL.`NUMBER`, ' ', AL.NAME ) AS ACTIONLINE, PP.DESCRIPTION AS PDIPROJECT, P.OBSERVATIONS AS OBSERVATIONS,
                                                    AD.ABBREVIATION AS ACADEMICTITLE, U.REALNAME AS POAUSER,
                                                    PC.CONCEPT AS CONCEPT, E.NAME AS EVIDENCE, PC.EXECUTION_MONTHS AS EXECUTIONMONTHS,
                                                    PC.AMOUNT AS AMOUNT, U2.ABBREVIATION AS UNIT, PC.UNITPRICE AS UNITPRICE,
                                                    CONCAT( '$', FORMAT( ( PC.AMOUNT * PC.UNITPRICE ), 2 ) ) AS IMPORT,
                                                    CONCAT( AD.ABBREVIATION, ' ', U.REALNAME ) AS ACADEMICTITLEUSER,
                                                    CONCAT( mes(P.PRODUCTIONDATE, 'es_ES'), '-', YEAR(PRODUCTIONDATE ) ) AS EXECUTIONDATE,
                                                    CONCAT( SUBSTR(mes(P.STARTDATE , 'es_ES'),1,3), '-', YEAR(PRODUCTIONDATE ) ) AS EXECUTIONDATE, PA.AXISNAME AS AXISNAME
                                            FROM POAS P     
                                            LEFT JOIN SUBAREAS S ON S.SUBAREACODE = P.MINORAREA 
                                            LEFT JOIN DERIVATEDAREAS DA ON DA.CODE = P.MINORAREA
                                            LEFT JOIN AREAS A ON A.AREACODE = S.AREA
                                            LEFT JOIN SUBAREAS S2 ON S2.SUBAREACODE = DA.SUBAREA
                                            INNER JOIN PDIPROJECTS PP ON PP.ID = P.PDIPROJECT
                                            INNER JOIN ACTIONLINES AL ON AL.ID = PP.ACTIONLINE
                                            INNER JOIN PDIAXIS PA ON PA.ID = AL.PDIAXIS
                                            INNER JOIN USERS U ON U.ID = P.`USER`
                                            INNER JOIN ACADEMICDEGREES AD ON AD.ID = U.ACADEMICDEGREE
                                            INNER JOIN POACONCEPTS PC ON PC.POA  = P.ID
                                            INNER JOIN UNITS U2 ON U2.ID = PC.UNIT
                                            INNER JOIN EVIDENCES E ON E.ID = PC.EVIDENCE
                                            WHERE P.MINORAREA IN ( $placeholders ) AND P.FISCALYEAR = ?
                                            ORDER BY P.PRODUCTIONDATE ASC, P.ID ASC, PC.CONCEPT ASC ";
        $stmt = $this->connection->prepare( $getAllPoasWithConceptsQuery );
        $parameters = array_merge( $userAreas, [ $fiscalYear  ] ); // Merges the subareas placeholders array with the fiscal year to bind the values on the execute
        $stmt->execute( $parameters );   
        return $stmt->fetchAll() ?? null;
    }

    // Insert a new POA into the database table 
    public function insert( array $data ): bool{
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userName = $_SESSION['userName'];
        $userData = $this->getUserData( $userName );
        $userId = $userData['USERID'];
        $insertPoaQuery = " INSERT INTO POAS(   USER, STATUS, GENERALDESCRIPTION, FISCALYEAR, STARTDATE, ENDDATE, MINORAREA, SPENDTYPE,
                            PDIPROJECT, OBSERVATIONS, PRODUCTIONDATE, PRODUCTIONHOUR )
                            VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";
        $stmt = $this->connection->prepare( $insertPoaQuery );
        $result = $stmt->execute( [   $userId, 1, $data['generalDescription'], $data['fiscalYear'], $data['startDate'], $data['endDate'], $data['subarea'], $data['budgetType'], 
                            $data['pdiProject'], $data['observations'], date('Y-m-d'), date('H:i:s') ] ) ;
        // Get the last id from the inserted POA 
        $poaId = $this->connection->lastInsertId(); 
        // Decodes the json object in order to convert it into an associative array  
        $poaConcepts = json_decode( $data['poaConcepts'], true  );
        // Now insert the POAs concepts with the ID of the POA inserted
        foreach( $poaConcepts  as $concept ):
            $poaConcept = $concept['CONCEPT'];
            $budgetConcept = $concept['BUDGETCONCEPT'];
            $amount = $concept['AMOUNT'];
            $unit = $concept['UNIT'];
            $unitPrice = $concept['UNITPRICE'];
            $evidence = $concept['EVIDENCE'];
            $executionTime = $concept['EXECUTIONMONTHS'];
            $otherEvidence = $concept['OTHER_EVIDENCE'] === "" ? null : trim($concept['OTHER_EVIDENCE']);
            $poaConceptInsertQuery = "  INSERT INTO POACONCEPTS( POA, CONCEPT, BUDGETCONCEPT, AMOUNT, UNIT, UNITPRICE, EVIDENCE, EXECUTION_MONTHS, OTHER_EVIDENCE )
                                        VALUES( ?, ?, ?, ? , ?, ?, ?, ?, ? ) ";
            $stmt = $this->connection->prepare( $poaConceptInsertQuery );
            $resultInsertPoaConcept = $stmt->execute( [ $poaId, $poaConcept, $budgetConcept, $amount, $unit, $unitPrice, $evidence, $executionTime, $otherEvidence]);
        endforeach;
        return $result;
    }


    public function editPoa():bool{

    }

    public function getUserData( string $userName ): ?array{
        $userDataQuery = "  SELECT	U.ID AS USERID ,U.USERNAME AS USERNAME, U.REALNAME AS REALNAME
                            FROM USERS U
                            WHERE U.USERNAME = ? ";
        $stmt = $this->connection->prepare( $userDataQuery );
        $stmt->execute( [ $userName ]);
        return $stmt->fetch() ?? null;
    }

    // Return the user's area(s)
    public function getUserAreas( string $userName ): ?array{
        $userAreasQuery = " SELECT	COALESCE( SA.SUBAREACODE, DA.CODE ) AS SUBAREACODE, COALESCE(SA.NAME, DA.NAME) AS SUBAREANAME, 
		                    COALESCE(A.AREACODE) AS MAINAREACODE, COALESCE(A.NAME) AS MAINAREA
                            FROM SUBAREAS_USER SU
                            LEFT JOIN SUBAREAS SA ON SA.SUBAREACODE = SU.SUBAREACODE
                            LEFT JOIN DERIVATEDAREAS DA ON DA.CODE = SU.DERIVATEDAREACODE
                            INNER JOIN USERS U ON U.ID = SU.USER 
                            LEFT JOIN AREAS A ON A.AREACODE = SA.AREA 
                            WHERE U.USERNAME = ? ";
        $stmt = $this->connection->prepare( $userAreasQuery );
        $stmt->execute( [ $userName ]);
        return $stmt->fetchAll() ?? null;                  
    }

    public function getSubareasCodes( ): ?array  {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userName = $_SESSION['userName'];
        $userAreas = $this->getUserAreas($userName);
        $subareasCodes = array_column( $userAreas, 'SUBAREACODE' );
        return $subareasCodes;
    }

    // Return the user's profile(s)
    public function getUserProfiles( string $userName ): ?array {
        $userProfilesQuery = "  SELECT P.PROFILENAME AS PROFILE
                                FROM USERS_PERMISSIONS UP 
                                INNER JOIN USERS U ON U.ID = UP.USER 
                                INNER JOIN PROFILES P ON P.ID = UP.PERMISSION 
                                WHERE U.USERNAME = ? ";
        $stmt = $this->connection->prepare( $userProfilesQuery );
        $stmt->execute( [ $userName ] );
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? null; 
    }

    // Return ALL the areas and subareas ( derivated areas included too )
    public function getAreas( ): ?array{
        $getAreasQuery = "  SELECT * FROM GETAREASANDSUBAREAS ";
        $stmt = $this->connection->prepare($getAreasQuery);
        $stmt->execute();
        return $stmt->fetchAll() ?? null;
    }
}


?>