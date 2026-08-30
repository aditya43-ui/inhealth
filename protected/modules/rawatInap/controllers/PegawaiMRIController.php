<?php

/**
 *       - controller ini untuk extends ke controller pegawai
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.PegawaiMController');
class PegawaiMRIController extends PegawaiMController
{
  public $init = 'RI';
}
