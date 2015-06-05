<!DOCTYPE html>
<html lang="br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

        <title>MasterSis</title>

        <link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo base_url('assets/css/bootstrap-theme.min.css'); ?>" rel="stylesheet" media="screen">


    </head>

    <body>
        <div class="container">

            <h4>
                <?php
                if (isset($mensagem) and $mensagem != NULL) {
                    echo $mensagem;
                };
                ?>
            </h4>


            <form action="<?php echo base_url('home'); ?>/dologin" method="post" accept-charset="utf-8" class="form-signin form-group bg-success">
                <h2 class="form-signin-heading">MasterSis<i class="glyphicon glyphicon glyphicon-leaf"></i></h2>
                <input type="text" name="usuario" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                <label class="checkbox">
                    <input type="checkbox" value="lembra" class="checkbox "> Lembre de me
                </label>
                <button class="btn btn-lg btn-block btn-default" type="submit">Entra</button>
            </form>

        </div> <!-- /container -->

    </body>
</html>
