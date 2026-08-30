<?php

/**
 * This is the model class for table "hasilpemeriksaanpa_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanpa_t':
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pemeriksaanlab_id
 * @property integer $pasienadmisi_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $nosediaanpa
 * @property string $tglperiksapa
 * @property string $makroskopis
 * @property string $mikroskopis
 * @property string $kesimpulanpa
 * @property string $saranpa
 * @property string $catatanpa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class HasilpemeriksaanpaT extends CActiveRecord
{


	public $kelaspelayanan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanpaT the static model class
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
		return 'hasilpemeriksaanpa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmasukpenunjang_id, pemeriksaanlab_id, pasien_id, pendaftaran_id, nosediaanpa, tglperiksapa', 'required'),
			array('pasienmasukpenunjang_id, pemeriksaanlab_id, pasienadmisi_id, tindakanpelayanan_id, pasien_id, pendaftaran_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nosediaanpa', 'length', 'max'=>50),
			array('makroskopis, mikroskopis, kesimpulanpa, saranpa, catatanpa, update_time, update_loginpemakai_id', 'safe'),
                        ['nama_pengambilhasil, alamat_pengambilhasil, notelp_pengambilhasil, hubungan_pengambilhasil, noidentitas_pengambilhasil, tgl_pengambilhasil, statusperiksahasil, verifikasi_ppds_id, tglverifikasi_ppds, verifikasi_dpjtm_id, tglverifikasi_dpjtm, statushasilpemeriksaan','safe'],
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			array('formathasilperiksa, statushasilperiksapa, organ_lokasi, diagnosaklinis, adekuasisediaan, kategoriumum, diagnosadeskriptif', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanpa_id, pasienmasukpenunjang_id, pemeriksaanlab_id, pasienadmisi_id, tindakanpelayanan_id, pasien_id, pendaftaran_id, nosediaanpa, tglperiksapa, makroskopis, mikroskopis, kesimpulanpa, saranpa, catatanpa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanlab'=>array(self::BELONGS_TO,'PemeriksaanlabM','pemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanpa_id' => 'Hasilpemeriksaanpa',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'nosediaanpa' => 'No. Sediaan PA',
			'tglperiksapa' => 'Tanggal Pemeriksaan',
			'makroskopis' => 'Makroskopis',
			'mikroskopis' => 'Mikroskopis',
			'kesimpulanpa' => 'Kesimpulan',
			'statushasilperiksapa' => 'Status Hasil',
			'saranpa' => 'Saran',
			'catatanpa' => 'Catatan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'organ_lokasi' => 'Organ/Lokasi',
			'diagnosaklinis' => 'Diagnosa/Keterangan Klinis',
			'adekuasisediaan' => 'Adekuasi Sediaan',
			'kategoriumum' => 'Kategori Umum',
			'diagnosadeskriptif' => 'Diagnosa Deskriptif',
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

		$criteria->compare('hasilpemeriksaanpa_id',$this->hasilpemeriksaanpa_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nosediaanpa)',strtolower($this->nosediaanpa),true);
		$criteria->compare('LOWER(tglperiksapa)',strtolower($this->tglperiksapa),true);
		$criteria->compare('LOWER(makroskopis)',strtolower($this->makroskopis),true);
		$criteria->compare('LOWER(mikroskopis)',strtolower($this->mikroskopis),true);
		$criteria->compare('LOWER(kesimpulanpa)',strtolower($this->kesimpulanpa),true);
		$criteria->compare('LOWER(saranpa)',strtolower($this->saranpa),true);
		$criteria->compare('LOWER(catatanpa)',strtolower($this->catatanpa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('hasilpemeriksaanpa_id',$this->hasilpemeriksaanpa_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nosediaanpa)',strtolower($this->nosediaanpa),true);
		$criteria->compare('LOWER(tglperiksapa)',strtolower($this->tglperiksapa),true);
		$criteria->compare('LOWER(makroskopis)',strtolower($this->makroskopis),true);
		$criteria->compare('LOWER(mikroskopis)',strtolower($this->mikroskopis),true);
		$criteria->compare('LOWER(kesimpulanpa)',strtolower($this->kesimpulanpa),true);
		$criteria->compare('LOWER(saranpa)',strtolower($this->saranpa),true);
		$criteria->compare('LOWER(catatanpa)',strtolower($this->catatanpa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

	public function getnamadepan()
    {
        return $this->pasien->namadepan;
    }

    public function getnama_pasien()
    {
        return $this->pasien->nama_pasien;
    }

    public function getumur()
    {
        return $this->pasien->CekUmurValid;
    }

    public function getjeniskelamin()
    {
        return $this->pasien->jeniskelamin;
    }

    public function getalamat_pasien()
    {
        return $this->pasien->alamat_pasien;
    }

    public function getprinthasillab()
    {
        return $this->printhasilpa;
    }
    
}