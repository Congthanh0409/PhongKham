<?php
// Include SessionHelper for authentication
require_once __DIR__ . '/../../helpers/SessionHelper.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Phòng khám Tai Mũi Họng'; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <?php require_once __DIR__ . '/../partials/header.php'; ?>

    <main>
        <?php echo $content; ?>
    </main>

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <?php include __DIR__ . '/../../assets/js/script.php'; ?>
</body>

</html> 