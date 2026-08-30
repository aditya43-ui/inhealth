<?php

/**
 * This is the model class for table "gradinginsidenrs_t".
 *
 * @author  Andyka <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'gradinginsidenrs_t':
 * @property integer $gradinginsidenrs_id
 * @property integer $insidenrs_id
 * @property string $tgl_gradingunit
 * @property integer $peluang_id
 * @property integer $konsekuensi_id
 * @property integer $tingkatrisiko_id
 * @property string $gradingrisiko
 * @property string $tindakan
 * @property string $tglverifikasi_unit
 * @property integer $grader1
 * @property integer $grader2
 * @property string $statuslaporan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $tgl_kirimpelaporan
 *
 * The followings are the available model relations:
 * @property TingkatrisikoM $tingkatrisiko
 * @property PeluangM $peluang
 * @property KonsekuensiM $konsekuensi
 * @property InsidenrsT $insidenrs
 */
class GradinginsidenrsT extends CActiveRecord
{
    public $grader1_nama;
    public $grader_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GradinginsidenrsT the static model class
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
		return 'gradinginsidenrs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('insidenrs_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('insidenrs_id, peluang_id, konsekuensi_id, tingkatrisiko_id, grader1, grader2, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('gradingrisiko, regradingrisiko', 'length', 'max'=>150),
			array('statuslaporan', 'length', 'max'=>50),
			array('tindaklanjut, skor_risiko, tgl_gradingunit, tindakan, tglverifikasi_unit, update_time, tgl_kirimpelaporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gradinginsidenrs_id, insidenrs_id, tgl_gradingunit, peluang_id, konsekuensi_id, tingkatrisiko_id, gradingrisiko, tindakan, tglverifikasi_unit, grader1, grader2, statuslaporan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_kirimpelaporan', 'safe', 'on'=>'search'),
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
			'tingkatrisiko' => array(self::BELONGS_TO, 'TingkatrisikoM', 'tingkatrisiko_id'),
			'peluang' => array(self::BELONGS_TO, 'PeluangM', 'peluang_id'),
			'konsekuensi' => array(self::BELONGS_TO, 'KonsekuensiM', 'konsekuensi_id'),
			'insidenrs' => array(self::BELONGS_TO, 'InsidenrsT', 'insidenrs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gradinginsidenrs_id' => 'Gradinginsidenrs',
			'insidenrs_id' => 'Insidenrs',
			'tgl_gradingunit' => 'Tgl Gradingunit',
			'peluang_id' => 'Peluang',
			'konsekuensi_id' => 'Konsekuensi',
			'tingkatrisiko_id' => 'Tingkatrisiko',
			'gradingrisiko' => 'Gradingrisiko',
			'tindakan' => 'Tindakan',
			'tglverifikasi_unit' => 'Tglverifikasi Unit',
			'grader1' => 'Grader1',
			'grader2' => 'Grader2',
			'statuslaporan' => 'Statuslaporan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'tgl_kirimpelaporan' => 'Tgl Pelaporan',
			'skor_risiko' => 'Skor Risiko',
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

		$criteria->compare('gradinginsidenrs_id',$this->gradinginsidenrs_id);
		$criteria->compare('insidenrs_id',$this->insidenrs_id);
		$criteria->compare('tgl_gradingunit',$this->tgl_gradingunit,true);
		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('tingkatrisiko_id',$this->tingkatrisiko_id);
		$criteria->compare('gradingrisiko',$this->gradingrisiko,true);
		$criteria->compare('tindakan',$this->tindakan,true);
		$criteria->compare('tglverifikasi_unit',$this->tglverifikasi_unit,true);
		$criteria->compare('grader1',$this->grader1);
		$criteria->compare('grader2',$this->grader2);
		$criteria->compare('statuslaporan',$this->statuslaporan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('tgl_kirimpelaporan',$this->tgl_kirimpelaporan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}