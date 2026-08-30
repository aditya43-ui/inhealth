<?php

/**
 * This is the model class for table "infoimplementasiaskep_v".
 *
 * The followings are the available columns in table 'infoimplementasiaskep_v':
 * @property integer $implementasiaskep_id
 * @property string $no_implementasi
 * @property string $implementasiaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $rencanaaskep_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_rekam_medik
 * @property string $umur
 * @property string $statusperkawinan
 * @property string $jeniskelamin
 * @property string $pekerjaan_nama
 * @property string $pendidikan_nama
 * @property string $agama
 * @property string $alamat_pasien
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $diagnosa_nama
 * @property string $nama_pj
 * @property string $no_identitas
 * @property string $tgllahir_pj
 * @property string $no_teleponpj
 * @property string $no_mobilepj
 * @property string $hubungankeluarga
 * @property string $alamat_pj
 * @property string $jk
 */
class InfoimplementasiaskepV extends CActiveRecord
{
        public $pilih_id, $indikator, $indikator_id, $imp_id, $imp_nama;
        public $load_all = false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoimplementasiaskepV the static model class
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
		return 'infoimplementasiaskep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('implementasiaskep_id, rencanaaskep_id, ruangan_id, pasien_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('no_implementasi, no_pendaftaran, statusperkawinan, jeniskelamin, agama, jk', 'length', 'max'=>20),
			array('ruangan_nama, kelaspelayanan_nama, nama_pasien, nama_pegawai, pekerjaan_nama, pendidikan_nama, nama_pj, no_identitas, hubungankeluarga', 'length', 'max'=>50),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('umur', 'length', 'max'=>30),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('no_teleponpj, no_mobilepj', 'length', 'max'=>15),
			array('load_all, rencanaaskep_tgl, implementasiaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran, alamat_pasien, tgllahir_pj, alamat_pj', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('implementasiaskep_id, no_implementasi, implementasiaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rencanaaskep_id, ruangan_id, ruangan_nama, kelaspelayanan_nama, pasien_id, nama_pasien, pegawai_id, nama_pegawai, no_pendaftaran, tgl_pendaftaran, no_rekam_medik, umur, statusperkawinan, jeniskelamin, pekerjaan_nama, pendidikan_nama, agama, alamat_pasien, kamarruangan_nokamar, kamarruangan_nobed, diagnosa_nama, nama_pj, no_identitas, tgllahir_pj, no_teleponpj, no_mobilepj, hubungankeluarga, alamat_pj, jk', 'safe', 'on'=>'search'),
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
			'implementasiaskep_id' => 'Implementasiaskep',
			'no_implementasi' => 'No Implementasi',
			'implementasiaskep_tgl' => 'Implementasiaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'rencanaaskep_id' => 'Rencanaaskep',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'umur' => 'Umur',
			'statusperkawinan' => 'Statusperkawinan',
			'jeniskelamin' => 'Jenis Kelamin',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_nama' => 'Pendidikan Nama',
			'agama' => 'Agama',
			'alamat_pasien' => 'Alamat Pasien',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'diagnosa_nama' => 'Diagnosa Nama',
			'nama_pj' => 'Nama Pj',
			'no_identitas' => 'No Identitas',
			'tgllahir_pj' => 'Tgllahir Pj',
			'no_teleponpj' => 'No Teleponpj',
			'no_mobilepj' => 'No Mobilepj',
			'hubungankeluarga' => 'Hubungankeluarga',
			'alamat_pj' => 'Alamat Pj',
			'jk' => 'Jk',
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

		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('no_implementasi',$this->no_implementasi,true);
		$criteria->compare('implementasiaskep_tgl',$this->implementasiaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function search_riwayat_implementasi_by_rencana(){
            $cri = new CDbCriteria();
            $cri->select = "
                        pilih.pilihimplementasiaskep_id as pilih_id,
                        ind.indikatorimplkepdet_indikator as indikator,
                        ind.indikatorimplkepdet_id as indikator_id,
                        t.implementasiaskep_tgl,
                        imp_m.implementasikep_id as imp_id,
                        imp_m.jenistindakan as imp_nama,
                        t.nama_pegawai,
                        t.implementasiaskep_id
                    ";
            $cri->join = " 
                    JOIN implementasiaskepdet_t impdet ON impdet.implementasiaskep_id = t.implementasiaskep_id 
                    JOIN pilihimplementasiaskep_t pilih ON pilih.implementasiaskepdet_id = impdet.implementasiaskepdet_id 
                    JOIN indikatorimplkepdet_m ind ON ind.indikatorimplkepdet_id = pilih.indikatorimplkepdet_id 
                    JOIN implementasikep_m imp_m ON imp_m.implementasikep_id = ind.implementasikep_id 
            ";
            if (!empty($this->rencanaaskep_id)){
                $cri->addCondition(" t.rencanaaskep_id = ".$this->rencanaaskep_id);
            }else{
                $cri->addCondition(" t.implementasiaskep_id IS NULL ");
            }
            $cri->order = " t.implementasiaskep_tgl ASC ";
            $model = self::model()->findAll($cri);
            
            $data = [];
            foreach($model as $i => $det){
                $init = $det->implementasiaskep_id;
                $init2 = $det->pilih_id;
                $data[$init]['nourut'] = $i+1;
                $data[$init]['implementasiaskep_tgl'] = $det->implementasiaskep_tgl;
                $data[$init]['nama_pegawai'] = $det->nama_pegawai;
                if (!empty($det->pilih_id)){
                    if (!empty($det->imp_id)){
                        $data[$init]['det'][$init2]['imp'][$det->imp_id] = $det->imp_nama;
                    }
                    
                    if (!empty($det->indikator_id)){
                        $data[$init]['det'][$init2]['indikator'][$det->indikator_id] = $det->indikator;
                    }
                }
                
            }
            
            return new CArrayDataProvider($data, array(
                'keyField'=>'nourut',			
                'id'=>'data_laporan',
                'totalItemCount'=>count($data),
                'pagination' => array(
                    'pageSize' => ($this->load_all==true)?count($data):10,
                    'pageVar' => 'page'
                ),			
            ));   
        }
}