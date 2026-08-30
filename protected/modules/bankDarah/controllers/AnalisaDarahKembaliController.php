<?php

/**
 * Form analisa darah kembali
 * untuk input analisa darah setelah melakukan retur kantong darah.
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author     Elham Budianto <elhambudianto@.com>
 * @package    application.modules.bankDarah
 * @subpackage controllers
 * @category   controller
 */
class AnalisaDarahKembaliController extends MyAuthController
{
    public $path_view = "application.modules.bankDarah.views.analisaDarahKembali.";
    
    /**
     * Autocomplete untuk menampilkan list petugas analisa seauai ruangan login
     * 
     * @param string $term Nama pegawai/petugas yang dicari. 
     */
	public function actionAutocompletePetugasAnalisa($term = "")
	{
        $model = new BDPegawairuanganV;
        $model->unsetAttributes();
        $model->pegawai_aktif = true;
        $model->nama_pegawai = $term;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        $res = array();
        
        foreach ($model->search()->data as $item) {
            $sub = array(
                'label'=>$item->nama_pegawai." - ".$item->nomorindukpegawai,
                'value'=>$item->pegawai_id,
                'nama_pegawai'=>$item->nama_pegawai,
            );
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
	}

    /**
     * Autocomplete untuk menampilkan list kantong darah yang diretur yang belum dianalisa
     * berdasarkan No. Kantong Darah-nya.
     * 
     * @param string $term No. Kantong Darah yang dicari. 
     */
	public function actionAutocompleteReturKantong($term = "")
	{
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $model = new BDReturdarahT();
        $model->unsetAttributes();
        $model->no_kantongdarah = $term;
        
        $prov = $model->searchReturKantongDarah();
        $res = array();
        
        foreach ($prov->data as $item) {
            $sub = $item->jsonReturDarah(false);
            $sub['label'] = $item->no_kantongdarah." - ".$item->no_retur_darah;
            $sub['value'] = $item->returdarah_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
	}

    /**
     * Form analisa darah kembali
     * @param type $returdarah_id
     * @param type $link
     */
	public function actionIndex($returdarah_id = null, $link = null)
	{
        $model = BDReturdarahT::model()->findByPk($returdarah_id);
        if(!empty($model)){
            $model->returdarah_id = $model->returdarah_id;
            $model->tgl_retur_darah = MyFormatter::formatDateTimeForUser($model->tgl_retur_darah);
            $kompat = UjikompatibilitasT::model()->findByPk($model->ujikompatibilitas_id);
            
            //data pasien
            $pasien = PasienM::model()->findByPk($kompat->pasien_id);
            $pendaftaran = PendaftaranT::model()->findByPk($kompat->pendaftaran_id);
            $ruangan = RuanganM::model()->findByPk($pendaftaran->ruangan_id);
            
            //data darah
            $stokkantongdarah = StokkantongdarahT::model()->findByPk($kompat->stokkantongdarah_id);
            $kantongdarah = KantongdarahT::model()->findByPk($stokkantongdarah->kantongdarah_id);
            $komponendarah = KomponendarahM::model()->findByPk($kantongdarah->komponendarah_id);
            $pendonor = PendonorM::model()->findByPk($kantongdarah->pendonor_id);
            
            //petugas penerima
            $pegawai = PegawaiM::model()->findByPk($model->petugas_penerima_id);
            
            if($model->is_ruangan == true){
                $model->asal_darah = 'Ruangan';
            }else if($model->is_bdt == true){
                $model->asal_darah = 'BDT';
            }else if($model->is_itd == true){
                $model->asal_darah = 'IDT';
            }
            $model->no_kantongdarah = $kompat->nomorbarcode;
            $model->nama_pasien = $pasien->nama_pasien;
            $model->no_rekam_medik = $pasien->no_rekam_medik;
            $model->ruangan_nama = $ruangan->ruangan_nama;
            $model->jenis_komponen_darah = $komponendarah->singkatan_komp;
            if(!empty($stokkantongdarah)){
                $model->golongan_darah = $stokkantongdarah->golongan_darah .' / '.$stokkantongdarah->rhesus;
            }else{
                $model->golongan_darah = '-';
            }
            $model->petugas_penerima_nama = $pegawai->nama_pegawai;
        }else{
            $model = new BDReturdarahT();
        }
        
        // default
        $model->is_kadaluarsa = 2;
        $model->is_sealer_habis = 2;
        $model->is_tabung_terbuka = 2;
        $model->is_bocor = 2;
        $model->is_gumpalan_plasma = 2;
        $model->is_hemolisis = 2;
        $model->is_endapan = 2;
        $model->is_plasma_pink = 2;
        $model->kesimpulan = "Layak";
        $model->tgl_analisa = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->petugas_analisa_id = Yii::app()->user->getState('pegawai_id');
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->petugas_analisa_nama = $pegawai->namaLengkap;
        if (isset($_POST['BDReturdarahT'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            $model = BDReturdarahT::model()->findByPk($_POST['BDReturdarahT']['returdarah_id']);
            
            try {
                if ($model->saveAnalisaRetur($_POST)) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    if(!empty($link)){
                        $this->redirect(array('/bankDarah/InformasiReturDarah/index','sukses'=>1));
                    }else{
                        $this->redirect(array('index'));
                    }
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
                }
            } catch (CException $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal Disimpan ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
		$this->render($this->path_view.'index', array(
            'model'=>$model,
            'link'=>$link,
                    
        ));
	}

}