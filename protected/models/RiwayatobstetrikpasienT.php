<?php

/**
 * This is the model class for table "riwayatobstetrikpasien_t".
 *
 * The followings are the available columns in table 'riwayatobstetrikpasien_t':
 * @property integer $riwayatobstetrikpasien_id
 * @property integer $asesmenawalkeperawatan_id
 * @property integer $kehamilan_hamilke
 * @property integer $kehamilan_umur
 * @property double $anak_beratbadanlahir
 * @property string $anak_satuanberatbadan
 * @property string $anak_jeniskelamin
 * @property string $persalinan_cara
 * @property string $persalinan_penolong
 * @property string $persalinan_tempat
 * @property boolean $isabortur
 * @property string $persalinan_komplikasiket
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class RiwayatobstetrikpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatobstetrikpasienT the static model class
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
		return 'riwayatobstetrikpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenawalkeperawatan_id', 'required'),
			array('asesmenawalkeperawatan_id, kehamilan_hamilke, kehamilan_umur', 'numerical', 'integerOnly'=>true),
			array('anak_beratbadanlahir', 'numerical'),
			array('anak_satuanberatbadan', 'length', 'max'=>10),
			array('anak_jeniskelamin', 'length', 'max'=>20),
			array('persalinan_cara, persalinan_penolong', 'length', 'max'=>100),
			array('persalinan_tempat', 'length', 'max'=>200),
			array('isabortur, persalinan_komplikasiket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatobstetrikpasien_id, asesmenawalkeperawatan_id, kehamilan_hamilke, kehamilan_umur, anak_beratbadanlahir, anak_satuanberatbadan, anak_jeniskelamin, persalinan_cara, persalinan_penolong, persalinan_tempat, isabortur, persalinan_komplikasiket', 'safe', 'on'=>'search'),
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
			'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayatobstetrikpasien_id' => 'Riwayatobstetrikpasien',
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'kehamilan_hamilke' => 'Kehamilan Hamilke',
			'kehamilan_umur' => 'Kehamilan Umur',
			'anak_beratbadanlahir' => 'Anak Beratbadanlahir',
			'anak_satuanberatbadan' => 'Anak Satuanberatbadan',
			'anak_jeniskelamin' => 'Anak Jeniskelamin',
			'persalinan_cara' => 'Persalinan Cara',
			'persalinan_penolong' => 'Persalinan Penolong',
			'persalinan_tempat' => 'Persalinan Tempat',
			'isabortur' => 'Isabortur',
			'persalinan_komplikasiket' => 'Persalinan Komplikasiket',
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

		$criteria->compare('riwayatobstetrikpasien_id',$this->riwayatobstetrikpasien_id);
		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('kehamilan_hamilke',$this->kehamilan_hamilke);
		$criteria->compare('kehamilan_umur',$this->kehamilan_umur);
		$criteria->compare('anak_beratbadanlahir',$this->anak_beratbadanlahir);
		$criteria->compare('anak_satuanberatbadan',$this->anak_satuanberatbadan,true);
		$criteria->compare('anak_jeniskelamin',$this->anak_jeniskelamin,true);
		$criteria->compare('persalinan_cara',$this->persalinan_cara,true);
		$criteria->compare('persalinan_penolong',$this->persalinan_penolong,true);
		$criteria->compare('persalinan_tempat',$this->persalinan_tempat,true);
		$criteria->compare('isabortur',$this->isabortur);
		$criteria->compare('persalinan_komplikasiket',$this->persalinan_komplikasiket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}