<?php
require_once "../config.php";
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedinClient"]) || $_SESSION["loggedinClient"] !== true) {
    header("location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Factures</title>
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
    
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une consommation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="traitement.php" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                            <div class="my-2">
                                <label for="consommation">Consommation actuelle en Kwh</label>
                                <input type="number" name="consommation" class="form-control" placeholder="consommation" required min="0">
                            </div>
                            <div class="col-lg">
                                <label for="mois">Mois</label>
                                <select type="number" name="mois" class="form-control" placeholder="Mois" required>
                                    <?php
                                    // Récupérer la date actuelle
                                    $now = new DateTime();
                                    // Créer une date pour le 1er janvier de l'année en cours
                                    $start = new DateTime($now->format('Y') . '-01-01');
                                    // Parcourir chaque mois entre la date de début et la date actuelle
                                    while ($start <= $now) {
                                        // Afficher le mois sous forme d'option dans la liste déroulante
                                        echo '<option  value="' . $start->format('m') . '">' . $start->format('m') . '</option>';
                                        // Ajouter un mois à la date de début pour passer au mois suivant
                                        $start->add(new DateInterval('P1M'));
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-lg">
                                <label for="annee">Année</label>

                                <select type="number" name="annee" class="form-control" placeholder="Année" required>
                                    <?php
                                    // Récupérer l'année actuelle
                                    $currentYear = date('Y');
                                    // Parcourir les 10 années précédentes à partir de l'année actuelle
                                    for ($i = $currentYear - 5; $i <= $currentYear; $i++) {
                                        // Afficher chaque année sous forme d'option dans la liste déroulante
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="my-2">
                            <label for="file">Preuve</label>
                            <input type="file" name="file" class="form-control" placeholder="preuve" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit-add-client" id="add_employee_btn" class="btn btn-primary" name="submitAdd">Ajouter Consomation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <nav id="mainNav" class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="../index.php"><span>ELECTRICAL WEB SITE</span></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-1" class="collapse navbar-collapse" style="padding-left: 0px;">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link active" href="facture.php">Mes factures</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="reclamation.php">Ajouter une reclamation</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="response.php">Reponses</a></li>
                    <li class="nav-item"></li>
                </ul><a class="btn btn-primary" href="../logout.php">logout</a>
            </div>
        </div>
    </nav>
    <section class="py-0 mt-5"><!-- Start: Testimonials -->
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <span class="fw-bold" style="font-size: xx-large;"><u>Welcome <?php echo $_SESSION["nom"] . ' ' . $_SESSION["prenom"]; ?></u></span>
                    <h2 class="fw-bold"><br /><span class="underline pb-2">Mes factures</span></h2>
                </div>
            </div>
            <div class="col-md-12 search-table-col">

                <div class="table-responsive table table-hover table-bordered results">
                    <?php

                    // Execute the SQL query
                    $sql = 'SELECT *
                    FROM facture  where client_id = ' . $_SESSION["id"] . ' and prix_HT is not null and prix_TTC is not null;';
                    $result = mysqli_query($mysqli, $sql);
                    if (!$result) {
                        die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
                    }
                    echo "<table class='table table-hover table-bordered' id='client_data'>";
                    echo "<thead class='bill-header cs'>
                                <tr>
                                <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id</th>
                                <th id='trs-hd-2' class='col-lg-2' style='color:black'>Année</th>
                                <th id='trs-hd-2' class='col-lg-2' style='color:black'>Mois</th>
                                <th id='trs-hd-3' class='col-lg-4' style='color:black'>Consommation total</th>
                                <th id='trs-hd-4' class='col-lg-3' style='color:black'>prix HT en MAD</th>
                                <th id='trs-hd-5' class='col-lg-3' style='color:black'>Prix TTC en MAD</th>
                                <th id='trs-hd-6' class='col-lg-2' style='color:black'>Status</th>
                                <th id='trs-hd-7' class='col-lg-6' style='color:black'>Action</th>
    
                                </tr>
                            </thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['annee'] . "</td>";
                        echo "<td>" . $row['mois'] . "</td>";
                        echo "<td>" . $row['consommation_monsuelle'] . "</td>";
                        echo "<td>" . $row['prix_HT'] . "</td>";
                        echo "<td>" . $row['prix_TTC'] . "</td>";
                        echo "<td>" . $row['status_f'] . "</td>";
                        if ($row['status_f'] == 'non_payee') {
                            echo '<td><button class="btn btn-danger" style="margin-left: 5px;" type="submit">Payez votre facture</button></td>';
                        } else {
                            echo '<td><button class="btn btn-primary" style="margin-left: 5px;" type="submit">Telecharger facture</button></td>';
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div><!-- End: Testimonials --><!-- Start: Testimonials -->
        <div class="container py-0">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold"><br><span class="underline pb-2">Options</span></h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Options</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ajouter consomation</td>
                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i class="bi-plus-circle me-2"></i>Ajouter Consommation</button>
            </div>
            </td>
            </tr>
            <tr>
                <td>Voir les factures non payées</td>
                <td><a class="btn btn-primary" href="dashboard.php">voir les factures non payées</a></td>
            </tr>
            </tbody>
            </table>
        </div>
        </div><!-- End: Testimonials -->
    </section>
    <div class="btn-toolbar">
        <div class="btn-group" role="group"></div>
        <div class="btn-group" role="group"></div>
    </div><!-- Start: Footer Multi Column -->
    <footer>
        <div class="container py-4 py-lg-5">
            <hr>
            <div class="text-muted d-flex justify-content-between align-items-center pt-3">
                <p class="mb-0">Copyright © 2023&nbsp;</p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                        </svg></li>
                </ul>
            </div>
        </div>
    </footer><!-- End: Footer Multi Column -->
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
    <?php
    if (isset($_SESSION['moisDeja']) && $_SESSION['moisDeja'] == true) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Le mois est déjà enregistré!',
              })
            </script>";
        $_SESSION['moisDeja'] = false;
    } else if (isset($_SESSION['add']) && $_SESSION['add'] == true) {
        echo "<script>
        Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Votre consommation a été enregistré',
                showConfirmButton: false,
                timer: 1500
              })
            </script>";
        $_SESSION['add'] = false;
    } else if (isset($_SESSION['notAdd']) && $_SESSION['notAdd'] == true) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Votre consommation n'a pas été enregistré, Veuillez ressayer ulterieurement !',
              })
            </script>";
        $_SESSION['notAdd'] = false;
    } else if (isset($_SESSION['addIf']) && $_SESSION['addIf'] == true) {
        echo "
        <script>
        Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Votre consommation a été enregistré,veullez attendre la validation du manager ',
                showConfirmButton: false,
                timer: 3500
              })
            </script>";
        $_SESSION['addIf'] = false;
    }
    if (isset($_SESSION['error']) && $_SESSION['error'] == true) {
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
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#client_data').DataTable();
        });
    </script>
</body>

</html>