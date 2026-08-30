<?php
Yii::import('laboratorium.controllers.PemakaianBahanController');
Yii::import('laboratorium.models.LBObatalkespasienT');
Yii::import('laboratorium.models.LBObatalkesM');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBahanHDController extends PemakaianBahanController
{
    public $path_view = "hemodialisa.views.pemakaianBahanHD.";
    public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
    public $path_view_bahan = "laboratorium.views.pemakaianBmhp.";
    
    // dicopy dari laboratorium.controller.pemakaianBmhp
    // public function actionIndex($pendaftaran_id=null)
    // {
    //     $format = new MyFormatter();
    //     $modKunjungan= new HDInfoKunjunganRDV;
    //     $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    //     $modObatAlkesPasien = new LBObatalkespasienT;
    //     $dataOas = array();

    //     if(!empty($pendaftaran_id)){
    //         $modKunjungan= HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
    //     }
        
    //     if(isset($_POST['LBObatalkespasienT'])){
    //         if(isset($_POST['pendaftaran_id'])){
    //             $modPendaftaran = HDPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
    //             $transaction = Yii::app()->db->beginTransaction();
    //             try {
    //                 if(count($_POST['LBObatalkespasienT']) > 0){
    //                     //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
    //                     $detailGroups = array();
    //                     foreach($_POST['LBObatalkespasienT'] AS $i => $postDetail){
    //                         $modDetails[$i] = new LBObatalkespasienT;
    //                         $modDetails[$i]->attributes = $postDetail;
    //                         $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
    //                         $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
    //                         $obatalkes_id = $postDetail['obatalkes_id'];
    //                         if(isset($detailGroups[$obatalkes_id])){
    //                             $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
    //                         }else{
    //                             $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
    //                             $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
    //                         }
    //                     }
    //                     //END GROUP
    //                 }

    //                 $obathabis = "";
    //                 //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
    //                 foreach($detailGroups AS $i => $detail){
    //                     $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
    //                     if(count($modStokOAs) > 0){
    //                         foreach($modStokOAs AS $i => $stok){
    //                             $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran,$stok, $_POST['LBObatalkespasienT']);
    //                             $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
    //                         }
    //                     }else{
    //                         $this->stokobatalkestersimpan &= false;
    //                         $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

    //                     }
    //                 }

    //                 if($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan){
    //                     $transaction->commit();
    //                     $this->redirect(array('index','pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'sukses'=>1));
    //                 }else{
    //                     $transaction->rollback();
    //                     Yii::app()->user->setFlash('error',"Data pemakaian BMHP gagal disimpan !");
    //                 }
    //             } catch (Exception $e) {
    //                 $transaction->rollback();
    //                 Yii::app()->user->setFlash('error',"Data pemakaian BMHP gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
    //             }
    //         }
            

    //     }
            
    //     $this->render($this->path_view.'index',array(
    //         'modKunjungan'=>$modKunjungan,
    //         'modObatAlkesPasien'=>$modObatAlkesPasien,
    //         'dataOas'=>$dataOas,
    //     ));
    // }
    
    
    /**
     * simpan HDObatalkesPasienT
     * @param type $modPendaftaran
     * @param type $post
     * @return \HDObatalkesPasienT
     */
    public function simpanObatAlkesPasien($modPendaftaran ,$stokOa, $postObatAlkesPasien){        
        $modObatAlkesPasien = new HDObatalkesPasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkesPasien->pasienmasukpenunjang_id = null;
        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
//        $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
//        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		//RND-12254
		$modObatAlkesPasien->hargasatuan_oa = 0;
		$modObatAlkesPasien->hargajual_oa = 0;
         foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
            }
        }

        if($modObatAlkesPasien->save()){
            $this->obatalkespasientersimpan &= true;
        }else{
            $this->obatalkespasientersimpan &= false;
        }
        return $modObatAlkesPasien;
    }
    
    /**
     * Mengurai data kunjungan berdasarkan:
     * - pendaftaran_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
            $model = $this->loadModPasienRawatJalan($_POST['pendaftaran_id']);
            if(isset($model)){
                $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                if(isset($loadHasilPemeriksaan)){
                    if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
                        $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
                    }
                }
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * @param type $pendaftaran_id
     * @return HDInfoKunjunganRDV
     */
    public function loadModPasienRawatJalan($pendaftaran_id){
            $criteria=new CDbCriteria;
            $criteria->addCondition("t.pendaftaran_id = ".$pendaftaran_id);
            $model = HDInfoKunjunganRDV::model()->find($criteria);
            return $model;
    }
    
    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatObatAlkesPasien(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $loadOaPasiens = HDObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id']));
            if(count($loadOaPasiens) > 0){
                foreach($loadOaPasiens AS $i => $modObatAlkesPasien){
                    $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
                    $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
                    $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
                    $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
                    $rows .= $this->renderPartial($this->path_view."_rowRiwayatObatAlkesPasien",array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
                }
            }
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    
    public function actionPrint($pendaftaran_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;    
        $modPendaftaran = HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));     
        $modObatAlkesPasien = HDObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

        $judul_print = 'Pemakaian Bahan '.$modPendaftaran->ruangan_nama;
        $this->render($this->path_view.'printPemakaianBahan', array(
                            'format'=>$format,
                            'judul_print'=>$judul_print,
                            'modPendaftaran'=>$modPendaftaran,
                            'modObatAlkesPasien'=>$modObatAlkesPasien,
        ));
    } 
    
}