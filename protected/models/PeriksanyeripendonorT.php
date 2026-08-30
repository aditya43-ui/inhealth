<?php

/**
 * This is the model class for table "periksanyeripendonor_t".
 *
 * The followings are the available columns in table 'periksanyeripendonor_t':  
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $periksanyeripendonor_id
 * @property integer $pendonor_id
 * @property string $tglperiksanyeri
 * @property boolean $keluhannyeri
 * @property integer $score_skalanyeri
 * @property string $keteranganskala_nyeri
 * @property string $frekuensinyeri
 * @property integer $lamanyeri
 * @property string $satuanlamanyeri
 * @property boolean $is_nyerimenjalar
 * @property string $nyerimenjalarke
 * @property string $kualitasnyeri
 * @property string $pemicu_memperberat
 * @property string $pemicu_meringankan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property GambarnyeriT[] $gambarnyeriTs
 */
class PeriksanyeripendonorT extends CActiveRecord
{
        public $petugas_nama, $nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksanyeripendonorT the static model class
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
		return 'periksanyeripendonor_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendonor_id, tglperiksanyeri, score_skalanyeri, keteranganskala_nyeri, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendonor_id, petugas_id, score_skalanyeri, lamanyeri, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('keteranganskala_nyeri', 'length', 'max'=>100),
			array('frekuensinyeri', 'length', 'max'=>50),
			array('satuanlamanyeri', 'length', 'max'=>20),
			array('nyerimenjalarke', 'length', 'max'=>200),
			array('kualitasnyeri', 'length', 'max'=>150),
			array('pemicu_memperberat, pemicu_meringankan', 'length', 'max'=>250),
			array('daftardonasi_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksanyeripendonor_id, petugas_id, pendonor_id, tglperiksanyeri, keluhannyeri, score_skalanyeri, keteranganskala_nyeri, frekuensinyeri, lamanyeri, satuanlamanyeri, is_nyerimenjalar, nyerimenjalarke, kualitasnyeri, pemicu_memperberat, pemicu_meringankan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'gambarnyeriTs' => array(self::HAS_MANY, 'GambarnyeriT', 'periksanyeripendonor_id'),
                    'petugaspenyadap' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksanyeripendonor_id' => 'Periksanyeripendonor',
			'pendonor_id' => 'Pendonor',
			'tglperiksanyeri' => 'Tanggal Pemeriksaan',
			'keluhannyeri' => 'Keluhannyeri',
			'score_skalanyeri' => 'Score Skalanyeri',
			'keteranganskala_nyeri' => 'Keteranganskala Nyeri',
			'frekuensinyeri' => 'Frekuensi Nyeri',
			'lamanyeri' => 'Lama Nyeri',
			'satuanlamanyeri' => 'Satuanlamanyeri',
			'is_nyerimenjalar' => 'Nyeri Menjalar',
			'nyerimenjalarke' => 'Nyerimenjalarke',
			'kualitasnyeri' => 'Kualitas Nyeri',
			'pemicu_memperberat' => 'Pemicu',
			'pemicu_meringankan' => 'Yang Mengurangi/ Yang Menghilangkan Rasa Sakit ',
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

		$criteria->compare('periksanyeripendonor_id',$this->periksanyeripendonor_id);
		$criteria->compare('pendonor_id',$this->pendonor_id);
		$criteria->compare('tglperiksanyeri',$this->tglperiksanyeri,true);
		$criteria->compare('keluhannyeri',$this->keluhannyeri);
		$criteria->compare('score_skalanyeri',$this->score_skalanyeri);
		$criteria->compare('keteranganskala_nyeri',$this->keteranganskala_nyeri,true);
		$criteria->compare('frekuensinyeri',$this->frekuensinyeri,true);
		$criteria->compare('lamanyeri',$this->lamanyeri);
		$criteria->compare('satuanlamanyeri',$this->satuanlamanyeri,true);
		$criteria->compare('is_nyerimenjalar',$this->is_nyerimenjalar);
		$criteria->compare('nyerimenjalarke',$this->nyerimenjalarke,true);
		$criteria->compare('kualitasnyeri',$this->kualitasnyeri,true);
		$criteria->compare('pemicu_memperberat',$this->pemicu_memperberat,true);
		$criteria->compare('pemicu_meringankan',$this->pemicu_meringankan,true);
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