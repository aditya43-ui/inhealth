<?php

/**
 * This is the model class for table "persetujuanumuminputan_m".
 *
 * The followings are the available columns in table 'persetujuanumuminputan_m':
 * @property integer $persetujuanumuminputan_id
 * @property integer $persetujuanumumisi_id
 * @property string $tipeinput
 * @property string $kalimatsebelum_inputan
 * @property integer $inputan_jumlah
 * @property string $kalimatsetelah_inputan
 * @property integer $inputan_urutan
 * @property boolean $isada_subinputan
 * @property integer $subinputan_jumlah
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PersetujuanumumisiM $persetujuanumumisi
 * @property PersetujuanumuminputandetM[] $persetujuanumuminputandetMs
 */
class PersetujuanumuminputanM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persetujuanumuminputan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persetujuanumumisi_id, tipeinput, inputan_jumlah, inputan_urutan, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('persetujuanumumisi_id, inputan_jumlah, inputan_urutan, subinputan_jumlah, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tipeinput', 'length', 'max'=>50),
			array('kalimatsebelum_inputan, kalimatsetelah_inputan, isada_subinputan, isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('persetujuanumuminputan_id, persetujuanumumisi_id, tipeinput, kalimatsebelum_inputan, inputan_jumlah, kalimatsetelah_inputan, inputan_urutan, isada_subinputan, subinputan_jumlah, isaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'persetujuanumumisi' => array(self::BELONGS_TO, 'PersetujuanumumisiM', 'persetujuanumumisi_id'),
			'persetujuanumuminputandetMs' => array(self::HAS_MANY, 'PersetujuanumuminputandetM', 'persetujuanumuminputan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persetujuanumuminputan_id' => 'Persetujuanumuminputan',
			'persetujuanumumisi_id' => 'Persetujuanumumisi',
			'tipeinput' => 'Tipeinput',
			'kalimatsebelum_inputan' => 'Kalimatsebelum Inputan',
			'inputan_jumlah' => 'Inputan Jumlah',
			'kalimatsetelah_inputan' => 'Kalimatsetelah Inputan',
			'inputan_urutan' => 'Inputan Urutan',
			'isada_subinputan' => 'Isada Subinputan',
			'subinputan_jumlah' => 'Subinputan Jumlah',
			'isaktif' => 'Isaktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('persetujuanumuminputan_id',$this->persetujuanumuminputan_id);
		$criteria->compare('persetujuanumumisi_id',$this->persetujuanumumisi_id);
		$criteria->compare('tipeinput',$this->tipeinput,true);
		$criteria->compare('kalimatsebelum_inputan',$this->kalimatsebelum_inputan,true);
		$criteria->compare('inputan_jumlah',$this->inputan_jumlah);
		$criteria->compare('kalimatsetelah_inputan',$this->kalimatsetelah_inputan,true);
		$criteria->compare('inputan_urutan',$this->inputan_urutan);
		$criteria->compare('isada_subinputan',$this->isada_subinputan);
		$criteria->compare('subinputan_jumlah',$this->subinputan_jumlah);
		$criteria->compare('isaktif',$this->isaktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersetujuanumuminputanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
