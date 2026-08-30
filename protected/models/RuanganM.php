<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 * @property string $ruangan_singkatan
 * @property integer $riwayatruangan_id
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 */
class RuanganM extends CActiveRecord {

    public $instalasi_nama;
    public $tgl_awal, $tgl_akhir, $bulan, $propinsi_id, $kabupaten_id, $pekerjaan_id, $carabayar_id, $penjamin_id, $pendidikan_id, $suku_id, $statuspasien, $ruangan;
    public $default, $gedung_nama, $area_nama;
    public $is_penerimaan_limbah = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RuanganM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ruangan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_nama', 'required'),
            array('instalasi_id, riwayatruangan_id, modul_id', 'numerical', 'integerOnly' => true),
            array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max' => 50),
            array('ruangan_singkatan', 'length', 'max' => 3),
            array('ruangan_image', 'length', 'max' => 100),
            array('is_nicu, is_klinikanak, is_jiwa, is_saraf,is_tindakan, ruangan_aktif, ruangan_fasilitas, modul_id, kode_bpjs, estimasipelayanan, ruangan_filesuara', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('is_nicu, is_klinikanak, ruangan_id, instalasi_id, data , is_tindakan, tick , jumlah, ruangan_nama, ruangan_namalainnya, bulan, tgl_awal, tgl_akhir,ruangan_jenispelayanan, ruangan_lokasi, ruangan_aktif, ruangan_singkatan, riwayatruangan_id, ruangan_fasilitas, ruangan_image', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ruangan_id' => 'ID',
            'instalasi_id' => 'Instalasi',
            'ruangan_nama' => 'Ruangan ',
            'ruangan_namalainnya' => 'Nama Lainnya',
            'ruangan_jenispelayanan' => 'Jenis Pelayanan',
            'ruangan_lokasi' => 'Lokasi',
            'ruangan_aktif' => 'Aktif',
            'ruangan_singkatan' => 'Singkatan',
            'riwayatruangan_id' => 'Riwayat Ruangan',
            'ruangan_fasilitas' => 'Fasilitas',
            'ruangan_image' => 'Photo Image',
            'modul_id' => 'Modul',
            'kode_bpjs' => 'Kode BPJS',
            'estimasipelayanan' => 'Estimasi Pelayanan (Menit)',
            'ruangan_filesuara' => 'Suara Antrian Ruangan',
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

        $criteria->compare('ruangan_id', $this->ruangan_id);
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $criteria->addInCondition('t.instalasi_id', $this->instalasi_id);
            } else {
                $criteria->compare('t.instalasi_id', $this->instalasi_id);
            }
        }

        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(ruangan_namalainnya)', strtolower($this->ruangan_namalainnya), true);
        $criteria->compare('LOWER(ruangan_jenispelayanan)', strtolower($this->ruangan_jenispelayanan), true);
        $criteria->compare('LOWER(ruangan_lokasi)', strtolower($this->ruangan_lokasi), true);
        $criteria->compare('LOWER(ruangan_singkatan)', strtolower($this->ruangan_singkatan), true);
        $criteria->compare('riwayatruangan_id', $this->riwayatruangan_id);
        $criteria->compare('LOWER(ruangan_fasilitas)', strtolower($this->ruangan_fasilitas), true);
        $criteria->compare('LOWER(ruangan_image)', strtolower($this->ruangan_image), true);
        $criteria->compare('ruangan_aktif', isset($this->ruangan_aktif) ? $this->ruangan_aktif : true);
        $criteria->order = "ruangan_id ASC";
//                $criteria->addCondition('ruangan_aktif is true');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(ruangan_namalainnya)', strtolower($this->ruangan_namalainnya), true);
        $criteria->compare('LOWER(ruangan_jenispelayanan)', strtolower($this->ruangan_jenispelayanan), true);
        $criteria->compare('LOWER(ruangan_lokasi)', strtolower($this->ruangan_lokasi), true);
        $criteria->compare('ruangan_aktif', $this->ruangan_aktif);
        $criteria->compare('LOWER(ruangan_singkatan)', strtolower($this->ruangan_singkatan), true);
        $criteria->compare('riwayatruangan_id', $this->riwayatruangan_id);
        $criteria->compare('LOWER(ruangan_fasilitas)', strtolower($this->ruangan_fasilitas), true);
        $criteria->compare('LOWER(ruangan_image)', strtolower($this->ruangan_image), true);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function beforeSave() {
        //$this->ruangan_nama = ucwords(strtolower($this->ruangan_nama));
        $this->ruangan_namalainnya = strtoupper($this->ruangan_namalainnya);
        $this->ruangan_singkatan = strtoupper($this->ruangan_singkatan);
        $this->ruangan_lokasi = ucwords(strtolower($this->ruangan_lokasi));
        return parent::beforeSave();
    }

    public function getInstalasiItems() {
        return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama');
        //return InstalasiM::model()->findAll('instalasi_adakamar=TRUE AND instalasi_aktif=TRUE ORDER BY instalasi_nama');
    }

        /**
     * static agar bisa menerima nilai dari parameter
     * @param type $instalasi_id
     * @return type
     */
    public static function getItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = 'ruangan_nama ASC';

        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);

            $model = self::model()->findAll($criteria);
            return self::model()->findAll($criteria);
        } else {
            return array();
        }
    }

    public static function getRuanganByInstalasi($instalasi = '') {
        if (!empty($instalasi))
            return RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi), array('condition' => 'ruangan_aktif=TRUE', 'order' => 'ruangan_nama'));
        else
            return array();
    }

    public static function getRuanganByInstalasi2($instalasi = '') {
        if (!empty($instalasi)) {
            return RuanganM::model()->findAll("instalasi_id = '" . $instalasi . "' AND ruangan_aktif=TRUE AND ruangan_id != '" . Yii::app()->user->getState('ruangan_id') . "' ORDER BY ruangan_nama");
        } else {
            return array();
        }
    }

    public function getPropinsiItems() {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
    }

    public function getCaraBayarItems() {
        return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true), array('order' => 'carabayar_nourut'));
    }

    public function getPenjaminItems($carabayar_id = null) {
        if (!empty($carabayar_id))
            return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        else
            return array();
        //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
    }

    public function getPekerjaanItems() {
        return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
    }

    public function getPendidikanItems() {
        return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
    }

    public function getSukuItems() {
        return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
    }

    public static function items() {
        $models = RuanganM::model()->findAll('
                instalasi_id IN (1,2,3,4,5,6,7) AND ruangan_aktif = TRUE ORDER BY ruangan_nama
            ');
        $items = array();
        foreach ($models as $model) {
            $items[$model->ruangan_id] = $model->ruangan_nama;
        }
        return $items;
    }

    public function ruanganNamaById($id) {
        $cek = $this->findByPk($id);

        if (empty($cek)):
            return null;
        else:
            return $cek->ruangan_nama;
        endif;
    }

    public function getRuanganByModul($modul_id) {
        $cek = $this->findAllByAttributes(array('modul_id' => $modul_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC'));

        if (empty($cek)):
            return null;
        else:
            foreach ($cek as $dt) {
                if ($dt->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                    return true;
                } else {
                    $data = false;
                }
            }
            return $data;
        endif;
    }

    /**
     * digunakan untuk menegenerate data ruangan, untuk di risk register
     * @return \CActiveDataProvider
     */
    public function searchRuanganTanpaAdm() {
        $criteria = new CDbCriteria;
        $criteria->select = " t.ruangan_nama, i.instalasi_nama, t.ruangan_id ";
        $criteria->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition(" t.instalasi_id = '" . $this->instalasi_id . "' ");
        }
        $criteria->addCondition("ruangan_aktif is true and lower(ruangan_nama) NOT LIKE 'adm%'");
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(i.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->order = 't.ruangan_nama ASC';
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * digunakan untuk menegenerate data ruangan, ditampilkan dalam grid view tabel dan di tampilkan pada dialog box
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        $criteria = new CDbCriteria;
        $criteria->select = [
            "t.kode_ruanganaset",
            "l.lookup_kode",
            "t.ruangan_lokasi",
            "t.ruangan_nama",
            "i.instalasi_nama",
            "t.ruangan_id",
            "i.instalasi_id",
            "i.instalasi_kode",
            "l.lookup_kode",
            "g.gedung_id",
            "g.gedung_nama",
            "g.gedung_kode",
            "a.area_nama",
            "a.area_kode"
        ];
        $criteria->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id "
                . " LEFT JOIN gedung_m g ON g.gedung_id = t.gedung_id "
                . " LEFT JOIN area_m a ON a.area_id = t.area_id "
                . " LEFT JOIN lookup_m l ON l.lookup_value = t.ruangan_lokasi AND l.lookup_type = 'ruangan_lokasi' ";
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition(" t.instalasi_id = '" . $this->instalasi_id . "' ");
        }
        if (!empty($this->gedung_id)) {
            $criteria->addCondition(" t.gedung_id = '" . $this->gedung_id . "' ");
        }
        if (!empty($this->default)) {
            $criteria->addCondition(" t.ruangan_id is null ");
        }

        if ($this->is_penerimaan_limbah) {
            $criteria->addCondition(" t.ruangan_id IN (SELECT sumberlimbah_id FROM logbookpenerimaanlimbahdaurulangdet_t GROUP BY sumberlimbah_id) ");
        }

        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.ruangan_lokasi)', strtolower($this->ruangan_lokasi), true);
        $criteria->compare('LOWER(g.gedung_nama)', strtolower($this->gedung_nama), true);
        $criteria->compare('LOWER(i.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(a.area_nama)', strtolower($this->area_nama), true);
        $criteria->addCondition('t.ruangan_aktif = TRUE');
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'ruangan_nama ASC'
            ]
        ));
    }

    /**
     * Untuk Open Dialog di Manajemen Aset
     * @return \CActiveDataProvider
     */
    public function searchDialogAset() {
        $criteria = new CDbCriteria;
        $criteria->select = [
            "t.kode_ruanganaset",
            "l.lookup_kode",
            "t.ruangan_lokasi",
            "t.ruangan_nama",
            "i.instalasi_nama",
            "t.ruangan_id",
            "i.instalasi_id",
            "i.instalasi_kode",
            "l.lookup_kode",
            "g.gedung_id",
            "g.gedung_nama",
            "g.gedung_kode",
            "a.area_nama",
            "a.area_kode"
        ];
        $criteria->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id "
                . " JOIN gedung_m g ON g.gedung_id = t.gedung_id "
                . " JOIN area_m a ON a.area_id = t.area_id "
                . " LEFT JOIN lookup_m l ON l.lookup_value = t.ruangan_lokasi AND l.lookup_type = 'ruangan_lokasi' ";
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition(" t.instalasi_id = '" . $this->instalasi_id . "' ");
        }
        if (!empty($this->gedung_id)) {
            $criteria->addCondition(" t.gedung_id = '" . $this->gedung_id . "' ");
        }
        if (!empty($this->default)) {
            $criteria->addCondition(" t.ruangan_id is null ");
        }

        if ($this->is_penerimaan_limbah) {
            $criteria->addCondition(" t.ruangan_id IN (SELECT sumberlimbah_id FROM logbookpenerimaanlimbahdaurulangdet_t GROUP BY sumberlimbah_id) ");
        }

        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.ruangan_lokasi)', strtolower($this->ruangan_lokasi), true);
        $criteria->compare('LOWER(g.gedung_nama)', strtolower($this->gedung_nama), true);
        $criteria->compare('LOWER(i.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(a.area_nama)', strtolower($this->area_nama), true);
        $criteria->addCondition('t.ruangan_aktif = TRUE');
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'ruangan_nama ASC'
            ]
        ));
    }

    public static function getRuanganItemsStatic() {
        return self::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama asc');
    }

    public static function arrRuanganId($instalasi_id = null){
            $res = [];
            
            $cri = new CDbCriteria;                        
            $cri->addCondition(" ruangan_aktif = true ");
            if (!empty($instalasi_id)){
                $cri->addCondition(" instalasi_id = ".$instalasi_id);
            }
            $cri->order = " ruangan_nama ASC ";
            $load = self::model()->findAll($cri);
            
            if (!empty($load)){
                foreach($load as $key => $val){
                    $res[$val->ruangan_id] = $val->ruangan_nama;
                }
            }
            
            return $res;
        }

    
    public static function getRuanganByInstalasiNoUrut($instalasi = '') {
        if (!empty($instalasi))
            return RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi), array('condition' => 'ruangan_aktif=TRUE', 'order' => 'ruangan_nourut'));
        else
            return array();
    }

    public function searchRuanganInstalasiFarmasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addCondition('instalasi_id = ' . Params::INSTALASI_ID_FARMASI);
        $criteria->addCondition('ruangan_aktif is true');
        $criteria->order = "ruangan_id ASC";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
