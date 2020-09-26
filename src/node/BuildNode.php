<?php

namespace alfmarks;

class BuildNode
{
    /**
     * 建立文件
     * @param Profile $profile
     * @return Node
     */
    static public function buildViaFile($profile)
    {
        switch ($profile->type) {
            case "vscode":
                $config = new VscodeConfig();
                return $config->buildViaFile($profile->filename);
        }
    }
}
