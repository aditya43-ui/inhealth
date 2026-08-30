<?php

/**
 * This is the model class for table "pemberianinformasi_t".
 *
 * The followings are the available columns in table 'pemberianinformasi_t':
 * @property integer $pemberianinformasi_id
 * @property integer $pendaftaran_id
 * @property integer $persetujuananestesi_id
 * @property string $penerimainformasi_nama
 * @property string $penerimainformasi_umur
 * @property string $penerimainformasi_jeniskelamin
 * @property string $penerimainformasi_alamat
 * @property string $penerimainformasi_hubungandgnpasien
 * @property string $penerimainformasi_jenisidentitas
 * @property string $penerimainformasi_noidentitas
 * @property integer $dokterpelaksanatindakan_id
 * @property integer $pemberiinformasi_id
 * @property string $jenisanestesi
 * @property string $subjenisanestesi
 * @property string $prognosis
 * @property integer $jenissurat_id
 * @property integer $daftartindakan_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PersetujuananestesiT $persetujuananestesi
 * @property PegawaiM $dokterpelaksanatindakan
 * @property PegawaiM $pemberiinformasi
 * @property PemberianinformasidetT[] $pemberianinformasidetTs
 */
class PemberianinformasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemberianinformasiT the static model class
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
		return 'pemberianinformasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jenissurat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, persetujuananestesi_id, dokterpelaksanatindakan_id, pemberiinformasi_id, jenissurat_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('penerimainformasi_nama', 'length', 'max'=>100),
			array('penerimainformasi_umur, penerimainformasi_jeniskelamin, penerimainformasi_hubungandgnpasien, penerimainformasi_jenisidentitas, penerimainformasi_noidentitas, jenisanestesi, subjenisanestesi', 'length', 'max'=>200),
			array('penerimainformasi_alamat, prognosis, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemberianinformasi_id, pendaftaran_id, persetujuananestesi_id, penerimainformasi_nama, penerimainformasi_umur, penerimainformasi_jeniskelamin, penerimainformasi_alamat, penerimainformasi_hubungandgnpasien, penerimainformasi_jenisidentitas, penerimainformasi_noidentitas, dokterpelaksanatindakan_id, pemberiinformasi_id, jenisanestesi, subjenisanestesi, prognosis, jenissurat_id, daftartindakan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'persetujuananestesi' => array(self::BELONGS_TO, 'PersetujuananestesiT', 'persetujuananestesi_id'),
			'dokterpelaksanatindakan' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpelaksanatindakan_id'),
			'pemberiinformasi' => array(self::BELONGS_TO, 'PegawaiM', 'pemberiinformasi_id'),
			'pemberianinformasidetTs' => array(self::HAS_MANY, 'PemberianinformasidetT', 'pemberianinformasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemberianinformasi_id' => 'Pemberianinformasi',
			'pendaftaran_id' => 'Pendaftaran',
			'persetujuananestesi_id' => 'Persetujuananestesi',
			'penerimainformasi_nama' => 'Penerimainformasi Nama',
			'penerimainformasi_umur' => 'Penerimainformasi Umur',
			'penerimainformasi_jeniskelamin' => 'Penerimainformasi Jeniskelamin',
			'penerimainformasi_alamat' => 'Penerimainformasi Alamat',
			'penerimainformasi_hubungandgnpasien' => 'Penerimainformasi Hubungandgnpasien',
			'penerimainformasi_jenisidentitas' => 'Penerimainformasi Jenisidentitas',
			'penerimainformasi_noidentitas' => 'Penerimainformasi Noidentitas',
			'dokterpelaksanatindakan_id' => 'Dokterpelaksanatindakan',
			'pemberiinformasi_id' => 'Pemberiinformasi',
			'jenisanestesi' => 'Jenisanestesi',
			'subjenisanestesi' => 'Subjenisanestesi',
			'prognosis' => 'Prognosis',
			'jenissurat_id' => 'Jenissurat',
			'daftartindakan_id' => 'Daftartindakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pemberianinformasi_id',$this->pemberianinformasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('persetujuananestesi_id',$this->persetujuananestesi_id);
		$criteria->compare('penerimainformasi_nama',$this->penerimainformasi_nama,true);
		$criteria->compare('penerimainformasi_umur',$this->penerimainformasi_umur,true);
		$criteria->compare('penerimainformasi_jeniskelamin',$this->penerimainformasi_jeniskelamin,true);
		$criteria->compare('penerimainformasi_alamat',$this->penerimainformasi_alamat,true);
		$criteria->compare('penerimainformasi_hubungandgnpasien',$this->penerimainformasi_hubungandgnpasien,true);
		$criteria->compare('penerimainformasi_jenisidentitas',$this->penerimainformasi_jenisidentitas,true);
		$criteria->compare('penerimainformasi_noidentitas',$this->penerimainformasi_noidentitas,true);
		$criteria->compare('dokterpelaksanatindakan_id',$this->dokterpelaksanatindakan_id);
		$criteria->compare('pemberiinformasi_id',$this->pemberiinformasi_id);
		$criteria->compare('jenisanestesi',$this->jenisanestesi,true);
		$criteria->compare('subjenisanestesi',$this->subjenisanestesi,true);
		$criteria->compare('prognosis',$this->prognosis,true);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}