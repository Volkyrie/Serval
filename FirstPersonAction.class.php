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
        $sql = "SELECT actions.requis FROM actions 
                JOIN map ON map.id=actions.map_id
                WHERE actions.map_id=:map AND actions.status=0 AND map.status_action=0";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();
        $obj = $query->fetch(PDO::FETCH_OBJ);
        if(isset($obj->requis)) {
            $require = $obj->requis;
        } else {
            $require = 0;
        }

        if($require == 1 && $_SESSION['items'] == 0) {
            $disable = "disabled";
        } else {
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
        }
        
        return $disable;
    }

    public function doAction() {
        $this->__currentMapId();
        $dbh = $this->getDbh();

        $sql = "UPDATE actions SET status=1
                WHERE map_id=:map";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();

        $sql = "UPDATE map SET status_action=1
                WHERE id=:map";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();

        $sql = "UPDATE images SET status_action=1
                WHERE map_id=:map
                ORDER BY id ASC LIMIT 1";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();

        $sql = "UPDATE text SET status_action=1
                WHERE map_id=:map
                ORDER BY id ASC LIMIT 1";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();

        $sql = "SELECT items.description FROM items 
                JOIN actions ON actions.item_id=items.id
                WHERE actions.map_id=:map";
        $query = $dbh->prepare($sql);
        $query->bindParam(':map', $this->_mapId, PDO::PARAM_INT);
        $query->execute();
        $obj = $query->fetch(PDO::FETCH_OBJ);
        if(isset($_SESSION['items']) && ($_SESSION['items'] == 0)) {
            $_SESSION['items'] = $obj->description;
        } else {
            $_SESSION['items'] = 0;
        }
    }
}
?>