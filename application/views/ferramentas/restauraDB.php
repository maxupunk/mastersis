<?php
echo $upload;
echo $mensagem;
?>

<form action="<?php echo base_url('ferramentas'); ?>/restare_db" method="post" name="formRestoure" accept-charset="utf-8" enctype="multipart/form-data">

    <label>O backup deve ser .SQL, o sistema não consegui restourar a base inteira!</label>
    <hr>
    <label class="file_input_button"><span>Click para seleciona arquivo!</span>
        <input type="file" name="userfile" />
    </label>
    <br><br>

    <input type="submit" value="upload" />
    <br><br>

</form>