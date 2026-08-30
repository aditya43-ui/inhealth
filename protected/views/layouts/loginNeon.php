<?php

/**
 * Digunakan sebagai layout atau kerangka template login
 * tema STIKes Panti Waluya Malang
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    html, body.page-body.login-page {
        display: block !important;
        width: 100vw !important;
        min-height: 100vh !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: url('<?php echo Yii::app()->baseUrl; ?>/images/bg_login_stikes.jpg?v=<?php echo time(); ?>') no-repeat center center fixed !important;
        background-size: cover !important;
        -webkit-background-size: cover !important;
        overflow-x: hidden !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    .login-page .login-container {
        display: flex !important;
        min-height: 100vh !important;
        width: 100% !important;
        align-items: center !important;
        justify-content: flex-end !important;
        padding: 30px 80px !important;
        box-sizing: border-box !important;
        background: transparent !important;
    }

    /* Card Box Form Login (Modern Glassmorphism Menyatu Tema Watercolor STIKes) */
    .login-card-box {
        width: 380px !important;
        min-width: 360px !important;
        max-width: 400px !important;
        padding: 28px 28px 20px !important;
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(14px) saturate(160%) !important;
        -webkit-backdrop-filter: blur(14px) saturate(160%) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.85) !important;
        border-radius: 20px !important;
        box-shadow: 0 20px 50px rgba(23, 62, 53, 0.24), 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        color: #1e3d34 !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        transition: all 0.3s ease;
    }

    .login-card-box:hover {
        box-shadow: 0 25px 55px rgba(23, 62, 53, 0.3), 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    }

    .login-brand-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .login-brand-header img {
        max-height: 80px;
        max-width: 80px;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.12));
        transition: transform 0.3s ease;
    }

    .login-brand-header img:hover {
        transform: scale(1.05);
    }

    .login-brand-header .system-title {
        margin: 10px 0 2px;
        font-weight: 800;
        font-size: 15px;
        color: #1b4332;
        letter-spacing: 0.8px;
    }

    .login-brand-header .institution-subtitle {
        font-size: 11px;
        color: #406a5e;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .login-footer-copy {
        margin-top: 15px;
        text-align: center;
        font-size: 11px;
        color: #52796f;
        font-weight: 500;
        border-top: 1px solid rgba(82, 121, 111, 0.15);
        padding-top: 10px;
    }

    @media (max-width: 991px) {
        .login-page .login-container {
            justify-content: center !important;
            padding: 20px !important;
        }
        .login-card-box {
            width: 100% !important;
            max-width: 380px !important;
            min-width: unset !important;
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
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet"
        href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet"
        href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/fonts.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/css/custom-login-red.css">
</head>

<body class="page-body login-page">
    <script type="text/javascript">
    var baseurl = '<?php echo Yii::app()->baseUrl; ?>';
    </script>
    <div class="login-container">
        <div class="login-card-box">
            <?php
            $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
            ?>
            <div class="login-brand-header">
                <?php if (!empty($profil->logo_rumahsakit)): ?>
                    <img src="<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit; ?>?v=<?php echo time(); ?>" alt="Logo">
                <?php endif; ?>
                <div class="system-title">SIMRS E-HEALTHCARE</div>
                <div class="institution-subtitle"><?php echo $profil->nama_rumahsakit; ?></div>
            </div>

            <?php echo $content; ?>

            <div class="login-footer-copy">
                <strong><?php echo $profil->nama_rumahsakit; ?></strong> &copy; <?php echo date('Y'); ?>
            </div>
        </div>
    </div>

    <!-- Bottom Scripts -->
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/gsap/TweenMax.min.js"></script>
    <script
        src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js">
    </script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/bootstrap.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/joinable.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/resizeable.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-api.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-login.js"></script>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/bootstrap-switch.min.js', CClientScript::POS_END); ?>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-custom.js"></script>
    <script src="<?php echo Yii::app()->baseUrl . "/"; ?>themes/neon18/assets/js/neon-demo.js"></script>
</body>

</html>