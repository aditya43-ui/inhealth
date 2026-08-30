<?php

/**
 * This is the model class for table "progressmonevindentifikasirisiko_t".
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'progressmonevindentifikasirisiko_t':
 * @property integer $progressmonevindentifikasirisiko_id
 * @property integer $identifikasiresiko_id
 * @property integer $evaluasiidentifikasirisiko_id
 * @property integer $konsekuensi_id
 * @property integer $peluang_id
 * @property integer $detectability_id
 * @property integer $rpn_score
 * @property integer $rpn_sisa
 * @property string $status_riskregister
 * @property string $laporansingkat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property EvaluasiidentifikasirisikoT $evaluasiidentifikasirisiko
 * @property IdentifikasiresikoT $identifikasiresiko
 */
class ProgressmonevindentifikasirisikoT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProgressmonevindentifikasirisikoT the static model class
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
		return 'progressmonevindentifikasirisiko_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identifikasiresiko_id, evaluasiidentifikasirisiko_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('identifikasiresiko_id, evaluasiidentifikasirisiko_id, konsekuensi_id, peluang_id, detectability_id, rpn_score, rpn_sisa, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('status_riskregister', 'length', 'max'=>50),
			array('laporansingkat, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('progressmonevindentifikasirisiko_id, identifikasiresiko_id, evaluasiidentifikasirisiko_id, konsekuensi_id, peluang_id, detectability_id, rpn_score, rpn_sisa, status_riskregister, laporansingkat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'evaluasiidentifikasirisiko' => array(self::BELONGS_TO, 'EvaluasiidentifikasirisikoT', 'evaluasiidentifikasirisiko_id'),
			'identifikasiresiko' => array(self::BELONGS_TO, 'IdentifikasiresikoT', 'identifikasiresiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'progressmonevindentifikasirisiko_id' => 'Progressmonevindentifikasirisiko',
			'identifikasiresiko_id' => 'Identifikasiresiko',
			'evaluasiidentifikasirisiko_id' => 'Evaluasiidentifikasirisiko',
			'konsekuensi_id' => 'Konsekuensi',
			'peluang_id' => 'Peluang',
			'detectability_id' => 'Detectability',
			'rpn_score' => 'Rpn Score',
			'rpn_sisa' => 'Rpn Sisa',
			'status_riskregister' => 'Status Riskregister',
			'laporansingkat' => 'Laporansingkat',
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

		$criteria->compare('progressmonevindentifikasirisiko_id',$this->progressmonevindentifikasirisiko_id);
		$criteria->compare('identifikasiresiko_id',$this->identifikasiresiko_id);
		$criteria->compare('evaluasiidentifikasirisiko_id',$this->evaluasiidentifikasirisiko_id);
		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('detectability_id',$this->detectability_id);
		$criteria->compare('rpn_score',$this->rpn_score);
		$criteria->compare('rpn_sisa',$this->rpn_sisa);
		$criteria->compare('status_riskregister',$this->status_riskregister,true);
		$criteria->compare('laporansingkat',$this->laporansingkat,true);
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