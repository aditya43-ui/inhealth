<?php

/**
 * This is the model class for table "pasienmorbiditas_r".
 *
 * The followings are the available columns in table 'pasienmorbiditas_r':
 * @property integer $pasienmorbiditas_id
 * @property integer $morfologineoplasma_id
 * @property integer $kamarruangan_id
 * @property integer $jenisketunaan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $ruangan_id
 * @property integer $diagnosaicdix_id
 * @property integer $pegawai_id
 * @property integer $sebabdiagnosa_id
 * @property integer $kelompokumur_id
 * @property integer $diagnosa_id
 * @property integer $sebabin_id
 * @property integer $pasien_id
 * @property integer $jenisin_id
 * @property integer $kelompokdiagnosa_id
 * @property integer $golonganumur_id
 * @property integer $pendaftaran_id
 * @property integer $penyebabluarcedera_id
 * @property integer $pasienadmisi_id
 * @property string $tglmorbiditas
 * @property string $kasusdiagnosa
 * @property integer $umur_0_28hr
 * @property integer $umur_28hr_1thn
 * @property integer $umur_1_4thn
 * @property integer $umur_5_14thn
 * @property integer $umur_15_24thn
 * @property integer $umur_25_44thn
 * @property integer $umur_45_64thn
 * @property integer $umur_65
 * @property boolean $infeksinosokomial
 * @property integer $laki_laki
 * @property integer $perempuan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $tglpenghapusankemenkes
 * @property integer $pegawaipenghapusankemenkes
 * @property string $tglpengiriminkemenkes
 * @property integer $pegawaipengirimkemenkes
 * @property string $tglubahpengirimankemenkes
 * @property integer $pegawaiubahpengirimankemenkes
 * @property string $logpenghapusandatakemenkes
 * @property string $statuspengiriman
 * @property string $keterangan
 * @property string $statusdiagnosapasien
 * @property string $ket_diagnosa
 * @property integer $pasienicd9cm_id
 * @property integer $ppds_id
 * @property integer $asesmen_awal_medis_id
 * @property boolean $is_verifikasidiagnosa
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property DiagnosaM $diagnosa
 * @property DiagnosaicdixM $diagnosaicdix
 * @property GolonganumurM $golonganumur
 * @property JenisinM $jenisin
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property JenisketunaanM $jenisketunaan
 * @property KamarruanganM $kamarruangan
 * @property KelompokdiagnosaM $kelompokdiagnosa
 * @property KelompokumurM $kelompokumur
 * @property MorfologineoplasmaM $morfologineoplasma
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PenyebabluarcederaM $penyebabluarcedera
 * @property RuanganM $ruangan
 * @property SebabdiagnosaM $sebabdiagnosa
 * @property SebabinM $sebabin
 */
class PasienmorbiditasR extends CActiveRecord
{
	public $diagnosa_kode, $diagnosa_nama, $diagnosa_namalainnya, $diagnosa_nama1;
	public $kelompokdiagnosa_nama, $pegawai_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasienmorbiditas_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmorbiditas_id, jeniskasuspenyakit_id, ruangan_id, pegawai_id, kelompokumur_id, pasien_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, tglmorbiditas, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('morfologineoplasma_id, kamarruangan_id, jenisketunaan_id, jeniskasuspenyakit_id, ruangan_id, diagnosaicdix_id, pegawai_id, sebabdiagnosa_id, kelompokumur_id, diagnosa_id, sebabin_id, pasien_id, jenisin_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, penyebabluarcedera_id, pasienadmisi_id, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, laki_laki, perempuan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, pasienicd9cm_id, ppds_id, asesmen_awal_medis_id, created_by', 'numerical', 'integerOnly'=>true),
			array('kasusdiagnosa, statuspengiriman, statusdiagnosapasien', 'length', 'max'=>20),
			array('infeksinosokomial, update_time, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes, keterangan, ket_diagnosa, is_verifikasidiagnosa, diagnosakematian', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('riwayatpasienmorbiditas_id, pasienmorbiditas_id, morfologineoplasma_id, kamarruangan_id, jenisketunaan_id, jeniskasuspenyakit_id, ruangan_id, diagnosaicdix_id, pegawai_id, sebabdiagnosa_id, kelompokumur_id, diagnosa_id, sebabin_id, pasien_id, jenisin_id, kelompokdiagnosa_id, golonganumur_id, pendaftaran_id, penyebabluarcedera_id, pasienadmisi_id, tglmorbiditas, kasusdiagnosa, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, infeksinosokomial, laki_laki, perempuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpenghapusankemenkes, pegawaipenghapusankemenkes, tglpengiriminkemenkes, pegawaipengirimkemenkes, tglubahpengirimankemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman, keterangan, statusdiagnosapasien, ket_diagnosa, pasienicd9cm_id, ppds_id, asesmen_awal_medis_id, is_verifikasidiagnosa, created_by', 'safe', 'on'=>'search'),
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
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'diagnosaicdix' => array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'golonganumur' => array(self::BELONGS_TO, 'GolonganumurM', 'golonganumur_id'),
			'jenisin' => array(self::BELONGS_TO, 'JenisinM', 'jenisin_id'),
			'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
			'jenisketunaan' => array(self::BELONGS_TO, 'JenisketunaanM', 'jenisketunaan_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'kelompokdiagnosa' => array(self::BELONGS_TO, 'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
			'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
			'morfologineoplasma' => array(self::BELONGS_TO, 'MorfologineoplasmaM', 'morfologineoplasma_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'penyebabluarcedera' => array(self::BELONGS_TO, 'PenyebabluarcederaM', 'penyebabluarcedera_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'sebabdiagnosa' => array(self::BELONGS_TO, 'SebabdiagnosaM', 'sebabdiagnosa_id'),
			'sebabin' => array(self::BELONGS_TO, 'SebabinM', 'sebabin_id'),
			'ppds' => array(self::BELONGS_TO,  'PpdsM', 'ppds_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'morfologineoplasma_id' => 'Morfologineoplasma',
			'kamarruangan_id' => 'Kamarruangan',
			'jenisketunaan_id' => 'Jenisketunaan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'ruangan_id' => 'Ruangan',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'pegawai_id' => 'Pegawai',
			'sebabdiagnosa_id' => 'Sebabdiagnosa',
			'kelompokumur_id' => 'Kelompokumur',
			'diagnosa_id' => 'Diagnosa',
			'sebabin_id' => 'Sebabin',
			'pasien_id' => 'Pasien',
			'jenisin_id' => 'Jenisin',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'golonganumur_id' => 'Golonganumur',
			'pendaftaran_id' => 'Pendaftaran',
			'penyebabluarcedera_id' => 'Penyebabluarcedera',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglmorbiditas' => 'Tglmorbiditas',
			'kasusdiagnosa' => 'Kasusdiagnosa',
			'umur_0_28hr' => 'Umur 0 28hr',
			'umur_28hr_1thn' => 'Umur 28hr 1thn',
			'umur_1_4thn' => 'Umur 1 4thn',
			'umur_5_14thn' => 'Umur 5 14thn',
			'umur_15_24thn' => 'Umur 15 24thn',
			'umur_25_44thn' => 'Umur 25 44thn',
			'umur_45_64thn' => 'Umur 45 64thn',
			'umur_65' => 'Umur 65',
			'infeksinosokomial' => 'Infeksinosokomial',
			'laki_laki' => 'Laki Laki',
			'perempuan' => 'Perempuan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglpenghapusankemenkes' => 'Tglpenghapusankemenkes',
			'pegawaipenghapusankemenkes' => 'Pegawaipenghapusankemenkes',
			'tglpengiriminkemenkes' => 'Tglpengiriminkemenkes',
			'pegawaipengirimkemenkes' => 'Pegawaipengirimkemenkes',
			'tglubahpengirimankemenkes' => 'Tglubahpengirimankemenkes',
			'pegawaiubahpengirimankemenkes' => 'Pegawaiubahpengirimankemenkes',
			'logpenghapusandatakemenkes' => 'Logpenghapusandatakemenkes',
			'statuspengiriman' => 'Statuspengiriman',
			'keterangan' => 'Keterangan',
			'statusdiagnosapasien' => 'Statusdiagnosapasien',
			'ket_diagnosa' => 'Ket Diagnosa',
			'pasienicd9cm_id' => 'Pasienicd9cm',
			'ppds_id' => 'Ppds',
			'asesmen_awal_medis_id' => 'Asesmen Awal Medis',
			'is_verifikasidiagnosa' => 'Is Verifikasidiagnosa',
			'created_by' => 'Created By',
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

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tglmorbiditas',$this->tglmorbiditas,true);
		$criteria->compare('kasusdiagnosa',$this->kasusdiagnosa,true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial);
		$criteria->compare('laki_laki',$this->laki_laki);
		$criteria->compare('perempuan',$this->perempuan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('tglpenghapusankemenkes',$this->tglpenghapusankemenkes,true);
		$criteria->compare('pegawaipenghapusankemenkes',$this->pegawaipenghapusankemenkes);
		$criteria->compare('tglpengiriminkemenkes',$this->tglpengiriminkemenkes,true);
		$criteria->compare('pegawaipengirimkemenkes',$this->pegawaipengirimkemenkes);
		$criteria->compare('tglubahpengirimankemenkes',$this->tglubahpengirimankemenkes,true);
		$criteria->compare('pegawaiubahpengirimankemenkes',$this->pegawaiubahpengirimankemenkes);
		$criteria->compare('logpenghapusandatakemenkes',$this->logpenghapusandatakemenkes,true);
		$criteria->compare('statuspengiriman',$this->statuspengiriman,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('statusdiagnosapasien',$this->statusdiagnosapasien,true);
		$criteria->compare('ket_diagnosa',$this->ket_diagnosa,true);
		$criteria->compare('pasienicd9cm_id',$this->pasienicd9cm_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('asesmen_awal_medis_id',$this->asesmen_awal_medis_id);
		$criteria->compare('is_verifikasidiagnosa',$this->is_verifikasidiagnosa);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasienmorbiditasR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function catat($model, $verifikasi = false) {
		
		$record = new PasienmorbiditasR;
		$record->attributes = $model->attributes;
		$record->create_time = date('Y-m-d H:i:s');
		$record->update_time = date('Y-m-d H:i:s');
		$record->is_verifikasidiagnosa = $verifikasi;
		$record->created_by = Yii::app()->user->getState('pegawai_id');
		$record->save();
		
		// var_dump($record->attributes, $model->attributes); die;

		return $record;

	}

	public function updateRiwayat($model, $verifikasi = false) {
		
		$record = PasienmorbiditasR::model()->findByAttributes(['pasienmorbiditas_id' => $model->pasienmorbiditas_id]);
		if(!empty($record)) {
			$record->attributes = $model->attributes;
			$record->update_time = date('Y-m-d H:i:s');
			$record->is_verifikasidiagnosa = $verifikasi;
			$record->update();
		}
		
		// echo '<pre>';
		// var_dump($record->attributes, $model->attributes); die;

		return $record;

	}

	public function catatTransaksi($model)
	{

		$record = new PasienmorbiditasT;
		$record->attributes = $model->attributes;
		$record->create_time = date('Y-m-d H:i:s');
		$record->update_time = date('Y-m-d H:i:s');
		$record->save();

		// var_dump($record->attributes, $model->attributes); die;

		return $record;
	}

	public function searchRiwayatDiagnosa()
	{
		$criteria = new CDbCriteria;

		if (!empty($this->pasien_id)) {
			$criteria->addCondition("pasien_id = " . $this->pasien_id);
		}
		$criteria->addCondition("kelompokdiagnosa_id = " . Params::KELOMPOKDIAGNOSA_UTAMA);

		$criteria->order = 'create_time desc';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 5,),
		));
	}
}
