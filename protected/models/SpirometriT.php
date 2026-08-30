<?php

/**
 * This is the model class for table "spirometri_t".
 *
 * The followings are the available columns in table 'spirometri_t':
 * @property integer $spirometri_id
 * @property string $spirometri_tgl
 * @property integer $pendaftaran_id
 * @property double $svc_prediksi
 * @property double $svc
 * @property double $svc_persen
 * @property double $fvc_prediksi
 * @property double $fvc
 * @property double $fvc_persen
 * @property double $fev1_prediksi
 * @property double $fev1
 * @property double $fev1_persen
 * @property double $fev1_fvc_prediksi
 * @property double $fev1_fvc
 * @property double $fev1_fvc_persen
 * @property double $pfr_prediksi
 * @property double $pfr
 * @property double $pfr_persen
 * @property boolean $pakai_bronkhodilator
 * @property string $kesimpulan
 * @property string $test_spirometri
 * @property boolean $test_reversibilitas_is_positif
 * @property double $test_reversibilitas_nilai
 * @property string $saran
 * @property integer $pegawai_id
 * @property integer $pengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pengetahui
 */
class SpirometriT extends CActiveRecord
{
    public $mengetahui_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpirometriT the static model class
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
		return 'spirometri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('spirometri_tgl, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pegawai_id, pengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('svc_prediksi, svc, svc_persen, fvc_prediksi, fvc, fvc_persen, fev1_prediksi, fev1, fev1_persen, fev1_fvc_prediksi, fev1_fvc, fev1_fvc_persen, pfr_prediksi, pfr, pfr_persen, test_reversibilitas_nilai', 'numerical'),
			array('pakai_bronkhodilator, kesimpulan, test_spirometri, test_reversibilitas_is_positif, saran, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('spirometri_id, spirometri_tgl, pendaftaran_id, svc_prediksi, svc, svc_persen, fvc_prediksi, fvc, fvc_persen, fev1_prediksi, fev1, fev1_persen, fev1_fvc_prediksi, fev1_fvc, fev1_fvc_persen, pfr_prediksi, pfr, pfr_persen, pakai_bronkhodilator, kesimpulan, test_spirometri, test_reversibilitas_is_positif, test_reversibilitas_nilai, saran, pegawai_id, pengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'spirometri_id' => 'Spirometri',
			'spirometri_tgl' => 'Spirometri Tgl',
			'pendaftaran_id' => 'Pendaftaran',
			'svc_prediksi' => 'Svc Prediksi',
			'svc' => 'Svc',
			'svc_persen' => 'Svc Persen',
			'fvc_prediksi' => 'Fvc Prediksi',
			'fvc' => 'Fvc',
			'fvc_persen' => 'Fvc Persen',
			'fev1_prediksi' => 'Fev1 Prediksi',
			'fev1' => 'Fev1',
			'fev1_persen' => 'Fev1 Persen',
			'fev1_fvc_prediksi' => 'Fev1 Fvc Prediksi',
			'fev1_fvc' => 'Fev1 Fvc',
			'fev1_fvc_persen' => 'Fev1 Fvc Persen',
			'pfr_prediksi' => 'Pfr Prediksi',
			'pfr' => 'Pfr',
			'pfr_persen' => 'Pfr Persen',
			'pakai_bronkhodilator' => 'Pakai Bronkhodilator',
			'kesimpulan' => 'Kesimpulan',
			'test_spirometri' => 'Test Spirometri',
			'test_reversibilitas_is_positif' => 'Test Reversibilitas Is Positif',
			'test_reversibilitas_nilai' => 'Test Reversibilitas Nilai',
			'saran' => 'Saran',
			'pegawai_id' => 'Pegawai',
			'pengetahui_id' => 'Pengetahui',
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

		$criteria->compare('spirometri_id',$this->spirometri_id);
		$criteria->compare('spirometri_tgl',$this->spirometri_tgl,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('svc_prediksi',$this->svc_prediksi);
		$criteria->compare('svc',$this->svc);
		$criteria->compare('svc_persen',$this->svc_persen);
		$criteria->compare('fvc_prediksi',$this->fvc_prediksi);
		$criteria->compare('fvc',$this->fvc);
		$criteria->compare('fvc_persen',$this->fvc_persen);
		$criteria->compare('fev1_prediksi',$this->fev1_prediksi);
		$criteria->compare('fev1',$this->fev1);
		$criteria->compare('fev1_persen',$this->fev1_persen);
		$criteria->compare('fev1_fvc_prediksi',$this->fev1_fvc_prediksi);
		$criteria->compare('fev1_fvc',$this->fev1_fvc);
		$criteria->compare('fev1_fvc_persen',$this->fev1_fvc_persen);
		$criteria->compare('pfr_prediksi',$this->pfr_prediksi);
		$criteria->compare('pfr',$this->pfr);
		$criteria->compare('pfr_persen',$this->pfr_persen);
		$criteria->compare('pakai_bronkhodilator',$this->pakai_bronkhodilator);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
		$criteria->compare('test_spirometri',$this->test_spirometri,true);
		$criteria->compare('test_reversibilitas_is_positif',$this->test_reversibilitas_is_positif);
		$criteria->compare('test_reversibilitas_nilai',$this->test_reversibilitas_nilai);
		$criteria->compare('saran',$this->saran,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pengetahui_id',$this->pengetahui_id);
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