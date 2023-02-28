<?php
require_once "../config.php";
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedinFournisseur"]) || $_SESSION["loggedinFournisseur"] !== true) {
    header("location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
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
</head>

<body>
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="traitement.php" method="POST" id="add_employee_form" enctype="multipart/form-data">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nom">Nom</label>
              <input type="text" name="nom" class="form-control" placeholder="Nom" required>
            </div>
            <div class="col-lg">
              <label for="prenom">Prenom</label>
              <input type="text" name="prenom" class="form-control" placeholder="Prenom" required>
            </div>
          </div>
          <div class="my-2">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="my-2">
            <label for="adresse">Id d'agent</label>
            <input type="number" name="agent_id" class="form-control" placeholder="Agent_id" required>
          </div>
          <div class="my-2">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit-add-client" id="add_employee_btn" class="btn btn-primary" name="submitAdd">AjouterClient</button>
        </div>
      </form>
    </div>
  </div>
</div>
    <nav id="mainNav" class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <span>ELECTRICAL WEB SITE</span></a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div id="navcol-1" class="collapse navbar-collapse" style="padding-left: 0px;">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="dashboard_fournisseur.php">Dashboard</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="verify.php">Annuelles</a></li>
                <li class="nav-item"></li>
                <li class="nav-item"><a class="nav-link" href="verifyMonth.php">Mensuelles</a></li>
                <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="showReclamation.php">Reclamation</a></li>
                </ul><a class="btn btn-primary" href="../logout.php">logout</a>
            </div>
        </div>
    </nav>
    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold"><br>
                        <span class="underline pb-2">Mes clients</span>
                    </h2>
                </div>
            </div><!-- Start: Table With Search -->
            <div class="col-md-12 search-table-col">
                <!-- <div class="form-group pull-right col-lg-4"><input type="text" class="search form-control" placeholder="Search by typing here.."></div> -->
                <span class="counter pull-right"></span>
                <div class="table-responsive table table-hover table-bordered results">
                    <?php

                    // Execute the SQL query
                    $sql = "SELECT c.ID, c.nom, c.prenom, c.password,c.email ,a.zone_number
                    FROM client c
                    JOIN agent a ON c.agent_id = a.id;";
                    $result = $mysqli->query($sql);

                    // Output the HTML table
                    echo "<table class='table table-hover table-bordered' id='client_data'>";
                    echo "<thead class='bill-header cs'>
                        <tr>
                            <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id client</th>
                            <th id='trs-hd-2' class='col-lg-2' style='color:black'>Nom</th>
                            <th id='trs-hd-3' class='col-lg-3' style='color:black'>Prenom</th>
                            <th id='trs-hd-4' class='col-lg-2' style='color:black'>Password</th>
                            <th id='trs-hd-5' class='col-lg-5' style='color:black'>email</th>
                            <th id='trs-hd-6' class='col-lg-2' style='color:black'>Zone geographique</th>
                            <th id='trs-hd-7' class='col-lg-3' style='color:black'>Action</th>
                        </tr>
                        </thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $row['prenom'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['zone_number'] . "</td>";
                        echo '<td><a class="btn btn-primary" type="button" href="modifierFournisseur.php?id=' . $row['ID'] . '">Modifier client</a></td>';
                        echo "</tr>";
                      }                      
                    echo "</tbody>";
                    echo "</table>";

                    ?>
                </div>
            </div>
            <!-- End: Table With Search --><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Ajouter Client</button>
        </div>
    </section>
    <section class="py-5 mt-5"><!-- Start: Testimonials -->
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold"><br /><span class="underline pb-2">Les factures non payées</span></h2>
                </div>
            </div>
            <div class="col-md-12 search-table-col">
                <div class="table-responsive table table-hover table-bordered results">
                    <?php
                    // Execute the SQL query
                    $sql = 'SELECT * FROM facture  where status_f = "non_payee" and prix_HT is not NULL and prix_TTC is not null;';
                    $result = mysqli_query($mysqli, $sql);
                    if (!$result) {
                        die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
                    }
                    
                    if ($result->num_rows > 0) {
                        echo "<table class='table table-hover table-bordered' id='client_data'>";
                        echo "<thead class='bill-header cs'>
            <tr>
            <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id</th>
            <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id client</th>
            <th id='trs-hd-2' class='col-lg-2' style='color:black'>Mois</th>
            <th id='trs-hd-3' class='col-lg-2' style='color:black'>Consommation</th>
            <th id='trs-hd-4' class='col-lg-3' style='color:black'>prix HT en MAD</th>
            <th id='trs-hd-5' class='col-lg-3' style='color:black'>Prix TTC en MAD</th>
            <th id='trs-hd-6' class='col-lg-2' style='color:black'>Status</th>
            <th id='trs-hd-7' class='col-lg-5' style='color:black'>Action</th>

            </tr>
        </thead>";
                        echo "<tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['client_id'] . "</td>";
                            echo "<td>" . $row['mois'] . "</td>";
                            echo "<td>" . $row['consommation_monsuelle'] . "</td>";
                            echo "<td>" . $row['prix_HT'] . "</td>";
                            echo "<td>" . $row['prix_TTC'] . "</td>";
                            echo "<td>" . $row['status_f'] . "</td>";
                            echo '<td><button class="btn btn-danger" style="margin-left: 5px;" type="submit">Envoyer un avertissement</button></td>';
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
                    ?>
                </div>
            </div>
        </div><!-- End: Testimonials -->
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
    <script src="../assets/js/DataTable---Fully-BSS-Editable-style.js"></script>
    <script src="../assets/js/Dynamic-Table-dynamic-table.js"></script>
    <script src="../assets/js/startup-modern.js"></script>
    <script src="../assets/js/Table-With-Search-search-table.js"></script>
    <script>  
 $(document).ready(function(){  
      $('#client_data').DataTable();  
 });  
 </script> 
</body>

</html>