<?php

namespace codeseasy\projecthandler;
require "ProjectHandler.php";
class Handler{
    static function init($doamin){
        return (new ProjectHandler)->init($doamin);
    }
}