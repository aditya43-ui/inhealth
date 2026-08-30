<?php

/**
 *       - controller ini untuk extends ke controller cuti pegawai
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.controllers.CutiPegawaiController');
class CutiPegawaiGZController extends CutiPegawaiController
{
  public $layout = '//layouts/iframe';
}
