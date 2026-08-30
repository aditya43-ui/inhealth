<?php

/**
 * This is the model class for table "pemeriksaantriage_m".
 *
 * The followings are the available columns in table 'pemeriksaantriage_m':
 * @property integer $pemeriksaantriage_id
 * @property string $metode_triage
 * @property string $jenis_triage
 * @property string $nama_pemeriksaan
 * @property integer $urutan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property DetailpemeriksaantriageM[] $detailpemeriksaantriageMs
 * @property AsesmentriagewpssdetT[] $asesmentriagewpssdetTs
 * @property AsesmentriageesidetT[] $asesmentriageesidetTs
 */
class PemeriksaantriageM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaantriage_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metode_triage, jenis_triage, nama_pemeriksaan, urutan, create_time, create_loginpemakai', 'required'),
			array('urutan, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('metode_triage, jenis_triage', 'length', 'max'=>50),
			array('nama_pemeriksaan', 'length', 'max'=>200),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaantriage_id, metode_triage, jenis_triage, nama_pemeriksaan, urutan, isaktif, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'detailpemeriksaantriageMs' => array(self::HAS_MANY, 'DetailpemeriksaantriageM', 'pemeriksaantriage_id'),
			'asesmentriagewpssdetTs' => array(self::HAS_MANY, 'AsesmentriagewpssdetT', 'pemeriksaantriage_id'),
			'asesmentriageesidetTs' => array(self::HAS_MANY, 'AsesmentriageesidetT', 'pemeriksaantriage_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaantriage_id' => 'Pemeriksaantriage',
			'metode_triage' => 'Metode Triage',
			'jenis_triage' => 'Jenis Triage',
			'nama_pemeriksaan' => 'Nama Pemeriksaan',
			'urutan' => 'Urutan',
			'isaktif' => 'Isaktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('pemeriksaantriage_id',$this->pemeriksaantriage_id);
		$criteria->compare('metode_triage',$this->metode_triage,true);
		$criteria->compare('jenis_triage',$this->jenis_triage,true);
		$criteria->compare('nama_pemeriksaan',$this->nama_pemeriksaan,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('isaktif',$this->isaktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaantriageM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
