<?php
class BaseClass {
    private $_currentX;
    private $_currentY;
    private $_currentAngle;
    private $_dbh;

    public function __construct() {
        $this->_dbh = DataBase::getInstance();
    }

    private function __checkMove($x, $y, $angle) {
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

    public function checkForward($x, $y, $angle) {
        if($angle == 0) {
            $x += 1;
        } else if ($angle == 90) {
            $y += 1;
        } else if ($angle == 180) {
            $x -= 1;
        } else {
            $y -= 1;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function checkBack($x, $y, $angle) {
        if($angle == 0) {
            $x -= 1;
        } else if ($angle == 90) {
            $y -= 1;
        } else if ($angle == 180) {
            $x += 1;
        } else {
            $y += 1;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function checkRight($x, $y, $angle) {
        if($angle == 0) {
            $y -= 1;
        } else if ($angle == 90) {
            $x += 1;
        } else if ($angle == 180) {
            $y += 1;
        } else {
            $x -= 1;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function checkLeft($x, $y, $angle) {
        if($angle == 0) {
            $y += 1;
        } else if ($angle == 90) {
            $x -= 1;
        } else if ($angle == 180) {
            $y -= 1;
        } else {
            $x += 1;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function checkTurnLeft($x, $y, $angle) {
        if($angle == 270) {
            $angle = 0;
        } else {
            $angle += 90;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function checkTurnRight($x, $y, $angle) {
        if($angle == 0) {
            $angle = 270;
        } else {
            $angle -= 90;
        }

        $result = $this->__checkMove($x, $y, $angle);
        return $result;
    }

    public function goForward($x, $y, $angle) {
        if($angle == 0) {
            $this->setCurrentX($x+1);
        } else if ($angle == 90) {
            $this->setCurrentY($y+1);
        } else if ($angle == 180) {
            $this->setCurrentX($x-1);
        } else {
            $this->setCurrentY($y-1);
        }
    }

    public function goBack($x, $y, $angle) {
        if($angle == 0) {
            $this->setCurrentX($x-1);
        } else if ($angle == 90) {
            $this->setCurrentY($y-1);
        } else if ($angle == 180) {
            $this->setCurrentX($x+1);
        } else {
            $this->setCurrentY($y+1);
        }
    }

    public function goRight($x, $y, $angle) {
        if($angle == 0) {
            $this->setCurrentY($y-1);
        } else if ($angle == 90) {
            $this->setCurrentX($x+1);
        } else if ($angle == 180) {
            $this->setCurrentY($y+1);
        } else {
            $this->setCurrentX($x-1);
        }
    }

    public function goLeft($x, $y, $angle) {
        if($angle == 0) {
            $this->setCurrentY($y+1);
        } else if ($angle == 90) {
            $this->setCurrentX($x-1);
        } else if ($angle == 180) {
            $this->setCurrentY($y-1);
        } else {
            $this->setCurrentX($x+1);
        }
    }

    public function turnRight($x, $y, $angle) {
        if($angle == 0) {
            $this->setCurrentAngle(270);
        } else {
            $this->setCurrentAngle($angle-90);
        }
    }

    public function turnLeft($x, $y, $angle) {
        if($angle == 270) {
            $this->setCurrentAngle(0);
        } else {
            $this->setCurrentAngle($angle+90);
        }
    }
}
?>