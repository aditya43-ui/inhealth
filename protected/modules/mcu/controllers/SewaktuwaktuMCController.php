<?php


Yii::import('rekamMedis.controllers.SewaktuwaktuController');
Yii::import('rekamMedis.models.*');

class SewaktuwaktuMCController extends SewaktuwaktuController {
    
    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/SewaktuwaktuMC/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuMC/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuMC/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/SewaktuwaktuMC/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/SewaktuwaktuMC/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/mcu/pengkajianJiwaMC/index";
    }
    
}
