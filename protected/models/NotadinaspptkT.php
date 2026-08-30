<?php

/**
 * This is the model class for table "notadinaspptk_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'notadinaspptk_t':
 * @property integer $notadinaspptk_id
 * @property integer $persiapanpengadaan_id
 * @property string $notadinaspptk_nomor
 * @property string $notadinaspptk_tanggal
 * @property string $nomor_notadinas
 * @property string $nomor_kuitansi
 * @property string $tanggal_pembayaran
 * @property string $telahditerima_dari
 * @property integer $pegpptk_id
 * @property integer $pegppk_id
 * @property integer $pegpjk_id
 * @property string $pegpjk_jabatan
 * @property double $jumlah_harga
 * @property double $jumlah_pph22
 * @property double $jumlah_diterima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $ispph22
 *
 * The followings are the available model relations:
 * @property NotadinaspptkdetT[] $notadinaspptkdetTs
 * @property PegawaiM $pegpjk
 * @property PegawaiM $pegppk
 * @property PegawaiM $pegpptk
 * @property PersiapanpengadaanT $persiapanpengadaan
 */
class NotadinaspptkT extends CActiveRecord {

    public $persiapanpengadaan_nomor, $persiapanpengadaan_tanggal, $sumberdana, $tahunanggaran, $koderekening, $total,
            $programkerja_nama, $subprogramkerja_nama, $kegiatanprogram_nama, $subkegiatanprogram_nama, $nama_pekerjaan, $nilai_hps,
            $pph22, $pegpjk_nama, $pegppk_nama, $pegpptk_nama, $pegpjk_unitkerja, $isi_surat,
            $suratperjanjiankerja_id, $nosuratperjanjiankerja, $tglsuratperjanjian, $pegawaikpa_id, $nama_pegawai,
            $unitkerja_id, $kategoripengadaan, $periodeanggaran_id, $perintahpengiriman_id, 
            $namaunitkerja;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NotadinaspptkT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notadinaspptk_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notadinaspptk_nomor, notadinaspptk_tanggal, pegpptk_id, pegppk_id, pegpjk_id, jumlah_diterima, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('persiapanpengadaan_id, pegpptk_id, pegppk_id, pegpjk_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('jumlah_harga, jumlah_pph22, jumlah_diterima', 'numerical'),
            array('notadinaspptk_nomor, nomor_notadinas, nomor_kuitansi', 'length', 'max' => 50),
            array('telahditerima_dari, pegpjk_jabatan', 'length', 'max' => 200),
            array('perintahpengiriman_id, islumsum, sisa_pagu, termin, paket_pekerjaan, jumlah_pajak, unitkerja_id, mappingrekeninganggaran_id, instalasi_id, kategori_pengadaan, rencanaumumpengadaan_id, suratperjanjiankerja_id, kontrak_nomor, kontrak_tanggal, supplier_id, supplier_nama, supplier_alamat, pegpjk_unitkerja, keperluan, jumlah_pajak, tanggal_pembayaran, update_time, ispph22', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('notadinaspptk_id, persiapanpengadaan_id, notadinaspptk_nomor, notadinaspptk_tanggal, nomor_notadinas, nomor_kuitansi, tanggal_pembayaran, telahditerima_dari, pegpptk_id, pegppk_id, pegpjk_id, pegpjk_jabatan, jumlah_harga, jumlah_pph22, jumlah_diterima, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ispph22', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'notadinaspptkdetTs' => array(self::HAS_MANY, 'NotadinaspptkdetT', 'notadinaspptk_id'),
            'pegpjk' => array(self::BELONGS_TO, 'PegawaiM', 'pegpjk_id'),
            'pegppk' => array(self::BELONGS_TO, 'PegawaiM', 'pegppk_id'),
            'pegpptk' => array(self::BELONGS_TO, 'PegawaiM', 'pegpptk_id'),
            'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'notadinaspptk_id' => 'Notadinaspptk',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'notadinaspptk_nomor' => 'Nomor Nota Dinas ',
            'notadinaspptk_tanggal' => 'Notadinaspptk Tanggal',
            'nomor_notadinas' => 'Nomor Notadinas',
            'nomor_kuitansi' => 'Nomor Kuitansi',
            'tanggal_pembayaran' => 'Tanggal Pembayaran',
            'telahditerima_dari' => 'Telahditerima Dari',
            'pegpptk_id' => 'Pegpptk',
            'pegppk_id' => 'Pegppk',
            'pegpjk_id' => 'Pegpjk',
            'pegpjk_jabatan' => 'Pegpjk Jabatan',
            'jumlah_harga' => 'Jumlah Sebelum Pajak',
            'jumlah_pph22' => 'Jumlah Pph22',
            'jumlah_diterima' => 'Jumlah Diterima',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'ispph22' => 'Ispph22',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('notadinaspptk_id', $this->notadinaspptk_id);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('notadinaspptk_nomor', $this->notadinaspptk_nomor, true);
        $criteria->compare('notadinaspptk_tanggal', $this->notadinaspptk_tanggal, true);
        $criteria->compare('nomor_notadinas', $this->nomor_notadinas, true);
        $criteria->compare('nomor_kuitansi', $this->nomor_kuitansi, true);
        $criteria->compare('tanggal_pembayaran', $this->tanggal_pembayaran, true);
        $criteria->compare('telahditerima_dari', $this->telahditerima_dari, true);
        $criteria->compare('pegpptk_id', $this->pegpptk_id);
        $criteria->compare('pegppk_id', $this->pegppk_id);
        $criteria->compare('pegpjk_id', $this->pegpjk_id);
        $criteria->compare('pegpjk_jabatan', $this->pegpjk_jabatan, true);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('jumlah_pph22', $this->jumlah_pph22);
        $criteria->compare('jumlah_diterima', $this->jumlah_diterima);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('ispph22', $this->ispph22);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data verifikasi untuk transaksi verifikasi keuangan
     * @return \CActiveDataProvider
     */
    public function searchNotaVerifikasi() {
        $criteria = new CDbCriteria();
            
        $criteria->select = "t.notadinaspptk_id,
                            t.notadinaspptk_nomor,
                            t.paket_pekerjaan,
                            t.nomor_notadinas,
                            t.rencanaumumpengadaan_id,
                            t.suratperjanjiankerja_id,
                            t.jumlah_diterima,
                            CASE
                            WHEN t.suratperjanjiankerja_id is not null THEN spk.periodeanggaran_id::text
                            ELSE rup.periodeanggaran_id::text
                            END AS periodeanggaran_id,
                            t.mappingrekeninganggaran_id, 
                            pptk.pegawai_id as pegpptk_id,
                            pptk.nama_pegawai as pegpptk_nama,
                            ppk.pegawai_id as pegppk_id,
                            ppk.nama_pegawai as pegppk_nama";
        $criteria->join = "join pegawai_m pptk on t.pegpptk_id = pptk.pegawai_id 
                           join pegawai_m ppk on t.pegppk_id = ppk.pegawai_id 
                           left join suratperjanjiankerja_t spk on t.suratperjanjiankerja_id = spk.suratperjanjiankerja_id
                           left join rencanaumumpengadaan_t rup on t.rencanaumumpengadaan_id = rup.rencanaumumpengadaan_id";
        if (!empty($this->periodeanggaran_id) && !empty($this->kategoripengadaan)) {
            if($this->kategoripengadaan == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                $criteria->addCondition("lower(t.kategori_pengadaan) = '".strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)."'");
            } else {
                $criteria->addCondition("lower(t.kategori_pengadaan) = '".strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)."'"); 
            }
            
            $criteria->addCondition("(not exists (select * from invoicemasuk_t where invoicemasuk_t.notadinaspptk_id = t.notadinaspptk_id)) AND"
                                    . "(rup.periodeanggaran_id  = ".$this->periodeanggaran_id ." OR "
                                    . " spk.periodeanggaran_id = ".$this->periodeanggaran_id.")");
        } else {
            $criteria->addCondition("t.notadinaspptk_id is null");
        }
                    
        $criteria->compare('LOWER(t.nomor_notadinas)',strtolower($this->nomor_notadinas),true);
        $criteria->compare('LOWER(t.notadinaspptk_nomor)',strtolower($this->notadinaspptk_nomor),true);
        $criteria->compare('LOWER(t.paket_pekerjaan)',strtolower($this->paket_pekerjaan),true);
        $criteria->compare('LOWER(pptk.nama_pegawai)',strtolower($this->pegpptk_nama),true);
        $criteria->compare('LOWER(ppk.pegppk_nama)',strtolower($this->pegppk_nama),true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
