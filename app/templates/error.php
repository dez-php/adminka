<?php
/**
 * @var string $message
 * @var string $location
 * @var \Dez\Http\Response $response
*/
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error Page <?= $this->response->getStatusCode() ?></title>
    <link rel="stylesheet" href="<?= $this->url->staticPath('css/error-page.css'); ?>">
</head>
<body class="container">
    <div class="center-block">
        <h1>Error Page <b><?= $this->response->getStatusCode(); ?></b></h1>

        <div>
            <pre><?= $message ?></pre>
            <h5><i>HIDDEN</i>/<?= basename($location) ?></h5>
        </div>
    </div>
</body>
</html>