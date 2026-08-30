<?php

/**
 * This is the model class for table "diagnosaicdix_m".
 *
 * The followings are the available columns in table 'diagnosaicdix_m':  
 * 
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 *  
 * @property integer $diagnosaicdix_id
 * @property string $diagnosaicdix_kode
 * @property string $diagnosaicdix_nama
 * @property string $diagnosaicdix_namalainnya
 * @property string $diagnosatindakan_katakunci
 * @property integer $diagnosaicdix_nourut
 * @property boolean $diagnosaicdix_aktif
 */
class DiagnosaicdixM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaicdixM the static model class
	 */
	public $default;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'diagnosaicdix_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosaicdix_kode, diagnosaicdix_nama', 'required'),
			array('diagnosaicdix_nourut', 'numerical', 'integerOnly'=>true),
			array('diagnosaicdix_kode', 'length', 'max'=>10),
			array('diagnosaicdix_nama, diagnosaicdix_namalainnya, diagnosatindakan_katakunci', 'length', 'max'=>50),
			array('diagnosaicdix_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosaicdix_id, diagnosaicdix_kode, diagnosaicdix_nama, diagnosaicdix_namalainnya, diagnosatindakan_katakunci, diagnosaicdix_nourut, diagnosaicdix_aktif', 'safe', 'on'=>'search'),
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
			'diagnosaicdix_id' => 'ID',
			'diagnosaicdix_kode' => 'Kode Diagnosa',
			'diagnosaicdix_nama' => 'Nama Diagnosa',
			'diagnosaicdix_namalainnya' => 'Nama Lainnya',
			'diagnosatindakan_katakunci' => 'Kata Kunci',
			'diagnosaicdix_nourut' => 'No. Urut',
			'diagnosaicdix_aktif' => 'Aktif',
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

		if(!empty($this->diagnosaicdix_id)){
			$criteria->addCondition('diagnosaicdix_id = '.$this->diagnosaicdix_id);
		}
		$criteria->compare('LOWER(diagnosaicdix_kode)',strtolower($this->diagnosaicdix_kode),true);
		$criteria->compare('LOWER(diagnosaicdix_nama)',strtolower($this->diagnosaicdix_nama),true);
		$criteria->compare('LOWER(diagnosaicdix_namalainnya)',strtolower($this->diagnosaicdix_namalainnya),true);
		$criteria->compare('LOWER(diagnosatindakan_katakunci)',strtolower($this->diagnosatindakan_katakunci),true);
		if(!empty($this->diagnosaicdix_nourut)){
			$criteria->addCondition('diagnosaicdix_nourut = '.$this->diagnosaicdix_nourut);
		}
		$criteria->compare('diagnosaicdix_aktif',$this->diagnosaicdix_aktif);

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

		$criteria=new CDbCriteria;

		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('LOWER(diagnosaicdix_kode)',strtolower($this->diagnosaicdix_kode),true);
		$criteria->compare('LOWER(diagnosaicdix_nama)',strtolower($this->diagnosaicdix_nama),true);
		$criteria->compare('LOWER(diagnosaicdix_namalainnya)',strtolower($this->diagnosaicdix_namalainnya),true);
		$criteria->compare('LOWER(diagnosatindakan_katakunci)',strtolower($this->diagnosatindakan_katakunci),true);
		$criteria->compare('diagnosaicdix_nourut',$this->diagnosaicdix_nourut);
		$criteria->compare('diagnosaicdix_aktif',isset($this->diagnosaicdix_aktif)?$this->diagnosaicdix_aktif:true);
//                $criteria->addCondition('diagnosaicdix_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            //$criteria->limit=5;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
			//		'pagination'=>false,
            ));
        }
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('LOWER(diagnosaicdix_kode)',strtolower($this->diagnosaicdix_kode),true);
		$criteria->compare('LOWER(diagnosaicdix_nama)',strtolower($this->diagnosaicdix_nama),true);
		$criteria->compare('LOWER(diagnosaicdix_namalainnya)',strtolower($this->diagnosaicdix_namalainnya),true);
		$criteria->compare('LOWER(diagnosatindakan_katakunci)',strtolower($this->diagnosatindakan_katakunci),true);
		$criteria->compare('diagnosaicdix_nourut',$this->diagnosaicdix_nourut);
		$criteria->compare('diagnosaicdix_aktif',$this->diagnosaicdix_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}