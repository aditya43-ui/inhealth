<?php

/**
 * This is the model class for table "hasilpengkajianresikojatuh_t".
 *
 * The followings are the available columns in table 'hasilpengkajianresikojatuh_t':
 * @property integer $hasilpengkajianresikojatuh_id
 * @property integer $pengkajianresikojatuh_id
 * @property string $parameter
 * @property string $penilaian
 * @property integer $skor
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PengkajianresikojatuhT $pengkajianresikojatuh
 */
class HasilpengkajianresikojatuhT extends CActiveRecord
{
	public $resikojatuh_usia_anak_skor, $resikojatuh_usia_anak_kriteria, $resikojatuh_usia_anak;
	public $jeniskelamin_skrining_kriteria, $jeniskelamin_skrining_skor;
	public $resikojatuh_diagnose_anak_kriteria, $resikojatuh_diagnose_anak_skor;
	public $resikojatuh_gangguan_kognitif_anak_kriteria, $resikojatuh_gangguan_kognitif_anak_skor;
	public $resikojatuh_faktor_lingkungan_anak_kriteria, $resikojatuh_faktor_lingkungan_anak_skor;
	public $resikojatuh_responterhadap_pembedahan_anak_kriteria, $resikojatuh_responterhadap_pembedahan_anak_skor;
	public $resikojatuh_pembedahan_medikamentosa_anak_kriteria, $resikojatuh_pembedahan_medikamentosa_anak_skor;
	public $resikojatuh_komorbiditas_dewasa;
	public $resikojatuh_polaeliminasi_dewasa;
	public $resikojatuh_mobilitas_dewasa;
	public $resikojatuh_pengobatan_dewasa;
	public $resikojatuh_kognisi_dewasa;
	public $resikojatuh_riwayatjatuh_dewasa;
	public $resikojatuh_akktivitas_dewasa;
	public $resikojatuh_defisitsensoris_dewasa;
	public $resikojatuh_usia_dewasa;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpengkajianresikojatuhT the static model class
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
		return 'hasilpengkajianresikojatuh_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajianresikojatuh_id, parameter, create_loginpemakai, update_loginpemakai', 'required'),
			array('pengkajianresikojatuh_id, skor, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('parameter', 'length', 'max'=>50),
			array('penilaian', 'length', 'max'=>255),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpengkajianresikojatuh_id, pengkajianresikojatuh_id, parameter, penilaian, skor, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pengkajianresikojatuh' => array(self::BELONGS_TO, 'PengkajianresikojatuhT', 'pengkajianresikojatuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpengkajianresikojatuh_id' => 'Hasilpengkajianresikojatuh',
			'pengkajianresikojatuh_id' => 'Pengkajianresikojatuh',
			'parameter' => 'Parameter',
			'penilaian' => 'Penilaian',
			'skor' => 'Skor',
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

		$criteria->compare('hasilpengkajianresikojatuh_id',$this->hasilpengkajianresikojatuh_id);
		$criteria->compare('pengkajianresikojatuh_id',$this->pengkajianresikojatuh_id);
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('penilaian',$this->penilaian,true);
		$criteria->compare('skor',$this->skor);
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