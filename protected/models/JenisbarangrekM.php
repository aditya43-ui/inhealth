<?php

/**
 * This is the model class for table "jenisbarangrek_m".
 *
 * The followings are the available columns in table 'jenisbarangrek_m':
 * @property integer $jenisbarangrek_id
 * @property integer $jenisbarang_id
 * @property integer $rekening5_id
 * @property string $debitkredit
 * @property boolean $ispenerimaan
 * @property boolean $ispemakaian
 * @property boolean $isreturpenerimaan
 *
 * The followings are the available model relations:
 * @property JenisbarangM $jenisbarang
 * @property Rekening5M $rekening5
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 * @category model
 */
class JenisbarangrekM extends CActiveRecord
{
    public $is_pilihan;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisbarangrekM the static model class
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
		return 'jenisbarangrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisbarang_id, rekening5_id, debitkredit', 'required'),
			array('jenisbarang_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('debitkredit', 'length', 'max'=>1),
			array('ispenerimaan, ispemakaian, isreturpenerimaan, ismutasi, isstokopname, isstokopnameberkurang, isstokopnamebertambah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisbarangrek_id, jenisbarang_id, rekening5_id, debitkredit, ispenerimaan, ispemakaian, isreturpenerimaan, ismutasi, isstokopname, isstokopnameberkurang, isstokopnamebertambah', 'safe', 'on'=>'search'),
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
			'jenisbarang' => array(self::BELONGS_TO, 'JenisbarangM', 'jenisbarang_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisbarangrek_id' => 'Jenis Barang Rekening',
			'jenisbarang_id' => 'Jenis Barang',
			'rekening5_id' => 'Rekening COA',
			'debitkredit' => 'Saldo Normal',
			'ispenerimaan' => 'Penerimaan Faktur',
			'ispemakaian' => 'Pemakaian Ruangan',
			'isreturpenerimaan' => 'Retur Penerimaan Faktur',
			'ismutasi' => 'Mutasi',
			'isstokopname' => 'Inventarisasi Stok Awal',
			'isstokopnameberkurang' => 'Inventarisasi Penyesuaian Berkurang',
      'isstokopnamebertambah'=>'Inventarisasi Penyesuaian Bertambah'
		);
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

		$criteria->compare('jenisbarangrek_id',$this->jenisbarangrek_id);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit);

        if ($this->ispenerimaan == 1) {

            $criteria->addCondition('ispenerimaan = true');
        } else if ($this->ispenerimaan == 2) {
            $criteria->addCondition('ispenerimaan = false');
        }
        if ($this->ispemakaian == 1) {
            $criteria->addCondition('ispemakaian = true');
        } else if ($this->ispemakaian == 2) {
            $criteria->addCondition('ispemakaian = false');
        }
        if ($this->isreturpenerimaan == 1) {
            $criteria->addCondition('isreturpenerimaan = true');
        } else if ($this->isreturpenerimaan == 2) {
            $criteria->addCondition('isreturpenerimaan = false');
        }
        if ($this->ismutasi == 1) {
            $criteria->addCondition('ismutasi = true');
        } else if ($this->ismutasi == 2) {
            $criteria->addCondition('ismutasi = false');
        }

        if ($this->isstokopname == 1) {
            $criteria->addCondition('isstokopname = true');
        } else if ($this->isstokopname == 2) {
            $criteria->addCondition('isstokopname = false');
        }

        if ($this->isstokopnameberkurang == 1) {
            $criteria->addCondition('isstokopnameberkurang = true');
        } else if ($this->isstokopnameberkurang == 2) {
            $criteria->addCondition('isstokopnameberkurang = false');
        }

        if ($this->isstokopnamebertambah == 1) {
            $criteria->addCondition('isstokopnamebertambah = true');
        } else if ($this->isstokopnamebertambah == 2) {
            $criteria->addCondition('isstokopnamebertambah = false');
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisbarangrek_id',$this->jenisbarangrek_id);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit);

        if ($this->ispenerimaan == 1) {
            $criteria->addCondition('ispenerimaan = true');
        } else if ($this->ispenerimaan == 2) {
            $criteria->addCondition('ispenerimaan = false');
        }
        if ($this->ispemakaian == 1) {
            $criteria->addCondition('ispemakaian = true');
        } else if ($this->ispemakaian == 2) {
            $criteria->addCondition('ispemakaian = false');
        }
        if ($this->isreturpenerimaan == 1) {
            $criteria->addCondition('isreturpenerimaan = true');
        } else if ($this->isreturpenerimaan == 2) {
            $criteria->addCondition('isreturpenerimaan = false');
        }
        if ($this->ismutasi == 1) {
            $criteria->addCondition('ismutasi = true');
        } else if ($this->ismutasi == 2) {
            $criteria->addCondition('ismutasi = false');
        }

        if ($this->isstokopname == 1) {
            $criteria->addCondition('isstokopname = true');
        } else if ($this->isstokopname == 2) {
            $criteria->addCondition('isstokopname = false');
        }

        if ($this->isstokopnameberkurang == 1) {
            $criteria->addCondition('isstokopnameberkurang = true');
        } else if ($this->isstokopnameberkurang == 2) {
            $criteria->addCondition('isstokopnameberkurang = false');
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}
