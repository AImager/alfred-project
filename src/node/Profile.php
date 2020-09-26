<?php

namespace alfmarks;

class Profile {
    public $type;
    public $filename;
    public function __construct($type, $filename) {
        $this->type = $type;
        $this->filename = $filename;
    }
}

/**
 * 获取所有的配置文件
 * @param string $profile
 * @param string $homePath
 * @return []Profile
 */
function getProfiles($profile, $homePath) {
    $files = explode(';', $profile);
    $len = count($files);
    $profiles = [];
    for ($i = 0; $i < $len; $i += 2) {
        array_push($profiles, new Profile(
            $files[$i],
            str_replace('~/', $homePath . '/', $files[$i + 1])
        ));
    }
    return $profiles;
}
