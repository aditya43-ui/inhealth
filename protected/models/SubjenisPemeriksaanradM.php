<?php

/**
 * This is the model class for table "subjenis_pemeriksaanrad_m".
 *
 * The followings are the available columns in table 'subjenis_pemeriksaanrad_m':
 * @property integer $subjenis_pemeriksaanrad_id
 * @property string $subjenis_pr_nama
 * @property string $subjenis_pr_namalainnya
 * @property boolean $subjenis_aktif
 */
class SubjenisPemeriksaanradM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subjenis_pemeriksaanrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subjenis_pr_nama, subjenis_pr_namalainnya', 'length', 'max'=>255),
			array('subjenis_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subjenis_pemeriksaanrad_id, subjenis_pr_nama, subjenis_pr_namalainnya, subjenis_aktif', 'safe', 'on'=>'search'),
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
			'subjenis_pemeriksaanrad_id' => 'Subjenis Pemeriksaanrad',
			'subjenis_pr_nama' => 'Nama Subjenis',
			'subjenis_pr_namalainnya' => 'Nama Subjenis Lainnya',
			'subjenis_aktif' => 'Status',
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

		$criteria->compare('subjenis_pemeriksaanrad_id',$this->subjenis_pemeriksaanrad_id);
		$criteria->compare('LOWER(subjenis_pr_nama)',strtolower($this->subjenis_pr_nama),true);
		$criteria->compare('LOWER(subjenis_pr_namalainnya)',strtolower($this->subjenis_pr_namalainnya),true);
		$criteria->compare('subjenis_aktif',$this->subjenis_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchTabel()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(subjenis_pr_nama)',strtolower($this->subjenis_pr_nama),true);
		$criteria->compare('LOWER(subjenis_pr_namalainnya)',strtolower($this->subjenis_pr_namalainnya),true);
		$criteria->compare('subjenis_aktif',$this->subjenis_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(subjenis_pr_nama)',strtolower($this->subjenis_pr_nama),true);
		$criteria->compare('LOWER(subjenis_pr_namalainnya)',strtolower($this->subjenis_pr_namalainnya),true);
		$criteria->compare('subjenis_aktif',$this->subjenis_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubjenisPemeriksaanradM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
