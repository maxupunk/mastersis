<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a href="ferramentas/BackupDB">Backup dos dados</a></li>
            <li role="presentation"><a href="ferramentas/BackupSistema">Backup do sistema</a></li>
            <li role="presentation"><a href="ferramentas/OtimizarDB" id="Inconsole">Otimizar DB</a></li>
            <li role="presentation"><a href="ferramentas/RepararTabela" id="Inconsole">Reparar DB</a></li>
            <li role="presentation"><a href="ferramentas/RestareDB" id="Inconsole">Restoura DB</a></li>
            <li role="presentation"><a href="ferramentas/LogSistema" id="Inconsole">logs do sistema</a></li>
            <li role="presentation"><a href="#">Update Sistema</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 console"></div>
</div>
<script>
    $(document).ready(function () {
        $(document).on("click", "#Inconsole", function () {
            $.get($(this).attr('href'), function (retorno) {
                $(".console").html(retorno);
            });
            return false;
        });

        // Submit o restoure
        $(document).on("submit", 'form[name="formRestoure"]', function () {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $(".console").html(response);
                }
            });
            return false;
        });

    });
</script>