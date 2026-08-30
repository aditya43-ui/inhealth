<?php
Yii::import('pemulasaranJenazah.controllers.PendaftaranPemulasaranJenazahController');
Yii::import('pemulasaranJenazah.models.*');
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
Yii::import('radiologi.models.ROPendaftaranT');
Yii::import('radiologi.models.ROPasienM');
Yii::import('radiologi.models.ROPegawaiM');
Yii::import('radiologi.models.ROPenanggungJawabM');
Yii::import('radiologi.models.ROPasienmasukpenunjangT');
Yii::import('radiologi.models.RORujukanT');
Yii::import('radiologi.models.ROTindakanpelayananT');
Yii::import('radiologi.models.ROTindakanKomponenT');
Yii::import('radiologi.models.ROTarifpemeriksaanradruanganV');
Yii::import('radiologi.models.ROPasienMasukPenunjangV');
Yii::import('radiologi.models.ROKarcisV');
Yii::import('radiologi.models.ROHasilpemeriksaanradT');
Yii::import('radiologi.models.ROAsuransipasienM');
Yii::import('radiologi.models.ROPasienblacklistT');
Yii::import('radiologi.models.ROPemeriksaanRadM');
Yii::import('pendaftaranPenjadwalan.models.PPAsuransipasienbadakM');

class PendaftaranPemulasaranJenazahPPController extends PendaftaranPemulasaranJenazahController
{
  public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranPemulasaanJenazahPP.';

  
}
