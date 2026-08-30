<?php

/**
 * This is the model class for table "pemeriksaanpartograflain_t".
 *
 * The followings are the available columns in table 'pemeriksaanpartograflain_t':
 * 
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 * @property integer $pemeriksaanpartograflain_id
 * @property integer $pemeriksaanpartograf_id
 * @property string $pendarahan
 * @property string $diagnosis_obstetri
 * @property string $diagnosis_nonobstetri
 * @property string $diagnosis_janin
 * @property integer $dokter_id
 * @property string $intruksi_dokter
 * @property integer $bidan_id
 * @property string $catatan_bidan
 * @property integer $perawat_id
 * @property string $catatan_perawat
 * @property string $oksigen
 * @property string $cairan_infus
 * @property string $laboratorium
 * @property string $oksitosin
 * @property string $produksi_urine
 */
class PemeriksaanpartograflainT extends CActiveRecord
{
        public $dokter_nama;
        public $bidan_nama;
        public $perawat_nama;
        public $nourutlain; 
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanpartograflainT the static model class
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
		return 'pemeriksaanpartograflain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanpartograf_id, pendarahan', 'required'),
			array('pemeriksaanpartograf_id, dokter_id, bidan_id, perawat_id', 'numerical', 'integerOnly'=>true),
			array('pendarahan', 'length', 'max'=>30),
			array('oksigen, cairan_infus, oksitosin, produksi_urine', 'length', 'max'=>50),
			array('diagnosis_obstetri, diagnosis_nonobstetri, diagnosis_janin, intruksi_dokter, catatan_bidan, catatan_perawat, laboratorium', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanpartograf_id, pendarahan, diagnosis_obstetri, diagnosis_nonobstetri, diagnosis_janin, dokter_id, intruksi_dokter, bidan_id, catatan_bidan, perawat_id, catatan_perawat, oksigen, cairan_infus, laboratorium, oksitosin, produksi_urine', 'safe', 'on'=>'search'),
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
			'pemeriksaanpartograflain_id' => 'Pemeriksaanpartograflain',
			'pemeriksaanpartograf_id' => 'Pemeriksaanpartograf',
			'pendarahan' => 'Pendarahan',
			'diagnosis_obstetri' => 'Diagnosis Obstetri',
			'diagnosis_nonobstetri' => 'Diagnosis Nonobstetri',
			'diagnosis_janin' => 'Diagnosis Janin',
			'dokter_id' => 'Dokter',
			'intruksi_dokter' => 'Intruksi Dokter',
			'bidan_id' => 'Bidan',
			'catatan_bidan' => 'Catatan Bidan',
			'perawat_id' => 'Perawat',
			'catatan_perawat' => 'Catatan Perawat',
			'oksigen' => 'Oksigen',
			'cairan_infus' => 'Cairan Infus',
			'laboratorium' => 'Laboratorium',
			'oksitosin' => 'Oksitosin',
			'produksi_urine' => 'Produksi Urine',
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

		$criteria->compare('pemeriksaanpartograflain_id',$this->pemeriksaanpartograflain_id);
		$criteria->compare('pemeriksaanpartograf_id',$this->pemeriksaanpartograf_id);
		$criteria->compare('pendarahan',$this->pendarahan,true);
		$criteria->compare('diagnosis_obstetri',$this->diagnosis_obstetri,true);
		$criteria->compare('diagnosis_nonobstetri',$this->diagnosis_nonobstetri,true);
		$criteria->compare('diagnosis_janin',$this->diagnosis_janin,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('intruksi_dokter',$this->intruksi_dokter,true);
		$criteria->compare('bidan_id',$this->bidan_id);
		$criteria->compare('catatan_bidan',$this->catatan_bidan,true);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('catatan_perawat',$this->catatan_perawat,true);
		$criteria->compare('oksigen',$this->oksigen,true);
		$criteria->compare('cairan_infus',$this->cairan_infus,true);
		$criteria->compare('laboratorium',$this->laboratorium,true);
		$criteria->compare('oksitosin',$this->oksitosin,true);
		$criteria->compare('produksi_urine',$this->produksi_urine,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}