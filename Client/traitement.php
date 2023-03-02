
<?php
require_once "../config.php";
// Initialize the session
session_start();
require('../FPDF/FPDF/fpdf.php');
if (isset($_GET['idFacture'])) {
    $id = $_GET['idFacture'];

    $sql = 'SELECT f.*, c.nom as nom, c.prenom as prenom, a.zone_number as zone_number
    FROM facture f 
    JOIN client c ON f.client_id = c.ID 
    JOIN agent a ON c.agent_id = a.id 
    WHERE f.id = ' . $id . ';';

    $result = mysqli_query($mysqli, $sql);
    $row = $result->fetch_assoc();
    if (!$result) {
        die('Erreur lors de l\'exécution de la requête : ' . mysqli_error($mysqli));
    } else {
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $mois = $row['mois'];
        $zone_geographique = $row['zone_number'];
        $consommation = $row['consommation_monsuelle'];
        $prix_HT = $row['prix_HT'];
        $prix_TTC = $row['prix_TTC'];
        $status = $row['status_f'];
        $nom_complet = $nom . " " . $prenom;
        $_SESSION['download'] = true;
        // Création de la facture
        $pdf = new FPDF();
        $pdf->AddPage();

        // Ajout du titre de la facture
        $pdf->SetFont('Arial', 'BIU', 16);
        $pdf->SetX(90);
        $pdf->SetTextColor(255,0,0);
        $pdf->Cell(40, 10, 'Facture');
        $pdf->SetTextColor(0,0,0);

        // Ajout des informations de la facture
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Nom : ');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $nom_complet);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Zone geographique :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(60);
        $pdf->Cell(60, 10, $zone_geographique);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Mois :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $mois);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Consommation totale jusqu a ce mois :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(100);

        $pdf->Cell(60, 10, $consommation);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Prix HT :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $prix_HT);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Prix TTC :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $prix_TTC);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Statut :');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(60, 10, $status);

        if($status == 'non_payee'){
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(255,0,0);
            $pdf->Cell(60, 10, 'Vous devez payee votre facture aussi vite que possible ');
        }

        // Génération du PDF
        $pdf->Output('F', 'facture.pdf');
        header("Location: facture.php");
    }
}




// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedinClient"]) || $_SESSION["loggedinClient"] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_POST['submitAdd'])) {



    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                $_SESSION['big'] = true;
                header("Location: facture.php");

                //echo "your file is too big !";
            }
        } else {
            $_SESSION['error'] = true;
            header("Location: facture.php");

            //echo "there was an error uploading your file !";
        }
    } else {
        $_SESSION['type'] = true;
        header("Location: facture.php");

        //echo "you cannot upload files of this type !";
    }
    $id = $_SESSION["id"];
    $mois = $_POST['mois'];
    $mois_pre = $mois - 1;
    $annee = $_POST['annee'];
    $consommation = $_POST['consommation'];

    $sql = "SELECT * FROM facture WHERE mois='$mois'";
    $result = mysqli_query($mysqli, $sql);
    if (!$result->num_rows > 0) {

        if ($mois != 01) {
            $sql = "SELECT * FROM facture WHERE mois='$mois_pre'";
            $result = mysqli_query($mysqli, $sql);
            $user = mysqli_fetch_assoc($result);
            $consommation_f = $consommation - $user['consommation_monsuelle'];

            if ($consommation_f >= 50 && $consommation_f <= 400) {
                if ($consommation_f <= 100) {
                    $HT = $consommation_f * 0.91;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else if ($consommation_f > 100 && $consommation_f <= 200) {
                    $HT = $consommation_f * 1.01;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else if ($consommation_f > 200) {
                    $HT = $consommation_f * 1.12;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else {
                    $_SESSION['notAdd'] = true;
                    header("Location: facture.php");
                }
            } else {
                $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path,annee)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination','$annee')";
                $result = mysqli_query($mysqli, $sql);

                if ($result) {
                    $_SESSION['addIf'] = true;
                    header("Location: facture.php");
                } else {
                    $_SESSION['notAdd'] = true;
                    header("Location: facture.php");
                }
            }
        } else {
            $ann = $annee - 1;
            $sql3 = "SELECT annee FROM consommation_annuelle WHERE client_id='$id'";
            $result3 = mysqli_query($mysqli, $sql3);
            $user3 = mysqli_fetch_assoc($result3);
            if ($user3['annee'] == null) {
                $dec = 0;
            } else {
                $sql1 = "SELECT * FROM consommation_annuelle WHERE client_id='$id' and annee='$ann'";
                $result1 = mysqli_query($mysqli, $sql1);
                $user1 = mysqli_fetch_assoc($result1);
                $dec = $user1['decalage'];
            }
            $consommation_f = $consommation + $dec;
            if ($consommation_f >= 50 && $consommation_f <= 400) {
                if ($consommation_f <= 100) {
                    $HT = $consommation_f * 0.91;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation_f', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else if ($consommation_f > 100 && $consommation_f <= 200) {
                    $HT = $consommation_f * 1.01;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation_f', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else if ($consommation_f > 200) {
                    $HT = $consommation_f * 1.12;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC,annee)
                    VALUES ('$id','$consommation_f', '$mois', '$fileDestination', '$HT', '$TTC','$annee')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        $_SESSION['add'] = true;
                        header("Location: facture.php");
                    } else {
                        $_SESSION['notAdd'] = true;
                        header("Location: facture.php");
                    }
                } else {
                    $_SESSION['notAdd'] = true;
                    header("Location: facture.php");
                }
            } else {
                $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path,annee)
                    VALUES ('$id','$consommation_f', '$mois', '$fileDestination','$annee')";
                $result = mysqli_query($mysqli, $sql);
                if ($result) {
                    $_SESSION['addIf'] = true;
                    header("Location: facture.php");
                } else {
                    $_SESSION['notAdd'] = true;
                    header("Location: facture.php");
                }
            }
        }
    } else {


        header("Location: facture.php");
        $_SESSION['moisDeja'] = true;
    }
}
if (isset($_POST['submitRec'])) {
    $subject  = $_POST['subject'];
    $other_subject = $_POST['otherSubject'];
    $message = $_POST['message'];
    $id = $_SESSION["id"];
    $sql = "SELECT agent.fournisseur_id
        FROM agent
        INNER JOIN client ON agent.id = client.agent_id
        WHERE client.ID = $id;";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_f = $row['fournisseur_id'];
    if ($subject == 'Autre') {

        $sql = "INSERT INTO reclamation (client_id,contenue,fournisseur_id,type_rec,autre_type)
                    VALUES ('$id','$message', '$id_f', '$subject','$other_subject')";
        $result = mysqli_query($mysqli, $sql);
        if ($result) {
            $_SESSION['add'] = true;
            header("Location: dashboard.php");
        } else {
            $_SESSION['notAdd'] = true;
            header("Location: dashboard.php");
        }
    } else {
        $sql = "INSERT INTO reclamation (client_id,contenue,fournisseur_id,type_rec)
                    VALUES ('$id','$message', '$id_f', '$subject')";
        $result = mysqli_query($mysqli, $sql);
        if ($result) {
            $_SESSION['add'] = true;
            header("Location: dashboard.php");
        } else {
            $_SESSION['notAdd'] = true;
            header("Location: dashboard.php");
        }
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM reclamation WHERE id='$id'";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $_SESSION['delete'] = true;
        header("Location: response.php");
    }
}
