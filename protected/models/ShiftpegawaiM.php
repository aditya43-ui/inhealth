<?php

/**
 * This is the model class for table "shiftpegawai_m".
 *
 * The followings are the available columns in table 'shiftpegawai_m':
 * @property integer $shiftpegawai_id
 * @property integer $pegawai_id
 * @property integer $shift_id
 */
class ShiftpegawaiM extends CActiveRecord
{
	public $jamshift;
	public $namashift;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftpegawaiM the static model class
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
		return 'shiftpegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, shift_id', 'required'),
			array('pegawai_id, shift_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shiftpegawai_id, pegawai_id, shift_id', 'safe', 'on'=>'search'),
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
			'shift' => array(self::BELONGS_TO,'ShiftM','shift_id'),
			'pegawai' => array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shiftpegawai_id' => 'Shiftpegawai',
			'pegawai_id' => 'Pegawai',
			'shift_id' => 'Shift',
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

		$criteria->compare('shiftpegawai_id',$this->shiftpegawai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('shift_id',$this->shift_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getShiftPegawai($pegawai_id){
		$cri = new CDbCriteria();
		$cri->join = " JOIN shift_m s ON s.shift_id = t.shift_id ";
		$cri->addCondition(" s.shift_aktif = TRUE AND t.pegawai_id = '".$pegawai_id."' ");
		$cri->order = " s.shift_nama ASC ";
		
		return $this->model()->findAll($cri);
	}
	
	public function getShiftPegawaiJam(){
		return $this->shift->shiftJam;
	}
}