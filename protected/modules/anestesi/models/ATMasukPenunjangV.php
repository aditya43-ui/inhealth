<?php

/**
 * This is the model class for table "pasienmasukpenunjang_v".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * 
 * @subpackage application.modules.anestesi
 * @package models
 * @category model
 */
class ATMasukPenunjangV extends PasienmasukpenunjangV {

    public $ceklis = false;
    public $statuspendaftaran;
    public $dokterpenerima_nama;
    public $dpjp_nama;
    public $kelastanggungan_nama;
    public $kamarruangan_nokamar;
    public $kamarruangan_nobed;
    public $pasienanastesi_id, $tglanastesi;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function searchBS() {
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id 
                    JOIN pasienanastesi_t ON pasienanastesi_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id
                ";
        $criteria->select = " t.*, p.statusperiksa as statuspendaftaran, pasienanastesi_t.pasienanastesi_id, pasienanastesi_t.tglanastesi, pasienanastesi_t.pasienmasukpenunjang_id";

        if (!empty($this->statuspendaftaran)) {
            $criteria->addCondition(" p.statusperiksa ilike '" . strtolower($this->statuspendaftaran) . "' ");
        }
        
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
                
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);

        if ($this->ceklis) {
            $criteria->addCondition('DATE(t.tglmasukpenunjang) BETWEEN \'' . $this->tgl_awal . '\' AND \'' . $this->tgl_akhir . '\'');
        }

        
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
        }
        
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('t.penjamin_id = ' . $this->penjamin_id);
        }
        
        
        if (!empty($this->ruanganasal_id)) {
            $criteria->addCondition('t.ruanganasal_id = ' . $this->ruanganasal_id);
        }        
        if (!empty($this->instalasiasal_id)) {
            $criteria->addCondition('t.instalasiasal_id = ' . $this->instalasiasal_id);
        }        
        
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('t.kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }        
        
        $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
                                
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition('t.pegawai_id = ' . $this->pegawai_id);
        }

        $criteria->order = 't.tglmasukpenunjang DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Mengambil daftar semua dokter ruangan
     * @return CActiveDataProvider 
     */
    public function getDokterItems($ruangan_id='') {
        return DokterV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'nama_pegawai'));
    }

    /**
     * Load kamar kosong
     * @param integer $ruangan_id
     * @return array
     */
    public function getKamarKosongItems($ruangan_id = '') {
        if (!empty($ruangan_id))
            return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif' => true));
        else
            return array();
    }

    /**
     * Load data para medis
     * @param integer $ruangan_id
     * @return array
     */
    public function getParamedisItems($ruangan_id = '') {
        if (!empty($ruangan_id))
            return ParamedisV::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));
        else
            return array();
    }

    /**
     * Load data staus operasi
     * @param integer $pasienmasukpenunjang_id
     * @return array
     */
    public function getStatusOperasi($pasienmasukpenunjang_id) {
        $res = "";
        $criteria = new CDbCriteria;
        $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
        $model = BSRencanaOperasiT::model()->find($criteria);
        return $model['statusoperasi'];
    }

    /**
     * Load data / cek data monitoring berdasarkan data anestesi
     * @param integer $pasienanastesi_id
     * return array
     */
    public function getMonitoringIntraAnastesi($pasienanastesi_id) {
        $criteria = new CDbCriteria;
        $criteria->select = 'pasienanastesi_id';
        $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
        $model = ATMonitoringintraanastesiT::model()->find($criteria);
        return !empty($model)?$model->pasienanastesi_id:null;
    }

    /**
     * Digunakan untuk mendapatkan status pasien
     * @param type $status
     * @param type $id
     * @param type $pasienmasukpenunjang_id
     * @return string
     */
    public function getStatusAnastesi($status, $id, $pasienmasukpenunjang_id) {
        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $selisih_periksa = 0;
        $selisih = time() - strtotime($pasienmasukpenunjang->tglmasukpenunjang);

        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id' => $id,
            'pasienbatalpulang_id' => null,
//                    'kondisikeluar_id'=>Params::KONDISIKELUAR_ID_RAWATINAP,
        ));


        if (!empty($pulang)) {
            $format = new MyFormatter();
            $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
            $selisih = time() - strtotime($tgl_pulang);
        }

        if ($selisih < 60) {
            $selisih = $selisih . "d";
        } else if ($selisih < 3600) {
            $selisih = floor($selisih / 60) . "m";
        } else if ($selisih < (3600 * 24)) {
            $selisih = floor($selisih / 3600) . "j";
        } else {
            $selisih = floor($selisih / (3600 * 24)) . "h";
        }

        if (empty($pasienmasukpenunjang->pasienkirimkeunitlain_id)) {
            $selisih_periksa = time() - strtotime($pasienmasukpenunjang->waktumulaiperiksa);
            // untuk periksa pasien
            if ($selisih_periksa < 60) {
                $selisih_periksa = $selisih_periksa . "d";
            } else if ($selisih_periksa < 3600) {
                $selisih_periksa = floor($selisih_periksa / 60) . "m";
            } else if ($selisih_periksa < (3600 * 24)) {
                $selisih_periksa = floor($selisih_periksa / 3600) . "j";
            } else {
                $selisih_periksa = floor($selisih_periksa / (3600 * 24)) . "h";
            }
            // end 
        } else {
            $selisih_periksa = time() - strtotime($pendaftaran->waktumulaiperiksa);
            // untuk periksa pasien di ambil dari pendaftaran_t karena pasien rujukan dari modul lain
            if ($selisih_periksa < 60) {
                $selisih_periksa = $selisih_periksa . "d";
            } else if ($selisih_periksa < 3600) {
                $selisih_periksa = floor($selisih_periksa / 60) . "m";
            } else if ($selisih_periksa < (3600 * 24)) {
                $selisih_periksa = floor($selisih_periksa / 3600) . "j";
            } else {
                $selisih_periksa = floor($selisih_periksa / (3600 * 24)) . "h";
            }
            // end        
        }


        $status = $pasienmasukpenunjang->statusperiksa;


        $status = trim($status);
        if ($status == Params::STATUSPERIKSA_SEDANG_PERIKSA) {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih_periksa . '</span>';
            $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_ANTRIAN) {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $id));
            $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24)) . "h";
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else if ($status == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO || $status == "MENUNGGU ADMISI PASIEN") {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
            $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">' . $status . '</button>';
            $status = '<div class="button-status">' . $badge . $status . '</div>';
        } else {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">' . $status . '</button>';
        }
        return $status;
    }

}
