<?php

/**
 * This is the model class for table "stokopnamegizi_t".
 *
 * The followings are the available columns in table 'stokopnamegizi_t':
 * @property integer $stokopnamegizi_id
 * @property integer $ruangan_id
 * @property integer $formuliropnamegizi_id
 * @property string $tglstokopnamegizi
 * @property string $nostokopnamegizi
 * @property boolean $isstokawal
 * @property string $jenisstokopnamegizi
 * @property string $keterangan_opname
 * @property integer $mengetahui_id
 * @property integer $petugas1_id
 * @property integer $petugas2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property PegawaiM $mengetahui
 * @property PegawaiM $petugas1
 * @property PegawaiM $petugas2
 * @property StokopnamegizidetT[] $stokopnamegizidetTs
 */
class StokopnamegiziT extends CActiveRecord
{
    public $mengetahui_nama;
    public $petugas1_nama;
    public $petugas2_nama;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokopnamegiziT the static model class
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
		return 'stokopnamegizi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglstokopnamegizi, nostokopnamegizi, jenisstokopnamegizi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, formuliropnamegizi_id, mengetahui_id, petugas1_id, petugas2_id', 'numerical', 'integerOnly'=>true),
			array('totalharga, totalnetto', 'numerical'),
			array('nostokopnamegizi, jenisstokopnamegizi', 'length', 'max'=>50),
			array('isstokawal, keterangan_opname, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokopnamegizi_id, ruangan_id, formuliropnamegizi_id, tglstokopnamegizi, nostokopnamegizi, isstokawal, jenisstokopnamegizi, keterangan_opname, mengetahui_id, petugas1_id, petugas2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, totalharga, totalnetto', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
			'petugas1' => array(self::BELONGS_TO, 'PegawaiM', 'petugas1_id'),
			'petugas2' => array(self::BELONGS_TO, 'PegawaiM', 'petugas2_id'),
			'stokopnamegizidetTs' => array(self::HAS_MANY, 'StokopnamegizidetT', 'stokopnamegizi_id'),
            'formuliropnamegizi' => array(self::BELONGS_TO, 'FormuliropnamegiziR', 'formuliropnamegizi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokopnamegizi_id' => 'Stokopnamegizi',
			'ruangan_id' => 'Ruangan',
			'formuliropnamegizi_id' => 'Formulir Opname',
			'tglstokopnamegizi' => 'Tanggal Stok Opname',
			'nostokopnamegizi' => 'No. Stok Opname',
			'isstokawal' => 'Isstokawal',
			'jenisstokopnamegizi' => 'Jenis Opname',
			'keterangan_opname' => 'Keterangan Opname',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas 1',
			'petugas2_id' => 'Petugas 2',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('stokopnamegizi_id',$this->stokopnamegizi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('formuliropnamegizi_id',$this->formuliropnamegizi_id);
		$criteria->compare('tglstokopnamegizi',$this->tglstokopnamegizi,true);
		$criteria->compare('nostokopnamegizi',$this->nostokopnamegizi,true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('jenisstokopnamegizi',$this->jenisstokopnamegizi,true);
		$criteria->compare('keterangan_opname',$this->keterangan_opname,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}