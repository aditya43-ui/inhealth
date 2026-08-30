<?php

/**
 * This is the model class for table "perhitunganiwl_t".
 *
 * The followings are the available columns in table 'perhitunganiwl_t':
 * @property integer $perhitunganiwl_id
 * @property integer $balancecairan_id
 * @property string $waktupemeriksaan
 * @property string $jam_pemeriksaan
 * @property string $kelompokpasien
 * @property integer $usia_anak
 * @property double $beratbadan_kg
 * @property double $iwlperjam_normal
 * @property boolean $isterjadikenaikansuhu
 * @property double $cairanmasuk_total
 * @property double $kenaikansuhutubuh_jml
 * @property double $iwlperjam_kenaikansuhu
 * @property integer $jmljam_pemeriksaan
 * @property integer $iwl_nilaiakhir
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property BalancecairanT $balancecairan
 */
class PerhitunganiwlT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerhitunganiwlT the static model class
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
		return 'perhitunganiwl_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('balancecairan_id, create_time, create_loginpemakai_id', 'required'),
			array('balancecairan_id, usia_anak, jmljam_pemeriksaan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, iwlperjam_normal, cairanmasuk_total, kenaikansuhutubuh_jml, iwlperjam_kenaikansuhu, iwl_nilaiakhir', 'numerical'),
			array('waktupemeriksaan, kelompokpasien', 'length', 'max'=>50),
			array('jam_pemeriksaan, isterjadikenaikansuhu, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perhitunganiwl_id, balancecairan_id, waktupemeriksaan, jam_pemeriksaan, kelompokpasien, usia_anak, beratbadan_kg, iwlperjam_normal, isterjadikenaikansuhu, cairanmasuk_total, kenaikansuhutubuh_jml, iwlperjam_kenaikansuhu, jmljam_pemeriksaan, iwl_nilaiakhir, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'balancecairan' => array(self::BELONGS_TO, 'BalancecairanT', 'balancecairan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perhitunganiwl_id' => 'Perhitunganiwl',
			'balancecairan_id' => 'Balancecairan',
			'waktupemeriksaan' => 'Waktupemeriksaan',
			'jam_pemeriksaan' => 'Jam Pemeriksaan',
			'kelompokpasien' => 'Kelompokpasien',
			'usia_anak' => 'Usia Anak',
			'beratbadan_kg' => 'Beratbadan Kg',
			'iwlperjam_normal' => 'Iwlperjam Normal',
			'isterjadikenaikansuhu' => 'Isterjadikenaikansuhu',
			'cairanmasuk_total' => 'Cairanmasuk Total',
			'kenaikansuhutubuh_jml' => 'Kenaikansuhutubuh Jml',
			'iwlperjam_kenaikansuhu' => 'Iwlperjam Kenaikansuhu',
			'jmljam_pemeriksaan' => 'Jmljam Pemeriksaan',
			'iwl_nilaiakhir' => 'Iwl Nilaiakhir',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('perhitunganiwl_id',$this->perhitunganiwl_id);
		$criteria->compare('balancecairan_id',$this->balancecairan_id);
		$criteria->compare('waktupemeriksaan',$this->waktupemeriksaan,true);
		$criteria->compare('jam_pemeriksaan',$this->jam_pemeriksaan,true);
		$criteria->compare('kelompokpasien',$this->kelompokpasien,true);
		$criteria->compare('usia_anak',$this->usia_anak);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('iwlperjam_normal',$this->iwlperjam_normal);
		$criteria->compare('isterjadikenaikansuhu',$this->isterjadikenaikansuhu);
		$criteria->compare('cairanmasuk_total',$this->cairanmasuk_total);
		$criteria->compare('kenaikansuhutubuh_jml',$this->kenaikansuhutubuh_jml);
		$criteria->compare('iwlperjam_kenaikansuhu',$this->iwlperjam_kenaikansuhu);
		$criteria->compare('jmljam_pemeriksaan',$this->jmljam_pemeriksaan);
		$criteria->compare('iwl_nilaiakhir',$this->iwl_nilaiakhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}