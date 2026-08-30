<?php


Yii::import('rekamMedis.controllers.SewaktuwaktuController');
Yii::import('rekamMedis.models.*');

class SewaktuwaktuGZController extends SewaktuwaktuController {
    
    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/SewaktuwaktuGZ/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/gizi/pengkajianJiwaGZ/index";
    }
    
}
