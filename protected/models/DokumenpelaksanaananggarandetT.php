<?php

/**
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @subpackage models
 * @category model
 * 
 * The followings are the available columns in table 'dokumenpelaksanaananggarandet_t':
 * @property integer $dokumenpelaksanaananggarandet_id
 * @property integer $dokumenpelaksanaananggaran_id
 * @property integer $subkegiatanprogram_id
 * @property string $kode_rekening
 * @property string $uraian
 * @property double $volume
 * @property string $satuan
 * @property double $harga_satuan
 * @property double $jumlah
 * @property boolean $pengadaan_status
 * @property integer $barang_id
 * @property string $jenis_barang
 *
 * The followings are the available model relations:
 * @property SubkegiatanprogramM $subkegiatanprogram
 * @property DokumenpelaksanaananggaranT $dokumenpelaksanaananggaran
 * @property RencanaumumpengadaandetT[] $rencanaumumpengadaandetTs
 */
class DokumenpelaksanaananggarandetT extends CActiveRecord {

    public $unitkerja_id, $pengantaruangmuka_id, $pptk_id;
    public $programkerja_nama, $subprogramkerja_nama, $subkegiatanprogram_nama;
    public $periodeanggaran_id, $sisa_pagu, $sisa;
    public $default;
    public $instalasi_id;
    public $nmrekening5, $rekeninganggaran5_id;
    public $kegiatanprogram_nama, $kegiatanprogram_kode;
    public $subprogramkerja_id;
    public $programkerja_id;
    public $kegiatanprogram_id_from_sub;
    public $no_dpa, $rincian_serapan;
    public $jenis_dpa, $uraian_uangmukapanjar, $spjuangmuka;
    public $rencanabisnisanggarandet_id;
    public $kodeanggaran, $subsubprogramkerja_nama;
    public $metodepengadaan_id;

    public $nama_rekeninganggaran5, $rencanaumumpengadaandet_jumlah;
    public $rencanaumumpengadaandet_id, $rencanaumumpengadaan_id;

    public $golongan_kegiatan;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DokumenpelaksanaananggarandetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dokumenpelaksanaananggarandet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dokumenpelaksanaananggaran_id, subkegiatanprogram_id', 'required'),
            array('dokumenpelaksanaananggaran_id, subkegiatanprogram_id, barang_id', 'numerical', 'integerOnly' => true),
            array('volume, harga_satuan, jumlah', 'numerical'),
            array('jenis_barang', 'length', 'max' => 50),
            array('pjunitkerja_id, mappingrekeninganggaran_id, sisapagu_pengadaan, sisavolume_pengadaan, paketpekerjaan_id, metode_pengadaan, kegiatanprogram_id, subkegiatanprogram_id, kode_rekening, uraian, satuan, pengadaan_status', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('programkerja_nama,dokumenpelaksanaananggarandet_id, dokumenpelaksanaananggaran_id, subkegiatanprogram_id, kode_rekening, uraian, volume, satuan, harga_satuan, jumlah, pengadaan_status, barang_id, jenis_barang', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
            'dokumenpelaksanaananggaran' => array(self::BELONGS_TO, 'DokumenpelaksanaananggaranT', 'dokumenpelaksanaananggaran_id'),
            'rencanaumumpengadaandetTs' => array(self::HAS_MANY, 'RencanaumumpengadaandetT', 'dokumenpelaksanaananggarandet_id'),
            'mappingrekeninganggaran' => array(self::BELONGS_TO, 'DokumenpelaksanaananggaranT', 'mappingrekeninganggaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'dokumenpelaksanaananggarandet_id' => 'Dokumenpelaksanaananggarandet',
            'dokumenpelaksanaananggaran_id' => 'Dokumenpelaksanaananggaran',
            'subkegiatanprogram_id' => 'Subkegiatanprogram',
            'kode_rekening' => 'Kode Rekening',
            'uraian' => 'Uraian',
            'volume' => 'Volume',
            'satuan' => 'Satuan',
            'harga_satuan' => 'Harga Satuan',
            'jumlah' => 'Jumlah',
            'pengadaan_status' => 'Pengadaan Status',
            'barang_id' => 'Barang',
            'jenis_barang' => 'Jenis Barang',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->dokumenpelaksanaananggarandet_id)) {
            $criteria->addCondition('dokumenpelaksanaananggarandet_id = ' . $this->dokumenpelaksanaananggarandet_id);
        }
        if (!empty($this->dokumenpelaksanaananggaran_id)) {
            $criteria->addCondition('dokumenpelaksanaananggaran_id = ' . $this->dokumenpelaksanaananggaran_id);
        }
        if (!empty($this->subkegiatanprogram_id)) {
            $criteria->addCondition('subkegiatanprogram_id = ' . $this->subkegiatanprogram_id);
        }
        $criteria->compare('LOWER(kode_rekening)', strtolower($this->kode_rekening), true);
        $criteria->compare('LOWER(uraian)', strtolower($this->uraian), true);
        $criteria->compare('volume', $this->volume);
        $criteria->compare('LOWER(satuan)', strtolower($this->satuan), true);
        $criteria->compare('harga_satuan', $this->harga_satuan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('pengadaan_status', $this->pengadaan_status);
        if (!empty($this->barang_id)) {
            $criteria->addCondition('barang_id = ' . $this->barang_id);
        }
        $criteria->compare('LOWER(jenis_barang)', strtolower($this->jenis_barang), true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Pencarian Sub Kegiatan yang baru
     */
    public function searchSubkegiatan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->select = "t.subkegiatanprogram_id, dk.dokumenpelaksanaananggaran_id,dk.unitkerja_id, r5.nmrekening5";
        $criteria->join = " left join subkegiatanprogram_m s on s.subkegiatanprogram_id= t.subkegiatanprogram_id
                            left join kegiatanprogram_m k on k.kegiatanprogram_id=s.kegiatanprogram_id
                            left join subprogramkerja_m sk on sk.subprogramkerja_id=k.subprogramkerja_id
                            left join programkerja_m p on p.programkerja_id=sk.programkerja_id
                            join dokumenpelaksanaananggaran_t dk ON dk.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id 
                            JOIN unitkerja_m u ON u.unitkerja_id = dk.unitkerja_id    
                            LEFT JOIN rekening5_m r5 ON r5.rekening5_id = s.rekeningdebit_id";
        $criteria->group = 't.subkegiatanprogram_id, dk.dokumenpelaksanaananggaran_id, dk.unitkerja_id, r5.nmrekening5';

        if (!empty($this->default)) {
            $criteria->addCondition('t.dokumenpelaksanaananggaran_id is null ');
        }

        if (!empty($this->unitkerja_id)) {
            $criteria->addCondition('dk.unitkerja_id=' . $this->unitkerja_id);
        }
        if (!empty($this->periodeanggaran_id)) {
            $criteria->addCondition('dk.periodeanggaran_id=' . $this->periodeanggaran_id);
        }

        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('u.instalasi_id=' . $this->instalasi_id);
        }


        $criteria->compare('LOWER(p.programkerja_nama)', strtolower($this->programkerja_nama), true);
        $criteria->compare('LOWER(sk.subprogramkerja_nama)', strtolower($this->subprogramkerja_nama), true);
        $criteria->compare('LOWER(s.subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);
        $criteria->compare('LOWER(r5.nmrekening5)', strtolower($this->nmrekening5), true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * dialog yang digunakan, untuk meload data RAB/barang dan jasa
     * @return \CActiveDataProvider
     */
    public function searchRAB() {
        $cri = new CDbCriteria;
        $cri->join = " JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id "
                . " JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id ";
        $cri->addCondition(" t.pengadaan_status = FALSE ");
        if (!empty($this->default)) {
            $cri->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
        }
        if (!empty($this->instalasi_id)) {
            $cri->addCondition(" u.instalasi_id = " . $this->instalasi_id . " ");
        }
        if (!empty($this->unitkerja_id)) {
            $cri->addCondition(" t.unitkerja_id = " . $this->unitkerja_id . " ");
        }
        if (!empty($this->periodeanggaran_id)) {
            $cri->addCondition(" dok.periodeanggaran_id = " . $this->periodeanggaran_id . " ");
        }

        if (!empty($this->subkegiatanprogram_id)) {

            $sub = explode(',', $this->subkegiatanprogram_id);
            unset($sub[count($sub) - 1]);

            if (is_array($sub)) {
                $cri->addInCondition(" t.subkegiatanprogram_id ", $sub);
            } else {
                $cri->addCondition(" t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id . " ");
            }
        }
        
        
        
        if (!empty($this->kegiatanprogram_id)) {
            $cri->addCondition(" t.kegiatanprogram_id = " . $this->kegiatanprogram_id . " ");
        }
        if (!empty($this->mappingrekeninganggaran_id)) {
            
            $sub = explode(',', $this->mappingrekeninganggaran_id);
            unset($sub[count($sub) - 1]);

            if (is_array($sub)) {
                $cri->addInCondition(" t.mappingrekeninganggaran_id ", $sub);
            } else {
                $cri->addCondition(" t.mappingrekeninganggaran_id = " . $this->mappingrekeninganggaran_id . " ");
            }            
        }
        if (!empty($this->paketpekerjaan_id)) {

            $paket = explode(',', $this->paketpekerjaan_id);
            unset($paket[count($paket) - 1]);
            if (is_array($paket)) {
                $cri->addInCondition(" t.paketpekerjaan_id ", $paket);
            } else {
                $cri->addCondition(" t.paketpekerjaan_id = " . $this->paketpekerjaan_id . " ");
            }
        }
        $cri->compare('LOWER(t.uraian)', strtolower($this->uraian), true);
        $cri->order = "uraian ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

    /**
     * dialog yang digunakan, untuk meload data RAB/barang dan jasa
     * @return \CActiveDataProvider
     */
    public function searchDPAUntukPergeseran() {
        $cri = new CDbCriteria;
        //$cri->join =  " JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id ";
        $cri->select = " pk.programkerja_id, spk.subprogramkerja_id, dok.no_dpa, dok.periodeanggaran_id, dok.unitkerja_id, t.kegiatanprogram_id, keg.kegiatanprogram_id as kegiatanprogram_id_from_sub, keg.kegiatanprogram_nama, subkeg.subkegiatanprogram_nama, subkeg.subkegiatanprogram_id, t.*, maprek.kodeanggaran, appdet.golongan_kegiatan  ";
        $cri->join =  " JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id "
                    . " JOIN unitkerja_m u ON u.unitkerja_id = dok.unitkerja_id "
                    . " JOIN subkegiatanprogram_m subkeg ON subkeg.subkegiatanprogram_id = t.subkegiatanprogram_id "
                    . " JOIN kegiatanprogram_m keg ON keg.kegiatanprogram_id = subkeg.kegiatanprogram_id "
                    . " JOIN subprogramkerja_m spk ON spk.subprogramkerja_id = keg.subprogramkerja_id "
                    . " JOIN programkerja_m pk ON pk.programkerja_id = spk.programkerja_id "
                    . " LEFT JOIN mappingrekeninganggaran_m maprek ON maprek.mappingrekeninganggaran_id = t. mappingrekeninganggaran_id "
                    . " LEFT JOIN rencanabisnisanggarandet_t rbadet ON rbadet.dokumenpelaksanaananggarandet_id = t.dokumenpelaksanaananggarandet_id "
                    . " LEFT JOIN approvalusulananggarandet_t appdet ON rbadet.approvalusulananggarandet_id = appdet.approvalusulananggarandet_id";
        //$cri->addCondition(" t.pengadaan_status = true ");
        if (!empty($this->default)) {
            $cri->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
        }
        if (!empty($this->periodeanggaran_id)) {
            $cri->addCondition(" dok.periodeanggaran_id = " . $this->periodeanggaran_id . " ");
        }
        if (!empty($this->unitkerja_id)) {
            $cri->addCondition(" t.unitkerja_id = " . $this->unitkerja_id . " ");
        }
        if (!empty($this->subprogramkerja_id)) {
            $cri->addCondition(" spk.subprogramkerja_id = " . $this->subprogramkerja_id . " ");
        }
        if (!empty($this->dokumenpelaksanaananggarandet_id)) {
            $cri->addCondition(" t.dokumenpelaksanaananggarandet_id = " . $this->dokumenpelaksanaananggarandet_id . " ");
        }
        $cri->compare('LOWER(maprek.kodeanggaran)', strtolower($this->kodeanggaran), true);
        $cri->compare('LOWER(keg.kegiatanprogram_nama)', strtolower($this->kegiatanprogram_nama), true);
        $cri->compare('LOWER(subkeg.subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);
        $cri->compare('LOWER(t.uraian)', strtolower($this->uraian), true);
        $cri->compare('LOWER(t.satuan)', strtolower($this->satuan), true);
        $cri->compare('t.volume', $this->volume);
        $cri->compare('t.harga_satuan', $this->harga_satuan);
        $cri->compare('t.jumlah', $this->jumlah);
        $cri->compare('t.sisavolume_pengadaan', $this->sisavolume_pengadaan);
        $cri->compare('t.sisapagu_pengadaan', $this->sisapagu_pengadaan);
        $cri->compare('LOWER(appdet.golongan_kegiatan)', strtolower($this->golongan_kegiatan), true);
        
        //$cri->compare('LOWER(t.uraian)',strtolower($this->uraian),true);
        $cri->order = "uraian ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

    /**
     * Load data dialog transaksi permintaan uang muka panjar
     * Filter berdasarkan subkegiatanprogram_id dan unitkerja_id
     * @return \CActiveDataProvider
     */
    public function searchDialogUntukUangPanjar() {
        $cri = new CDbCriteria();
        $cri->select = "t.*, dok.dokumenpelaksanaananggaran_id, dok.unitkerja_id, t.subkegiatanprogram_id";
        $cri->join = "left join dokumenpelaksanaananggaran_t dok ON t.dokumenpelaksanaananggaran_id = dok.dokumenpelaksanaananggaran_id";
        $cri->order = "uraian ASC";
        if (!empty($this->subkegiatanprogram_id)) {
            $cri->addCondition("t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id);
        }
        if (!empty($this->unitkerja_id)) {
            $cri->addCondition("unitkerja_id = 84");
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

    /**
     * Load data dialog transaksi permintaan uang muka panjar
     * Filter berdasarkan subkegiatanprogram_id dan unitkerja_id
     * @return \CActiveDataProvider
     */
    public function searchDok() {
        $cri = new CDbCriteria();

        if (!empty($this->dokumenpelaksanaananggaran_id)) {
            $cri->addCondition("dokumenpelaksanaananggaran_id = " . $this->dokumenpelaksanaananggaran_id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

    /**
     * Search Kegiatan Verifikasi
     * @return \CActiveDataProvider
     */
    public function searchVerifikasiKeuangan() {
        $criteria = new CDbCriteria();
        if (empty($this->default)) {
            $criteria->addCondition('t.dokumenpelaksanaananggaran_id is null ');
        }
        if (!empty($this->rekeninganggaran5_id)) {
            $criteria->addCondition("mappingrekeninganggaran_m.rekeninganggaran5_id = " . $this->rekeninganggaran5_id);
        } else {
            
        }
        $criteria->select = "
                            t.dokumenpelaksanaananggaran_id, 
                            t.subkegiatanprogram_id, 
                            mappingrekeninganggaran_m.rekeninganggaran5_id, 
                            mappingrekeninganggaran_m.mappingrekeninganggaran_id, 
                            mappingrekeninganggaran_m.kodeanggaran, 
                            kegiatanprogram_m.kegiatanprogram_id, 
                            kegiatanprogram_m.kegiatanprogram_nama, 
                            kegiatanprogram_m.kegiatanprogram_kode ";
        $criteria->join = "left join kegiatanprogram_m on kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                           left join mappingrekeninganggaran_m on t.mappingrekeninganggaran_id = mappingrekeninganggaran_m.mappingrekeninganggaran_id";
        $criteria->addCondition("t.kegiatanprogram_id is not null and t.mappingrekeninganggaran_id is not null ");
        $criteria->group = "t.dokumenpelaksanaananggaran_id, t.subkegiatanprogram_id, kegiatanprogram_m.kegiatanprogram_id, kegiatanprogram_m.kegiatanprogram_kode, kegiatanprogram_m.kegiatanprogram_nama, mappingrekeninganggaran_m.mappingrekeninganggaran_id, mappingrekeninganggaran_m.kodeanggaran ";
        $criteria->compare('LOWER(kegiatanprogram_m.kegiatanprogram_nama)', strtolower($this->kegiatanprogram_nama), true);
        $criteria->compare('LOWER(mappingrekeninganggaran_m.kodeanggaran)', strtolower($this->kodeanggaran), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Search Dialog Rincian Verifikasi
     * @return \CActiveDataProvider
     */
    public function searchDialogRincian() {
        $criteria = new CDbCriteria();
        if (!empty($this->periodeanggaran_id) && !empty($this->unitkerja_id) && !empty($this->rekeninganggaran5_id) && !empty($this->subkegiatanprogram_id)) {
            $criteria->addCondition("t.unitkerja_id = " . $this->unitkerja_id);
            $criteria->addCondition("dok.periodeanggaran_id = " . $this->periodeanggaran_id);
            $criteria->addCondition("mappingrekeninganggaran_m.rekeninganggaran5_id = " . $this->rekeninganggaran5_id);
            $criteria->addCondition("t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id);
        } else {
            $criteria->addCondition('t.dokumenpelaksanaananggaran_id is null ');
        }

        $criteria->select = "
                            t.dokumenpelaksanaananggarandet_id,
                            t.uraian, 
                            t.volume,
                            t.satuan,
                            t.harga_satuan,
                            t.jumlah, 
                            mappingrekeninganggaran_m.rekeninganggaran5_id, 
                            mappingrekeninganggaran_m.mappingrekeninganggaran_id, 
                            mappingrekeninganggaran_m.kodeanggaran, 
                            kegiatanprogram_m.kegiatanprogram_id, 
                            kegiatanprogram_m.kegiatanprogram_nama";
        $criteria->join = "join dokumenpelaksanaananggaran_t dok on t.dokumenpelaksanaananggaran_id = dok.dokumenpelaksanaananggaran_id 
                           join kegiatanprogram_m on kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                           join mappingrekeninganggaran_m on t.mappingrekeninganggaran_id = mappingrekeninganggaran_m.mappingrekeninganggaran_id ";
        
        $criteria->compare('LOWER(t.uraian)', strtolower($this->uraian), true);
        $criteria->compare('LOWER(t.volume)', strtolower($this->volume), true);
        $criteria->compare('LOWER(mappingrekeninganggaran_m.kodeanggaran)', strtolower($this->kodeanggaran), true);

        $criteria->addCondition("((SELECT 
                                t.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) > 0 or (SELECT 
                                t.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) is null)");       
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load subkegiatan di transaksi verifikasi 
     * @return \CActiveDataProvider
     */
    public function searchSubKegiatanVerifikasi() {
        $criteria = new CDbCriteria();
        $criteria->select = "
                            t.subkegiatanprogram_id,
                            sub.subkegiatanprogram_nama,
                            kp.kegiatanprogram_nama,
                            kp.kegiatanprogram_id,
                            pk.programkerja_nama, 
                            t.mappingrekeninganggaran_id";
        $criteria->join = " JOIN dokumenpelaksanaananggaran_t dok on t.dokumenpelaksanaananggaran_id = dok.dokumenpelaksanaananggaran_id
                            JOIN subkegiatanprogram_m sub on sub.subkegiatanprogram_id = t.subkegiatanprogram_id
                            JOIN kegiatanprogram_m kp ON kp.kegiatanprogram_id = sub.kegiatanprogram_id 
                            JOIN subprogramkerja_m spk ON spk.subprogramkerja_id = kp.subprogramkerja_id  
                            JOIN programkerja_m pk ON pk.programkerja_id = spk.programkerja_id 
                            LEFT JOIN mappingrekeninganggaran_m maprek ON maprek.mappingrekeninganggaran_id = t.mappingrekeninganggaran_id";
        $criteria->group = "t.subkegiatanprogram_id,
                            sub.subkegiatanprogram_nama,
                            kp.kegiatanprogram_nama,
                            kp.kegiatanprogram_id,
                            pk.programkerja_nama,
                            t.mappingrekeninganggaran_id";

        if (!empty($this->rekeninganggaran5_id) && !empty($this->unitkerja_id) && !empty($this->periodeanggaran_id)) {
            $criteria->addCondition("maprek.rekeninganggaran5_id = " . $this->rekeninganggaran5_id);
            $criteria->addCondition("t.unitkerja_id = " . $this->unitkerja_id);
            $criteria->addCondition("dok.periodeanggaran_id = " . $this->periodeanggaran_id);
        } else {
            $criteria->addCondition(" dokumenpelaksanaananggarandet_id IS NULL ");
        }

        $criteria->compare('LOWER(sub.subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);
        $criteria->compare('LOWER(kp.kegiatanprogram_nama)', strtolower($this->kegiatanprogram_nama), true);
        $criteria->compare('LOWER(pk.programkerja_nama)', strtolower($this->programkerja_nama), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /* Search Dialog Rincian Verifikasi
     * @return \CActiveDataProvider
     */
    public function searchDialogRekMAK() {
        $criteria = new CDbCriteria();

        if (!empty($this->default)) {
            $criteria->addCondition(" dokumenpelaksanaananggarandet_id IS NULL ");
        }

        if (!empty($this->subkegiatanprogram_id)) {
            $sub = explode(',', $this->subkegiatanprogram_id);
            unset($sub[count($sub) - 1]);
            if (is_array($sub)) {
                $criteria->addInCondition("t.subkegiatanprogram_id", $sub);
            } else {
                $criteria->addCondition("t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id);
            }
        }
        if (!empty($this->paketpekerjaan_id)) {
            $paket = explode(',', $this->paketpekerjaan_id);
            unset($paket[count($paket) - 1]);
            if (is_array($paket)) {
                $criteria->addInCondition("t.paketpekerjaan_id", $paket);
            } else {
                $criteria->addCondition("t.paketpekerjaan_id = " . $this->paketpekerjaan_id);
            }
        }
        if (!empty($this->kodeanggaran)) {
            $criteria->addCondition(" mappingrekeninganggaran_m.kodeanggaran ilike '%" . $this->kodeanggaran . "%' OR mappingrekeninganggaran_m.nama_rekeninganggaran5 ilike '%" . $this->kodeanggaran . "%' ");
        }
        $criteria->addCondition(" sub.subprogramkerja_nama ilike '%" . $this->subprogramkerja_nama . "%' ");
//        
//        if (empty($this->spjuangmuka)) {
//            $criteria->addCondition('t.dokumenpelaksanaananggaran_id is null ');
//        }

        $criteria->group = "                            
                            mappingrekeninganggaran_m.rekeninganggaran5_id, 
                            mappingrekeninganggaran_m.nama_rekeninganggaran5,
                            mappingrekeninganggaran_m.mappingrekeninganggaran_id, 
                            mappingrekeninganggaran_m.kodeanggaran, 
                            kegiatanprogram_m.kegiatanprogram_id, 
                            kegiatanprogram_m.kegiatanprogram_nama,
                            sub.subprogramkerja_nama";
        $criteria->select = $criteria->group;
        $criteria->join = "join kegiatanprogram_m on kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                           join mappingrekeninganggaran_m on t.mappingrekeninganggaran_id = mappingrekeninganggaran_m.mappingrekeninganggaran_id                            
                           JOIN subprogramkerja_m sub ON sub.subprogramkerja_id = kegiatanprogram_m.subprogramkerja_id ";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
     /**
     * dialog yang digunakan, untuk meload data RAB/barang dan jasa
      * di halaman addendum SPK 
     * @return \CActiveDataProvider
     */
    public function searchAddendum() {
        $cri = new CDbCriteria;
        $cri->join = " JOIN dokumenpelaksanaananggaran_t dok ON dok.dokumenpelaksanaananggaran_id = t.dokumenpelaksanaananggaran_id "
                    ." JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id ";
        $cri->addCondition(" t.pengadaan_status = FALSE ");
        if (!empty($this->default)) {
            $cri->addCondition(" t.dokumenpelaksanaananggarandet_id is null ");
        }
        if (!empty($this->unitkerja_id)) {
            $cri->addCondition(" t.unitkerja_id = " . $this->unitkerja_id . " ");
        }
        if (!empty($this->periodeanggaran_id)) {
            $cri->addCondition(" dok.periodeanggaran_id = " . $this->periodeanggaran_id . " ");
        }
        if (!empty($this->subkegiatanprogram_id)) {
            $cri->addCondition(" t.subkegiatanprogram_id = " . $this->subkegiatanprogram_id . " ");
        }
        $cri->compare('LOWER(t.uraian)', strtolower($this->uraian), true);
        $cri->order = "uraian ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

}
