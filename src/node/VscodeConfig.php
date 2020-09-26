<?php

namespace alfmarks;

class VscodeConfig
{
    /**
     * @param string $filename
     * @return Node
     */
    public function buildViaFile($filename)
    {
        $objs = Config::getObjs($filename);

        return Config::normalizeData($objs, function ($objs) {
            if (!isset($objs['name'], $objs['rootPath'])) return;

            $objs['rootPath'] = str_replace('$home', getenv('HOME'), $objs['rootPath']);
            $objs['rootPath'] = str_replace('\\', '/', $objs['rootPath']);
            $objs['rootPath'] = str_replace(' ', '\ ', $objs['rootPath']);

            return new Node($objs['name'], $objs['rootPath'], strtolower($objs['name']));
        });
    }
}
