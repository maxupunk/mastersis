$(document).ready(function(){
				// carrega o edita e excluir da tabela na direta
                $("table a").click(function(){
                        var href = $(this).attr('href');
                        $("#centro").load( href );
                        return false;
                });

                $("form").submit(function(){
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    dataType: "html",
                    data: $(this).serialize(),

                    // enviado com sucesso
                    success: function(response){
                    $("#centro").html(response);
                    },
                    // quando houver erro
                    error: function(){
                    $("#centro").append('<div class="alert-box alert">- Ocoreu um erro na requisição! tente novamente mais tarde</div>');
                    }
                });
                return false;
             });
             
});