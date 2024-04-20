<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task on Click</title>
</head>
<body>

<?php
// Check if the form is submitted
if(isset($_GET['performTask'])) {
    // Perform your SQL query
    echo "HIi buddy:-  ".$_GET['performTask'];
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $selectedFruits = $_POST["Situation"];
    $email = $_POST["inputEmail"];
    $password = $_POST["inputPassword"];
    if(($email=='amar@gmail.com' && $selectedFruits=='OPD_Visit') || ($email=='amar@gmail.com' && $selectedFruits=='Hospital_Visit')){
        echo "HEllo doctor";
    }
    else{
        echo "error in the if_else";
    }
}
else{
    echo "Dropdown not working";
}

?>

<!-- Link triggering the form submission on click -->
<a href="?performTask=1">Perform SQL Query</a>

<form method="post">
    <input name="inputEmail" type="email" placeholder="Email address" required="" autofocus="" class="form-control rounded-pill border-1 shadow-sm px-4">
    <input name="inputPassword" type="password" placeholder="Password" required="" class="form-control rounded-pill border-1 shadow-sm px-4 text-primary">
                                
    <select name="Situation" id="Situation" class="form-control rounded-pill border-1 shadow-sm px-4">
                                        <option value="OPD_Visit">OPD VISIT</option>
                                        <option value="Lab_Test">LAB TEST</option>
                                        <option value="Pharmacist_Shop_Visit">PHARMA SHOP VISIT</option>
                                        <option value="Hospital_Visit">HOSPITAL VISIT</option>
                                        <option value="First_Time_Visit">FIRST TIME VISIT</option>
                                        <option value="ICU"></option>
    </select>
    <button type="submit">Sign in</button>
</form>

</body>
</html>
