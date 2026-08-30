<?php

/**
 * This is the model class for table "riwayatkehamilan_t".
 *
 * The followings are the available columns in table 'riwayatkehamilan_t':
 * @property integer $riwayatkehamilan_id
 * @property integer $pemeriksaanginekologi_id
 * @property integer $anak_ke
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PemeriksaanginekologiT $pemeriksaanginekologi
 */
class RiwayatkehamilanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatkehamilanT the static model class
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
		return 'riwayatkehamilan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanginekologi_id', 'required'),
			array('pemeriksaanginekologi_id, anak_ke, hamil_ke, suami_ke, umurkehamilan_minggu', 'numerical', 'integerOnly'=>true),
			array('anak_beratbadanlahir', 'numerical'),
			array('keterangan, anak_keadaanlahir', 'length', 'max'=>100),
			array('persalinan_penolong, persalinan_jenis, persalinan_penyulit, nifas, kb_cara', 'length', 'max'=>200),
			array('anak_jeniskelamin', 'length', 'max'=>50),
			array('anak_beratbadanlahirsatuan', 'length', 'max'=>20),
			array('anak_lamapersalinanmenit', 'length', 'max'=>10),
			
			array('penyulit_kehamilan', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatkehamilan_id, pemeriksaanginekologi_id, anak_ke, keterangan, hamil_ke, suami_ke, umurkehamilan_minggu, penyulit_kehamilan, persalinan_penolong, persalinan_jenis, persalinan_penyulit, nifas, kb_cara, anak_jeniskelamin, anak_beratbadanlahir, anak_beratbadanlahirsatuan, anak_keadaanlahir, anak_lamapersalinanmenit', 'safe', 'on'=>'search'),
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
			'pemeriksaanginekologi' => array(self::BELONGS_TO, 'PemeriksaanginekologiT', 'pemeriksaanginekologi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayatkehamilan_id' => 'Riwayatkehamilan',
			'pemeriksaanginekologi_id' => 'Pemeriksaanginekologi',
			'anak_ke' => 'Anak Ke',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('riwayatkehamilan_id',$this->riwayatkehamilan_id);
		$criteria->compare('pemeriksaanginekologi_id',$this->pemeriksaanginekologi_id);
		$criteria->compare('anak_ke',$this->anak_ke);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}