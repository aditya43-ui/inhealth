<?php

/**
 * This is the model class for table "evaluasiawal_t".
 *
 * The followings are the available columns in table 'evaluasiawal_t':
 * @property integer $evaluasiawal_id
 * @property integer $ruangan_id
 * @property integer $diagnosa_id
 * @property integer $kelaspelayanan_id
 * @property string $kelompok_resiko
 * @property string $tgl_evaluasi
 * @property string $identifikasi_skriningpasien
 * @property string $assesmen
 * @property string $identifikasi_masalah
 * @property string $perencanaan
 * @property integer $petugaspengisi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $petugaspengisi
 */
class EvaluasiawalT extends CActiveRecord
{
	public $petugaspengisi_nama, $kelompok_resikolainnya, $diagnosa_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasiawalT the static model class
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
		return 'evaluasiawal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, kelaspelayanan_id, kelompok_resiko, tgl_evaluasi, create_time', 'required'),
			array('ruangan_id, diagnosa_id, kelaspelayanan_id, petugaspengisi_id, create_ruangan, pasien_id', 'numerical', 'integerOnly'=>true),
			array('kelompok_resiko', 'length', 'max'=>20),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('identifikasi_skriningpasien, assesmen, identifikasi_masalah, perencanaan, update_time', 'safe'),
            array('psikososial, sosioekonomi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasiawal_id, ruangan_id, diagnosa_id, kelaspelayanan_id, kelompok_resiko, tgl_evaluasi, identifikasi_skriningpasien, assesmen, identifikasi_masalah, perencanaan, petugaspengisi_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, pasien_id', 'safe', 'on'=>'search'),
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
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiawal_id' => 'Evaluasiawal',
			'ruangan_id' => 'Ruangan',
			'diagnosa_id' => 'Diagnosa',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelompok_resiko' => 'Kelompok Resiko',
			'tgl_evaluasi' => 'Tanggal Evaluasi',
			'identifikasi_skriningpasien' => 'Identifikasi/ Skrinning',
			'assesmen' => 'Assesmen',
			'identifikasi_masalah' => 'Identifikasi Masalah',
			'perencanaan' => 'Perencanaan',
			'petugaspengisi_id' => 'Petugaspengisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
            'sosioekonomi' => 'Sosio-Ekonomi',
            'psikososial' => 'Psikososial',
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

		$criteria->compare('evaluasiawal_id',$this->evaluasiawal_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelompok_resiko',$this->kelompok_resiko,true);
		$criteria->compare('tgl_evaluasi',$this->tgl_evaluasi,true);
		$criteria->compare('identifikasi_skriningpasien',$this->identifikasi_skriningpasien,true);
		$criteria->compare('assesmen',$this->assesmen,true);
		$criteria->compare('identifikasi_masalah',$this->identifikasi_masalah,true);
		$criteria->compare('perencanaan',$this->perencanaan,true);
		$criteria->compare('petugaspengisi_id',$this->petugaspengisi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}
