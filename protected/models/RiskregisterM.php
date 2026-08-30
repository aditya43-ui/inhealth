<?php

/**
 * This is the model class for table "riskregister_m".
 * @author      Elham Budianto <elhambudianto1@gmail.com>
 * @author   Aida Rahmawati <aidarahmawati@.com>
 * @package     application.models
 * 
 * The followings are the available columns in table 'riskregister_m':
 * @property integer $riskregister_id
 * @property string $riskregister_deskripsiresiko
 * @property string $riskregister_penyebab
 * @property integer $tiperesiko_id
 * @property string $riskregister_existingcontrol
 * @property integer $detectability_id
 * @property integer $detectability_skor
 * @property integer $konsekuensi_id
 * @property integer $konsekuensi_skor
 * @property integer $peluang_id
 * @property integer $peluang_skor
 * @property integer $riskregister_rpn
 * @property integer $riskregister_targetrpn
 * @property boolean $riskregister_resikoditerima
 * @property string $riskregister_tanggalmulai
 * @property string $riskregister_tanggaltinjauan
 * @property string $riskregister_riskresponse
 * @property integer $jabatan_id
 *
 * The followings are the available model relations:
 * @property PeluangM $peluang
 * @property KonsekuensiM $konsekuensi
 * @property DetectabilityM $detectability
 * @property TiperesikoM $tiperesiko
 */
class RiskregisterM extends CActiveRecord
{
        public $domain_id;
        public $tgl_awal, $tgl_akhir, $tgl_awal2, $tgl_akhir2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiskregisterM the static model class
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
		return 'riskregister_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tiperesiko_id, detectability_id, konsekuensi_id, peluang_id', 'required'),
			array('tiperesiko_id, detectability_id, detectability_skor, konsekuensi_id, konsekuensi_skor, peluang_id, peluang_skor, riskregister_rpn, riskregister_targetrpn, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('riskregister_deskripsiresiko, riskregister_penyebab', 'length', 'max'=>255),
			array('riskregister_tanggaltinjauan', 'length', 'max'=>45),
			array('riskregister_existingcontrol, riskregister_resikoditerima, riskregister_tanggalmulai, riskregister_riskresponse, sumber_riskregister, evaluasi_risiko, tingkatrisiko_nama,
                            penanggungjawab, detectability_rpnsisa_id, detectability_skor_rpnsisa, konsekuensi_rpnsisa_id, konsekuensi_skor_rpnsisa, peluang_rpnsisa_id, peluang_skor_rpnsisa, riskregister_rpnsisa,
                            laporansingkat, status_riskregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riskregister_id, riskregister_deskripsiresiko, riskregister_penyebab, tiperesiko_id, riskregister_existingcontrol, detectability_id, detectability_skor, konsekuensi_id, konsekuensi_skor, peluang_id, peluang_skor, riskregister_rpn, riskregister_targetrpn, riskregister_resikoditerima, riskregister_tanggalmulai, riskregister_tanggaltinjauan, riskregister_riskresponse, jabatan_id, sumber_riskregister, evaluasi_risiko, 
                            tingkatrisiko_nama, penanggungjawab, detectability_rpnsisa_id, detectability_skor_rpnsisa, konsekuensi_rpnsisa_id, konsekuensi_skor_rpnsisa, peluang_rpnsisa_id, peluang_skor_rpnsisa, riskregister_rpnsisa, laporansingkat, status_riskregister', 'safe', 'on'=>'search'),
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
			'peluang' => array(self::BELONGS_TO, 'PeluangM', 'peluang_id'),
			'konsekuensi' => array(self::BELONGS_TO, 'KonsekuensiM', 'konsekuensi_id'),
			'detectability' => array(self::BELONGS_TO, 'DetectabilityM', 'detectability_id'),
			'tiperesiko' => array(self::BELONGS_TO, 'TiperesikoM', 'tiperesiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riskregister_id' => 'Riskregister',
			'riskregister_deskripsiresiko' => 'Riskregister Deskripsiresiko',
			'riskregister_penyebab' => 'Riskregister Penyebab',
			'tiperesiko_id' => 'Tiperesiko',
			'riskregister_existingcontrol' => 'Riskregister Existingcontrol',
			'detectability_id' => 'Detectability',
			'detectability_skor' => 'Detectability Skor',
			'konsekuensi_id' => 'Konsekuensi',
			'konsekuensi_skor' => 'Konsekuensi Skor',
			'peluang_id' => 'Peluang',
			'peluang_skor' => 'Peluang Skor',
			'riskregister_rpn' => 'Riskregister Rpn',
			'riskregister_targetrpn' => 'Riskregister Targetrpn',
			'riskregister_resikoditerima' => 'Riskregister Resikoditerima',
			'riskregister_tanggalmulai' => 'Riskregister Tanggalmulai',
			'riskregister_tanggaltinjauan' => 'Riskregister Tanggaltinjauan',
			'riskregister_riskresponse' => 'Riskregister Riskresponse',
			'jabatan_id' => 'Jabatan',
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

		$criteria->compare('riskregister_id',$this->riskregister_id);
		$criteria->compare('riskregister_deskripsiresiko',$this->riskregister_deskripsiresiko,true);
		$criteria->compare('riskregister_penyebab',$this->riskregister_penyebab,true);
		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('riskregister_existingcontrol',$this->riskregister_existingcontrol,true);
		$criteria->compare('detectability_id',$this->detectability_id);
		$criteria->compare('detectability_skor',$this->detectability_skor);
		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('konsekuensi_skor',$this->konsekuensi_skor);
		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('peluang_skor',$this->peluang_skor);
		$criteria->compare('riskregister_rpn',$this->riskregister_rpn);
		$criteria->compare('riskregister_targetrpn',$this->riskregister_targetrpn);
		$criteria->compare('riskregister_resikoditerima',$this->riskregister_resikoditerima);
		$criteria->compare('riskregister_tanggalmulai',$this->riskregister_tanggalmulai,true);
		$criteria->compare('riskregister_tanggaltinjauan',$this->riskregister_tanggaltinjauan,true);
		$criteria->compare('riskregister_riskresponse',$this->riskregister_riskresponse,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * Set data dropdown Kosekuensi
     * @return array $data option untuk dropdown
     */
    public static function getDropDownKonsekuensi(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "konsekuensi_bobot ASC";
        $criteria->addCondition('konsekuensi_aktif IS TRUE');
        $models = KonsekuensiM::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->konsekuensi_id]= $model->konsekuensi_bobot.". ".$model->konsekuensi_namabobot;
        }

        return $data;
    }
    
    /**
     * Set data dropdown Peluang
     * @return array $data option untuk dropdown
     */
    public static function getDropDownPeluang(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "peluang_bobotdescriptor ASC";
        $criteria->addCondition('peluang_aktif IS TRUE');
        $models = PeluangM::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->peluang_id] = $model->peluang_bobotdescriptor.". ".$model->peluang_descriptor." (".$model->peluang_frekuensi.")";
        }

        return $data;
    }
    
    /**
     * Set data dropdown Detectability
     * @return array $data option untuk dropdown
     */
    public static function getDropDownDetectability(){
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "detectability_bobot ASC";
        $criteria->addCondition('detectability_aktif IS TRUE');
        $models = DetectabilityM::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->detectability_id]= $model->detectability_bobot.". ".$model->detectability_deskripsi;
        }

        return $data;
    }
    
}