<?php

$this->load->view('header');
$this->load->view('menu');

if ($tela!="") $this->load->view($tela);

$this->load->view('footer');

?>