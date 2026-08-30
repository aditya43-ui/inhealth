<?php

/**
 * This is the model class for table "obatmonitoringhd_t".
 *
 * The followings are the available columns in table 'obatmonitoringhd_t':
 * @property integer $obatmonitoringhd_id
 * @property integer $obatalkespasien_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $jam_pemberian
 * @property integer $obatalkes_id
 * @property double $obat_dosis
 * @property double $obat_jumlah
 * @property integer $pegawaipemberi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ObatalkespasienT $obatalkespasien
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property ObatalkesM $obatalkes
 * @property PegawaiM $pegawaipemberi
 */
class ObatmonitoringhdT extends CActiveRecord
{
    public $pegawaipemberi_nama, $obatalkes_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatmonitoringhdT the static model class
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
		return 'obatmonitoringhd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, pasien_id, pendaftaran_id', 'required'),
			array('obatalkespasien_id, pasien_id, pendaftaran_id, pasienadmisi_id, obatalkes_id, pegawaipemberi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('obat_dosis, obat_jumlah', 'numerical'),
			array('obatalkespasien_id, jam_pemberian, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatmonitoringhd_id, obatalkespasien_id, pasien_id, pendaftaran_id, pasienadmisi_id, jam_pemberian, obatalkes_id, obat_dosis, obat_jumlah, pegawaipemberi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'obatalkespasien' => array(self::BELONGS_TO, 'ObatalkespasienT', 'obatalkespasien_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'pegawaipemberi' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipemberi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatmonitoringhd_id' => 'Obatmonitoringhd',
			'obatalkespasien_id' => 'Obatalkespasien',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'jam_pemberian' => 'Jam',
			'obatalkes_id' => 'Nama Obat',
			'obat_dosis' => 'Dosis',
			'obat_jumlah' => 'Jumlah',
			'pegawaipemberi_id' => 'Nama Pemberi Obat',
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

		if(!empty($this->obatmonitoringhd_id)){
			$criteria->addCondition('obatmonitoringhd_id = '.$this->obatmonitoringhd_id);
		}
		if(!empty($this->obatalkespasien_id)){
			$criteria->addCondition('obatalkespasien_id = '.$this->obatalkespasien_id);
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
		$criteria->compare('LOWER(jam_pemberian)',strtolower($this->jam_pemberian),true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('obat_dosis',$this->obat_dosis);
		$criteria->compare('obat_jumlah',$this->obat_jumlah);
		if(!empty($this->pegawaipemberi_id)){
			$criteria->addCondition('pegawaipemberi_id = '.$this->pegawaipemberi_id);
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