<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title><?= CONF_SITE_NAME ?></title>
    <link rel="stylesheet" type="text/css" href="<?= assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/font-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/style.css') ?>">
</head>

<body>
    <div class="main-wrapper error-wrapper">
        <div class="error-box">
            <h1><?= $error->code; ?></h1>
            <h3><i class="fa fa-warning"></i><?= $error->title; ?></h3>
            <p><?= $error->message; ?></p>
            <?php if (!empty($error->link)) : ?>
                <a href="<?= $error->link; ?>" title="<?= $error->linkTitle; ?>" class="btn btn-primary go-home"><?= $error->linkTitle; ?></a>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>