<?php

/**
 * Controler untuk form Mutasi Aset
 * @package application.modules.manajemenAset
 * @subpackage controllers
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 *          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *          Elham Budianto <elhambudianto1@gmail.com>
 * @issue   <RSST-1620>
 */
class MutasiAsetController extends MyAuthController
{
    public $path_view = 'manajemenAset.views.mutasiAset.';
    
        /**
         * load data aset
         */
	public function actionAjaxLoadAset()
	{
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        $barang = InvperalatanT::model()->findByPk($id);
        $master = BarangM::model()->findByPk($barang->barang_id);
         
        
		$str = $this->renderPartial('ajaxLoadAset', array(
            'barang'=>$barang, 'master'=>$master
        ), true);
        
        echo CJSON::encode(array(
            'html'=>$str,
        ));
	}

        /**
         * action utama untuk masuk ke transaksi mutasi aset
         * @param type $id
         */
	public function actionIndex($id = null)
	{
            $model = new MutasiasetT;
            
            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if (!empty($peg)){
                $model->pegmenyerahkan_nama = $peg->namaLengkap;
                $model->pegmenyerahkan_id = $peg->pegawai_id;
            }
            
            $detail = array(new MutasiasetperalatanT);

            if (Yii::app()->request->isAjaxRequest){
                if (isset($_GET['ajax'])){
                    $ajax = $_GET['ajax'];
                    
                    if ($ajax == 'daftarperalatan-grid')
                        $path = 'grid/_aset';
                    else if ($ajax == 'lokasi-grid')
                        $path = 'grid/_lokasi';
                    else if ($ajax == 'pegawaiserah-grid')
                        $path = 'grid/_peg_menyerahkan';
                    else if ($ajax == 'pegawaiterima-grid')
                        $path = 'grid/_peg_penerima';
                        
                    $this->renderPartial($path,['model'=>$model]);
                    exit;
                }                                
            }
            
            $model->tglmutasiaset = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
            $model->nomutasiaset = "-- Otomatis --";

            $model->instalasiasal_id = Yii::app()->user->getState('instalasi_id');
            $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

            if (!empty($id)) {
                $model = MutasiasetT::model()->findByPk($id);
                $model->tglmutasiaset = MyFormatter::formatDateTimeForUser($model->tglmutasiaset);

                $peg_serah = PegawaiM::model()->findByPk($model->pegmenyerahkan_id);
                $model->pegmenyerahkan_nama = $peg_serah->nama_pegawai;


                if (!empty($model->pegpenerima_id)) {
                    $peg_terima = PegawaiM::model()->findByPk($model->pegpenerima_id);
                    $model->pegpenerima_nama = $peg_terima->nama_pegawai;
                }

                $ruangan_asal = RuanganM::model()->findByPk($model->ruanganasal_id);
                $ruangan_tujuan = RuanganM::model()->findByPk($model->ruangantujuan_id);
                $model->ruanganasal_nama = !empty($ruangan_asal)?$ruangan_asal->ruangan_nama:null;
                $model->ruangantujuan_nama = !empty($ruangan_tujuan)?$ruangan_tujuan->ruangan_nama:null;
                
                $model->lokasiasal_nama = !empty($model->lokasiasal->lokasiaset_namalokasi)?$model->lokasiasal->lokasiaset_namalokasi:null;
                $model->lokasitujuan_nama = !empty($model->lokasitujuan->lokasiaset_namalokasi)?$model->lokasitujuan->lokasiaset_namalokasi:null;


                $detail = MutasiasetperalatanT::model()->findAllByAttributes(array(
                    'mutasiaset_id'=>$id,
                ));



            }


            if (isset($_POST['MutasiasetT']) && isset($_POST['MutasiasetperalatanT'])) {
                $trans = Yii::app()->db->beginTransaction();
                $ok = true;

                try {

                    $model->attributes = $_POST['MutasiasetT'];
                    $model->tglmutasiaset = MyFormatter::formatDateTimeForDb($model->tglmutasiaset);
                    $model->nomutasiaset = MyGenerator::noMutasiAset();

                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    if ($model->validate()) {

                        $ok = $ok && $model->save();

                        foreach ($_POST['MutasiasetperalatanT'] as $item) {
                            $detail = new MutasiasetperalatanT;
                            $detail->attributes = $item;
                            $detail->mutasi_keadaan = $item['mutasi_keadaan'];
                            $detail->mutasiaset_id = $model->mutasiaset_id;
                            $ok = $ok && $detail->save();
                            /*
                            InvperalatanT::model()->updateByPk($detail->invperalatan_id, array(
                                // 'invperalatan_keadaan'=>$detail->mutasi_keadaan,
                                // 'ruangan_id'=>$model->ruangantujuan_id,
                            ));
                             * 
                             */
                        }
                    }

                    if ($ok) {
                        
                        
                        
                        $trans->commit();
                        Yii::app()->user->setFlash("success", "Berhasil! Mutasi berhasil disimpan.");

                        $this->redirect(array('index', 'id'=>$model->mutasiaset_id));

                    } else {
                        $trans->rollback();
                        Yii::app()->user->setFlash("gagal", "Mutasi gagal disimpan.");                                    
                    }


                } catch (Exception $exc) {
                    $trans->rollback();
                    Yii::app()->user->setFlash("error", "Error! Mutasi gagal disimpan ".MyExceptionMessage::getMessage($exc,true));                
                }
            }
        
            $this->render('index', array(
                'model'=>$model,
                'detail'=>$detail,
            ));
            
	}

        /**
         * fungsi cetak
         */
	public function actionPrint($id)
	{
	    $this->layout = '//layouts/printWindows';
            $modMutasi = MutasiasetT::model()->findByPk($id); 
            $format = new MyFormatter();

            $modDetailMutasi= MutasiasetperalatanT::model()->findAllByAttributes(array('mutasiaset_id' => $modMutasi->mutasiaset_id));
            $modPegSerah= PegawaiM::model()->findByPk($modMutasi->pegmenyerahkan_id);
            $modPegTerima= PegawaiM::model()->findByPk($modMutasi->pegpenerima_id);

            if (!empty($modMutasi)){                            
                $this->render($this->path_view.'print/index', array(
                    'modMutasi' => $modMutasi,
                    'format' => $format, 
                    'modDetailMutasi' => $modDetailMutasi,   
                    'modPegSerah' => $modPegSerah,
                    'modPegTerima' => $modPegTerima,
                ));
            }
	}

    
    /**
     * Mengambil list autocomplete peralatan berdasarkan ruangan.
     * Peralatan yang sudah dipilih di form tidak ditampilkan dari list.
     * 
     * 
     * @param string  $term Peralatan yang dicari.
     * @param integer $ruangan_id Ruangan dimana peralatan berada.
     * @param integer $peralatankecuali_id ID Perlatan yang dikecualikan dalam list.
     */
    public function actionAjaxGetPeralatan($term="", $ruangan_id="", $peralatankecuali_id = "", $lokasi_id = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $cr = new CDbCriteria;
        $term = strtolower($term);
        $kecuali = empty($peralatankecuali_id) ? array() : explode(".", $peralatankecuali_id);
        
        $cr->compare('ruangan_id', $ruangan_id);
        $cr->compare('lokasi_id', $lokasi_id);
        $cr->addCondition("lower(invperalatan_namabrg) ilike '%".$term."%' or invperalatan_kode ilike '&".$term."&'");
        $cr->addNotInCondition('invperalatan_id', $kecuali);
        $cr->limit = 20;
        
        $peralatan = InvperalatanT::model()->findAll($cr);
        
        
        $res = array();
        
        foreach($peralatan as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->invperalatan_namabrg." - ".$item->invperalatan_kode;
            $sub['value'] = $item->invperalatan_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
    
    /**
     * action ini digunakan untuk masuk ke halaman informasi mutasi aset
     */
    public function actionInformasi(){
        $model = new MAInfomutasiasetV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
               
        
        if (isset($_GET['MAInfomutasiasetV'])){
            $model->attributes = $_GET['MAInfomutasiasetV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfomutasiasetV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfomutasiasetV']['tgl_akhir']);            
            $model->instalasiasal_id = isset($_GET['MAInfomutasiasetV']['instalasiasal_id'])?$_GET['MAInfomutasiasetV']['instalasiasal_id']:null;
            $model->instalasitujuan_id = isset($_GET['MAInfomutasiasetV']['instalasitujuan_id'])?$_GET['MAInfomutasiasetV']['instalasitujuan_id']:null;
            $model->unitasal_id = isset($_GET['MAInfomutasiasetV']['unitasal_id'])?$_GET['MAInfomutasiasetV']['unitasal_id']:null;
            $model->unittujuan_id = isset($_GET['MAInfomutasiasetV']['unittujuan_id'])?$_GET['MAInfomutasiasetV']['unittujuan_id']:null;
        }
        
        $pj_aset = PenanggungjawabasetM::model()->find(" penanggungjawabaset_aktif = TRUE AND pegawai_id = ".Yii::app()->user->getState('pegawai_id')." ");        
        $model->is_pj_aset = (!empty($pj_aset)?true:false);        
        
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                $path  = $this->path_view.'informasi/table';
                if ($ajax == 'lokasi-grid'){
                    $path  = $this->path_view.'grid/_lokasi';
                }elseif ($ajax == 'ruangan-grid'){
                    $path  = $this->path_view.'grid/_ruangan';
                }
                $this->renderPartial($path,['model'=>$model]);
            }
        }else{
            $this->render('informasi',array('model'=>$model));
        }
    }
    
    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @author Elham Budianto <elhambudianto1@gmail.com>
     * @param type $mutasiaset_id, $detail=null
     */
    public function actionLihatDetail($mutasiaset_id){
        $model = MutasiasetT::model()->findByPk($mutasiaset_id);
        
        $model->tglmutasiaset = MyFormatter::formatDateTimeForUser($model->tglmutasiaset);

        $peg_serah = PegawaiM::model()->findByPk($model->pegmenyerahkan_id);
        $model->pegmenyerahkan_nama = $peg_serah->nama_pegawai;


        if (!empty($model->pegpenerima_id)) {
            $peg_terima = PegawaiM::model()->findByPk($model->pegpenerima_id);
            $model->pegpenerima_nama = $peg_terima->nama_pegawai;
        }

        $ruangan_asal = RuanganM::model()->findByPk($model->ruanganasal_id);
        $ruangan_tujuan = RuanganM::model()->findByPk($model->ruangantujuan_id);
        $model->ruanganasal_nama = !empty($ruangan_asal)?$ruangan_asal->ruangan_nama:null;
        $model->ruangantujuan_nama = !empty($ruangan_tujuan)?$ruangan_tujuan->ruangan_nama:null;

        $model->lokasiasal_nama = !empty($model->lokasiasal->lokasiaset_namalokasi)?$model->lokasiasal->lokasiaset_namalokasi:null;
        $model->lokasitujuan_nama = !empty($model->lokasitujuan->lokasiaset_namalokasi)?$model->lokasitujuan->lokasiaset_namalokasi:null;


        $detail = MutasiasetperalatanT::model()->findAllByAttributes(array(
            'mutasiaset_id'=>$mutasiaset_id,
        ));
        
        $this->render('detail',array('model'=>$model,'detail'=>$detail));
    }
    
    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @author Elham Budianto <elhambudianto1@gmail.com>
     * @param type $mutasiaset_id, $detail=null
     */
    public function actionVerifikasi($mutasiaset_id){
        $model = MutasiasetT::model()->findByPk($mutasiaset_id);
        
        $model->tglmutasiaset = MyFormatter::formatDateTimeForUser($model->tglmutasiaset);

        $peg_serah = PegawaiM::model()->findByPk($model->pegmenyerahkan_id);
        $model->pegmenyerahkan_nama = $peg_serah->nama_pegawai;


        if (!empty($model->pegpenerima_id)) {
            $peg_terima = PegawaiM::model()->findByPk($model->pegpenerima_id);
            $model->pegpenerima_nama = $peg_terima->nama_pegawai;
        }

        $ruangan_asal = RuanganM::model()->findByPk($model->ruanganasal_id);
        $ruangan_tujuan = RuanganM::model()->findByPk($model->ruangantujuan_id);
        $model->ruanganasal_nama = !empty($ruangan_asal)?$ruangan_asal->ruangan_nama:null;
        $model->ruangantujuan_nama = !empty($ruangan_tujuan)?$ruangan_tujuan->ruangan_nama:null;

        $model->lokasiasal_nama = !empty($model->lokasiasal->lokasiaset_namalokasi)?$model->lokasiasal->lokasiaset_namalokasi:null;
        $model->lokasitujuan_nama = !empty($model->lokasitujuan->lokasiaset_namalokasi)?$model->lokasitujuan->lokasiaset_namalokasi:null;


        $detail = MutasiasetperalatanT::model()->findAllByAttributes(array(
            'mutasiaset_id'=>$mutasiaset_id,
        ));
        
        if (isset($_POST['MutasiasetT'])){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['MutasiasetT'];
                $model->tglmutasiaset = !empty($model->tglmutasiaset)?MyFormatter::formatDateTimeForDb($model->tglmutasiaset):null;
                $model->tanggal_verifikasi = date('Y-m-d H:i:s');
                $model->pegverifikasi_id = Yii::app()->user->getState('pegawai_id');
                $model->is_disetujui = ($model->is_disetujui)?true:false;
                $model->update_time = date("Y-m-d H:i:s");
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $ok &= $model->save();                                
                                
                
                if ($ok){
                    Yii::app()->user->setFlash("success", "Data berhasil disimpan.");
                    $trans->commit();
                    $this->redirect(['verifikasi','mutasiaset_id'=>$model->mutasiaset_id]);
                }else {
                    $trans->rollback();
                    Yii::app()->user->setFlash("gagal", "Mutasi gagal disimpan.");                                    
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash("error", "Error! Mutasi gagal disimpan ".MyExceptionMessage::getMessage($exc,true));                
            }                                    
        }
        
        $this->render('verifikasi',array('model'=>$model,'detail'=>$detail));
    }
    
    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @author Elham Budianto <elhambudianto1@gmail.com>
     * - digunakan untuk mengubah status mutasi
     */    
    public function actionUbahStatus(){
        if (Yii::app()->request->isAjaxRequest){
            $status = isset($_POST['st'])?$_POST['st']:null;
            $mutasiaset_id = isset($_POST['mutasiaset_id'])?$_POST['mutasiaset_id']:null;
                        
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $up = MutasiasetT::model()->findByPk($mutasiaset_id);
                $up->pegpenerima_tgl = date('Y-m-d');
                $up->update_time = date('Y-m-d H:i:s');
                if (empty($up->pegpenerima_id)){
                    $up->pegpenerima_id = Yii::app()->user->getState('pegawai_id');
                }
                $up->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $up->mutasiaset_status = $status;                       
                $ok = $ok && $up->save();
                
                if ($ok){                    
                    if ($status == ParamsConst::STATUS_MUTASI_ASET_SUDAH){
                        
                        $det = MutasiasetperalatanT::model()->findAllByAttributes(array('mutasiaset_id' => $up->mutasiaset_id));                        
                        if (!empty($det)){                            
                            // stock in
                            foreach ($det as $d){                                
                                $inv = InvperalatanT::model()->findByPk($d->invperalatan_id);
//                                $perDet = TerimapersdetailT::model()->findByPk($inv->terimapersdetail_id);
//                                
//                                // simpan stok in, menambahkan stok ruangan tujuan yang dimutasi oleh ruangan asal
//                                $in = new InventarisasiruanganT;
//                                $in->invperalatan_id = $d->invperalatan_id;
//                                $in->terimapersdetail_id = $inv->terimapersdetail_id;
//                                $in->barang_id = $inv->barang_id;
//                                $in->ruangan_id = $up->ruangantujuan_id;
//                                $in->tgltransaksi = date('Y-m-d H:i:s');
//                                $in->inventarisasi_kode = MyGenerator::kodeMutasiAsetInOut('IN');
//                                if (!empty($perDet)){
//                                    $in->inventarisasi_hargabeli = $perDet->hargabeli;
//                                    $in->inventarisasi_hargasatuan = $perDet->hargasatuan;
//                                }
//                                $in->inventarisasi_qty_in = 1;
//                                $in->inventarisasi_qty_out = 0;
//                                $in->inventarisasi_qty_skrg = 1;                                
//                                $in->inventarisasi_keadaan = $d->mutasi_keadaan;
//                                $in->inventarisasi_keterangan = $d->ket_mutasi;
//                                $in->create_time = date('Y-m-d H:i:s');
//                                $in->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
//                                $in->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                                $in->inventarisasiruangan_aktif = true;
//                                                                
//                                $ok = $ok && $in->save();                                                               
//                                                                                                
//                                // simpan stok out, mengurangi stok ruangan asal yang mengirimkan aset
//                                $out = new InventarisasiruanganT;
//                                $out->invperalatan_id = $d->invperalatan_id;
//                                $out->terimapersdetail_id = $inv->terimapersdetail_id;
//                                $out->barang_id = $inv->barang_id;
//                                $out->ruangan_id = $up->ruanganasal_id;
//                                $out->tgltransaksi = date('Y-m-d H:i:s');
//                                $out->inventarisasi_kode = MyGenerator::kodeMutasiAsetInOut('OUT');
//                                if (!empty($perDet)){
//                                    $out->inventarisasi_hargabeli = $perDet->hargabeli;
//                                    $out->inventarisasi_hargasatuan = $perDet->hargasatuan;
//                                }
//                                $out->inventarisasi_qty_in = 0;
//                                $out->inventarisasi_qty_out = 1;
//                                $out->inventarisasi_qty_skrg = -1;                                
//                                $out->inventarisasi_keadaan = $d->mutasi_keadaan;
//                                $out->inventarisasi_keterangan = $d->ket_mutasi;
//                                $out->create_time = date('Y-m-d H:i:s');
//                                $out->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
//                                $out->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                                $out->inventarisasiruangan_aktif = true;
//                                
//                                $ok = $ok && $out->save();
                                
                                //update ruangan inv peralatan
                                $modInv = InvperalatanT::model()->findByPk($d->invperalatan_id);
                                $modInv->ruangan_id = $up->ruangantujuan_id;
                                $ok = $ok && $modInv->save();
                                
                                
                            }
                                                        
                            $up->lokasitujuan_id = $modInv->lokasi_id;
                            $ok &= $up->update();
                            
                        }                                                
                    }elseif($status == ParamsConst::STATUS_MUTASI_ASET_BATAL){
                        $det = MutasiasetperalatanT::model()->findAllByAttributes(array('mutasiaset_id' => $up->mutasiaset_id));                        
                        if (!empty($det)){
                            // stock in
                            foreach ($det as $d){
                                $inv = InvperalatanT::model()->findByPk($d->invperalatan_id);
                                $inv->ruangan_id = $up->ruanganasal_id;
                                $ok = $ok && $inv->save();
                            }
                        }
                    }
                    
                    $trans->commit();
                    $data['pesan'] = 'Perubahan status berhasil disimpan !';
                    $data['sukses'] = 1;
                }else{
                    $trans->rollback();
                    $data['pesan'] = 'Perubahan status gagal disimpan';
                    $data['sukses'] = 0;
                }                
            }catch(Exception $e){                
                $trans->rollback();
                $data['pesan'] = 'Perubahan status gagal disimpan';
                $data['sukses'] = 0;
            }
                                                            
            echo json_encode($data);
        }
    }
    
   
}