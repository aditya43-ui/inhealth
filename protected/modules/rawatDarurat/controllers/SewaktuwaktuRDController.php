<?php


Yii::import('rekamMedis.controllers.SewaktuwaktuController');
Yii::import('rekamMedis.models.*');

class SewaktuwaktuRDController extends SewaktuwaktuController {
    
    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/SewaktuwaktuRD/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuRD/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuRD/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/SewaktuwaktuRD/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/SewaktuwaktuRD/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/rawatDarurat/pengkajianJiwaRD/index";
    }
    
}
