<?php

/**
 * This is the model class for table "verifbataltindakan_t".
 *
 * The followings are the available columns in table 'verifbataltindakan_t':
 * @property integer $verifbataltindakan_id
 * @property string $tglverifikasibatal
 * @property string $noverifikasi_batal
 * @property string $keterangan_verifbatal
 * @property integer $petugas_verif_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $bataltindakan_id
 * @property string $tglbataltindakanpelayanan
 * @property integer $petugasbatal_id
 */
class VerifbataltindakanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'verifbataltindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglverifikasibatal, mengetahui_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('verifbataltindakan_id, petugas_verif_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, bataltindakan_id, petugasbatal_id', 'numerical', 'integerOnly'=>true),
			array('noverifikasi_batal', 'length', 'max'=>50),
			array('keterangan_verifbatal, update_time, tglbataltindakanpelayanan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('verifbataltindakan_id, tglverifikasibatal, noverifikasi_batal, keterangan_verifbatal, petugas_verif_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, bataltindakan_id, tglbataltindakanpelayanan, petugasbatal_id', 'safe', 'on'=>'search'),
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
			'verifbataltindakan_id' => 'Verifbataltindakan',
			'tglverifikasibatal' => 'Tglverifikasibatal',
			'noverifikasi_batal' => 'Noverifikasi Batal',
			'keterangan_verifbatal' => 'Keterangan Verifbatal',
			'petugas_verif_id' => 'Petugas Verif',
			'mengetahui_id' => 'Mengetahui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'bataltindakan_id' => 'Bataltindakan',
			'tglbataltindakanpelayanan' => 'Tglbataltindakanpelayanan',
			'petugasbatal_id' => 'Petugasbatal',
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

		$criteria->compare('verifbataltindakan_id',$this->verifbataltindakan_id);
		$criteria->compare('tglverifikasibatal',$this->tglverifikasibatal,true);
		$criteria->compare('noverifikasi_batal',$this->noverifikasi_batal,true);
		$criteria->compare('keterangan_verifbatal',$this->keterangan_verifbatal,true);
		$criteria->compare('petugas_verif_id',$this->petugas_verif_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('bataltindakan_id',$this->bataltindakan_id);
		$criteria->compare('tglbataltindakanpelayanan',$this->tglbataltindakanpelayanan,true);
		$criteria->compare('petugasbatal_id',$this->petugasbatal_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerifbataltindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
