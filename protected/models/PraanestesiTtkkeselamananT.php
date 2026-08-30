<?php

/**
 * This is the model class for table "praanestesi_ttkkeselamanan_t".
 *
 * The followings are the available columns in table 'praanestesi_ttkkeselamanan_t':
 * 
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 * @property integer $praanestesi_ttkkeselamanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property boolean $is_identifikasipasien
 * @property boolean $is_ijinoperasi
 * @property boolean $is_puasadngbaik
 * @property boolean $is_mesinanestesi
 * @property boolean $is_suction
 * @property boolean $is_obatan
 * @property boolean $is_antibiotikprofilaksis
 * @property boolean $is_pulseoxymeter
 * @property boolean $is_ekg
 * @property boolean $is_sabukpengaman
 * @property boolean $is_stetoskopprecordial
 * @property boolean $is_nibp
 * @property boolean $is_termometer
 * @property boolean $is_selimutpenghangat
 * @property boolean $is_urinkateter
 * @property boolean $is_penghangatcairan
 * @property boolean $pascainduksi_titiktekanan
 * @property boolean $pascainduksi_mataterlindunga
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PraanestesiTtkkeselamananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PraanestesiTtkkeselamananT the static model class
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
		return 'praanestesi_ttkkeselamanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pasienanastesi_id, pasienmasukpenunjang_id, is_identifikasipasien, is_ijinoperasi, is_puasadngbaik, is_mesinanestesi, is_suction, is_obatan, is_antibiotikprofilaksis, is_pulseoxymeter, is_ekg, is_sabukpengaman, is_stetoskopprecordial, is_nibp, is_termometer, is_selimutpenghangat, is_urinkateter, is_penghangatcairan, pascainduksi_titiktekanan, pascainduksi_mataterlindunga, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praanestesi_ttkkeselamanan_id, pendaftaran_id, pasien_id, is_identifikasipasien, is_ijinoperasi, is_puasadngbaik, is_mesinanestesi, is_suction, is_obatan, is_antibiotikprofilaksis, is_pulseoxymeter, is_ekg, is_sabukpengaman, is_stetoskopprecordial, is_nibp, is_termometer, is_selimutpenghangat, is_urinkateter, is_penghangatcairan, pascainduksi_titiktekanan, pascainduksi_mataterlindunga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'praanestesi_ttkkeselamanan_id' => 'Praanestesi Ttkkeselamanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'is_identifikasipasien' => 'Is Identifikasipasien',
			'is_ijinoperasi' => 'Is Ijinoperasi',
			'is_puasadngbaik' => 'Is Puasadngbaik',
			'is_mesinanestesi' => 'Is Mesinanestesi',
			'is_suction' => 'Is Suction',
			'is_obatan' => 'Is Obatan',
			'is_antibiotikprofilaksis' => 'Is Antibiotikprofilaksis',
			'is_pulseoxymeter' => 'Is Pulseoxymeter',
			'is_ekg' => 'Is Ekg',
			'is_sabukpengaman' => 'Is Sabukpengaman',
			'is_stetoskopprecordial' => 'Is Stetoskopprecordial',
			'is_nibp' => 'Is Nibp',
			'is_termometer' => 'Is Termometer',
			'is_selimutpenghangat' => 'Is Selimutpenghangat',
			'is_urinkateter' => 'Is Urinkateter',
			'is_penghangatcairan' => 'Is Penghangatcairan',
			'pascainduksi_titiktekanan' => 'Pascainduksi Titiktekanan',
			'pascainduksi_mataterlindunga' => 'Pascainduksi Mataterlindunga',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('praanestesi_ttkkeselamanan_id',$this->praanestesi_ttkkeselamanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('is_identifikasipasien',$this->is_identifikasipasien);
		$criteria->compare('is_ijinoperasi',$this->is_ijinoperasi);
		$criteria->compare('is_puasadngbaik',$this->is_puasadngbaik);
		$criteria->compare('is_mesinanestesi',$this->is_mesinanestesi);
		$criteria->compare('is_suction',$this->is_suction);
		$criteria->compare('is_obatan',$this->is_obatan);
		$criteria->compare('is_antibiotikprofilaksis',$this->is_antibiotikprofilaksis);
		$criteria->compare('is_pulseoxymeter',$this->is_pulseoxymeter);
		$criteria->compare('is_ekg',$this->is_ekg);
		$criteria->compare('is_sabukpengaman',$this->is_sabukpengaman);
		$criteria->compare('is_stetoskopprecordial',$this->is_stetoskopprecordial);
		$criteria->compare('is_nibp',$this->is_nibp);
		$criteria->compare('is_termometer',$this->is_termometer);
		$criteria->compare('is_selimutpenghangat',$this->is_selimutpenghangat);
		$criteria->compare('is_urinkateter',$this->is_urinkateter);
		$criteria->compare('is_penghangatcairan',$this->is_penghangatcairan);
		$criteria->compare('pascainduksi_titiktekanan',$this->pascainduksi_titiktekanan);
		$criteria->compare('pascainduksi_mataterlindunga',$this->pascainduksi_mataterlindunga);
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