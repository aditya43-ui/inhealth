<?php

/**
 * This is the model class for table "pemeriksaangambarnyeri_t".
 *
 * The followings are the available columns in table 'pemeriksaangambarnyeri_t':
 * @property integer $pemeriksaangambarnyeri_id
 * @property integer $gambartubuh_id
 * @property integer $asesmentnyeri_id
 * @property integer $bagiantubuh_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpemeriksaan
 * @property double $kordinat_tubuh_x
 * @property double $kordinat_tubuh_y
 * @property string $keterangan_periksa_gbr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemeriksaangambarnyeriT extends CActiveRecord
{
        public $namabagtubuh;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaangambarnyeriT the static model class
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
		return 'pemeriksaangambarnyeri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gambartubuh_id, asesmentnyeri_id, bagiantubuh_id, pendaftaran_id, pasien_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('gambartubuh_id, asesmentnyeri_id, bagiantubuh_id, pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kordinat_tubuh_x, kordinat_tubuh_y', 'numerical'),
			array('keterangan_periksa_gbr, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaangambarnyeri_id, gambartubuh_id, asesmentnyeri_id, bagiantubuh_id, pendaftaran_id, pasien_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, keterangan_periksa_gbr, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'bagiantubuh' => array(self::BELONGS_TO, 'BagiantubuhM', 'bagiantubuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaangambarnyeri_id' => 'Pemeriksaangambarnyeri',
			'gambartubuh_id' => 'Gambartubuh',
			'asesmentnyeri_id' => 'Asesmentnyeri',
			'bagiantubuh_id' => 'Bagiantubuh',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tglpemeriksaan' => 'Tglpemeriksaan',
			'kordinat_tubuh_x' => 'Koordinat Tubuh X',
			'kordinat_tubuh_y' => 'Koordinat Tubuh Y',
			'keterangan_periksa_gbr' => 'Keterangan Periksa Gbr',
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

		$criteria->compare('pemeriksaangambarnyeri_id',$this->pemeriksaangambarnyeri_id);
		$criteria->compare('gambartubuh_id',$this->gambartubuh_id);
		$criteria->compare('asesmentnyeri_id',$this->asesmentnyeri_id);
		$criteria->compare('bagiantubuh_id',$this->bagiantubuh_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tglpemeriksaan',$this->tglpemeriksaan,true);
		$criteria->compare('kordinat_tubuh_x',$this->kordinat_tubuh_x);
		$criteria->compare('kordinat_tubuh_y',$this->kordinat_tubuh_y);
		$criteria->compare('keterangan_periksa_gbr',$this->keterangan_periksa_gbr,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}