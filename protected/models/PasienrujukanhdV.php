<?php

/**
 * This is the model class for table "pasienrujukanhd_v".
 *
 * The followings are the available columns in table 'pasienrujukanhd_v':
 * @property string $tglkonsulpoli
 * @property string $catatan_dokter_konsul
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $instalasi_nama
 * @property string $instalasi_asal
 * @property string $ruangan_nama
 * @property string $ruangan_asal
 * @property string $nama_pegawai
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $kelaspelayanan_nama
 * @property string $jeniskasuspenyakit_nama
 */
class PasienrujukanhdV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir,$pasienkirimkeunitlain_id, $namadepan, $alias, $kelas_pelayanan_asal, $umur;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrujukanhdV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pasienrujukanhd_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, pasien_id', 'numerical', 'integerOnly' => true),
            array('no_pendaftaran, jeniskelamin', 'length', 'max' => 20),
            array('statusperiksa, instalasi_nama, ruangan_nama, nama_pegawai, nama_pasien, carabayar_nama, penjamin_nama, kelaspelayanan_nama', 'length', 'max' => 50),
            array('no_rekam_medik', 'length', 'max' => 10),
            array('jeniskasuspenyakit_nama', 'length', 'max' => 100),
            array('tglkonsulpoli, catatan_dokter_konsul, tgl_pendaftaran, tanggal_lahir, alamat_pasien', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tglkonsulpoli, catatan_dokter_konsul, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, statusperiksa, instalasi_nama, ruangan_nama, nama_pegawai,'
                . ' pasien_id, no_rekam_medik, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, carabayar_nama, penjamin_nama, kelaspelayanan_nama, jeniskasuspenyakit_nama,'
                . ' instalasi_asal, ruangan_asal', 'safe', 'on' => 'search'),
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
            'tglkonsulpoli' => 'Tglkonsulpoli',
            'catatan_dokter_konsul' => 'Catatan Dokter Konsul',
            'pendaftaran_id' => 'Pendaftaran',
            'tgl_pendaftaran' => 'Tgl Pendaftaran',
            'no_pendaftaran' => 'No Pendaftaran',
            'statusperiksa' => 'Statusperiksa',
            'instalasi_nama' => 'Instalasi Nama',
            'ruangan_nama' => 'Ruangan Nama',
            'nama_pegawai' => 'Nama Pegawai',
            'pasien_id' => 'Pasien',
            'no_rekam_medik' => 'No. Rekam Medik',
            'nama_pasien' => 'Nama Pasien',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jeniskelamin' => 'Jeniskelamin',
            'alamat_pasien' => 'Alamat Pasien',
            'carabayar_nama' => 'Carabayar Nama',
            'penjamin_nama' => 'Penjamin Nama',
            'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
            'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
            'instalasi_asal' => 'Instalasi Asal',
            'ruangan_asal' => 'Ruangan Asal',
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

        $criteria->compare('tglkonsulpoli', $this->tglkonsulpoli, true);
        $criteria->compare('catatan_dokter_konsul', $this->catatan_dokter_konsul, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
        $criteria->compare('statusperiksa', $this->statusperiksa, true);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('carabayar_nama', $this->carabayar_nama, true);
        $criteria->compare('penjamin_nama', $this->penjamin_nama, true);
        $criteria->compare('kelaspelayanan_nama', $this->kelaspelayanan_nama, true);
        $criteria->compare('jeniskasuspenyakit_nama', $this->jeniskasuspenyakit_nama, true);
        
        $criteria->compare('instalasi_asal', $this->instalasi_asal, true);
        $criteria->compare('ruangan_asal', $this->ruangan_asal, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPasienRujukan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('tgl_kirimpasien', $this->tgl_kirimpasien, true);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('LOWER(no_pendaftaran) ', strtolower($this->no_pendaftaran), true);
        $criteria->compare('statusperiksa', $this->statusperiksa, true);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('carabayar_nama', $this->carabayar_nama, true);
        $criteria->compare('penjamin_nama', $this->penjamin_nama, true);
        $criteria->compare('kelaspelayanan_nama', $this->kelaspelayanan_nama, true);
        $criteria->compare('jeniskasuspenyakit_nama', $this->jeniskasuspenyakit_nama, true);

        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);

        if(!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
        }



        $criteria->order = 'tgl_kirimpasien DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
