<?php

/**
 * Digunakan untuk mengakses halaman Transaksi Penerimaan Spesimen
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class PenerimaanSpesimenController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'mikrobiologiKlinik.views.penerimaanSpesimen.';
    public $penerimaanspesimendetailtersimpan = true;
    public $terimaspesimentersimpan = true;
    public $updatekirim = true;

    /**
     * Halaman transaksi penerimaan spesimen
     * @param type $pengirimanspesimen_id
     * @param type $penerimaanspesimen_id
     */
    public function actionIndex($pengirimanspesimen_id = null, $penerimaanspesimen_id = null) {
        $modTerimaSpesimen = new PenerimaanspesimenT();
        $modTerimaSpesimen->no_terimaspesimen = '--Otomatis--';
        $modTerimaSpesimen->tglterimaspesimen = date('Y-m-d H:i:s');
        //Ruangan Terima
        $modTerimaSpesimen->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $modTerimaSpesimen->ruanganterima_nama = $modRuangan->ruangan_nama;

        $modTerimaSpesimenDet = new PenerimaanspesimendetT();
        $format = new MyFormatter();
        $modKirimSpesimendetail = array();
        $modTerimaDetail = array();
        $modKirimSpesimen = '';
        
        if (isset($pengirimanspesimen_id) && $pengirimanspesimen_id != null) {
            $modKirimSpesimen = PengirimanspesimenT::model()->findByPk($pengirimanspesimen_id);
            $modKirimSpesimendetail = PengirimanspesimendetT::model()->findAllByAttributes(array('pengirimanspesimen_id' => $pengirimanspesimen_id,'penerimaanspesimendet_id'=>null));
        }

        if (!empty($penerimaanspesimen_id)) {
            $modTerimaSpesimen = PenerimaanspesimenT::model()->findByPk($penerimaanspesimen_id);
            if(!empty($modTerimaSpesimen)){
                $modRuangan = RuanganM::model()->findByPk($modTerimaSpesimen->ruangan_id);
                $modTerimaSpesimen->ruanganterima_nama = $modRuangan->ruangan_nama;
                $modTerimaSpesimen->keterangan_penerimaan = $modTerimaSpesimen->keterangan_penerimaan;
                $modTerimaSpesimen->ruanganterima_nama = $modRuangan->ruangan_nama;
                $modTerimaSpesimen->tglterimaspesimen = $format->formatDateTimeForUser($modTerimaSpesimen->tglterimaspesimen);
            }
            
            $modKirimSpesimen = new PengirimanspesimenT;
            $cekPenerimaandet = PenerimaanspesimendetT::model()->findAllByAttributes(array('penerimaanspesimen_id'=>$penerimaanspesimen_id));
            $penerimaanspesimendet_id = array();
            foreach ($cekPenerimaandet as $value){
                $penerimaanspesimendet_id[] = $value->penerimaanspesimendet_id;
            }
            $criteria = new CDbCriteria;
            $criteria->addInCondition("penerimaanspesimendet_id",$penerimaanspesimendet_id); 
            $criteria->addCondition("penerimaanspesimendet_id IS NOT NULL "); 
            $modKirimSpesimendetail = PengirimanspesimendetT::model()->findAll($criteria);
            
        }

        if (isset($_POST['PenerimaanspesimenT'])) {            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modTerimaSpesimen->attributes = $_POST['PenerimaanspesimenT'];
                //$modTerimaSpesimen->pengirimanspesimen_id = isset($modKirimSpesimen->pengirimanspesimen_id) ? $modKirimSpesimen->pengirimanspesimen_id : $_POST['PenerimaanspesimenT']['pengirimanspesimen_id'];
                $modTerimaSpesimen->tglterimaspesimen = $format->formatDateTimeForDb($_POST['PenerimaanspesimenT']['tglterimaspesimen']);
                $modTerimaSpesimen->no_terimaspesimen = MyGenerator::noPenerimaanSpesimen();
                
                if ($modTerimaSpesimen->save()) {
                    /* update spesimen */
                    /*
                    $updateKirimSpesimen = PengirimanspesimenT::model()->findByPk($modTerimaSpesimen->pengirimanspesimen_id);
                    $updateKirimSpesimen->isterima = true;
                    $updateKirimSpesimen->pengirimanspesimen_status = 'Sudah Diterima';
                    if ($updateKirimSpesimen->update()) {
                        $this->updatekirim = true;
                    } else {
                        $this->updatekirim = false;
                    }
                     */
                    /* end */
                    //$this->terimaspesimentersimpan = true;
                    
                    // untuk insert ke detail
                    if (isset($_POST['PenerimaanspesimendetT']['detail'])) {
                        if (count($_POST['PenerimaanspesimendetT']['detail']) > 0) {
                            foreach ($_POST['PenerimaanspesimendetT']['detail'] as $no_sampel => $detail) {
                                if ($detail['checklist'] == 1) {
                                    foreach ($detail['detail'] as $spesimen_id => $subdetail) {
                                        $modTerimaSpesimenDet = $this->simpanDetail($modTerimaSpesimen, $subdetail, $spesimen_id);
                                    }
                                }
                            }
                        }
                    } // end simpan detail
                } else {
                    $this->terimaspesimentersimpan = false;
                }
                
                if ($this->terimaspesimentersimpan && $this->penerimaanspesimendetailtersimpan && $this->updatekirim) {
                    $transaction->commit();
                    $modTerimaSpesimen->isNewRecord = false;
                    $this->redirect(array('index', 'penerimaanspesimen_id' => $modTerimaSpesimen->penerimaanspesimen_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Penerimaan Spesimen gagal disimpan !");
                    $this->redirect(array('index', 'pengirimanspesimen_id' => $modTerimaSpesimen->pengirimanspesimen_id));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Penerimaan Spesimen gagal disimpan ! " . MyExceptionMessage::getMessage($exc, true));
                $this->redirect(array('index', 'pengirimanspesimen_id' => $modTerimaSpesimen->pengirimanspesimen_id));
            }
        }

        $this->render($this->path_view . 'index', array(
            'modTerimaSpesimen' => $modTerimaSpesimen,
            'modTerimaSpesimenDet' => $modTerimaSpesimenDet,
            'modKirimSpesimendetail' => $modKirimSpesimendetail,
            'modKirimSpesimen' => $modKirimSpesimen,
            'format' => $format,
        ));
    }

    /**
     * Fungsi simpan detail penerimaan spesimen
     * @param type $modTerima
     * @param type $detail
     * @param type $spesimen_id
     * @return \PenerimaanspesimendetT
     */
    public function simpanDetail($modTerima, $detail, $spesimen_id) {
        $format = new MyFormatter();
        $modTerimaSpesimenDet = new PenerimaanspesimendetT;
        $modTerimaSpesimenDet->attributes = $detail;
        $modTerimaSpesimenDet->penerimaanspesimen_id = $modTerima->penerimaanspesimen_id;
        $modTerimaSpesimenDet->spesimen_id = $spesimen_id;

        if ($modTerimaSpesimenDet->validate()) {
            if ($modTerimaSpesimenDet->save()) {
                $this->penerimaanspesimendetailtersimpan &= true;
                
                /* update pengirimanspesimendet_t */
                $modUpdatePengirimanSpesimendet = PengirimanspesimendetT::model()->findByPk($detail['pengirimanspesimendet_id']);
                $modUpdatePengirimanSpesimendet->penerimaanspesimendet_id = $modTerimaSpesimenDet->penerimaanspesimendet_id;
                $modUpdatePengirimanSpesimendet->update();
                /* end */
                
                /* update spesimen_t */
                $updateSpesimen = SpesimenT::model()->updateByPk($spesimen_id, array('penerimaanspesimendet_id' => $modTerimaSpesimenDet->penerimaanspesimendet_id));
                /* end */
            } else {
                $this->penerimaanspesimendetailtersimpan &= false;
            }
        }
        
        return $modTerimaSpesimenDet;
    }

    /**
     * Digunakan untuk mendapatkan data ruangan dan instalasi pengiriman
     */
    public function actionGetRuangan() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $ruangan_id = isset($_POST['id']) ? $_POST['id'] : ' ';
            if (isset($ruangan_id)) {
                $modRuangan = RuanganM::model()->findByPk($ruangan_id);
                $data['ruangan_nama'] = $modRuangan->ruangan_nama;
                $data['instalasi_nama'] = $modRuangan->instalasi->instalasi_nama;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mendapatkan data tanggal pengiriman spesimen
     */
    public function actionGetTanggalKirim() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $tanggal_kirim = isset($_POST['tgl']) ? $_POST['tgl'] : ' ';
            if (isset($tanggal_kirim)) {
                $data['tglkirimspesimen'] = MyFormatter::formatDateTimeForUser($tanggal_kirim);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mendapatkan data pegawai pengirim
     */
    public function actionGetPegawai() {
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
     * Digunakan untuk mendapatkan detail pengiriman spesimen
     */
    public function actionGetDetailKirim() {
        if (Yii::app()->request->isAjaxRequest) {
            $pengirimanspesimen_id = $_POST['pengirimanspesimen_id'];
            $modKirimSpesimendetail = PengirimanspesimendetT::model()->findAllByAttributes(array('pengirimanspesimen_id' => $pengirimanspesimen_id,'penerimaanspesimendet_id'=>null));

            $tr = $this->renderPartial($this->path_view . '_detailKirimSpesimen', array('modKirimSpesimendetail' => $modKirimSpesimendetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete petugas penerima
     * @param type $term
     */
    public function actionAutocompletePetugasTerima($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $cr = new CDbCriteria();
        $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
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

    /**
     * Autocomplete petugas penerima
     * @param type $term
     */
    public function actionAutocompletePengirimanSpesimen($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $cr = new CDbCriteria();
        $cr->addCondition('batalpengiriman_id IS NULL');
        $cr->addCondition('isterima IS FALSE');
        $cr->compare('lower(no_kirimspesimen)', strtolower($term), true);
        $cr->order = 'no_kirimspesimen';

        $data = PengirimanspesimenT::model()->findAll($cr);
        $res = array();

        foreach ($data as $item) {
            $sub = $item->attributes;

            $sub['label'] = $item->no_kirimspesimen;
            $sub['value'] = $item->pengirimanspesimen_id;

            $res[] = $sub;
        }
        echo CJSON::encode($res);
    }

    /**
     * Generate spesimen 
     */
    public function actionGetSpesimen() {
        if (Yii::app()->request->isAjaxRequest) {
            $no_spesimen = isset($_POST['no_spesimen']) ? $_POST['no_spesimen'] : null;

            $cri = new CDbCriteria();
            if (is_array($no_spesimen)) {
                $cri->addInCondition("t.spesimen_id", $no_spesimen);
            } else {
                $cri->addCondition("t.spesimen_id = '" . $no_spesimen . "' ");
            }
            $cri->order = "t.tglkirimspesimen desc, t.spesimen_id asc";
            $modKirimSpesimendetail = InfopengirimanspesimenV::model()->findAll($cri);
            $tr = $this->renderPartial($this->path_view . '_detailKirimSpesimen', array('modKirimSpesimendetail' => $modKirimSpesimendetail), true);
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
}
