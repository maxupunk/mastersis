<?php
if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                $query = $this->produto_model->pega_id("$id")->result();
                foreach($query as $row){
                    header('Content-Type: image/jpeg');
                    echo $row->PRO_IMG;
                }
}

?>
