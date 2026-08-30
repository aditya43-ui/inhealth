<?php

/**
 *       - controller ini untuk extends ke controller informasi penggajian pegawai
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.controllers.InformasiGajiPegawaiController');
class InformasiGajiPegawaiPPController extends InformasiGajiPegawaiController
{
  public $layout = '//layouts/iframe';
}
