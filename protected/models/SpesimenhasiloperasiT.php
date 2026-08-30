<?php

/**
 * This is the model class for table "spesimenhasiloperasi_t".
 *
 * The followings are the available columns in table 'spesimenhasiloperasi_t':
 * @property integer $spesimenhasiloperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $jenisspesimen_pa_id
 * @property string $jenisspesimen_pa_lainnya
 * @property integer $teknikpengambilanspesimen_id
 * @property string $lokasipengambilanspesimen
 * @property string $volumespesimen
 * @property string $statuskirim_pa
 * @property string $tujuanpengirimanspesimen_lainnya
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 * @property integer $create_pegawaipengisi_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 */
class SpesimenhasiloperasiT extends CActiveRecord
{
    public $permintaanPeriksa;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpesimenhasiloperasiT the static model class
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
		return 'spesimenhasiloperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, jenisspesimen_pa_id, teknikpengambilanspesimen_id, create_ruangan_id, create_pegawaipengisi_id', 'numerical', 'integerOnly'=>true),
			array('jenisspesimen_pa_lainnya,teknikpengambilanspesimen_lainnya', 'length', 'max'=>300),
			array('lokasipengambilanspesimen, volumespesimen, tujuanpengirimanspesimen_lainnya', 'length', 'max'=>200),
			array('statuskirim_pa', 'length', 'max'=>20),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('kualifikasi_operasi, kualifikasiluka_operasi, indikasi_operasi, create_time, update_time, rencanaoperasi_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('spesimenhasiloperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, jenisspesimen_pa_id, jenisspesimen_pa_lainnya, teknikpengambilanspesimen_id, lokasipengambilanspesimen, volumespesimen, statuskirim_pa, tujuanpengirimanspesimen_lainnya, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id, create_pegawaipengisi_id,teknikpengambilanspesimen_lainnya', 'safe', 'on'=>'search'),
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
                    'teknik' => array(self::BELONGS_TO, 'TeknikpengambilanspesimenM', 'teknikpengambilanspesimen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'spesimenhasiloperasi_id' => 'Spesimenhasiloperasi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'jenisspesimen_pa_id' => 'Jenis Pesimen',
			'jenisspesimen_pa_lainnya' => 'Jenisspesimen Pa Lainnya',
			'teknikpengambilanspesimen_id' => 'Diperoleh Dari hasil',
			'lokasipengambilanspesimen' => 'Lokasi Pengambilan',
			'volumespesimen' => 'Volume',
			'statuskirim_pa' => 'Dikirim untuk Pemeriksaan PA',
			'tujuanpengirimanspesimen_lainnya' => 'Tujuanpengirimanspesimen Lainnya',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'create_pegawaipengisi_id' => 'Create Pegawaipengisi',
                        'kualifikasi_operasi'=>'Kualifikasi Operasi',
                        'kualifikasiluka_operasi'=>'Kualifikasi Luka Operasi',
                        'indikasi_operasi'=>'Indikasi Operasi',
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

		if(!empty($this->spesimenhasiloperasi_id)){
			$criteria->addCondition('spesimenhasiloperasi_id = '.$this->spesimenhasiloperasi_id);
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
		if(!empty($this->jenisspesimen_pa_id)){
			$criteria->addCondition('jenisspesimen_pa_id = '.$this->jenisspesimen_pa_id);
		}
		$criteria->compare('LOWER(jenisspesimen_pa_lainnya)',strtolower($this->jenisspesimen_pa_lainnya),true);
		if(!empty($this->teknikpengambilanspesimen_id)){
			$criteria->addCondition('teknikpengambilanspesimen_id = '.$this->teknikpengambilanspesimen_id);
		}
		$criteria->compare('LOWER(lokasipengambilanspesimen)',strtolower($this->lokasipengambilanspesimen),true);
		$criteria->compare('LOWER(volumespesimen)',strtolower($this->volumespesimen),true);
		$criteria->compare('LOWER(statuskirim_pa)',strtolower($this->statuskirim_pa),true);
		$criteria->compare('LOWER(tujuanpengirimanspesimen_lainnya)',strtolower($this->tujuanpengirimanspesimen_lainnya),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai)',strtolower($this->create_loginpemakai),true);
		$criteria->compare('LOWER(update_loginpemakai)',strtolower($this->update_loginpemakai),true);
		if(!empty($this->create_ruangan_id)){
			$criteria->addCondition('create_ruangan_id = '.$this->create_ruangan_id);
		}
		if(!empty($this->create_pegawaipengisi_id)){
			$criteria->addCondition('create_pegawaipengisi_id = '.$this->create_pegawaipengisi_id);
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
