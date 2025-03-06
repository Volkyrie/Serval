<?php
class BaseClass {
    private $_currentX = 0;
    private $_currentY = 1;
    private $_currentAngle = 0;
    private $_dbh;

    public function __construct() {
        $this->_dbh = DataBase::getInstance();
    }

    public function __checkMove($x, $y, $angle) {
        $sql = "SELECT id FROM map WHERE coordx=:x AND coordy=:y AND direction=:angle";
        $query = $this->_dbh->prepare($sql);
        $query->bindParam(':y', $y, PDO::PARAM_INT);
        $query->bindParam(':x', $x, PDO::PARAM_INT);
        $query->bindParam(':angle', $angle, PDO::PARAM_INT);
        $query->execute();
        $newPos = $query->fetch(PDO::FETCH_OBJ);
        $result = isset($newPos->id) ? true : false;
        return $result;
    }

    private function __currentMapId() {
        $sql = "SELECT id FROM map WHERE coordx=:x AND coordy=:y AND direction=:angle";
        $query = $this->_dbh->prepare($sql);
        $query->bindParam(':y', $_currentY, PDO::PARAM_INT);
        $query->bindParam(':x', $_currentX, PDO::PARAM_INT);
        $query->bindParam(':angle', $_currentAngle, PDO::PARAM_INT);
        $query->execute();
        $newPos = $query->fetch(PDO::FETCH_OBJ);

        return $newPos->id;
    }

    public function getDbh() {
        return $this->_dbh;
    }

    public function getCurrentX() {
        return $this->_currentX;
    }

    public function getCurrentY() {
        return $this->_currentY;
    }

    public function getCurrentAngle() {
        return $this->_currentAngle;
    }

    public function setCurrentX($x) {
        $this->_currentX = $x;
    }

    public function setCurrentY($y) {
        $this->_currentY = $y;
    }

    public function setCurrentAngle($angle) {
        $this->_currentAngle = $angle;
    }

    public function checkForward() {
        if($_currentAngle  == 0) {
            $x = $_currentX + 1;
        } else if ($_currentAngle  == 90) {
            $y = $_currentY + 1;
        } else if ($_currentAngle  == 180) {
            $x = $_currentX - 1;
        } else {
            $y = $_currentY - 1;
        }

        $result = $this->__checkMove($x, $y, $_currentAngle);
        return $result;
    }

    public function checkBack() {
        if($_currentAngle  == 0) {
            $x = $_currentX - 1;
        } else if ($_currentAngle  == 90) {
            $y = $_currentY - 1;
        } else if ($_currentAngle  == 180) {
            $x = $_currentX + 1;
        } else {
            $y = $_currentY + 1;
        }

        $result = $this->__checkMove($x, $y, $_currentAngle);
        return $result;
    }

    public function checkRight() {
        if($_currentAngle  == 0) {
            $y = $_currentY - 1;
        } else if ($_currentAngle  == 90) {
            $x = $_currentX + 1;
        } else if ($_currentAngle  == 180) {
            $y = $_currentY + 1;
        } else {
            $x = $_currentX - 1;
        }

        $result = $this->__checkMove($x, $y, $_currentAngle);
        return $result;
    }

    public function checkLeft() {
        if($_currentAngle  == 0) {
            $y = $_currentX + 1;
        } else if ($_currentAngle  == 90) {
            $x = $_currentX - 1;
        } else if ($_currentAngle  == 180) {
            $y = $_currentY - 1;
        } else {
            $x = $_currentX + 1;
        }

        $result = $this->__checkMove($x, $y, $_currentAngle);
        return $result;
    }

    public function checkTurnLeft() {
        if($_currentAngle == 270) {
            $angle = 0;
        } else {
            $angle = $_currentAngle + 90;
        }

        $result = $this->__checkMove($_currentX, $_currentY, $angle);
        return $result;
    }

    public function checkTurnRight() {
        if($_currentAngle == 0) {
            $angle = 270;
        } else {
            $angle = $_currentAngle - 90;
        }

        $result = $this->__checkMove($_currentX, $_currentY, $angle);
        return $result;
    }

    public function goForward() {
        if($_currentAngle == 0) {
            $this->setCurrentX($_currentX + 1);
        } else if ($_currentAngle == 90) {
            $this->setCurrentY($_currentY + 1);
        } else if ($_currentAngle == 180) {
            $this->setCurrentX($_currentX - 1);
        } else {
            $this->setCurrentY($_currentY - 1);
        }
    }

    public function goBack() {
        if($_currentAngle == 0) {
            $this->setCurrentX($_currentX - 1);
        } else if ($_currentAngle == 90) {
            $this->setCurrentY($_currentY - 1);
        } else if ($_currentAngle == 180) {
            $this->setCurrentX($_currentX + 1);
        } else {
            $this->setCurrentY($_currentY + 1);
        }
    }

    public function goRight() {
        if($_currentAngle == 0) {
            $this->setCurrentY($_currentY - 1);
        } else if ($_currentAngle == 90) {
            $this->setCurrentX($_currentX + 1);
        } else if ($_currentAngle == 180) {
            $this->setCurrentY($_currentY + 1);
        } else {
            $this->setCurrentX($_currentX - 1);
        }
    }

    public function goLeft() {
        if($_currentAngle == 0) {
            $this->setCurrentY($_currentY + 1);
        } else if ($_currentAngle == 90) {
            $this->setCurrentX($_currentX - 1);
        } else if ($_currentAngle == 180) {
            $this->setCurrentY($_currentY - 1);
        } else {
            $this->setCurrentX($_currentX + 1);
        }
    }

    public function turnRight() {
        if($_currentAngle == 0) {
            $this->setCurrentAngle(270);
        } else {
            $this->setCurrentAngle($_currentAngle - 90);
        }
    }

    public function turnLeft() {
        if($_currentAngle == 270) {
            $this->setCurrentAngle(0);
        } else {
            $this->setCurrentAngle($_currentAngle + 90);
        }
    }
}
?>