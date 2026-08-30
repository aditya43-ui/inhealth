<?php

/**
 * This is the model class for table "tunjangan_m".
 *
 * The followings are the available columns in table 'tunjangan_m':
 * @property integer $tunjangan_id
 * @property integer $pangkat_id
 * @property integer $jabatan_id
 * @property integer $komponengaji_id
 * @property double $nominaltunjangan
 * @property boolean $tunjangan_aktif
 *
 * The followings are the available model relations:
 * @property JabatanM $jabatan
 * @property KomponengajiM $komponengaji
 * @property PangkatM $pangkat
 */
class TunjanganM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TunjanganM the static model class
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
		return 'tunjangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponengaji_id', 'required'),
			array('pangkat_id, jabatan_id, komponengaji_id', 'numerical', 'integerOnly'=>true),
			array('nominaltunjangan', 'numerical'),
			array('tunjangan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tunjangan_id, pangkat_id, jabatan_id, komponengaji_id, nominaltunjangan, tunjangan_aktif', 'safe', 'on'=>'search'),
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
			'jabatan' => array(self::BELONGS_TO, 'JabatanM', 'jabatan_id'),
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'pangkat' => array(self::BELONGS_TO, 'PangkatM', 'pangkat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tunjangan_id' => 'ID',
			'pangkat_id' => 'Pangkat',
			'jabatan_id' => 'Jabatan',
			'komponengaji_id' => 'Komponen Gaji',
			'nominaltunjangan' => 'Nominal Tunjangan',
			'tunjangan_aktif' => 'Aktif',
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

		if(!empty($this->tunjangan_id)){
			$criteria->addCondition('tunjangan_id = '.$this->tunjangan_id);
		}
		if(!empty($this->pangkat_id)){
			$criteria->addCondition('pangkat_id = '.$this->pangkat_id);
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		if(!empty($this->komponengaji_id)){
			$criteria->addCondition('komponengaji_id = '.$this->komponengaji_id);
		}
		$criteria->compare('nominaltunjangan',  str_replace('.','',$this->nominaltunjangan));
		$criteria->compare('tunjangan_aktif',isset($this->tunjangan_aktif)?$this->tunjangan_aktif:true);

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