<?php
/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pemeriksaan asesmen pasien
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1700
 */

Yii::import('rawatInap.controllers.AsesmenKeperawatanController');
Yii::import('rawatInap.models.*');
class AsesmenKeperawatanHDController extends AsesmenKeperawatanController
{
    public $layout='//layouts/mainNeonSidebar';
    public $init = 'HD';
}