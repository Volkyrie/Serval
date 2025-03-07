<?php
    function chargerClasse($classe)
    {
        require $classe . '.class.php';
    }
    spl_autoload_register('chargerClasse');

    $player = new FirstPersonView();
    $text = new FirstPersonText();
    $player->coord();
    $text->coord();

    if(isset($_GET['action'])) {
        $action = $_GET['action'];
        $x = $_GET['x'];
        $y = $_GET['y'];
        $angle = $_GET['angle'];

        $player->setCurrentX($x);
        $player->setCurrentY($y);
        $player->setCurrentAngle($angle);
        $text->setCurrentX($x);
        $text->setCurrentY($y);
        $text->setCurrentAngle($angle);

        if($action == 'forward') {
            $player->goForward();
            $text->goForward();
        } else if ($action == 'back'){
            $player->goBack();
            $text->goBack();
        } else if ($action == 'right'){
            $player->goRight();
            $text->goRight();
        } else if ($action == 'left'){
            $player->goLeft();
            $text->goLeft();
        } else if ($action == 'turnRight'){
            $player->turnRight();
            $text->turnRight();
        } else if ($action == 'turnLeft'){
            $player->turnLeft();
            $text->turnLeft();
        } else {
            error_log('Erreur!', 0);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <script src="https://kit.fontawesome.com/4f3e1a72fd.js" crossorigin="anonymous"></script>
    <title>Projet Serval</title>
</head>
<body class="main-img">
    <img class="game" src="<?php echo $player->getView(); ?>" alt="">
    <div class="compass-container">
        <img class="compass" style="transform: rotate(<?php echo $player->getAnimCompass(); ?>);" src="./assets/compass.png" alt="compass">
    </div>
    <div class="overlay">
            <div class="controls">
                <div class="btns">
                    <button onCLick="location.href='index.php?action=turnLeft&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <button onCLick="location.href='index.php?action=forward&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-arrow-up"></i>
                    </button>
                    <button onCLick="location.href='index.php?action=turnRight&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button onCLick="location.href='index.php?action=left&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-hand-pointer"></i>
                    </button>
                    <button onCLick="location.href='index.php?action=right&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button onCLick="location.href='index.php?action=back&x=<?php echo $player->getCurrentX();?>&y=<?php echo $player->getCurrentY();?>&angle=<?php echo $player->getCurrentAngle();?>'">
                        <i class="fa-solid fa-arrow-down"></i>
                    </button>
                </div>
            </div>
            <div class="text">
                <?php echo $text->getText(); ?>
            </div>
        </div>
    </div>
</body>
</html>