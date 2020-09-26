<?php

namespace alfmarks;

require("node/Node.php");
require("node/VscodeConfig.php");
require("node/Config.php");
require("node/AtomConfig.php");
require("node/BuildNode.php");
require("node/NodeCollection.php");
require("node/Profile.php");

define("ROOT_PATH", dirname(__DIR__) . "/");
define("SRC_PATH", __DIR__ . "/");
define("MEDIA_PATH", ROOT_PATH . 'media/');

class Log
{
    public static function info($info)
    {
        $file = fopen($_SERVER['HOME'] . "/Downloads/debug.txt", "a+");
        fwrite($file, "\n" . print_r($info, true));
        fclose($file);
    }
}

try {
    $profile = $_SERVER['PROFILE'];
    $homePath = $_SERVER['HOME'];
    $editor = $_SERVER['EDITOR'];
    $term = $_SERVER['argv'][1];

    $profiles = getProfiles($profile, $homePath);
    $nodeColl = new NodeCollection($profiles);

    $result = $nodeColl->find($term)
        ->filter(strlen($term) & 0xFFFFFFFE / 2)
        ->sort()
        ->to_xml($editor);

    echo $result;
} catch (\Exception $e) {
    Log::info(print_r($e->getLine(), true));
}
