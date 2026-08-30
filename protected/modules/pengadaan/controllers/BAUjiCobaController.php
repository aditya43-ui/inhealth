<?php
/**
 * Tab menu Berita Acara Uji Coba
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Tantowi J <tantowijaya@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAUjiCobaController extends MyAuthController{

    /**
     * Default menu transaksi
     * @param integer $suratperjanjiankerja_id
     * @param integer $baujifungsi_id
     */
    public function actionIndex($suratperjanjiankerja_id = null, $baujifungsi_id = null){
        $this->layout = '//layouts/iframe';
        
        $cekUji = BaujifungsiT::model()->findByAttributes(array('baujifungsi_id' => $baujifungsi_id));
        $spkTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        $cekTermin = BaujifungsiT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        
        if (!empty($cekUji)) {
            $model = BaujifungsiT::model()->findByPk($cekUji->baujifungsi_id);
            $model->pegawai_nama = $model->pegawai->namaLengkap;
            $model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
            $model->baujifungsi_tanggal = MyFormatter::formatDateTimeForUser($model->baujifungsi_tanggal); 
            $model->temp_file = $model->dokumen_pendukung;
            if(!is_numeric($model->terminke)){
                $model->terminke = CustomFunction::romanToInteger($model->terminke);
            }
            $model->terminke = (empty($model->terminke))? 1 : $model->terminke;
        } else {
            $model = new BaujifungsiT;
            $model->baujifungsi_nomor = '-- Otomatis --';
            $model->baujifungsi_tanggal = date('d M Y H:i:s');
            $model->terminke = (count($cekTermin) <= 0 )? 1 : (count($cekTermin)+1);
        }
        
        $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
        $model->jumlah_termin = (count($spkTermin) <= 0 )? 0 : count($spkTermin);
        
        if(empty($baujifungsi_id)){
            if(count($spkTermin) > 0){
                $termin = count($cekTermin)+1;
                $termin = CustomFunction::Romawi($termin);
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $termin));
                $model->termin_persen = !empty($modTermin->jumlah_persen)? $modTermin->jumlah_persen : null;
            }else{
                $model->termin_persen = 100;
            }
        }
        
        $modPegawai = new PegtimteknisT;
        $modPegawaiPenyedia = new TeknisipenyediaT;
        $modDetail = new BaujifungsidetT;
        if (isset($_POST['BaujifungsiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['BaujifungsiT'];
                $model->baujifungsi_tanggal = MyFormatter::formatDateTimeForDb($model->baujifungsi_tanggal);
                if (empty($model->baujifungsi_id)) {
                    $model->baujifungsi_nomor = MyGenerator::noBAUjiCoba();
                    $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    if(is_numeric($model->terminke)){
                        $model->terminke = CustomFunction::Romawi($model->terminke);
                    }
                } else {
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    if(is_numeric($model->terminke)){
                        $model->terminke = CustomFunction::Romawi($model->terminke);
                    }
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->baujifungsi_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BaujifungsiT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                    
                $ok = $ok && $model->save();
                
                $this->updateUjiDet($model->baujifungsi_id, $_POST['BaujifungsidetT']);
                $this->updateTimTeknis($model->baujifungsi_id, $_GET['suratperjanjiankerja_id'], $_POST['PegtimteknisT']);
                $this->updateTimTeknisPenyedia($_GET['suratperjanjiankerja_id'], $model->baujifungsi_id, $_POST['TeknisipenyediaT']);
                
                if ($ok) {                   
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'baujifungsi_id' => $model->baujifungsi_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'modDetail' => $modDetail, 'modPegawai' => $modPegawai, 'modPegawaiPenyedia' => $modPegawaiPenyedia));        
    }
    
    /**
     * Simpan / update tabel baujifungsidet_t
     * @param integer $id
     * @param array $post
     */
    public function updateUjiDet($id, $post){
        $ok = true;
        foreach ($post as $key => $value) {
            if (!empty($value['baujifungsidet_id'])) {
                BaujifungsidetT::model()->updateByPk($value['baujifungsidet_id'], array(
                    'baujifungsi_id' => $value['baujifungsi_id'],
                    'barang_id' => $value['barang_id'],
                    'jenis_barang' => $value['jenis_barang'],
                    'nama_barang' => $value['nama_barang'],
                    'satuan_barang' => $value['satuan_barang'],
                    'jumlah_barang' => $value['jumlah_barang'],
                    'islengkap' => isset($value['islengkap'])? $value['islengkap'] : false,
                    'isfungsibaik' => $value['isfungsibaik'],
                    'hasil_uji' => ($value['isfungsibaik'])? "Baik" : "Tidak Baik",
                    'baujifungsidet_tanggal' => MyFormatter::formatDateTimeForDb($value['baujifungsidet_tanggal']),
                    'keterangan_uji' => $value['keterangan_uji']
                ));
                $modDetail = BaujifungsidetT::model()->findByAttributes(array('baujifungsi_id' => $id));
//                $ok = $ok && $modDetail->save();
            } else {
                $modDetail = new BaujifungsidetT;
                $modDetail->attributes = $value;
                $modDetail->baujifungsi_id = $id;
                $modDetail->hasil_uji = ($modDetail->isfungsibaik)? "Baik" : "Tidak Baik";
                $ok = $ok && $modDetail->save();
            }
        }
    }
    
    /**
     * Simpan / Update Data tim teknis
     * @param integer $baujifungsi_id
     * @param integer $id
     * @param array $post
     */
    public function updateTimTeknis($baujifungsi_id, $id, $post){
        $ok = true;
        foreach ($post as $i => $mod) {
            $modPegawai = PegtimteknisT::model()->findByAttributes(array('suratperjanjiankerja_id' => $id, 'baujifungsi_id' => $baujifungsi_id));
            if (!empty($mod['pegtimteknis_id'])) {
                PegtimteknisT::model()->updateByPk($modPegawai->pegtimteknis_id,array(
                    'pegawai_id' => $mod['pegawai_id'],
                    'suratperjanjiankerja_id' => $id,
                    'baujifungsi_id' => $baujifungsi_id,
                ));
                $modPegawai = PegtimteknisT::model()->findByAttributes(array('suratperjanjiankerja_id' => $id, 'baujifungsi_id' => $baujifungsi_id));
                $modPegawai->suratperjanjiankerja_id = $id;
                $ok = $ok && $modPegawai->save();
            } else {
                $modPegawai = new PegtimteknisT;
                $modPegawai->attributes = $mod;
                $modPegawai->suratperjanjiankerja_id = $id;
                $modPegawai->baujifungsi_id = $baujifungsi_id;
                $ok = $ok && $modPegawai->save();
            }
        }
    }
    
    /**
     * Simpan / Update Data tim teknis penyedia
     * @param integer $suratperjanjiankerja_id
     * @param integer $baujifungsi_id
     * @param array $post
     */
    public function updateTimTeknisPenyedia($suratperjanjiankerja_id, $baujifungsi_id, $post){
        $ok = true;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        foreach ($post as $i => $mod) {
            if (!empty($mod['teknisipenyedia_id'])) {
                TeknisipenyediaT::model()->updateByPk($mod['teknisipenyedia_id'],array(
                    'baujifungsi_id' => $baujifungsi_id,
                    'teknisipenyedia_nama' => $mod['teknisipenyedia_nama'],
                    'supplier_id' => $modSPK->supplier_id,
                ));
            } else {
                $modPegawai = new TeknisipenyediaT;
                $modPegawai->attributes = $mod;
                $modPegawai->baujifungsi_id = $baujifungsi_id;
                $modPegawai->supplier_id = $modSPK->supplier_id;
                $ok = $ok && $modPegawai->save();
            }
        }
    }
    
    /**
     * Load row pengujian
     */
    public function actionGetAlat(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new BaujifungsidetT;
            
            $data['form'] = "";
            $models = $this->loadModelByType($_POST['id'], $_POST['ujifungsi_id']);
            if(count($models) > 0){
                foreach ($models AS $i=>$modSurat){
                    if (!empty($modSurat->dokumenpelaksanaananggarandet_id)) {
                        $model->barang_id = $modSurat->barang_id;
                        $model->jenis_barang = $modSurat->jenis_barang;
                        $model->nama_barang = $modSurat->barang_nama;
                        $model->satuan_barang = $modSurat->barang_satuan;
                        $model->jumlah_barang = $modSurat->barang_jumlah;
                        $model->hasil = $model->hasil;
                        $model->islengkap = 0;
                        $model->isfungsibaik = false;
                    } else {
                        $model->baujifungsidet_id = $modSurat->baujifungsidet_id;
                        $model->baujifungsi_id = $modSurat->baujifungsi_id;
                        $model->barang_id = $modSurat->barang_id;
                        $model->jenis_barang = $modSurat->jenis_barang;
                        $model->nama_barang = $modSurat->nama_barang;
                        $model->jumlah_barang = $modSurat->jumlah_barang;
                        $model->satuan_barang = $modSurat->satuan_barang; 
                        $model->hasil_uji = $modSurat->hasil_uji;
                        $model->keterangan_uji = $modSurat->keterangan_uji;
                        $model->islengkap = empty($modSurat->islengkap)? 0 : $modSurat->islengkap;
                        $model->isfungsibaik = empty($modSurat->isfungsibaik)? false : $modSurat->isfungsibaik;
                    }
                    $data['form'] .= $this->renderPartial('_rowAlat',array('model'=>$model, 'i' => $i),true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowAlat',array('model'=>$model),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load berdasarkan surat perjanjian kerja rincian atau dari detail uji fungsi
     * @param integer $id
     * @param integer $ujifungsi_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($id, $ujifungsi_id = null){
        if (!empty($ujifungsi_id)) {
            $cekUji = BaujifungsiT::model()->findByAttributes(array('baujifungsi_id' => $ujifungsi_id));
            $modCekDetail = BaujifungsidetT::model()->findAllByAttributes(array('baujifungsi_id' => $cekUji->baujifungsi_id));
            if (!empty($modCekDetail)) {
                $modSurat = BaujifungsidetT::model()->findAllByAttributes(array('baujifungsi_id' => $cekUji->baujifungsi_id));
            } else {
                $modSurat = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $id));
            }
        } else {
            $modSurat = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $id));
        }

        if($modSurat===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $modSurat;
    }
    
   /**
     * Load pegawai tim teknis
     */
    public function actionGetPegawai(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {  
            $model = new PegtimteknisT();
            $data['form'] = "";
            $models = PegtimteknisT::model()->findAllByAttributes(array('baujifungsi_id' => $_POST['id']));
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    $model->nama_pegawai = $model->pegawai->nama_pegawai;
                    $model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
                    $data['form'] .= $this->renderPartial('_rowTimTeknis',array('modPegawai'=>$model, 'i'=>1),true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowTimTeknis',array('modPegawai'=>$model, 'i'=>1),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
   /**
     * Load pegawai tim teknis penyedia
     */
    public function actionGetPenyedia(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {  
            $model = new TeknisipenyediaT();
            $data['form'] = "";
            $models = TeknisipenyediaT::model()->findAllByAttributes(array('baujifungsi_id' => $_POST['id']));
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    $data['form'] .= $this->renderPartial('_rowTimTeknisPenyedia',array('modPegawaiPenyedia'=>$model, 'i'=>1),true);
                }
            } else {
                $data['form'] .= $this->renderPartial('_rowTimTeknisPenyedia',array('modPegawaiPenyedia'=>$model, 'i'=>1),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load data pegawai
     * @param integer $id
     * @return type
     * @throws CHttpException
     */
    private function loadPegawai($id){
            $model = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $id), array('order' => 'pegtimteknis_id ASC'));

        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Delete Pegawai Teknis
     * @param integer $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if($this->loadModel($id)->delete()){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Delete Pegawai Teknis Penyedia
     * @param integer $id
     * @throws CHttpException
     */
    public function actionDeletePenyedia($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = TeknisipenyediaT::model()->findByk($id);
                if($model->delete()){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PegtimteknisT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Autocomplete pegawai monev
     */
    public function actionAutocompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawaiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Cetak transaksi uji coba
     * @param integer $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        
        $model = BaujifungsiT::model()->findByPk($id);
        $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
        $modUnitKerja = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
        $modInstalasi= InstalasiM::model()->findByPK($modUnitKerja->instalasi_id);
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        if(!empty($model->baujifungsi_id)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            if($modSPK->istermin){//jika surat perjanjian adalah termin
              $criteria->addCondition("konfigtemplatesurat_nama = 'BA Uji Coba/Uji Fungsi-Termin'");
            }else{ //jika non termin
              $criteria->addCondition("konfigtemplatesurat_nama = 'BA Uji Coba/Uji Fungsi'");
            }
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modSPK->nomor_dokumen, $isiPesan);
                    $isiPesan = str_replace("{{unitinstalasi}}",$modUnitKerja->namaunitkerja , $isiPesan);
                    if($modSPK->istermin){//jika surat perjanjian adalah termin
                        $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);
                        $isiPesan = str_replace("{{termin_persen}}", $model->termin_persen, $isiPesan);
                     }
                    
                }
                $classku1="";
                $classku2="";
                $modDetail = BaujifungsidetT::model()->findAllByAttributes(array('baujifungsi_id' => $model->baujifungsi_id));
                $i = 1;
                $a = '<table border="1" style="width:100%" id="settabfungsi">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center"> No. </th>
                                <th rowspan="2" style="text-align: center"> Tgl Uji Fungsi </th>
                                <th colspan="3" style="text-align: center"> Spesifikasi Alat </th>
                                <th colspan="2" style="text-align: center"> Kelengkapan </th>
                                <th style="text-align: center"> Keterangan </th>
                            </tr>
                            <tr>
                                
                                <th style="text-align: center"> Nama  </th>
                                <th style="text-align: center"> Keterangan </th>
                                <th style="text-align: center"> Jumlah </th>
                                <th style="text-align: center"> Ada </th>
                                <th style="text-align: center"> Tidak </th>
                                <th style="text-align: center"> Berfungsi Baik </th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                foreach($modDetail as $modDet){
                    if($modDet->islengkap){
                        $classku1="entypo-check";
                        $classku2="";
                    }else{
                        $classku2="entypo-check";
                        $classku1="";
                    }
                    if($modDet->isfungsibaik){
                        $classfungsi="entypo-check";
                    }else{
                        $classfungsi="entypo-cancel";
                    }
                    $a .= '<tr>
                                <td style="color:black; border:1px solid black;text-align: left">' . $i++ . ' </td>
                                <td style="color:black; border:1px solid black;text-align: left">' . date('d ', strtotime($modDet->baujifungsidet_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($modDet->baujifungsidet_tanggal))) . date(' Y', strtotime($modDet->baujifungsidet_tanggal)) . ' </td>
                                <td style="color:black; border:1px solid black;text-align: left">' . $modDet->nama_barang. ' </td>
                                <td style="color:black; border:1px solid black;text-align: left">' . $modDet->keterangan_uji . ' </td>
                                <td style="color:black; border:1px solid black;text-align: left">' . $modDet->jumlah_barang." ".$modDet->satuan_barang. ' </td>
                                <td style="color:black; border:1px solid black;text-align: center"><div class="' . $classku1. '"></div></td>
                                <td style="color:black; border:1px solid black;text-align: center"><div class="' . $classku2. '"></div></td> 
                                <td style="color:black; border:1px solid black;text-align: center"><div class="' . $classfungsi. '"></div></td> 
                                                       
                           </tr>';
                            
                }
                $a .= '</tbody> </table>';
                
                $isiPesan = str_replace("{{tabel_pengujian}}", $a, $isiPesan);
            }
            
            $model->dasar=$isiPesan;
        }
        
        $this->render('print', array('model' => $model));
    }
    
    /**
     * Default menu transaksi
     * @param integer $suratperjanjiankerja_id
     * @param integer $baujifungsi_id
     */
    public function actionDetail($suratperjanjiankerja_id = null, $baujifungsi_id = null){
        $this->layout = '//layouts/iframe';
        
        $cekUji = BaujifungsiT::model()->findByAttributes(array('baujifungsi_id' => $baujifungsi_id));
        $spkTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        $cekTermin = BaujifungsiT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
        
        if (!empty($cekUji)) {
            $model = BaujifungsiT::model()->findByPk($cekUji->baujifungsi_id);
            $model->pegawai_nama = $model->pegawai->namaLengkap;
            $model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
            $model->baujifungsi_tanggal = MyFormatter::formatDateTimeForUser($model->baujifungsi_tanggal); 
            if(!is_numeric($model->terminke)){
                $model->terminke = CustomFunction::romanToInteger($model->terminke);
            }
            $model->terminke = (empty($model->terminke))? 1 : $model->terminke;
        } else {
            $model = new BaujifungsiT;
            $model->baujifungsi_nomor = '-- Otomatis --';
            $model->baujifungsi_tanggal = date('d M Y H:i:s');
            $model->terminke = (count($cekTermin) <= 0 )? 1 : (count($cekTermin)+1);
        }
        
        $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
        $model->jumlah_termin = (count($spkTermin) <= 0 )? 0 : count($spkTermin);
        
        if(empty($baujifungsi_id)){
            if(count($spkTermin) > 0){
                $termin = count($cekTermin)+1;
                $termin = CustomFunction::Romawi($termin);
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $termin));
                $model->termin_persen = !empty($modTermin->jumlah_persen)? $modTermin->jumlah_persen : null;
            }else{
                $model->termin_persen = 100;
            }
        }
        
        $modPegawai = new PegtimteknisT;
        $modPegawaiPenyedia = new TeknisipenyediaT;
        $modDetail = new BaujifungsidetT;
        
        $this->render('detail', array('model' => $model, 'modDetail' => $modDetail, 'modPegawai' => $modPegawai, 'modPegawaiPenyedia' => $modPegawaiPenyedia));        
    }
    
    /**
     * Fungsi unduh file kpendukung pegawai
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BaujifungsiT::model()->findByPk($id);
        $path = Params::pathberitaAcaraDirectory().$filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }
}