<?php

/**
 * This is the model class for table "stokkantongdarah_t".
 *
 * The followings are the available columns in table 'stokkantongdarah_t':
 * @property integer $stokkantongdarah_id
 * @property string $nomorbarcode
 * @property integer $ruangan_id
 * @property integer $jeniskantongdarah_id
 * @property integer $komponendarah_id
 * @property integer $jmlkantongdarah
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class StokkantongdarahT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokkantongdarahT the static model class
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
		return 'stokkantongdarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomorbarcode, ruangan_id, jmlkantongdarah, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, jeniskantongdarah_id, komponendarah_id, jmlkantongdarah, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode', 'length', 'max'=>100),
			array('update_time, rhesus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokkantongdarah_id, nomorbarcode, ruangan_id, jeniskantongdarah_id, komponendarah_id, jmlkantongdarah, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jeniskantongdarah' => array(self::BELONGS_TO, 'JeniskantongdarahM', 'jeniskantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokkantongdarah_id' => 'Stokkantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'ruangan_id' => 'Ruangan',
			'jeniskantongdarah_id' => 'Jeniskantongdarah',
			'komponendarah_id' => 'Komponendarah',
			'jmlkantongdarah' => 'Jmlkantongdarah',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        /**
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()

	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('stokkantongdarah_id',$this->stokkantongdarah_id);
		$criteria->compare('nomorbarcode',$this->nomorbarcode,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('jmlkantongdarah',$this->jmlkantongdarah);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	
		if(!empty($this->stokkantongdarah_id)){
			$criteria->addCondition('stokkantongdarah_id = '.$this->stokkantongdarah_id);
		}
		$criteria->compare('LOWER(nomorbarcode)',strtolower($this->nomorbarcode),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->jeniskantongdarah_id)){
			$criteria->addCondition('jeniskantongdarah_id = '.$this->jeniskantongdarah_id);
		}
		if(!empty($this->komponendarah_id)){
			$criteria->addCondition('komponendarah_id = '.$this->komponendarah_id);
		}
		if(!empty($this->jmlkantongdarah)){
			$criteria->addCondition('jmlkantongdarah = '.$this->jmlkantongdarah);
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