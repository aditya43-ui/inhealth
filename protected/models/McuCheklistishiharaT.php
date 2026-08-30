<?php

/**
 * This is the model class for table "mcu_cheklistishihara_t".
 *
 * The followings are the available columns in table 'mcu_cheklistishihara_t':
 * @property integer $mcu_cheklistishihara_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pemeriksaan
 * @property integer $pemeriksa_id
 * @property boolean $ishihara_no1
 * @property boolean $ishihara_no2
 * @property boolean $ishihara_no3
 * @property boolean $ishihara_no4
 * @property boolean $ishihara_no5
 * @property boolean $ishihara_no6
 * @property boolean $ishihara_no7
 * @property boolean $ishihara_no8
 * @property boolean $ishihara_no9
 * @property boolean $ishihara_no10
 * @property boolean $ishihara_no11
 * @property boolean $ishihara_no12
 * @property boolean $ishihara_no13
 * @property boolean $ishihara_no14
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property string $kesimpulan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PegawaiM $pemeriksa
 * @property PendaftaranT $pendaftaran
 */
class McuCheklistishiharaT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mcu_cheklistishihara_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('pasien_id, pendaftaran_id, pemeriksa_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('kesimpulan', 'length', 'max'=>20),
			array('tgl_pemeriksaan, ishihara_no1, ishihara_no2, ishihara_no3, ishihara_no4, ishihara_no5, ishihara_no6, ishihara_no7, ishihara_no8, ishihara_no9, ishihara_no10, ishihara_no11, ishihara_no12, ishihara_no13, ishihara_no14, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mcu_cheklistishihara_id, pasien_id, pendaftaran_id, tgl_pemeriksaan, pemeriksa_id, ishihara_no1, ishihara_no2, ishihara_no3, ishihara_no4, ishihara_no5, ishihara_no6, ishihara_no7, ishihara_no8, ishihara_no9, ishihara_no10, ishihara_no11, ishihara_no12, ishihara_no13, ishihara_no14, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, kesimpulan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'pemeriksa_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mcu_cheklistishihara_id' => 'Mcu Cheklistishihara',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'pemeriksa_id' => 'Pemeriksa',
			'ishihara_no1' => 'Ishihara No1',
			'ishihara_no2' => 'Ishihara No2',
			'ishihara_no3' => 'Ishihara No3',
			'ishihara_no4' => 'Ishihara No4',
			'ishihara_no5' => 'Ishihara No5',
			'ishihara_no6' => 'Ishihara No6',
			'ishihara_no7' => 'Ishihara No7',
			'ishihara_no8' => 'Ishihara No8',
			'ishihara_no9' => 'Ishihara No9',
			'ishihara_no10' => 'Ishihara No10',
			'ishihara_no11' => 'Ishihara No11',
			'ishihara_no12' => 'Ishihara No12',
			'ishihara_no13' => 'Ishihara No13',
			'ishihara_no14' => 'Ishihara No14',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'kesimpulan' => 'Kesimpulan',
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

		$criteria->compare('mcu_cheklistishihara_id',$this->mcu_cheklistishihara_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('pemeriksa_id',$this->pemeriksa_id);
		$criteria->compare('ishihara_no1',$this->ishihara_no1);
		$criteria->compare('ishihara_no2',$this->ishihara_no2);
		$criteria->compare('ishihara_no3',$this->ishihara_no3);
		$criteria->compare('ishihara_no4',$this->ishihara_no4);
		$criteria->compare('ishihara_no5',$this->ishihara_no5);
		$criteria->compare('ishihara_no6',$this->ishihara_no6);
		$criteria->compare('ishihara_no7',$this->ishihara_no7);
		$criteria->compare('ishihara_no8',$this->ishihara_no8);
		$criteria->compare('ishihara_no9',$this->ishihara_no9);
		$criteria->compare('ishihara_no10',$this->ishihara_no10);
		$criteria->compare('ishihara_no11',$this->ishihara_no11);
		$criteria->compare('ishihara_no12',$this->ishihara_no12);
		$criteria->compare('ishihara_no13',$this->ishihara_no13);
		$criteria->compare('ishihara_no14',$this->ishihara_no14);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return McuCheklistishiharaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
