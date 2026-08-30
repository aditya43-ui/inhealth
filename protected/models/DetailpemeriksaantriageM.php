<?php

/**
 * This is the model class for table "detailpemeriksaantriage_m".
 *
 * The followings are the available columns in table 'detailpemeriksaantriage_m':
 * @property integer $detailpemeriksaantriage_id
 * @property integer $prioritastriage_id
 * @property integer $pemeriksaantriage_id
 * @property string $detailpemeriksaantriage_nama
 * @property boolean $isada_keterangan
 * @property integer $skor
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
 * @property PemeriksaantriageM $pemeriksaantriage
 * @property PrioritastriageM $prioritastriage
 * @property AsesmentriagewpssdetT[] $asesmentriagewpssdetTs
 */
class DetailpemeriksaantriageM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detailpemeriksaantriage_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaantriage_id, detailpemeriksaantriage_nama, urutan, create_time, create_loginpemakai', 'required'),
			array('prioritastriage_id, pemeriksaantriage_id, skor, urutan, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('isada_keterangan, isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('detailpemeriksaantriage_id, prioritastriage_id, pemeriksaantriage_id, detailpemeriksaantriage_nama, isada_keterangan, skor, urutan, isaktif, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pemeriksaantriage' => array(self::BELONGS_TO, 'PemeriksaantriageM', 'pemeriksaantriage_id'),
			'prioritastriage' => array(self::BELONGS_TO, 'PrioritastriageM', 'prioritastriage_id'),
			'asesmentriagewpssdetTs' => array(self::HAS_MANY, 'AsesmentriagewpssdetT', 'detailpemeriksaantriage_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'detailpemeriksaantriage_id' => 'Detailpemeriksaantriage',
			'prioritastriage_id' => 'Prioritastriage',
			'pemeriksaantriage_id' => 'Pemeriksaantriage',
			'detailpemeriksaantriage_nama' => 'Detailpemeriksaantriage Nama',
			'isada_keterangan' => 'Isada Keterangan',
			'skor' => 'Skor',
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

		$criteria->compare('detailpemeriksaantriage_id',$this->detailpemeriksaantriage_id);
		$criteria->compare('prioritastriage_id',$this->prioritastriage_id);
		$criteria->compare('pemeriksaantriage_id',$this->pemeriksaantriage_id);
		$criteria->compare('detailpemeriksaantriage_nama',$this->detailpemeriksaantriage_nama,true);
		$criteria->compare('isada_keterangan',$this->isada_keterangan);
		$criteria->compare('skor',$this->skor);
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
	 * @return DetailpemeriksaantriageM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
