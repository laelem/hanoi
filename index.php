<?php 
require('config.php'); 
require('functions.php'); 
require('main.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <section id="main">
            <div class="contain">
                <div id="tower1" class="tower">
                    <div class="contain">
                        <div class="vertical-stake"></div>
                        <div class="horizontal-stake"></div>
                    </div>
                </div><!--
                --><div id="tower2" class="tower">
                    <div class="contain">
                        <div class="vertical-stake"></div>
                        <div class="horizontal-stake"></div>
                    </div>
                </div><!--
                --><div id="tower3" class="tower">
                    <div class="contain">
                        <div class="vertical-stake"></div>
                        <div class="horizontal-stake"></div>
                    </div>
                </div>
            </div>
        </section><!--

        --><section id="controls" data-move-index="0">
            <h1>Les tours de Hanoï</h1>
            <div>
                <div class="nb-disc">
                    <label>Nombre de disques : </label>
                    <input type="number" id="nbBlock" 
                        placeholder="Nombre entre 1 et <?php echo CONFIG_MAX_NB_BLOCK ?>" 
                        min="1" max="<?php echo CONFIG_MAX_NB_BLOCK ?>" 
                        value="<?php echo CONFIG_INIT_NB_BLOCK; ?>">
                </div>
                <button class="next">Next</button>
                <button class="reset">Reset</button>
            </div>
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="hanoi.js"></script>
    </body>
</html>