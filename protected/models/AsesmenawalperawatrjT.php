<?php

/**
 * This is the model class for table "asesmenawalperawatrj_t".
 *
 * The followings are the available columns in table 'asesmenawalperawatrj_t':
 * @property integer $asesmenawalperawatrj_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $anamnesa_id
 * @property integer $pemeriksaanfisik_id
 * @property boolean $is_bahasaindonesia
 * @property boolean $is_bahasadaerah
 * @property string $keterangan_bahasa
 * @property boolean $is_tinggalbersamasuami
 * @property boolean $is_tinggalbersamaistri
 * @property boolean $is_tinggalbersamaanak
 * @property boolean $is_tinggalbersamakakek
 * @property boolean $is_tinggalbersamanenek
 * @property boolean $is_tinggalbersamalain
 * @property string $keterangan_tinggalbersama
 * @property string $keluargaterdekat
 * @property string $hubungankeluarga
 * @property string $tempattinggal
 * @property boolean $is_pembiayaanasuransi
 * @property boolean $is_pembiayaanperusahaan
 * @property string $keterangan_pembiayaan
 * @property boolean $pendampingspiritual
 * @property boolean $is_nilaikepercayaan
 * @property boolean $is_tidakpulangdarirs
 * @property boolean $is_tidakdilakukanoperasi
 * @property boolean $is_tidakmakandaging
 * @property boolean $is_nilaikepercayaanlainnya
 * @property string $ket_nilaikepercayaanlainnya
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $skriningmst_id
 *
 * The followings are the available model relations:
 * @property AnamnesaT $anamnesa
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 * @property PemeriksaanfisikT $pemeriksaanfisik
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class AsesmenawalperawatrjT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmenawalperawatrj_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, ruangan_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, ruangan_id, pegawai_id, anamnesa_id, pemeriksaanfisik_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sosialekonomispiritual_id, pengkajiannyeri_id, pengkajianresikojatuh_id, skrininggizi_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asesmenawalperawatrj_id, pasien_id, pendaftaran_id, ruangan_id, pegawai_id, anamnesa_id, pemeriksaanfisik_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, sosialekonomispiritual_id, pengkajiannyeri_id, pengkajianresikojatuh_id, skrininggizi_id', 'safe', 'on'=>'search'),
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
			'anamnesa' => array(self::BELONGS_TO, 'AnamnesaT', 'anamnesa_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pemeriksaanfisik' => array(self::BELONGS_TO, 'PemeriksaanfisikT', 'pemeriksaanfisik_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenawalperawatrj_id' => 'Asesmenawalperawatrj',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'anamnesa_id' => 'Anamnesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'is_bahasaindonesia' => 'Is Bahasaindonesia',
			'is_bahasadaerah' => 'Is Bahasadaerah',
			'keterangan_bahasa' => 'Keterangan Bahasa',
			'is_tinggalbersamasuami' => 'Is Tinggalbersamasuami',
			'is_tinggalbersamaistri' => 'Is Tinggalbersamaistri',
			'is_tinggalbersamaanak' => 'Is Tinggalbersamaanak',
			'is_tinggalbersamakakek' => 'Is Tinggalbersamakakek',
			'is_tinggalbersamanenek' => 'Is Tinggalbersamanenek',
			'is_tinggalbersamalain' => 'Is Tinggalbersamalain',
			'keterangan_tinggalbersama' => 'Keterangan Tinggalbersama',
			'keluargaterdekat' => 'Keluargaterdekat',
			'hubungankeluarga' => 'Hubungankeluarga',
			'tempattinggal' => 'Tempattinggal',
			'is_pembiayaanasuransi' => 'Is Pembiayaanasuransi',
			'is_pembiayaanperusahaan' => 'Is Pembiayaanperusahaan',
			'keterangan_pembiayaan' => 'Keterangan Pembiayaan',
			'pendampingspiritual' => 'Pendampingspiritual',
			'is_nilaikepercayaan' => 'Is Nilaikepercayaan',
			'is_tidakpulangdarirs' => 'Is Tidakpulangdarirs',
			'is_tidakdilakukanoperasi' => 'Is Tidakdilakukanoperasi',
			'is_tidakmakandaging' => 'Is Tidakmakandaging',
			'is_nilaikepercayaanlainnya' => 'Is Nilaikepercayaanlainnya',
			'ket_nilaikepercayaanlainnya' => 'Ket Nilaikepercayaanlainnya',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'skriningmst_id' => 'Skriningmst',
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

		$criteria->compare('asesmenawalperawatrj_id',$this->asesmenawalperawatrj_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('anamnesa_id',$this->anamnesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('is_bahasaindonesia',$this->is_bahasaindonesia);
		$criteria->compare('is_bahasadaerah',$this->is_bahasadaerah);
		$criteria->compare('keterangan_bahasa',$this->keterangan_bahasa,true);
		$criteria->compare('is_tinggalbersamasuami',$this->is_tinggalbersamasuami);
		$criteria->compare('is_tinggalbersamaistri',$this->is_tinggalbersamaistri);
		$criteria->compare('is_tinggalbersamaanak',$this->is_tinggalbersamaanak);
		$criteria->compare('is_tinggalbersamakakek',$this->is_tinggalbersamakakek);
		$criteria->compare('is_tinggalbersamanenek',$this->is_tinggalbersamanenek);
		$criteria->compare('is_tinggalbersamalain',$this->is_tinggalbersamalain);
		$criteria->compare('keterangan_tinggalbersama',$this->keterangan_tinggalbersama,true);
		$criteria->compare('keluargaterdekat',$this->keluargaterdekat,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('is_pembiayaanasuransi',$this->is_pembiayaanasuransi);
		$criteria->compare('is_pembiayaanperusahaan',$this->is_pembiayaanperusahaan);
		$criteria->compare('keterangan_pembiayaan',$this->keterangan_pembiayaan,true);
		$criteria->compare('pendampingspiritual',$this->pendampingspiritual);
		$criteria->compare('is_nilaikepercayaan',$this->is_nilaikepercayaan);
		$criteria->compare('is_tidakpulangdarirs',$this->is_tidakpulangdarirs);
		$criteria->compare('is_tidakdilakukanoperasi',$this->is_tidakdilakukanoperasi);
		$criteria->compare('is_tidakmakandaging',$this->is_tidakmakandaging);
		$criteria->compare('is_nilaikepercayaanlainnya',$this->is_nilaikepercayaanlainnya);
		$criteria->compare('ket_nilaikepercayaanlainnya',$this->ket_nilaikepercayaanlainnya,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('skriningmst_id',$this->skriningmst_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsesmenawalperawatrjT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
