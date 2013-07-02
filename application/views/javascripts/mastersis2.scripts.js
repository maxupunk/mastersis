$(document).ready(function(){
				// carrega o edita e excluir da tabela na direta
                $("table a").click(function(){
                        var href = $(this).attr('href');
                        $("#esquerda").load( href );
                        return false;
                });

                //$("form").submit(function() {
                //    $("#centro").load($(this).attr('action')+'?'+$(this).serialize());
                //    return false;
                //});
                $("form").submit(function(){
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    dataType: "html",
                    data: $(this).serialize(),

                    // enviado com sucesso
                    success: function(response){
                    $("#esquerda").html(response);
                    },
                    // quando houver erro
                    error: function(){
                    $("#esquerda").append("<p>- Ocoreu um erro na requisição! tente novamente mais tarde</p>");
                    }
                });
                return false;
             });
      });