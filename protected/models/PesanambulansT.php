<?php

/**
 * This is the model class for table "pesanambulans_t".
 *
 * The followings are the available columns in table 'pesanambulans_t':
 * @property integer $pesanambulans_t
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $mobilambulans_id
 * @property integer $pemakaianambulans_id
 * @property integer $pasien_id
 * @property string $pesanambulans_no
 * @property string $tglpemesananambulans
 * @property string $norekammedis
 * @property string $namapasien
 * @property string $tempattujuan
 * @property string $kelurahan_nama
 * @property string $alamattujuan
 * @property string $rt_rw
 * @property string $nomobile
 * @property string $notelepon
 * @property string $tglpemakaianambulans
 * @property string $untukkeperluan
 * @property string $keteranganpesan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PesanambulansT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $ruangan_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanambulansT the static model class
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
		return 'pesanambulans_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pesanambulans_no, tglpemesananambulans, namapasien', 'required'),
			array('ruangan_id, pendaftaran_id, mobilambulans_id, pemakaianambulans_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('pesanambulans_no, rt_rw', 'length', 'max'=>20),
			array('norekammedis', 'length', 'max'=>10),
			array('namapasien, nomobile, notelepon', 'length', 'max'=>100),
			array('tempattujuan, kelurahan_nama', 'length', 'max'=>50),
			array('ruangan_nama, alamattujuan, tglpemakaianambulans, untukkeperluan, keteranganpesan, update_time, update_loginpemakai_id', 'safe'),
			
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanambulans_t, ruangan_id, pendaftaran_id, mobilambulans_id, pemakaianambulans_id, pasien_id, pesanambulans_no, tglpemesananambulans, norekammedis, namapasien, tempattujuan, kelurahan_nama, alamattujuan, rt_rw, nomobile, notelepon, tglpemakaianambulans, untukkeperluan, keteranganpesan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
			'mobilambulans'=>array(self::BELONGS_TO,'MobilambulansM','mobilambulans_id'),
			'ruanganpemesan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'ruanganUserPemesan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
			'userpemesan'=>array(self::BELONGS_TO, 'LoginpemakaiK','create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanambulans_t' => 'ID Pesan Ambulans',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'mobilambulans_id' => 'Mobil Ambulans',
			'pemakaianambulans_id' => 'Pemakaian Ambulans',
			'pasien_id' => 'Pasien',
			'pesanambulans_no' => 'No. Pesan Ambulans',
			'tglpemesananambulans' => 'Tanggal Pemesanan Ambulans',
			'norekammedis' => 'No. Rekam Medik',
			'namapasien' => 'Nama Pasien',
			'tempattujuan' => 'Tempat Tujuan',
			'kelurahan_nama' => 'Nama Kelurahan',
			'alamattujuan' => 'Alamat Tujuan',
			'rt_rw' => 'RT / RW',
                        'rt' => 'RT / RW',
			'nomobile' => 'No. Handphone',
			'notelepon' => 'Notelepon',
			'tglpemakaianambulans' => 'Tanggal Pemakaian Ambulans',
			'untukkeperluan' => 'Untuk Keperluan',
			'keteranganpesan' => 'Keterangan Pesan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		$criteria->compare('LOWER(tglpemesananambulans)',strtolower($this->tglpemesananambulans),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);
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
		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		$criteria->compare('LOWER(tglpemesananambulans)',strtolower($this->tglpemesananambulans),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);
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
        
        public function getNamaPasien()
        {
            $nama = PasienM::model()->findByPk($this->pasien_id);
            
            return $nama->namadepan.' '.$nama->nama_pasien;
        }
}