<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs nav-justified">
            <li <?php echo 'id="SubMenu" url="' . base_url('produto') . '" url-busca="' . base_url('produto') . '">'?><a><?php echo $this->lang->line("menu_cad_produto") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('servico') . '" url-busca="' . base_url('servico') . '">'?><a><?php echo $this->lang->line("menu_cad_servico") ?></a></li>            
            <li <?php echo 'id="SubMenu" url="' . base_url('pessoa') . '" url-busca="' . base_url('pessoa') . '">'?><a><?php echo $this->lang->line("menu_cad_pessoa") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('usuario') . '" url-busca="' . base_url('usuario') . '">'?><a><?php echo $this->lang->line("menu_cad_usario") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('endereco') . '" url-busca="' . base_url('endereco') . '">'?><a><?php echo $this->lang->line("menu_cad_endereco") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('categoria') . '" url-busca="' . base_url('categoria') . '">'?><a><?php echo $this->lang->line("menu_cad_categoria") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('medida') . '" url-busca="' . base_url('medida') . '">'?><a><?php echo $this->lang->line("menu_cad_unid_medida") ?></a></li>
            <li <?php echo 'id="SubMenu" url="' . base_url('avaria') . '" url-busca="' . base_url('avaria') . '">'?><a><?php echo $this->lang->line("menu_cad_avaria") ?></a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12">
                <div id="cadastro" class="BordaCad"><!-- tabela de cadastro --></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">
            <div class="col-lg-12 BordaCad">
                        <input type="text" name="buscar" url="" id="busca" class="form-control" placeholder="Busca">
                        <div id="resultado"><!--resultado da busca --></div>
            </div>
        </div>
    </div>
</div>