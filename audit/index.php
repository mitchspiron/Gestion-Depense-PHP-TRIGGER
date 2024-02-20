<?php
// Vérifie si l'utilisateur est déjà connecté, si oui il reste sur le dashboard
if (!isset($_COOKIE['email'])) {
    header("Location: ../auth/index.php");
    exit;
}

// On inclut la connexion à la base
require_once('../configs/connection.php');

require_once('controller/gets.php');

require_once('../configs/close.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Gestion de dépense - Trigger</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet" />

    <!-- Custom styles for this page -->
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="sidebar-brand-text mx-3">G-Depense</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Gestions</div>

            <li class="nav-item">
                <a class="nav-link" href="../etablissement/index.php">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Etablissements</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../depense/index.php">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Dépenses</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Audits</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= htmlspecialchars($_COOKIE['nom']) ?> <?= htmlspecialchars($_COOKIE['prenom']) ?></span>
                                <img class="img-profile rounded-circle" src="../assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <button class="dropdown-item" onclick="deleteCookies()" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Se déconnecter
                                </button>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Gestion d'audit</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Les audits des dépenses
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">ID</th>
                                            <th>Etablissement</th>
                                            <th>N° Dépense</th>
                                            <th>Ancien Dépense</th>
                                            <th>Nouveau Dépense</th>
                                            <th>Type d'action</th>
                                            <th>Utilisateur</th>
                                            <th>Date et Heure</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($audits as $audit) {


                                        ?>
                                            <tr class="text-center">
                                                <td><?= htmlspecialchars($audit['id']) ?></td>
                                                <td><?= htmlspecialchars($audit['nom']) ?></td>
                                                <td><?= htmlspecialchars($audit['num_depense']) ?></td>
                                                <td><?= (htmlspecialchars($audit['ancien_dep']) == NULL) ? "Aucun" : $audit['ancien_dep']; ?></td>
                                                <td><?= (htmlspecialchars($audit['nouveau_dep']) == NULL) ? "Aucun" : $audit['nouveau_dep']; ?></td>
                                                <td><?php
                                                    switch ($audit['action']) {
                                                        case "INSERTION":
                                                            echo "<span class='badge badge-pill badge-primary'>INSERTION</span>
                                                            ";
                                                            break;
                                                        case "MODIFICATION":
                                                            echo "<span class='badge badge-pill badge-success'>MODIFICATION</span>
                                                            ";
                                                            break;
                                                        default:
                                                            echo "<span class='badge badge-pill badge-danger'>SUPPRESSION</span>
                                                        ";
                                                    }
                                                    ?></td>
                                                <td><?= htmlspecialchars($audit['personne']) ?></td>
                                                <td><?= htmlspecialchars($audit['date']) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; G-Depense 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/datatables-demo.js"></script>

    <!-- Deconnexion -->
    <script src="../auth/controller/logout.js"></script>
</body>

</html>