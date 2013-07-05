<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcoes extends CI_Model {

    
        function createThumbnail($filename) {

        $config['image_library'] = "gd";
        $config['source_image'] = "uploads/" . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = "auto";
        $config['quality'] = "80%";
        $config['width'] = "320";
        $config['height'] = "240";

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            return $this->image_lib->display_errors();
        }
        unlink($config['source_image']);
    }

    
}