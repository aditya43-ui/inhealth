<?php

/**
 * This is the model class for table "batalpakaiambulans_t".
 *
 * The followings are the available columns in table 'batalpakaiambulans_t':
 * @property integer $batalpakaiambulans_id
 * @property integer $pemakaianambulans_id
 * @property integer $ruangan_id
 * @property string $tglpembatalan
 * @property string $alasanpembatalanambulans
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property PemakaianambulansT $pemakaianambulans
 * @property RuanganM $ruangan
 */
class BatalpakaiambulansT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalpakaiambulansT the static model class
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
		return 'batalpakaiambulans_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglpembatalan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemakaianambulans_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('alasanpembatalanambulans, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('batalpakaiambulans_id, pemakaianambulans_id, ruangan_id, tglpembatalan, alasanpembatalanambulans, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'batalpakaiambulans_id'),
			'pemakaianambulans' => array(self::BELONGS_TO, 'PemakaianambulansT', 'pemakaianambulans_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batalpakaiambulans_id' => 'Batal Pakai Ambulans ID',
			'pemakaianambulans_id' => 'Pemakaian Ambulans ID',
			'ruangan_id' => 'Ruangan',
			'tglpembatalan' => 'Tanggal Pembatalan',
			'alasanpembatalanambulans' => 'Alasan Pembatalan Ambulans',
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

		if(!empty($this->batalpakaiambulans_id)){
			$criteria->addCondition('batalpakaiambulans_id = '.$this->batalpakaiambulans_id);
		}
		if(!empty($this->pemakaianambulans_id)){
			$criteria->addCondition('pemakaianambulans_id = '.$this->pemakaianambulans_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(alasanpembatalanambulans)',strtolower($this->alasanpembatalanambulans),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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