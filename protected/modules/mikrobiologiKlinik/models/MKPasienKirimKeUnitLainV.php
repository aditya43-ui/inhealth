<?php

/**
 * digunakan untuk mengakses view pasienkirimkeunitlain_v pada modul mikrobiologi klinik
 * RSST-5079
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class MKPasienKirimKeUnitLainV extends PasienkirimkeunitlainV {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienkirimkeunitlainV the static model class
     */
    public $permintaankepenunjang_id, $pemeriksaanlab_id, $pemeriksaanlab_nama, $daftartindakanlab_id, $pemeriksaanrad_id,
            $pemeriksaanrad_nama, $daftartindakanrad_id, $qtypermintaan, $noperminatanpenujang, $tglpermintaankepenunjang, $umur;
    public $tgl_awal, $tgl_akhir;
    public $cbTglMasuk = 0;
    public $statusperiksa;
    public $samplelab_nama;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Load data pasien labolatorium
     * @return \CActiveDataProvider
     */
    public function searchPasienLAB() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pasienkirimkeunitlain_id)) {
            $criteria->addCondition('pasienkirimkeunitlain_id = ' . $this->pasienkirimkeunitlain_id);
        }
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('LOWER(tgl_kirimpasien)', strtolower($this->tgl_kirimpasien), true);
        $criteria->compare('LOWER(nourut)', strtolower($this->nourut), true);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        if (!empty($this->jeniskasuspenyakit_id)) {
            $criteria->addCondition('jeniskasuspenyakit_id = ' . $this->jeniskasuspenyakit_id);
        }
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
//		if(!empty($this->pegawai_id)){
//			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
//		}
        if (!empty($this->pegawai_id)) {
            if (is_array($this->pegawai_id)) {
                $criteria->addInCondition(" t.pegawai_id ", $this->pegawai_id);
            } else {
                $criteria->addCondition(" t.pegawai_id = '" . $this->pegawai_id . "' ");
            }
        }
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        if (!empty($this->gelarbelakang_id)) {
            $criteria->addCondition('gelarbelakang_id = ' . $this->gelarbelakang_id);
        }
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(catatandokterpengirim)', strtolower($this->catatandokterpengirim), true);
        if (!empty($this->ruanganasal_id)) {
            $criteria->addCondition('ruanganasal_id = ' . $this->ruanganasal_id);
        }
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        if (!empty($this->instalasiasal_id)) {
            $criteria->addCondition('instalasiasal_id = ' . $this->instalasiasal_id);
        }
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        if (!empty($this->pasienmasukpenunjang_id)) {
            $criteria->addCondition('pasienmasukpenunjang_id = ' . $this->pasienmasukpenunjang_id);
        }
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        if (!empty($this->permintaankepenunjang_id)) {
            $criteria->addCondition('permintaankepenunjang_id = ' . $this->permintaankepenunjang_id);
        }
        if (!empty($this->pemeriksaanlab_id)) {
            $criteria->addCondition('pemeriksaanlab_id = ' . $this->pemeriksaanlab_id);
        }
        $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($this->pemeriksaanlab_nama), true);
        if (!empty($this->daftartindakanlab_id)) {
            $criteria->addCondition('daftartindakanlab_id = ' . $this->daftartindakanlab_id);
        }
        if (!empty($this->pemeriksaanrad_id)) {
            $criteria->addCondition('pemeriksaanrad_id = ' . $this->pemeriksaanrad_id);
        }
        $criteria->compare('LOWER(pemeriksaanrad_nama)', strtolower($this->pemeriksaanrad_nama), true);
        if (!empty($this->daftartindakanrad_id)) {
            $criteria->addCondition('daftartindakanrad_id = ' . $this->daftartindakanrad_id);
        }
        $criteria->compare('qtypermintaan', $this->qtypermintaan);
        $criteria->compare('LOWER(noperminatanpenujang)', strtolower($this->noperminatanpenujang), true);
        $criteria->compare('LOWER(tglpermintaankepenunjang)', strtolower($this->tglpermintaankepenunjang), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Search data rujukan
     * @return \CActiveDataProvider
     */
    public function searchPasienRujukan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if ($this->isPilihTglRencana == 1){
            if (!empty($this->tgl_rencana_awal) && !empty($this->tgl_rencana_akhir)) {
                $criteria->addBetweenCondition('t.tglrencanapemeriksaan::date', $this->tgl_rencana_awal, $this->tgl_rencana_akhir);
            }
        }else{
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
            }
        }

        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);

        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->prefix_pendaftaran . $this->no_pendaftaran), true);

        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('t.carabayar_id = ' . $this->carabayar_id);
        }
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('t.penjamin_id = ' . $this->penjamin_id);
        }

        if (!empty($this->pegawai_id)) {
            if (is_array($this->pegawai_id)) {
                $criteria->addInCondition(" t.pegawai_id ", $this->pegawai_id);
            } else {
                $criteria->addCondition(" t.pegawai_id = '" . $this->pegawai_id . "' ");
            }
        }

        if (!empty($this->ruanganasal_id)) {
            $criteria->addCondition('t.ruanganasal_id = ' . $this->ruanganasal_id);
        }

        if (!empty($this->instalasiasal_id)) {
            $criteria->addCondition('t.instalasiasal_id = ' . $this->instalasiasal_id);
        }


        $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));

        $criteria->addCondition('t.instalasi_id = ' . Yii::app()->user->getState('instalasi_id')); // INSTALASI Mikrobiolog KLINIK

        $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                . "left join kirimspesimenlab_t k ON k.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id "
                . "left join samplelab_m s on s.samplelab_id = k.samplelab_id";
//        $criteria->join = "left join kirimspesimenlab_t k ON k.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id";
        $criteria->addCondition('p.pasienbatalperiksa_id is null');
        $criteria->select = " t.*,  p.statusperiksa, s.samplelab_nama";
        if (!empty($this->statusperiksa)) {
            $criteria->addCondition(" p.statusperiksa ilike '" . strtolower($this->statusperiksa) . "' ");
        }
        if(!empty($this->samplelab_nama)){
            $criteria->compare('LOWER(s.samplelab_nama)', strtolower($this->samplelab_nama), true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menampilkan dialog kunjungan
     */
    public function searchDialogKunjungan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        if (!empty($this->carabayar_id)) {
            $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
        }
        if (!empty($this->penjamin_id)) {
            $criteria->addCondition('penjamin_id = ' . $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(nama_pegawai)', ($this->nama_pegawai));
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Load status rujukan pasien
     * @param string $status
     * @param integer $id
     * @param integer $pasienkirimkeunitlain_id
     * @return string
     */
    function getStatusRujukan($status, $id, $pasienkirimkeunitlain_id) {
        $pasienkirimkeunitlain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

        $selisih = time() - strtotime($pasienkirimkeunitlain->tgl_kirimpasien);

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
        $status = trim($status);
        if ($status == Params::STATUSPERIKSA_SEDANG_PERIKSA) {
            $badge = '<span class="badge badge-info pull-right badge-status">' . $selisih . '</span>';
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
    
    /**
     * Cek sudah ada penilaian spesimen atau belum
     * @return boolean
     */
    public static function PenilaianSpesimen($pasienkirimkeunitlain_id){
        $model = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
        if(!empty($model->penilaian_kelayakan_spesimen_id)){
            return true;
        }else{
            return false;
        }
    }

}
