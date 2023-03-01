<?php
require_once "../config.php";
// Initialize the session
session_start();


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedinFournisseur"]) || $_SESSION["loggedinFournisseur"] !== true) {
    header("location: ../login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $mois = $_GET['mois'];

    $sql = "SELECT * FROM facture WHERE mois='$mois' and client_id ='$id'";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $mois_pre = $mois - 1;

    $consommation = $row['consommation_monsuelle'];
    echo $consommation;

    if ($mois != 01) {
        $sql = "SELECT * FROM facture WHERE mois='$mois_pre' and client_id ='$id';";
        $result = mysqli_query($mysqli, $sql);
        $user = mysqli_fetch_assoc($result);
        $consommation_f = $consommation - $user['consommation_monsuelle'];
        if ($consommation < 50) {
            $HT = $consommation_f * 0.91;
            $TTC = $HT + $HT * 0.14;
            $sql = "UPDATE facture SET prix_HT='$HT', prix_TTC='$TTC' WHERE mois='$mois' AND client_id='$id';";

            $result = mysqli_query($mysqli, $sql);
            if ($result) {

                $_SESSION['add'] = true;
                header("Location: verifyMonth.php");
            }
        } else if ($consommation > 400) {
            $HT = $consommation_f * 1.12;
            $TTC = $HT + $HT * 0.14;
            $sql = "UPDATE facture SET prix_HT='$HT', prix_TTC='$TTC' WHERE mois='$mois' AND client_id='$id';";

            $result = mysqli_query($mysqli, $sql);
            if ($result) {
                $_SESSION['add'] = true;
                header("Location: verifyMonth.php");
            }
        }
    } else {
        if ($consommation < 50) {
            $HT = $consommation * 0.91;

            $TTC = $HT + $HT * 0.14;

            $sql = "UPDATE facture SET prix_HT='$HT', prix_TTC='$TTC' WHERE mois='$mois' AND client_id='$id';";

            $result = mysqli_query($mysqli, $sql);

            if ($result) {


                $_SESSION['add'] = true;
                header("Location: verifyMonth.php");
            }
        } else if ($consommation > 400) {
            $HT = $consommation * 1.12;
            $TTC = $HT + $HT * 0.14;
            $sql = "UPDATE facture SET prix_HT='$HT', prix_TTC='$TTC' WHERE mois='$mois' AND client_id='$id';";

            $result = mysqli_query($mysqli, $sql);
            if ($result) {
                $_SESSION['add'] = true;
                header("Location: verifyMonth.php");
            }
        }
    }
}

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    print_r($id);

    $nom = $_POST['nom'];
    print_r($nom);
    $prenom = $_POST['prenom'];
    print_r($prenom);

    $email = $_POST['email'];
    print_r($email);

    $password = $_POST['password'];
    print_r($password);
    $sql = "UPDATE client SET nom=?, prenom=?, password=?, email=? WHERE ID=?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nom, $prenom, $password, $email, $id);
    mysqli_stmt_execute($stmt);
    print_r($sql);
    $_SESSION['success'] = true;
    header("location: dashboard_fournisseur.php");
    exit;
}
if (isset($_POST['submitAdd'])) {


    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $email = $_POST['email'];
    $password = $_POST['password'];
    $agent_id = $_POST['agent_id'];
    $sql = "SELECT * FROM client WHERE email='$email'";
    $result = mysqli_query($mysqli, $sql);
    if (!$result->num_rows > 0) {

        $sql = "INSERT INTO client (nom, prenom,password, email,agent_id)
                VALUES ('$nom', '$prenom', '$password', '$email', '$agent_id')";
        $result = mysqli_query($mysqli, $sql);

        if ($result) {
            $_SESSION['addClient'] = true;
            header("Location: dashboard_fournisseur.php");
        } else {
            //echo "<script>setTimeout(function() {alert('Veuillez ressayer ulterieurement'); }, 3000);</script>";
            $_SESSION['notAdd'] = true;
            header("Location: dashboard_fournisseur.php");
        }
    } else {
        //echo "<script>setTimeout(function() { alert('Un autre client a cet email , essayer avec un autre email.');}, 3000);</script>";
        $_SESSION['addClientAlready'] = true;
        header("Location: dashboard_fournisseur.php");
    }
}

if (isset($_POST['send'])) {
    $id = $_POST['rec_id'];
    $reponse = $_POST['response'];
    $sql = "update reclamation set contenue_reponse = '$reponse' where id = '$id';";
    $result = mysqli_query($mysqli, $sql);

    if ($result) {
        $_SESSION['send'] = true;
        header("Location: showReclamation.php");
    }
}
