<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * RSPMC-2174
 */

Yii::import('rawatInap.controllers.AsesmenNyeriController');
Yii::import('rawatInap.models.*');
class AsesmenNyeriRJController extends AsesmenNyeriController
{
  public $init = 'RJ';
}
