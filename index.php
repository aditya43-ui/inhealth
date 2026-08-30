<?php
ini_set('memory_limit', '-1');

/*
 * Mode aplikasi ditentukan oleh environment variable APP_ENV.
 *
 *   production  (default) : YII_DEBUG mati, error disembunyikan, pakai yiilite
 *   development           : YII_DEBUG hidup, stack trace tampil, pakai yii.php
 *
 * Default sengaja 'production': bila environment lupa diset, yang berlaku
 * adalah mode yang aman, bukan mode yang membocorkan informasi.
 *
 * Setel lewat berkas .env (lihat .env.example).
 */
$appEnv  = getenv('APP_ENV') ?: 'production';
$isDebug = ($appEnv !== 'production');

defined('YII_DEBUG')       or define('YII_DEBUG', $isDebug);
// Jumlah level call stack yang ditampilkan pada pesan log
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $isDebug ? 3 : 0);

if ($isDebug) {
    error_reporting(E_ALL | E_STRICT);
    $yii = dirname(__FILE__) . '/yii1_24/framework/yii.php';
} else {
    error_reporting(0);
    // yiilite.php menggabungkan kelas inti Yii dalam satu berkas (lebih cepat)
    $yii = dirname(__FILE__) . '/yii1_24/framework/yiilite.php';
}

$config = dirname(__FILE__) . '/protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();

if(isset($_GET['r']))
{
    $url = $_GET['r'];
    if(isset(Yii::app()->user->id)){
        $attributes = array(
            'statuslogin' => TRUE,
            'ruanganaktifitas' => Yii::app()->user->getState('ruangan_id'),
            'crudaktifitas' => $url,
            'waktuterakhiraktifitas' => date("Y-m-d H:i:s"),
        );
        $update = LoginpemakaiK::model()->updateByPk(Yii::app()->user->id, $attributes);
    }
}
