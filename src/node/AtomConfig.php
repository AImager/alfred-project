<?php

namespace alfmarks;

class AtomConfig extends Config
{
    /**
     * @param string $filename
     * @return Node
     */
    public function buildViaFile($filename)
    {
        $objs = Config::getObjs($filename);

        return Config::normalizeData($objs, function ($objs) {
            if (!isset($objs['title'], $objs['paths'])) return;

            return new Node($objs['title'], join(" ", $objs['paths']), strtolower($objs['title']));
        });
    }
}