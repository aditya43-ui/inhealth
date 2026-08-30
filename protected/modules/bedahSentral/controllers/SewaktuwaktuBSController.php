<?php


Yii::import('rekamMedis.controllers.SewaktuwaktuController');
Yii::import('rekamMedis.models.*');

class SewaktuwaktuBSController extends SewaktuwaktuController {
    
    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/SewaktuwaktuBS/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuBS/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuBS/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/SewaktuwaktuBS/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/SewaktuwaktuBS/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/bedahSentral/pengkajianJiwaBS/index";
    }
    
}
