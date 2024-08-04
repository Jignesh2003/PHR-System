<?php 
    session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "researchpaper";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

                $sr = 0; //situation reliablity
                $rr = 0; //role reliability
                $ar = 0; //access reliability
                $dc = 0; //document confidentiality
                $ca = 0; //consent authority

            // Check connection
            if ($conn->connect_error) {
            // die("Connection failed: " . $conn->connect_error);
            }
            else {
                
                // echo "Connected successfully";
                if(!isset($_SESSION['isLogin'])){
                    header("Location: ./login.php");
                    die();
                }

                if(isset($_SESSION['Role'])){
                    if($_SESSION['Role'] != 'Admin' && $_SESSION['Role'] != 'Doctor' && $_SESSION['Role'] != 'admin' && $_SESSION['Role'] != 'doctor' && $_SESSION['Role'] != 'LabAssistant' && $_SESSION['Role'] != 'Nurse'){
                        //if role is pharmacist then no access to reports
                        header("Location: ./prescription.php");
                    }
                }

                if(isset($_POST['submit'])){
                    $id = $_POST['myId'];
                    $answers = $_POST['answers']; //Array type of data
                    $ArrToStr1 = implode(", ",$answers); //Converting Array to string
                    //---------------------------------
                    $sql = "SELECT * FROM `reports` WHERE `id` = '$id';";
                    $result = mysqli_query($conn, $sql);

                    if($result){
                        while($row = mysqli_fetch_assoc($result)){
                            //echo $row['GiveRights'];
                            $dummyArr1= array($row['GiveRights']);
                        }   
                    }
                    //echo "<br>Array Value is :".$dummyArr1;
                    $ArrToStr2 = implode(", ", $dummyArr1); //Converting array to string
                    //echo "<br>String Value is :".$ArrToStr;
                    $ArrToStr = "$ArrToStr2, $ArrToStr1"; //Concatenating two Strings
                    //echo "<br>Concatenated String is : ".$ArrToStr;
                    
                    $answers = $ArrToStr; //Storing string to variable
                    $sql = "UPDATE `reports` SET `GiveRights` = '$answers' WHERE `id` = '$id';";
                    $result = mysqli_query($conn, $sql);

                    if($result){
                        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Document Uploaded Successfully</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";

                            $sql = "SELECT * FROM `reports` WHERE `id`='$id'";
                            $result = mysqli_query($conn, $sql);
                            
                    }
                    else{
                        echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>Error: Please Try Again!!...</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    }
                    
                }


                //Trigger when link is clicked to update the count in access table
                if(isset($_GET['performTask'])) {
                    // Perform your SQL query
                    $id = $_GET['myId'];
                    $tableName = $_GET['myTable'];
                    
                    $sql1 = "SELECT * FROM `access` WHERE `accessBy`=$id AND `byWhichTable`='$tableName'";
                    $result1 = mysqli_query($conn, $sql1);
                    if (!$result1) {
                        echo "Error updating accessCount in result1: " . mysqli_error($conn);
                    }

                    if($result1){
                        while($row = mysqli_fetch_assoc($result1)){
                            $accessCount = $row['accessCount'];
                        }
    
                        $accessCount = $accessCount+1;
    
                        $sql2 = "UPDATE `access` SET `accessCount`=$accessCount WHERE `accessBy`=$id AND `byWhichTable`='$tableName'";
                        $result2 = mysqli_query($conn, $sql2);
                        if (!$result2) {
                            echo "Error updating accessCount in result2: " . mysqli_error($conn);
                        } 
                    }

                    $sql3 = "SELECT * FROM `$tableName` WHERE `id`=$id";
                    $result3 = mysqli_query($conn, $sql3);

                    if(!$result3){
                        echo "Error in accesing documents table in result3: " . mysqli_error($conn);
                    }
                    if($result3){
                        while($row = mysqli_fetch_assoc($result3)){
                            $dc = $row['DocumentPriority'];
                            $documentType = $row['DocumentType'];
                            $documentName = $row['Document'];
                        }
                    }
                    
                    //Entering data in the tf calculating table
                    if(($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='OPD Visit') || ($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='Hospital Visit') || ($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='First Time Visit') || ($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='ICU') || ($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='Annual Checkup')){

                        $rr=1;
                        $ar=1;
                        
                        if($_SESSION["Situation"]=='OPD Visit')
                        {
                            $sr = 1;
                        }
                        elseif($_SESSION["Situation"]=='Hospital Visit')
                        {
                            $sr = 1;
                        }
                        elseif($_SESSION["Situation"]=='First Time Visit')
                        {
                            $sr=2;
                        }
                        elseif($_SESSION["Situation"]=='ICU')
                        {
                            $sr = 1;
                        }
                        else
                        {
                            $sr = 1;
                        }

                        $sql4 = "INSERT INTO `main`(`Role`, `Name`, `SituationType`, `DocumentId`, `DocumentName`, `DocumentType`, `ByWhichTable`, `RBAC`, `documentConfidentiality`, `roleReliablity`, `situationReliablity`, `accessReliability`, `consentAuthority`, `TF`, `RBAC_TF`) VALUES('{$_SESSION['Role']}', '{$_SESSION['Name']}', '{$_SESSION['Situation']}', $id, '$documentName', '$documentType', '$tableName', 'Yes', $dc, $rr, $sr, $ar,0,0,0);";
                        $result4 = mysqli_query($conn,$sql4);
                        if (!$result4) {
                            echo "Error inserting in main table in result4 in reports: " . mysqli_error($conn);
                        }

                        $sql5 = "SELECT * FROM `main` order by `id` desc limit 1;";
                        $result5 = mysqli_query($conn,$sql5);

                        if($row= mysqli_fetch_assoc($result5)){
                            //echo "inside row table:";
                            $rbac = $row['RBAC'];
                            $dc = $row['documentConfidentiality'];
                            $rr = $row['roleReliablity'];
                            $sr = $row['situationReliablity'];
                            $ar = $row['accessReliability'];
                            $ca = $row['consentAuthority'];
                            $mainId = $row['id'];
                        }
                        //Calculating TF
                        if(($rbac=='Yes' && $dc==1 && $ca==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf =1;

                        }
                        elseif(($rbac=='No' && $dc==1 && $ca==1)|| ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf = 1;
                        }

                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }

                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        else{
                            $tf = 0;
                        }

                        if($tf == 1)
                        {
                            $rbac_tf="Yes";
                        }
                        else{
                            $rbac_tf="No";
                        }

                        $sql6 = "UPDATE `main` SET `TF`=$tf ,`RBAC_TF`='$rbac_tf' WHERE `id`=$mainId;";
                        $result6 = mysqli_query($conn,$sql6);


                        
                    }
                    elseif(($_SESSION['Role']=='doctor' && $_SESSION["Situation"]=='OPD Visit') || ($_SESSION['Role']=='doctor' && $_SESSION["Situation"]=='Hospital Visit') || ($_SESSION['Role']=='doctor' && $_SESSION["Situation"]=='First Time Visit') || ($_SESSION['Role']=='doctor' && $_SESSION["Situation"]=='ICU' ) || ($_SESSION['Role']=='Doctor' && $_SESSION["Situation"]=='Annual Checkup') ){

                        $rr = 1;
                        $ar=1;

                        if($situationType=='OPD Visit')
                        {
                            $sr = 1;
                        }
                        elseif($situationType=='Hospital Visit')
                        {
                            $sr = 1;
                        }
                        elseif($situationType=='First Time Visit')
                        {
                            $sr=2;
                        }
                        elseif($situationType=='ICU')
                        {
                            $sr = 1;
                        }
                        else
                        {
                            $sr = 1;
                        }
                        $sql4 = "INSERT INTO `main`(`Role`, `Name`, `SituationType`, `DocumentId`, `DocumentName`, `DocumentType`, `ByWhichTable`, `RBAC`, `documentConfidentiality`, `roleReliablity`, `situationReliablity`, `accessReliability`, `consentAuthority`, `TF`, `RBAC_TF`) VALUES('{$_SESSION['Role']}', '{$_SESSION['Name']}', '{$_SESSION['Situation']}', $id, '$documentName', '$documentType', '$tableName', 'Yes', $dc, $rr, $sr, $ar,0,0,0);";
                        $result4 = mysqli_query($conn,$sql4);
                        if (!$result4) {
                            echo "Error inserting in main table in result4 in reports: " . mysqli_error($conn);
                        }


                        $sql5 = "SELECT * FROM `main` order by `id` desc limit 1;";
                        $result5 = $conn->query($sql5);

                        if($row= mysqli_fetch_assoc($result5)){
                            $rbac = $row['RBAC'];
                            $dc = $row['documentConfidentiality'];
                            $rr = $row['roleReliablity'];
                            $sr = $row['situationReliablity'];
                            $ar = $row['accessReliability'];
                            $ca = $row['consentAuthority'];
                            $mainId = $row['id'];
                        }

                        //Calculating TF
                        if(($rbac=='Yes' && $dc==1 && $ca==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf =1;

                        }
                        elseif(($rbac=='No' && $dc==1 && $ca==1)|| ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf = 1;
                        }

                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }

                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        else{
                            $tf = 0;
                        }

                        if($tf == 1)
                        {
                            $rbac_tf="Yes";
                        }
                        else{
                            $rbac_tf="No";
                        }

                        $sql6 = "UPDATE `main` SET `TF`=$tf ,`RBAC_TF`='$rbac_tf' WHERE `id`=$mainId;";
                        $result6 = mysqli_query($conn,$sql6);
                    }
                    elseif(($_SESSION['Role']=='Lab Assistant' && $_SESSION["Situation"]=='Lab Test')){

                        $rr = 1;
                        $ar=0;
                        $sr=0;
                        $sql4 = "INSERT INTO `main`(`Role`, `Name`, `SituationType`, `DocumentId`, `DocumentName`, `DocumentType`, `ByWhichTable`, `RBAC`, `documentConfidentiality`, `roleReliablity`, `situationReliablity`, `accessReliability`,`consentAuthority`,`TF`,`RBAC_TF`) VALUES('{$_SESSION['Role']}', '{$_SESSION['Name']}', '{$_SESSION['Situation']}', $id, '$documentName', '$documentType', '$tableName', 'Yes', $dc, $rr, $sr, $ar,0,0,0);";
                        $result4 = $conn->query($sql4);
                        if (!$result4) {
                            echo "Error inserting in main table in result4 in reports: " . mysqli_error($conn);
                        }

                        $sql5 = "SELECT * FROM `main` order by `id` desc limit 1;";
                        $result5 = mysqli_query($conn,$sql5);

                        if($row= mysqli_fetch_assoc($result5)){
                            $rbac = $row['RBAC'];
                            $dc = $row['documentConfidentiality'];
                            $rr = $row['roleReliablity'];
                            $sr = $row['situationReliablity'];
                            $ar = $row['accessReliability'];
                            $ca = $row['consentAuthority'];
                            $mainId = $row['id'];
                        }

                        //Calculating TF
                        if(($rbac=='Yes' && $dc==1 && $ca==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf =1;

                        }
                        elseif(($rbac=='No' && $dc==1 && $ca==1)|| ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==1 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==1 && $ca==0 && $rr==1 && $ar==1)){
                            $tf = 1;
                        }

                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==2 && $ca==0) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==2 && $ca==0) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==2 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==2 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }

                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='Yes' && $dc==3 && $ca==0) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==2 && $ar==2) || ($rbac=='Yes' && $dc==3 && $ca==0 && $rr==1 && $ar==0 && $sr==0)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $sr==1) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==1 && $ar==1) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==1 && $ar==1)){
                            $tf=1;
                        }
                        elseif(($rbac=='No' && $dc==3 && $ca==0) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $sr==2) || ($rbac=='No' && $dc==3 && $ca==0 && $sr==2 && $ar==2) || ($rbac=='No' && $dc==3 && $ca==0 && $rr==2 && $ar==2)){
                            $tf=1;
                        }
                        else{
                            $tf = 0;
                        }

                        if($tf == 1)
                        {
                            $rbac_tf="Yes";
                        }
                        else{
                            $rbac_tf="No";
                        }

                        $sql6 = "UPDATE `main` SET `TF`=$tf ,`RBAC_TF`='$rbac_tf' WHERE `id`=$mainId;";
                        $result6 = mysqli_query($conn,$sql6);
                    }
                    else{
                        ?>

                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>Invalid Credentials</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        
                        <?php
                    }
                    
                }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC</title>
    <!-- Required meta tags -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Varela Round', sans-serif;

        }

        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /*Footer*/

        footer {
            width: 100%;
            margin-top: auto;
        }

        footer div {
            font-size: 1.4rem;
        }
    </style>
</head>

<body>
    <!-- NavBar -->
    <div class="bg-dark navbar-dark">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid pe-lg-2 p-0"> <a class="navbar-brand ms-5" href="#"><img src="Images/logo.png"
                        height="70vh"></a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                        <?php
                            if($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'admin') { ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" aria-current="page"
                                href="./index.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active"
                                href="./reports.php">REPORTS</a></li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold"
                                href="./prescription.php">PRESCRIPTION</a></li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./UploadDocument.php">UPLOAD
                                DOCUMENTS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Doctor' || $_SESSION['Role'] == 'doctor') { ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" aria-current="page"
                                href="./index.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active" href="./reports.php">REPORTS</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Pharmacist' || $_SESSION['Role'] == 'pharmacist') { ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active"
                                href="./prescription.php">PRESCRIPTION</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'LabAssistant') { ?>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active"
                                href="./reports.php">REPORTS</a></li>
                        <?php   }
                            elseif($_SESSION['Role'] == 'Nurse'){ ?>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" aria-current="page"
                                href="./index.php">DASHBOARD</a> </li>
                        <?php   }
                            else{ ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <?php   }
                        ?>

                        <?php if(!isset($_SESSION['isLogin'])) { ?>

                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./login.php">LOGIN</a> </li>
                        <?php } else { ?>

                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./signout.php">SIGN-OUT</a>
                        </li>

                        <?php } ?>

                    </ul>

                    <ul class="navbar-nav icons ms-auto mb-2 mb-lg-0">

                        <?php if(isset($_SESSION['isLogin'])) { ?>
                        <li id="message" style="color:white;" class="fs-bold">Welcome
                            <?php echo $_SESSION['Name'];?>,
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Container -->
    <div class="container">
        <div class="row">
            <?php
            
            try {
                $sql = "SELECT * FROM `reports`;";
                $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {  // Displaying the catalogue
                        
                        $ArrToStr = array($row['GiveRights']); //converting into array

                        foreach($ArrToStr as $x){
                            $x_Array = explode(",",$x); //converting string like "red, blue, green" into array(red, blue,green)
                            //echo "Name of X : ".$x."<br>";
                            foreach($x_Array as $z){

                                //comparing the array elements with the logged in User to achieve rights for documents      
                                if(strcmp($_SESSION['Name'],trim($z)) == 0){

                                ?>
    
                                   <div class="col-xxl-3 col-md-6 col-xs-12 container-fluid">
                                        <div class="card" style="max-width: 18rem;">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <a href="?performTask=1&myTable=reports&myId=<?php echo $row['id'] ?>" onclick="openMultipleLinks(<?php echo $row['id']; ?>, '<?php echo $row['Document']; ?>')">
                                                    <?php echo $row['Document'];?>
                                                    </a>

                                                    <script>
                                                        function openMultipleLinks(id, documentName){
                                                            
                                                            /* --------------------------------------------------------------------- */
                                                            
                                                            link = './uploadReports/'+documentName+'?performTask=1&myTable=reports&myId='+id+'';
                                                            window.open(link, '_blank');
                                                        }
                                                    </script>
                                                </p>
                                                <p class="card-text">
                                                    <strong>Ref :</strong> <b><?php echo $row['DoctorName']; ?></b>
                                                </p>
                                                <p class="card-text">
                                                    <strong>Date Of Treatment :</strong> <b>
                                                        <?php echo $row['DateOfPerformance']; 
                                                        ?>
                                                    </b>
                                                </p>
                            
                                                <form class="d-flex" method="post">
                                                    <input type="hidden" name="myId" id="prdId" value="<?php echo $row['id'] ?>">
    
                                                    <!--Admin can give rights-->
                                                    <?php
                                                    if($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'admin') {?>
                                                    <input class="form-control me-3" type="search" placeholder="Enter" name="answers[]">
                                                    <button class="btn btn-primary m-1 p-1 " type="submit" name="submit">Submit</button>
                                                    <?php } ?>
                                                        
                                                </form>
                            
                                            </div>
                                        </div>
                                    </div> 
    
                                <?php 
                                }//End of If(status == 0)
                                
                            }//End of foreach loop

                            if($_SESSION['Role']== 'Admin'|| $_SESSION['Role'] == 'admin'){
                            ?>
                                <div class="col-xxl-3 col-md-6 col-xs-12 container-fluid">
                                    <div class="card" style="max-width: 18rem;">
                                        <div class="card-body">  
                                            <p class="card-text">
                                            <a href="?performTask=1&myTable=reports&myId=<?php echo $row['id'] ?>" onclick="openMultipleLinks(<?php echo $row['id']; ?>, '<?php echo $row['Document']; ?>')">
                                                <?php echo $row['Document']; 
                                                ?>
                                            </a>

                                            <script>
                                                function openMultipleLinks(id, documentName){
                                                    
                                                    link = './uploadReports/'+documentName+'?performTask=1&myTable=reports&myId='+id+'';
                                                    window.open(link, '_blank');
                                                }
                                            </script>

                                            </p>
                                            <p class="card-text">
                                                <strong>Ref :</strong> <b><?php echo $row['DoctorName']; ?></b>
                                            </p>
                                            <p class="card-text">
                                                <strong>Date Of Treatment :</strong> <b>
                                                    <?php echo $row['DateOfPerformance']; 
                                                    ?>
                                                </b>
                                            </p>
                                            
                                            <form class="d-flex myForm" method="post" style="display:none;">
                                                <input type="hidden" name="myId" id="prdId" value="<?php echo $row['id'] ?>">
                                            
                                                <!--Admin can give rights-->
                                                <?php
                                                    if($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'admin') {?>
                                                        <input class="form-control me-3" type="search" placeholder="Enter" name="answers[]">
                                                        <button class="btn btn-primary m-1 p-1 " type="submit" name="submit">Submit</button>
                                                <?php } ?>
                                                    
                                            </form>
                                        </div>
                            
                                    </div>
                                </div>

                            <?php }
    
                            
                        }//End of foreach loop
                    ?>

            
            <?php
                        } //End of while loop 
                
            }// End of try block

            catch(Exception $e) {
                echo "some error occured";
            }
        ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-center text-white">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-twitter"></i></a>

                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-google"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-instagram"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-linkedin-square"></i></a>

                <!-- Github -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-github"></i></a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Copyright:
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer END -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <?php 
    $conn->close();
} ?>
</body>

</html>