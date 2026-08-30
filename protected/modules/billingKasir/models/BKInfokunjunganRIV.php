<?php

/**
 * This is the model class for table "infokunjunganri_v".
 *
 * The followings are the available columns in table 'infokunjunganri_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekeriaan_id
 * @property string $pekeriaan_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 */
class BKInfokunjunganRIV extends InfokunjunganriV
{
    public $kelastanggungan_nama;
    public $kelastanggungan_id;
    public $pake_tanggal;
    public $tgl_awal_admisi;
    public $tgl_akhir_admisi;
    public $tglselesaiperiksa;
    
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRI()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addCondition('t.tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
        }
        
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition('t.rujukan_id = '.$this->rujukan_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPasienMelarikanDiri() {
        $prop = $this->searchRI();
        $prop->criteria->join = 'join pasienpulang_t p on p.pendaftaran_id = t.pendaftaran_id and p.pasienadmisi_id is not null '
                . 'join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id';
        $prop->criteria->compare('p.carakeluar_id', Params::CARAKELUAR_ID_MELARIKANDIRI);
        
        if ($this->pake_tanggal) {
            $prop->criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal_admisi,$this->tgl_akhir_admisi);	       
        }

        if (!empty($this->pegawai_id)) {
            $peg_id = $this->pegawai_id;
            $prop->criteria->addCondition("(t.pegawai_id = ${peg_id} or a.dpjp2_id = ${peg_id} or a.dpjp3_id = ${peg_id})");
        }
        
        if(!empty($this->kelaspelayanan_id)){
            $prop->criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
        }
        $prop->criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        if(!empty($this->propinsi_id)){
            $prop->criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
        }
        
        $prop->criteria->compare('pa.kamarruangan_id', $this->kamarruangan_id);
        
        $tb = "case when n.total_belum is null then 0 else n.total_belum end";
        $tt = "case when n.total_tindakan is null then 0 else n.total_tindakan end";
        $ob = "case when o.total_oa_belum is null then 0 else o.total_oa_belum end";
        $ot = "case when o.total_oa is null then 0 else o.total_oa end";

        $prop->criteria->select = "t.*, ap.kelastanggunganasuransi_id as kelastanggungan_id, "
                . "kt.kelaspelayanan_nama as kelastanggungan_nama, "
                . "${tb} as total_belum,
                    ${tt} as total_tindakan,
                    ${ob} as total_oa_belum,
                    ${ot} as total_oa";

        $prop->criteria->join .= "
        left join pasienadmisi_t pa on pa.pendaftaran_id = t.pendaftaran_id 
        left join pendaftaran_t pd on pd.pendaftaran_id = t.pendaftaran_id 
        left join asuransipasien_m ap on ap.asuransipasien_id = pd.asuransipasien_id 
        left join kelaspelayanan_m kt on kt.kelaspelayanan_id = ap.kelastanggunganasuransi_id

        left join 
        (select 
        p.pendaftaran_id, 
        sum(case when p.tindakansudahbayar_id is null then 1 else 0 end) as total_belum,
        count(p.tindakanpelayanan_id) as total_tindakan

        from tindakanpelayanan_t p
        group by p.pendaftaran_id
        ) n on n.pendaftaran_id = t.pendaftaran_id

        left join 
        (select 
        p.pendaftaran_id, 
        sum(case when p.oasudahbayar_id is null then 1 else 0 end) as total_oa_belum,
        count(p.obatalkespasien_id) as total_oa

        from obatalkespasien_t p
        group by p.pendaftaran_id
        ) o on o.pendaftaran_id = t.pendaftaran_id
        ";

        $prop->criteria->compare('ap.kelastanggunganasuransi_id',$this->kelastanggungan_id);   
        
        $prop->criteria->addCondition("(
            (case when n.total_belum is null then 0 else n.total_belum end) <> 0
            or 
            (case when o.total_oa_belum is null then 0 else o.total_oa_belum end) <> 0
            )");
        
        
        return $prop;
    }
}