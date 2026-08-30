<?php

/**
 * This is the model class for table "verifikasipenjualanfarmasi_t".
 *
 * The followings are the available columns in table 'verifikasipenjualanfarmasi_t':
 * @property integer $verifikasipenjualanfarmasi_id
 * @property integer $reseptur_id
 * @property integer $resepturdetail_id
 * @property string $create_time
 * @property string $update_time
 * @property boolean $is_jual
 * @property integer $create_ruangan_id
 * @property integer $create_pegawai_id
 * @property integer $pendaftaran_id
 */
class VerifikasipenjualanfarmasiT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'verifikasipenjualanfarmasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id', 'required'),
			array('verifikasipenjualanfarmasi_id, reseptur_id, resepturdetail_id, create_ruangan_id, create_pegawai_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time, is_jual', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('verifikasipenjualanfarmasi_id, reseptur_id, resepturdetail_id, create_time, update_time, is_jual, create_ruangan_id, create_pegawai_id, pendaftaran_id', 'safe', 'on'=>'search'),
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
			'verifikasipenjualanfarmasi_id' => 'Verifikasipenjualanfarmasi',
			'reseptur_id' => 'Reseptur',
			'resepturdetail_id' => 'Resepturdetail',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'is_jual' => 'Is Jual',
			'create_ruangan_id' => 'Create Ruangan',
			'create_pegawai_id' => 'Create Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('verifikasipenjualanfarmasi_id',$this->verifikasipenjualanfarmasi_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('is_jual',$this->is_jual);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('create_pegawai_id',$this->create_pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerifikasipenjualanfarmasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
