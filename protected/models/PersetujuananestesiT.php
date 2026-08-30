<?php

/**
 * @author Tantowi J <tantowijaya@.com>
 * This is the model class for table "persetujuananestesi_t".
 *
 * The followings are the available columns in table 'persetujuananestesi_t':
 * @property integer $persetujuananestesi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $namapenanggungjawab
 * @property string $umurpenanggungjawab
 * @property string $jeniskelamin_penanggungjawab
 * @property string $jenisidentitas_penanggungjawab
 * @property string $noidentitas_penanggungjawab
 * @property boolean $jnsanestesi_sedasiberatsedang
 * @property boolean $jnsanestesi_umum
 * @property boolean $jnsanestesi_regional_sedasi
 * @property boolean $jnsanestesi_regional_tnpsedasi
 * @property boolean $jnsanestesi_regional_sab
 * @property boolean $jnsanestesi_regional_epidural
 * @property boolean $jnsanestesi_regional_blokperifer
 * @property boolean $jnsanestesi_regional_kombinasi
 * @property boolean $jnsanestesi_kombinasi
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $dokteranestesi_id
 * @property string $hubungan_pembuatpernyataan
 * @property string $nama_pihakkeluarga
 * @property string $noidentitas
 * @property integer $saksipihakrs_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PersetujuananestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersetujuananestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persetujuananestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, dokteranestesi_id, create_time, create_loginpemakai_id', 'required'),
			array('pasienmasukpenunjang_id, pasienkirimkeunitlain_id, pasien_id, pendaftaran_id, dokteranestesi_id, saksipihakrs_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('namapenanggungjawab', 'length', 'max'=>100),
			array('umurpenanggungjawab', 'length', 'max'=>2),
			array('jeniskelamin_penanggungjawab, jenisidentitas_penanggungjawab', 'length', 'max'=>10),
			array('noidentitas_penanggungjawab, hubungan_pembuatpernyataan', 'length', 'max'=>20),
			array('nama_pihakkeluarga', 'length', 'max'=>50),
			array('noidentitas', 'length', 'max'=>25),
			array('doktermenyetujui_id, jnsanestesi_sedasiberatsedang, jnsanestesi_umum, jnsanestesi_regional_sedasi, jnsanestesi_regional_tnpsedasi, jnsanestesi_regional_sab, jnsanestesi_regional_epidural, jnsanestesi_regional_blokperifer, jnsanestesi_regional_kombinasi, jnsanestesi_kombinasi, update_time, alamat_penanggungjawab', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('persetujuananestesi_id, pasienmasukpenunjang_id, namapenanggungjawab, umurpenanggungjawab, jeniskelamin_penanggungjawab, jenisidentitas_penanggungjawab, noidentitas_penanggungjawab, jnsanestesi_sedasiberatsedang, jnsanestesi_umum, jnsanestesi_regional_sedasi, jnsanestesi_regional_tnpsedasi, jnsanestesi_regional_sab, jnsanestesi_regional_epidural, jnsanestesi_regional_blokperifer, jnsanestesi_regional_kombinasi, jnsanestesi_kombinasi, pasien_id, pendaftaran_id, dokteranestesi_id, hubungan_pembuatpernyataan, nama_pihakkeluarga, noidentitas, saksipihakrs_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'dokteranestesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranestesi_id'),
                    'saksipihakrs' => array(self::BELONGS_TO, 'PegawaiM', 'saksipihakrs_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranestesi_id'),
                    'pegawaisaksi' => array(self::BELONGS_TO, 'PegawaiM', 'saksipihakrs_id'),
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persetujuananestesi_id' => 'Persetujuananestesi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'namapenanggungjawab' => 'Namapenanggungjawab',
			'umurpenanggungjawab' => 'Umurpenanggungjawab',
			'jeniskelamin_penanggungjawab' => 'Jeniskelamin Penanggungjawab',
			'jenisidentitas_penanggungjawab' => 'Jenisidentitas Penanggungjawab',
			'noidentitas_penanggungjawab' => 'Noidentitas Penanggungjawab',
			'jnsanestesi_sedasiberatsedang' => 'Jnsanestesi Sedasiberatsedang',
			'jnsanestesi_umum' => 'Jnsanestesi Umum',
			'jnsanestesi_regional_sedasi' => 'Jnsanestesi Regional Sedasi',
			'jnsanestesi_regional_tnpsedasi' => 'Jnsanestesi Regional Tnpsedasi',
			'jnsanestesi_regional_sab' => 'Jnsanestesi Regional Sab',
			'jnsanestesi_regional_epidural' => 'Jnsanestesi Regional Epidural',
			'jnsanestesi_regional_blokperifer' => 'Jnsanestesi Regional Blokperifer',
			'jnsanestesi_regional_kombinasi' => 'Jnsanestesi Regional Kombinasi',
			'jnsanestesi_kombinasi' => 'Jnsanestesi Kombinasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'dokteranestesi_id' => 'Dokteranestesi',
			'hubungan_pembuatpernyataan' => 'Hubungan Pembuatpernyataan',
			'nama_pihakkeluarga' => 'Nama Pihakkeluarga',
			'noidentitas' => 'Noidentitas',
			'saksipihakrs_id' => 'Saksipihakrs',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->persetujuananestesi_id)){
			$criteria->addCondition('persetujuananestesi_id = '.$this->persetujuananestesi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(namapenanggungjawab)',strtolower($this->namapenanggungjawab),true);
		$criteria->compare('LOWER(umurpenanggungjawab)',strtolower($this->umurpenanggungjawab),true);
		$criteria->compare('LOWER(jeniskelamin_penanggungjawab)',strtolower($this->jeniskelamin_penanggungjawab),true);
		$criteria->compare('LOWER(jenisidentitas_penanggungjawab)',strtolower($this->jenisidentitas_penanggungjawab),true);
		$criteria->compare('LOWER(noidentitas_penanggungjawab)',strtolower($this->noidentitas_penanggungjawab),true);
		$criteria->compare('jnsanestesi_sedasiberatsedang',$this->jnsanestesi_sedasiberatsedang);
		$criteria->compare('jnsanestesi_umum',$this->jnsanestesi_umum);
		$criteria->compare('jnsanestesi_regional_sedasi',$this->jnsanestesi_regional_sedasi);
		$criteria->compare('jnsanestesi_regional_tnpsedasi',$this->jnsanestesi_regional_tnpsedasi);
		$criteria->compare('jnsanestesi_regional_sab',$this->jnsanestesi_regional_sab);
		$criteria->compare('jnsanestesi_regional_epidural',$this->jnsanestesi_regional_epidural);
		$criteria->compare('jnsanestesi_regional_blokperifer',$this->jnsanestesi_regional_blokperifer);
		$criteria->compare('jnsanestesi_regional_kombinasi',$this->jnsanestesi_regional_kombinasi);
		$criteria->compare('jnsanestesi_kombinasi',$this->jnsanestesi_kombinasi);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->dokteranestesi_id)){
			$criteria->addCondition('dokteranestesi_id = '.$this->dokteranestesi_id);
		}
		$criteria->compare('LOWER(hubungan_pembuatpernyataan)',strtolower($this->hubungan_pembuatpernyataan),true);
		$criteria->compare('LOWER(nama_pihakkeluarga)',strtolower($this->nama_pihakkeluarga),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		if(!empty($this->saksipihakrs_id)){
			$criteria->addCondition('saksipihakrs_id = '.$this->saksipihakrs_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}