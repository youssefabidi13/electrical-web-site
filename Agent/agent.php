<?php
require_once "../config.php";
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}  if (isset($_POST['submit'])) {



        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('txt','docx');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'uploads/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $_SESSION['add'] = true;
                } else {
                    $_SESSION['big'] = true;
    
                    //echo "your file is too big !";
                }
            } else {
                $_SESSION['error'] = true;
    
                //echo "there was an error uploading your file !";
            }
        } else {
            $_SESSION['type'] = true;
    
            //echo "you cannot upload files of this type !";
        }
    }else{
        $_SESSION['notAdd'] = true;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Agent</title>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Button-Outlines---Pretty.css">
    <link rel="stylesheet" href="../assets/css/Dynamic-Table.css">
    <link rel="stylesheet" href="../assets/css/Fully-responsive-table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="../assets/css/Table-With-Search-search-table.css">
    <link rel="stylesheet" href="../assets/css/Table-With-Search.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="/"><span>ELECTRICAL WEB
                    SITE</span></a><button data-bs-toggle="collapse" data-bs-target="#navcol-1"
                class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1" style="padding-left: 0px;">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul><a class="btn btn-primary" href="../logout.php">logout</a>
            </div>
        </div>
    </nav>
    <section class=" py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold"><br /><span class="underline pb-2">Les consomations
                            annuelles </span></h2>
                </div>
            </div>
        
        
        <div class="col-md-12 search-table-col">
                <div class="table-responsive table table-hover table-bordered results">
                    <?php

                    // Execute the SQL query
                    $sql = 'SELECT *
                    FROM consommation_annuelle  where decalage is  null';
                    $result = mysqli_query($mysqli, $sql);
                    if (!$result) {
                        die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
                    }
                    if ($result->num_rows > 0) {

                        echo "<table class='table table-hover table-bordered' id='client_data'>";
                        echo "<thead class='bill-header cs'>
                                <tr>
                                <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id</th>
                                <th id='trs-hd-1' class='col-lg-3' style='color:black'>Id client</th>
                                <th id='trs-hd-3' class='col-lg-4' style='color:black'>Consommation annuelle</th>
                                <th id='trs-hd-3' class='col-lg-4' style='color:black'>Année</th>
                                </tr>
                            </thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['client_id'] . "</td>";
                            echo "<td>" . $row['consommation'] . "</td>";
                            echo "<td>" . $row['annee'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo '<div class="alert alert-success" role="alert">
A l\'instant il n\' y a pas un fichier inserer par vous .
</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="custom-file">
            <form method="post" action="agent.php" enctype="multipart/form-data">
                <input class="custom-file-input" type="file" name="file" />
                <label class="form-label custom-file-label">Upload File consommation_annuel</labelclass>
                <input type="submit" name="submit" class="btn btn-primary" value="Envoyer">
            </form>  
            </div>
            
        </div>
    </section>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
  <script src="../assets/js/DataTable---Fully-BSS-Editable-style.js"></script>
  <script src="../assets/js/Dynamic-Table-dynamic-table.js"></script>
  <script src="../assets/js/startup-modern.js"></script>
  <script src="../assets/js/Table-With-Search-search-table.js"></script>
    <script>
        $(document).ready(function() {
            $('#client_data').DataTable();
        });
    </script>
 <?php
    if (isset($_SESSION['add']) && $_SESSION['add'] == true) {
        echo "<script>
        Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Votre fichier a été enregistré',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
        $_SESSION['add'] = false;
    } else if (isset($_SESSION['error']) && $_SESSION['error'] == true) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'there was an error uploading your file !!',
              })
            </script>";
        $_SESSION['error'] = false;
    } elseif (isset($_SESSION['big']) && $_SESSION['big'] == true) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'your file is too big !',
              })
            </script>";
        $_SESSION['big'] = false;
    } else if (isset($_SESSION['type']) && $_SESSION['type'] == true) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'you cannot upload files of this type !',
              })
            </script>";
        $_SESSION['type'] = false;
    }else if(isset($_SESSION['notAdd']) && $_SESSION['notAdd'] == true){
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'aucun fichier est choisi !!',
              })
            </script>";
        $_SESSION['notAdd'] = false;
    }
    ?>
</body>

</html>