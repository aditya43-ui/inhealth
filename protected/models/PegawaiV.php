<?php

/**
 * This is the model class for table "pegawai_v".
 *
 * The followings are the available columns in table 'pegawai_v':
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
class PegawaiV extends CActiveRecord
{
	public $namaunitkerja;
	public $statusperkawinan;
	public $kategoripegawai;
	public $jabatan_nama;
	public $tglditerima;
    
    public $jenisjasa;
    public $ruangan_id;
    public $pendidik_jabatan;
    public $golonganpegawai_nama;
    public $default, $lokasi_id;
    public $is_peg_internalaset, $is_peg_pjasset, $is_peg_teknisipeliharaaset, $pegawaisemua_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiV the static model class
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
		return 'pegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pendidikan_nama, pendkualifikasi_nama', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, agama', 'length', 'max'=>20),
			array('tempatlahir_pegawai, nomorindukpegawai', 'length', 'max'=>30),
			array('golongandarah', 'length', 'max'=>2),
			array('alamatemail', 'length', 'max'=>100),
			array('photopegawai', 'length', 'max'=>200),
			array('tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, jenisjasa, unitkerja_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, unitkerja_id, '
                . 'jenisjasa, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, '
                . 'pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, '
                . 'photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, '
                . 'nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id, jabatan_nama', 'safe', 'on'=>'search'),
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
			'jabatan'=>array(self::BELONGS_TO, 'JabatanM', 'jabatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'jeniskelamin' => 'Jenis Kelamin',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempat Lahir',
			'tgl_lahirpegawai' => 'Tanggal Lahir',
			'alamat_pegawai' => 'Alamat Pegawai',
			'pegawai_aktif' => 'Pegawai Aktif',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'alamatemail' => 'E-mail',
			'notelp_pegawai' => 'No. Telepon',
			'nomobile_pegawai' => 'No. Hp',
			'photopegawai' => 'Photo',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Kategori Pegawai',
			'pendkualifikasi_id' => 'Pendidikan Kualifikasi',
			'pendkualifikasi_nama' => 'Pendidikan Kualifikasi',
			'nomorindukpegawai' => 'Nomor Induk Pegawai (NIP)',
			'pangkat_id' => 'Pangkat',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'jabatan_id' => 'Jabatan',
			'unitkerja_id' => 'Unit Kerja',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
        //$criteria->compare('jabatan_id', $this->jabatan_id);
		
		
        $criteria->compare('unitkerja_id', $this->unitkerja_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		
		if (!empty($this->kelompokpegawai_id)){
			if (is_array($this->kelompokpegawai_id)){
				$criteria->addInCondition('kelompokpegawai_id',$this->kelompokpegawai_id);
			}else{
				$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
			}
		}
		
		if (!empty($this->jabatan_id)){
			if (is_array($this->jabatan_id)){
				$criteria->addInCondition('jabatan_id',$this->jabatan_id);
			}else{
				$criteria->compare("jabatan_id", $this->jabatan_id);
			}
		}	
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);	
		$criteria->order = " nama_pegawai ASC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    public function searchPegawaiJasaSopir() {
        // Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
        // $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('unitkerja_id', $this->unitkerja_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		
		if (!empty($this->kelompokpegawai_id)){
			if (is_array($this->kelompokpegawai_id)){
				$criteria->addInCondition('kelompokpegawai_id',$this->kelompokpegawai_id);
			}else{
				$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
			}
		}
        
        $jabatan = array(Params::JABATAN_ID_DRIVER, Params::JABATAN_ID_SECURITY);
        $pegawai_plus = array(33, 69);
        
		
		$criteria->addCondition("jabatan_id in (".join(",", $jabatan).") or pegawai_id in (".join(",", $pegawai_plus).")");
		$criteria->order = " nama_pegawai ASC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function getNamaLengkap()
        {
            return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_pegawai.(isset($this->gelarbelakang_nama) ? ', '.$this->gelarbelakang_nama : "");
        }
        
        public function searchByDokterPerawat() {
            $prov = $this->search();
            $prov->criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN));
            $prov->criteria->addCondition('pegawai_aktif = true');
            
            $prov->sort->defaultOrder = 'nama_pegawai';
            return $prov;
        }
        
        public function searchByDokterPerawatNon() {
            $prov = $this->search();
            //$prov->criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN));
            $prov->criteria->addCondition('pegawai_aktif = true');
            
            $prov->sort->defaultOrder = 'nama_pegawai';
            return $prov;
        }
        
        public function searchByPerawat() {
            $prov = $this->search();
            $prov->criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN));
            $prov->criteria->addCondition('pegawai_aktif = true');
            
            $prov->sort->defaultOrder = 'nama_pegawai';
            return $prov;
        }
        
        public function searchPegawaiRuangan() {
            $prov = $this->search();
            
            // $prov->criteria->addNotInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK));
            $prov->sort->defaultOrder = 'nama_pegawai';
            
            return $prov;
        }
        
        public function searchNonDokter() {
            $prov = $this->search();
            
            $prov->criteria->addNotInCondition('unitkerja_id', array(Params::UNITKERJA_ID_DOKTER));
            $prov->sort->defaultOrder = 'nama_pegawai';
            
            return $prov;
        }
        
        public function searchDokter() {
            $prov = $this->search();
            $prov->criteria->compare('unitkerja_id', Params::UNITKERJA_ID_DOKTER);
            
            return $prov;
        }
        
        public function searchPerawat() {
            $prov = $this->search();
            $prov->criteria->compare('kelompokpegawai_id', Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
            
            return $prov;
        }
        
        public function searchDokterDPJP() {
            $prov = $this->searchDokter();
            $prov->criteria->addNotInCondition('jabatan_id', array(Params::JABATAN_ID_DOKTER_UMUM));
            
            return $prov;
        }
        
        public function searchDokterUmum() {
            $prov = $this->searchDokter();
            $prov->criteria->addInCondition('jabatan_id', array(Params::JABATAN_ID_DOKTER_UMUM, Params::JABATAN_ID_DOKTER_SPESIALIS));
            return $prov;
        }

        public function searchDokterSpesialis() {
            $prov = $this->searchDokter();
            $prov->criteria->addInCondition('jabatan_id', array(Params::JABATAN_ID_DOKTER_SPESIALIS));
            $prov->criteria->addNotInCondition('gelarbelakang_id', array(281));
            return $prov;
        }
		
		public function getNoKeputusan(){
			$modPegJab = PegawaijabatanR::model()->findByAttributes (array('pegawai_id'=>$this->pegawai_id), array('order'=>'tglditetapkanjabatan DESC'));
			$nomorkeputusan = isset($modPegJab->nomorkeputusanjabatan) ? $modPegJab->nomorkeputusanjabatan : "";
			return $nomorkeputusan; 
		}
        
        public function getPerawatItems() {
            return CHtml::listData(self::model()->findAllByAttributes(array(
                'pegawai_aktif' => 'true',
                'kelompokpegawai_id' => array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN)
            ), array(
                'order'=>'nama_pegawai'
            )), 'pegawai_id', 'namaLengkap');
        }
        
        public function getPegawaiJabatanItems($jabatan_id) {
            return CHtml::listData(self::model()->findAllByAttributes(array(
                'pegawai_aktif' => 'true',
                'jabatan_id' => $jabatan_id,
            ), array(
                'order'=>'nama_pegawai'
            )), 'pegawai_id', 'namaLengkap');
        }
        
        /**
     * digunakan untuk search ppjp
     * @return type object digunakan untuk mengembalikan criteria yang dimaksud
     */
    public function searchPPJP() {
        $prov = $this->search();
        $prov->criteria->compare('kelompokpegawai_id', Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
        if (!empty($this->ruangan_id)) {
            $prov->criteria->join = "JOIN ruanganpegawai_m on ruanganpegawai_m.pegawai_id=t.pegawai_id";
            $prov->criteria->addCondition("ruangan_id= " . $this->ruangan_id);
        }

        return $prov;
    }
    
    /**
     * fungsi yang digunakan untuk memfilter data pegawai, yang ditampilkan pada filter ini berlaku untuk semua pegawai
     * @return \CActiveDataProvider
     */
    public function searchAllPegawai() {
        $cri = new CDbCriteria();
        $cri->select = " t.*, j.jabatan_nama, u.namaunitkerja ";
        $cri->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                . " LEFT JOIN unitkerja_m u ON u.unitkerja_Id = t.unitkerja_id ";
        if (!empty($this->jabatan_id)) {
            $cri->addCondition(" t.jabatan_id = '" . $this->jabatan_id . "' ");
        }

        if (!empty($this->unitkerja_id)) {
            $cri->addCondition(" t.unitkerja_id = '" . $this->unitkerja_id . "' ");
        }

        if (!empty($this->default)) {
            $cri->addCondition(" t.pegawai_id is null ");
        }
        
        if ($this->is_peg_teknisipeliharaaset) {
            $cri->addCondition(" t.pegawai_id IN (select tek.pegawai_id from teknisipemeliharaanaset_t tek JOIN korektifmainten_t kor ON kor.korektifmainten_id = tek.korektifmainten_id GROUP BY tek.pegawai_id) ");
        }

        if ($this->is_peg_internalaset) {
            $cri->addCondition(" t.unitkerja_id IN (select lookup_value::int from lookup_m where lookup_type = 'teknisicm' AND lookup_aktif = TRUE group by lookup_value::int) ");
        }
        
        if ($this->is_peg_pjasset) {
            
            $cond = '';
            if (!empty($this->lokasi_id)){
                $cond .= " AND lokasi_id = ".$this->lokasi_id;
            }
            
            $cri->addCondition(" t.pegawai_id IN (select pegawai_id from penanggungjawabaset_m where penanggungjawabaset_aktif = TRUE ".$cond." group by pegawai_id) ");
            
        }

        $cri->addCondition('pegawai_aktif = true');

        $cri->compare("LOWER(t.nama_pegawai)", strtolower($this->nama_pegawai), true);
        $cri->compare("LOWER(t.nomorindukpegawai)", strtolower($this->nomorindukpegawai), true);
        $cri->compare("LOWER(u.namaunitkerja)", strtolower($this->namaunitkerja), true);
        $cri->compare("LOWER(j.jabatan_nama)", strtolower($this->jabatan_nama), true);

				if (!empty($this->pegawaisemua_id)) {
					if(is_array($this->pegawaisemua_id)){
						$cri->addInCondition(" t.pegawai_id",$this->pegawaisemua_id);
					}else{
						$cri->addCondition(" t.pegawai_id =".$this->pegawaisemua_id);
					}
				}

        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
            'sort' => array('defaultOrder' => 'nama_pegawai'),
        ));
    }
        
}