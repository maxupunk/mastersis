<?php

$this->load->view('header');
$this->load->view('menu');

#if ($tela!="") $this->load->view('telas/'.$tela);

$this->load->view('footer');

?>