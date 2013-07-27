<!DOCTYPE html>
<html>
    <head>
        <title>MasterSis</title>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo base_url('application/views/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">

        <!-- jquery -->
        <script src="<?php echo base_url('application/views/js/jquery-1.10.2.min.js'); ?>"></script>
        <script src="<?php echo base_url('application/views/js/jquery.mask.min.js'); ?>"></script>


        <style type="text/css">
            body
            {
                position: relative;
                margin:0;
                padding:0;
            }

            /* Wrapper for page content to push down footer */
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }
            
            #head {
                height: 100px;
                width: 100%;
                background-color: #f5f5f5;
            }

            .container .credit {
                margin: 20px 0;
            }
            
            .container p {
                margin: 20px 0;
            }
            
            .cep{
                width: 80px;
            }
            
            .valor{
                width: 80px;
            }
            
            .fone{
                width: 100px;
            }
            
            .data{
                width: 80px;
            }
            
            .cpf{
                width: 120px;
            }
            
            #mensagem {
                position: absolute;
                text-align: center;
                display: none;
                border: #B3B4BD double 2px;
                background: #f5f5f5;
                height: auto;
                width: 600px;
                top:180px;
                left:calc(50% - 600px/2);
                z-index:101;
            }
            
            #screen {
                position: absolute;
                top:0;
                bottom:0;
                left:0;
                right:0;
                background: #000;
                display: none;
                opacity: 0.7;
                width: 100%;
                height: 100%;
                z-index:99;
            }
            
            .bg_tabela_enderco{
                color: #006dcc;
                background: #f5f5f5;
            }

        </style>
    </head>
    <body>
        <div id="screen"></div>
        <span id="mensagem"></span>
        <div id="head">
            <div class="container">
                <div class="span5 left"><h1>MasterSis SGC</h1><h5>SISTEMA DE GERENCIAMENTO COMERCIAL</h5></div>
            </div>
        </div>