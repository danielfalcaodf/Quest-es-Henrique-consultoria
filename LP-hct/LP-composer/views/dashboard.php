<?php $v->layout("theme/_theme"); ?>

<section>
    <div class="container my-5 py-5 ">

        <div class="card">

            <div class="card-body my-5 py-5">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form class="form" action="<?= $router->route("caixa.caixaCalc"); ?>" method="post"
                            autocomplete="off">
                            <h5 class="font-weight-bold">Calcular o Troco: </h5>


                            <div class="form_callback">
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

        <div class="card my-5  d-none" id="tabelaTroco">

            <div class="card-body">
                <div class="mb-2" id="result"></div>
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Moeda/Cédula</th>
                            <th scope="col">Quantidade</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>




    </div>
</section>
<?php $v->start("scripts"); ?>
<script src="<?= asset("js/dff.js"); ?>"></script>
<script src="<?= asset("js/form.js"); ?>"></script>
<script src="<?= asset("js/scripts.js"); ?>"></script>
<?php $v->end(); ?>