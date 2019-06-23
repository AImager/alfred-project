<?php

namespace alfmarks;

class BuildNode
{
    static public function build_via_file($type, $filename)
    {
        // Log::info(print_r("asfsd", true));
        switch ($type) {
            case "atom":
                return AtomNode::build_via_file($filename);
            case "vscode":
                return VscodeNode::build_via_file($filename);
        }
    }

    static public function build_via_data($type, $data)
    {
        switch ($type) {
            case "atom":
                return new AtomNode($data);
            case "vscode":
                return new VscodeNode($data);
        }
    }
}
