<?php

/**
 * This is the model class for table "lapverifikasiinasis_v".
 *
 * The followings are the available columns in table 'lapverifikasiinasis_v':
 * @property string $verifikasiinasis_tglmasuk
 * @property integer $verifikasiinasis_id
 * @property string $verifikasiinasis_tglkeluar
 * @property string $verifikasiinasis_jnspelayanan
 * @property string $verifikasiinasis_kelaspelayanan
 * @property string $verifikasiinasis_status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $sep_id
 * @property integer $inacbg_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nosep
 * @property string $kodeinacbg
 * @property string $no_identitas_pasien
 * @property integer $verifikasiklaiminasis_id
 * @property string $verifikasi_jnspelayanan
 * @property double $verifikasi_bytopup
 * @property double $verifikasi_bytarifgruper
 * @property double $verifikasi_bytagihan
 * @property string $verifikasi_nokartu
 * @property double $verifikasi_bytarifrs
 * @property string $verifikasi_tglsep
 * @property string $verifikasi_tglpulang
 * @property string $nama_pasien
 * @property string $verifikasi_nminacbg
 * @property string $verifikasi_kdinacbg
 */
class LapverifikasiinasisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapverifikasiinasisV the static model class
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
		return 'lapverifikasiinasis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verifikasiinasis_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sep_id, inacbg_id, pasien_id, verifikasiklaiminasis_id', 'numerical', 'integerOnly'=>true),
			array('verifikasi_bytopup, verifikasi_bytarifgruper, verifikasi_bytagihan, verifikasi_bytarifrs', 'numerical'),
			array('verifikasiinasis_jnspelayanan, verifikasiinasis_kelaspelayanan, verifikasiinasis_status, nosep, verifikasi_jnspelayanan, verifikasi_nokartu', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('kodeinacbg, nama_pasien, verifikasi_kdinacbg', 'length', 'max'=>50),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('verifikasi_nminacbg', 'length', 'max'=>200),
			array('verifikasiinasis_tglmasuk, verifikasiinasis_tglkeluar, create_time, update_time, verifikasi_tglsep, verifikasi_tglpulang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasiinasis_tglmasuk, verifikasiinasis_id, verifikasiinasis_tglkeluar, verifikasiinasis_jnspelayanan, verifikasiinasis_kelaspelayanan, verifikasiinasis_status, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sep_id, inacbg_id, pasien_id, no_rekam_medik, nosep, kodeinacbg, no_identitas_pasien, verifikasiklaiminasis_id, verifikasi_jnspelayanan, verifikasi_bytopup, verifikasi_bytarifgruper, verifikasi_bytagihan, verifikasi_nokartu, verifikasi_bytarifrs, verifikasi_tglsep, verifikasi_tglpulang, nama_pasien, verifikasi_nminacbg, verifikasi_kdinacbg', 'safe', 'on'=>'search'),
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
			'verifikasiinasis_tglmasuk' => 'Verifikasiinasis Tglmasuk',
			'verifikasiinasis_id' => 'Verifikasiinasis',
			'verifikasiinasis_tglkeluar' => 'Verifikasiinasis Tglkeluar',
			'verifikasiinasis_jnspelayanan' => 'Verifikasiinasis Jnspelayanan',
			'verifikasiinasis_kelaspelayanan' => 'Verifikasiinasis Kelaspelayanan',
			'verifikasiinasis_status' => 'Verifikasiinasis Status',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'sep_id' => 'Sep',
			'inacbg_id' => 'Inacbg',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nosep' => 'Nosep',
			'kodeinacbg' => 'Kodeinacbg',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'verifikasiklaiminasis_id' => 'Verifikasiklaiminasis',
			'verifikasi_jnspelayanan' => 'Verifikasi Jnspelayanan',
			'verifikasi_bytopup' => 'Verifikasi Bytopup',
			'verifikasi_bytarifgruper' => 'Verifikasi Bytarifgruper',
			'verifikasi_bytagihan' => 'Verifikasi Bytagihan',
			'verifikasi_nokartu' => 'Verifikasi Nokartu',
			'verifikasi_bytarifrs' => 'Verifikasi Bytarifrs',
			'verifikasi_tglsep' => 'Verifikasi Tglsep',
			'verifikasi_tglpulang' => 'Verifikasi Tglpulang',
			'nama_pasien' => 'Nama Pasien',
			'verifikasi_nminacbg' => 'Verifikasi Nminacbg',
			'verifikasi_kdinacbg' => 'Verifikasi Kdinacbg',
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

		$criteria->compare('verifikasiinasis_tglmasuk',$this->verifikasiinasis_tglmasuk,true);
		$criteria->compare('verifikasiinasis_id',$this->verifikasiinasis_id);
		$criteria->compare('verifikasiinasis_tglkeluar',$this->verifikasiinasis_tglkeluar,true);
		$criteria->compare('verifikasiinasis_jnspelayanan',$this->verifikasiinasis_jnspelayanan,true);
		$criteria->compare('verifikasiinasis_kelaspelayanan',$this->verifikasiinasis_kelaspelayanan,true);
		$criteria->compare('verifikasiinasis_status',$this->verifikasiinasis_status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('inacbg_id',$this->inacbg_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('kodeinacbg',$this->kodeinacbg,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('verifikasiklaiminasis_id',$this->verifikasiklaiminasis_id);
		$criteria->compare('verifikasi_jnspelayanan',$this->verifikasi_jnspelayanan,true);
		$criteria->compare('verifikasi_bytopup',$this->verifikasi_bytopup);
		$criteria->compare('verifikasi_bytarifgruper',$this->verifikasi_bytarifgruper);
		$criteria->compare('verifikasi_bytagihan',$this->verifikasi_bytagihan);
		$criteria->compare('verifikasi_nokartu',$this->verifikasi_nokartu,true);
		$criteria->compare('verifikasi_bytarifrs',$this->verifikasi_bytarifrs);
		$criteria->compare('verifikasi_tglsep',$this->verifikasi_tglsep,true);
		$criteria->compare('verifikasi_tglpulang',$this->verifikasi_tglpulang,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('verifikasi_nminacbg',$this->verifikasi_nminacbg,true);
		$criteria->compare('verifikasi_kdinacbg',$this->verifikasi_kdinacbg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}