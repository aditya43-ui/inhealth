<?php


Yii::import('rekamMedis.controllers.SewaktuwaktuController');
Yii::import('rekamMedis.models.*');

class SewaktuwaktuRIController extends SewaktuwaktuController {
    
    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/SewaktuwaktuRI/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuRI/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuRI/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/SewaktuwaktuRI/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/SewaktuwaktuRI/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/rawatInap/pengkajianJiwaRI/index";
    }
    
}
