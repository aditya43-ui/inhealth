<?php
/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1073
 */

Yii::import('rawatInap.controllers.AsesmenRencanaAwalKeperawatanController');
Yii::import('rawatInap.models.*');
class AsesmenRencanaAwalKeperawatanHDController extends AsesmenRencanaAwalKeperawatanController
{
        public $init = 'HD';
}