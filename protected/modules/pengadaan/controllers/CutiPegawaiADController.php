<?php
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.controllers.CutiPegawaiController');
/**
 * controller ini digunakan untuk mengakses menu cuti pegawai, yang di ekstend dari modul kepegawaian
 * 
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class CutiPegawaiADController extends CutiPegawaiController{
    public $layout = '//layouts/iframe';
}

?>
