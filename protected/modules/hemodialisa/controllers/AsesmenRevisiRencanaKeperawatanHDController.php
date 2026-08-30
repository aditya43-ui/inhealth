<?php
/**
 * -digunakan untuk mengekstend menu dari rawat inap yaitu : pasesmen revisi rencana keperawatan
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * RSST-1700
 */

Yii::import('rawatInap.controllers.AsesmenRevisiRencanaKeperawatanController');
Yii::import('rawatInap.models.*');
class AsesmenRevisiRencanaKeperawatanHDController extends AsesmenRevisiRencanaKeperawatanController
{
        public $init = 'HD';
}