<?php 
    session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "researchpaper";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

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
                    if($_SESSION['Role'] != 'Admin' && $_SESSION['Role'] != 'Doctor' && $_SESSION['Role'] != 'admin' && $_SESSION['Role'] != 'doctor'){
                        //if role is pharmacist then no access to dashboard
                        header("Location: ./prescription.php");
                    }
                }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .main-img {
            height: 60vh !important;
        }

        .slidebar div img {
            height: 100vh;
        }

        /* .container {
            display: flex;
            justify-content: space-evenly;
        } */

        .container div {
            text-align: center;
            margin: 10px auto;
        }

        .container img {
            border: 2px solid white;
            border-radius: 15px;
        }

        .aboutUs {
            background-color: #212529;
            height: 30vh;
            color: #ffffff;
        }

        .aboutUs .container-fluid {
            display: inline;
        }

        .aboutUs h3 {
            text-align: center;
        }

        #message {
            margin-right: 5px;
            padding: 7px 10px;
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
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active" aria-current="page" href="./index.php">DASHBOARD</a> </li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./reports.php">REPORTS</a></li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./prescription.php">PRESCRIPTION</a></li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./UploadDocument.php">UPLOAD DOCUMENTS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Doctor' || $_SESSION['Role'] == 'doctor') { ?>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active" aria-current="page" href="./index.php">DASHBOARD</a> </li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="./reports.php">REPORTS</a></li>
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold" href="#">MEDICLAIM DETAILS</a></li>
                        <?php    }
                            elseif($_SESSION['Role'] == 'Pharmacist' || $_SESSION['Role'] == 'pharmacist') { ?> 
                                <li class="nav-item"> <a class="nav-link pe-3 me-4 fw-bold active" href="./prescription.php">PRESCRIPTION</a></li>
                                
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

    <div class="container">
        hello fiuc
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