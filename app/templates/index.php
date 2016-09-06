<?php
/**
 * @var string $message
 * @var string $location
 * @var \Dez\Http\Response $response
 * @var \Adminka\Core\Module\ModuleInitializerInterface[] $modules
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adminka</title>
    <link href='https://fonts.googleapis.com/css?family=Exo+2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=cyrillic,latin-ext'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= $url->staticPath('css/site.min.css'); ?>">
</head>
<body>

<header class="header">
    <section class="header-logo">
        <a href="/">adminka</a>
    </section>
    <nav class="header-menu">
        <a class="text-color-orange" href="#">Header item 23</a>
        <a href="#">Header item 2</a>
        <a href="#">Header item 3</a>
        <a href="#">Header item 4</a>
        <a href="#">Header item 2</a>
        <a href="#">Header item 3</a>
        <a href="#" class="upper">Header item 4</a>
    </nav>
</header>

<main>

    <menu class="menu">
        <h2>Main</h2>
        <ul>
            <li>
                <a href="<?= $url->path('index/welcome'); ?>">Dashboard</a>
            </li>
            <li>
                <a href="<?= $url->path('users/index'); ?>">Users</a>
            </li>
            <li>
                <a href="<?= $url->path('access/roles'); ?>">Access</a>
            </li>
        </ul>

        <h2>Modules</h2>
        <ul>
            <li>
                <?php foreach($modules as $module): ?>
                <a href="<?= $module->url() ?>"><?= $module->name() ?></a>
                <?php endforeach; ?>
            </li>
        </ul>

    </menu>

    <article class="body">
        <?= $this->fetch('common/flash'); ?>
        <?= $content; ?>
    </article>

</main>

<footer class="footer-site">
    Adminka&nbsp;<?= date('Y'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a class="button size-small info" target="_blank" href="https://github.com/dez-php">Ivan Gonatrenko</a>
</footer>

</body>
</html>