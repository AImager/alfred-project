<?php

namespace alfmarks;

class Node {
    static public function normalizeData($objs, $callback) {
		$nodes = array();
		if ($item = $callback($objs)) {
			$nodes[] = $item;
		}
		foreach ($objs as $value) {
			if (is_array($value)) {
				$nodes = array_merge($nodes, Node::normalizeData($value, $callback));
			}
		}
		return $nodes;
    }
	
    static public function get_objs($filename){
        if(substr($filename, -5, 5) == '.cson') {
			exec("python " . SRC_PATH . "transfer/cson2json.py " . $filename);
			$filename = ROOT_PATH . "projects.json";
		}
		return json_decode(file_get_contents($filename), true);
    }
}