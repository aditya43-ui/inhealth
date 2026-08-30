<?php

/**
 * This is the model class for table "informasiloketantiran_v".
 *
 * The followings are the available columns in table 'informasiloketantiran_v':
 * @property string $loket_nama
 * @property string $loket_fungsi
 * @property integer $antrian_id
 * @property string $tglantrian
 * @property string $noantrian
 * @property string $statuspasien
 * @property boolean $panggil_flaq
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 */
class InformasiloketantrianV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiloketantrianV the static model class
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
		return 'informasiloketantiran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antrian_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('loket_nama, statuspasien', 'length', 'max'=>50),
			array('noantrian', 'length', 'max'=>6),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('loket_fungsi, tglantrian, panggil_flaq', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, loket_nama, loket_fungsi, antrian_id, tglantrian, noantrian, statuspasien, panggil_flaq, pendaftaran_id, no_pendaftaran', 'safe', 'on'=>'search'),
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
			'loket_nama' => 'Nama Loket',
			'loket_fungsi' => 'Fungsi Loket',
			'antrian_id' => 'Antrian',
			'tglantrian' => 'Tanggal Antrian',
			'noantrian' => 'No. antrian',
			'statuspasien' => 'Status pasien',
			'panggil_flaq' => 'Panggil Flaq',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
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

		$criteria->compare('LOWER(loket_nama)',strtolower($this->loket_nama),true);
		$criteria->compare('LOWER(loket_fungsi)',strtolower($this->loket_fungsi),true);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('LOWER(tglantrian)',strtolower($this->tglantrian),true);
		$criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(loket_nama)',strtolower($this->loket_nama),true);
		$criteria->compare('LOWER(loket_fungsi)',strtolower($this->loket_fungsi),true);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('LOWER(tglantrian)',strtolower($this->tglantrian),true);
		$criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
}