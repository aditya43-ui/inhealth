<?php

/**
 * This is the model class for table "pasienrekonsiliasiobat_v".
 *
 * The followings are the available columns in table 'pasienrekonsiliasiobat_v':
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 */
class PasienrekonsiliasiobatV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $prefix_pendaftaran;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienrekonsiliasiobatV the static model class
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
		return 'pasienrekonsiliasiobat_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('statusperiksa, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('nama_pasien, tanggal_lahir, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, pasien_id, no_rekam_medik, nama_pasien, jeniskelamin, tanggal_lahir, tgl_pendaftaran, no_pendaftaran, statusperiksa, carabayar_nama, penjamin_nama', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'tanggal_lahir' => 'Tanggal Lahir',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'statusperiksa' => 'Status Periksa',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi()
	{
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
		$criteria->compare('statusperiksa',$this->statusperiksa);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
