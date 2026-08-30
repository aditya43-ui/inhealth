<?php

/**
 * This is the model class for table "catatanimplementasi_t".
 *
 * The followings are the available columns in table 'catatanimplementasi_t':
 * @property integer $catatanimplementasi_id
 * @property integer $ruangan_id
 * @property integer $diagnosa_id
 * @property integer $kelaspelayanan_id
 * @property string $kelompok_resiko
 * @property string $tgl_evaluasi
 * @property string $pelaksanaan
 * @property string $monitoring
 * @property string $fasilitas
 * @property string $advokasi
 * @property string $hasilpelayanan
 * @property string $terminasi
 * @property integer $petugaspengisi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $petugaspengisi
 */
class CatatanimplementasiT extends CActiveRecord
{
	public $kelompok_resikolainnya,$diagnosa_nama, $petugaspengisi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatatanimplementasiT the static model class
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
		return 'catatanimplementasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, kelaspelayanan_id, tgl_evaluasi, create_time', 'required'),
			array('ruangan_id, diagnosa_id, kelaspelayanan_id, petugaspengisi_id, create_ruangan, pasien_id', 'numerical', 'integerOnly'=>true),
			array('kelompok_resiko', 'length', 'max'=>20),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('pelaksanaan, monitoring, fasilitas, advokasi, hasilpelayanan, terminasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catatanimplementasi_id, ruangan_id, diagnosa_id, kelaspelayanan_id, kelompok_resiko, tgl_evaluasi, pelaksanaan, monitoring, fasilitas, advokasi, hasilpelayanan, terminasi, petugaspengisi_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, pasien_id', 'safe', 'on'=>'search'),
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
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanimplementasi_id' => 'Catatanimplementasi',
			'ruangan_id' => 'Ruangan',
			'diagnosa_id' => 'Diagnosa',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelompok_resiko' => 'Kelompok Resiko',
			'tgl_evaluasi' => 'Tanggal Evaluasi',
			'pelaksanaan' => 'Pelaksanaan',
			'monitoring' => 'Monitoring',
			'fasilitas' => 'Fasilitas, Koordinasi, Komunikasi dan Kolaburasi',
			'advokasi' => 'Advokasi',
			'hasilpelayanan' => 'Hasil Pelayanan',
			'terminasi' => 'Terminasi',
			'petugaspengisi_id' => 'Petugaspengisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('catatanimplementasi_id',$this->catatanimplementasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelompok_resiko',$this->kelompok_resiko,true);
		$criteria->compare('tgl_evaluasi',$this->tgl_evaluasi,true);
		$criteria->compare('pelaksanaan',$this->pelaksanaan,true);
		$criteria->compare('monitoring',$this->monitoring,true);
		$criteria->compare('fasilitas',$this->fasilitas,true);
		$criteria->compare('advokasi',$this->advokasi,true);
		$criteria->compare('hasilpelayanan',$this->hasilpelayanan,true);
		$criteria->compare('terminasi',$this->terminasi,true);
		$criteria->compare('petugaspengisi_id',$this->petugaspengisi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
