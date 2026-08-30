<?php

/**
 * This is the model class for table "lapfrekuensilayanan_v".
 *
 * The followings are the available columns in table 'lapfrekuensilayanan_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_katakunci
 * @property string $tgl_tindakan
 * @property string $sum
 */
class LapfrekuensilayananV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $data;
	public $jumlah;	
	public $no;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapfrekuensilayananV the static model class
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
		return 'lapfrekuensilayanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, kelompoktindakan_id, komponenunit_id, kategoritindakan_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, kelompoktindakan_nama', 'length', 'max'=>50),
			array('komponenunit_nama, daftartindakan_katakunci', 'length', 'max'=>30),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('daftartindakan_kode', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('tglpembayaran, tgl_tindakan, sum', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, kategoritindakan_id, kategoritindakan_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, tgl_tindakan, sum', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponenunit_id' => 'Komponenunit',
			'komponenunit_nama' => 'Komponenunit Nama',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Layanan',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'sum' => 'Sum',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kelompoktindakan_nama',$this->kelompoktindakan_nama,true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('komponenunit_nama',$this->komponenunit_nama,true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('daftartindakan_katakunci',$this->daftartindakan_katakunci,true);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('sum',$this->sum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}