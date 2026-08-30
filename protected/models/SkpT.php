<?php

/**
 * This is the model class for table "skp_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'skp_t':
 * @property integer $skp_id
 * @property string $tglskp
 * @property string $noskp
 * @property string $nokartuasuransi
 * @property string $tglrujukan
 * @property string $norujukan
 * @property string $ppkrujukan
 * @property string $ppkpelayanan
 * @property integer $jnspelayanan
 * @property string $catatanskp
 * @property string $diagnosaawal
 * @property string $politujuan
 * @property integer $klsrawat
 * @property string $tglpulang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $lakalantas
 * @property integer $penjamin_lakalantas
 * @property string $lokasi_lakalantas
 * @property string $no_telpon_peserta
 * @property integer $poli_eksekutif
 * @property integer $cob
 * @property integer $jenisrujukan_kode
 * @property string $jenisrujukan_nama
 * @property integer $kelasrawat_kode
 * @property integer $hakkelas_kode
 * @property integer $inacbg_id
 * @property string $nama_diagnosaawal
 * @property string $namaasuransi_cob
 * @property string $no_asuransi_cob
 * @property string $propinsi_lakalantas_nama
 * @property string $kabupaten_lakalantas_nama
 * @property string $kecamatan_lakalantas_nama
 * @property integer $suplesi_jasaraharja
 * @property string $no_suplesi
 * @property string $keterangan_kejadian
 * @property string $no_surat
 * @property string $kode_dpjp
 * @property string $nama_dpjp
 * @property string $tanggal_kejadian
 * @property string $propinsi_lakalantas_id
 * @property string $kabupaten_lakalantas_id
 * @property string $kecamatan_lakalantas_id
 * @property integer $katarak
 * @property string $kodediagnosatambahan
 * @property boolean $is_inhealth
 *
 * The followings are the available model relations:
 * @property PendaftaranT[] $pendaftaranTs
 */
class SkpT extends CActiveRecord {
    
    public $status_noskp, $pelayanan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SkpT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'skp_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tglskp, noskp, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('jnspelayanan, klsrawat, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lakalantas, penjamin_lakalantas, poli_eksekutif, cob, jenisrujukan_kode, kelasrawat_kode, hakkelas_kode, inacbg_id, suplesi_jasaraharja, katarak', 'numerical', 'integerOnly' => true),
            array('noskp, politujuan, no_suplesi, no_surat, kode_dpjp, nama_dpjp, kodediagnosatambahan', 'length', 'max' => 100),
            array('nokartuasuransi, norujukan, ppkrujukan, ppkpelayanan, jenisrujukan_nama, namaasuransi_cob, no_asuransi_cob', 'length', 'max' => 50),
            array('lokasi_lakalantas', 'length', 'max' => 250),
            array('no_telpon_peserta', 'length', 'max' => 15),
            array('nama_diagnosaawal', 'length', 'max' => 500),
            array('propinsi_lakalantas_nama, kabupaten_lakalantas_nama, kecamatan_lakalantas_nama', 'length', 'max' => 200),
            array('propinsi_lakalantas_id, kabupaten_lakalantas_id, kecamatan_lakalantas_id', 'length', 'max' => 10),
            array('tglrujukan, catatanskp, diagnosaawal, tglpulang, update_time, keterangan_kejadian, tanggal_kejadian, is_inhealth', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('skp_id, tglskp, noskp, nokartuasuransi, tglrujukan, norujukan, ppkrujukan, ppkpelayanan, jnspelayanan, catatanskp, diagnosaawal, politujuan, klsrawat, tglpulang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lakalantas, penjamin_lakalantas, lokasi_lakalantas, no_telpon_peserta, poli_eksekutif, cob, jenisrujukan_kode, jenisrujukan_nama, kelasrawat_kode, hakkelas_kode, inacbg_id, nama_diagnosaawal, namaasuransi_cob, no_asuransi_cob, propinsi_lakalantas_nama, kabupaten_lakalantas_nama, kecamatan_lakalantas_nama, suplesi_jasaraharja, no_suplesi, keterangan_kejadian, no_surat, kode_dpjp, nama_dpjp, tanggal_kejadian, propinsi_lakalantas_id, kabupaten_lakalantas_id, kecamatan_lakalantas_id, katarak, kodediagnosatambahan, is_inhealth', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'skp_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'skp_id' => 'Skp',
            'tglskp' => 'Tglskp',
            'noskp' => 'Noskp',
            'nokartuasuransi' => 'Nokartuasuransi',
            'tglrujukan' => 'Tglrujukan',
            'norujukan' => 'Norujukan',
            'ppkrujukan' => 'Ppkrujukan',
            'ppkpelayanan' => 'Ppkpelayanan',
            'jnspelayanan' => 'Jnspelayanan',
            'catatanskp' => 'Catatanskp',
            'diagnosaawal' => 'Diagnosaawal',
            'politujuan' => 'Politujuan',
            'klsrawat' => 'Klsrawat',
            'tglpulang' => 'Tglpulang',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'lakalantas' => 'Lakalantas',
            'penjamin_lakalantas' => 'Penjamin Lakalantas',
            'lokasi_lakalantas' => 'Lokasi Lakalantas',
            'no_telpon_peserta' => 'No Telpon Peserta',
            'poli_eksekutif' => 'Poli Eksekutif',
            'cob' => 'Cob',
            'jenisrujukan_kode' => 'Jenisrujukan Kode',
            'jenisrujukan_nama' => 'Jenisrujukan Nama',
            'kelasrawat_kode' => 'Kelasrawat Kode',
            'hakkelas_kode' => 'Hakkelas Kode',
            'inacbg_id' => 'Inacbg',
            'nama_diagnosaawal' => 'Nama Diagnosaawal',
            'namaasuransi_cob' => 'Namaasuransi Cob',
            'no_asuransi_cob' => 'No Asuransi Cob',
            'propinsi_lakalantas_nama' => 'Propinsi Lakalantas Nama',
            'kabupaten_lakalantas_nama' => 'Kabupaten Lakalantas Nama',
            'kecamatan_lakalantas_nama' => 'Kecamatan Lakalantas Nama',
            'suplesi_jasaraharja' => 'Suplesi Jasaraharja',
            'no_suplesi' => 'No Suplesi',
            'keterangan_kejadian' => 'Keterangan Kejadian',
            'no_surat' => 'No Surat',
            'kode_dpjp' => 'Kode Dpjp',
            'nama_dpjp' => 'Nama Dpjp',
            'tanggal_kejadian' => 'Tanggal Kejadian',
            'propinsi_lakalantas_id' => 'Propinsi Lakalantas',
            'kabupaten_lakalantas_id' => 'Kabupaten Lakalantas',
            'kecamatan_lakalantas_id' => 'Kecamatan Lakalantas',
            'katarak' => 'Katarak',
            'kodediagnosatambahan' => 'Kodediagnosatambahan',
            'is_inhealth' => 'Is Inhealth',
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

        $criteria->compare('skp_id', $this->skp_id);
        $criteria->compare('tglskp', $this->tglskp, true);
        $criteria->compare('noskp', $this->noskp, true);
        $criteria->compare('nokartuasuransi', $this->nokartuasuransi, true);
        $criteria->compare('tglrujukan', $this->tglrujukan, true);
        $criteria->compare('norujukan', $this->norujukan, true);
        $criteria->compare('ppkrujukan', $this->ppkrujukan, true);
        $criteria->compare('ppkpelayanan', $this->ppkpelayanan, true);
        $criteria->compare('jnspelayanan', $this->jnspelayanan);
        $criteria->compare('catatanskp', $this->catatanskp, true);
        $criteria->compare('diagnosaawal', $this->diagnosaawal, true);
        $criteria->compare('politujuan', $this->politujuan, true);
        $criteria->compare('klsrawat', $this->klsrawat);
        $criteria->compare('tglpulang', $this->tglpulang, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('lakalantas', $this->lakalantas);
        $criteria->compare('penjamin_lakalantas', $this->penjamin_lakalantas);
        $criteria->compare('lokasi_lakalantas', $this->lokasi_lakalantas, true);
        $criteria->compare('no_telpon_peserta', $this->no_telpon_peserta, true);
        $criteria->compare('poli_eksekutif', $this->poli_eksekutif);
        $criteria->compare('cob', $this->cob);
        $criteria->compare('jenisrujukan_kode', $this->jenisrujukan_kode);
        $criteria->compare('jenisrujukan_nama', $this->jenisrujukan_nama, true);
        $criteria->compare('kelasrawat_kode', $this->kelasrawat_kode);
        $criteria->compare('hakkelas_kode', $this->hakkelas_kode);
        $criteria->compare('inacbg_id', $this->inacbg_id);
        $criteria->compare('nama_diagnosaawal', $this->nama_diagnosaawal, true);
        $criteria->compare('namaasuransi_cob', $this->namaasuransi_cob, true);
        $criteria->compare('no_asuransi_cob', $this->no_asuransi_cob, true);
        $criteria->compare('propinsi_lakalantas_nama', $this->propinsi_lakalantas_nama, true);
        $criteria->compare('kabupaten_lakalantas_nama', $this->kabupaten_lakalantas_nama, true);
        $criteria->compare('kecamatan_lakalantas_nama', $this->kecamatan_lakalantas_nama, true);
        $criteria->compare('suplesi_jasaraharja', $this->suplesi_jasaraharja);
        $criteria->compare('no_suplesi', $this->no_suplesi, true);
        $criteria->compare('keterangan_kejadian', $this->keterangan_kejadian, true);
        $criteria->compare('no_surat', $this->no_surat, true);
        $criteria->compare('kode_dpjp', $this->kode_dpjp, true);
        $criteria->compare('nama_dpjp', $this->nama_dpjp, true);
        $criteria->compare('tanggal_kejadian', $this->tanggal_kejadian, true);
        $criteria->compare('propinsi_lakalantas_id', $this->propinsi_lakalantas_id, true);
        $criteria->compare('kabupaten_lakalantas_id', $this->kabupaten_lakalantas_id, true);
        $criteria->compare('kecamatan_lakalantas_id', $this->kecamatan_lakalantas_id, true);
        $criteria->compare('katarak', $this->katarak);
        $criteria->compare('kodediagnosatambahan', $this->kodediagnosatambahan, true);
        $criteria->compare('is_inhealth', $this->is_inhealth);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
