<?php

namespace alfmarks;

class AtomNode extends Node
{
    const ATOM_EXEC = "/usr/local/bin/atom ";

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function add_to($documents)
    {
        $item = $documents->addChild('item');

        $item->addAttribute('arg', self::ATOM_EXEC . $this->data['paths']);
        $item->title = $this->data['title'];
        $item->subtitle = $this->data['paths'];
        $item->icon = MEDIA_PATH . "atom.png";
    }

    static public function build_via_file($filename)
    {
        $objs = Node::get_objs($filename);

        return Node::normalizeData($objs, function ($objs) {
            if (!isset($objs['title'], $objs['paths'])) return;

            return new AtomNode([
                "title" => $objs['title'],
                "paths" => join(" ", $objs['paths']),
                "score_info" => strtolower($objs['title'])
            ]);
        });
    }
}
