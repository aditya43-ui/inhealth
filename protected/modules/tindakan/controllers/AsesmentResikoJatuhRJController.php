<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * RSPMC-2174
 */

Yii::import('rawatJalan.controllers.AsesmentResikoJatuhController');
Yii::import('rawatJalan.models.*');
class AsesmentResikoJatuhRJController extends AsesmentResikoJatuhController
{
  public $init = 'RJ';
}
