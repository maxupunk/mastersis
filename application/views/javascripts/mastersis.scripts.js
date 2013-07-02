$(document).ready(function(){
                $("a").click(function(){
                        var href = $(this).attr('href');
                        $("#centro").load( href );
                        return false;
                });

                //$("form").submit(function() {
                //    $("#centro").load($(this).attr('action')+'?'+$(this).serialize());
                //    return false;
                //});
      });