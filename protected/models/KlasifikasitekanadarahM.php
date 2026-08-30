<?php

/**
 * This is the model class for table "klasifikasitekanadarah_m".
 *
 * The followings are the available columns in table 'klasifikasitekanadarah_m':
 * @property integer $klasifikasitekanadarah_id
 * @property string $klasifikasitekanadarah
 * @property integer $sistolik_min
 * @property integer $sistolik_maks
 * @property integer $diastolik_min
 * @property integer $diastolik_miks
 * @property string $kondisi_logic
 * @property boolean $klasifikasitekanadarah_aktif
 *
 * The followings are the available model relations:
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 */
class KlasifikasitekanadarahM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasitekanadarahM the static model class
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
		return 'klasifikasitekanadarah_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('klasifikasitekanadarah, sistolik_min, sistolik_maks, diastolik_min, diastolik_miks', 'required'),
			array('sistolik_min, sistolik_maks, diastolik_min, diastolik_miks', 'numerical', 'integerOnly'=>true),
			array('klasifikasitekanadarah', 'length', 'max'=>100),
			array('kondisi_logic', 'length', 'max'=>5),
			array('klasifikasitekanadarah_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasitekanadarah_id, klasifikasitekanadarah, sistolik_min, sistolik_maks, diastolik_min, diastolik_miks, kondisi_logic, klasifikasitekanadarah_aktif', 'safe', 'on'=>'search'),
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
			'pemeriksaanfisikTs' => array(self::HAS_MANY, 'PemeriksaanfisikT', 'klasifikasitekanandarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'klasifikasitekanadarah_id' => 'Klasifikasitekanadarah',
			'klasifikasitekanadarah' => 'Klasifikasitekanadarah',
			'sistolik_min' => 'Sistolik Min',
			'sistolik_maks' => 'Sistolik Maks',
			'diastolik_min' => 'Diastolik Min',
			'diastolik_miks' => 'Diastolik Miks',
			'kondisi_logic' => 'Kondisi Logic',
			'klasifikasitekanadarah_aktif' => 'Klasifikasitekanadarah Aktif',
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

		if(!empty($this->klasifikasitekanadarah_id)){
			$criteria->addCondition('klasifikasitekanadarah_id = '.$this->klasifikasitekanadarah_id);
		}
		$criteria->compare('LOWER(klasifikasitekanadarah)',strtolower($this->klasifikasitekanadarah),true);
		if(!empty($this->sistolik_min)){
			$criteria->addCondition('sistolik_min = '.$this->sistolik_min);
		}
		if(!empty($this->sistolik_maks)){
			$criteria->addCondition('sistolik_maks = '.$this->sistolik_maks);
		}
		if(!empty($this->diastolik_min)){
			$criteria->addCondition('diastolik_min = '.$this->diastolik_min);
		}
		if(!empty($this->diastolik_miks)){
			$criteria->addCondition('diastolik_miks = '.$this->diastolik_miks);
		}
		$criteria->compare('LOWER(kondisi_logic)',strtolower($this->kondisi_logic),true);
		$criteria->compare('klasifikasitekanadarah_aktif',$this->klasifikasitekanadarah_aktif);

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