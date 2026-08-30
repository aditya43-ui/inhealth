<?php
/**
 * Form Penerimaan kantong darah.
 * Dapat dilakukan via menu maupun informasi Kirim Kantong Darah.
 *
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class PenerimaanKantongDarahController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view ='bankDarah.views.penerimaanKantongDarah.';
    public $penerimaankantongdetailtersimpan =true;
    public $terimakantongtersimpan = true;
    public $updatekantongdarah = true;
    public $updatekirim = true;
    
    /**
     * digunakan untuk masuk ke menu transaksi penerimaan kantong darah
     * @param integer $kirimkantongdarah_id   ID Kirim Kantong Darah
     * @param integer $terimakantongdarah_id  ID Terima Kantong Darah (Setelah Submit)
     */
    public function actionIndex($kirimkantongdarah_id = null, $terimakantongdarah_id = null)
    {
        $modTerimaKantong = new BDTerimakantongdarahT();
        $modTerimaKantong->no_terimakantong = '--Otomatis--';
        $modTerimaKantong->tglterimakantong = date('Y-m-d H:i:s');

        $modTerimaKantongDet = new BDTerimakantongdetT();
        $format = new MyFormatter();
        $modKirimKantongdetail = array();
        $modTerimaDetail = array();
        $modKirimKantong='';
        if (isset($kirimkantongdarah_id) && $kirimkantongdarah_id != null) {
            $modKirimKantong = BDKirimkantongdarahT::model()->findByPk($kirimkantongdarah_id);
            $modKirimKantongdetail = KirimkantongdetT::model()->findAllByAttributes(array('kirimkantongdarah_id'=>$kirimkantongdarah_id));
        }
        
        if (!empty($terimakantongdarah_id)) {
            $modTerimaKantong = BDTerimakantongdarahT::model()->findByPk($terimakantongdarah_id);
            
            $criKirim = new CDbCriteria();
            $criKirim->join = " JOIN terimakantongdet_t terimadet ON terimadet.kantongdarah_id = t.kantongdarah_id ";
            $criKirim->addCondition(" t.kirimkantongdarah_id = ".$kirimkantongdarah_id." AND terimadet.terimakantongdarah_id = ".$terimakantongdarah_id);
            $modKirimKantongdetail = KirimkantongdetT::model()->findAll($criKirim);
        }
        
        if (isset($_POST['BDTerimakantongdarahT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modTerimaKantong->attributes=$_POST['BDTerimakantongdarahT'];
                if (empty($modTerimaKantong->terimakantongdarah_id)){
                    $modTerimaKantong->kirimkantongdarah_id=isset($modKirimKantong->kirimkantongdarah_id) ? $modKirimKantong->kirimkantongdarah_id : $_POST['BDTerimakantongdarahT']['kirimkantongdarah_id'];                
                    $modTerimaKantong->tglterimakantong = $format->formatDateTimeForDb($_POST['BDTerimakantongdarahT']['tglterimakantong']);
                    $modTerimaKantong->no_terimakantong = MyGenerator::noPenerimaanKantong();                
                    $modTerimaKantong->create_time = date('Y-m-d H:i:s');
                    $modTerimaKantong->create_loginpemakai_id = Yii::app()->user->id;
                    $modTerimaKantong->create_ruangan = Yii::app()->user->ruangan_id;
                    $modTerimaKantong->ruanganterima_id = Params::RUANGAN_TRANSFUSI_DARAH;
                    $modTerimaKantong->suhu = (!empty($modTerimaKantong->suhu))?MyFormatter::formatNumberForDb($modTerimaKantong->suhu):null;
                }else{
                    $modTerimaKantong->update_time = date('Y-m-d H:i:s');
                    $modTerimaKantong->update_loginpemakai_id = Yii::app()->user->id;
                }                
                
                 
                if ($modTerimaKantong->save()) {
                    /* update kantong darah*/
                    $updateKirimKantongDarah = KirimkantongdarahT::model()->findByPk($modTerimaKantong->kirimkantongdarah_id);
                    $updateKirimKantongDarah->isterima = true;
                    if ($updateKirimKantongDarah->update()) {
                        $this->updatekirim = true;
                        $this->updatekirim = KirimkantongdetT::model()->updateAll(['terimakantongdarah_id' => $modTerimaKantong->terimakantongdarah_id], 'kirimkantongdarah_id=' . $modTerimaKantong->kirimkantongdarah_id);
                    } else {
                        $this->updatekirim = false;
                    }
                    /*end*/
                    $this->terimakantongtersimpan = true;
                    
                    // untuk insert ke detail
                    
                    if (isset($_POST['BDTerimakantongdetT']['detail'])) {
                        if (count($_POST['BDTerimakantongdetT']['detail']) > 0) {
                            foreach ($_POST['BDTerimakantongdetT']['detail'] as $no_sampel => $detail) {
                                if ($detail['sampel_konfirmasi'] == true || $detail['sampel_imltd'] == true || $detail['sampel_utama'] == true ){                                    
                                    foreach ($detail['detail'] as $kantongdarah_id => $subdetail) {
                                        $modTerimaKantongDet = $this->simpanDetail($modTerimaKantong, $subdetail, $kantongdarah_id, $detail);
                                        /* update kantongdarahdet_t*/
                                        $modUpdateKantongDarah = $this->updateKantongDarah($modTerimaKantong, $subdetail, $kantongdarah_id);
                                        /* end */
                                    }
                                }
                            }
                        }
                    } // end simpan detail
                } else {
                    $this->terimakantongtersimpan = false;
                }
                
                if ($this->terimakantongtersimpan && $this->penerimaankantongdetailtersimpan && $this->updatekantongdarah && $this->updatekirim) {
                    $transaction->commit();
                    $modTerimaKantong->isNewRecord = false;
                    if (isset($_GET['frame'])){
                        $this->redirect(array('index','kirimkantongdarah_id'=>$modTerimaKantong->kirimkantongdarah_id,'terimakantongdarah_id'=>$modTerimaKantong->terimakantongdarah_id,'sukses'=>1, 'frame'=>true));
                    }else{
                        $this->redirect(array('index','kirimkantongdarah_id'=>$modTerimaKantong->kirimkantongdarah_id,'terimakantongdarah_id'=>$modTerimaKantong->terimakantongdarah_id,'sukses'=>1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Penerimaan Kantong Darah gagal disimpan !");
                    $this->redirect(array('index','kirimkantongdarah_id'=>$modTerimaKantong->kirimkantongdarah_id));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data penerimaan darah gagal disimpan ! ".MyExceptionMessage::getMessage($exc,true));
                $this->redirect(array('index','kirimkantongdarah_id'=>$modTerimaKantong->kirimkantongdarah_id));
            }
        }
        
        $this->render($this->path_view.'index', array(
            'modTerimaKantong'=>$modTerimaKantong,
            'modTerimaKantongDet'=>$modTerimaKantongDet,
            'modKirimKantongdetail'=>$modKirimKantongdetail,
            'modKirimKantong'=>$modKirimKantong,
            'kirimkantongdarah_id'=>$kirimkantongdarah_id,
            'format'=>$format,
        ));
    }
    
    /**
     * fungsi menyimpan detail terima kantong
     * @param BDTerimakantongdarahT $modTerima
     * @param mixed                 $detail
     * @param integer               $kantongdarah_id
     * @return \BDTerimakantongdetT
     */
    public function simpanDetail($modTerima, $subdetail, $kantongdarah_id, $detail)
    {
        $format = new MyFormatter();
        $modTerimaKantongDet = new BDTerimakantongdetT;
        $cekDet = BDTerimakantongdetT::model()->findByPk($subdetail['terimakantongdet_id']);
        if (!empty($cekDet)){
            $modTerimaKantongDet = $cekDet;
        }
        $modTerimaKantongDet->attributes = $subdetail;
        $modTerimaKantongDet->terimakantongdarah_id = $modTerima->terimakantongdarah_id;
        $modTerimaKantongDet->kantongdarah_id = $kantongdarah_id;
        $modTerimaKantongDet->sampel_utama = $detail['sampel_utama'];
        $modTerimaKantongDet->sampel_konfirmasi = $detail['sampel_konfirmasi'];
        $modTerimaKantongDet->sampel_imltd = $detail['sampel_imltd'];
        
        if ($modTerimaKantongDet->validate()) {
            if ($modTerimaKantongDet->save()) {
                $this->penerimaankantongdetailtersimpan &= true;
            } else {
                $this->penerimaankantongdetailtersimpan &= false;
            }
        }
        
        return $modTerimaKantongDet;
    }
    
    /**
     * menmperbarui data kantongdarah
     * @param  BDTerimakantongdarahT $modTerima
     * @param  mixed                 $detail
     * @param  integer               $kantongdarah_id
     * @return integer
     */
    public function updateKantongDarah($modTerima, $detail, $kantongdarah_id)
    {   
        $updateKantongDarah = KantongdarahT::model()->updateByPk($kantongdarah_id, array('terimakantongdarah_id'=>$modTerima->terimakantongdarah_id, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')));
    
        if ($updateKantongDarah) {
            $this->updatekantongdarah &= true;
        } else {
            $this->updatekantongdarah &= false;
        }
        return $updateKantongDarah;
    }
    
    /**
     * mengenerate data ruangan
     */
    public function actionGetRuangan()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $ruangan_id = isset($_POST['id']) ? $_POST['id'] : ' ';
            if (isset($ruangan_id)) {
                $modRuangan = RuanganM::model()->findByPk($ruangan_id);
                $data['ruangan_nama'] = $modRuangan->ruangan_nama;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * mengenerate tanggal kirim
     */
    public function actionGetTanggalKirim()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $tanggal_kirim = isset($_POST['tgl']) ? $_POST['tgl'] : ' ';
            if (isset($tanggal_kirim)) {
                $data['tglkirimkantongdarah'] = MyFormatter::formatDateTimeForUser($tanggal_kirim);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * mengenerate data pegawai
     */
    public function actionGetPegawai()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : ' ';
            if (isset($pegawai_id)) {
                $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
                $data['pegawai_nama'] = $modPegawai->nama_pegawai;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * mengenerate cool box
     */
    public function actionGetCoolbox()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $coolboxdarah_id = isset($_POST['coolboxdarah_id']) ? $_POST['coolboxdarah_id'] : ' ';
            if (isset($coolboxdarah_id)) {
                $modCoolbox = CoolboxdarahM::model()->findByPk($coolboxdarah_id);
                $data['coolboxdarah_nama'] = $modCoolbox->coolboxdarah_nama;
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * mengenerate detail kirim
     */
    public function actionGetDetailKirim()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $kirimkantongdarah_id = $_POST['kirimkantongdarah_id'];
            $modKirimKantongdetail = KirimkantongdetT::model()->findAllByAttributes(array('kirimkantongdarah_id'=>$kirimkantongdarah_id));
            $tr = $this->renderPartial($this->path_view.'_detailKirimKantong', array('modKirimKantongdetail'=>$modKirimKantongdetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    /**
     * Autocomplete untuk mengambil data Petugas Terima berdasarkan Ruangan.
     * Untuk field autoccomplete Petugas Terima.
     * 
     * @param string $term Pegawai yang dicari
     */
    public function actionAutocompletePetugasTerima($term = null)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $cr = new CDbCriteria();
        $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        // $cr->compare('kelompokpegawai_id', Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
        $cr->compare('lower(nama_pegawai)', strtolower($term), true);
        $cr->order = 'nama_pegawai';
        
        $data = PegawairuanganV::model()->findAll($cr);
        $res = array();
        
        foreach ($data as $item) {
            $sub = $item->attributes;
            
            $sub['label'] = $item->nama_pegawai;
            $sub['value'] = $item->pegawai_id;
        
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
}
