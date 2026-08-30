<?php

/**
 * This is the model class for table "monitoringjalanlahir_t".
 *
 * The followings are the available columns in table 'monitoringjalanlahir_t':
 * @property integer $monitoringjalanlahir_id
 * @property integer $partografpasien_id
 * @property integer $pemeriksaanke
 * @property string $tgl_pemeriksaan
 * @property string $jam_pemeriksaan
 * @property integer $pembukaanserviks
 * @property integer $turunnyakepalajanin
 * @property integer $petugaspemeriksa_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property PartografpasienT $partografpasien
 * @property PegawaiM $petugaspemeriksa
 */
class MonitoringjalanlahirT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringjalanlahirT the static model class
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
		return 'monitoringjalanlahir_t';
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
			array('partografpasien_id, pemeriksaanke, pembukaanserviks, turunnyakepalajanin, petugaspemeriksa_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringjalanlahir_id, partografpasien_id, pemeriksaanke, tgl_pemeriksaan, jam_pemeriksaan, pembukaanserviks, turunnyakepalajanin, petugaspemeriksa_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'monitoringjalanlahir_id' => 'Monitoringjalanlahir',
			'partografpasien_id' => 'Partografpasien',
			'pemeriksaanke' => 'Pemeriksana Ke-',
			'tgl_pemeriksaan' => 'Tanggal Pemeriksaan',
			'jam_pemeriksaan' => 'Jam Pemeriksaan',
			'pembukaanserviks' => 'Pembukaan Serviks (cm)',
			'turunnyakepalajanin' => 'Turunnya Kepala (O)',
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

		$criteria->compare('monitoringjalanlahir_id',$this->monitoringjalanlahir_id);
		$criteria->compare('partografpasien_id',$this->partografpasien_id);
		$criteria->compare('pemeriksaanke',$this->pemeriksaanke);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('jam_pemeriksaan',$this->jam_pemeriksaan,true);
		$criteria->compare('pembukaanserviks',$this->pembukaanserviks);
		$criteria->compare('turunnyakepalajanin',$this->turunnyakepalajanin);
		$criteria->compare('petugaspemeriksa_id',$this->petugaspemeriksa_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchRiwayat() {
        $prov = $this->search();
        $prov->sort->defaultOrder = 'partografpasien_id, pemeriksaanke';
        return $prov;
    }
    
    public static function generatePemeriksaanKe($partografpasien_id) {
        $model = self::model()->findByAttributes(array(
            'partografpasien_id'=>$partografpasien_id,
        ), array(
            'order'=>'pemeriksaanke desc',
        ));
        
        return empty($model) ? 1 : ($model->pemeriksaanke + 1);
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