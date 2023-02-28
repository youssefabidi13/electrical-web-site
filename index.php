<?php session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Home - Electrical</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
  <link rel="stylesheet" href="assets/css/Button-Outlines---Pretty.css">
  <link rel="stylesheet" href="assets/css/Dynamic-Table.css">
  <link rel="stylesheet" href="assets/css/Fully-responsive-table.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
  <link rel="stylesheet" href="assets/css/Table-With-Search-search-table.css">
  <link rel="stylesheet" href="assets/css/Table-With-Search.css">
</head>

<body>
  <!-- Start: Navbar Centered Links -->
  <nav id="mainNav" class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php"><span>ELECTRICAL WEB SITE</span></a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
        <span class="visually-hidden">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navcol-1" class="collapse navbar-collapse" style="padding-left: 0px">
        <ul class="navbar-nav ms-auto">
          <li><a class="btn btn-warning ms-2 mt-2" role="button" href="login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End: Navbar Centered Links -->
  <header class="pt-5">
    <!-- Start: Hero Clean Reverse -->
    <div class="container pt-4 pt-xl-5">
      <div class="row pt-5">
        <div class="col-md-8 text-center text-md-start mx-auto">
          <div class="text-center">
            <h1 class="display-4 fw-bold mb-5">
              Nous fournissons la meilleure&nbsp; &nbsp;<span class="underline">énergie</span>&nbsp;<br /><strong>électrique .</strong>
            </h1>
            <p class="fs-5 text-muted mb-5"></p>
          </div>
        </div>
        <div class="col-12 col-lg-10 mx-auto">
          <div class="text-center position-relative"><img class="img-fluid" src="assets/img/illustrations/meeting.svg" style="width: 800px;" /></div>
        </div>
      </div>
    </div>
    <!-- End: Hero Clean Reverse -->
  </header>
  <!-- Start: Banner Heading Image -->
  <section class="py-4 py-xl-5">
    <!-- Start: 1 Row 2 Columns -->
    <div class="container">
      <div class="bg-primary border rounded border-0 border-primary overflow-hidden">
        <div class="row g-0">
          <div class="col-md-6 d-flex flex-column justify-content-center">
            <div class="text-white p-4 p-md-5">
              <h2 class="fw-bold text-white mb-3">Vous êtes : </h2>
              <p class="mb-4">
              Nous somme une société spécialisée dans la fourniture de services de paiement en ligne pour les factures d'électricité. Nous facilitons le paiement pour les clients en ligne, en utilisant une plate-forme de paiement sécurisée. Les agents peuvent inserer le fichier de consomation annuelles et le manager peut suivre ces clients
              </p>
              
            </div>
          </div>
          <div class="col-md-6 order-first order-md-last" style="min-height: 250px;"><img class="w-100 h-100 fit-contain pt-5 pt-md-0" src="assets/img/illustrations/web-development.svg"></div>
        </div>
      </div>
    </div>
    <!-- End: 1 Row 2 Columns -->
  </section>
  <!-- End: Banner Heading Image -->
  <section class="py-5">
    <!-- Start: Pricing Clean -->
    <div class="container py-4 py-xl-5">
      <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <h2 class="display-6 fw-bold mb-4">
            &nbsp;<span class="underline">Nos services</span>
          </h2>
        </div>
      </div>
      <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
        <div class="col">
          <div class="card border-0 h-100">
            <div class="card-body d-flex flex-column justify-content-between p-4">
              <div>
                <h4 class="display-5 fw-bold mb-4">0.91 MAD</h4>
                <ul class="list-unstyled">
                  <li class="d-flex mb-2">
                    <span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg></span><span>100 kwh</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-warning border-2 h-100">
            <div class="card-body d-flex flex-column justify-content-between p-4">
              <div>
                <h4 class="display-5 fw-bold mb-4">1.01 MAD</h4>
                <ul class="list-unstyled">
                  <li class="d-flex mb-2">
                    <span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg></span><span>&nbsp;Entre 101 et 200 kwh</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 h-100">
            <div class="card-body d-flex flex-column justify-content-between p-4">
              <div class="pb-4">
                <h4 class="display-5 fw-bold mb-4">1.12 MAD</h4>
                <ul class="list-unstyled">
                  <li class="d-flex mb-2">
                    <span class="bs-icon-xs bs-icon-rounded bs-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check fs-5 text-primary">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg></span><span>Plus que 201 kwh</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End: Pricing Clean -->
  </section>
  <!-- Start: Footer Multi Column -->
  <footer>
    <div class="container py-4 py-lg-5">
      <hr />
      <div class="text-muted d-flex justify-content-between align-items-center pt-3">
        <p class="mb-0">Copyright © 2023&nbsp;</p>
        <ul class="list-inline mb-0">
          <li class="list-inline-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
              <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
              </path>
            </svg>
          </li>
          <li class="list-inline-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
              <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
              </path>
            </svg>
          </li>
          <li class="list-inline-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
              <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
              </path>
            </svg>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/DataTable---Fully-BSS-Editable-style.js"></script>
  <script src="assets/js/Dynamic-Table-dynamic-table.js"></script>
  <script src="assets/js/startup-modern.js"></script>
  <script src="assets/js/Table-With-Search-search-table.js"></script>
</body>

</html>