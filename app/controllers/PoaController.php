<?php
include( __DIR__ . "/../models/Poa.php");
class PoaController{
    private Poa $myPoa;
    public function __construct(){
        $this->myPoa = new Poa();
    }

    public function signIn(): void{
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $validSession = $this->myPoa->validateSession( $userName, $password );
        if( $validSession  ){
            session_start();
            $_SESSION['userName'] = $userName;
            $userRealName = $this->myPoa->getUserData( $userName )['REALNAME'];
            $_SESSION['userRealName'] = $userRealName;
            $userProfiles = $this->myPoa->getUserProfiles( $userName );
            $_SESSION['userProfiles'] =$userProfiles;
            $userAreas = $this->myPoa->getUserAreas( $userName );
            $_SESSION['userAreas'] = $userAreas;
            include_once( __DIR__ . "/../views/dashboard.php");
        }
        else{
            $errorMessage = "Credenciales inválidas";
            header("Location: ?method=login&errorMessage=$errorMessage");
        }
    }

    public function userAreas(): void {
        session_start();
        echo json_encode( $_SESSION['userAreas']); 
    }
 
    public function login( ): void {   
        session_start();
        if( !isset( $_SESSION['userName'] ) )
            require_once( __DIR__ . "/../views/login.php");
        else
            require_once( __DIR__ . "/../views/dashboard.php");

    }

    public function myPoas(): void{
        $myPoas = $this->myPoa->getAllPoas();
        $numberOfPoas = $this->myPoa->getTotalPoasPerSubareas();
        require_once( __DIR__ . "/../views/myPoas.php");
    } 


    public function generatePoaExcel( ): void{
        $poaData = $this->myPoa->getPoaData( $_POST['poaId'] );
        $poaConcepts = $this->myPoa->getPoaConcepts( $_POST['poaId'] );
        //require_once( __DIR__ . "/../views/budgetReportByAreaExcel.php");
        require_once( __DIR__ . "/../views/generatePOAExcel.php");
    }

    // Store the data into the POA table 
    public function store(): void{
        $data = $_POST;
        $result = $this->myPoa->insert( $data );
        if( $result === true ){
            echo json_encode([
                "success" => true,
                "message" => "POA guardado exitosamente!",
                "location" => "?controller=poa&method=myPoas"
            ]);
        }
        else{
            echo json_encode([
                "sucsess" => false,
                "message" => "No se pudo guardar el POA!"
            ]);
        }
    }

    public function logOut(): void {
        session_start();
        session_destroy();
        header("Location: ?controller=poa&method=login");
    }
    public function index():void{
        if( !isset( $_SESSION['userName'] ) ){
            header("Location: ?controller=poa&method=login");
        }
        else
            include_once( __DIR__ . "/../views/dashboard.php");

    }

    public function reports(): void {
        require_once( __DIR__ . "/../views/reports.php");
    }

    public function generateInformPerArea(): void{
        $areas = $this->myPoa->getAreas();
        require_once( __DIR__ . "/../views/budgetReportByAreaExcel.php");

    }

    public function getSubareasCodesFromUser(): void {
        $subareasCodes = $this->myPoa->getSubareasCodes();
        echo json_encode( $subareasCodes );
    }
    
    // Return the concentrated POAS document for the subareas of the user 
    public function generateConcentratedPoas(): void{
        $status = [ "En espera", "Aprobado" ]; // Only want the on hold and approved POAS
        $poasFromSubarea = $this->myPoa->getAllPoas( $status ); // Get the POAS
        $poasAmount = count( $poasFromSubarea );
        for( $poa = 0; $poa < $poasAmount; $poa++ ):
            $poaId = $poasFromSubarea[$poa]['ID'];
            $poaGeneralData = $this->myPoa->getPoaData( $poaId ); // Get the general data from the POA
            $poaConcepts = $this->myPoa->getPoaConcepts( $poaId ); // And also the concepts/activities from it
            $poasFromSubarea[$poa]['GENERALDATA'] = $poaGeneralData;
            $poasFromSubarea[$poa]['CONCEPTS'] = $poaConcepts;  
        endfor;
        include_once( __DIR__ . "/../views/generateConcentratedPoas.php");
    }  


    public function viewAreas(): void{
        $areas = $this->myPoa->getAreas();
        include_once( __DIR__ . "/../views/areasSubareas.php");

    }
}

?>