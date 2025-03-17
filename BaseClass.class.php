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

    public function init() {
        $y = 1;
        $x = 0;
        $angle = 180;

        $sql = "SELECT id FROM map WHERE coordx=:x AND coordy=:y AND direction=:angle AND status_action=1";
        $query = $this->_dbh->prepare($sql);
        $query->bindParam(':y', $y, PDO::PARAM_INT);
        $query->bindParam(':x', $x, PDO::PARAM_INT);
        $query->bindParam(':angle', $angle, PDO::PARAM_INT);
        $query->execute();
        $reset = $query->fetch(PDO::FETCH_OBJ);
        if(isset($reset->id) && ($reset->id == 3)) {
            $_SESSION['items'] = 0;

            $sql = "UPDATE actions SET status=0";
            $query = $this->_dbh->prepare($sql);
            $query->execute();

            $sql = "UPDATE map SET status_action=0";
            $query = $this->_dbh->prepare($sql);
            $query->execute();

            $sql = "UPDATE text SET status_action=0";
            $query = $this->_dbh->prepare($sql);
            $query->execute();

            $sql = "UPDATE images SET status_action=0";
            $query = $this->_dbh->prepare($sql);
            $query->execute();
        }
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
        if($this->_currentAngle  == 0) {
            $x = $this->_currentX + 1;
            $y = $this->_currentY;
        } else if ($this->_currentAngle  == 90) {
            $y = $this->_currentY + 1;
            $x = $this->_currentX;
        } else if ($this->_currentAngle  == 180) {
            $x = $this->_currentX - 1;
            $y = $this->_currentY;
        } else {
            $y = $this->_currentY - 1;
            $x = $this->_currentX;
        }

        $result = $this->__checkMove($x, $y, $this->_currentAngle);
        return $result;
    }

    public function checkBack() {
        if($this->_currentAngle  == 0) {
            $x = $this->_currentX - 1;
            $y = $this->_currentY;
        } else if ($this->_currentAngle  == 90) {
            $y = $this->_currentY - 1;
            $x = $this->_currentX;
        } else if ($this->_currentAngle  == 180) {
            $x = $this->_currentX + 1;
            $y = $this->_currentY;
        } else {
            $y = $this->_currentY + 1;
            $x = $this->_currentX;
        }

        $result = $this->__checkMove($x, $y, $this->_currentAngle);
        return $result;
    }

    public function checkRight() {
        if($this->_currentAngle  == 0) {
            $y = $this->_currentY - 1;
            $x = $this->_currentX;
        } else if ($this->_currentAngle  == 90) {
            $x = $this->_currentX + 1;
            $y = $this->_currentY;
        } else if ($this->_currentAngle  == 180) {
            $y = $this->_currentY + 1;
            $x = $this->_currentX;
        } else {
            $x = $this->_currentX - 1;
            $y = $this->_currentY;
        }
        $coord = $x . $y;
        $result = $this->__checkMove($x, $y, $this->_currentAngle);
        return $result;
    }

    public function checkLeft() {
        if($this->_currentAngle  == 0) {
            $y = $this->_currentY + 1;
            $x = $this->_currentX;
        } else if ($this->_currentAngle  == 90) {
            $x = $this->_currentX - 1;
            $y = $this->_currentY;
        } else if ($this->_currentAngle  == 180) {
            $y = $this->_currentY - 1;
            $x = $this->_currentX;
        } else {
            $x = $this->_currentX + 1;
            $y = $this->_currentY;
        }

        $result = $this->__checkMove($x, $y, $this->_currentAngle);
        return $result;
    }

    public function checkTurnLeft() {
        if($this->_currentAngle == 270) {
            $angle = 0;
        } else {
            $angle = $this->_currentAngle + 90;
        }

        $result = $this->__checkMove($this->_currentX, $this->_currentY, $angle);
        return $result;
    }

    public function checkTurnRight() {
        if($this->_currentAngle == 0) {
            $angle = 270;
        } else {
            $angle = $this->_currentAngle - 90;
        }

        $result = $this->__checkMove($this->_currentX, $this->_currentY, $angle);
        return $result;
    }

    public function goForward() {
        $test = $this->checkForward();
        if($test == 1) {
            if($this->_currentAngle == 0) {
                $this->setCurrentX($this->_currentX + 1);
            } else if ($this->_currentAngle == 90) {
                $this->setCurrentY($this->_currentY + 1);
            } else if ($this->_currentAngle == 180) {
                $this->setCurrentX($this->_currentX - 1);
            } else {
                $this->setCurrentY($this->_currentY - 1);
            }
        } else {
            error_log('You cant move forward');
        }
    }

    public function goBack() {
        $test = $this->checkBack();
        if($test == 1) {
            if($this->_currentAngle == 0) {
                $this->setCurrentX($this->_currentX - 1);
            } else if ($this->_currentAngle == 90) {
                $this->setCurrentY($this->_currentY - 1);
            } else if ($this->_currentAngle == 180) {
                $this->setCurrentX($this->_currentX + 1);
            } else {
                $this->setCurrentY($this->_currentY + 1);
            }
        } else {
            error_log('You cant move backward');
        }   
    }

    public function goRight() {
        $test = $this->checkRight();
        if($test == 1) {
            if($this->_currentAngle == 0) {
                $this->setCurrentY($this->_currentY - 1);
            } else if ($this->_currentAngle == 90) {
                $this->setCurrentX($this->_currentX + 1);
            } else if ($this->_currentAngle == 180) {
                $this->setCurrentY($this->_currentY + 1);
            } else {
                $this->setCurrentX($this->_currentX - 1);
            }
        }   else {
            error_log('You cant move to the right');
        } 
    }

    public function goLeft() {
        $test = $this->checkLeft();
        if($test == 1) {
            if($this->_currentAngle == 0) {
                $this->setCurrentY($this->_currentY + 1);
            } else if ($this->_currentAngle == 90) {
                $this->setCurrentX($this->_currentX - 1);
            } else if ($this->_currentAngle == 180) {
                $this->setCurrentY($this->_currentY - 1);
            } else {
                $this->setCurrentX($this->_currentX + 1);
            }
        }   else {
            error_log('You cant move to the left');
        }
    }

    public function turnRight() {
        $test = $this->checkTurnRight();
        if($test == 1) {
            if($this->_currentAngle == 0) {
                $this->setCurrentAngle(270);
            } else {
                $this->setCurrentAngle($this->_currentAngle - 90);
            }
        }   else {
            error_log('You cant turn right');
        }
    }

    public function turnLeft() {
        $test = $this->checkTurnLeft();
        if($test == 1) {
            if($this->_currentAngle == 270) {
                $this->setCurrentAngle(0);
            } else {
                $this->setCurrentAngle($this->_currentAngle + 90);
            }
        }   else {
            error_log('You cant turn left');
        }
    }
}
?>