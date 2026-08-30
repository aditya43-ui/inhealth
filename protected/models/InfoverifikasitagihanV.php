<?php

/**
 * This is the model class for table "infoverifikasitagihan_v".
 *
 * The followings are the available columns in table 'infoverifikasitagihan_v':
 * @property integer $verifikasitagihan_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglverifikasi
 * @property string $noverifikasi
 * @property string $keteranganverifikasi
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 */
class InfoverifikasitagihanV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoverifikasitagihanV the static model class
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
		return 'infoverifikasitagihan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verifikasitagihan_id, pendaftaran_id, pasien_id, carabayar_id, penjamin_id, loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, nama_pemakai', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, noverifikasi', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('noverifikasi, tgl_pendaftaran, tglverifikasi, keteranganverifikasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasitagihan_id, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglverifikasi, noverifikasi, keteranganverifikasi, loginpemakai_id, nama_pemakai', 'safe', 'on'=>'search'),
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
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'tglverifikasi' => 'Tgl. Verifikasi',
			'noverifikasi' => 'No Verifikasi',
			'keteranganverifikasi' => 'Keterangan',
			'loginpemakai_id' => 'Loginpemakai',
			'nama_pemakai' => 'Verifikator',
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

		$criteria->compare('verifikasitagihan_id',$this->verifikasitagihan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tglverifikasi',$this->tglverifikasi,true);
		$criteria->compare('lower(noverifikasi)',strtolower($this->noverifikasi),true);
		$criteria->compare('keteranganverifikasi',$this->keteranganverifikasi,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi() {
		$cr = new CDbCriteria;
		
		$cr->addBetweenCondition('tglverifikasi::date', $this->tgl_awal, $this->tgl_akhir);
		$cr->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
		$cr->compare('lower(nama_pemakai)', strtolower($this->nama_pemakai), true);
		$cr->compare('lower(noverifikasi)',strtolower($this->noverifikasi),true);
		$cr->addCondition('loginpemakai_id = ' . Yii::app()->user->getState('loginpemakai_id'));
		
		return new CActiveDataProvider($this, array('criteria'=>$cr));
	}
}