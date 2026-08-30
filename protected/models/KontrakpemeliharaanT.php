<?php

/**
 * This is the model class for table "kontrakpemeliharaan_t".
 *
 * The followings are the available columns in table 'kontrakpemeliharaan_t':
 * @property integer $kontrakpemeliharaan_id
 * @property integer $invperalatan_id
 * @property string $kontrakpem_no
 * @property string $kontrakpem_tgl
 * @property string $kontrakpem_sdtgl
 * @property double $kontrakpem_nilai
 * @property string $kontrakpem_ket
 * @property string $kontrakpem_file
 * @property string $statuskontrak
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KontrakpemeliharaanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KontrakpemeliharaanT the static model class
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
		return 'kontrakpemeliharaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, kontrakpem_no, kontrakpem_tgl, kontrakpem_sdtgl, statuskontrak, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('invperalatan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kontrakpem_nilai', 'numerical'),
			array('kontrakpem_no', 'length', 'max'=>100),
			array('kontrakpem_file', 'length', 'max'=>255),
			array('statuskontrak', 'length', 'max'=>20),
			array('supplier_id, kontrakpem_ket, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kontrakpemeliharaan_id, invperalatan_id, kontrakpem_no, kontrakpem_tgl, kontrakpem_sdtgl, kontrakpem_nilai, kontrakpem_ket, kontrakpem_file, statuskontrak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kontrakpemeliharaan_id' => 'Kontrakpemeliharaan',
			'invperalatan_id' => 'Invperalatan',
			'kontrakpem_no' => 'Kontrakpem No',
			'kontrakpem_tgl' => 'Kontrakpem Tgl',
			'kontrakpem_sdtgl' => 'Kontrakpem Sdtgl',
			'kontrakpem_nilai' => 'Kontrakpem Nilai',
			'kontrakpem_ket' => 'Kontrakpem Ket',
			'kontrakpem_file' => 'Kontrakpem File',
			'statuskontrak' => 'Statuskontrak',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->kontrakpemeliharaan_id)){
			$criteria->addCondition('kontrakpemeliharaan_id = '.$this->kontrakpemeliharaan_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(kontrakpem_no)',strtolower($this->kontrakpem_no),true);
		$criteria->compare('LOWER(kontrakpem_tgl)',strtolower($this->kontrakpem_tgl),true);
		$criteria->compare('LOWER(kontrakpem_sdtgl)',strtolower($this->kontrakpem_sdtgl),true);
		$criteria->compare('kontrakpem_nilai',$this->kontrakpem_nilai);
		$criteria->compare('LOWER(kontrakpem_ket)',strtolower($this->kontrakpem_ket),true);
		$criteria->compare('LOWER(kontrakpem_file)',strtolower($this->kontrakpem_file),true);
		$criteria->compare('LOWER(statuskontrak)',strtolower($this->statuskontrak),true);
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