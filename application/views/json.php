<?php

//header('Content-Type: application/json');
//echo json_encode($query, JSON_UNESCAPED_UNICODE);
$this->output->set_content_type('application/json')->set_output(json_encode($query, JSON_UNESCAPED_UNICODE));
