<?php $v->layout("theme/_theme"); ?>
<div class="container my-5 py-5 ">
    <div class="page my-5 py-5">
        <h1>Ooops, erro <?= $error; ?></h1>
        <p>Desculpe por isso, caso o problema persista, por favor entre em contato conosco.</p>
        <p><a class="btn btn-primary" href="<?= $router->route("app.home"); ?>" title="<?= site("name"); ?>">VOLTAR!</a>
        </p>
    </div>
</div>