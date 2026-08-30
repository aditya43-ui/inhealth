<?php

/**
 * This is the model class for table "dokterspesialis_v".
 *
 * The followings are the available columns in table 'dokterspesialis_v':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $alamat_pegawai
 * @property boolean $pegawai_aktif
 * @property string $agama
 * @property string $golongandarah
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $photopegawai
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_nama
 * @property string $nomorindukpegawai
 * @property integer $pangkat_id
 * @property integer $kelompokpegawai_id
 * @property integer $jabatan_id
 */
class DokterspesialisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokterspesialisV the static model class
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
		return 'dokterspesialis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id, pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pendidikan_nama, pendkualifikasi_nama', 'length', 'max'=>50),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, agama', 'length', 'max'=>20),
			array('tempatlahir_pegawai, nomorindukpegawai', 'length', 'max'=>30),
			array('golongandarah', 'length', 'max'=>2),
			array('alamatemail', 'length', 'max'=>100),
			array('photopegawai', 'length', 'max'=>200),
			array('tgl_lahirpegawai, alamat_pegawai, pegawai_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, ruangan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id', 'safe', 'on'=>'search'),
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
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jeniskelamin' => 'Jenis Kelamin',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'alamat_pegawai' => 'Alamat Pegawai',
			'pegawai_aktif' => 'Pegawai Aktif',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'alamatemail' => 'Alamatemail',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'photopegawai' => 'Photopegawai',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Pendidikan Nama',
			'pendkualifikasi_id' => 'Pendkualifikasi',
			'pendkualifikasi_nama' => 'Pendkualifikasi Nama',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'pangkat_id' => 'Pangkat',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'jabatan_id' => 'Jabatan',
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

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('lower(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('nama_keluarga',$this->nama_keluarga,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('notelp_pegawai',$this->notelp_pegawai,true);
		$criteria->compare('nomobile_pegawai',$this->nomobile_pegawai,true);
		$criteria->compare('photopegawai',$this->photopegawai,true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('pendkualifikasi_nama',$this->pendkualifikasi_nama,true);
		$criteria->compare('lower(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchDokterSpesialis() {
        $prov = $this->search();
        $prov->criteria->group = $prov->criteria->select = 'pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_nama, jabatan_id';
        $prov->sort->defaultOrder = 'nama_pegawai';
        
        return $prov;
    }
    
    public function getNamaLengkap()
    {
        return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_pegawai.(isset($this->gelarbelakang_nama) ? ', '.$this->gelarbelakang_nama : "");
    }
    
    public function getJenisBuktiPotong() {
        $peg = PegawaiM::model()->findByPk($this->pegawai_id);
        if ($peg->kode_objekpajak == "21-100-07") {
            return "21 Final";
        }
        
        return "21";
    }
    
    public function getAlamatJson() {
        return str_replace("\n", " ", str_replace("\r", " ", $this->alamat_pegawai));
    }
}