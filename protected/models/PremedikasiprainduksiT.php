<?php

/**
 * This is the model class for table "premedikasiprainduksi_t".
 *
 * The followings are the available columns in table 'premedikasiprainduksi_t':
 * @property integer $premedikasiprainduksi_id
 * @property integer $asesmenprainduksi_id
 * @property double $obatalkes_id
 * @property integer $premedikasi_jumlah
 * @property string $premedikasi_jam
 * @property string $premedikasi_hasil
 *
 * The followings are the available model relations:
 * @property AsesmenprainduksiT $asesmenprainduksi
 */
class PremedikasiprainduksiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PremedikasiprainduksiT the static model class
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
		return 'premedikasiprainduksi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenprainduksi_id, obatalkes_id', 'required'),
			array('asesmenprainduksi_id, premedikasi_jumlah', 'numerical', 'integerOnly'=>true),
			array('obatalkes_id', 'numerical'),
			array('premedikasi_jam, premedikasi_hasil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('premedikasiprainduksi_id, asesmenprainduksi_id, obatalkes_id, premedikasi_jumlah, premedikasi_jam, premedikasi_hasil', 'safe', 'on'=>'search'),
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
			'asesmenprainduksi' => array(self::BELONGS_TO, 'AsesmenprainduksiT', 'asesmenprainduksi_id'),
                    'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'premedikasiprainduksi_id' => 'Premedikasiprainduksi',
			'asesmenprainduksi_id' => 'Asesmenprainduksi',
			'obatalkes_id' => 'Obat',
			'premedikasi_jumlah' => 'Jumlah',
			'premedikasi_jam' => 'Jam',
			'premedikasi_hasil' => 'Hasil Premedikasi',
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

		$criteria->compare('premedikasiprainduksi_id',$this->premedikasiprainduksi_id);
		$criteria->compare('asesmenprainduksi_id',$this->asesmenprainduksi_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('premedikasi_jumlah',$this->premedikasi_jumlah);
		$criteria->compare('premedikasi_jam',$this->premedikasi_jam,true);
		$criteria->compare('premedikasi_hasil',$this->premedikasi_hasil,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}