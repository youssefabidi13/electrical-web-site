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
    <title>Modification</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
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
    <nav id="mainNav" class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="../index.php"><span>ELECTRICAL WEB SITE</span></a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-1" class="collapse navbar-collapse" style="padding-left: 0px;">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard_fournisseur.php">Dashboard</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link" href="verify.php">Annuelles</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link active" href="verifyMonth.php">Mensuelles</a></li>
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
                    <h2 class="fw-bold"><br /><span class="underline pb-2">Modifier consommation</span></h2>
                </div>
            </div>

            <div class="col-md-12 search-table-col">
                <div class="table-responsive table table-hover table-bordered results">
                    <table class="table table-hover table-bordered">
                        <thead class="bill-header cs">
                            <tr>
                                <th id='trs-hd-1' class='col-lg-1' style='color:black'>Id</th>
                                <th id='trs-hd-1' class='col-lg-3' style='color:black'>Id client</th>
                                <th id='trs-hd-2' class='col-lg-2' style='color:black'>Mois</th>
                                <th id='trs-hd-3' class='col-lg-4' style='color:black'>Consommation total</th>
                                <th id='trs-hd-3' class='col-lg-3' style='color:black'>Preuve</th>
                                <th id='trs-hd-6' class='col-lg-3' style='color:black'>Status</th>
                                <th id='trs-hd-7' class='col-lg-6' style='color:black'>Approuver modification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT  * FROM facture f WHERE id = $id";
                                $result = $mysqli->query($sql);
                                $row = $result->fetch_assoc();
                                if (!$result) {
                                    die("Query failed: " . $mysqli->error);
                                } ?>
                            <form method="post" action="traitement.php">
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['client_id']; ?></td>
                                    <td><?php echo $row['mois']; ?></td>
                                    <td><input type="number" name="consommation_monsuelle" class="form-control" value="<?php echo $row['consommation_monsuelle']; ?>"></td>
                                    <?php
                                    echo '<td><button onclick="showImage(\'../Client/' . $row['photo_path'] . '\')" class="btn btn-primary">Voir preuve</button></td>';
                                    echo "<td>" . $row['status_f'] . "</td>";
                                    ?>
                                    <input type="hidden" name="status_f" value="<?php echo $row['status_f']; ?>">

                                    <input type="hidden" name="client_id" value="<?php echo $row['client_id']; ?>">
                                    <input type="hidden" name="mois" value="<?php echo $row['mois']; ?>">
                                    <input type="hidden" name="photo_path" value="<?php echo $row['photo_path']; ?>">


                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <td><input type="submit" class="btn btn-primary" name="submitUpdate" value="Valider"></td>
                                </tr>
                            </form>

                        </tbody>
                    </table>
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
    <script>
        function showImage(imagePath) {
            var modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.zIndex = '1';
            modal.style.left = '0';
            modal.style.top = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.overflow = 'auto';
            modal.style.backgroundColor = 'rgba(0,0,0,0.9)';
            modal.onclick = function() {
                modal.remove();
            };
            var img = document.createElement('img');
            img.src = imagePath;
            img.style.margin = 'auto';
            img.style.display = 'block';
            img.style.maxWidth = '90%';
            img.style.maxHeight = '90%';
            img.onclick = function(event) {
                event.stopPropagation();
            };
            modal.appendChild(img);
            document.body.appendChild(modal);
        }
    </script>
    
</body>

</html>