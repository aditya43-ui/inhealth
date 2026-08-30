<?php

/**
 * This is the model class for table "pencarianseprujukankeluar_v".
 *
 * The followings are the available columns in table 'pencarianseprujukankeluar_v':
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $klsrawat
 * @property integer $pegawai_id
 */
class PencarianseprujukankeluarV extends CActiveRecord
{
        public $default;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencarianseprujukankeluarV the static model class
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
		return 'pencarianseprujukankeluar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sep_id, klsrawat, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nosep', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien', 'length', 'max'=>50),
			array('jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('tglsep, tanggal_lahir, alamat_pasien, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sep_id, tglsep, nosep, no_rekam_medik, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, no_pendaftaran, tgl_pendaftaran, klsrawat, pegawai_id', 'safe', 'on'=>'search'),
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
			'sep_id' => 'Sep',
			'tglsep' => 'Tgl SEP',
			'nosep' => 'No SEP',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'klsrawat' => 'Klsrawat',
			'pegawai_id' => 'Pegawai',
                        'Nokartuasuransi' => 'No Kartu Peserta'
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

		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('tglsep',$this->tglsep,true);
		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('klsrawat',$this->klsrawat);
		$criteria->compare('pegawai_id',$this->pegawai_id);
                
                if (!empty($this->default)){
                    $criteria->addCondition(" sep_id IS NULL ");
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}