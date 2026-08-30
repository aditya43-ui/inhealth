<?php

/**
 * This is the model class for table "balancecairandiet_t".
 *
 * The followings are the available columns in table 'balancecairandiet_t':
 * @property integer $balancecairandiet_id
 * @property integer $balancecairan_id
 * @property integer $waktu_pemberian
 * @property double $jumlah
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property BalancecairanT $balancecairan
 */
class BalancecairandietT extends CActiveRecord
{
	public $pasienadmisi_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BalancecairandietT the static model class
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
		return 'balancecairandiet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('balancecairan_id, create_time, create_loginpemakai, create_ruangan_id', 'required'),
			array('balancecairan_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			array('keterangan, create_loginpemakai, update_loginpemakai', 'length', 'max'=>200),
			array('waktu_pemberian', 'length', 'max'=>10),
			array('satuan_jumlah', 'length', 'max'=>50),
			array('update_time, jam_pemberian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('balancecairandiet_id, balancecairan_id, waktu_pemberian, jumlah, keterangan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id, jam_pemberian, satuan_jumlah', 'safe', 'on'=>'search'),
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
			'balancecairan' => array(self::BELONGS_TO, 'BalancecairanT', 'balancecairan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'balancecairandiet_id' => 'Balancecairandiet',
			'balancecairan_id' => 'Balancecairan',
			'waktu_pemberian' => 'Waktu Pemberian',
			'jumlah' => 'Jumlah',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('balancecairandiet_id',$this->balancecairandiet_id);
		$criteria->compare('balancecairan_id',$this->balancecairan_id);
		$criteria->compare('waktu_pemberian',$this->waktu_pemberian);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.waktu_pemberian, t.jumlah, t.keterangan, t.jam_pemberian, t.satuan_jumlah";
		$criteria->join = "JOIN balancecairan_t balance ON balance.balancecairan_id = t.balancecairan_id ";

		if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition('balance.pasienadmisi_id = '.$this->pasienadmisi_id);
		}

		if(!empty($this->balancecairan_id)){
				$criteria->addCondition('balance.balancecairan_id = '.$this->balancecairan_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
