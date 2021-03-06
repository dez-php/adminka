<?php
/**
 * @var string $message
 * @var string $location
 * @var float $memory
 * @var \Dez\Http\Response $response
 * @var \Dez\Url\Url $url
*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error Page <?= $response->getStatusCode() ?> - Adminka</title>
    <link href='https://fonts.googleapis.com/css?family=Exo+2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=cyrillic,latin-ext'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= $url->staticPath('css/site.min.css'); ?>">
</head>
<body>

<main>

    <article class="body">

        <div class="container">
            <div class="caption">
                Error Page <b><?= $response->getStatusCode(); ?></b>
            </div>
            <div class="content">
                <div>
                    <h4>Error message</h4>
                    <pre><?= $message ?></pre>
                    <h4>Location</h4>
                    <pre>HIDDEN/<?= basename($location) ?></pre>
                    <h4>Memory: <b><?= $memory; ?></b></h4>
                </div>
            </div>
            <div class="footer">
                <div class="button-group">
                    <a class="button notice" href="<?= $this->url('index/index', [], ['_message' => $message]); ?>">Home Page</a>
                    <a class="button error" href="mailto: stewie.dev@gmail.com?subject=Adminka Error&body=<?= $this->fetch('common/error_report', [
                        'message' => $message,
                    ]); ?>;">Report Error</a>
                </div>
            </div>
        </div>

    </article>
</main>

<footer class="footer-site">
    Adminka&nbsp;<?= date('Y'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<button class="size-small info" onclick="window.location = 'mailto: stewie.dev@gmail.com;';">Ivan Gonatrenko</button>
</footer>

</body>
</html>