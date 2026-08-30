<?php

/**
 * This is the model class for table "catatanperawat_t".
 *
 * The followings are the available columns in table 'catatanperawat_t':
 * @property integer $catatanperawat_id
 * @property string $tglobservasi
 * @property string $diagnosa_nama
 * @property string $catatanperawat
 * @property integer $perawatmengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $perawatmengetahui
 */
class CatatanperawatT extends CActiveRecord
{
	public $perawatmengetahui_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catatanperawat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perawatmengetahui_id, create_time, create_loginpemakai_id, create_ruangan, pendaftaran_id', 'required'),
			array('perawatmengetahui_id, pendaftaran_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('tglobservasi, diagnosa_nama, catatanperawat, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('catatanperawat_id, tglobservasi, diagnosa_nama, catatanperawat, perawatmengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id, pasienadmisi_id', 'safe', 'on'=>'search'),
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
			'perawatmengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'perawatmengetahui_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanperawat_id' => 'Catatanperawat',
			'tglobservasi' => 'Tgl. Observasi',
			'diagnosa_nama' => 'Diagnosa',
			'catatanperawat' => 'Catatan',
			'perawatmengetahui_id' => 'Perawat Mengetahui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('catatanperawat_id',$this->catatanperawat_id);
		$criteria->compare('tglobservasi',$this->tglobservasi,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('catatanperawat',$this->catatanperawat,true);
		$criteria->compare('perawatmengetahui_id',$this->perawatmengetahui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);	
		}

		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);	
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatatanperawatT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
