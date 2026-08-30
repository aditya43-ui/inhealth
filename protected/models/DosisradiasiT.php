<?php

/**
 * This is the model class for table "dosisradiasi_t".
 *
 * The followings are the available columns in table 'dosisradiasi_t':
 * @property integer $dosisradiasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $petugas_id
 * @property integer $berat_badan
 * @property string $tanggal_pencatatatan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property DosisradiasidetT[] $dosisradiasidetTs
 */
class DosisradiasiT extends CActiveRecord
{
	public $petugas_nama, $tanggal_pencatatatan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dosisradiasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmasukpenunjang_id, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('pasienmasukpenunjang_id, petugas_id, berat_badan', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai_id, update_loginpemakai_id', 'length', 'max'=>100),
			array('tanggal_pencatatatan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dosisradiasi_id, pasienmasukpenunjang_id, petugas_id, berat_badan, tanggal_pencatatatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'dosisradiasidetTs' => array(self::HAS_MANY, 'DosisradiasidetT', 'dosisradiasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dosisradiasi_id' => 'Dosisradiasi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'petugas_id' => 'Petugas',
			'berat_badan' => 'Berat Badan',
			'tanggal_pencatatatan' => 'Tanggal Pencatatatan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('dosisradiasi_id',$this->dosisradiasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('berat_badan',$this->berat_badan);
		$criteria->compare('tanggal_pencatatatan',$this->tanggal_pencatatatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DosisradiasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
