
<?php

class PencatatanAsetRuanganController extends MyAuthController {

    public $defaultAction = 'index';
    public $simpanAset = true;
   

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $model = new MAInvperalatanT;
        $modelDetail = new InvperalatanT;
        $model->invperalatan_tglguna = date('d M Y');
        $modBarang = new MABarangM;                        
        
        if (isset($_POST['MAInvperalatanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = new MAInvperalatanT();
                $modelDetail = new InvperalatanT;

                $model->attributes = $_POST['MAInvperalatanT'];                               
                $model->invperalatan_noregister = MyGenerator::Kodenoregister($_POST['MAInvperalatanT']['barang_id']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = null;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->invperalatan_tglguna = !empty($_POST['MAInvperalatanT']['invperalatan_tglguna']) ? $_POST['MAInvperalatanT']['invperalatan_tglguna'] : null;
                $model->tglpenghapusan = !empty($_POST['MAInvperalatanT']['tglpenghapusan']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['tglpenghapusan']) : null;
                $model->invperalatan_tglguna = !empty($_POST['MAInvperalatanT']['invperalatan_tglguna']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['invperalatan_tglguna']) : null;
                $model->peralatan_garansihabis = !empty($_POST['MAInvperalatanT']['peralatan_garansihabis']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['peralatan_garansihabis']) : null;
                
                foreach ($_POST['InvperalatanT'] as $key => $value) {
                    $modelDetail = new InvperalatanT;
                    $modelDetail->attributes = $model->attributes;
                    $modelDetail->attributes = $value;
                    if ($value['ceklis_kode'] != '1'){
                        $modelDetail->invperalatan_kode=MyGenerator::kodePeralatanMesin($modelDetail->barang_id);                                    
                    }
                    $modelDetail->umurekonomis = $value['invperalatan_umurekonomis'];
                    
                    $modelDetail->tanggal_perolehan = !empty($modelDetail->tanggal_perolehan)?MyFormatter::formatDateTimeForDb($modelDetail->tanggal_perolehan):null;
                                       
                    $modelDetail->ruangan_id = !empty($model->lokasi_id) ? $model->lokasi->ruangan_id : null;                   
                                        
                    if ($modelDetail->save()){
                        BarangM::model()->updateByPk($modelDetail->barang_id, array('barang_statusregister' => true));
                        $this->simpanAset &= true;
                    } else {                        
                        $this->simpanAset &= false;
                    }                        
                }

                if ($this->simpanAset) {                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan ");
                    $this->redirect(array('create', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modBarang' => $modBarang
        ));
    }
    
    /**
     * @author Tantowy <tantowijaya@.com>
     * 
     * Proses untuk load data barang berdasarkan jumlah penerimaan
     */
    public function actionLoadDetailInvAlat() {
        if (Yii::app()->request->isAjaxRequest) {

            $modelDetail = new InvperalatanT;
            $jumlah = $_GET['jumlah'];
            $barang_id = $_GET['barang_id'];            

            $barangM = BarangM::model()->findByPk($barang_id);            

            $modelDetail->invperalatan_namabrg = $barangM->barang_nama;            
            $modelDetail->invperalatan_kode = !empty($barangM->subsubkelompok->subsubkelompok_kode)?$barangM->subsubkelompok->subsubkelompok_kode:'';

            $default = "00001";
            $prefix = $modelDetail->invperalatan_kode;
            $sql = "SELECT CAST(MAX(SUBSTR(invperalatan_kode," . (strlen($prefix) + 2) . "," . (strlen($default)) . ")) AS integer) nomaksimal
                        FROM invperalatan_t 
                        WHERE invperalatan_kode LIKE ('" . $prefix . "%')";
            $nourut = Yii::app()->db->createCommand($sql)->queryRow();
            $nourutBaru = (isset($nourut['nomaksimal']) ? $nourut['nomaksimal'] + 1 : 1);

            /* kondisi select count invperalatan_kode, karena di pake untuk no.urut berdasarkan subsubkelompok_kode*/
            $criteriaNoUrut=new CDbCriteria;
            $criteriaNoUrut->select = "count (*) AS kode_urut";
            $criteriaNoUrut->addCondition("invperalatan_kode ILIKE ('".$barangM->subsubkelompok->subsubkelompok_kode."%')");
            $modelNoUrut = InvperalatanT::model()->find($criteriaNoUrut);
            /* end */
            $no_urut = '00001';
            if($jumlah==0){
                $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut+1 : 1;
                $awal = (str_pad($jumlah_noUrut, strlen($no_urut), 0,STR_PAD_LEFT));
                $jumlah_tot = $jumlah;
                $akhir = ($jumlah_noUrut == 1) ? (str_pad($jumlah, strlen($no_urut), 0,STR_PAD_LEFT)) : (str_pad($modelNoUrut->kode_urut + $jumlah, strlen($no_urut), 0,STR_PAD_LEFT));
            }else{
                $jumlah_tot = ($jumlah);
                $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut+1 : 1;
                $awal = (str_pad($jumlah_noUrut, strlen($no_urut), 0,STR_PAD_LEFT));
                $akhir = ($jumlah_noUrut==1)? (str_pad($jumlah, strlen($no_urut), 0,STR_PAD_LEFT)) : (str_pad(($modelNoUrut->kode_urut + $jumlah), strlen($no_urut), 0,STR_PAD_LEFT));
            }
            
            $rows = "";
            for ($i = 0; $i < $jumlah; $i++) {
                $kode = (str_pad($awal+$i, strlen($default), 0, STR_PAD_LEFT));
                $modelDetail->invperalatan_kode = (!empty($barangM->subsubkelompok->subsubkelompok_kode)?$barangM->subsubkelompok->subsubkelompok_kode:'') . '.' . $kode;
                $rows .= $this->renderPartial('_invDetailAset', array('form' => '', 'modelDetail' => $modelDetail, 'i' => $i), true);
                $nourutBaru++;
            }

            echo CJSON::encode(array(
                'barang_nama' => $barangM->barang_nama,
                'rows' => $rows, 
                'awal'=>$awal, 
                'akhir'=>$akhir));
        }
        Yii::app()->end();
    }
       

    /**
     * @author tantowy <tantowijaya@.com>
     * Autocomplete barang aset sesuai dengan golongan aset dan penerimaan aset/barang
     */
    public function actionGetBarangAset() {
        if (Yii::app()->request->isAjaxRequest) {
            $golongan_kode = isset($_GET['golongan_kode']) ? $_GET['golongan_kode'] : null;
            $nopenerimaan = isset($_GET['nopenerimaan']) ? $_GET['nopenerimaan'] : null;
            $term = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(barang_nama)', strtolower($term), true);
            $criteria->compare('LOWER(nopenerimaan)', strtolower($nopenerimaan), true);
            $criteria->compare('LOWER(golongan.golongan_kode)', strtolower($golongan_kode), true);
            $criteria->addCondition("terimapersdetail_id NOT IN (SELECT terimapersdetail_id FROM invperalatan_t WHERE terimapersdetail_id IS NOT NULL)"); //agar detail tidak muncul yg sudah di inventarisasi
            $criteria->addCondition("t.barang_type = '" . Params::TYPE_BARANG_ASET . "'");
            $criteria->order = 'barang_nama';
            $criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama
                            ,subsubkelompok.subsubkelompok_nama,subsubkelompok.subsubkelompok_kode,terimaDet.terimapersdetail_id,terima.terimapersediaan_id,terima.nopenerimaan,terimaDet.jmlterima';
            $criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
                    . ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
                    . ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
                    . ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
                    . ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id'
                    . ' JOIN terimapersdetail_t As terimaDet ON terimaDet.barang_id = t.barang_id'
                    . ' JOIN $terima As terima ON terima.terimapersediaan_id = terimaDet.terimapersediaan_id';
            $models = BarangM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopenerimaan . ' - ' . $model->barang_nama;
                $returnVal[$i]['nopenerimaan'] = $model->nopenerimaan;
                $returnVal[$i]['barang_nama'] = $model->barang_nama;
                $returnVal[$i]['subsubkelompok_nama'] = $model->subsubkelompok_nama;
                $returnVal[$i]['subsubkelompok_kode'] = $model->subsubkelompok_kode;
                $returnVal[$i]['jmlterima'] = $model->jmlterima;
                $returnVal[$i]['value'] = $model->barang_id;
                $returnVal[$i]['terimapersdetail_id'] = $model->terimapersdetail_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionGetkodeRegister(){
            if(Yii::app()->request->isAjaxRequest) {
                $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;

                $returnVal = array();
                $kode_register = MyGenerator::Kodenoregister($barang_id);
                $returnVal['value'] = !empty($kode_register) ? $kode_register : "";

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
}
