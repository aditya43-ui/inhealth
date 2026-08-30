<?php

/**
 * This is the model class for table "kelompokpemeriksaanmikro_t".
 *
 * The followings are the available columns in table 'kelompokpemeriksaanmikro_t':
 * @property integer $kelompokpemeriksaanmikro_id
 * @property integer $pemeriksaankultur_id
 * @property integer $pemeriksaanpewarnaan_id
 * @property integer $pemeriksaancci_id
 * @property integer $pemeriksaanpcr_id
 * @property integer $pemeriksaanviralload_id
 * @property integer $pemeriksaantbc_id
 * @property boolean $is_pemeriksaankultur
 * @property boolean $is_pemeriksaanpewarnaan
 * @property boolean $is_pemeriksaancci
 * @property boolean $is_pemeriksaanpcr
 * @property boolean $is_pemeriksaanviralload
 * @property boolean $is_pemeriksaantbc
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pemeriksaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $no_lab
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $perawat_id
 * @property boolean $is_validasi
 * @property boolean $is_kirimhasil
 */
class KelompokpemeriksaanmikroT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tgl_awal, $tgl_akhir, $nama_pasien, $no_rekam_medik, $dpjp_nama, $daftartindakan_nama, $pemeriksaan_nama;

	public function tableName()
	{
		return 'kelompokpemeriksaanmikro_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id', 'required'),
			array('pemeriksaankultur_id, pemeriksaanpewarnaan_id, pemeriksaancci_id, pemeriksaanpcr_id, pemeriksaanviralload_id, pemeriksaantbc_id, pasien_id, pasienadmisi_id, pasienmasukpenunjang_id, pendaftaran_id, pegawai_id, dpjp_id, perawat_id', 'numerical', 'integerOnly'=>true),
			array('no_lab', 'length', 'max'=>100),
			array('is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaanviralload, is_pemeriksaantbc, tgl_pemeriksaan, update_time, update_loginpemakai_id, is_validasi, is_kirimhasil', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kelompokpemeriksaanmikro_id, pemeriksaankultur_id, pemeriksaanpewarnaan_id, pemeriksaancci_id, pemeriksaanpcr_id, pemeriksaanviralload_id, pemeriksaantbc_id, is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaanviralload, is_pemeriksaantbc, pasien_id, pasienadmisi_id, pasienmasukpenunjang_id, pendaftaran_id, tgl_pemeriksaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, no_lab, pegawai_id, dpjp_id, perawat_id, is_validasi, is_kirimhasil', 'safe', 'on'=>'search'),
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
			'dpjp'=>array(self::BELONGS_TO, 'PegawaiM','dpjp_id'),
			'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT','tindakanpelayanan_id'),
			'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
			'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelompokpemeriksaanmikro_id' => 'Kelompokpemeriksaanmikro',
			'pemeriksaankultur_id' => 'Pemeriksaankultur',
			'pemeriksaanpewarnaan_id' => 'Pemeriksaanpewarnaan',
			'pemeriksaancci_id' => 'Pemeriksaancci',
			'pemeriksaanpcr_id' => 'Pemeriksaanpcr',
			'pemeriksaanviralload_id' => 'Pemeriksaanviralload',
			'pemeriksaantbc_id' => 'Pemeriksaantbc',
			'is_pemeriksaankultur' => 'Is Pemeriksaankultur',
			'is_pemeriksaanpewarnaan' => 'Is Pemeriksaanpewarnaan',
			'is_pemeriksaancci' => 'Is Pemeriksaancci',
			'is_pemeriksaanpcr' => 'Is Pemeriksaanpcr',
			'is_pemeriksaanviralload' => 'Is Pemeriksaanviralload',
			'is_pemeriksaantbc' => 'Is Pemeriksaantbc',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'no_lab' => 'No Lab',
			'pegawai_id' => 'Pegawai',
			'dpjp_id' => 'Dpjp',
			'perawat_id' => 'Perawat',
			'is_validasi' => 'Is Validasi',
			'is_kirimhasil' => 'Is Kirimhasil',
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

		$criteria->compare('kelompokpemeriksaanmikro_id',$this->kelompokpemeriksaanmikro_id);
		$criteria->compare('pemeriksaankultur_id',$this->pemeriksaankultur_id);
		$criteria->compare('pemeriksaanpewarnaan_id',$this->pemeriksaanpewarnaan_id);
		$criteria->compare('pemeriksaancci_id',$this->pemeriksaancci_id);
		$criteria->compare('pemeriksaanpcr_id',$this->pemeriksaanpcr_id);
		$criteria->compare('pemeriksaanviralload_id',$this->pemeriksaanviralload_id);
		$criteria->compare('pemeriksaantbc_id',$this->pemeriksaantbc_id);
		$criteria->compare('is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('is_pemeriksaantbc',$this->is_pemeriksaantbc);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('is_validasi',$this->is_validasi);
		$criteria->compare('is_kirimhasil',$this->is_kirimhasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchHasil()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.pendaftaran_id, t.tgl_pemeriksaan, t.no_lab, p.nama_pasien, p.no_rekam_medik,
		 d.pegawai_id, d.nama_pegawai, dt.daftartindakan_id, dt.daftartindakan_nama
		case
			when is_pemeriksaankultur = true then 'Kultur'
			when is_pemeriksaanpewarnaan = true then 'Pewarnaan Langsung'
			when is_pemeriksaancci = true then 'CCI'
			when is_pemeriksaanpcr = true then 'PCR Covid'
			when is_pemeriksaanviralload = true then 'Viral Load'
			when is_pemeriksaantbc = true then 'TBC'
		end as \"pemeriksaan\"";


		$criteria->compare('t.is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('t.is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('t.is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('t.is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('t.is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('t.is_pemeriksaantbc',$this->is_pemeriksaantbc);

		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('t.pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.tgl_pemeriksaan',$this->tgl_pemeriksaan,true);

		$criteria->compare('t.no_lab',$this->no_lab,true);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.dpjp_id',$this->dpjp_id);
		$criteria->compare('t.perawat_id',$this->perawat_id);
		$criteria->compare('t.is_validasi',$this->is_validasi);
		$criteria->compare('t.is_kirimhasil',$this->is_kirimhasil);

		$criteria->join = 'join pasien_m p on p.pasien_id = t.pasien_id join pegawai_m d on d.pegawai_id = t.dpjp_id
							join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id
							join daftartindakan_m dt on dt.daftartindakan_id = tp.daftartindakan_id';

		$criteria->compare('LOWER(p.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('p.no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('d.nama_pegawai',$this->dpjp_nama,true);
		$criteria->compare('LOWER(dt.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KelompokpemeriksaanmikroT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
