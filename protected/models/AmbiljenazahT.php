<?php

/**
 * This is the model class for table "ambiljenazah_t".
 *
 * The followings are the available columns in table 'ambiljenazah_t':
 * @property integer $ambiljenazah_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property string $tglpengambilan
 * @property string $tglmeninggal
 * @property string $nama_pengambiljenazah
 * @property string $hubungan_pengjenazah
 * @property string $noidentitas_pengjenazah
 * @property string $alamat_pengjenazah
 * @property string $notelepon_pengjenazah
 * @property string $keterangan_pengambilan
 * @property integer $ruanganmeninggal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class AmbiljenazahT extends CActiveRecord
{
        public $no_pendaftaran;
        public $no_rekam_medik;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AmbiljenazahT the static model class
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
		return 'ambiljenazah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, pendaftaran_id, tglpengambilan, tglmeninggal, nama_pengambiljenazah, hubungan_pengjenazah, alamat_pengjenazah, ruanganmeninggal_id', 'required'),
			array('pasien_id, ruangan_id, pendaftaran_id, ruanganmeninggal_id', 'numerical', 'integerOnly'=>true),
			array('nama_pengambiljenazah, noidentitas_pengjenazah', 'length', 'max'=>100),
			array('hubungan_pengjenazah, notelepon_pengjenazah', 'length', 'max'=>50),
			array('no_pendaftaran, no_rekam_medik, keterangan_pengambilan, update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ambiljenazah_id, pasien_id, ruangan_id, pendaftaran_id, tglpengambilan, tglmeninggal, nama_pengambiljenazah, hubungan_pengjenazah, noidentitas_pengjenazah, alamat_pengjenazah, notelepon_pengjenazah, keterangan_pengambilan, ruanganmeninggal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ambiljenazah_id' => 'Ambiljenazah',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'tglpengambilan' => 'Tanggal Pengambilan',
			'tglmeninggal' => 'Tanggal Meninggal',
			'nama_pengambiljenazah' => 'Nama Pengambil Jenazah',
			'hubungan_pengjenazah' => 'Hubungan Pengambil Jenazah',
			'noidentitas_pengjenazah' => 'No. Identitas Pengambil',
			'alamat_pengjenazah' => 'Alamat Pengambil',
			'notelepon_pengjenazah' => 'No. Telepon Pengambil',
			'keterangan_pengambilan' => 'Keterangan Pengambilan',
			'ruanganmeninggal_id' => 'Ruangan Meninggal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'no_pendaftaran' => 'No. Pendaftaran',
                        'no_rekam_medik' => 'No. Rekam Medik',
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

		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpengambilan)',strtolower($this->tglpengambilan),true);
		$criteria->compare('LOWER(tglmeninggal)',strtolower($this->tglmeninggal),true);
		$criteria->compare('LOWER(nama_pengambiljenazah)',strtolower($this->nama_pengambiljenazah),true);
		$criteria->compare('LOWER(hubungan_pengjenazah)',strtolower($this->hubungan_pengjenazah),true);
		$criteria->compare('LOWER(noidentitas_pengjenazah)',strtolower($this->noidentitas_pengjenazah),true);
		$criteria->compare('LOWER(alamat_pengjenazah)',strtolower($this->alamat_pengjenazah),true);
		$criteria->compare('LOWER(notelepon_pengjenazah)',strtolower($this->notelepon_pengjenazah),true);
		$criteria->compare('LOWER(keterangan_pengambilan)',strtolower($this->keterangan_pengambilan),true);
		$criteria->compare('ruanganmeninggal_id',$this->ruanganmeninggal_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglpengambilan)',strtolower($this->tglpengambilan),true);
		$criteria->compare('LOWER(tglmeninggal)',strtolower($this->tglmeninggal),true);
		$criteria->compare('LOWER(nama_pengambiljenazah)',strtolower($this->nama_pengambiljenazah),true);
		$criteria->compare('LOWER(hubungan_pengjenazah)',strtolower($this->hubungan_pengjenazah),true);
		$criteria->compare('LOWER(noidentitas_pengjenazah)',strtolower($this->noidentitas_pengjenazah),true);
		$criteria->compare('LOWER(alamat_pengjenazah)',strtolower($this->alamat_pengjenazah),true);
		$criteria->compare('LOWER(notelepon_pengjenazah)',strtolower($this->notelepon_pengjenazah),true);
		$criteria->compare('LOWER(keterangan_pengambilan)',strtolower($this->keterangan_pengambilan),true);
		$criteria->compare('ruanganmeninggal_id',$this->ruanganmeninggal_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}