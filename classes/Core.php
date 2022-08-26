<?php

class Core
{

    public function run(){
        // start output buffering
        ob_start();

        // require index file from pages dir
        require_once(Url::getPage());

        // sent buffered string to browser
        ob_get_flush();
    }

}