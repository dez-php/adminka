<?php
/**
 * @var array $data
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
    <title>DezWebAdmin \ Error</title>
</head>
<body>
    <h2>Error Page <b><?= $response->getStatusCode() ?></b></h2>
    <div>
        <h3><code><?= $data['location'] ?></code></h3>
        <code><?= nl2br($data['response']['message']) ?></code>
    </div>
</body>
</html>