<?php

namespace alfmarks;

require("node/Node.php");
require("node/AtomNode.php");
require("node/VscodeNode.php");
require("node/BuildNode.php");
require("node/NodeCollection.php");
// require("node/Query.php");
require("node/Source.php");


define("ROOT_PATH", dirname(__dir__) . "/");
define("SRC_PATH", __dir__ . "/");
define("MEDIA_PATH", ROOT_PATH . 'media/');

// use SimpleXMLElement;

class Log {
	public static function info($info) {
		$file = fopen($_SERVER['HOME'] . "/Downloads/debug.txt", "w+");
		fwrite($file, "\n" . print_r($info, true));
		fclose($file);
	}
}

try {
	$src = new Source();
	$term = $_SERVER['argv'][1];
	$node_coll = new NodeCollection($src);
	
	// Log::info(print_r($node_coll->find($term), true));
	echo $node_coll->find($term)
					->filter(strlen($term)&0xFFFFFFFE/2)
					->sort()
					->to_xml();
}
catch (Exception $e) {
	Log::info(print_r($e->getLine(), true));
}

