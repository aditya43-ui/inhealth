<?php

/**
 * This is the model class for table "permintaanpembeliantouangmuka_v".
 *
 * The followings are the available columns in table 'permintaanpembeliantouangmuka_v':
 * @property integer $permintaanpembelian_id
 * @property string $nopermintaan
 * @property string $tglpermintaan
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $noreferensi
 * @property string $keterangan
 * @property string $tglpermintaanuangmuka
 * @property double $jmlpermintaanuangmuka
 * @property double $totalharga
 * @property string $typepermintaan
 */
class PermintaanpembeliantouangmukaV extends CActiveRecord
{
	public $tglpouangmuka, $supplier_alamat;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpembeliantouangmukaV the static model class
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
		return 'permintaanpembeliantouangmuka_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permintaanpembelian_id, supplier_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('jmlpermintaanuangmuka, totalharga, jumlahuangmuka, jmlsisauangmuka', 'numerical'),
			array('supplier_nama, noreferensi', 'length', 'max'=>100),
			array('nopermintaan, tglpermintaan, keterangan, tglpermintaanuangmuka, typepermintaan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaanpembelian_id, nopermintaan, tglpermintaan, supplier_id, supplier_nama, noreferensi, keterangan, tglpermintaanuangmuka, jmlpermintaanuangmuka, totalharga, typepermintaan, jumlahuangmuka, jmlsisauangmuka, sumberdana_id', 'safe', 'on'=>'search'),
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
			'permintaanpembelian_id' => 'Permintaanpembelian',
			'nopermintaan' => 'Nopermintaan',
			'tglpermintaan' => 'Tglpermintaan',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'noreferensi' => 'Noreferensi',
			'keterangan' => 'Keterangan',
			'tglpermintaanuangmuka' => 'Tglpermintaanuangmuka',
			'jmlpermintaanuangmuka' => 'Jmlpermintaanuangmuka',
			'totalharga' => 'Totalharga',
			'typepermintaan' => 'Typepermintaan',
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

		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('nopermintaan',$this->nopermintaan,true);
		$criteria->compare('tglpermintaan',$this->tglpermintaan,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('noreferensi',$this->noreferensi,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('tglpermintaanuangmuka',$this->tglpermintaanuangmuka,true);
		$criteria->compare('jmlpermintaanuangmuka',$this->jmlpermintaanuangmuka);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('typepermintaan',$this->typepermintaan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
