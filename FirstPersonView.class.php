<?php
class FirstPersonView extends BaseClass {
    private $_img = "./images/";
    private $_mapId = 1;

    public function __construct() {
        parent::__construct();
    }

    public function getMapId() {
        return $this->_mapId;
    }

    public function setMapId($id) {
        $this->_mapId = $id;
    }

    private function __currentMapId() {
        $y = $this->getCurrentY();
        $x = $this->getCurrentX();
        $angle = $this->getCurrentAngle();

        $sql = "SELECT id FROM map WHERE coordx=:x AND coordy=:y AND direction=:angle";
        $query = $this->getDbh()->prepare($sql);
        $query->bindParam(':y', $y, PDO::PARAM_INT);
        $query->bindParam(':x', $x, PDO::PARAM_INT);
        $query->bindParam(':angle', $angle, PDO::PARAM_INT);
        $query->execute();
        $newPos = $query->fetch(PDO::FETCH_OBJ);
        $this->setMapId($newPos->id);
    }

    public function getView() {
        $this->__currentMapId();
        $dbh = $this->getDbh();
        $sql = "SELECT images.path FROM images
                JOIN map ON map.id=images.map_id
                WHERE map.id=:map AND images.status_action=0";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();
        $view = $query->fetch(PDO::FETCH_OBJ);
        $path = $view->path;
        return $this->_img . $path;
    }

    public function getAnimCompass() {
        $angle = $this->getCurrentAngle();
        return $angle . "deg";
    }
}
?>