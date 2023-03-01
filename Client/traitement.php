
<?php
require_once "../config.php";
// Initialize the session
session_start();


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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $sql = "DELETE FROM reclamation WHERE id='$id'";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        $_SESSION['delete'] = true;
        header("Location: response.php");
    }
}
