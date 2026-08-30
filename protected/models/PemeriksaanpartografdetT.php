<?php

/**
 * This is the model class for table "pemeriksaanpartografdet_t".
 *
 * The followings are the available columns in table 'pemeriksaanpartografdet_t':
 * @property integer $pemeriksaanpartografdet_id
 * @property integer $pemeriksaanpartograf_id
 * @property integer $p1_djj_menit
 * @property string $p2_airketuban
 * @property string $p2_penyusupan
 * @property integer $p3_pembukaanserviks
 * @property integer $p3_turunnyakepala
 * @property string $p3_waktu
 * @property integer $p4_kontraksi_jml
 * @property string $p4_kontraksi_lama_detik
 * @property integer $p5_oksitosin_unit
 * @property integer $p5_tetes_menit
 * @property string $p6_tekanandarah
 * @property integer $p6_systolic
 * @property integer $p6_diastolic
 * @property integer $p6_nadi
 * @property boolean $p6_penyulit
 * @property double $p7_suhu
 * @property string $p8_urin_protein
 * @property string $p8_urin_aseton
 * @property integer $p8_urin_volume
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PemeriksaanpartografT $pemeriksaanpartograf
 * @property PemeriksaanpartografobatT[] $pemeriksaanpartografobatTs
 */
class PemeriksaanpartografdetT extends CActiveRecord
{	
        public $nourutlain; 
        public $qty_oa;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanpartografdetT the static model class
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
		return 'pemeriksaanpartografdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanpartograf_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaanpartograf_id, p1_djj_menit, p3_pembukaanserviks, p3_turunnyakepala, p4_kontraksi_jml, p5_oksitosin_unit, p5_tetes_menit, p6_systolic, p6_diastolic, p6_nadi, p8_urin_volume, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('p7_suhu', 'numerical'),
			array('p2_airketuban, p2_penyusupan, p8_urin_protein, p8_urin_aseton', 'length', 'max'=>100),
			array('p4_kontraksi_lama_detik, p6_tekanandarah', 'length', 'max'=>20),
			array('pemeriksaan_ke, penepisan, perlunakan, skor_pelvik, respirasi, gcs_eye, gcs_verbal, gcs_motorik, gcs_totalskor, center_venous_pressure, waktucatat, p3_waktu, p6_penyulit, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanpartografdet_id, pemeriksaanpartograf_id, p1_djj_menit, p2_airketuban, p2_penyusupan, p3_pembukaanserviks, p3_turunnyakepala, p3_waktu, p4_kontraksi_jml, p4_kontraksi_lama_detik, p5_oksitosin_unit, p5_tetes_menit, p6_tekanandarah, p6_systolic, p6_diastolic, p6_nadi, p6_penyulit, p7_suhu, p8_urin_protein, p8_urin_aseton, p8_urin_volume, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanpartograf' => array(self::BELONGS_TO, 'PemeriksaanpartografT', 'pemeriksaanpartograf_id'),
			'pemeriksaanpartografobatTs' => array(self::HAS_MANY, 'PemeriksaanpartografobatT', 'pemeriksaanpartografdet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpartografdet_id' => 'Pemeriksaanpartografdet',
			'pemeriksaanpartograf_id' => 'Pemeriksaanpartograf',
			'p1_djj_menit' => 'P1 Djj Menit',
			'p2_airketuban' => 'P2 Airketuban',
			'p2_penyusupan' => 'P2 Penyusupan',
			'p3_pembukaanserviks' => 'P3 Pembukaanserviks',
			'p3_turunnyakepala' => 'P3 Turunnyakepala',
			'p3_waktu' => 'P3 Waktu',
			'p4_kontraksi_jml' => 'P4 Kontraksi Jml',
			'p4_kontraksi_lama_detik' => 'P4 Kontraksi Lama Detik',
			'p5_oksitosin_unit' => 'P5 Oksitosin Unit',
			'p5_tetes_menit' => 'P5 Tetes Menit',
			'p6_tekanandarah' => 'P6 Tekanandarah',
			'p6_systolic' => 'P6 Systolic',
			'p6_diastolic' => 'P6 Diastolic',
			'p6_nadi' => 'P6 Nadi',
			'p6_penyulit' => 'P6 Penyulit',
			'p7_suhu' => 'P7 Suhu',
			'p8_urin_protein' => 'P8 Urin Protein',
			'p8_urin_aseton' => 'P8 Urin Aseton',
			'p8_urin_volume' => 'P8 Urin Volume',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pemeriksaanpartografdet_id',$this->pemeriksaanpartografdet_id);
		$criteria->compare('pemeriksaanpartograf_id',$this->pemeriksaanpartograf_id);
		$criteria->compare('p1_djj_menit',$this->p1_djj_menit);
		$criteria->compare('p2_airketuban',$this->p2_airketuban,true);
		$criteria->compare('p2_penyusupan',$this->p2_penyusupan,true);
		$criteria->compare('p3_pembukaanserviks',$this->p3_pembukaanserviks);
		$criteria->compare('p3_turunnyakepala',$this->p3_turunnyakepala);
		$criteria->compare('p3_waktu',$this->p3_waktu,true);
		$criteria->compare('p4_kontraksi_jml',$this->p4_kontraksi_jml);
		$criteria->compare('p4_kontraksi_lama_detik',$this->p4_kontraksi_lama_detik,true);
		$criteria->compare('p5_oksitosin_unit',$this->p5_oksitosin_unit);
		$criteria->compare('p5_tetes_menit',$this->p5_tetes_menit);
		$criteria->compare('p6_tekanandarah',$this->p6_tekanandarah,true);
		$criteria->compare('p6_systolic',$this->p6_systolic);
		$criteria->compare('p6_diastolic',$this->p6_diastolic);
		$criteria->compare('p6_nadi',$this->p6_nadi);
		$criteria->compare('p6_penyulit',$this->p6_penyulit);
		$criteria->compare('p7_suhu',$this->p7_suhu);
		$criteria->compare('p8_urin_protein',$this->p8_urin_protein,true);
		$criteria->compare('p8_urin_aseton',$this->p8_urin_aseton,true);
		$criteria->compare('p8_urin_volume',$this->p8_urin_volume);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}