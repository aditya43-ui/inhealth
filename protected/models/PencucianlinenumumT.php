<?php

/**
 * This is the model class for table "pencucianlinenumum_t".
 *
 * The followings are the available columns in table 'pencucianlinenumum_t':
 * @property integer $pencucianlinenumum_id
 * @property integer $terimapencucianlinenumum_id
 * @property string $tglpencucian
 * @property string $nopencucian
 * @property integer $mesinpencucian_id
 * @property string $keterangan
 * @property integer $pegawaimengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class PencucianlinenumumT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pencucianlinenumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimapencucianlinenumum_id, mesinpencucian_id, pegawaimengetahui_id, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('nopencucian', 'length', 'max'=>25),
			array('tglpencucian, keterangan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pencucianlinenumum_id, terimapencucianlinenumum_id, tglpencucian, nopencucian, mesinpencucian_id, keterangan, pegawaimengetahui_id, create_time, update_time, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
                    'pegawaimengetahui'=>[self::BELONGS_TO,'PegawaiM','pegawaimengetahui_id'],
                    'mesinpencucian'=>[self::BELONGS_TO,'MesinpencucianM','mesinpencucian_id']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencucianlinenumum_id' => 'Pencucianlinenumum',
			'terimapencucianlinenumum_id' => 'Terimapencucianlinenumum',
			'tglpencucian' => 'Tglpencucian',
			'nopencucian' => 'Nopencucian',
			'mesinpencucian_id' => 'Mesinpencucian',
			'keterangan' => 'Keterangan',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pencucianlinenumum_id',$this->pencucianlinenumum_id);
		$criteria->compare('terimapencucianlinenumum_id',$this->terimapencucianlinenumum_id);
		$criteria->compare('tglpencucian',$this->tglpencucian,true);
		$criteria->compare('nopencucian',$this->nopencucian,true);
		$criteria->compare('mesinpencucian_id',$this->mesinpencucian_id);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
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
	 * @return PencucianlinenumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
