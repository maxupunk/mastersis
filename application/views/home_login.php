<?php
$this->load->view('includes/header');
?>
<h4><?php if (isset($mensagem) and $mensagem != NULL) {
    echo $mensagem;
}; ?></h4>

<div class="container">
    <form action="<?php echo base_url('home'); ?>/dologin" method="post" accept-charset="utf-8" class="form-signin">
        <h2 class="form-signin-heading"> Acesso Restrito</h2>
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" autofocus>
        <input type="password" name="senha" class="form-control" placeholder="Senha">
        <label class="checkbox">
            <input type="checkbox" value="remember-me">Me lembrar
        </label>
        <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
</div> <!-- /container -->