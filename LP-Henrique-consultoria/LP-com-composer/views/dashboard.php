<?php $v->layout("theme/_theme"); ?>

<section>
    <div class="container my-5 pt-2">

        <div class="card">

            <div class="card-body my-5 py-5">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form class="form" action="<?= $router->route("auth.login"); ?>" method="post"
                            autocomplete="off">
                            <!-- <h5 class="font-weight-bold">Valor do Produto</h5> -->


                            <div class="login_form_callback">
                                <?= flash(); ?>
                            </div>
                            <div class="form-group">
                                <label for="valorProduto">Valor do produto</label>
                                <div class="input-group">

                                    <input id="valorProduto" type="text" placeholder="R$" class="form-control required"
                                        name="valorProduto[]">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button" onclick="produtoMore();"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="produtos_valor"></div>

                            <button type="submit" class="btn btn-primary  btn-block">Calcular</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




    </div>
</section>
<?php $v->start("scripts"); ?>
<script src="<?= asset("js/dff.js"); ?>"></script>
<?php $v->end(); ?>