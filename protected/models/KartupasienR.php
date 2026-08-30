<?php

/**
 * This is the model class for table "kartupasien_r".
 *
 * The followings are the available columns in table 'kartupasien_r':
 * @property serial $kartupasien_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property date $tglprintkartu
 * @property boolean $statusprintkartu
 * @property text $keteranganprintkartu
 * @property date $create_time
 * @property date $update_time
 * @property bigint $create_loginpemakai_id
 * @property bigint $update_loginpemakai_id
 */
class KartupasienR extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $rt;
        public $rw;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiantrianpasienV the static model class
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
		return 'kartupasien_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('keteranganprint', 'length', 'max'=>200),
			array('rt, rw, tglprintkartu, pasien_id, statusprintkartu', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kartupasien_id' => 'Kartu Pasien',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'No. Pendaftaran',
			'tglprintkartu' => 'Tanggal Print Kartu',
			'statusprintkartu' => 'Status Print',
			'keteranganprint' => 'Keterangan Print',
			'create_time' => 'Tanggal Print',
			'update_time' => 'Tanggal Update',
			'create_loginpemakai_id' => 'Tanggal Login Id',
			'update_loginpemakai_id' => 'Tanggal Update Login Id',
                        'rt' => 'RT',
                        'rw' => 'RW'
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

        $criteria->addBetweenCondition('tglprintkartu', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('kartupasien_id',$this->kartupasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tglprintkartu',$this->tglprintkartu);
		$criteria->compare('statusprintkartu',$this->statusprintkartu);
		$criteria->compare('keteranganprint',$this->keteranganprint);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        // $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),true);
        // $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat_pasien),true);
        // $criteria->compare('LOWER(pasien.rt)',  $this->rt);
        // $criteria->compare('LOWER(pasien.rw)',  $this->rw);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
    public function searchPrint()
    {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

        $criteria=new CDbCriteria;

		$criteria->compare('kartupasien_id',$this->kartupasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tglprintkartu',$this->tglprintkartu);
		$criteria->compare('statusprintkartu',$this->statusprintkartu);
		$criteria->compare('keteranganprint',$this->keteranganprint);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->namaPasien),true);
        $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamatPasien),true);
        $criteria->compare('LOWER(pasien.rt)',  $this->rt);
        $criteria->compare('LOWER(pasien.rw)',  $this->rw);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
        
    public function primaryKey() {
        return 'kartupasien_id';
    }
}