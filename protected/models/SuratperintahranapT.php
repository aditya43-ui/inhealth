<?php

/**
 * This is the model class for table "suratperintahranap_t".
 *
 * The followings are the available columns in table 'suratperintahranap_t':
 * @property integer $suratperintahranap_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienpulang_id
 * @property integer $profilrs_id
 * @property string $tgl_suratperintahranap
 * @property string $nourutsurat
 * @property string $nomorsurat
 * @property integer $dokterpembuatsurat_id
 * @property integer $ruangansurat_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 * @property string $tgl_rencanaranap
 * @property string $nomorspri_bpjs
 * @property integer $spesialissubspesialis_id
 * @property integer $dpjp_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PasienpulangT $pasienpulang
 * @property ProfilrumahsakitM $profilrs
 * @property PegawaiM $dokterpembuatsurat
 * @property RuanganM $ruangansurat
 */
class SuratperintahranapT extends CActiveRecord
{
    public $dokterpembuatsurat_nama;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratperintahranapT the static model class
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
		return 'suratperintahranap_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_rencanaranap, pendaftaran_id, pasien_id, pasienpulang_id, profilrs_id, nourutsurat, nomorsurat, ruangansurat_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasien_id, pasienpulang_id, profilrs_id, dokterpembuatsurat_id, ruangansurat_id, create_petugaspengisi_id, create_ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('nomorsurat', 'length', 'max'=>200),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('dpjp_id, spesialissubspesialis_id, nomorspri_bpjs, tgl_suratperintahranap, update_time, therapi_sementara, isranap_perinatologi, responspri_bpjs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratperintahranap_id, pendaftaran_id, pasien_id, pasienpulang_id, profilrs_id, tgl_suratperintahranap, nourutsurat, nomorsurat, dokterpembuatsurat_id, ruangansurat_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, therapi_sementara, instalasi_id, isranap_perinatologi, responspri_bpjs', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienpulang' => array(self::BELONGS_TO, 'PasienpulangT', 'pasienpulang_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'dokterpembuatsurat' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpembuatsurat_id'),
			'ruangansurat' => array(self::BELONGS_TO, 'RuanganM', 'ruangansurat_id'),
			'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratperintahranap_id' => 'Suratperintahranap',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienpulang_id' => 'Pasienpulang',
			'profilrs_id' => 'Profilrs',
			'tgl_suratperintahranap' => 'Tgl Suratperintahranap',
			'nourutsurat' => 'Nourutsurat',
			'nomorsurat' => 'Nomorsurat',
			'dokterpembuatsurat_id' => 'Dokterpembuatsurat',
			'ruangansurat_id' => 'Ruangansurat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
			'nomorspri_bpjs' => 'Nomor SPRI BPJS',
			'spesialissubspesialis_id' => 'Spesialis / Subspesialis',
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

		$criteria->compare('suratperintahranap_id',$this->suratperintahranap_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('tgl_suratperintahranap',$this->tgl_suratperintahranap,true);
		$criteria->compare('nourutsurat',$this->nourutsurat,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('dokterpembuatsurat_id',$this->dokterpembuatsurat_id);
		$criteria->compare('ruangansurat_id',$this->ruangansurat_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	function getItemPegawaiDokter()
	{
		$criteria = new CDbCriteria();
		$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_DOKTER_SPESIALIS, Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP));
		$criteria->limit = 20;
		$list = CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'namaLengkap');
		return $list;
	}
}
