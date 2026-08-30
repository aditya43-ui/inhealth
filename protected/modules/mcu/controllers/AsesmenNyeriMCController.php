<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1073
 */

Yii::import('rawatInap.controllers.AsesmenNyeriController');
Yii::import('rawatInap.models.*');
class AsesmenNyeriMCController extends AsesmenNyeriController
{
  public $init = 'MC';
}
