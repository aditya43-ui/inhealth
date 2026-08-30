<?php

/**
 * This is the model class for table "formulirinvbarang_r".
 *
 * The followings are the available columns in table 'formulirinvbarang_r':
 * @property integer $formulirinvbarang_id
 * @property integer $inventarisasi_id
 * @property integer $invbarang_id
 * @property integer $ruangan_id
 * @property string $forminvbarang_no
 * @property string $forminvbarang_tgl
 * @property double $forminvbarang_totalvolume
 * @property double $forminvbarang_totalharga
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property InventarisasiruanganT $inventarisasi
 */
class FormulirinvbarangR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormulirinvbarangR the static model class
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
		return 'formulirinvbarang_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('forminvbarang_no, forminvbarang_tgl, forminvbarang_totalvolume, forminvbarang_totalharga, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('inventarisasi_id, invbarang_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('forminvbarang_totalvolume, forminvbarang_totalharga', 'numerical'),
			array('forminvbarang_no', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formulirinvbarang_id, inventarisasi_id, invbarang_id, ruangan_id, forminvbarang_no, forminvbarang_tgl, forminvbarang_totalvolume, forminvbarang_totalharga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inventarisasi' => array(self::BELONGS_TO, 'InventarisasiruanganT', 'inventarisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formulirinvbarang_id' => 'Formulir Inventarisasi Barang ID',
			'inventarisasi_id' => 'Inventarisasi ID',
			'invbarang_id' => 'Inventarisasi Barang ID',
			'satuankecil_id' => 'Satuan Kecil',
			'ruangan_id' => 'Ruangan',
			'forminvbarang_no' => 'No. Formulir Inventarisasi',
			'forminvbarang_tgl' => 'Tanggal Formulir',
			'forminvbarang_totalvolume' => 'Total Volume',
			'forminvbarang_totalharga' => 'Total Harga',
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

		if(!empty($this->formulirinvbarang_id)){
			$criteria->addCondition('formulirinvbarang_id = '.$this->formulirinvbarang_id);
		}
		if(!empty($this->inventarisasi_id)){
			$criteria->addCondition('inventarisasi_id = '.$this->inventarisasi_id);
		}
		if(!empty($this->invbarang_id)){
			$criteria->addCondition('invbarang_id = '.$this->invbarang_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(forminvbarang_no)',strtolower($this->forminvbarang_no),true);
		$criteria->compare('LOWER(forminvbarang_tgl)',strtolower($this->forminvbarang_tgl),true);
		$criteria->compare('forminvbarang_totalvolume',$this->forminvbarang_totalvolume);
		$criteria->compare('forminvbarang_totalharga',$this->forminvbarang_totalharga);
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