<?php
class FirstPersonAction extends BaseClass {
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

    public function checkAction() {
        $this->__currentMapId();
        $dbh = $this->getDbh();
        $sql = "SELECT actions.id FROM actions 
                JOIN map ON map.id=actions.map_id
                WHERE actions.map_id=:map AND actions.status=0 AND map.status_action=0";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();
        $view = $query->fetch(PDO::FETCH_OBJ);
        if(isset($view->id)) {
            $disable = " ";
        } else {
            $disable = "disabled";
        }
        
        return $disable;
    }

    public function doAction() {
        $this->__currentMapId();
        $dbh = $this->getDbh();
        $sql = "SELECT text.text FROM text
                JOIN map ON map.id=text.map_id
                WHERE map.id=:map";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();
        $view = $query->fetch(PDO::FETCH_OBJ);
        if(isset($view->text)) {
            $disable = "disabled";
        } else {
            $disable = "";
        }
        
        return $disable;
    }
}
?>