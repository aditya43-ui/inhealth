<?php

/**
 * This is the model class for table "denyutjantungjanin_t".
 *
 * The followings are the available columns in table 'denyutjantungjanin_t':
 * @property integer $denyutjantungjanin_id
 * @property integer $partografpasien_id
 * @property integer $pemeriksaanke
 * @property string $tgl_pemeriksaan
 * @property string $jam_pemeriksaan
 * @property integer $denyutjantung_janin
 * @property integer $petugaspemeriksa_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property PartografpasienT $partografpasien
 */
class DenyutjantungjaninT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DenyutjantungjaninT the static model class
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
		return 'denyutjantungjanin_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partografpasien_id, pemeriksaanke, tgl_pemeriksaan, jam_pemeriksaan, create_loginpemakai_id', 'required'),
			array('partografpasien_id, pemeriksaanke, denyutjantung_janin, petugaspemeriksa_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('denyutjantungjanin_id, partografpasien_id, pemeriksaanke, tgl_pemeriksaan, jam_pemeriksaan, denyutjantung_janin, petugaspemeriksa_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'partografpasien' => array(self::BELONGS_TO, 'PartografpasienT', 'partografpasien_id'),
			'petugaspemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspemeriksa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'denyutjantungjanin_id' => 'Denyutjantungjanin',
			'partografpasien_id' => 'Partografpasien',
			'pemeriksaanke' => 'Pemeriksaan Ke-',
			'tgl_pemeriksaan' => 'Tanggal Pemeriksaan',
			'jam_pemeriksaan' => 'Jam Pemeriksaan',
			'denyutjantung_janin' => 'Denyut Jantung Janin',
			'petugaspemeriksa_id' => 'Petugas Pemeriksa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('denyutjantungjanin_id',$this->denyutjantungjanin_id);
		$criteria->compare('partografpasien_id',$this->partografpasien_id);
		$criteria->compare('pemeriksaanke',$this->pemeriksaanke);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('jam_pemeriksaan',$this->jam_pemeriksaan,true);
		$criteria->compare('denyutjantung_janin',$this->denyutjantung_janin);
		$criteria->compare('petugaspemeriksa_id',$this->petugaspemeriksa_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getNoPemeriksaan() {
        
        $cr = new CDbCriteria();
        $cr->compare('partografpasien_id', $this->partografpasien_id);
        $cr->order = 'pemeriksaanke desc';
        
        $det = self::model()->find($cr);
        
        return empty($det) ? 1 : ($det->pemeriksaanke + 1);
    }
    
    public static function resetUrutanPeriksa($partografpasien_id) {
        $model = self::model()->findAllByAttributes(array(
            'partografpasien_id'=>$partografpasien_id,
        ), array(
            'order'=>'pemeriksaanke asc',
        ));
        
        foreach($model as $idx => $item) {
            $item->pemeriksaanke = $idx + 1;
            $item->save();
        }
    }
}