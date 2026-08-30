<?php

/**
 * This is the model class for table "obatalkesanestesi_t".
 *
 * The followings are the available columns in table 'obatalkesanestesi_t':
 * @property integer $obatalkesanestesi_id
 * @property integer $praanestesi_id
 * @property integer $intraanestesi_id
 * @property integer $obatalkespasien_id
 * @property integer $ruangan_id
 * @property integer $qty_oa
 * @property double $hargasatuan_oa
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PraanestesiT $praanestesi
 * @property IntraanestesiT $intraanestesi
 * @property ObatalkespasienT $obatalkespasien
 * @property RuanganM $ruangan
 */
class ObatalkesanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesanestesiT the static model class
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
		return 'obatalkesanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('praanestesi_id, intraanestesi_id, obatalkespasien_id, ruangan_id, qty_oa, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('hargasatuan_oa', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkesanestesi_id, praanestesi_id, intraanestesi_id, obatalkespasien_id, ruangan_id, qty_oa, hargasatuan_oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'praanestesi' => array(self::BELONGS_TO, 'PraanestesiT', 'praanestesi_id'),
			'intraanestesi' => array(self::BELONGS_TO, 'IntraanestesiT', 'intraanestesi_id'),
			'obatalkespasien' => array(self::BELONGS_TO, 'ObatalkespasienT', 'obatalkespasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkesanestesi_id' => 'Obat Alkes Anestesi',
			'praanestesi_id' => 'Pra Anestesi',
			'intraanestesi_id' => 'Intra Anestesi',
			'obatalkespasien_id' => 'Obat Alkes Pasien',
			'ruangan_id' => 'Ruangan',
			'qty_oa' => 'Jumlah',
			'hargasatuan_oa' => 'Harga Satuan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		if(!empty($this->obatalkesanestesi_id)){
			$criteria->addCondition('obatalkesanestesi_id = '.$this->obatalkesanestesi_id);
		}
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		if(!empty($this->obatalkespasien_id)){
			$criteria->addCondition('obatalkespasien_id = '.$this->obatalkespasien_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->qty_oa)){
			$criteria->addCondition('qty_oa = '.$this->qty_oa);
		}
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
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