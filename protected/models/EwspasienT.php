<?php

/**
 * This is the model class for table "ewspasien_t".
 *
 * The followings are the available columns in table 'ewspasien_t':
 * @property integer $ewspasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggalpengkajian
 * @property integer $petugaspengkaji_id
 * @property integer $dpjp_id
 * @property string $jenisews
 * @property string $total_skor
 * @property string $klasifikasi
 * @property string $monitoring_frekuensi
 * @property string $tindakan
 * @property string $monitoring_petugas
 * @property integer $total_skor_hijau
 * @property integer $total_skor_kuning
 * @property integer $total_skor_merah
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $petugaspengkaji
 * @property PegawaiM $dpjp
 * @property EwspasiendetT $ewspasiendetT
 */
class EwspasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EwspasienT the static model class
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
		return 'ewspasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggalpengkajian, petugaspengkaji_id, dpjp_id, jenisews, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, petugaspengkaji_id, dpjp_id, total_skor_hijau, total_skor_kuning, total_skor_merah, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jenisews', 'length', 'max'=>20),
			array('total_skor', 'length', 'max'=>50),
			array('klasifikasi, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('monitoring_frekuensi, monitoring_petugas', 'length', 'max'=>200),
			array('tindakan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ewspasien_id, pendaftaran_id, pasienadmisi_id, tanggalpengkajian, petugaspengkaji_id, dpjp_id, jenisews, total_skor, klasifikasi, monitoring_frekuensi, tindakan, monitoring_petugas, total_skor_hijau, total_skor_kuning, total_skor_merah, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'petugaspengkaji' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengkaji_id'),
			'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
			'ewspasiendetT' => array(self::HAS_ONE, 'EwspasiendetT', 'ewspasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ewspasien_id' => 'Ewspasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggalpengkajian' => 'Tanggal / Jam',
			'petugaspengkaji_id' => 'Petugas Pengkaji',
			'dpjp_id' => 'Dpjp',
			'jenisews' => 'Jenisews',
			'total_skor' => 'Total Skor',
			'klasifikasi' => 'Klasifikasi',
			'monitoring_frekuensi' => 'Monitoring Frekuensi',
			'tindakan' => 'Tindakan',
			'monitoring_petugas' => 'Monitoring Petugas',
			'total_skor_hijau' => 'Total Skor Hijau',
			'total_skor_kuning' => 'Total Skor Kuning',
			'total_skor_merah' => 'Total Skor Merah',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('ewspasien_id',$this->ewspasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggalpengkajian',$this->tanggalpengkajian,true);
		$criteria->compare('petugaspengkaji_id',$this->petugaspengkaji_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('jenisews',$this->jenisews,true);
		$criteria->compare('total_skor',$this->total_skor,true);
		$criteria->compare('klasifikasi',$this->klasifikasi,true);
		$criteria->compare('monitoring_frekuensi',$this->monitoring_frekuensi,true);
		$criteria->compare('tindakan',$this->tindakan,true);
		$criteria->compare('monitoring_petugas',$this->monitoring_petugas,true);
		$criteria->compare('total_skor_hijau',$this->total_skor_hijau);
		$criteria->compare('total_skor_kuning',$this->total_skor_kuning);
		$criteria->compare('total_skor_merah',$this->total_skor_merah);
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
        
}