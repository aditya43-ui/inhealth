<?php

/**
 * This is the model class for table "asesmentnyeri_t".
 *
 * The followings are the available columns in table 'asesmentnyeri_t':
 * @property integer $asesmentnyeri_id
 * @property string $tglpemeriksaannyeri
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pegawaipemeriksa_id
 * @property boolean $keluhannyeri
 * @property boolean $is_keluhannyeri_dewasa
 * @property integer $score_skalanyeri
 * @property string $keteranganskala_nyeri
 * @property integer $asesmentnyerianakdet_id
 * @property integer $pemeriksaannyeri_id
 * @property string $frekuensinyeri
 * @property integer $lamanyeri
 * @property string $satuanlamanyeri
 * @property boolean $is_nyerimenjalar
 * @property string $nyerimenjalarke
 * @property string $kualitasnyeri
 * @property string $pemicu_memperberat
 * @property string $pemicu_meringankan
 * @property string $tindaklanjut
 * @property string $create_time
 * @property integer $create_ruangan_id
 * @property integer $create_loginpemakai_id
 * @property string $update_time
 * @property integer $update_ruangan_id
 * @property integer $update_loginpemakai_id
 */
class AsesmentnyeriT extends CActiveRecord
{
        public $scoreanak;
        public $keterangananak;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentnyeriT the static model class
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
		return 'asesmentnyeri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpemeriksaannyeri, pendaftaran_id, pasien_id, pegawaipemeriksa_id, create_time, create_ruangan_id, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, pasien_id, pegawaipemeriksa_id, score_skalanyeri, asesmentnyerianakdet_id, pemeriksaannyeri_id, lamanyeri, create_ruangan_id, create_loginpemakai_id, update_ruangan_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('keteranganskala_nyeri', 'length', 'max'=>100),
			array('frekuensinyeri', 'length', 'max'=>50),
			array('satuanlamanyeri', 'length', 'max'=>20),
			array('nyerimenjalarke', 'length', 'max'=>200),
			array('kualitasnyeri, tindaklanjut', 'length', 'max'=>150),
			array('pemicu_memperberat, pemicu_meringankan', 'length', 'max'=>250),
			array('keluhannyeri, is_keluhannyeri_dewasa, is_keluhannyeribayi, is_bayiprematur, is_nyerimenjalar, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentnyeri_id, tglpemeriksaannyeri, pendaftaran_id, pasien_id, pegawaipemeriksa_id, keluhannyeri, is_keluhannyeri_dewasa, score_skalanyeri, keteranganskala_nyeri, asesmentnyerianakdet_id, pemeriksaannyeri_id, frekuensinyeri, lamanyeri, satuanlamanyeri, is_nyerimenjalar, nyerimenjalarke, kualitasnyeri, pemicu_memperberat, pemicu_meringankan, tindaklanjut, create_time, create_ruangan_id, create_loginpemakai_id, update_time, update_ruangan_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'asesmentnyeri_id' => 'Asesmentnyeri',
			'tglpemeriksaannyeri' => 'Tanggal Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pegawaipemeriksa_id' => 'Pegawaipemeriksa',
			'keluhannyeri' => 'Ada Keluhan',
			'is_keluhannyeri_dewasa' => 'Is Keluhannyeri Dewasa',
			'score_skalanyeri' => 'Skala Nyeri',
			'keteranganskala_nyeri' => 'Keteranganskala Nyeri',
			'asesmentnyerianakdet_id' => 'Asesmentnyerianakdet',
			'pemeriksaannyeri_id' => 'Pemeriksaannyeri',
			'frekuensinyeri' => 'Frekuensi Nyeri',
			'lamanyeri' => 'Lama Nyeri',
			'satuanlamanyeri' => 'Satuan Lama Nyeri',
			'is_nyerimenjalar' => 'Menjalar',
			'nyerimenjalarke' => 'ke',
			'kualitasnyeri' => 'Kualitas Nyeri',
			'pemicu_memperberat' => 'Faktor Pemicu/ Memperberat',
			'pemicu_meringankan' => 'Faktor yang mengurangi/ menghilangkan nyeri',
			'tindaklanjut' => 'Tindak Lanjut',
			'create_time' => 'Waktu Create',
			'create_ruangan_id' => 'Create Ruangan',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_time' => 'Waktu Update',
			'update_ruangan_id' => 'Update Ruangan',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('asesmentnyeri_id',$this->asesmentnyeri_id);
		$criteria->compare('tglpemeriksaannyeri',$this->tglpemeriksaannyeri,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawaipemeriksa_id',$this->pegawaipemeriksa_id);
		$criteria->compare('keluhannyeri',$this->keluhannyeri);
		$criteria->compare('is_keluhannyeri_dewasa',$this->is_keluhannyeri_dewasa);
		$criteria->compare('score_skalanyeri',$this->score_skalanyeri);
		$criteria->compare('keteranganskala_nyeri',$this->keteranganskala_nyeri,true);
		$criteria->compare('asesmentnyerianakdet_id',$this->asesmentnyerianakdet_id);
		$criteria->compare('pemeriksaannyeri_id',$this->pemeriksaannyeri_id);
		$criteria->compare('frekuensinyeri',$this->frekuensinyeri,true);
		$criteria->compare('lamanyeri',$this->lamanyeri);
		$criteria->compare('satuanlamanyeri',$this->satuanlamanyeri,true);
		$criteria->compare('is_nyerimenjalar',$this->is_nyerimenjalar);
		$criteria->compare('nyerimenjalarke',$this->nyerimenjalarke,true);
		$criteria->compare('kualitasnyeri',$this->kualitasnyeri,true);
		$criteria->compare('pemicu_memperberat',$this->pemicu_memperberat,true);
		$criteria->compare('pemicu_meringankan',$this->pemicu_meringankan,true);
		$criteria->compare('tindaklanjut',$this->tindaklanjut,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_ruangan_id',$this->update_ruangan_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchRiwayat()
	{
	
                
		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->order = 'tglpemeriksaannyeri desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
}