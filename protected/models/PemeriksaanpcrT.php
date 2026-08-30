<?php

/**
 * This is the model class for table "pemeriksaanpcr_t".
 *
 * The followings are the available columns in table 'pemeriksaanpcr_t':
 * @property integer $pemeriksaanpcr_id
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $perawat_id
 * @property string $tgl_pemeriksaan
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $daftartindakan_nama
 * @property string $no_lab
 * @property boolean $is_negative
 */
class PemeriksaanpcrT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemeriksaanpcr_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasienmasukpenunjang_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaanpcr_id, pegawai_id, dpjp_id, perawat_id, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('daftartindakan_nama', 'length', 'max'=>100),
			array('no_lab', 'length', 'max'=>30),
			array('tgl_pemeriksaan, update_time, update_loginpemakai_id, is_negative', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaanpcr_id, pegawai_id, dpjp_id, perawat_id, tgl_pemeriksaan, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, daftartindakan_nama, no_lab, is_negative', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpcr_id' => 'Pemeriksaanpcr',
			'pegawai_id' => 'Pegawai',
			'dpjp_id' => 'Dpjp',
			'perawat_id' => 'Perawat',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'no_lab' => 'No Lab',
			'is_negative' => 'Is Negative',
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

		$criteria->compare('pemeriksaanpcr_id',$this->pemeriksaanpcr_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('is_negative',$this->is_negative);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaanpcrT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
