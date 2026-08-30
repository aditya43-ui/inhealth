<?php

/**
 * This is the model class for table "pemeriksaangambar_t".
 *
 * The followings are the available columns in table 'pemeriksaangambar_t':
 * @property integer $pemeriksaangambar_id
 * @property integer $gambartubuh_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $bagiantubuh_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpemeriksaan
 * @property double $kordinat_tubuh_x
 * @property double $kordinat_tubuh_y
 * @property string $keterangan_periksa_gbr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemeriksaangambarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaangambarT the static model class
	 */
	public $namabagtubuh;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaangambar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gambartubuh_id, bagiantubuh_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('gambartubuh_id, pemeriksaanfisik_id, bagiantubuh_id, pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pemeriksaanginekologi_id', 'numerical', 'integerOnly'=>true),
			array('kordinat_tubuh_x, kordinat_tubuh_y', 'numerical'),
			array('keterangan_periksa_gbr, update_time, look, feel, move, sensory, motorik, gambartubuh_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaangambar_id, gambartubuh_id, pemeriksaanfisik_id, bagiantubuh_id, pendaftaran_id, pasien_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, keterangan_periksa_gbr, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, look, feel, move, sensory, motorik, pemeriksaanginekologi_id', 'safe', 'on'=>'search'),
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
			'bagiantubuh' => array(self::BELONGS_TO, 'BagiantubuhM', 'bagiantubuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaangambar_id' => 'Pemeriksaangambar',
			'gambartubuh_id' => 'Gambartubuh',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'bagiantubuh_id' => 'Bagiantubuh',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tglpemeriksaan' => 'Tglpemeriksaan',
			'kordinat_tubuh_x' => 'Koordinat Tubuh X',
			'kordinat_tubuh_y' => 'Koordinat Tubuh Y',
			'keterangan_periksa_gbr' => 'Keterangan Periksa Gbr',
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

		if(!empty($this->pemeriksaangambar_id)){
			$criteria->addCondition('pemeriksaangambar_id = '.$this->pemeriksaangambar_id);
		}
		if(!empty($this->gambartubuh_id)){
			$criteria->addCondition('gambartubuh_id = '.$this->gambartubuh_id);
		}
		if(!empty($this->pemeriksaanfisik_id)){
			$criteria->addCondition('pemeriksaanfisik_id = '.$this->pemeriksaanfisik_id);
		}
		if(!empty($this->bagiantubuh_id)){
			$criteria->addCondition('bagiantubuh_id = '.$this->bagiantubuh_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(tglpemeriksaan)',strtolower($this->tglpemeriksaan),true);
		$criteria->compare('kordinat_tubuh_x',$this->kordinat_tubuh_x);
		$criteria->compare('kordinat_tubuh_y',$this->kordinat_tubuh_y);
		$criteria->compare('LOWER(keterangan_periksa_gbr)',strtolower($this->keterangan_periksa_gbr),true);
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