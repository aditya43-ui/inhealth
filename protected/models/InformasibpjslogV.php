<?php

/**
 * This is the model class for table "informasibpjslog_v".
 *
 * The followings are the available columns in table 'informasibpjslog_v':
 * @property integer $code
 * @property string $pesan
 * @property string $tgl_log
 * @property string $nama_pemakai
 * @property string $nama_pegawai
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $api
 * @property string $json_request_respose
 * @property string $ip_address
 */
class InformasibpjslogV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasibpjslog_v';
	}

	public $tgl_awal, $tgl_akhir;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('nama_pemakai, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pegawai', 'length', 'max'=>50),
			array('ip_address', 'length', 'max'=>255),
			array('pesan, tgl_log, tgl_pendaftaran, api, json_request_respose', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code, pesan, tgl_log, nama_pemakai, nama_pegawai, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, api, json_request_respose, ip_address', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'pesan' => 'Pesan',
			'tgl_log' => 'Tgl Log',
			'nama_pemakai' => 'Nama Pemakai',
			'nama_pegawai' => 'Nama Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'api' => 'Api',
			'json_request_respose' => 'Json Request',
			'ip_address' => 'Ip Address',
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

		$criteria->compare('code',$this->code);
		$criteria->compare('pesan',$this->pesan,true);
		$criteria->compare('tgl_log',$this->tgl_log,true);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('api',$this->api,true);
		$criteria->compare('json_request_respose',$this->json_request_respose,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchLog()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$this->no_pendaftaran = trim($this->no_pendaftaran);
		$criteria->addBetweenCondition('DATE(tgl_log)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
		$criteria->compare('json_request_respose', $this->json_request_respose, true);
		
		// echo "<pre>";
		// var_dump('testtt', $criteria);die;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasibpjslogV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
