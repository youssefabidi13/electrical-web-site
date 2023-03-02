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
  <title>Reclamtions</title>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
  <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
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
  <nav id="mainNav" class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="../index.php"><span>ELECTRICAL WEB SITE</span></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
        <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
      </button>
      <div id="navcol-1" class="collapse navbar-collapse" style="padding-left: 0px">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="dashboard_fournisseur.php">Dashboard</a>
          </li>
          <li class="nav-item"></li>
          <li class="nav-item"><a class="nav-link" href="verify.php">Annuelles</a></li>
          <li class="nav-item"></li>
          <li class="nav-item"><a class="nav-link" href="verifyMonth.php">Mensuelles</a></li>
          <li class="nav-item"></li>
          <li class="nav-item"><a class="nav-link active" href="showReclamation.php">Reclamation</a></li>
          <li class="nav-item"></li>
        </ul>
        <a class="btn btn-primary" href="../logout.php">logout</a>
      </div>
    </div>
  </nav>
  <section class="py-5 mt-5">
    <div class="container py-5">
      <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <h2 class="fw-bold">
            <br /><span class="underline pb-2">Reclamations</span>
          </h2>
        </div>
      </div>
      <div class="col-md-12 search-table-col">

        <div class="table-responsive table table-hover table-bordered results">
          <?php
          $idFour = $_SESSION['id'];
          $status = false;
          // Execute the SQL query
          $sql = "SELECT *
        FROM reclamation r
        WHERE contenue_reponse IS NULL OR status = '$status' and r.client_id in (SELECT c.ID
            FROM client c
            INNER JOIN agent a ON c.agent_id = a.id
            INNER JOIN manager m ON a.fournisseur_id = m.id
            WHERE m.id = $idFour);";
          $result = mysqli_query($mysqli, $sql);
          if (!$result) {
            die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
          }
          if ($result->num_rows > 0) {
          echo "<table class='table table-hover table-bordered' id='client_data'>";
          echo "<thead class='bill-header cs'>
                                <tr>
                                <th id='trs-hd-1' class='col-lg-3' style='color:black'>Id reclamation</th>
                                <th id='trs-hd-1' class='col-lg-2' style='color:black'>Id client</th>
                                <th id='trs-hd-2' class='col-lg-2' style='color:black'>Subject</th>
                                <th id='trs-hd-2' class='col-lg-7' style='color:black'>Reclamation</th>
                                <th id='trs-hd-2' class='col-lg-3' style='color:black'>Action</th>

                                </tr>
                            </thead>";
          echo "<tbody>";
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['client_id'] . "</td>";

            if ($row['autre_type'] == null) {
              echo "<td>" . $row['type_rec'] . "</td>";
            } else {
              echo "<td>" . $row['autre_type'] . "</td>";
            }
            echo "<td>" . $row['contenue'] . "</td>";

            echo '<td><a class="btn btn-primary" type="button" href="responseReclamation.php?id=' . $row['id'] . '&id_client=' . $row['client_id'] . '">Repondre</a></td>';
            echo "</tr>";
          }

          echo "</tbody>";
          echo "</table>";
        }else {
            echo '<div class="alert alert-success" role="alert">
Vous n\'avez pas une reclamation actuellement.
</div>';
        }
          ?>
        </div>
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
  <?php
     if (isset($_SESSION['send']) && $_SESSION['send'] == true) {
        echo "<script>
        Swal.fire({
                icon: 'success',
                title: 'Votre reponse a été enregistré envoyée',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
        $_SESSION['send'] = false;
    } 
    
    ?>
    <script>
        $(document).ready(function() {
            $('#client_data').DataTable();
        });
    </script>

</body>

</html>