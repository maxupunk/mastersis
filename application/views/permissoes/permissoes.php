<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <input type="text" name="USUARIO_NOME" id="usuario" autocomplete="off" placeholder="Nome do usuario" />
            <label><input type="checkbox" id="selec-all-permi" checked> Marca todos</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12" id="permissoes"></div>
</div>

<script>
    $(document).ready(function () {
        // Auto completa usuario
        var usuario = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: 'usuario/pegausuario?buscar=%QUERY',
                wildcard: '%QUERY'
            }
        });
        // inicialisa typeahead UI
        $('#usuario').typeahead(null, {
            display: 'value',
            source: usuario
        }).on('typeahead:selected typeahead:autocompleted', function (object, data) {
            $("#permissoes").load("permissoes/gerenciar/" + data.id);
        });

        $("#usuario").focus();
        // Selecione uma permisão
        $(document).on('change', '.metodo', function () {
            var dados = {
                USU_ID: $("#id_usuario").val(),
                METOD_ID: $(this).val()
            };
            if ($(this).is(':checked')) {
                $.post('permissoes/Adiciona', dados);
            } else {
                $.post('permissoes/Remove', dados);
            }
        });
        // marca e/ou desmarca todoas as permisoes
        $(document).on('click', '#selec-all-permi', function () {
            if ($("#selec-all-permi").is(':checked')) {
                $(".metodo").each(function () {
                    $(this).prop("checked", true);
                    dados = {
                        USU_ID: $("#id_usuario").val(),
                        METOD_ID: $(this).val()
                    };
                    $.post('permissoes/Adiciona', dados);
                });
            } else {
                dados = {USU_ID: $("#id_usuario").val()};
                $.post('permissoes/RemoveTodas', dados);
                $(".metodo").each(function () {
                    $(this).prop("checked", false);
                });
            }
        });
    });
</script>