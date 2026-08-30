<?php

/**
 * This is the model class for table "prioritastriage_m".
 *
 * The followings are the available columns in table 'prioritastriage_m':
 * @property integer $prioritastriage_id
 * @property string $metode_triage
 * @property string $jenis_triage
 * @property string $prioritas_nama
 * @property string $warna
 * @property integer $urutan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property DetailpemeriksaantriageM[] $detailpemeriksaantriageMs
 * @property AsesmentriagewpssT[] $asesmentriagewpssTs
 * @property AsesmentriageesiT[] $asesmentriageesiTs
 */
class PrioritastriageM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prioritastriage_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metode_triage, jenis_triage, prioritas_nama, warna, urutan, create_time, create_loginpemakai_id', 'required'),
			array('urutan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('metode_triage, jenis_triage, warna', 'length', 'max'=>50),
			array('prioritas_nama', 'length', 'max'=>200),
			array('isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('prioritastriage_id, metode_triage, jenis_triage, prioritas_nama, warna, urutan, isaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'detailpemeriksaantriageMs' => array(self::HAS_MANY, 'DetailpemeriksaantriageM', 'prioritastriage_id'),
			'asesmentriagewpssTs' => array(self::HAS_MANY, 'AsesmentriagewpssT', 'prioritastriage_id'),
			'asesmentriageesiTs' => array(self::HAS_MANY, 'AsesmentriageesiT', 'prioritastriage_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prioritastriage_id' => 'Prioritastriage',
			'metode_triage' => 'Metode Triage',
			'jenis_triage' => 'Jenis Triage',
			'prioritas_nama' => 'Prioritas Nama',
			'warna' => 'Warna',
			'urutan' => 'Urutan',
			'isaktif' => 'Isaktif',
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

		$criteria->compare('prioritastriage_id',$this->prioritastriage_id);
		$criteria->compare('metode_triage',$this->metode_triage,true);
		$criteria->compare('jenis_triage',$this->jenis_triage,true);
		$criteria->compare('prioritas_nama',$this->prioritas_nama,true);
		$criteria->compare('warna',$this->warna,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('isaktif',$this->isaktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrioritastriageM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
