<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->Html->css("bootstrap.min.css"); ?>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- <?= $this->Html->css('base.css') ?> -->
    <!-- <?= $this->Html->css('style.css') ?> -->
    <?= $this->Html->css('login.css') ?>
    <?= $this->Html->css('sidebar.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <?= $this->Html->css('fileUpload.css') ?>

    <?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.js'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?php
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if(!strpos($url, '/classrooms/enter-exit-operation')) {
            echo $this->element('navbar');
        }
    ?>

    <?= $this->Flash->render() ?>
    <div class="container-fluid" style="height:90%; overflow: hidden">
        <div class='page'>
            <?php
                $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                // enter exit operation page would not render side bar
                if(!strpos($url, '/classrooms/enter-exit-operation')) {
                    if($login_user) {
                        if($login_user['identity'] == 'admin') {
                            echo $this->element('admin_sidebar');
                        } else if($login_user['identity'] == 'general') {
                            echo $this->element('general_sidebar');
                        }
                    }
                }

            ?>
            <div style='width:100%; height:100%; margin-top: 10px'>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
    <?php echo $this->Html->script('bootstrap.bundle.min.js') ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    </body>
</html>
