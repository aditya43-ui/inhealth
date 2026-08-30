<?php
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.RekonsiliasiObatController');
class RekonsiliasiObatFAController extends RekonsiliasiObatController
{
    public function getUrlRekonsiliasiObatAlergi()
    {
        return $this->module->id . '/RekonsiliasiObatAlergiFA/index';
    }
    public function getUrlRekonsiliasiObatAdmisi()
    {
        return $this->module->id . '/RekonsiliasiObatAdmisiFA/index';
    }
    public function getUrlRekonsiliasiObatTransfer()
    {
        return $this->module->id . '/RekonsiliasiObatTransferFA/index';
    }
    public function getUrlRekonsiliasiObatDischarge()
    {
        return $this->module->id . '/RekonsiliasiObatDischargeFA/index';
    }
}
