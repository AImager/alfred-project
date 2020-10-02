<?php

namespace alfmarks;

class NodeCollection
{
    /**
     * 节点
     * @var []Node $node
     */
    public $nodes = [];

    public function sort()
    {
        usort($this->nodes, function ($a, $b) {
            return ($b->score < $a->score) ? -1 : 1;
        });
        return $this;
    }

    public function filter($minScore = 0)
    {
        foreach ($this->nodes as $k => $node) {
            if ($node->score < $minScore) {
                unset($this->nodes[$k]);
            }
        }
        return $this;
    }

    public function to_xml($editorType)
    {
        $document = new \SimpleXMLElement('<items />');
        foreach ($this->nodes as $node) {
            $item = $document->addChild('item');
            $node->initItem($item, $editorType);
        }
        return $document->asXML();
    }

    public function grade($term)
    {
        foreach ($this->nodes as $k => $node) {
            $score = max(strlen($node->scoreInfo), strlen($term)) - levenshtein($node->scoreInfo, $term);
            $node->score = $score;
        }
        return $this;
    }

    /**
     * __construct
     * @param []Profile $source
     */
    public function __construct($profiles)
    {
        if ($profiles == ".") {
            $this->nodes[] = new Node("Current Folder", $_SERVER['CURRENT_FOLDER'], ".");
        } else {
            foreach ($profiles as $profile) {
                $tmpNodes = BuildNode::buildViaFile($profile);
                foreach ($tmpNodes as $node) {
                    $this->nodes[] = $node;
                }
            }
        }
    }
}
