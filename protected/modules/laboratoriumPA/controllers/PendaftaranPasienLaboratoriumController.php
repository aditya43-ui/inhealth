<?php

Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranLaboratoriumAnatomiPPController');

class PendaftaranPasienLaboratoriumController extends PendaftaranLaboratoriumAnatomiPPController {

    public $pageTitle = 'Pendaftaran Pasien Laboratorium';
    public $path_view_pasien = 'pendaftaranPenjadwalan.views.pendaftaranLaboratoriumPP.';
    
    public $judulPendaftaranLab = "Pendaftaran <b>Pasien Laboratorium Patologi Anatomi</b>";

}
