<?php

/**
 * This is the model class for table "informasipersiapanpengadaan_v".
 * @author Elham Budianto <elhambudianto@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'informasipersiapanpengadaan_v':
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaan_tanggal
 * @property string $persiapanpengadaan_nomor
 * @property string $kode_rup
 * @property integer $rencanaumumpengadaan_id
 * @property string $rencanaumumpengadaan_nomor
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $periodeanggaran_id
 * @property string $tahunanggaran
 * @property string $anggaran_nama
 * @property string $rencanaumumpengadaan_tahun
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $daftarjenispengadaan
 * @property string $daftarsumberdana
 * @property string $nama_pekerjaan
 * @property string $volume_pekerjaan
 * @property string $uraian_pekerjaan
 * @property string $rencanaumumpengadaan_kategori
 * @property string $metodepengadaan_nama
 * @property double $persiapanpengadaan_pagu
 * @property string $pemanfaatanbarang_tglawal
 * @property string $pemanfaatanbarang_tglakhir
 * @property string $pelaksanaankontrak_tglawal
 * @property string $pelaksanaankontrak_tglakhir
 * @property string $pemilihanpenyedia_tglawal
 * @property string $pemilihanpenyedia_tglakhir
 * @property string $swakelola_tipe
 * @property string $persiapanpengadaan_status
 * @property boolean $isumumkanpengadaan
 * @property string $diumumkan_tanggal
 * @property integer $pegawaippk_id
 * @property string $peg_ppk
 * @property integer $pegawaipa_id
 * @property string $peg_pa
 * @property integer $pegawaikpa_id
 * @property string $peg_kpa
 */
class InformasipersiapanpengadaanV extends CActiveRecord
{   
    public $pegawaipembuat_id, $namaunitkerja, $unitkerja_id, $namaLengkap;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipersiapanpengadaanV the static model class
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
        return 'informasipersiapanpengadaan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('persiapanpengadaan_id, rencanaumumpengadaan_id, instalasi_id, periodeanggaran_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, pegawaippk_id, pegawaipa_id, pegawaikpa_id', 'numerical', 'integerOnly'=>true),
            array('dpa_pagu', 'numerical'),
            array('persiapanpengadaan_nomor, rencanaumumpengadaan_nomor, rencanaumumpengadaan_kategori', 'length', 'max'=>20),
            array('kode_rup, instalasi_nama, peg_ppk, peg_pa, peg_kpa', 'length', 'max'=>50),
            array('tahunanggaran, rencanaumumpengadaan_tahun', 'length', 'max'=>4),
            array('anggaran_nama, volume_pekerjaan, metodepengadaan_nama, swakelola_tipe, persiapanpengadaan_status', 'length', 'max'=>100),
            array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode', 'length', 'max'=>5),
            array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>500),
            array('nama_pekerjaan', 'length', 'max'=>300),
            array('uraian_pekerjaan', 'length', 'max'=>2000),
            array('persiapanpengadaan_tanggal, daftarjenispengadaan, daftarsumberdana, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, isumumkanpengadaan, diumumkan_tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('persiapanpengadaan_id, persiapanpengadaan_tanggal, persiapanpengadaan_nomor, kode_rup, rencanaumumpengadaan_id, rencanaumumpengadaan_nomor, instalasi_id, instalasi_nama, periodeanggaran_id, tahunanggaran, anggaran_nama, rencanaumumpengadaan_tahun, programkerja_id, programkerja_kode, programkerja_nama, subprogramkerja_id, subprogramkerja_kode, subprogramkerja_nama, kegiatanprogram_id, kegiatanprogram_kode, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama, daftarjenispengadaan, daftarsumberdana, nama_pekerjaan, volume_pekerjaan, uraian_pekerjaan, rencanaumumpengadaan_kategori, metodepengadaan_nama, dpa_pagu, pemanfaatanbarang_tglawal, pemanfaatanbarang_tglakhir, pelaksanaankontrak_tglawal, pelaksanaankontrak_tglakhir, pemilihanpenyedia_tglawal, pemilihanpenyedia_tglakhir, swakelola_tipe, persiapanpengadaan_status, isumumkanpengadaan, diumumkan_tanggal, pegawaippk_id, peg_ppk, pegawaipa_id, peg_pa, pegawaikpa_id, peg_kpa', 'safe', 'on'=>'search'),
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
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'persiapanpengadaan_tanggal' => 'Persiapanpengadaan Tanggal',
            'persiapanpengadaan_nomor' => 'Persiapanpengadaan Nomor',
            'kode_rup' => 'Kode Rup',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'rencanaumumpengadaan_nomor' => 'Rencanaumumpengadaan Nomor',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'periodeanggaran_id' => 'Periodeanggaran',
            'tahunanggaran' => 'Tahunanggaran',
            'anggaran_nama' => 'Anggaran Nama',
            'rencanaumumpengadaan_tahun' => 'Rencanaumumpengadaan Tahun',
            'programkerja_id' => 'Programkerja',
            'programkerja_kode' => 'Programkerja Kode',
            'programkerja_nama' => 'Programkerja Nama',
            'subprogramkerja_id' => 'Subprogramkerja',
            'subprogramkerja_kode' => 'Subprogramkerja Kode',
            'subprogramkerja_nama' => 'Subprogramkerja Nama',
            'kegiatanprogram_id' => 'Kegiatanprogram',
            'kegiatanprogram_kode' => 'Kegiatanprogram Kode',
            'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
            'subkegiatanprogram_id' => 'Subkegiatanprogram',
            'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
            'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
            'daftarjenispengadaan' => 'Daftarjenispengadaan',
            'daftarsumberdana' => 'Daftarsumberdana',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'volume_pekerjaan' => 'Volume Pekerjaan',
            'uraian_pekerjaan' => 'Uraian Pekerjaan',
            'rencanaumumpengadaan_kategori' => 'Rencanaumumpengadaan Kategori',
            'metodepengadaan_nama' => 'Metodepengadaan Nama',
            'dpa_pagu' => 'Persiapanpengadaan Pagu',
            'pemanfaatanbarang_tglawal' => 'Pemanfaatanbarang Tglawal',
            'pemanfaatanbarang_tglakhir' => 'Pemanfaatanbarang Tglakhir',
            'pelaksanaankontrak_tglawal' => 'Pelaksanaankontrak Tglawal',
            'pelaksanaankontrak_tglakhir' => 'Pelaksanaankontrak Tglakhir',
            'pemilihanpenyedia_tglawal' => 'Pemilihanpenyedia Tglawal',
            'pemilihanpenyedia_tglakhir' => 'Pemilihanpenyedia Tglakhir',
            'swakelola_tipe' => 'Swakelola Tipe',
            'persiapanpengadaan_status' => 'Persiapanpengadaan Status',
            'isumumkanpengadaan' => 'Isumumkanpengadaan',
            'diumumkan_tanggal' => 'Diumumkan Tanggal',
            'pegawaippk_id' => 'Pegawaippk',
            'peg_ppk' => 'Peg Ppk',
            'pegawaipa_id' => 'Pegawaipa',
            'peg_pa' => 'Peg Pa',
            'pegawaikpa_id' => 'Pegawaikpa',
            'peg_kpa' => 'Peg Kpa',
        );
    }

    /**
     * Load data yang dicari 
     * @return \CDbCriteria
     */
    public function criteriaSearch(){
        $criteria = new CDbCriteria;
        $criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
        $criteria->compare('persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
        $criteria->compare('LOWER(persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
        $criteria->compare('kode_rup',$this->kode_rup,true);
        $criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
        $criteria->compare('rencanaumumpengadaan_nomor',$this->rencanaumumpengadaan_nomor,true);
        $criteria->compare('instalasi_id',$this->instalasi_id);
        $criteria->compare('instalasi_nama',$this->instalasi_nama,true);
        $criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
        $criteria->compare('tahunanggaran',$this->tahunanggaran,true);
        $criteria->compare('anggaran_nama',$this->anggaran_nama,true);
        $criteria->compare('rencanaumumpengadaan_tahun',$this->rencanaumumpengadaan_tahun,true);
        $criteria->compare('programkerja_id',$this->programkerja_id);
        $criteria->compare('programkerja_kode',$this->programkerja_kode,true);
        $criteria->compare('subprogramkerja_id',$this->subprogramkerja_id);
        $criteria->compare('subprogramkerja_kode',$this->subprogramkerja_kode,true);
        $criteria->compare('subprogramkerja_nama',$this->subprogramkerja_nama,true);
        $criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
        $criteria->compare('kegiatanprogram_kode',$this->kegiatanprogram_kode,true);
        $criteria->compare('kegiatanprogram_nama',$this->kegiatanprogram_nama,true);
        $criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
        $criteria->compare('subkegiatanprogram_kode',$this->subkegiatanprogram_kode,true);
        $criteria->compare('subkegiatanprogram_nama',$this->subkegiatanprogram_nama,true);
        $criteria->compare('daftarjenispengadaan',$this->daftarjenispengadaan,true);
        $criteria->compare('daftarsumberdana',$this->daftarsumberdana,true);
        $criteria->compare('nama_pekerjaan',$this->nama_pekerjaan,true);
        $criteria->compare('volume_pekerjaan',$this->volume_pekerjaan,true);
        $criteria->compare('uraian_pekerjaan',$this->uraian_pekerjaan,true);
        $criteria->compare('rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
        $criteria->compare('metodepengadaan_nama',$this->metodepengadaan_nama,true);
        $criteria->compare('dpa_pagu',$this->dpa_pagu);
        $criteria->compare('pemanfaatanbarang_tglawal',$this->pemanfaatanbarang_tglawal,true);
        $criteria->compare('pemanfaatanbarang_tglakhir',$this->pemanfaatanbarang_tglakhir,true);
        $criteria->compare('pelaksanaankontrak_tglawal',$this->pelaksanaankontrak_tglawal,true);
        $criteria->compare('pelaksanaankontrak_tglakhir',$this->pelaksanaankontrak_tglakhir,true);
        $criteria->compare('pemilihanpenyedia_tglawal',$this->pemilihanpenyedia_tglawal,true);
        $criteria->compare('pemilihanpenyedia_tglakhir',$this->pemilihanpenyedia_tglakhir,true);
        $criteria->compare('swakelola_tipe',$this->swakelola_tipe,true);
        $criteria->compare('persiapanpengadaan_status',$this->persiapanpengadaan_status,true);
        $criteria->compare('isumumkanpengadaan',$this->isumumkanpengadaan);
        $criteria->compare('diumumkan_tanggal',$this->diumumkan_tanggal,true);
        $criteria->compare('pegawaippk_id',$this->pegawaippk_id);
        $criteria->compare('peg_ppk',$this->peg_ppk,true);
        $criteria->compare('pegawaipa_id',$this->pegawaipa_id);
        $criteria->compare('peg_pa',$this->peg_pa,true);
        $criteria->compare('pegawaikpa_id',$this->pegawaikpa_id);
        $criteria->compare('peg_kpa',$this->peg_kpa,true);
        return $criteria;
    }
    
    /**
     * Load data yang dicari 
     * @return \CDbCriteria
     */
    public function infoSearch(){
        $criteria = new CDbCriteria;
        $criteria->select = " t.*, uk.unitkerja_id, uk.namaunitkerja, t.rencanaumumpengadaan_id ";
        $criteria->join = " LEFT JOIN rencanaumumpengadaan_t rup ON rup.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id 
                            LEFT JOIN unitkerja_m uk ON uk.unitkerja_id = rup.unitkerja_id ";
        $criteria->compare('t.persiapanpengadaan_id',$this->persiapanpengadaan_id);
        $criteria->compare('t.persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(t.programkerja_nama)',strtolower($this->programkerja_nama),true);
        $criteria->compare('LOWER(uk.namaunitkerja)',strtolower($this->namaunitkerja),true);
        $criteria->compare('uk.unitkerja_id',$this->unitkerja_id,true);
        $criteria->compare('t.kode_rup',$this->kode_rup,true);
        $criteria->compare('t.rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
        $criteria->compare('t.rencanaumumpengadaan_nomor',$this->rencanaumumpengadaan_nomor,true);
        $criteria->compare('t.instalasi_id',$this->instalasi_id);
        $criteria->compare('t.instalasi_nama',$this->instalasi_nama,true);
        $criteria->compare('t.periodeanggaran_id',$this->periodeanggaran_id);
        $criteria->compare('t.tahunanggaran',$this->tahunanggaran,true);
        $criteria->compare('t.anggaran_nama',$this->anggaran_nama,true);
        $criteria->compare('t.rencanaumumpengadaan_tahun',$this->rencanaumumpengadaan_tahun,true);
        $criteria->compare('t.programkerja_id',$this->programkerja_id);
        $criteria->compare('t.programkerja_kode',$this->programkerja_kode,true);
        $criteria->compare('t.subprogramkerja_id',$this->subprogramkerja_id);
        $criteria->compare('t.subprogramkerja_kode',$this->subprogramkerja_kode,true);
        $criteria->compare('t.subprogramkerja_nama',$this->subprogramkerja_nama,true);
        $criteria->compare('t.kegiatanprogram_id',$this->kegiatanprogram_id);
        $criteria->compare('t.kegiatanprogram_kode',$this->kegiatanprogram_kode,true);
        $criteria->compare('t.kegiatanprogram_nama',$this->kegiatanprogram_nama,true);
        $criteria->compare('t.subkegiatanprogram_id',$this->subkegiatanprogram_id);
        $criteria->compare('t.subkegiatanprogram_kode',$this->subkegiatanprogram_kode,true);
        $criteria->compare('t.subkegiatanprogram_nama',$this->subkegiatanprogram_nama,true);
        $criteria->compare('t.daftarjenispengadaan',$this->daftarjenispengadaan,true);
        $criteria->compare('t.daftarsumberdana',$this->daftarsumberdana,true);
        $criteria->compare('t.nama_pekerjaan',$this->nama_pekerjaan,true);
        $criteria->compare('t.volume_pekerjaan',$this->volume_pekerjaan,true);
        $criteria->compare('t.uraian_pekerjaan',$this->uraian_pekerjaan,true);
        $criteria->compare('t.rencanaumumpengadaan_kategori',$this->rencanaumumpengadaan_kategori,true);
        $criteria->compare('t.metodepengadaan_nama',$this->metodepengadaan_nama,true);
        $criteria->compare('t.dpa_pagu',$this->dpa_pagu);
        $criteria->compare('t.pemanfaatanbarang_tglawal',$this->pemanfaatanbarang_tglawal,true);
        $criteria->compare('t.pemanfaatanbarang_tglakhir',$this->pemanfaatanbarang_tglakhir,true);
        $criteria->compare('t.pelaksanaankontrak_tglawal',$this->pelaksanaankontrak_tglawal,true);
        $criteria->compare('t.pelaksanaankontrak_tglakhir',$this->pelaksanaankontrak_tglakhir,true);
        $criteria->compare('t.pemilihanpenyedia_tglawal',$this->pemilihanpenyedia_tglawal,true);
        $criteria->compare('t.pemilihanpenyedia_tglakhir',$this->pemilihanpenyedia_tglakhir,true);
        $criteria->compare('t.swakelola_tipe',$this->swakelola_tipe,true);
        $criteria->compare('t.persiapanpengadaan_status',$this->persiapanpengadaan_status,true);
        $criteria->compare('t.isumumkanpengadaan',$this->isumumkanpengadaan);
        $criteria->compare('t.diumumkan_tanggal',$this->diumumkan_tanggal,true);
        $criteria->compare('t.pegawaippk_id',$this->pegawaippk_id);
        $criteria->compare('t.peg_ppk',$this->peg_ppk,true);
        $criteria->compare('t.pegawaipa_id',$this->pegawaipa_id);
        $criteria->compare('t.peg_pa',$this->peg_pa,true);
        $criteria->compare('t.pegawaikpa_id',$this->pegawaikpa_id);
        $criteria->compare('t.peg_kpa',$this->peg_kpa,true);
        return $criteria;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Pencarian Informasi Pengadaan Bagi Penyedia
     * @return \CActiveDataProvider
     */
    public function searchInformasiPengadaanPenyedia(){
        $criteria = $this->criteriaSearch();
        $criteria->addBetweenCondition('DATE(t.diumumkan_tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition(" t.persiapanpengadaan_status = '".Params::VERIFIKASI_DISETUJUI."'");
        $criteria->addCondition("t.isumumkanpengadaan IS TRUE");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Pencarian data untuk dialog surat perjanjian kerja
     * @return \CActiveDataProvider
     */
    public function searchSuratPerjanjianKerja(){
        
        $unit = UnitkerjaM::model()->findByPk(Params::UNITKERJA_ID_PENGADAAN_DAN_JASA);        
        $peg_kepala_unit = !empty($unit)?$unit->kepalaunitpeg_id:'tidak-ada';
        
        $criteria = new CDbCriteria();
        $criteria->join = " JOIN rencanaumumpengadaan_t rup ON rup.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id "
                        . " JOIN unitkerja_m on rup.unitkerja_id = unitkerja_m.unitkerja_id "
                        . " left join infoumumpengadaan_t info on t.persiapanpengadaan_id = info.persiapanpengadaan_id ";
        $criteria->select = " t.*, rup.unitkerja_id, unitkerja_m.namaunitkerja, t.rencanaumumpengadaan_id ";
        $criteria->compare('t.persiapanpengadaan_id',$this->persiapanpengadaan_id);
        $criteria->compare('t.persiapanpengadaan_tanggal',$this->persiapanpengadaan_tanggal,true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(t.programkerja_nama)',strtolower($this->programkerja_nama),true);
        $criteria->compare('LOWER(unitkerja_m.namaunitkerja)',strtolower($this->namaunitkerja),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        
        
        if ($peg_kepala_unit != Yii::app()->user->getState('pegawai_id')){        
            $cri = new CDbCriteria();
            $cri->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
            $cri->addCondition('pejabatpengadaan_aktif is true');
            $cri->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PPK."'");
            $modPPK = PejabatpengadaanM::model()->find($cri); 

            $cri2 = new CDbCriteria();
            $cri2->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
            $cri2->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PEJABAT_PENGADAAN."'");
            $cri2->addCondition('pejabatpengadaan_aktif is true');
            $modPejabat = PejabatpengadaanM::model()->find($cri2); 
            if (!empty($modPPK)) {
                $criteria->addCondition('t.pegawaippk_id = '.Yii::app()->user->getState('pegawai_id'));
            } else if (!empty($modPejabat)) {
                $criteria->addCondition('info.pegpengadaan_id = '.Yii::app()->user->getState('pegawai_id'));
            } else {

            }
        }
        
        $criteria->addCondition("upper(t.rencanaumumpengadaan_kategori) = '".Params::KATEGORI_PENGADAAN_PENYEDIA."'");
        $criteria->addCondition(" t.persiapanpengadaan_status = '".Params::VERIFIKASI_DISETUJUI."'");
        $criteria->order = "t.persiapanpengadaan_tanggal DESC ";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Pencarian data untuk dialog surat perjanjian kerja
     * @return \CActiveDataProvider
     */
    public function searchPersiapanPengadaan(){
        $criteria = new CDbCriteria;
        $criteria->join ='JOIN rencanaumumpengadaan_t ON rencanaumumpengadaan_t.rencanaumumpengadaan_id = t.rencanaumumpengadaan_id';
        $criteria->select = 't.*, rencanaumumpengadaan_t.rencanaumumpengadaan_kategori';
        if ($this->persiapanpengadaan_tanggal != "") {
            $criteria->addCondition("DATE(persiapanpengadaan_tanggal) = '" . MyFormatter::formatDateTimeForDb($this->persiapanpengadaan_tanggal) . "'");
        }
        $criteria->compare('LOWER(nama_pekerjaan)',$this->nama_pekerjaan,true);
        $criteria->addCondition(" t.persiapanpengadaan_status = '".Params::VERIFIKASI_DISETUJUI."'");
//        $criteria->addCondition(" t.rencanaumumpengadaan_kategori = 'Swakelola'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}