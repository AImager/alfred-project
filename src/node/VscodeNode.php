<?php

namespace alfmarks;

class VscodeNode extends Node {
	const VSCODE_EXEC = "open -a Visual\ Studio\ Code ";
	
    public $data;

    public function __construct($data) {
        $this->data = $data;
    }
	
    public function add_to($documents) {
        $item = $documents->addChild('item');
        
        $item->addAttribute('arg', self::VSCODE_EXEC . $this->data['paths']);
		$item->title = $this->data['title'];
		$item->subtitle = $this->data['paths'];
		$item->icon = MEDIA_PATH . "vscode.png";
    }

    static public function build_via_file ($filename) {
        $objs = Node::get_objs($filename);
		
        return Node::normalizeData($objs, function($objs) {
            if (!isset($objs['name'], $objs['rootPath'])) return;
            
            return new VscodeNode([
                "title" => $objs['name'],
                "paths" => $objs['rootPath'],
				"score_info" => strtolower($objs['name'])
            ]);
        });
    }
}