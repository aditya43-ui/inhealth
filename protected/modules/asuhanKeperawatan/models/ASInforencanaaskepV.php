<?php

/**
 * This is the model class for table "inforencanaaskep_v".
 *
 */
class ASInforencanaaskepV extends InforencanaaskepV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id, $implementasiaskep_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InforencanaaskepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanaaskep_id' => 'Rencanaaskep',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'no_rencana' => 'No Rencana',
			'rencanaaskep_tgl' => 'Rencanaaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_pengkajian' => 'No Pengkajian',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'nama_pasien' => 'Nama Pasien',
			'nama_pegawai' => 'Nama Pegawai',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'umur' => 'Umur',
			'statusperkawinan' => 'Statusperkawinan',
			'jeniskelamin' => 'Jenis Kelamin',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_nama' => 'Pendidikan Nama',
			'agama' => 'Agama',
			'alamat_pasien' => 'Alamat Pasien',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'diagnosa_nama' => 'Diagnosa Nama',
			'nama_pj' => 'Nama Pj',
			'no_identitas' => 'No Identitas',
			'tgllahir_pj' => 'Tgllahir Pj',
			'no_teleponpj' => 'No Teleponpj',
			'no_mobilepj' => 'No Mobilepj',
			'hubungankeluarga' => 'Hubungankeluarga',
			'alamat_pj' => 'Alamat Pj',
			'jk' => 'Jk',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'iskeperawatan' => 'Iskeperawatan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                // $criteria->select = "t.rencanaaskep_id, t.no_rencana, t.rencanaaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama, Implementasiaskep_t.implementasiaskep_id";
                // $criteria->join = " LEFT JOIN Implementasiaskep_t ON Implementasiaskep_t.rencanaaskep_id = t.rencanaaskep_id";
				$criteria->group = "t.rencanaaskep_id, t.no_rencana, t.rencanaaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama, Implementasiaskep_t.implementasiaskep_id";
				$criteria->select = $criteria->group;
                $criteria->join = " LEFT JOIN Implementasiaskep_t ON Implementasiaskep_t.rencanaaskep_id = t.rencanaaskep_id";
		$criteria->compare('t.rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('t.pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.no_rencana',$this->no_rencana,true);
		$criteria->addBetweenCondition('DATE(t.rencanaaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan,true);
		$criteria->compare('t.no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('t.pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('t.ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('t.kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('t.nama_pasien',$this->nama_pasien,true);
		$criteria->compare('t.nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('t.no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('t.tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('t.no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('t.umur',$this->umur,true);
		$criteria->compare('t.statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('t.jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('t.pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('t.pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('t.agama',$this->agama,true);
		$criteria->compare('t.alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('t.kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('t.kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('t.diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('t.nama_pj',$this->nama_pj,true);
		$criteria->compare('t.no_identitas',$this->no_identitas,true);
		$criteria->compare('t.tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('t.no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('t.no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('t.hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('t.alamat_pj',$this->alamat_pj,true);
		$criteria->compare('t.jk',$this->jk,true);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.iskeperawatan',$this->iskeperawatan);
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>[
                        'defaultOrder'=>'rencanaaskep_tgl DESC'
                    ]
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(no_rencana)',strtolower($this->no_rencana),true);
		if(!empty($this->rencanaaskep_tgl)){
                    $rencanaaskep_tgl = $this->getKonverviDateRange($this->rencanaaskep_tgl);
                    $criteria->addBetweenCondition('DATE(rencanaaskep_tgl)', $rencanaaskep_tgl[0]." 00:00:00", $rencanaaskep_tgl[1]." 23:59:59");
//			$criteria->addCondition("DATE(rencanaaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->rencanaaskep_tgl) . "'");
		}
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('iskeperawatan',$this->iskeperawatan);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
                        'sort'=>[
                            'defaultOrder'=>'rencanaaskep_tgl DESC'
                        ]
                    
		));
	}
	
	public function getNoKamar($pendaftaran_id) {
		$no_kamar = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nokamar
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

	public function getNoBed($pendaftaran_id) {
		
		$no_bed = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nobed
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

	public function getKelasPelayanan($pendaftaran_id) {

		$pelayanan = '-';
		if (!empty($pendaftaran_id)) {
			$kelas = KelaspelayananM::model()->findBySql('
			SELECT kelaspelayanan_m.kelaspelayanan_nama
			FROM kelaspelayanan_m
			JOIN masukkamar_t ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (!empty($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (!empty	($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
        
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
}