<?php

/**
 * This is the model class for table "intervensicegahjatuhpasien_t".
 *
 * The followings are the available columns in table 'intervensicegahjatuhpasien_t':
 * @property integer $intervensicegahjatuhpasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tgl_intervensi
 * @property string $jam_intervensi
 * @property integer $petugas_id
 * @property integer $ruangan_id
 * @property string $resikojatuh_tingkat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property IntervensicegahjatuhpasiendetT[] $intervensicegahjatuhpasiendetTs
 */
class IntervensicegahjatuhpasienT extends CActiveRecord
{
	public $is_jenicegah, $resikojatuh_tingkat_dewasa;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntervensicegahjatuhpasienT the static model class
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
		return 'intervensicegahjatuhpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasien_id, petugas_id, ruangan_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('resikojatuh_tingkat, kelompok_pasien', 'length', 'max'=>50),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tgl_intervensi, jam_intervensi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intervensicegahjatuhpasien_id, pendaftaran_id, pasien_id, tgl_intervensi, jam_intervensi, petugas_id, ruangan_id, resikojatuh_tingkat, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, kelompok_pasien, pengkajianresikojatuh_id, evaluasi_pencegahanjatuh', 'safe', 'on'=>'search'),
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
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'intervensicegahjatuhpasiendetTs' => array(self::HAS_MANY, 'IntervensicegahjatuhpasiendetT', 'intervensicegahjatuhpasien_id'),
                    'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intervensicegahjatuhpasien_id' => 'Intervensicegahjatuhpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tgl_intervensi' => 'Tgl Intervensi',
			'jam_intervensi' => 'Jam Intervensi',
			'petugas_id' => 'Petugas',
			'ruangan_id' => 'Ruangan',
			'resikojatuh_tingkat' => 'Resikojatuh Tingkat',
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

		$criteria->compare('intervensicegahjatuhpasien_id',$this->intervensicegahjatuhpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tgl_intervensi',$this->tgl_intervensi,true);
		$criteria->compare('jam_intervensi',$this->jam_intervensi,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('resikojatuh_tingkat',$this->resikojatuh_tingkat,true);
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

        public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                if(!empty($this->pendaftaran_id)){
                    $criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
