<?php

namespace alfmarks;

class NodeCollection {

    public $nodes = [];

    public $term;
	
	public $document;
	
	public function append($node) {
		array_push($this->nodes, [
			'obj' => $node,
			'score' => 0
		]);
	}

    public function multiple_append($nodes) {
        foreach($nodes as $val) {
            $this->append($val);
        }
    }

	public function sort() {
		usort($this->nodes, function($a, $b) {
			return ($b['score'] < $a['score']) ? -1 : 1;
		});
		return $this;
	}
	
	public function filter($min_score = 0) {
		foreach($this->nodes as $k => $val) {
			if($val['score'] < $min_score) {
				unset($this->nodes[$k]);
			} 
		}
		return $this;
	}

	public function to_xml() {	
		foreach ($this->nodes as $node) {
			$node['obj']->add_to($this->document);
		}
		return $this->document->asXML();
    }
    
    public function find($term) {
        $this->term = $term;
        // $query = new Query($term);
        foreach($this->nodes as $k => $node) {
            // $score = $query->score($node['obj']->data['score_info']);
			$score = max(strlen($node['obj']->data['score_info']), strlen($term))-levenshtein($node['obj']->data['score_info'], $term);
            $this->nodes[$k]["score"] = $score;
        }
		return $this;
    }

    public function __construct ($src) {
		$this->document = new \SimpleXMLElement('<items />');
		
        foreach($src->files as $val) {
            $this->multiple_append(BuildNode::build_via_file($val['type'], $val['filename']));
        }
		
		
		
		$editors = explode(';', $_SERVER['EDITOR']);
		foreach($editors as $val) {
			$this->append(BuildNode::build_via_data($val, [
				"title" => "Current Folder",
				"paths" => substr($_SERVER['CURRENT_FOLDER'], 1, -1),
				"score_info" => "."
			]));
		}
    }
}