<?php

/**
 * This is the model class for table "jenispenilaian_m".
 *
 * The followings are the available columns in table 'jenispenilaian_m':
 * @property integer $jenispenilaian_id
 * @property string $jenispenilaian_nama
 * @property string $jenispenilaian_namalain
 * @property string $jenispenilaian_sifat
 * @property boolean $jenispenilaian_aktif
 */
class JenispenilaianM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispenilaianM the static model class
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
		return 'jenispenilaian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispenilaian_nama, jenispenilaian_namalain, jenispenilaian_sifat, jenispenilaian_aktif', 'required'),
			array('bobot_penilaian, jenispenilaian_urutan', 'numerical', 'integerOnly'=>true),
                        array('jenispenilaian_nama, jenispenilaian_namalain', 'length', 'max'=>100),
			array('jenispenilaian_sifat', 'length', 'max'=>25),
                        array('jenispenilaian_urutan, tingkatpenilaian','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispenilaian_id, jenispenilaian_nama, jenispenilaian_namalain, jenispenilaian_sifat, jenispenilaian_aktif, bobot_penilaian, tingkatpenilaian', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenispenilaian_id' => 'Jenis Penilaian',
			'jenispenilaian_nama' => 'Jenis Penilaian',
			'jenispenilaian_namalain' => 'Nama Lain',
			'jenispenilaian_sifat' => 'Sifat',
			'jenispenilaian_aktif' => 'Status',
                        'jenispenilaian_urutan' => 'Urutan',
                        'bobot_penilaian' => 'Bobot Penilaian',
                        'tingkatpenilaian' => 'Tingkat Penilaian',
                    
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

		if(!empty($this->jenispenilaian_id)){
			$criteria->addCondition('jenispenilaian_id = '.$this->jenispenilaian_id);
		}
		$criteria->compare('LOWER(jenispenilaian_nama)',strtolower($this->jenispenilaian_nama),true);
		$criteria->compare('LOWER(jenispenilaian_namalain)',strtolower($this->jenispenilaian_namalain),true);
		$criteria->compare('LOWER(jenispenilaian_sifat)',strtolower($this->jenispenilaian_sifat),true);
		$criteria->compare('jenispenilaian_aktif',$this->jenispenilaian_aktif);

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