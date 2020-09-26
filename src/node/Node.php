<?php

namespace alfmarks;

class Node
{
    /**
     * 标题
     * @var string
     */
    public $title;

    /**
     * 地址，空格分割
     * @var string
     */
    public $paths;

    /**
     * 用于评分的信息
     * @var string
     */
    public $scoreInfo;

    private $params = [
        "atom" => [
            "exec" => "/usr/local/bin/atom ",
            "png" => "atom.png",
        ],
        "vscode" => [
            "exec" => "open -a Visual\ Studio\ Code ",
            "png" => "vscode.png",
        ],
        "idea" => [
            "exec" => "open -a IntelliJ\ IDEA ",
            "png" => "idea.png",
        ],
    ];

    /**
     * 分数
     * @var int
     */
    public $score;

    public function __construct($title, $paths, $scoreInfo)
    {
        $this->title = $title;
        $this->paths = $paths;
        $this->scoreInfo = $scoreInfo;
    }

    public function initItem($item, $editorType) {
        $item->title = $this->title;
        $item->subtitle = $this->paths;
        $item->addAttribute('arg', $this->params[$editorType]['exec']  . $this->paths);
        $item->icon = MEDIA_PATH . $this->params[$editorType]['png'];
    }
}
