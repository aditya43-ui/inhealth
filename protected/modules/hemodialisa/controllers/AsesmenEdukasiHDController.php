<?php
/**
*   - Extend Dari Asesment Edukasi Rawat Inap
*   @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*   @website	<.com>
 *  @issue      RSST-1700
*/

Yii::import('rawatInap.controllers.AsesmenEdukasiController');
Yii::import('rawatInap.models.*');

class AsesmenEdukasiHDController extends AsesmenEdukasiController {
    public $layout='//layouts/column1';
    public $init = 'HD';
}
