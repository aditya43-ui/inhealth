<?php

/**
 * This is the model class for table "laporanoperasipasien_t".
 *
 * The followings are the available columns in table 'laporanoperasipasien_t':
 * @property integer $laporanoperasipasien_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property string $tanggal_operasi
 * @property string $jam_mulaioperasi
 * @property string $jam_selesaioperasi
 * @property string $lamaoperasi
 * @property string $laporanoperasi
 * @property string $tanggalpengisian_laporanop
 * @property integer $dokterbedah_pengisilaporan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 */
class LaporanoperasipasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanoperasipasienT the static model class
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
		return 'laporanoperasipasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, dokterbedah_pengisilaporan_id', 'required'),			
			array('lamaoperasi', 'length', 'max'=>50),
			array('laporanpascaoperasi, tanggal_operasi, jam_mulaioperasi, jam_selesaioperasi, laporanoperasi, tanggalpengisian_laporanop, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('laporanoperasipasien_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, tanggal_operasi, jam_mulaioperasi, jam_selesaioperasi, lamaoperasi, laporanoperasi, tanggalpengisian_laporanop, dokterbedah_pengisilaporan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
            'dokterbedahPengisilaporan' => array(self::BELONGS_TO, 'PegawaiM', 'dokterbedah_pengisilaporan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'laporanoperasipasien_id' => 'Laporan Operasi Pasien',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'rencanaoperasi_id' => 'Rencana Operasi',
			'tanggal_operasi' => 'Tanggal Operasi',
			'jam_mulaioperasi' => 'Jam Mulaioperasi',
			'jam_selesaioperasi' => 'Jam Selesai Operasi',
			'lamaoperasi' => 'Lama Operasi',
			'laporanoperasi' => 'Laporan Operasi',
			'tanggalpengisian_laporanop' => 'Tanggal Laporan',
			'dokterbedah_pengisilaporan_id' => 'Ahli Bedah',
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
   



	public function searchDataLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->laporanoperasipasien_id)){
			$criteria->addCondition('laporanoperasipasien_id = '.$this->laporanoperasipasien_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->rencanaoperasi_id)){
			$criteria->addCondition('rencanaoperasi_id = '.$this->rencanaoperasi_id);
		}
		$criteria->compare('LOWER(tanggal_operasi)',strtolower($this->tanggal_operasi),true);
		$criteria->compare('LOWER(jam_mulaioperasi)',strtolower($this->jam_mulaioperasi),true);
		$criteria->compare('LOWER(jam_selesaioperasi)',strtolower($this->jam_selesaioperasi),true);
		$criteria->compare('LOWER(lamaoperasi)',strtolower($this->lamaoperasi),true);
		$criteria->compare('LOWER(laporanoperasi)',strtolower($this->laporanoperasi),true);
		$criteria->compare('LOWER(tanggalpengisian_laporanop)',strtolower($this->tanggalpengisian_laporanop),true);
		if(!empty($this->dokterbedah_pengisilaporan_id)){
			$criteria->addCondition('dokterbedah_pengisilaporan_id = '.$this->dokterbedah_pengisilaporan_id);
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
		$criteria->order = 'pasienmasukpenunjang_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
	));

	}


	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->laporanoperasipasien_id)){
			$criteria->addCondition('laporanoperasipasien_id = '.$this->laporanoperasipasien_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->rencanaoperasi_id)){
			$criteria->addCondition('rencanaoperasi_id = '.$this->rencanaoperasi_id);
		}
		$criteria->compare('LOWER(tanggal_operasi)',strtolower($this->tanggal_operasi),true);
		$criteria->compare('LOWER(jam_mulaioperasi)',strtolower($this->jam_mulaioperasi),true);
		$criteria->compare('LOWER(jam_selesaioperasi)',strtolower($this->jam_selesaioperasi),true);
		$criteria->compare('LOWER(lamaoperasi)',strtolower($this->lamaoperasi),true);
		$criteria->compare('LOWER(laporanoperasi)',strtolower($this->laporanoperasi),true);
		$criteria->compare('LOWER(tanggalpengisian_laporanop)',strtolower($this->tanggalpengisian_laporanop),true);
		if(!empty($this->dokterbedah_pengisilaporan_id)){
			$criteria->addCondition('dokterbedah_pengisilaporan_id = '.$this->dokterbedah_pengisilaporan_id);
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
