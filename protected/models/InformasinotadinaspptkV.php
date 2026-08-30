<?php

/**
 * This is the model class for table "informasinotadinaspptk_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'informasinotadinaspptk_v':
 * @property integer $notadinaspptk_id
 * @property string $notadinaspptk_nomor
 * @property string $notadinaspptk_tanggal
 * @property integer $persiapanpengadaan_id
 * @property string $nama_pekerjaan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $nomor_notadinas
 * @property string $nomor_kuitansi
 * @property string $tanggal_pembayaran
 * @property integer $pegpptk_id
 * @property string $pegpptk
 * @property integer $pegppk_id
 * @property string $pegppk
 * @property integer $pegpjk_id
 * @property string $pegpjk
 * @property string $pegpjk_jabatan
 * @property double $jumlah_harga
 * @property double $jumlah_pph22
 * @property double $jumlah_diterima
 * @property integer $periodeanggaran_id
 * @property string $tahunanggaran
 * @property string $anggaran_nama
 * @property string $daftarsumberdana
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
 */
class InformasinotadinaspptkV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasinotadinaspptkV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'informasinotadinaspptk_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notadinaspptk_id, persiapanpengadaan_id, instalasi_id, pegpptk_id, pegppk_id, pegpjk_id, periodeanggaran_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id', 'numerical', 'integerOnly' => true),
            array('jumlah_harga, jumlah_pph22, jumlah_diterima', 'numerical'),
            array('notadinaspptk_nomor, instalasi_nama, nomor_notadinas, nomor_kuitansi, pegpptk, pegppk, pegpjk', 'length', 'max' => 50),
            array('nama_pekerjaan', 'length', 'max' => 300),
            array('pegpjk_jabatan', 'length', 'max' => 200),
            array('tahunanggaran, rencanaumumpengadaan_tahun', 'length', 'max' => 4),
            array('anggaran_nama', 'length', 'max' => 100),
            array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode', 'length', 'max' => 5),
            array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max' => 500),
            array('notadinaspptk_tanggal, tanggal_pembayaran, daftarsumberdana', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('notadinaspptk_id, notadinaspptk_nomor, notadinaspptk_tanggal, persiapanpengadaan_id, nama_pekerjaan, instalasi_id, instalasi_nama, nomor_notadinas, nomor_kuitansi, tanggal_pembayaran, pegpptk_id, pegpptk, pegppk_id, pegppk, pegpjk_id, pegpjk, pegpjk_jabatan, jumlah_harga, jumlah_pph22, jumlah_diterima, periodeanggaran_id, tahunanggaran, anggaran_nama, daftarsumberdana, rencanaumumpengadaan_tahun, programkerja_id, programkerja_kode, programkerja_nama, subprogramkerja_id, subprogramkerja_kode, subprogramkerja_nama, kegiatanprogram_id, kegiatanprogram_kode, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'notadinaspptk_id' => 'Notadinaspptk',
            'notadinaspptk_nomor' => 'Notadinaspptk Nomor',
            'notadinaspptk_tanggal' => 'Notadinaspptk Tanggal',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'nomor_notadinas' => 'Nomor Notadinas',
            'nomor_kuitansi' => 'Nomor Kuitansi',
            'tanggal_pembayaran' => 'Tanggal Pembayaran',
            'pegpptk_id' => 'Pegpptk',
            'pegpptk' => 'Pegpptk',
            'pegppk_id' => 'Pegppk',
            'pegppk' => 'Pegppk',
            'pegpjk_id' => 'Pegpjk',
            'pegpjk' => 'Pegpjk',
            'pegpjk_jabatan' => 'Pegpjk Jabatan',
            'jumlah_harga' => 'Jumlah Harga',
            'jumlah_pph22' => 'Jumlah Pph22',
            'jumlah_diterima' => 'Jumlah Diterima',
            'periodeanggaran_id' => 'Periodeanggaran',
            'tahunanggaran' => 'Tahunanggaran',
            'anggaran_nama' => 'Anggaran Nama',
            'daftarsumberdana' => 'Daftarsumberdana',
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
        $criteria->compare('notadinaspptk_nomor', $this->notadinaspptk_nomor, true);
        $criteria->compare('notadinaspptk_tanggal', $this->notadinaspptk_tanggal, true);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('nama_pekerjaan', $this->nama_pekerjaan, true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('nomor_notadinas', $this->nomor_notadinas, true);
        $criteria->compare('nomor_kuitansi', $this->nomor_kuitansi, true);
        $criteria->compare('tanggal_pembayaran', $this->tanggal_pembayaran, true);
        $criteria->compare('pegpptk_id', $this->pegpptk_id);
        $criteria->compare('pegpptk', $this->pegpptk, true);
        $criteria->compare('pegppk_id', $this->pegppk_id);
        $criteria->compare('pegppk', $this->pegppk, true);
        $criteria->compare('pegpjk_id', $this->pegpjk_id);
        $criteria->compare('pegpjk', $this->pegpjk, true);
        $criteria->compare('pegpjk_jabatan', $this->pegpjk_jabatan, true);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('jumlah_pph22', $this->jumlah_pph22);
        $criteria->compare('jumlah_diterima', $this->jumlah_diterima);
        $criteria->compare('periodeanggaran_id', $this->periodeanggaran_id);
        $criteria->compare('tahunanggaran', $this->tahunanggaran, true);
        $criteria->compare('anggaran_nama', $this->anggaran_nama, true);
        $criteria->compare('daftarsumberdana', $this->daftarsumberdana, true);
        $criteria->compare('rencanaumumpengadaan_tahun', $this->rencanaumumpengadaan_tahun, true);
        $criteria->compare('programkerja_id', $this->programkerja_id);
        $criteria->compare('programkerja_kode', $this->programkerja_kode, true);
        $criteria->compare('programkerja_nama', $this->programkerja_nama, true);
        $criteria->compare('subprogramkerja_id', $this->subprogramkerja_id);
        $criteria->compare('subprogramkerja_kode', $this->subprogramkerja_kode, true);
        $criteria->compare('subprogramkerja_nama', $this->subprogramkerja_nama, true);
        $criteria->compare('kegiatanprogram_id', $this->kegiatanprogram_id);
        $criteria->compare('kegiatanprogram_kode', $this->kegiatanprogram_kode, true);
        $criteria->compare('kegiatanprogram_nama', $this->kegiatanprogram_nama, true);
        $criteria->compare('subkegiatanprogram_id', $this->subkegiatanprogram_id);
        $criteria->compare('subkegiatanprogram_kode', $this->subkegiatanprogram_kode, true);
        $criteria->compare('subkegiatanprogram_nama', $this->subkegiatanprogram_nama, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "t.*, nota.paket_pekerjaan as nama_pekerjaan ";
        $criteria->join = "left join notadinaspptk_t nota on t.notadinaspptk_id = nota.notadinaspptk_id";
        
        $modPPTK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpptk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPPK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegppk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPJK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpjk_id' => Yii::app()->user->getState('pegawai_id')));

        if (!empty($modPPTK) || !empty($modPPK) || !empty($modPJK)) {
            $criteria->addCondition('t.pegpptk_id = '. Yii::app()->user->getState('pegawai_id').' OR '.
                                    't.pegppk_id = '. Yii::app()->user->getState('pegawai_id') . ' OR '.
                                    't.pegpjk_id = '. Yii::app()->user->getState('pegawai_id'));
        }
        
        $criteria->addBetweenCondition('DATE(t.notadinaspptk_tanggal)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('lower(t.notadinaspptk_nomor)', strtolower($this->notadinaspptk_nomor), true);
        $criteria->compare('lower(t.nomor_notadinas)', strtolower($this->nomor_notadinas), true);
        $criteria->compare('lower(nota.paket_pekerjaan)', strtolower($this->nama_pekerjaan), true);
        $criteria->compare('lower(t.pegpptk)', strtolower($this->pegpptk), true);
        $criteria->compare('lower(t.pegppk)', strtolower($this->pegppk), true);
        $criteria->compare('lower(t.pegpjk)', strtolower($this->pegpjk), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasiPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "t.*, nota.paket_pekerjaan as nama_pekerjaan ";
        $criteria->join = "left join notadinaspptk_t nota on t.notadinaspptk_id = nota.notadinaspptk_id";
        $criteria->addBetweenCondition('DATE(t.notadinaspptk_tanggal)', $this->tgl_awal, $this->tgl_akhir);
        
        $modPPTK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpptk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPPK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegppk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPJK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpjk_id' => Yii::app()->user->getState('pegawai_id')));

        if (!empty($modPPTK) || !empty($modPPK) || !empty($modPJK)) {
            $criteria->addCondition('t.pegpptk_id = '. Yii::app()->user->getState('pegawai_id').' OR '.
                                    't.pegppk_id = '. Yii::app()->user->getState('pegawai_id') . ' OR '.
                                    't.pegpjk_id = '. Yii::app()->user->getState('pegawai_id'));
        }
        
        $criteria->compare('lower(t.notadinaspptk_nomor)', strtolower($this->notadinaspptk_nomor), true);
        $criteria->compare('lower(t.nomor_notadinas)', strtolower($this->nomor_notadinas), true);
        $criteria->compare('lower(nota.paket_pekerjaan)', strtolower($this->nama_pekerjaan), true);
        $criteria->compare('lower(t.pegpptk)', strtolower($this->pegpptk), true);
        $criteria->compare('lower(t.pegppk)', strtolower($this->pegppk), true);
        $criteria->compare('lower(t.pegpjk)', strtolower($this->pegpjk), true);
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }

}
