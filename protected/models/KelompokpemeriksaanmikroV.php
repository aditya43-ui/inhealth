<?php

/**
 * This is the model class for table "kelompokpemeriksaanmikro_v".
 *
 * The followings are the available columns in table 'kelompokpemeriksaanmikro_v':
 * @property integer $kelompokpemeriksaanmikro_id
 * @property string $tgl_pemeriksaan
 * @property string $no_lab
 * @property boolean $is_pemeriksaancci
 * @property boolean $is_pemeriksaanpcr
 * @property boolean $is_pemeriksaantbc
 * @property boolean $is_pemeriksaankultur
 * @property boolean $is_pemeriksaanpewarnaan
 * @property boolean $is_pemeriksaanviralload
 * @property boolean $is_kirimhasil
 * @property integer $dpjp_id
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pendaftaran_id
 */
class KelompokpemeriksaanmikroV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelompokpemeriksaanmikro_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokpemeriksaanmikro_id, dpjp_id, pasien_id, pegawai_id, samplelab_id, daftartindakan_id, carabayar_id, pasienmasukpenunjang_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('no_lab', 'length', 'max'=>100),
			array('nama_pasien, nama_pegawai, samplelab_nama, carabayar_nama', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('tgl_pemeriksaan, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaantbc, is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaanviralload, is_kirimhasil', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kelompokpemeriksaanmikro_id, tgl_pemeriksaan, no_lab, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaantbc, is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaanviralload, is_kirimhasil, dpjp_id, pasien_id, nama_pasien, no_rekam_medik, pegawai_id, nama_pegawai, samplelab_id, samplelab_nama, daftartindakan_id, daftartindakan_nama, carabayar_id, carabayar_nama, pasienmasukpenunjang_id, pendaftaran_id', 'safe', 'on'=>'search'),
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
			'kelompokpemeriksaanmikro_id' => 'Kelompokpemeriksaanmikro',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'no_lab' => 'No Lab',
			'is_pemeriksaancci' => 'Is Pemeriksaancci',
			'is_pemeriksaanpcr' => 'Is Pemeriksaanpcr',
			'is_pemeriksaantbc' => 'Is Pemeriksaantbc',
			'is_pemeriksaankultur' => 'Is Pemeriksaankultur',
			'is_pemeriksaanpewarnaan' => 'Is Pemeriksaanpewarnaan',
			'is_pemeriksaanviralload' => 'Is Pemeriksaanviralload',
			'is_kirimhasil' => 'Is Kirimhasil',
			'dpjp_id' => 'Dpjp',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'samplelab_id' => 'Samplelab',
			'samplelab_nama' => 'Samplelab Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pendaftaran_id' => 'Pendaftaran',
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
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('is_pemeriksaantbc',$this->is_pemeriksaantbc);
		$criteria->compare('is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('is_kirimhasil',$this->is_kirimhasil);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KelompokpemeriksaanmikroV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
