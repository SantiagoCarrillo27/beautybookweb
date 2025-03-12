<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/build/img/favicon.ico" type="image/x-icon">
    <title>BeautyBook | <?= $titulo ?? ''; ?> </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap">
    <!-- UI DE FECHAS Y HORAS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <!-- SWEETALERT -->

    <link href='https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js'></script>


    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>


    <?php echo $contenido; ?>


    <?php echo $script ?? ''; ?>

</body>

</html>