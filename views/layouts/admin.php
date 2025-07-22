<?php
// Include SessionHelper for authentication
require_once __DIR__ . '/../../helpers/SessionHelper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Quản trị'; ?></title>
    <link href="quantri/assets/css/bootstrap.css" rel="stylesheet">
    <link href="quantri/assets/css/style.css" rel="stylesheet">
    <link href="quantri/assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <section id="container">
        <?php require_once __DIR__ . '/../partials/admin_header.php'; ?>
        
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <?php require_once __DIR__ . '/../partials/admin_sidebar.php'; ?>
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <?php echo $content; ?>
            </section>
        </section>
        <!--main content end-->
    </section>

    <script src="quantri/assets/js/jquery.js"></script>
    <script src="quantri/assets/js/bootstrap.min.js"></script>
    <script src="quantri/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="quantri/assets/js/jquery.nicescroll.js"></script>
    <script src="quantri/assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="quantri/assets/js/jquery.scrollTo.min.js"></script>
    <script src="quantri/assets/js/common-scripts.js"></script>
</body>
</html> 