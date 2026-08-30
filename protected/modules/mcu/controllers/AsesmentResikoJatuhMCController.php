<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1073
 */

Yii::import('rawatJalan.controllers.AsesmentResikoJatuhController');
Yii::import('rawatJalan.models.*');
class AsesmentResikoJatuhMCController extends AsesmentResikoJatuhController
{
  public $init = 'MC';
}
