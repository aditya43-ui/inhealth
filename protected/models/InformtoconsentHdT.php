<?php

/**
 * This is the model class for table "informtoconsent_hd_t".
 *
 * The followings are the available columns in table 'informtoconsent_hd_t':
 * @property integer $informtoconsent_hd_id
 * @property integer $pasien_id
 * @property integer $dokteri_id
 * @property integer $pendaftaran_id
 * @property string $waktu
 * @property boolean $f_hd
 * @property boolean $g_hd
 * @property boolean $diagnosis
 * @property boolean $dasar_diagnosis
 * @property boolean $tindakan_kedokteran
 * @property boolean $indikasi_tindakan
 * @property boolean $tata_cara
 * @property boolean $tujuan
 * @property boolean $risiko
 * @property boolean $prognosis
 * @property boolean $alternatif_risiko
 * @property string $alternatif_risiko_isi_informasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $dokteri
 * @property PasienM $pasien
 */
class InformtoconsentHdT extends CActiveRecord
{
    public $hd, $dokter_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformtoconsentHdT the static model class
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
		return 'informtoconsent_hd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, ruangan_id', 'required'),
			array('informtoconsent_hd_id, pasien_id, dokteri_id, pendaftaran_id, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('alternatif_risiko_isi_informasi', 'length', 'max'=>100),
			array('waktu, f_hd, g_hd, diagnosis, dasar_diagnosis, tindakan_kedokteran, indikasi_tindakan, tata_cara, tujuan, risiko, prognosis, alternatif_risiko, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('informtoconsent_hd_id, pasien_id, dokteri_id, pendaftaran_id, waktu, f_hd, g_hd, diagnosis, dasar_diagnosis, tindakan_kedokteran, indikasi_tindakan, tata_cara, tujuan, risiko, prognosis, alternatif_risiko, alternatif_risiko_isi_informasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'dokteri' => array(self::BELONGS_TO, 'PegawaiM', 'dokteri_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'informtoconsent_hd_id' => 'Informtoconsent Hd',
			'pasien_id' => 'Pasien',
			'dokteri_id' => 'Prof./Dr./Spesialis',
			'pendaftaran_id' => 'Pendaftaran',
			'waktu' => 'Waktu',
			'f_hd' => 'F Hd',
			'g_hd' => 'G Hd',
			'diagnosis' => 'Diagnosis',
			'dasar_diagnosis' => 'Dasar Diagnosis',
			'tindakan_kedokteran' => 'Tindakan Kedokteran',
			'indikasi_tindakan' => 'Indikasi Tindakan',
			'tata_cara' => 'Tata Cara',
			'tujuan' => 'Tujuan',
			'risiko' => 'Risiko',
			'prognosis' => 'Prognosis',
			'alternatif_risiko' => 'Alternatif Risiko',
			'alternatif_risiko_isi_informasi' => 'Alternatif Risiko Isi Informasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'creale_login' => 'Creale Login',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'ruangan_id' => 'Ruangan',
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

		$criteria->compare('informtoconsent_hd_id',$this->informtoconsent_hd_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('dokteri_id',$this->dokteri_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('waktu',$this->waktu,true);
		$criteria->compare('f_hd',$this->f_hd);
		$criteria->compare('g_hd',$this->g_hd);
		$criteria->compare('diagnosis',$this->diagnosis);
		$criteria->compare('dasar_diagnosis',$this->dasar_diagnosis);
		$criteria->compare('tindakan_kedokteran',$this->tindakan_kedokteran);
		$criteria->compare('indikasi_tindakan',$this->indikasi_tindakan);
		$criteria->compare('tata_cara',$this->tata_cara);
		$criteria->compare('tujuan',$this->tujuan);
		$criteria->compare('risiko',$this->risiko);
		$criteria->compare('prognosis',$this->prognosis);
		$criteria->compare('alternatif_risiko',$this->alternatif_risiko);
		$criteria->compare('alternatif_risiko_isi_informasi',$this->alternatif_risiko_isi_informasi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}