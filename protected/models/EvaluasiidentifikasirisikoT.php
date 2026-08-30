<?php

/**
 * This is the model class for table "evaluasiidentifikasirisiko_t".
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'evaluasiidentifikasirisiko_t':
 * @property integer $evaluasiidentifikasirisiko_id
 * @property integer $identifikasirisiko_id
 * @property string $evaluasi_risiko
 * @property integer $pegawai_id
 * @property string $tgl_mulai
 * @property string $tgl_tinjauan
 * @property string $riskrespon
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property IdentifikasiresikoT $identifikasirisiko
 * @property ProgressmonevindentifikasirisikoT[] $progressmonevindentifikasirisikoTs
 */
class EvaluasiidentifikasirisikoT extends CActiveRecord
{       
        public $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasiidentifikasirisikoT the static model class
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
		return 'evaluasiidentifikasirisiko_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identifikasirisiko_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('identifikasirisiko_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('evaluasi_risiko', 'length', 'max'=>100),
			array('tgl_mulai, tgl_tinjauan, riskrespon, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasiidentifikasirisiko_id, identifikasirisiko_id, evaluasi_risiko, pegawai_id, tgl_mulai, tgl_tinjauan, riskrespon, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'identifikasirisiko' => array(self::BELONGS_TO, 'IdentifikasiresikoT', 'identifikasirisiko_id'),
			'progressmonevindentifikasirisikoTs' => array(self::HAS_MANY, 'ProgressmonevindentifikasirisikoT', 'evaluasiidentifikasirisiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiidentifikasirisiko_id' => 'Evaluasiidentifikasirisiko',
			'identifikasirisiko_id' => 'Identifikasirisiko',
			'evaluasi_risiko' => 'Evaluasi Risiko',
			'pegawai_id' => 'Pegawai',
			'tgl_mulai' => 'Tgl Mulai',
			'tgl_tinjauan' => 'Tgl Tinjauan',
			'riskrespon' => 'Riskrespon',
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

		$criteria->compare('evaluasiidentifikasirisiko_id',$this->evaluasiidentifikasirisiko_id);
		$criteria->compare('identifikasirisiko_id',$this->identifikasirisiko_id);
		$criteria->compare('evaluasi_risiko',$this->evaluasi_risiko,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tgl_mulai',$this->tgl_mulai,true);
		$criteria->compare('tgl_tinjauan',$this->tgl_tinjauan,true);
		$criteria->compare('riskrespon',$this->riskrespon,true);
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