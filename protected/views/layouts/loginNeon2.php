<?php

/**
 * Digunakan sebagai layout atau kerangka template login
 * menggati logo login
 * @category     Params
 * @author       Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author       Yusuf Putra Anugrah <yusufputra@.com>
 * @website      <piindonesia.co.id>
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .login-content {
            margin: 30px auto !important;
            box-shadow: 0 0 25px 0px rgba(119, 118, 118, .35) !important;
        }

        @media only screen and (min-height: 800px) {
            body {
                display: flex !important;
                align-items: center;
                justify-content: center;
            }

            .login-content {
                margin: 0 auto !important;
            }
        }
    </style>

    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <?php
    $this->pageTitle = Yii::app()->name;
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="" />

    <title><?php echo CHtml::encode($this->pageTitle); ?> - Login</title>


    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/fonts.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/neon-theme.css">
    <!--      class theme:custom-login-violet,custom-login-red,custom-login-green,custom-login-blue,custom-login-yellow   -->
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/custom-login-red.css">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

</head>

<body class="page-body login-page login-form-fall" data-url="http://neon.dev">
    <script type="text/javascript">
        var baseurl = '<?php echo Yii::app()->baseUrl; ?>';
    </script>
    <?php
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    ?>

    <div class="login-container bg-trans">
        <div class="login-header">
            <!-- progress bar indicator -->
            <div class="login-progressbar-indicator">
                <h3></h3>
                <span>Silakan Tunggu Sebentar ...</span>
            </div>
        </div>

        <div class="login-progressbar">
            <div></div>
        </div>

        <div class="log-hide">
            <div class="login-content">
                <br>
                <!-- <?php echo CHtml::image(Yii::app()->baseUrl . '/images/ims-login.png', $profil->nama_rumahsakit, array('width' => '50%')) ?> -->

                <p>&nbsp;</p>
                <?php echo $content; ?>

                <div class="login-bottom-links">
                    <!--				<a href="#" class="link">Forgot your password?</a> <br />-->
                </div>
                <center><strong><?php echo $profil->nama_rumahsakit; ?> </strong>&copy; <?php echo date('Y') ?><br />
                    <a href="" target="blank"></a>, All Rights Reserved<br> <br>
                    <div class="row logoweb">

                        <div class="col-md-12 ">

                            <!-- <a href="http://bantuan..com" target="blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-innova.png" width="100px" alt="" style="padding:5px" /></a> -->
                        </div>
                    </div>
                </center>
            </div>
            <div class="login-content">
            </div>
        </div>

        <div class="col-md-1">
            &nbsp;
        </div>

    </div>
    <!--        <div class="login-footer" style="position:fixed;bottom:0;right:0">
                    <a href="http://bantuan..com" target="blank"><img src="<?php //echo Yii::app()->request->baseUrl; 
                                                                                        ?>/images/logo-innova.png" width="200px" alt="" style="padding:5px"/></a> 
                </div>-->
    </div>

    <!-- Bottom Scripts -->
    <!-- Bottom scripts (common) -->
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/gsap/TweenMax.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js">
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/bootstrap.js">
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/joinable.js">
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/resizeable.js">
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-api.js">
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-login.js">
    </script>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/bootstrap-switch.min.js', CClientScript::POS_END); ?>

    <!-- JavaScripts initializations and stuff -->
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-custom.js">
    </script>


    <!-- Demo Settings -->
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-demo.js">
    </script>

</body>

</html>