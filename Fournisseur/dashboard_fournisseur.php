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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</head>
</head>

<body>

    <?php $id = $_SESSION['id']; ?>

    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
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
                            <label for="agent_id">Id d'agent</label>
                            <select name="agent_id" class="form-control" required>
                                <?php
                                // Récupération des ID des agents dans la table `agent`
                                $sql5 = "SELECT id FROM agent where fournisseur_id ='$id';";
                                $result5 = mysqli_query($mysqli, $sql5);

                                // Affichage des options dans la liste déroulante
                                while ($row = mysqli_fetch_assoc($result5)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                                }
                                ?>
                            </select>
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

    <section class="py-5 mt-5"><!-- Start: Testimonials -->
        <div class="container py-5">
            <!-- Content Row -->
            <div class="row no-gutters">

                <!-- somme facture non payee -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Factures non payées</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                                        $sql1 = "SELECT sum(prix_TTC) as sum FROM facture f where status_f = 'non_payee' and prix_HT is not NULL and prix_TTC is not null and f.client_id in (SELECT c.ID
                                                                                        FROM client c
                                                                                        INNER JOIN agent a ON c.agent_id = a.id
                                                                                        INNER JOIN manager m ON a.fournisseur_id = m.id
                                                                                        WHERE m.id = '$id')";
                                                                                        $result1 = mysqli_query($mysqli, $sql1);
                                                                                        $row1 = $result1->fetch_assoc();
                                                                                        echo $row1['sum'] . " MAD";
                                                                                        ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-dollar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <label for="mois">Consommation cummulée par mois: </label><br>
                                        <div id="consommationM" class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            if (isset($_POST['mois'])) {
                                                $selectedMois = $_POST["mois"];
                                            } else {
                                                $selectedMois = date('m');
                                            }

                                            $sql2 = "SELECT sum(consommation_monsuelle) as sum FROM facture WHERE mois='$selectedMois' AND client_id IN (SELECT c.ID FROM client c INNER JOIN agent a ON c.agent_id = a.id INNER JOIN manager m ON a.fournisseur_id = m.id WHERE m.id = $id)";
                                            $result2 = mysqli_query($mysqli, $sql2);
                                            $row2 = $result2->fetch_assoc();
                                            if ($row2['sum'] != null) {
                                                echo $row2['sum'] . " KWH <br>";
                                            } else {
                                                echo "<div class='alert alert-primary'>There is no data</div>";
                                            }
                                            ?>
                                            <form method="post" action="dashboard_fournisseur.php" onchange="this.submit()">
                                                <select id="mois" class="shadow form-control" name="mois" placeholder="Mois">
                                                    <?php
                                                    for ($i = 1; $i < 13; $i++) {
                                                        $selected = ($selectedMois == $i) ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>



                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Consommations par zone
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php
                                                                                                        if (isset($_POST['zone'])) {
                                                                                                            $selectedZone = $_POST["zone"];
                                                                                                        } else {
                                                                                                            $selectedZone = 1;
                                                                                                        }

                                                                                                        $sql5 = "SELECT SUM(f.consommation_monsuelle) AS sum
                                            FROM facture f
                                            JOIN client c ON f.client_id = c.ID
                                            JOIN agent a ON c.agent_id = a.id
                                            WHERE a.fournisseur_id ='$id' AND a.zone_number = '$selectedZone'";
                                                                                                        $result5 = mysqli_query($mysqli, $sql5);
                                                                                                        $row5 = $result5->fetch_assoc();
                                                                                                        if ($row5['sum'] != null) {
                                                                                                            echo $row5['sum'] . " KWH <br>";
                                                                                                        } else {
                                                                                                            echo "<div class='alert alert-primary'>There is no data</div>";
                                                                                                        }
                                                                                                        ?>
                                                <form method="post" action="dashboard_fournisseur.php" onchange="this.submit()">
                                                    <select id="zone" class="shadow form-control" name="zone" placeholder="Zone">
                                                        <?php
                                                        $query3 = "SELECT a.zone_number as zone
                                                        FROM manager m
                                                        INNER JOIN agent a ON m.id = a.fournisseur_id
                                                        WHERE m.id = '$id'
                                                        GROUP BY a.zone_number; ";
                                                        $result8 = mysqli_query($mysqli, $query3);
                                                        while ($row8 = $result8->fetch_assoc()) {
                                                            $selected = ($selectedZone == $row8['zone']) ? 'selected' : '';
                                                            echo '<option value="' . $row8['zone'] . '" ' . $selected . '>' . $row8['zone'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Reclamations
                                        <i class="fa fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                        $sql4 = "SELECT count(*) as count FROM reclamation r where contenue_reponse is null and fournisseur_id ='$id'";
                                        $result4 = mysqli_query($mysqli, $sql4);
                                        $row4 = $result4->fetch_assoc();
                                        echo $row4['count'];
                                        ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //chart
        $idF = $_SESSION['id'];

        $query = "SELECT mois, SUM(consommation_monsuelle) AS total_consommation_cumulee FROM facture f where f.client_id in (SELECT c.ID
FROM client c
INNER JOIN agent a ON c.agent_id = a.id
INNER JOIN manager m ON a.fournisseur_id = m.id
WHERE m.id = '$idF') GROUP BY mois ORDER BY mois ASC";
        $result6 = mysqli_query($mysqli, $query);
        if (!$result6) {
            die('Error: ' . mysqli_error($mysqli));
        }
        $chart_data = '';
        while ($row6 = mysqli_fetch_array($result6)) {
            $chart_data .= "{ month:'" . $row6["mois"] . "', consommation_cumulee:" . $row6["total_consommation_cumulee"] . "}, ";
        }

        $chart_data = substr($chart_data, 0, -2);
        if ($chart_data != '') {
            echo ' <div class="container" style="width: 900px">
            <h2 align="center">Consommation cumulée par mois</h2>
            <br />
            <br />
            <div id="chart"></div>
        </div>';
        } else {
            echo '
            <div class="container" style="width: 900px">
            <h2 align="center">Consommation cumulée par mois</h2>
            <br />
            <br />
            <div class="alert alert-danger">There is no data</div>
        </div>';
        }

        $query1 = "SELECT SUM(f.consommation_monsuelle) AS sum,a.zone_number 
        FROM facture f
        JOIN client c ON f.client_id = c.ID
        JOIN agent a ON c.agent_id = a.id
        WHERE a.fournisseur_id ='$id' group by a.zone_number order by a.zone_number asc";
        $result7 = mysqli_query($mysqli, $query1);
        if (!$result7) {
            die('Error: ' . mysqli_error($mysqli));
        }
        $chart_data1 = '';
        while ($row7 = mysqli_fetch_array($result7)) {
            $chart_data1 .= "{ zone:'" . $row7["zone_number"] . "', consommation_cumulee:" . $row7["sum"] . "}, ";
        }
        // var_dump($chart_data1);
        // die();
        $chart_data1 = substr($chart_data1, 0, -2);
        if ($chart_data1 != '') {
            echo ' <div class="container" style="width: 900px">
            <h2 align="center">Consommation cumulée par zone</h2>
            <br />
            <br />
            <div id="chartZone"></div>
            </div>';
        } else {
            echo '
            <div class="container" style="width: 900px">
            <h2 align="center">Consommation cumulée par zone</h2>
            <br />
            <br />
            <div class="alert alert-danger">There is no data</div>
        </div>';
        }
        ?>

        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="fw-bold"><br /><span class="underline pb-2">Les factures non payées</span></h2>
            </div>
        </div>

        <?php
        // Execute the SQL query
        $sql = "SELECT * FROM facture  
        WHERE status_f = 'non_payee' 
        AND prix_HT IS NOT NULL 
        AND prix_TTC IS NOT NULL 
        AND client_id IN (
            SELECT c.ID
            FROM client c
            INNER JOIN agent a ON c.agent_id = a.id
            INNER JOIN manager m ON a.fournisseur_id = m.id
            WHERE m.id = $id
        )";
        $result = mysqli_query($mysqli, $sql);
        if (!$result) {
            die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
        }
        ?>

        <?php
        echo " <div class='col-md-12 search-table-col'>
                    <div class='table-responsive table table-hover table-bordered results'>";
        if ($result->num_rows > 0) {
            echo "<table class='table table-hover table-bordered' id='client_data'>";
            echo "<thead class='bill-header cs'>
                <tr>
                <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id</th>
                <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id client</th>
                <th id='trs-hd-2' class='col-lg-2' style='color:black'>Annee</th>
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
                echo '<form action="avertissement.php" method="post">';
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['client_id'] . "</td>";
                echo "<td>" . $row['annee'] . "</td>";
                echo "<td>" . $row['mois'] . "</td>";
                echo "<td>" . $row['consommation_monsuelle'] . "</td>";
                echo "<td>" . $row['prix_HT'] . "</td>";
                echo "<td>" . $row['prix_TTC'] . "</td>";
                echo "<td>" . $row['status_f'] . "</td>";
                echo '<input type="hidden" value="'. $row['client_id'] .'" name="idC">';
                echo '<td><input class="btn btn-danger" style="margin-left: 5px;" type="submit" value="Envoyer un avertissement"></input></td>
                </form>';
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>
                            </div>";
        } else {
            echo '<div class="alert alert-success" role="alert">
Tous les factures ont été payée
</div>';
        }
        ?>

        </div><!-- End: Testimonials -->
    </section>
    <section class="py-0 mt-0">
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
                    $sql = "SELECT c.* , a.zone_number
                    FROM client c
                    INNER JOIN agent a ON c.agent_id = a.id
                    INNER JOIN manager m ON a.fournisseur_id = m.id
                    WHERE m.id = '$id';";
                    $result = $mysqli->query($sql);

                    // Output the HTML table
                    echo "<table class='table table-hover table-bordered' id='client_data1'>";
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
            <!-- End: Table With Search --><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="bi-plus-circle me-2"></i>Ajouter Client</button>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="../assets/js/DataTable---Fully-BSS-Editable-style.js"></script>
    <script src="../assets/js/Dynamic-Table-dynamic-table.js"></script>
    <script src="../assets/js/startup-modern.js"></script>
    <script src="../assets/js/Table-With-Search-search-table.js"></script>

    <script>
        $(document).ready(function() {
            $('#client_data').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#client_data1').DataTable();
        });
    </script>
    <?php
    if (isset($_SESSION['addClient']) && $_SESSION['addClient'] == true) {
        echo "<script>
    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Votre client a été bien enregistrer',
            showConfirmButton: false,
            timer: 1500
          })
        </script>";
        $_SESSION['addClient'] = false;
    }
    if (isset($_SESSION['addClientAlready']) && $_SESSION['addClientAlready'] == true) {
        echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
            text: 'Un autre client a cet email , essayer avec un autre email',
          })
        </script>";
        $_SESSION['addClientAlready'] = false;
    }
    if (isset($_SESSION['notAdd']) && $_SESSION['notAdd'] == true) {
        echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
            text: 'Veuillez ressayer ulterieurement',
            
          })
        </script>";
        $_SESSION['notAdd'] = false;
    }
    if (isset($_SESSION['success']) && $_SESSION['success'] == true) {
        echo "<script>
    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Votre client a été bien modifié',
            showConfirmButton: false,
            timer: 1500
          })
        </script>";
        $_SESSION['success'] = false;
    }
    ?>
    <?php

if (isset($_SESSION['addA']) && $_SESSION['addA'] == true) {
    echo "<script>
    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Votre avertissement a été envoyée',
            showConfirmButton: false,
            timer: 1500
          })
        </script>";
    $_SESSION['addA'] = false;
} else if (isset($_SESSION['notAddA']) && $_SESSION['notAddA'] == true) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Votre avertissement n'a pas été envoyée, Veuillez ressayer ulterieurement !',
          })
        </script>";
    $_SESSION['notAddA'] = false;
}
?>
    <script>
        Morris.Bar({
            element: 'chart',
            data: [<?php echo $chart_data; ?>],
            xkey: 'month',
            ykeys: ['consommation_cumulee'],
            labels: ['consommation cumulee'],
            hideHover: 'auto'
        });
    </script>
    <script>
        Morris.Bar({
            element: 'chartZone',
            data: [<?php echo $chart_data1; ?>],
            xkey: 'zone',
            ykeys: ['consommation_cumulee'],
            labels: ['consommation cumulee'],
            hideHover: 'auto'
        });
    </script>
    </script>
</body>

</html>