<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?= assets('img/umum.png') ?>">
    <title><?= $title ?? CONF_SITE_NAME ?></title>
    <link rel="stylesheet" type="text/css" href="<?= assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/font-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/style.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/custom.css') ?>">
    <?= $v->section('styles') ?>
</head>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    
                    <?= $v->section('content') ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= assets('js/jquery-3.2.1.min.js') ?>"></script>
    <script src="<?= assets('js/custom.js') ?>"></script>
    <?= $v->section('scripts') ?>
</body>

</html>