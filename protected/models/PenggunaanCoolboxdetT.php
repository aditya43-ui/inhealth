<?php

/**
 * This is the model class for table "penggunaan_coolboxdet_t".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'penggunaan_coolboxdet_t':
 * @property integer $penggunaan_coolboxdet_id
 * @property integer $daftardonasi_id
 * @property integer $kantongdarah_id
 * @property integer $penggunaan_coolbox_id
 * @property string $nomorbarcod_sample
 *
 * The followings are the available model relations:
 * @property DaftardonasiT $daftardonasi
 * @property KantongdarahT $kantongdarah
 * @property PenggunaanCoolboxT $penggunaanCoolbox
 */
class PenggunaanCoolboxdetT extends CActiveRecord
{
        public $no_pendonor,$no_identitas,$nomorbarcode_utama,$nomorbarcode_sample,$gol_darah,$rhesus;
        public $no_penggunaan_coolbox, $tgl_penggunaan_coolbox, $jumlah_icepack, $jenis_kantong, $standar_suhu, $jeniskantong, $volume, $petugas_nama, $no_kantongpabrik;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggunaanCoolboxdetT the static model class
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
		return 'penggunaan_coolboxdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftardonasi_id, kantongdarah_id, penggunaan_coolbox_id', 'numerical', 'integerOnly'=>true),
			array('nomorbarcod_sample', 'length', 'max'=>100),
                        array('gol_darah, rhesus, kirimkantongdet_id','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penggunaan_coolboxdet_id, daftardonasi_id, kantongdarah_id, penggunaan_coolbox_id, nomorbarcod_sample', 'safe', 'on'=>'search'),
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
			'daftardonasi' => array(self::BELONGS_TO, 'DaftardonasiT', 'daftardonasi_id'),
			'kantongdarah' => array(self::BELONGS_TO, 'KantongdarahT', 'kantongdarah_id'),
			'penggunaanCoolbox' => array(self::BELONGS_TO, 'PenggunaanCoolboxT', 'penggunaan_coolbox_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penggunaan_coolboxdet_id' => 'Penggunaan Coolboxdet',
			'daftardonasi_id' => 'Daftardonasi',
			'kantongdarah_id' => 'Kantongdarah',
			'penggunaan_coolbox_id' => 'Penggunaan Coolbox',
			'nomorbarcod_sample' => 'Nomorbarcod Sample',
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

		$criteria->compare('penggunaan_coolboxdet_id',$this->penggunaan_coolboxdet_id);
		$criteria->compare('daftardonasi_id',$this->daftardonasi_id);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('penggunaan_coolbox_id',$this->penggunaan_coolbox_id);
		$criteria->compare('nomorbarcod_sample',$this->nomorbarcod_sample,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}