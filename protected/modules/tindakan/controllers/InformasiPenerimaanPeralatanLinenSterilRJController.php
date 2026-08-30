<?php
Yii::import('sterilisasi.controllers.InformasiPenerimaanPeralatanLinenSterilController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class InformasiPenerimaanPeralatanLinenSterilRJController extends InformasiPenerimaanPeralatanLinenSterilController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1777);
        return InformasiPenerimaanPeralatanLinenSterilController::actionIndex($linkHalaman);
    }
}
