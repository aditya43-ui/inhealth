<?php

/**
 * This is the model class for table "aldrettepasienruangpulih_t".
 *
 * The followings are the available columns in table 'aldrettepasienruangpulih_t':
 * @property integer $aldrettepasienruangpulih_id
 * @property integer $pasienruangpulih_id
 * @property string $aktivitas_penilaian
 * @property integer $aktivitas_skor
 * @property string $sirkulasi_penilaian
 * @property integer $sirkulasi_skor
 * @property string $pernapasan_penilaian
 * @property integer $pernapasan_skor
 * @property string $kesadaran_penilaian
 * @property integer $kesadaran_skor
 * @property string $warnakulit_penilaian
 * @property integer $warnakulit_skor
 * @property string $jenisaldrette
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienruangpulihT $pasienruangpulih
 */
class AldrettepasienruangpulihT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AldrettepasienruangpulihT the static model class
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
		return 'aldrettepasienruangpulih_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienruangpulih_id, jenisaldrette', 'required'),
			array('pasienruangpulih_id, aktivitas_skor, sirkulasi_skor, pernapasan_skor, kesadaran_skor, warnakulit_skor, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('aktivitas_penilaian, sirkulasi_penilaian, pernapasan_penilaian, kesadaran_penilaian, warnakulit_penilaian, jenisaldrette', 'length', 'max'=>50),
			array('create_loginpemakai_id, update_loginpemakai_id', 'length', 'max'=>100),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('aldrettepasienruangpulih_id, pasienruangpulih_id, aktivitas_penilaian, aktivitas_skor, sirkulasi_penilaian, sirkulasi_skor, pernapasan_penilaian, pernapasan_skor, kesadaran_penilaian, kesadaran_skor, warnakulit_penilaian, warnakulit_skor, jenisaldrette, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienruangpulih' => array(self::BELONGS_TO, 'PasienruangpulihT', 'pasienruangpulih_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aldrettepasienruangpulih_id' => 'Aldrettepasienruangpulih',
			'pasienruangpulih_id' => 'Pasienruangpulih',
			'aktivitas_penilaian' => 'Aktivitas',
			'aktivitas_skor' => 'Aktivitas Skor',
			'sirkulasi_penilaian' => 'Sirkulasi',
			'sirkulasi_skor' => 'Sirkulasi Skor',
			'pernapasan_penilaian' => 'Pernapasan',
			'pernapasan_skor' => 'Pernapasan Skor',
			'kesadaran_penilaian' => 'Kesadaran',
			'kesadaran_skor' => 'Kesadaran Skor',
			'warnakulit_penilaian' => 'Warna Kulit',
			'warnakulit_skor' => 'Warnakulit Skor',
			'jenisaldrette' => 'Jenis',
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

		if(!empty($this->aldrettepasienruangpulih_id)){
			$criteria->addCondition('aldrettepasienruangpulih_id = '.$this->aldrettepasienruangpulih_id);
		}
		if(!empty($this->pasienruangpulih_id)){
			$criteria->addCondition('pasienruangpulih_id = '.$this->pasienruangpulih_id);
		}
		$criteria->compare('LOWER(aktivitas_penilaian)',strtolower($this->aktivitas_penilaian),true);
		if(!empty($this->aktivitas_skor)){
			$criteria->addCondition('aktivitas_skor = '.$this->aktivitas_skor);
		}
		$criteria->compare('LOWER(sirkulasi_penilaian)',strtolower($this->sirkulasi_penilaian),true);
		if(!empty($this->sirkulasi_skor)){
			$criteria->addCondition('sirkulasi_skor = '.$this->sirkulasi_skor);
		}
		$criteria->compare('LOWER(pernapasan_penilaian)',strtolower($this->pernapasan_penilaian),true);
		if(!empty($this->pernapasan_skor)){
			$criteria->addCondition('pernapasan_skor = '.$this->pernapasan_skor);
		}
		$criteria->compare('LOWER(kesadaran_penilaian)',strtolower($this->kesadaran_penilaian),true);
		if(!empty($this->kesadaran_skor)){
			$criteria->addCondition('kesadaran_skor = '.$this->kesadaran_skor);
		}
		$criteria->compare('LOWER(warnakulit_penilaian)',strtolower($this->warnakulit_penilaian),true);
		if(!empty($this->warnakulit_skor)){
			$criteria->addCondition('warnakulit_skor = '.$this->warnakulit_skor);
		}
		$criteria->compare('LOWER(jenisaldrette)',strtolower($this->jenisaldrette),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
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