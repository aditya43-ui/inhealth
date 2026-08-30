<?php

/**
 * This is the model class for table "ambilpencucianlinenumumdet_t".
 *
 * The followings are the available columns in table 'ambilpencucianlinenumumdet_t':
 * @property integer $ambilpencucianlinenumumdet_id
 * @property integer $ambilpencucianlinenumum_id
 * @property string $namalinen
 * @property double $jumlah
 * @property string $satuan
 * @property string $keterangan
 */
class AmbilpencucianlinenumumdetT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ambilpencucianlinenumumdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ambilpencucianlinenumum_id', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			array('namalinen', 'length', 'max'=>30),
			array('satuan', 'length', 'max'=>20),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ambilpencucianlinenumumdet_id, ambilpencucianlinenumum_id, namalinen, jumlah, satuan, keterangan', 'safe', 'on'=>'search'),
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
			'ambilpencucianlinenumumdet_id' => 'Ambilpencucianlinenumumdet',
			'ambilpencucianlinenumum_id' => 'Ambilpencucianlinenumum',
			'namalinen' => 'Namalinen',
			'jumlah' => 'Jumlah',
			'satuan' => 'Satuan',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('ambilpencucianlinenumumdet_id',$this->ambilpencucianlinenumumdet_id);
		$criteria->compare('ambilpencucianlinenumum_id',$this->ambilpencucianlinenumum_id);
		$criteria->compare('namalinen',$this->namalinen,true);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('satuan',$this->satuan,true);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AmbilpencucianlinenumumdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
