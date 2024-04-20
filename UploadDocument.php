<?php
session_start();
if(!isset($_SESSION['isLogin'])){
    header("Location: ./login.php");
    die();
}
if(isset($_SESSION['Role'])){

    if($_SESSION['Role'] != 'Admin' && $_SESSION['Role'] != 'Doctor' && $_SESSION['Role'] != 'admin' && $_SESSION['Role'] != 'doctor'){
        //if role is pharmacist then no access to uploadDocuments
        header("Location: ./prescription.php");
    }
    
    if($_SESSION['Role'] != 'Admin' && $_SESSION['Role'] != 'Pharmacist' && $_SESSION['Role'] != 'admin' && $_SESSION['Role'] != 'pharmacist'){
        //if role is doctor then no access to uploadDocuments 
        header("Location: ./index.php");
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
    <!-- Bootstrap CSS -->

    <style>
        * {
            margin: 0 0;
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
    <!-- NAV BAR -->
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
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./reports.php">REPORTS</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold"
                                href="./prescription.php">PRESCRIPTION</a></li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active"
                                href="./UploadDocument.php">UPLOAD DOCUMENTS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Doctor' || $_SESSION['Role'] == 'doctor') { ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active" aria-current="page"
                                href="./index.php">DASHBOARD</a> </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./reports.php">REPORTS</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Pharmacist' || $_SESSION['Role'] == 'pharmacist') { ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold"
                                href="./prescription.php">PRESCRIPTION</a></li>
                        <?php    }
                            else{ ?>
                        <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <?php    }
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
    <!--NavBar End-->

    <div class="container-fluid">
        <div class="alert alert-secondary" role="alert">
            <h4 class="alert-heading">Upload Document in Reports Table</h4>
        </div>
        <div class="container col-12 m-5">
            <div class="col-6 m-auto">
                <?php
                    if(isset($_POST['btn1'])){
                        $conn = mysqli_connect("localhost","root","","researchpaper");
                        $drName1 = $_POST['drName1'];
                        $situation1 = $_POST['Situation1'];
                        $drNameInGiveRights = $_POST['drName1'];
                        $filename = $_FILES["choosefile1"]["name"];
                        $tempfile = $_FILES["choosefile1"]["tmp_name"];
                        $folder = "uploadReports/".$filename;

                        
                        $documentCount = 0;
                        $documentPriority=0;
                        
                        if($situation1=='Hospital Registration'){$documentPriority=2;}
                        elseif($situation1=='Last Visit Report'){$documentPriority=1;}
                        elseif($situation1=='Diagnosis Report'){$documentPriority=1;}
                        elseif($situation1=='Prescription'){$documentPriority=2;}
                        elseif($situation1=='Checkup Report'){$documentPriority=1;}
                        elseif($situation1=='Test Requirement'){$documentPriority=3;}
                        elseif($situation1=='Blood Test Report'){$documentPriority=1;}
                        elseif($situation1=='Sonography Report'){$documentPriority=1;}
                        elseif($situation1=='Xray Report'){$documentPriority=1;}
                        elseif($situation1=='MRI Report'){$documentPriority=1;}
                        else{$documentPriority=1;}

                        $sql = "INSERT INTO reports(`DoctorName`,`Document`,`GiveRights`,`DocumentType`,`DocumentPriority`) VALUES ('$drName1','$filename','$drNameInGiveRights','$situation1',$documentPriority)";
                        
                        if($filename == "" || $drName1=""){
                            echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Blank Not Allowed</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                        }
                        else{
                            $result = mysqli_query($conn, $sql);
                            
                            //firing query to get the id of current data to use it as foreignkey in access table
                            $sql2 = "SELECT * FROM reports WHERE id = LAST_INSERT_ID()";
                            $result2 = mysqli_query($conn, $sql2);
                            while($row = mysqli_fetch_assoc($result2)){
                                $FK= $row['id'];
                            }
                            
                            $sql3 = "INSERT INTO access(`Document`, `lastAccessDate`, `lastAccessTime`, `accessCount`, `byWhichTable`, `foreignKey`) VALUES ('$filename', CURRENT_DATE, CURRENT_TIME, $documentCount, 'reports', $FK)";
                            $result3 = mysqli_query($conn, $sql3);
                            
                            move_uploaded_file($tempfile, $folder);
                            echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Document Uploaded Successfully</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                        }
                    }
                ?>

                <form method="post" enctype="multipart/form-data">
                    <input class="form-control" type="text" placeholder="Enter Doctor Name" name="drName1" aria-label=".form-control-lg example"><br>
                    <select name="Situation1" id="Situation1" class="form-control">
                        <option value="Hospital Registration">HOSPITAL REGISTRATION</option>
                        <option value="Last Visit Report">LAST VISIT REPORT</option>
                        <option value="Diagnosis Report">DIAGNOSIS REPORT</option>
                        <option value="Prescription">PRESCRIPTION</option>
                        <option value="Checkup Report">CHECKUP REPORT</option>
                        <option value="Test Requirement">TEST REQUIREMENT</option>
                        <option value="Blood Test Report">BLOOD TEST REPORT</option>
                        <option value="Sonography Report">SONOGRAPHY REPORT</option>
                        <option value="Xray Report">XRAY REPORT</option>
                        <option value="MRI Report">MRI REPORT</option>
                        <option value="ECG">ECG</option>
                    </select>
                    <br>
                    <input type="file" class="form-control" name="choosefile1">     
                    <div class="col-6 m-auto">
                        <button type="submit" name="btn1" class="btn btn-outline-success m-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-secondary" role="alert">
            <h4 class="alert-heading">Upload Document in Prescription Table</h4>
        </div>
        <div class="container col-12 m-5">
            <div class="col-6 m-auto">
                <?php
                    if(isset($_POST['btn2'])){
                        $conn = mysqli_connect("localhost","root","","researchpaper");
                        $drName2= $_POST['drName2'];
                        $situation2 = $_POST['Situation2'];
                        $drNameInGiveRights = $_POST['drName2'];
                        $filename = $_FILES["choosefile2"]["name"];
                        $tempfile = $_FILES["choosefile2"]["tmp_name"];
                        $folder = "uploadPrescription/".$filename;

                        $documentCount = 0;
                        $documentPriority=0;
                        
                        if($situation2=='Hospital Registration'){$documentPriority=2;}
                        elseif($situation2=='Last Visit Report'){$documentPriority=1;}
                        elseif($situation2=='Diagnosis Report'){$documentPriority=1;}
                        elseif($situation2=='Prescription'){$documentPriority=2;}
                        elseif($situation2=='Checkup Report'){$documentPriority=1;}
                        elseif($situation2=='Test Requirement'){$documentPriority=3;}
                        elseif($situation2=='Blood Test Report'){$documentPriority=1;}
                        elseif($situation2=='Sonography Report'){$documentPriority=1;}
                        elseif($situation2=='Xray Report'){$documentPriority=1;}
                        elseif($situation2=='MRI Report'){$documentPriority=1;}
                        else{$documentPriority=1;}

                        $sql = "INSERT INTO prescription(`DoctorName`,`Document`, `GiveRights`,`DocumentType`,`DocumentPriority`) VALUES ('$drName2','$filename', '$drNameInGiveRights', '$situation2', $documentPriority)";

                        
                        if($filename == "" || $drName2=""){
                            echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Blank Not Allowed</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                        }
                        else{
                            $result = mysqli_query($conn, $sql);

                            //firing query to get the id of current data to use it as foreignkey in access table
                            $sql2 = "SELECT * FROM reports WHERE id = LAST_INSERT_ID()";
                            $result2 = mysqli_query($conn, $sql2);
                            while($row = mysqli_fetch_assoc($result2)){
                                $FK= $row['id'];
                            }
                            
                            $sql3 = "INSERT INTO access(`Document`, `lastAccessDate`, `lastAccessTime`, `accessCount`, `byWhichTable`) VALUES ('$filename', CURRENT_DATE, CURRENT_TIME, $documentCount, 'prescription', $FK)";
                            $result3 = mysqli_query($conn, $sql2);
                        
                            move_uploaded_file($tempfile, $folder);
                            echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Document Uploaded Successfully</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                        }
                    }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <input class="form-control" type="text" placeholder="Enter Doctor Name" name="drName2" aria-label=".form-control-lg example"><br>
                    <select name="Situation2" id="Situation2" class="form-control">
                        <option value="Hospital Registration">HOSPITAL REGISTRATION</option>
                        <option value="Last Visit Report">LAST VISIT REPORT</option>
                        <option value="Diagnosis Report">DIAGNOSIS REPORT</option>
                        <option value="Prescription">PRESCRIPTION</option>
                        <option value="Checkup Report">CHECKUP REPORT</option>
                        <option value="Test Requirement">TEST REQUIREMENT</option>
                        <option value="Blood Test Report">BLOOD TEST REPORT</option>
                        <option value="Sonography Report">SONOGRAPHY REPORT</option>
                        <option value="Xray Report">XRAY REPORT</option>
                        <option value="MRI Report">MRI REPORT</option>
                        <option value="ECG">ECG</option>
                    </select>
                    <br>
                    <input type="file" class="form-control" name="choosefile2" id="">
                    <div class="col-6 m-auto">
                        <button type="submit" name="btn2" class="btn btn-outline-success m-4">Submit</button>
                    </div>
                </form>
            </div>
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

</body>

</html>