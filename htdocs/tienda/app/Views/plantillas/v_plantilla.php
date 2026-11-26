<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MKn5NWVBEuQXJE7TSKSgPUmMiSCmVTfCsR+VSSeQpHnoyJQZZFn/kBn+Ht5jZDPQ" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-+PW0IDVGGwmpaBQvcXY+W0BcpHpITFB3dSfSoGvDdHtLbrLpSbpGcvtQRM/BJpz+" crossorigin="anonymous"></script>
</head>
<body>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php echo site_url()."/categorias" ?>">Categorias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url()."/productos" ?>">Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url()."/clientes" ?>">Clientes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Tienda</a>
        </li>
    </ul>
    <?= $this->renderSection("principal") ?>

</body>
</html>