<?php

/**
 * This is the model class for table "rekonsiliasiobatdet_t".
 *
 * The followings are the available columns in table 'rekonsiliasiobatdet_t':
 * @property integer $rekonsiliasiobatdet_id
 * @property integer $rekonsiliasiobat_id
 * @property integer $obatalkes_id
 * @property string $frekuensi_dosis
 * @property string $rute
 * @property boolean $islanjutadmisi
 * @property boolean $transfer1
 * @property boolean $transfer2
 * @property boolean $saatpulang
 * @property string $tgl_pengisianapoteker
 * @property integer $apoteker_pengisi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RekonsiliasiobatT $rekonsiliasiobat
 * @property ObatalkesM $obatalkes
 * @property PegawaiM $apotekerPengisi
 */
class RekonsiliasiobatdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonsiliasiobatdetT the static model class
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
		return 'rekonsiliasiobatdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekonsiliasiobat_id', 'required'),
			array('rekonsiliasiobat_id, apoteker_pengisi, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('frekuensi_dosis, rute, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('nama_obat', 'length', 'max'=>200),

			array('islanjutadmisi, transfer1, transfer2, saatpulang, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasiobatdet_id, rekonsiliasiobat_id, nama_obat, frekuensi_dosis, rute, islanjutadmisi, transfer1, transfer2, saatpulang, tgl_pengisianapoteker, apoteker_pengisi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'rekonsiliasiobat' => array(self::BELONGS_TO, 'RekonsiliasiobatT', 'rekonsiliasiobat_id'),
			'apotekerPengisi' => array(self::BELONGS_TO, 'PegawaiM', 'apoteker_pengisi'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonsiliasiobatdet_id' => 'Rekonsiliasiobatdet',
			'rekonsiliasiobat_id' => 'Rekonsiliasiobat',
			'frekuensi_dosis' => 'Frekuensi Dosis',
			'rute' => 'Rute',
			'islanjutadmisi' => 'Islanjutadmisi',
			'transfer1' => 'Transfer1',
			'transfer2' => 'Transfer2',
			'saatpulang' => 'Saatpulang',
			'tgl_pengisianapoteker' => 'Tgl Pengisianapoteker',
			'apoteker_pengisi' => 'Apoteker Pengisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('rekonsiliasiobatdet_id',$this->rekonsiliasiobatdet_id);
		$criteria->compare('rekonsiliasiobat_id',$this->rekonsiliasiobat_id);
		$criteria->compare('frekuensi_dosis',$this->frekuensi_dosis,true);
		$criteria->compare('rute',$this->rute,true);
		$criteria->compare('islanjutadmisi',$this->islanjutadmisi);
		$criteria->compare('transfer1',$this->transfer1);
		$criteria->compare('transfer2',$this->transfer2);
		$criteria->compare('saatpulang',$this->saatpulang);
		$criteria->compare('tgl_pengisianapoteker',$this->tgl_pengisianapoteker,true);
		$criteria->compare('apoteker_pengisi',$this->apoteker_pengisi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
