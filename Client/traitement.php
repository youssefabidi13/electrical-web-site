
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
                echo "your file is too big !";
            }
        } else {
            echo "there was an error uploading your file !";
        }
    } else {
        echo "you cannot upload files of this type !";
    }
    $id = $_SESSION["id"];
    $mois = $_POST['mois'];
    $mois_pre = $mois - 1;
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
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        echo "<script src='../assets/js/sweet.js'>Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your facture has been added',
                            showConfirmButton: false,
                            timer: 1500
                          })</script>";
                        header("Location: facture.php");
                    }
                } else if ($consommation_f > 100 && $consommation_f <= 200) {
                    $HT = $consommation_f * 1.01;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        header("Location: facture.php");
                    } else {
                    }
                } else if ($consommation_f > 200) {
                    $HT = $consommation_f * 1.12;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        header("Location: facture.php");
                    }
                } else {
                    echo "<script>setTimeout(function() {alert('Veuillez ressayer ulterieurement'); }, 3000);</script>";
                }
            } else {
                $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination')";
                $result = mysqli_query($mysqli, $sql);
                if ($result) {
                    header("Location: facture.php");
                }
            }
        } else {
            // $sql = "SELECT * FROM facture WHERE mois='$mois'";
            // $result = mysqli_query($mysqli, $sql);
            // $user = mysqli_fetch_assoc($result);
            // $consommation_f = $consommation - $user['consommation'];
            if ($consommation >= 50 && $consommation <= 400) {
                if ($consommation <= 100) {
                    $HT = $consommation * 0.91;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        echo "<script src='../assets/js/sweet.js'>Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your facture has been added',
                            showConfirmButton: false,
                            timer: 1500
                          })</script>";
                        header("Location: facture.php");
                    }
                } else if ($consommation > 100 && $consommation <= 200) {
                    $HT = $consommation * 1.01;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        header("Location: facture.php");
                    }
                } else if ($consommation > 200) {
                    $HT = $consommation * 1.12;
                    $TTC = $HT + $HT * 0.14;
                    $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path, prix_HT,prix_TTC)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination', '$HT', '$TTC')";
                    $result = mysqli_query($mysqli, $sql);
                    if ($result) {
                        header("Location: facture.php");
                    }
                } else {
                    echo "<script>setTimeout(function() {alert('Veuillez ressayer ulterieurement'); });</script>";
                }
            } else {
                $sql = "INSERT INTO facture (client_id,consommation_monsuelle,mois,photo_path)
                    VALUES ('$id','$consommation', '$mois', '$fileDestination')";
                $result = mysqli_query($mysqli, $sql);
                if ($result) {
                    header("Location: facture.php");
                } else {
                }
            }
        }
    } else {
        
    echo "<script>
        alert('Le mois est déjà enregistré');
        window.location.href = 'facture.php';
        </script>";

    }
}
