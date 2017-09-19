<?php

namespace alfmarks;

class Source {
    public $files = [];

    public function __construct() {
		
		$profile = $_SERVER['PROFILE'];
		$home_path = $_SERVER['HOME'];
		$current_folder = $_SERVER['CURRENT_FOLDER'];
		$editor = $_SERVER['EDITOR'];

        $files = explode(';', $profile);
        $len = count($files);
        for($i=0; $i<$len; $i+=2) {
            array_push($this->files, [
                "type" => $files[$i],
                "filename" => str_replace('~/', $home_path . '/', $files[$i+1])
            ]);
        }
    }
}