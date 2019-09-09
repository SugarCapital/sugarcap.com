<?php

namespace SugarCap\TemplateFunctions;


class Version
{
    static $map = [];
    private static $path ='../public/mix-manifest.json';

    public function __construct()
    {
      if(file_exists(self::$path)) {
        self::$map = json_decode(file_get_contents(self::$path), true);
      }
    }

    public function __invoke($path) {
        if(isset(self::$map[$path])) {
          return self::$map[$path];
        }

        return $path;
    }
}
