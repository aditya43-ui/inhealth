<?php

/**
 * This is the model class for table "catatanelektrokardiogram_t".
 *
 * The followings are the available columns in table 'catatanelektrokardiogram_t':
 * @property integer $catatanelektrokardiogram_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal
 * @property integer $pegawai_id
 * @property string $gambar_path
 * @property string $iramajantung
 * @property string $frekuensijantung
 * @property string $atrium
 * @property string $ventrikel
 * @property string $pr_interval
 * @property string $qrs_interval
 * @property string $qt_interval
 * @property string $seksumbulistrik_qrs
 * @property string $sekbidangfrontal
 * @property string $sekbidanghorizontal
 * @property string $interpretasi
 * @property string $kesimpulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 */
class CatatanelektrokardiogramT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nama_pegawai;

	public function tableName()
	{
		return 'catatanelektrokardiogram_t';
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
			array('pendaftaran_id, pasien_id, pasienadmisi_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('gambar_path, iramajantung, frekuensijantung, atrium, ventrikel, pr_interval, qrs_interval, qt_interval, seksumbulistrik_qrs, sekbidangfrontal, sekbidanghorizontal', 'length', 'max'=>150),
			array('tanggal, interpretasi, kesimpulan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catatanelektrokardiogram_id, pendaftaran_id, pasien_id, pasienadmisi_id, tanggal, pegawai_id, gambar_path, iramajantung, frekuensijantung, atrium, ventrikel, pr_interval, qrs_interval, qt_interval, seksumbulistrik_qrs, sekbidangfrontal, sekbidanghorizontal, interpretasi, kesimpulan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanelektrokardiogram_id' => 'Catatanelektrokardiogram',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal' => 'Tanggal',
			'pegawai_id' => 'Pegawai',
			'gambar_path' => 'Gambar Path',
			'iramajantung' => 'Irama Jantung',
			'frekuensijantung' => 'Frekuensi Denyut Jantung',
			'atrium' => 'Atrium',
			'ventrikel' => 'Ventrikel',
			'pr_interval' => 'P - R Interval',
			'qrs_interval' => 'QRS Interval',
			'qt_interval' => 'Q - T Interval',
			'seksumbulistrik_qrs' => 'Sek Sumbu Listrik QRS',
			'sekbidangfrontal' => 'Sek Bidang Frontal',
			'sekbidanghorizontal' => 'Sek Bidang Horizontal',
			'interpretasi' => 'Interpretasi',
			'kesimpulan' => 'Kesimpulan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('catatanelektrokardiogram_id',$this->catatanelektrokardiogram_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gambar_path',$this->gambar_path,true);
		$criteria->compare('iramajantung',$this->iramajantung,true);
		$criteria->compare('frekuensijantung',$this->frekuensijantung,true);
		$criteria->compare('atrium',$this->atrium,true);
		$criteria->compare('ventrikel',$this->ventrikel,true);
		$criteria->compare('pr_interval',$this->pr_interval,true);
		$criteria->compare('qrs_interval',$this->qrs_interval,true);
		$criteria->compare('qt_interval',$this->qt_interval,true);
		$criteria->compare('seksumbulistrik_qrs',$this->seksumbulistrik_qrs,true);
		$criteria->compare('sekbidangfrontal',$this->sekbidangfrontal,true);
		$criteria->compare('sekbidanghorizontal',$this->sekbidanghorizontal,true);
		$criteria->compare('interpretasi',$this->interpretasi,true);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatatanelektrokardiogramT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}