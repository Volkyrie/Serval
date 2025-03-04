<?php
    function chargerClasse($classe)
    {
        require $classe . '.class.php';
    }
    spl_autoload_register('chargerClasse');
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
    <div class="compass-container">
        <img class="compass" src="./assets/compass.png" alt="compass">
    </div>
    <div class="overlay">
            <div class="controls">
                <div class="btns">
                    <button>
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-arrow-up"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-hand-pointer"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button>
                        <i class="fa-solid fa-arrow-down"></i>
                    </button>
                </div>
            </div>
            <div class="text">
                Text
            </div>
        </div>
    </div>
</body>
</html>