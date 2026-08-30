<?php

/**
 * This is the model class for table "obatalkes_v".
 *
 * The followings are the available columns in table 'obatalkes_v':
 * @property integer $obatalkes_id
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_kategori
 * @property string $obatalkes_golongan
 * @property double $harganetto
 * @property double $hargajual
 * @property integer $pabrik_id
 * @property integer $supplier_id
 * @property string $supplier_nama
 */
class ObatalkesV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'obatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, pabrik_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('harganetto, hargajual', 'numerical'),
			array('obatalkes_kode, obatalkes_nama, obatalkes_namalain', 'length', 'max'=>200),
			array('obatalkes_kategori, obatalkes_golongan', 'length', 'max'=>50),
			array('supplier_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_kategori, obatalkes_golongan, harganetto, hargajual, pabrik_id, supplier_id, supplier_nama, tglkadaluarsa', 'safe', 'on'=>'search'),
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
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_namalain' => 'Obatalkes Namalain',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'harganetto' => 'Harganetto',
			'hargajual' => 'Hargajual',
			'pabrik_id' => 'Pabrik',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Supplier Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkes_kode',$this->obatalkes_kode,true);
		$criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
		$criteria->compare('obatalkes_namalain',$this->obatalkes_namalain,true);
		$criteria->compare('obatalkes_kategori',$this->obatalkes_kategori,true);
		$criteria->compare('obatalkes_golongan',$this->obatalkes_golongan,true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('pabrik_id',$this->pabrik_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
