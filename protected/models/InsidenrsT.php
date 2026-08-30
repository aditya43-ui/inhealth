<?php

/**
 * This is the model class for table "insidenrs_t".
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @package application.models
 *
 * The followings are the available columns in table 'insidenrs_t':
 * @property integer $insidenrs_id
 * @property integer $penelitian_id
 * @property integer $pendaftaran_id
 * @property string $insidenrs_nomor
 * @property string $insidenrs_tgllapor
 * @property string $insidenrs_tglinsiden
 * @property string $insidenrs_nama
 * @property string $insidenrs_kronologis
 * @property string $insidenrs_jenis
 * @property string $insidenrs_pelapor
 * @property string $insidenrs_menyangkutpasien
 * @property string $diagnosa_lainnya
 * @property integer $unitkerjatempat_id
 * @property integer $unitkerjapenyebab_id
 * @property integer $lokasikejadian_id
 * @property string $insidenrs_akibat
 * @property string $tindakan_setelah
 * @property string $tindakan_oleh
 * @property string $tindakan_olehlainnya
 * @property boolean $terjadiunitlain
 * @property string $tindakan_pencegahan
 * @property string $insidenrs_grading
 * @property string $insidenrs_tglterima
 * @property string $insidenrs_tglgrading
 * @property integer $pegawaipelapor_id
 * @property integer $penelitipelapor_id
 * @property integer $penerimalaporan_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InsidenrsT extends CActiveRecord {

    public $penelitian_nomor_penelitian, $ketua_penelitian, $instalasi_penelitian, $golongan_penelitian, $penjamin,
            $judul_penelitian, $kategori_penelitian, $jenis_penelitian, $unitkerja, $ruangan_nama;
    public $unitkerjatempat_nama, $unitkerjapenyebab_nama, $lokasikejadian_nama, $adverseevent_nama, $adverseevent_id,
            $nama_pasien, $penjamin_nama, $tgl_pendaftaran, $adverseevent_nomor, $no_rekam_medik, $pasien_id, $umur, $jeniskelamin, $ruangan_pasien, $penanggungbiaya,
            $diagnosa, $tanggalmasukrs, $diagnosa_nama, $diagnosa_id_2, $diagnosa_nama_2, $diagnosa_lainnya1, $diagnosa_lainnya2;
    public $terjadiunitlain_ya, $terjadiunitlain_tidak;
    public $instalasi_id, $ruangan_id, $no_rekammedik, $tingkatrisiko_id, $tipeinsiden, $tanggal_awal, $tanggal_awal2, $tanggal_akhir, $tanggal_akhir2, $status_laporan, $perubahan_ada;
    public $mengetahui_nama, $tipeinsidensebelumnya, $gradingrisiko, $tipeLapor, $tipeInsiden, $nama_pelapor, $mengetahui_kepalaunitpenyebab_nama, $unitkerja_id, $ruanganpenyebab_nama;
    public $ruangan_id_2, $ruangan_nama_2, $instalasi_nama, $kategoripenolakan;
    public $penanggungjawab_biaya, $mengetahui_kepalainstalasi_kejadian_nama, $mengetahui_kepalainstalasi_penyebab_nama;
    public $penanggungjawab_biaya2;
    public $penanggungjawabpasien_lainnya_ket;
    public $penanggungjawabpasien_lainnya_ket2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenrsT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'insidenrs_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('insidenrs_nomor, insidenrs_tgllapor, insidenrs_jenis, lokasikejadian_id, '
                . 'insidenrs_tglinsiden, insidenrs_nama, insidenrs_jenis, insidenrs_pelapor, create_time, '
                . 'create_loginpemakai_id, insidenrs_menyangkutpasien, create_ruangan, insidenrs_akibat, '
                . 'tindakan_setelah', 'required'),
            array('jenis_kelamin', 'required'),
            array('penelitian_id, pendaftaran_id, lokasikejadian_id, pegawaipelapor_id, penelitipelapor_id, penerimalaporan_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('insidenrs_nomor', 'length', 'max' => 20),
            array('insidenrs_nama, insidenrs_jenis, insidenrs_pelapor, insidenrs_menyangkutpasien, insidenrs_akibat, tindakan_oleh, tindakan_olehlainnya', 'length', 'max' => 100),
            array('insidenrs_grading', 'length', 'max' => 50),
            array('mengetahui_kepalainstalasi_kejadian_id, mengetahui_kepalainstalasi_penyebab_id, kejadian_diunitlain, mengetahui_kepalaunitpenyebab_id,nama_pelapor,insidenrs_kronologis, tindakan_setelah, terjadiunitlain, tindakan_pencegahan, insidenrs_tglterima, insidenrs_tglgrading, update_time,tindakan_olehdokter,tindakan_olehperawat,tindakan_olehpetugaslain, mengetahui_kepalaunitpenyebab_id, nama_pelapor, penanggungjawab_biaya, penanggungjawab_biaya2, penanggungjawabpasien_lainnya_ket, penanggungjawabpasien_lainnya_ket2, diagnosa_lainnya', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('mengetahui_kepalaunitpenyebab_id,nama_pelapor,insidenrs_id, penelitian_id, pendaftaran_id, insidenrs_nomor, insidenrs_tgllapor, insidenrs_tglinsiden, insidenrs_nama, insidenrs_kronologis, insidenrs_jenis, insidenrs_pelapor, insidenrs_menyangkutpasien, unitkerjatempat_id, unitkerjapenyebab_id, lokasikejadian_id, insidenrs_akibat, tindakan_setelah, tindakan_oleh, tindakan_olehlainnya, terjadiunitlain, tindakan_pencegahan, insidenrs_grading, insidenrs_tglterima, insidenrs_tglgrading, pegawaipelapor_id, penelitipelapor_id, penerimalaporan_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, diagnosa_lainnya', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lokasikejadian' => array(self::BELONGS_TO, 'RuanganM', 'lokasikejadian_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'unitkerjatempat' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerjatempat_id'),
            'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
            'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
            'instalasiinsiden' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'ruanganinsiden' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'ruanganpenyebab' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpenyebab_id'),
            'kepalainstalasikejadian' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_kepalainstalasi_kejadian_id'),
            'kepalainstalasipenyebab' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_kepalainstalasi_penyebab_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'insidenrs_id' => 'Insidenrs',
            'penelitian_id' => 'Penelitian',
            'pendaftaran_id' => 'Pendaftaran',
            'insidenrs_nomor' => 'Insidenrs Nomor',
            'insidenrs_tgllapor' => 'Insidenrs Tgllapor',
            'insidenrs_tglinsiden' => 'Insidenrs Tglinsiden',
            'insidenrs_nama' => 'Insidenrs Nama',
            'insidenrs_kronologis' => 'Insidenrs Kronologis',
            'insidenrs_jenis' => 'Insidenrs Jenis',
            'insidenrs_pelapor' => 'Insidenrs Pelapor',
            'insidenrs_menyangkutpasien' => 'Insidenrs Menyangkutpasien',
            'unitkerjatempat_id' => 'Unitkerjatempat',
            'unitkerjapenyebab_id' => 'Unitkerjapenyebab',
            'lokasikejadian_id' => 'Lokasikejadian',
            'insidenrs_akibat' => 'Insidenrs Akibat',
            'tindakan_setelah' => 'Tindakan Setelah',
            'tindakan_oleh' => 'Tindakan Oleh',
            'tindakan_olehlainnya' => 'Tindakan Olehlainnya',
            'terjadiunitlain' => 'Terjadiunitlain',
            'tindakan_pencegahan' => 'Tindakan Pencegahan',
            'insidenrs_grading' => 'Insidenrs Grading',
            'insidenrs_tglterima' => 'Insidenrs Tglterima',
            'insidenrs_tglgrading' => 'Insidenrs Tglgrading',
            'pegawaipelapor_id' => 'Pegawaipelapor',
            'penelitipelapor_id' => 'Penelitipelapor',
            'penerimalaporan_id' => 'Penerimalaporan',
            'diagnosa_lainnya' => 'Diagnosa Lainnya',
            'mengetahui_id' => 'Mengetahui',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'penanggungjawab_biaya' => 'Penanggung Biaya Pasien',
            'penanggungjawab_biaya2' => 'Penanggung Biaya Pasien',
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

        $criteria->compare('insidenrs_id', $this->insidenrs_id);
        $criteria->compare('penelitian_id', $this->penelitian_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('insidenrs_nomor', $this->insidenrs_nomor, true);
        $criteria->compare('insidenrs_tgllapor', $this->insidenrs_tgllapor, true);
        $criteria->compare('insidenrs_tglinsiden', $this->insidenrs_tglinsiden, true);
        $criteria->compare('insidenrs_nama', $this->insidenrs_nama, true);
        $criteria->compare('insidenrs_kronologis', $this->insidenrs_kronologis, true);
        $criteria->compare('insidenrs_jenis', $this->insidenrs_jenis, true);
        $criteria->compare('insidenrs_pelapor', $this->insidenrs_pelapor, true);
        $criteria->compare('insidenrs_menyangkutpasien', $this->insidenrs_menyangkutpasien, true);
        $criteria->compare('unitkerjatempat_id', $this->unitkerjatempat_id);
        $criteria->compare('unitkerjapenyebab_id', $this->unitkerjapenyebab_id);
        $criteria->compare('lokasikejadian_id', $this->lokasikejadian_id);
        $criteria->compare('insidenrs_akibat', $this->insidenrs_akibat, true);
        $criteria->compare('tindakan_setelah', $this->tindakan_setelah, true);
        $criteria->compare('tindakan_oleh', $this->tindakan_oleh, true);
        $criteria->compare('tindakan_olehlainnya', $this->tindakan_olehlainnya, true);
        $criteria->compare('terjadiunitlain', $this->terjadiunitlain);
        $criteria->compare('tindakan_pencegahan', $this->tindakan_pencegahan, true);
        $criteria->compare('insidenrs_grading', $this->insidenrs_grading, true);
        $criteria->compare('insidenrs_tglterima', $this->insidenrs_tglterima, true);
        $criteria->compare('insidenrs_tglgrading', $this->insidenrs_tglgrading, true);
        $criteria->compare('diagnosa_lainnya', $this->diagnosa_lainnya, true);
        $criteria->compare('pegawaipelapor_id', $this->pegawaipelapor_id);
        $criteria->compare('penelitipelapor_id', $this->penelitipelapor_id);
        $criteria->compare('penerimalaporan_id', $this->penerimalaporan_id);
        $criteria->compare('mengetahui_id', $this->mengetahui_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian Informasi Laporan Insiden RS
     * @author Andyka Putra <andykaputra@.com>
     * @author Yusuf Putra Anugrah <yusufputra@.com>
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();
        $criteria->select = "t.ruangan_id, t.instalasi_id, t.*,t.insidenrs_id, gradinginsidenrs.tingkatrisiko_id, gradinginsidenrs.gradinginsidenrs_id, gradinginsidenrs.tglverifikasi_unit, gradinginsidenrs.statuslaporan, gradinginsidenrs.tgl_kirimpelaporan,pendaftaran.pendaftaran_id, pasien.pasien_id, pasien.no_rekam_medik, gradinginsidenrs.gradingrisiko";
        $criteria->join = " LEFT JOIN gradinginsidenrs_t gradinginsidenrs ON t.insidenrs_id = gradinginsidenrs.insidenrs_id "
                . " LEFT JOIN pendaftaran_t pendaftaran ON t.pendaftaran_id = pendaftaran.pendaftaran_id "
                . " LEFT JOIN pasien_m pasien ON pendaftaran.pasien_id = pasien.pasien_id ";

        $criteria->group = $criteria->select;

        $criteria->addCondition('t.is_batal = false');
        if ($this->tipeInsiden == true) {
            $criteria->addBetweenCondition('DATE(t.insidenrs_tglinsiden)', $this->tanggal_awal2, $this->tanggal_akhir2);
        }
        if ($this->tipeLapor == true) {
            $criteria->addBetweenCondition('DATE(t.insidenrs_tgllapor)', $this->tanggal_awal, $this->tanggal_akhir);
        }
        if (!empty($this->lokasikejadian_id)) {
            $criteria->addCondition("t.lokasikejadian_id = '" . $this->lokasikejadian_id . "' ");
        } else {
            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KMKP) {
                
            } else {
                $criteria->addCondition("t.lokasikejadian_id = '" . Yii::app()->user->getState('ruangan_id') . "' OR ruanganpenyebab_id = " . Yii::app()->user->getState('ruangan_id'));
            }
        }

        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("pendaftaran.instalasi_id = '" . $this->instalasi_id . "' ");
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition("pendaftaran.ruangan_id = '" . $this->ruangan_id . "' ");
        }

        if (!empty($this->tingkatrisiko_id)) {
            $criteria->addCondition("gradinginsidenrs.tingkatrisiko_id = '" . $this->tingkatrisiko_id . "' ");
        }

        $criteria->order = 't.insidenrs_tgllapor DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian Print Informasi Laporan Insiden RS
     * @author Andyka Putra <andykaputra@.com>
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();
        $criteria->select = "t.ruangan_id, "
                . "t.instalasi_id, "
                . "t.*,t.insidenrs_id, "
                . "gradinginsidenrs.tingkatrisiko_id, "
                . "gradinginsidenrs.gradinginsidenrs_id, "
                . "gradinginsidenrs.tglverifikasi_unit, "
                . "gradinginsidenrs.statuslaporan, "
                . "gradinginsidenrs.tgl_kirimpelaporan, "
                . "pendaftaran.pendaftaran_id, "
                . "pasien.pasien_id, "
                . "pasien.no_rekam_medik, "
                . "gradinginsidenrs.gradingrisiko";
        $criteria->join = " LEFT JOIN gradinginsidenrs_t gradinginsidenrs ON t.insidenrs_id = gradinginsidenrs.insidenrs_id "
                . " LEFT JOIN pendaftaran_t pendaftaran ON t.pendaftaran_id = pendaftaran.pendaftaran_id "
                . " LEFT JOIN pasien_m pasien ON pendaftaran.pasien_id = pasien.pasien_id ";

        $criteria->group = $criteria->select;

        $criteria->addCondition('t.is_batal = false');
        if ($this->tipeInsiden == true) {
            $criteria->addBetweenCondition('DATE(t.insidenrs_tglinsiden)', $this->tanggal_awal2, $this->tanggal_akhir2);
        }
        if ($this->tipeLapor == true) {
            $criteria->addBetweenCondition('DATE(t.insidenrs_tgllapor)', $this->tanggal_awal, $this->tanggal_akhir);
        }
        if (!empty($this->lokasikejadian_id)) {
            $criteria->addCondition("t.lokasikejadian_id = '" . $this->lokasikejadian_id . "' ");
        } else {
            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KMKP) {
                
            } else {
                $criteria->addCondition("t.lokasikejadian_id = '" . Yii::app()->user->getState('ruangan_id') . "' OR ruanganpenyebab_id = " . Yii::app()->user->getState('ruangan_id'));
            }
        }

        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("pendaftaran.instalasi_id = '" . $this->instalasi_id . "' ");
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition("pendaftaran.ruangan_id = '" . $this->ruangan_id . "' ");
        }

        if (!empty($this->tingkatrisiko_id)) {
            $criteria->addCondition("gradinginsidenrs.tingkatrisiko_id = '" . $this->tingkatrisiko_id . "' ");
        }

        $criteria->order = 't.insidenrs_tgllapor DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Digunakan untuk menampilkan button grading
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getGrading($insidenrs_id, $model = null) {
        $cekGrading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        $btn = '';
        if ($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')) {
            if (!empty($cekGrading)) {
                if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_BIRU)) {
                    $btn = "btn btn-info btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_MERAH)) {
                    $btn = "btn btn-danger btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_KUNING)) {
                    $btn = "btn btn-gold btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_HIJAU)) {
                    $btn = "btn btn-success btn-sm";
                }

                $grading .= CHtml::Link('<button class="' . $btn . '"> <b> ' . ucfirst(strtolower($cekGrading->gradingrisiko)) . ' </b>  </button>', Yii::app()->controller->createUrl("grading", array('insidenrs_id' => $insidenrs_id, "frame" => 3, "popup" => "true")), array("class" => "",
                            "target" => "iframeGrading",
                            "onclick" => "$(\"#dialogGrading\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melihat Grading Risiko",
                ));
            } elseif (empty($cekGrading)) {
                $grading .= CHtml::Link('<button class="btn btn-black btn-sm"> <b> Grading </b> </button>', Yii::app()->controller->createUrl("grading", array('insidenrs_id' => $insidenrs_id, "frame" => 3, "popup" => "true")), array("class" => "",
                            "target" => "iframeGrading",
                            "onclick" => "$(\"#dialogGrading\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melakukan Grading Risiko",
                ));
            }
        } else {
            if (!empty($cekGrading)) {
                if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_BIRU)) {
                    $btn = "btn btn-info btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_MERAH)) {
                    $btn = "btn btn-danger btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_KUNING)) {
                    $btn = "btn btn-gold btn-sm";
                } else if (strtoupper($cekGrading->gradingrisiko) == strtoupper(Params::GRADING_HIJAU)) {
                    $btn = "btn btn-success btn-sm";
                }
                $grading = CHtml::Link('<button class="' . $btn . '"> <b> ' . ucfirst(strtolower($cekGrading->gradingrisiko)) . ' </b>  </button>', 'javascript:;', array("class" => "",
                            "onclick" => "myAlert('Hanya Pegawai <b>" . $model->mengetahui->namaLengkap . "</b> yang bisa mengakses fitur ini');",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melakukan Grading Risiko",
                ));
            } elseif (empty($cekGrading)) {
                $grading .= CHtml::Link('<button class="btn btn-black btn-sm"> <b> Grading </b>  </button>', 'javascript:;', array("class" => "",
                            "onclick" => "myAlert('Hanya Pegawai <b>" . $model->mengetahui->namaLengkap . "</b> yang bisa mengakses fitur ini');",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melakukan Grading Risiko",
                ));
            }
        }

        echo $grading;
    }

    /**
     * Digunakan untuk menampilkan button verifikasi
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getVerifikasi($insidenrs_id) {
        $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        if (!empty($cek)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
            $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
            $cekGrading = GradinginsidenrsT::model()->find($criteria);

            if (!empty($cekGrading)) {
                $grading .= '<button class="btn btn-green btn-sm" name="yt1">Verifikasi</button>';
            } elseif (empty($cekGrading)) {
                if ($cek->grader1 == Yii::app()->user->getState('pegawai_id')) {
                    $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="setVerifikasi(' . $insidenrs_id . '); "> <b> Verifikasi </b> </button>';
                } else {
                    $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="cekVerifikator(); "> <b> Verifikasi </b> </button>';
                }
            }
        } else {
            $grading .= '<button class="btn btn-black btn-sm" name="yt1" disabled="true"> <b> Verifikasi </b> </button>';
        }
        echo $grading;
    }

    /**
     * Digunakan untuk menampilkan button status laporan
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getStatus($insidenrs_id) {
        $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        if (!empty($cek)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
            $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
            $cekVerifikasi = GradinginsidenrsT::model()->find($criteria);

            if (!empty($cekVerifikasi)) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
                $criteria->addCondition('tgl_kirimpelaporan IS NOT NULL');
                $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
                $cekGrading = GradinginsidenrsT::model()->find($criteria);
                if (!empty($cekGrading)) {
                    if ($cekGrading->statuslaporan == 'Menunggu Persetujuan') {
                        $grading .= '<button class="btn btn-gold btn-sm" name="yt1"> <b> Menunggu Persetujuan </b> </button>';
                    } else if ($cekGrading->statuslaporan == 'Ditolak') {
                        $grading .= CHtml::Link("<button class ='btn btn-sm btn-red'> <b>  Ditolak </b> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/detailDitolak", array("insidenrs_id" => $cekGrading->insidenrs_id)), array(
                                    "class" => "",
                                    "target" => "iframe5",
                                    "onclick" => "$(\"#dialogDitolak\").dialog(\"open\");",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Menyetujui",
                        ));
                    } else if ($cekGrading->statuslaporan == 'Disetujui') {
                        $grading .= '<button class="btn btn-green btn-sm" name="yt1">Disetujui</button>';
                    }
                } elseif (empty($cekGrading)) {
                    if ($cek->grader1 == Yii::app()->user->getState('pegawai_id')) {
                        $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="setStatus(' . $insidenrs_id . '); "> <b> Kirim Laporan </b> </button>';
                    } else {
                        $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="cekKirimlaporan(); ">  <b> Kirim Laporan </b> </button>';
                    }
                }
            } elseif (empty($cekVerifikasi)) {
                $grading .= '<button class="btn btn-black btn-sm" name="yt1" disabled="true">  <b>Kirim Laporan </b> </button>';
            }
        } else {
            $grading .= '<button class="btn btn-black btn-sm" name="yt1" disabled="true">  <b> Kirim Laporan </b> </button>';
        }
        echo $grading;
    }

    /**
     * Digunakan untuk menampilkan grading (hanya text untuk cetak data)
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getGradingPrint($insidenrs_id) {
        $cekGrading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        if (!empty($cekGrading)) {
            $grading .= $cekGrading->gradingrisiko;
        } elseif (empty($cekGrading)) {
            $grading .= 'grading';
        }

        echo $grading;
    }

    /**
     * Digunakan untuk menampilkan status verifikasi (hanya text untuk cetak data)
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getVerifikasiPrint($insidenrs_id) {
        $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        if (!empty($cek)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
            $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
            $cekGrading = GradinginsidenrsT::model()->find($criteria);

            if (!empty($cekGrading)) {
                $grading .= 'Sudah Verifikasi';
            } elseif (empty($cekGrading)) {
                $grading .= 'Belum Verifikasi';
            }
        } else {
            $grading .= '';
        }
        echo $grading;
    }

    /**
     * Digunakan untuk menampilkan status laporan (hanya text untuk cetak data)
     * @author Andyka Putra <andykaputra@.com>
     * @param type $insidenrs_id
     */
    public function getStatusPrint($insidenrs_id) {
        $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = '';
        if (!empty($cek)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
            $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
            $cekVerifikasi = GradinginsidenrsT::model()->find($criteria);

            if (!empty($cekVerifikasi)) {

                $criteria = new CDbCriteria();
                $criteria->addCondition('tglverifikasi_unit IS NOT NULL');
                $criteria->addCondition('tgl_kirimpelaporan IS NOT NULL');
                $criteria->addCondition("insidenrs_id = " . $insidenrs_id);
                $cekGrading = GradinginsidenrsT::model()->find($criteria);
                if (!empty($cekGrading)) {
                    $grading .= 'Menunggu Persetujuan';
                } elseif (empty($cekGrading)) {
                    $grading .= 'Kirim Laporan';
                }
            } elseif (empty($cekVerifikasi)) {
                $grading .= '';
            }
        } else {
            $grading .= '';
        }
        echo $grading;
    }

}
