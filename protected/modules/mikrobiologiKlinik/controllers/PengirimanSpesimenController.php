<?php

/**
 * Digunakan untuk mengakses halaman Transaksi Pengiriman Spesimen
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class PengirimanSpesimenController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'mikrobiologiKlinik.views.pengirimanSpesimen.';
    public $pendonortersimpan = false;
    public $pendaftardonasisimpan = false;
    public $simpandetailspesimen = false;

    /**
     * Digunakan untuk masuk ke menu transksi Pengiriman Spesimen
     * @param type $pengirimanspesimen_id
     */
    public function actionIndex($pengirimanspesimen_id = null) {
        $modKirimSpesimen = new PengirimanspesimenT();
        $modKirimSpesimen->no_kirimspesimen = '--Otomatis--';
        $modKirimSpesimen->tglkirimspesimen = date('Y-m-d H:i:s');
        $modLoginPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
        $modKirimSpesimen->petugaskirim_id = $modLoginPemakai->pegawai_id;
        //Ruangan
        $modKirimSpesimen->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modRuangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
        $modKirimSpesimen->ruangankirim_nama = $modRuangan->ruangan_nama;
        //Instalasi
        $modKirimSpesimen->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));
        $modKirimSpesimen->instalasikirim_nama = $modInstalasi->instalasi_nama;
        $modKirimSpesimenDetail = new PengirimanspesimendetT();
        $format = new MyFormatter();

        if (isset($_POST['PengirimanspesimenT'])) {
            $modKirimSpesimen = new PengirimanspesimenT();
            $modKirimSpesimen->attributes = $_POST['PengirimanspesimenT'];
            $modKirimSpesimen->petugaskirim_id = $_POST['PengirimanspesimenT']['petugaskirim_id'];
            $modKirimSpesimen->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modKirimSpesimen->no_kirimspesimen = MyGenerator::noPengirimanSpesimen();
            $modKirimSpesimen->tglkirimspesimen = $format->formatDateTimeForDb($_POST['PengirimanspesimenT']['tglkirimspesimen']);
            $modKirimSpesimen->keterangan_pengiriman = $_POST['PengirimanspesimenT']['keterangan_pengiriman'];
            $modKirimSpesimen->ruangantujuan_id = $_POST['PengirimanspesimenT']['ruangantujuan_id'];
            if (isset($_POST['PengirimanspesimendetT'])) {
                if ($modKirimSpesimen->validate()) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $success = true;
                        if ($modKirimSpesimen->save()) {
                            $no_urut_terkahir = $_POST['no_urut'];
                            $modKirimSpesimenDetail = $this->validasiTabular($modKirimSpesimen, $_POST['PengirimanspesimendetT'], $no_urut_terkahir);
                        } else {
                            $success = false;
                        }

                        if ($success == true && $this->simpandetailspesimen == true) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index', 'pengirimanspesimen_id' => $modKirimSpesimen->pengirimanspesimen_id, 'sukses' => 1));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                        }
                    } catch (Exception $ex) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                    }
                }
            } else {
                $modKirimSpesimen->validate();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
            }
        }
        $this->render($this->path_view . 'index', array(
            'modKirimSpesimen' => $modKirimSpesimen,
            'modKirimSpesimenDetail' => $modKirimSpesimenDetail,
            'format' => $format,
        ));
    }

    /**
     * Fungsi simpan detail pengiriman spesimen
     * @param type $model
     * @param type $data
     * @param type $no_urut_terkahir
     * @return type
     */
    protected function validasiTabular($model, $data, $no_urut_terkahir) {
        $valid = true;
        foreach ($data as $i => $row) {
            $modDetails[$i] = new PengirimanspesimendetT;
            $modDetails[$i]->attributes = $row;
            $modDetails[$i]->pengirimanspesimen_id = $model->pengirimanspesimen_id;
            $modDetails[$i]->validate();
            $valid = $modDetails[$i]->validate() && $valid;
            if ($modDetails[$i]->save()) {
                $this->simpandetailspesimen = true;
            }
        }
        return $this->simpandetailspesimen;
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
            $cri->order = "t.waktu_pengambilan_spesimen desc, t.spesimen_id asc";
            $modSpesimen = SpesimenT::model()->findAll($cri);

            $tr = '';
            $no = 0;
            
            foreach($modSpesimen as $det){
                $cekSample = SamplelabM::model()->findByPk($det->samplelab_id);
                $jenis_spesimen = '';
                if (!empty($cekSample)) {
                    $jenis_spesimen = $cekSample->samplelab_nama;
                }
                
                $modPenilaian = PenialianKelayakanSpesimenT::model()->findByPk($det['penilaian_kelayakan_spesimen_id']);
                $modKirimSpesimenDetail = new PengirimanspesimendetT();
                $modKirimSpesimenDetail->nama_pasien = $modPenilaian->pasienmasukpenunjang->pasien->nama_pasien;
                $modKirimSpesimenDetail->no_rekam_medik = $modPenilaian->pasienmasukpenunjang->pasien->no_rekam_medik;
                $modKirimSpesimenDetail->ruangan_nama = $modPenilaian->pasienmasukpenunjang->ruanganasal->ruangan_nama;
                $modKirimSpesimenDetail->status = $det->status;
                $modKirimSpesimenDetail->tindakanpelayanan_id = $det['tindakanpelayanan_id'];
                $modKirimSpesimenDetail->waktu_pengambilan_spesimen = MyFormatter::formatDateTimeId($det->waktu_pengambilan_spesimen);
                $modKirimSpesimenDetail->jenis_spesimen = $jenis_spesimen;
                $modKirimSpesimenDetail->jenis_pemeriksaan = $det->tindakanpelayanan->daftartindakan->daftartindakan_nama;
                $modKirimSpesimenDetail->pasien_id = $det->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->pasien_id;
                $modKirimSpesimenDetail->samplelab_id = $det['samplelab_id'];
                $modKirimSpesimenDetail->spesimen_id = $det['spesimen_id'];
                $modKirimSpesimenDetail->no_spesimen = $det['no_spesimen'];
                $tr .= $this->renderPartial($this->path_view . '_detailSpesimen', array('no' => $no + 1, 'modSpesimen' => $det, 'modKirimSpesimenDetail' => $modKirimSpesimenDetail), true);
                $no++;
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete spesimen
     * @param type $term
     */
    public function actionAutocompleteSpesimen($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        //Mencari spesimen yang dibatalkan
        $criteria = new CDbCriteria;
        $criteria->addCondition('batalpengiriman_id IS NOT NULL');
        $criteria->addCondition('isterima IS FALSE');

        $cekSpesimen = PengirimanspesimenT::model()->findAll($criteria);
        $pengirimanspesimen_id = array();

        foreach ($cekSpesimen as $val):
            $pengirimanspesimen_id[] = $val->pengirimanspesimen_id;
        endforeach;
        
        //Spesimen_id yang ada di pengirimanspesimendet_t berarti udah dikirim
        //Kriteria kedua ini menghilangkan pengirimanspesimen_id di pengirimanspesimendet_t, agar spesimen yang dibatalkan dapat ditampilkan kembali
        $criteria2 = new CDbCriteria;
        $criteria2->addNotInCondition('pengirimanspesimen_id',$pengirimanspesimen_id);
        
        $cekPengiriman = PengirimanspesimendetT::model()->findAll($criteria2);
        $spesimen = array();

        foreach ($cekPengiriman as $value):
            $spesimen[] = $value->spesimen_id;
        endforeach;
        
        //Pencarian spesimen yang tidak ada di pengirimanspesimendet_t
        $criteria3 = new CDbCriteria;

        $criteria3->addNotInCondition('spesimen_id',$spesimen);
        $criteria3->addCondition('tindakanpelayanan_id IS NOT NULL');
        $criteria3->compare('lower(no_spesimen)', strtolower($term), true);
        $criteria3->order = 'no_spesimen';

        $data = SpesimenT::model()->findAll($criteria3);
        $res = array();

        foreach ($data as $item) {
            $sub = $item->attributes;

            $sub['no_spesimen'] = $item->spesimen_id;
            $sub['label'] = $item->no_spesimen;
            $sub['value'] = $item->spesimen_id;

            $res[] = $sub;
        }
        echo CJSON::encode($res);
    }
    
    
}
