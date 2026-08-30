<?php

/**
 * This is the model class for table "inasiscmg_t".
 *
 * The followings are the available columns in table 'inasiscmg_t':
 * @property integer $inasiscmg_id
 * @property integer $pendaftaran_id
 * @property integer $inacbg_id
 * @property string $inasiscmg_tgl
 * @property string $kodecmg
 * @property string $kodegrup
 * @property string $namacmg
 * @property string $procedure
 * @property string $drugs
 * @property string $investigation
 * @property string $prosthesis
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InasiscmgT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InasiscmgT the static model class
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
		return 'inasiscmg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, inasiscmg_tgl, kodecmg, kodegrup, namacmg, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, inacbg_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kodecmg, kodegrup', 'length', 'max'=>50),
			array('namacmg', 'length', 'max'=>300),
			array('procedure, drugs, investigation, prosthesis, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inasiscmg_id, pendaftaran_id, inacbg_id, inasiscmg_tgl, kodecmg, kodegrup, namacmg, procedure, drugs, investigation, prosthesis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inasiscmg_id' => 'Inasiscmg',
			'pendaftaran_id' => 'Pendaftaran',
			'inacbg_id' => 'Inacbg',
			'inasiscmg_tgl' => 'Inasiscmg Tgl',
			'kodecmg' => 'Kodecmg',
			'kodegrup' => 'Kodegrup',
			'namacmg' => 'Namacmg',
			'procedure' => 'Procedure',
			'drugs' => 'Drugs',
			'investigation' => 'Investigation',
			'prosthesis' => 'Prosthesis',
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

		if(!empty($this->inasiscmg_id)){
			$criteria->addCondition('inasiscmg_id = '.$this->inasiscmg_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		$criteria->compare('LOWER(inasiscmg_tgl)',strtolower($this->inasiscmg_tgl),true);
		$criteria->compare('LOWER(kodecmg)',strtolower($this->kodecmg),true);
		$criteria->compare('LOWER(kodegrup)',strtolower($this->kodegrup),true);
		$criteria->compare('LOWER(namacmg)',strtolower($this->namacmg),true);
		$criteria->compare('LOWER(procedure)',strtolower($this->procedure),true);
		$criteria->compare('LOWER(drugs)',strtolower($this->drugs),true);
		$criteria->compare('LOWER(investigation)',strtolower($this->investigation),true);
		$criteria->compare('LOWER(prosthesis)',strtolower($this->prosthesis),true);
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