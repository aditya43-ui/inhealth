<?php

/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1073
 */

Yii::import('rawatInap.controllers.PemeriksaanAsesmenPasienController');
Yii::import('rawatInap.models.*');
class PemeriksaanAsesmenPasienMCController extends PemeriksaanAsesmenPasienController
{
  public $init = 'MC';
  public $init_resiko = 'MC';
  public $init_urlcontroller_informasi = 'InformasiDaftarPasienMC';
}
