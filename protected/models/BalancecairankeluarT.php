<?php

/**
 * This is the model class for table "balancecairankeluar_t".
 *
 * The followings are the available columns in table 'balancecairankeluar_t':
 * @property integer $balancecairankeluar_id
 * @property integer $balancecairan_id
 * @property string $nama_cairan
 * @property integer $waktu_pemberian
 * @property double $jumlah
 * @property boolean $statuspenggunaan
 * @property string $waktu_pemasangan
 * @property string $balance_cairan
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
class BalancecairankeluarT extends CActiveRecord
{
	public $pasienadmisi_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BalancecairankeluarT the static model class
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
		return 'balancecairankeluar_t';
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
			array('nama_cairan, balance_cairan, keterangan, create_loginpemakai, update_loginpemakai', 'length', 'max'=>200),
			array('waktu_pemberian', 'length', 'max'=>10),
			array('satuan_jumlah', 'length', 'max'=>50),
			array('statuspenggunaan, waktu_pemasangan, update_time, jam', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('balancecairankeluar_id, balancecairan_id, nama_cairan, waktu_pemberian, jumlah, statuspenggunaan, waktu_pemasangan, balance_cairan, keterangan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id, jam, satuan_jumlah', 'safe', 'on'=>'search'),
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
			'balancecairankeluar_id' => 'Balancecairankeluar',
			'balancecairan_id' => 'Balancecairan',
			'nama_cairan' => 'Nama Cairan',
			'waktu_pemberian' => 'Waktu Pemberian',
			'jumlah' => 'Jumlah',
			'statuspenggunaan' => 'Statuspenggunaan',
			'waktu_pemasangan' => 'Waktu Pemasangan',
			'balance_cairan' => 'Balance Cairan',
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

		$criteria->compare('balancecairankeluar_id',$this->balancecairankeluar_id);
		$criteria->compare('balancecairan_id',$this->balancecairan_id);
		$criteria->compare('nama_cairan',$this->nama_cairan,true);
		$criteria->compare('waktu_pemberian',$this->waktu_pemberian);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('statuspenggunaan',$this->statuspenggunaan);
		$criteria->compare('waktu_pemasangan',$this->waktu_pemasangan,true);
		$criteria->compare('balance_cairan',$this->balance_cairan,true);
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
		$criteria->select = "t.nama_cairan, t.waktu_pemberian, t.jumlah, t.statuspenggunaan, t.waktu_pemasangan, t.keterangan, t.balance_cairan, t.jam, t.satuan_jumlah";
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
