<?php

/**
 * This is the model class for table "profilrumahsakit_m".
 *
 * The followings are the available columns in table 'profilrumahsakit_m':
 * @property integer $profilrs_id
 * @property string $tahunprofilrs
 * @property string $kodejenisrs_profilrs
 * @property string $jenisrs_profilrs
 * @property string $statusrsswasta
 * @property string $namakepemilikanrs
 * @property integer $kodestatuskepemilikanrs
 * @property string $statuskepemilikanrs
 * @property string $pentahapanakreditasrs
 * @property string $statusakreditasrs
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $kelas_rumahsakit
 * @property string $namadirektur_rumahsakit
 * @property string $alamatlokasi_rumahsakit
 * @property string $nomor_suratizin
 * @property string $tgl_suratizin
 * @property string $oleh_suratizin
 * @property string $sifat_suratizin
 * @property string $masaberlakutahun_suratizin
 * @property string $motto
 * @property string $visi
 * @property string $no_faksimili
 * @property string $logo_rumahsakit
 * @property string $path_logorumahsakit
 * @property string $npwp
 * @property string $tahun_diresmikan
 * @property string $khususuntukswasta
 * @property string $website
 * @property string $email
 * @property string $no_telp_profilrs
 * @property string $namapendek_rumahsakit
 */
class ProfilrumahsakitM extends CActiveRecord
{
    public $warga_negara;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfilrumahsakitM the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'profilrumahsakit_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kodejenisrs_profilrs,propinsi_id,kabupaten_id, jenisrs_profilrs, nokode_rumahsakit, nama_rumahsakit', 'required'),
            array('kabupaten_id, kecamatan_id, propinsi_id, kelurahan_id, kodestatuskepemilikanrs', 'numerical', 'integerOnly' => true),
            array('tahunprofilrs, masaberlakutahun_suratizin, tahun_diresmikan', 'length', 'max' => 4),
            array('kodejenisrs_profilrs', 'length', 'max' => 15),
            array('kelas_rumahsakit, khususuntukswasta', 'length', 'max' => 1),
            array('nama_rumahsakit, jenisrs_profilrs, namakepemilikanrs, statuskepemilikanrs, kodepos, nama_pt, nama_tarifinacbgs_1, nama_tarifinacbg_2', 'length', 'max' => 100),
            array('statusrsswasta, pentahapanakreditasrs, statusakreditasrs, namadirektur_rumahsakit, sifat_suratizin, path_logorumahsakit, website, email, npwp_pt, namacabang', 'length', 'max' => 50),
            array('nokode_rumahsakit, kode_tarifinacbgs_1', 'length', 'max' => 10),
            array('npwp', 'length', 'max' => 25),
            array('nomor_suratizin', 'length', 'max' => 20),
            array('oleh_suratizin', 'length', 'max' => 30),
            array('no_faksimili, no_telp_profilrs', 'length', 'max' => 15),
            array('logo_rumahsakit', 'length', 'max' => 254),
            array('logo_rumahsakit_2', 'length', 'max' => 254),
            array('logo_navbar,logo_sidebar,logo_footer, logo_footer_2', 'safe'),
            array('namapendek_rumahsakit', 'safe'),
            array('alamatlokasi_rumahsakit, tgl_suratizin, motto, visi, noimagelayarantrian, videoprofil, npwp_pt, nama_pt, ppkpelayanan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('profilrs_id, kabupaten_id, kecamatan_id, propinsi_id, kelurahan_id, tahunprofilrs, kodejenisrs_profilrs, jenisrs_profilrs, statusrsswasta, namakepemilikanrs, kodestatuskepemilikanrs, statuskepemilikanrs, pentahapanakreditasrs, statusakreditasrs, nokode_rumahsakit, nama_rumahsakit, kelas_rumahsakit, namadirektur_rumahsakit, alamatlokasi_rumahsakit, nomor_suratizin, tgl_suratizin, oleh_suratizin, sifat_suratizin, masaberlakutahun_suratizin, motto, visi, no_faksimili, logo_rumahsakit, path_logorumahsakit, npwp, tahun_diresmikan, khususuntukswasta, website, email, no_telp_profilrs, negara, noimagelayarantrian, videoprofil, npwp_pt, nama_pt, kode_tarifinacbgs_1, nama_tarifinacbgs_1, nama_tarifinacbg_2, namacabang', 'safe', 'on' => 'search'),
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
            'propinsi' => array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
            'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
            'kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'kelurahan_id'),
            'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'profilrs_id' => 'ID',
            'tahunprofilrs' => 'Tahun',
            'kodejenisrs_profilrs' => 'Kode Jenis',
            'jenisrs_profilrs' => 'Jenis Rumah Sakit',
            'statusrsswasta' => 'Status Rumah Sakit',
            'namakepemilikanrs' => 'Nama Kepemilikan',
            'kodestatuskepemilikanrs' => 'Kode Status Kepemilikan',
            'statuskepemilikanrs' => 'Status Kepemilikan',
            'pentahapanakreditasrs' => 'Pentahapan Akreditas',
            'statusakreditasrs' => 'Status Akreditas',
            'nokode_rumahsakit' => 'No. kode',
            'nama_rumahsakit' => 'Nama',
            'kelas_rumahsakit' => 'Kelas',
            'namadirektur_rumahsakit' => 'Direktur',
            'alamatlokasi_rumahsakit' => 'Alamat',
            'nomor_suratizin' => 'Nomor',
            'tgl_suratizin' => 'Tanggal',
            'oleh_suratizin' => 'Oleh',
            'sifat_suratizin' => 'Sifat',
            'masaberlakutahun_suratizin' => 'Masa Berlaku s/d Tahun',
            'motto' => 'Motto',
            'visi' => 'Visi',
            'no_faksimili' => 'No. Faksimili',
            'logo_rumahsakit' => 'Logo Rumah Sakit',
            'logo_rumahsakit_2' => 'Logo Rumah Sakit 2',
            'path_logorumahsakit' => 'Logo',
            'npwp' => 'NPWP',
            'tahun_diresmikan' => 'Tahun Diresmikan',
            'khususuntukswasta' => 'Khusus Untuk Swasta',
            'website' => 'Website',
            'email' => 'Email',
            'no_telp_profilrs' => 'No. Telepon',
            'propinsi_id' => 'Provinsi',
            'kabupaten_id' => 'Kota / Kabupaten',
            'kecamatan_id' => 'Kecamatan',
            'kelurahan_id' => 'Kelurahan',
            'negara' => 'Warga Negara',
            'luastanah' => 'Tanah',
            'luasbangunan' => 'Bangunan',
            'ppkpelayanan' => 'No. PPK',
            'tglakreditasi' => 'Tanggal Akreditasi',
            'noimagelayarantrian' => 'Gambar Layar Antrian',
            'videoprofil' => 'Video Layar Antrian',
            'kodepos' => 'Kode Pos',
            'npwp_pt' => 'NPWP PT',
            'nama_pt' => 'Nama PT',
            'kode_tarifinacbgs_1' => 'Kode Tarif INACBG',
            'nama_tarifinacbgs_1' => 'Nama Tarif INACBG 1',
            'nama_tarifinacbg_2' => 'Nama Tarif INACBG 2',
            'namapendek_rumahsakit' => 'Nama Pendek Rumah Sakit',
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

        $criteria = new CDbCriteria;

        $criteria->compare('profilrs_id', $this->profilrs_id);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        //		$criteria->compare('LOWER(propinsi.propinsi_nama)',strtolower($this->propinsiNama),true);
        //		$criteria->compare('LOWER(kabupaten.kabupaten_nama)',strtolower($this->kabupatenNama),true);
        //		$criteria->compare('LOWER(kecamatan.kecamatan_nama)',strtolower($this->kecamatanNama),true);
        //		$criteria->compare('LOWER(kelurahan.kelurahan_nama)',strtolower($this->kelurahanNama),true);                 
        $criteria->compare('LOWER(tahunprofilrs)', strtolower($this->tahunprofilrs), true);
        $criteria->compare('LOWER(kodejenisrs_profilrs)', strtolower($this->kodejenisrs_profilrs), true);
        $criteria->compare('LOWER(jenisrs_profilrs)', strtolower($this->jenisrs_profilrs), true);
        $criteria->compare('LOWER(statusrsswasta)', strtolower($this->statusrsswasta), true);
        $criteria->compare('LOWER(namakepemilikanrs)', strtolower($this->namakepemilikanrs), true);
        $criteria->compare('kodestatuskepemilikanrs', $this->kodestatuskepemilikanrs);
        $criteria->compare('LOWER(statuskepemilikanrs)', strtolower($this->statuskepemilikanrs), true);
        $criteria->compare('LOWER(pentahapanakreditasrs)', strtolower($this->pentahapanakreditasrs), true);
        $criteria->compare('LOWER(statusakreditasrs)', strtolower($this->statusakreditasrs), true);
        $criteria->compare('LOWER(nokode_rumahsakit)', strtolower($this->nokode_rumahsakit), true);
        $criteria->compare('LOWER(nama_rumahsakit)', strtolower($this->nama_rumahsakit), true);
        $criteria->compare('LOWER(kelas_rumahsakit)', strtolower($this->kelas_rumahsakit), true);
        $criteria->compare('LOWER(namadirektur_rumahsakit)', strtolower($this->namadirektur_rumahsakit), true);
        $criteria->compare('LOWER(alamatlokasi_rumahsakit)', strtolower($this->alamatlokasi_rumahsakit), true);
        $criteria->compare('LOWER(nomor_suratizin)', strtolower($this->nomor_suratizin), true);
        $criteria->compare('LOWER(tgl_suratizin)', strtolower($this->tgl_suratizin), true);
        $criteria->compare('LOWER(oleh_suratizin)', strtolower($this->oleh_suratizin), true);
        $criteria->compare('LOWER(sifat_suratizin)', strtolower($this->sifat_suratizin), true);
        $criteria->compare('LOWER(masaberlakutahun_suratizin)', strtolower($this->masaberlakutahun_suratizin), true);
        $criteria->compare('LOWER(motto)', strtolower($this->motto), true);
        $criteria->compare('LOWER(visi)', strtolower($this->visi), true);
        $criteria->compare('LOWER(no_faksimili)', strtolower($this->no_faksimili), true);
        $criteria->compare('LOWER(logo_rumahsakit)', strtolower($this->logo_rumahsakit), true);
        $criteria->compare('LOWER(path_logorumahsakit)', strtolower($this->path_logorumahsakit), true);
        $criteria->compare('LOWER(npwp)', strtolower($this->npwp), true);
        $criteria->compare('LOWER(tahun_diresmikan)', strtolower($this->tahun_diresmikan), true);
        $criteria->compare('LOWER(khususuntukswasta)', strtolower($this->khususuntukswasta), true);
        $criteria->compare('LOWER(website)', strtolower($this->website), true);
        $criteria->compare('LOWER(email)', strtolower($this->email), true);
        $criteria->compare('LOWER(no_telp_profilrs)', strtolower($this->no_telp_profilrs), true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('kabupaten_id', $this->propinsi_id);
        $criteria->compare('LOWER(negara)', strtolower($this->negara), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('profilrs_id', $this->profilrs_id);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(tahunprofilrs)', strtolower($this->tahunprofilrs), true);
        $criteria->compare('LOWER(kodejenisrs_profilrs)', strtolower($this->kodejenisrs_profilrs), true);
        $criteria->compare('LOWER(jenisrs_profilrs)', strtolower($this->jenisrs_profilrs), true);
        $criteria->compare('LOWER(statusrsswasta)', strtolower($this->statusrsswasta), true);
        $criteria->compare('LOWER(namakepemilikanrs)', strtolower($this->namakepemilikanrs), true);
        $criteria->compare('kodestatuskepemilikanrs', $this->kodestatuskepemilikanrs);
        $criteria->compare('LOWER(statuskepemilikanrs)', strtolower($this->statuskepemilikanrs), true);
        $criteria->compare('LOWER(pentahapanakreditasrs)', strtolower($this->pentahapanakreditasrs), true);
        $criteria->compare('LOWER(statusakreditasrs)', strtolower($this->statusakreditasrs), true);
        $criteria->compare('LOWER(nokode_rumahsakit)', strtolower($this->nokode_rumahsakit), true);
        $criteria->compare('LOWER(nama_rumahsakit)', strtolower($this->nama_rumahsakit), true);
        $criteria->compare('LOWER(kelas_rumahsakit)', strtolower($this->kelas_rumahsakit), true);
        $criteria->compare('LOWER(namadirektur_rumahsakit)', strtolower($this->namadirektur_rumahsakit), true);
        $criteria->compare('LOWER(alamatlokasi_rumahsakit)', strtolower($this->alamatlokasi_rumahsakit), true);
        $criteria->compare('LOWER(nomor_suratizin)', strtolower($this->nomor_suratizin), true);
        $criteria->compare('LOWER(tgl_suratizin)', strtolower($this->tgl_suratizin), true);
        $criteria->compare('LOWER(oleh_suratizin)', strtolower($this->oleh_suratizin), true);
        $criteria->compare('LOWER(sifat_suratizin)', strtolower($this->sifat_suratizin), true);
        $criteria->compare('LOWER(masaberlakutahun_suratizin)', strtolower($this->masaberlakutahun_suratizin), true);
        $criteria->compare('LOWER(motto)', strtolower($this->motto), true);
        $criteria->compare('LOWER(visi)', strtolower($this->visi), true);
        $criteria->compare('LOWER(no_faksimili)', strtolower($this->no_faksimili), true);
        $criteria->compare('LOWER(logo_rumahsakit)', strtolower($this->logo_rumahsakit), true);
        $criteria->compare('LOWER(path_logorumahsakit)', strtolower($this->path_logorumahsakit), true);
        $criteria->compare('LOWER(npwp)', strtolower($this->npwp), true);
        $criteria->compare('LOWER(tahun_diresmikan)', strtolower($this->tahun_diresmikan), true);
        $criteria->compare('LOWER(khususuntukswasta)', strtolower($this->khususuntukswasta), true);
        $criteria->compare('LOWER(website)', strtolower($this->website), true);
        $criteria->compare('LOWER(email)', strtolower($this->email), true);
        $criteria->compare('LOWER(no_telp_profilrs)', strtolower($this->no_telp_profilrs), true);
        $criteria->compare('LOWER(negara)', strtolower($this->negara), true);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('kabupaten_id', $this->propinsi_id);
        $criteria->limit = -1;
        $criteria->order = 'nama_rumahsakit';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    protected function beforeValidate()
    {
        // convert to storage format
        //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
        $format = new MyFormatter();
        //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
            if ($column->dbType == 'date') {
                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
            } elseif ($column->dbType == 'datetime') {
                $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
            }
        }

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        //$this->modul_nama = ucwords(strtolower($this->modul_nama));
        if ($this->tahunprofilrs === null || trim($this->tahunprofilrs) == '') {
            $this->setAttribute('tahunprofilrs', null);
        }

        if ($this->tgl_suratizin === null || trim($this->tgl_suratizin) == '') {
            $this->setAttribute('tgl_suratizin', null);
        }

        if ($this->tahun_diresmikan === null || trim($this->tahun_diresmikan) == '') {
            $this->setAttribute('tahun_diresmikan', null);
        }
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {

            if (!strlen($this->$columnName)) continue;

            if ($column->dbType == 'date') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),
                    'medium',
                    null
                );
            } elseif ($column->dbType == 'datetime') {
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss')
                );
            }
        }
        return true;
    }

    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif' => true), array('order' => 'propinsi_nama'));
    }

    public function getKabupatenItems($propinsi_id = null)
    {
        if (!empty($propinsi_id))
            return KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $propinsi_id, 'kabupaten_aktif' => true), array('order' => 'kabupaten_nama'));
        else {
            return array();
        }
    }

    public function getKecamatanItems($kabupaten_id = null)
    {
        if (!empty($kabupaten_id))
            return KecamatanM::model()->findAllByAttributes(array('kabupaten_id' => $kabupaten_id, 'kecamatan_aktif' => true), array('order' => 'kecamatan_nama'));
        else {
            return array();
        }
    }

    public function getKelurahanItems($kecamatan_id = null)
    {
        if (!empty($kecamatan_id))
            return KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $kecamatan_id, 'kelurahan_aktif' => true), array('order' => 'kelurahan_nama'));
        else {
            return array();
        }
    }

    //          public function getNegaraItems()
    //        {
    //            return ProfilrumahsakitM::model()->findAll('kecamatan_aktif=TRUE ORDER BY kecamatan_nama');
    //        }    
    public function getInitJenisRS()
    {
        if (!empty($this->jenisrs_profilrs)) {
            $pisah = explode(" ", $this->jenisrs_profilrs);
            $jenis = '';
            foreach ($pisah as $val) {
                $jenis .= substr($val, 0, 1);
            }
        } else {
            $jenis = '';
        }

        return $jenis;
    }
}
