<?php

/**
 * This is the model class for table "skrinningnyerianakdet_t".
 *
 * The followings are the available columns in table 'skrinningnyerianakdet_t':
 * @property integer $skrinningnyerianakdet_id
 * @property integer $asesmenawalkeperawatan_id
 * @property integer $kat_skalanyeri_id
 * @property integer $skalanyeriflaccs_param
 * @property integer $skalanyeriflaccs_nilai
 * @property string $tgl_asesmentnyerianakdet
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 * @property integer $create_pegawaipengisi_id
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class SkrinningnyerianakdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkrinningnyerianakdetT the static model class
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
		return 'skrinningnyerianakdet_t';
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
			array('asesmenawalkeperawatan_id, kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_nilai, create_ruangan_id, create_pegawaipengisi_id', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tgl_asesmentnyerianakdet, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('skrinningnyerianakdet_id, asesmenawalkeperawatan_id, kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_nilai, tgl_asesmentnyerianakdet, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id, create_pegawaipengisi_id', 'safe', 'on'=>'search'),
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
			'skrinningnyerianakdet_id' => 'Skrinningnyerianakdet',
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'kat_skalanyeri_id' => 'Kat Skalanyeri',
			'skalanyeriflaccs_param' => 'Skalanyeriflaccs Param',
			'skalanyeriflaccs_nilai' => 'Skalanyeriflaccs Nilai',
			'tgl_asesmentnyerianakdet' => 'Tgl Asesmentnyerianakdet',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'create_pegawaipengisi_id' => 'Create Pegawaipengisi',
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

		$criteria->compare('skrinningnyerianakdet_id',$this->skrinningnyerianakdet_id);
		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('kat_skalanyeri_id',$this->kat_skalanyeri_id);
		$criteria->compare('skalanyeriflaccs_param',$this->skalanyeriflaccs_param);
		$criteria->compare('skalanyeriflaccs_nilai',$this->skalanyeriflaccs_nilai);
		$criteria->compare('tgl_asesmentnyerianakdet',$this->tgl_asesmentnyerianakdet,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('create_pegawaipengisi_id',$this->create_pegawaipengisi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}