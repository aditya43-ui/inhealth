<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * RSPMC-2174
 */

Yii::import('rawatInap.controllers.PemeriksaanAsesmenPasienController');
Yii::import('rawatInap.models.*');
class PemeriksaanAsesmenPasienRJController extends PemeriksaanAsesmenPasienController
{
  public $init = 'RJ';
  public $init_resiko = 'RJ';
}
