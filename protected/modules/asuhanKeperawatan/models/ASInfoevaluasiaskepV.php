<?php

/**
 * This is the model class for table "inforencanaaskep_v".
 *
 */
class ASInfoevaluasiaskepV extends InfoevaluasiaskepV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id, $verifikasiaskep_id;
        public $load_all;
        public $rencanaaskep_id;
        public $evaluasiaskepdet_subjektif, $evaluasiaskepdet_objektif,$evaluasiaskepdet_assessment,
               $evaluasiaskepdet_planning, $evaluasiaskepdet_implementasi;
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
			'evaluasiaskep_id' => 'Evaluasiaskep',
			'pegawai_id' => 'Pegawai',
			'implementasiaskep_id' => 'Implementasiaskep',
			'ruangan_id' => 'Ruangan',
			'no_evaluasi' => 'No. Evaluasi',
			'evaluasiaskep_tgl' => 'Evaluasiaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_implementasi' => 'No Implementasi',
			'implementasiaskep_tgl' => 'Implementasiaskep Tgl',
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
                // $criteria->select = "t.evaluasiaskep_id, t.no_evaluasi, t.evaluasiaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama, verifikasiaskep_t.verifikasiaskep_id";
                // $criteria->join = " LEFT JOIN verifikasiaskep_t ON verifikasiaskep_t.evaluasiaskep_id = t.evaluasiaskep_id";
				$criteria->group = "t.evaluasiaskep_id, t.no_evaluasi, t.evaluasiaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama";
				$criteria->select = $criteria->group;
                $criteria->join = " LEFT JOIN verifikasiaskep_t ON verifikasiaskep_t.evaluasiaskep_id = t.evaluasiaskep_id";
		$criteria->compare('evaluasiaskep_id',$this->evaluasiaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_evaluasi',$this->no_evaluasi,true);
		$criteria->addBetweenCondition('DATE(evaluasiaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_implementasi',$this->no_implementasi,true);
		$criteria->compare('implementasiaskep_tgl',$this->implementasiaskep_tgl,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>[
                            'defaultOrder'=>'evaluasiaskep_tgl DESC'
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
		if (!empty($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
        
        public function search_riwayat_evaluasi_by_rencana(){
            $cri = new CDbCriteria();
            $cri->select = "
                        t.evaluasiaskep_tgl,
                        evaldet.evaluasiaskepdet_subjektif,
                        evaldet.evaluasiaskepdet_objektif,
                        evaldet.evaluasiaskepdet_assessment,
                        evaldet.evaluasiaskepdet_planning,
                        evaldet.evaluasiaskepdet_implementasi,
                        t.nama_pegawai
                    ";
            $cri->join = " 
                    JOIN evaluasiaskepdet_t evaldet ON evaldet.evaluasiaskep_id = t.evaluasiaskep_id 
                    JOIN implementasiaskep_t imp ON imp.implementasiaskep_id = t.implementasiaskep_id 
                   
            ";
            if (!empty($this->rencanaaskep_id)){
                $cri->addCondition(" imp.rencanaaskep_id = ".$this->rencanaaskep_id);
            }else{
                $cri->addCondition(" t.evaluasiaskep_id IS NULL ");
            }
            $cri->order = " t.evaluasiaskep_tgl ASC ";
            $model = self::model()->findAll($cri);
            
            $data = [];
            $init = 1;
            foreach($model as $i => $det){
                $no = $i+1;
                
                $data = $this->set_evaluasi_riwayat($init, $det, $no, $data);
                $data[$init]['evaluasi'] = 'Subjektif';
                $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_subjektif;               $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_subjektif;
                $init++;
                
                $data = $this->set_evaluasi_riwayat($init, $det, $no, $data);
                $data[$init]['evaluasi'] = 'Objektif';
                $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_objektif;
                $init++;
                
                $data = $this->set_evaluasi_riwayat($init, $det, $no, $data);
                $data[$init]['evaluasi'] = 'Assesment';
                $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_assessment;
                $init++;
                
                $data = $this->set_evaluasi_riwayat($init, $det, $no, $data);
                $data[$init]['evaluasi'] = 'Planning';
                $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_planning;
                $init++;
                
                $data = $this->set_evaluasi_riwayat($init, $det, $no, $data);
                $data[$init]['evaluasi'] = 'Implementasi';
                $data[$init]['evaluasi_hasil'] = $det->evaluasiaskepdet_implementasi;
                $init++;
                
            }
            
            return new CArrayDataProvider($data, array(
                'keyField'=>'nourut',			
                'id'=>'data_laporan',
                'totalItemCount'=>count($data),
                'pagination' => array(
                    'pageSize' => ($this->load_all==true)?count($data):10,
                    'pageVar' => 'page'
                ),			
            ));   
        }
        
        public function set_evaluasi_riwayat($init, $det, $no, $data){
            $data[$init]['nourut'] = $no;
            $data[$init]['evaluasiaskep_tgl'] = MyFormatter::formatDateTimeForUser($det->evaluasiaskep_tgl);
            $data[$init]['nama_pegawai'] = $det->nama_pegawai;
            
            return $data;
        }
}