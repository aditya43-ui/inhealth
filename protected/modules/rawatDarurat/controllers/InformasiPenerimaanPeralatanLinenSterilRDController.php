<?php
Yii::import('bedahSentral.controllers.InformasiPenerimaanPeralatanLinenSterilBSController');
Yii::import('bedahSentral.models.*');
class InformasiPenerimaanPeralatanLinenSterilRDController extends InformasiPenerimaanPeralatanLinenSterilBSController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1775);
        return InformasiPenerimaanPeralatanLinenSterilBSController::actionIndex($linkHalaman);
    }
}
