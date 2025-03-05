<?php
class FirstPersonView extends BaseClass {
    private $_img = "./images/";
    private $_mapId = 1;

    public function getView() {
        return $_img+$x+$y . "-" . $angle . ".jpg";
    }

    public function getAnimCompass() {

    }
}
?>