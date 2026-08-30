<?php

/**
 * This is the model class for table "persetujuanumuminputandet_m".
 *
 * The followings are the available columns in table 'persetujuanumuminputandet_m':
 * @property integer $persetujuanumuminputandet_id
 * @property integer $persetujuanumuminputan_id
 * @property string $label_inputan
 * @property boolean $ismemilikisubinputan
 * @property string $informasisebelum_inputan
 * @property string $informasisesudah_inputan
 * @property integer $urutan
 * @property boolean $isaktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PersetujuanumuminputanM $persetujuanumuminputan
 */
class PersetujuanumuminputandetM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persetujuanumuminputandet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persetujuanumuminputan_id, urutan, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('persetujuanumuminputan_id, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('label_inputan, ismemilikisubinputan, informasisebelum_inputan, informasisesudah_inputan, isaktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('persetujuanumuminputandet_id, persetujuanumuminputan_id, label_inputan, ismemilikisubinputan, informasisebelum_inputan, informasisesudah_inputan, urutan, isaktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'persetujuanumuminputan' => array(self::BELONGS_TO, 'PersetujuanumuminputanM', 'persetujuanumuminputan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persetujuanumuminputandet_id' => 'Persetujuanumuminputandet',
			'persetujuanumuminputan_id' => 'Persetujuanumuminputan',
			'label_inputan' => 'Label Inputan',
			'ismemilikisubinputan' => 'Ismemilikisubinputan',
			'informasisebelum_inputan' => 'Informasisebelum Inputan',
			'informasisesudah_inputan' => 'Informasisesudah Inputan',
			'urutan' => 'Urutan',
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

		$criteria->compare('persetujuanumuminputandet_id',$this->persetujuanumuminputandet_id);
		$criteria->compare('persetujuanumuminputan_id',$this->persetujuanumuminputan_id);
		$criteria->compare('label_inputan',$this->label_inputan,true);
		$criteria->compare('ismemilikisubinputan',$this->ismemilikisubinputan);
		$criteria->compare('informasisebelum_inputan',$this->informasisebelum_inputan,true);
		$criteria->compare('informasisesudah_inputan',$this->informasisesudah_inputan,true);
		$criteria->compare('urutan',$this->urutan);
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
	 * @return PersetujuanumuminputandetM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
