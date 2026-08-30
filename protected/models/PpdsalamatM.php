<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @link http://172.9.1.15/simpp/docs/ 
 * This is the model class for table "ppdsalamat_m".
 *
 * The followings are the available columns in table 'ppdsalamat_m':
 * @property integer $ppdsalamat_id
 * @property integer $ppds_id
 * @property string $ppdsalamat_tipe
 * @property string $alamat
 * @property integer $alamat_rt
 * @property integer $alamat_rw
 * @property integer $propinsi_id
 * @property integer $kabupaten_id
 * @property integer $kecamatan_id
 * @property integer $kelurahan_id
 * @property string $kodepos
 * @property string $no_telepon
 * @property string $no_mobile
 * @property string $email
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 */
class PpdsalamatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PpdsalamatM the static model class
	 */
        public $propinsi_nama; 
        public $kabupaten_nama;
        public $kecamatan_nama; 
        public $kelurahan_nama; 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ppdsalamat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ppds_id, ppdsalamat_tipe, alamat, propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id, kodepos, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('ppds_id, alamat_rt, alamat_rw, propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('ppdsalamat_tipe', 'length', 'max'=>25),
			array('alamat, email', 'length', 'max'=>255),
			array('kodepos', 'length', 'max'=>5),
			array('no_telepon', 'length', 'max'=>12),
			array('no_mobile', 'length', 'max'=>16),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ppdsalamat_id, ppds_id, ppdsalamat_tipe, alamat, alamat_rt, alamat_rw, propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id, kodepos, no_telepon, no_mobile, email, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time, create_ruangan', 'safe', 'on'=>'search'),
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
                    'ppds' => array(self::BELONGS_TO, 'PpdsM', 'ppds_id'),
                    'propinsi' => array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
                    'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
                    'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
                    'kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'kelurahan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ppdsalamat_id' => 'Ppdsalamat',
			'ppds_id' => 'PPDS',
			'ppdsalamat_tipe' => 'Tipe',
			'alamat' => 'Alamat',
			'alamat_rt' => 'RT ',
			'alamat_rw' => 'RW',
			'propinsi_id' => 'Propinsi',
			'kabupaten_id' => 'Kabupaten',
			'kecamatan_id' => 'Kecamatan',
			'kelurahan_id' => 'Kelurahan',
			'kodepos' => 'Kode Pos',
			'no_telepon' => 'No Telepon',
			'no_mobile' => 'No Mobile',
			'email' => 'Email',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('ppdsalamat_id',$this->ppdsalamat_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('ppdsalamat_tipe',$this->ppdsalamat_tipe,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('alamat_rt',$this->alamat_rt);
		$criteria->compare('alamat_rw',$this->alamat_rw);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kodepos',$this->kodepos,true);
		$criteria->compare('no_telepon',$this->no_telepon,true);
		$criteria->compare('no_mobile',$this->no_mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}