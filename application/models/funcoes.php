<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcoes extends CI_Model {

    
        function createThumbnail($filename,$img_sourse) {

        $config['image_library'] = "gd";
        $config['source_image'] = $img_sourse.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = "auto";
        #$config['quality'] = "100%";
        $config['width'] = "120";
        $config['height'] = "120";

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            return $this->image_lib->display_errors();
        }
    }

    
}