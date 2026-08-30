<?php

/**
 * This is the model class for table "revisirencanggpeng_t".
 *
 * The followings are the available columns in table 'revisirencanggpeng_t':
 * @property integer $revisirencanggpeng_id
 * @property integer $subkegiatanprogram_id
 * @property string $tglrevisianggpeng
 * @property integer $ygmerevisi_id
 * @property double $nilaisblrevisi
 * @property double $nilairevisi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RevisirencanggpengT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RevisirencanggpengT the static model class
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
		return 'revisirencanggpeng_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkegiatanprogram_id, tglrevisianggpeng, ygmerevisi_id, nilaisblrevisi, nilairevisi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('subkegiatanprogram_id, ygmerevisi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilaisblrevisi, nilairevisi', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('revisirencanggpeng_id, subkegiatanprogram_id, tglrevisianggpeng, ygmerevisi_id, nilaisblrevisi, nilairevisi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'revisirencanggpeng_id' => 'Revisirencanggpeng',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'tglrevisianggpeng' => 'Tglrevisianggpeng',
			'ygmerevisi_id' => 'Ygmerevisi',
			'nilaisblrevisi' => 'Nilaisblrevisi',
			'nilairevisi' => 'Nilairevisi',
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

		if(!empty($this->revisirencanggpeng_id)){
			$criteria->addCondition('revisirencanggpeng_id = '.$this->revisirencanggpeng_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(tglrevisianggpeng)',strtolower($this->tglrevisianggpeng),true);
		if(!empty($this->ygmerevisi_id)){
			$criteria->addCondition('ygmerevisi_id = '.$this->ygmerevisi_id);
		}
		$criteria->compare('nilaisblrevisi',$this->nilaisblrevisi);
		$criteria->compare('nilairevisi',$this->nilairevisi);
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