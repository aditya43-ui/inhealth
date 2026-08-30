<?php

class PIKonsulPoliT extends KonsulpoliT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
	public $instalasi_id;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function getNamaModel(){
        return __CLASS__;
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'konsulpoli_id' => 'Konsulpoli',
			'ruangan_id' => 'Poliklinik Tujuan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter Pemeriksa',
			'tglkonsulpoli' => 'Tanggal Konsul',
			'asalpoliklinikkonsul_id' => 'Poliklinik Asal',
			'statusperiksa' => 'Status Periksa',
			'catatan_dokter_konsul' => 'Permasalahan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'poliasal'=>array(self::BELONGS_TO,'RuanganM','asalpoliklinikkonsul_id'),
                    'politujuan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
					'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}
		/**
         * Mengambil daftar semua ruangan 
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasi()
        {
			return RuanganM::model()->findAll();
        }
		
		public function getRuanganItems($instalasi_id = null) {
		if (!empty($instalasi_id)) {
			return RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama'));
		} else {
			return RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama'));
		}
	}

	/**
	 * menampilkan instalasi untuk pesan menu diet pasien
	 * @return array
	 */
	public function getInstalasiItems() {
		$criteria = new CDbCriteria();
		$criteria->addInCondition('instalasi_id', array(
			Params::INSTALASI_ID_RJ,
			Params::INSTALASI_ID_RD,
//		       Params::INSTALASI_ID_RI
				)
		);
		$criteria->addCondition('instalasi_aktif = true');
		$modInstalasis = InstalasiM::model()->findAll($criteria);
		if (count((array)$modInstalasis) > 0)
			return $modInstalasis;
		else
			return array();
	}
	
	public function getNamaLengkapDokter($pegawai_id)
    {
        $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
        if(!empty($dokter->nama_pegawai)){
            return (isset($dokter->gelardepan) ? $dokter->gelardepan." " : "").$dokter->nama_pegawai.", ".(isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
        }else{
            return "-";
        }
    }

}
?>
