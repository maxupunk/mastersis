<<<<<<< HEAD

  <div class="row">
    <div class="six columns">
      <h6>By Maxuel Aguiar. 2013</h6>
    </div>
  </div>

  
  <!-- Included JS Files (Compressed) -->
  <script src="<?php echo base_url('application/views/javascripts/jquery.js');?>"></script>
  <script src="<?php echo base_url('application/views/javascripts/foundation.min.js');?>"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="<?php echo base_url('application/views/javascripts/app.js');?>"></script>
  
  <script>
           $(".nav-bar a").click(function(){
                  var href = $(this).attr('href');
                  $("#centro").load( href );
                  return false;
           });
  </script>
  
=======
</div>
<div id="rodape"><br>Criado por Maxuel Aguiar®</div>
</div>
>>>>>>> parent of dd5c165... adicionado o faundation e ajax.
</body>
</html>