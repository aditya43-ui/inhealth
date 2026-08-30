<?php

/**
 * This is the model class for table "laporanrekapkondisiasetperjenis_v".
 *
 * The followings are the available columns in table 'laporanrekapkondisiasetperjenis_v':
 * @property integer $barang_id
 * @property string $barang_nama
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property string $baik
 * @property string $rusakringan
 * @property string $rusakberat
 */
class LaporanrekapkondisiasetperjenisV extends CActiveRecord
{
        public $total;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekapkondisiasetperjenisV the static model class
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
		return 'laporanrekapkondisiasetperjenis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, lokasi_id, ruangan_id, gedung_id', 'numerical', 'integerOnly'=>true),
			array('barang_nama, lokasiaset_namalokasi, gedung_nama', 'length', 'max'=>100),
			array('ruangan_nama', 'length', 'max'=>50),
			array('baik, rusakringan, rusakberat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_id, barang_nama, lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, baik, rusakringan, rusakberat', 'safe', 'on'=>'search'),
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
			'barang_id' => 'Barang',
			'barang_nama' => 'Jenis Peralatan',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'baik' => 'Baik',
			'rusakringan' => 'Rusak Ringan',
			'rusakberat' => 'Rusak Berat',
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
                $criteria->select = [
                    't.barang_nama',
                    'sum(baik+rusakringan+rusakberat)as total',
                    'sum(baik) as baik',
                    'sum(rusakringan) as rusakringan',
                    'sum(rusakberat) as rusakberat',
                ];
                $criteria->group = 'barang_nama';
		$criteria->compare('barang_id',$this->barang_id);		
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);		
		$criteria->compare('gedung_id',$this->gedung_id);		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}