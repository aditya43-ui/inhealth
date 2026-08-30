<?php

/**
 * This is the model class for table "infokunjunganriglobal_v".
 *
 * The followings are the available columns in table 'infokunjunganriglobal_v':
 * @property string $tgladmisi
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $kelurahan_nama
 * @property string $kecamatan_nama
 * @property string $kabupaten_nama
 * @property string $propinsi_nama
 * @property string $no_mobile_pasien
 * @property string $suku_nama
 * @property string $statusperkawinan
 * @property string $warga_negara
 * @property string $agama
 * @property string $pendidikan_nama
 * @property string $pekerjaan_nama
 * @property string $no_identitas_pasien
 * @property string $tanggal_lahir
 * @property string $umur_tahun
 * @property string $umur_bulan
 * @property string $umur_hari
 * @property string $golonganumur_nama
 * @property string $kelompokumur_nama
 * @property string $nama_ayah
 * @property string $nama_ibu
 * @property string $sistem
 * @property string $kunjungan
 * @property string $no_pendaftaran
 * @property string $nama_pegawailoket
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property string $kelastanggungan_nama
 * @property string $caramasuk_nama
 * @property string $diagnosamasuk
 * @property string $keluhan
 * @property string $icd_masuk
 * @property string $diagnosa_masuk
 * @property string $riwayatimunisasi
 * @property string $tekanandarah
 * @property string $golongandarah
 * @property double $tinggibadan_cm
 * @property double $beratbadan_kg
 * @property string $nama_pegawaiverif
 * @property string $icd_utama
 * @property string $diagnosa_utama
 * @property string $dtd_nama
 * @property string $icd_komplikasi
 * @property string $icd_tindakanutama
 * @property string $tindakanutama
 * @property string $icd_tindakanlain
 * @property string $tindakanlain
 * @property string $kodedokter
 * @property string $nama_pegawai
 * @property string $spesialissubspesialis_nama
 * @property string $kasus
 * @property string $icd_utama_dpjp
 * @property string $diagnosa_utama_dpjp
 * @property string $dtd_dpjp_nama
 * @property string $icd_komplikasi_dpjp
 * @property string $petugasrawatinap
 * @property string $kodespesialis
 * @property string $lamarawat
 * @property string $carakeluar_nama
 * @property string $tglpulang
 * @property string $asalrujukan_nama
 * @property string $tanggal_rujukan
 * @property string $no_rujukan
 * @property string $alamatrujukan
 * @property string $tgldiet
 * @property string $tgloperasi
 * @property string $jenisoperasi
 * @property string $tirahbaring
 * @property string $pulangmati
 * @property string $tglmati
 * @property string $icdmati
 * @property string $sebabmati
 * @property string $aa
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $namadepan
 * @property string $nama_bin
 * @property string $nama_pj
 * @property string $nama_perujuk
 * @property string $jeniskasuspenyakit_nama
 * @property string $instalasi_nama
 * @property string $gelardepan
 * @property string $gelarbelakang_nama
 * @property string $keterangankeluar
 * @property string $statusperiksa
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $tempat_lahir
 * @property integer $rt
 * @property integer $rw
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property integer $kabupaten_id
 * @property integer $kelurahan_id
 * @property integer $kecamatan_id
 * @property integer $pekerjaan_id
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $caramasuk_id
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $kelaspelayanan_id
 * @property integer $pasienadmisi_id
 * @property boolean $statuskeluar
 * @property boolean $rawatgabung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $kelompokumur_id
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property integer $pegawai_id
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property integer $suku_id
 * @property integer $pendidikan_id
 * @property string $nopeserta
 * @property string $tglcetakkartuasuransi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property boolean $asuransipasien_aktif
 * @property string $keterangan_pendaftaran
 * @property integer $kelompokpegawai_id
 * @property integer $masukkamar_id
 * @property string $tglmasukkamar
 */
class PPInfokunjunganriglobalV extends InfokunjunganriglobalV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir, $pilihanPeriode, $carakeluar_id;

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchTable() {
        $criteria = new CDbCriteria();
        if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
			}
		}
		
		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
			}else{
				$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
			}
		}
		
		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
			}
		}
		if(!empty($this->pilihanPeriode)) {
			if($this->pilihanPeriode == '1') {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			} else if($this->pilihanPeriode == '2') {
				$criteria->addBetweenCondition('DATE(t.tglpulang)', $this->tgl_awal, $this->tgl_akhir);
			} else {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			}
		} else {
			$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
		}

		if(!empty($this->carakeluar_id)) {
			$criteria->addCondition("t.carakeluar_id =".$this->carakeluar_id);
		}

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
        
    }

    public function searchPrint() {
        $criteria = new CDbCriteria();
        if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
			}
		}
		
		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
			}else{
				$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
			}
		}
		
		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
			}
		}

		if(!empty($this->pilihanPeriode)) {
			if($this->pilihanPeriode == '1') {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			} else if($this->pilihanPeriode == '2') {
				$criteria->addBetweenCondition('DATE(t.tglpulang)', $this->tgl_awal, $this->tgl_akhir);
			} else {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			}
		} else {
			$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
		}

		if(!empty($this->carakeluar_id)) {
			$criteria->addCondition("t.carakeluar_id =".$this->carakeluar_id);
		}

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'pagination' => false
        ));
        
    }

    
}