<?php

/**
 * This is the model class for table "permintaandarah_t".
 *
 * The followings are the available columns in table 'permintaandarah_t':
 * @property integer $permintaandarah_id
 * @property string $tglpermintaan
 * @property string $no_permintaandarah
 * @property string $jenispermintaan
 * @property string $tglren_transfusi
 * @property string $sd_tglrentransfusi
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruanganpemesan_id
 * @property integer $pegpemesan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $peg_pengambilsampel_id
 * @property string $tglpengambilansampel
 * @property string $no_peng_sampel
 * @property string $pernah_transfusi
 * @property string $reaksi_transfusi
 * @property string $gejala_transfusi
 * @property string $platelet_refractoriness
 * @property integer $dpjp_id
 *   
 * 
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
class PermintaandarahT extends CActiveRecord {

    public $is_tidak, $dokter_nama, $pegawai_id, $pegawai_nama, $pegawai_penerima_nama, $petugas_id, $pengambilsampel_nama;    

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'permintaandarah_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tglpermintaan, no_permintaandarah, jenispermintaan, pasien_id, pendaftaran_id, ruanganpemesan_id, pegpemesan_id, create_time, create_loginpemakai_id, create_ruangan, pernah_transfusi, reaksi_transfusi, gejala_transfusi', 'required'),
            array('pasien_id, pendaftaran_id, ruanganpemesan_id, pegpemesan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, peg_pengambilsampel_id, dpjp_id', 'numerical', 'integerOnly' => true),
            array('no_permintaandarah, gejala_transfusi, platelet_refractoriness', 'length', 'max' => 50),
            array('jenispermintaan, pernah_transfusi, reaksi_transfusi', 'length', 'max' => 10),
            array('no_peng_sampel', 'length', 'max' => 100),
            array('update_time, tglpengambilansampel, diagnosis, no_hp_dokter, no_formulir', 'safe'),
            array('riwayat_alergi, riwayat_alergijenis', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('permintaandarah_id, tglpermintaan, no_permintaandarah, jenispermintaan, pasien_id, pendaftaran_id, ruanganpemesan_id, pegpemesan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, peg_pengambilsampel_id, tglpengambilansampel, no_peng_sampel, pernah_transfusi, reaksi_transfusi, gejala_transfusi, platelet_refractoriness, dpjp_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
            'pegpemesan' => array(self::BELONGS_TO, 'PegawaiM', 'pegpemesan_id'),
            'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
            'pengambilsampel' => array(self::BELONGS_TO, 'PegawaiM', 'peg_pengambilsampel_id'),
		);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'permintaandarah_id' => 'Permintaandarah',
            'tglpermintaan' => 'Tglpermintaan',
            'no_permintaandarah' => 'No Permintaandarah',
            'jenispermintaan' => 'Jenis Permintaan',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'ruanganpemesan_id' => 'Ruanganpemesan',
            'pegpemesan_id' => 'Pegpemesan',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'peg_pengambilsampel_id' => 'Peg Pengambilsampel',
            'tglpengambilansampel' => 'Tglpengambilansampel',
            'no_peng_sampel' => 'No Peng Sampel',
            'pernah_transfusi' => 'Pernah Transfusi',
            'reaksi_transfusi' => 'Reaksi Transfusi',
            'gejala_transfusi' => 'Gejala Transfusi',
            'platelet_refractoriness' => 'Platelet Refractoriness',
            'dpjp_id' => 'Dpjp',
            'is_tidak' => '',
            'petugas_id' => 'Petugas',
            'riwayat_alergi' => 'Riwayat Alergi',
            'riwayat_alergijenis' => 'Alergi',
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

        if (!empty($this->permintaandarah_id)) {
            $criteria->addCondition('t.permintaandarah_id = ' . $this->permintaandarah_id);
        }
        $criteria->compare('LOWER(t.tglpermintaan)', strtolower($this->tglpermintaan), true);
        $criteria->compare('LOWER(t.no_permintaandarah)', strtolower($this->no_permintaandarah), true);
        $criteria->compare('LOWER(t.jenispermintaan)', strtolower($this->jenispermintaan), true);
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('t.pasien_id = ' . $this->pasien_id);
        }
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('t.pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->ruanganpemesan_id)) {
            $criteria->addCondition('t.ruanganpemesan_id = ' . $this->ruanganpemesan_id);
        }
        if (!empty($this->pegpemesan_id)) {
            $criteria->addCondition('t.pegpemesan_id = ' . $this->pegpemesan_id);
        }

        $criteria->compare('LOWER(t.create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(t.update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('t.create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('t.update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('t.create_ruangan = ' . $this->create_ruangan);
        }
        if (!empty($this->peg_pengambilsampel_id)) {
            $criteria->addCondition('t.peg_pengambilsampel_id = ' . $this->peg_pengambilsampel_id);
        }
        $criteria->compare('LOWER(t.tglpengambilansampel)', strtolower($this->tglpengambilansampel), true);
        $criteria->compare('LOWER(t.no_peng_sampel)', strtolower($this->no_peng_sampel), true);
        $criteria->compare('LOWER(t.pernah_transfusi)', strtolower($this->pernah_transfusi), true);
        $criteria->compare('LOWER(t.reaksi_transfusi)', strtolower($this->reaksi_transfusi), true);
        $criteria->compare('LOWER(t.gejala_transfusi)', strtolower($this->gejala_transfusi), true);
        $criteria->compare('LOWER(t.platelet_refractoriness)', strtolower($this->platelet_refractoriness), true);
        if (!empty($this->dpjp_id)) {
            $criteria->addCondition('t.dpjp_id = ' . $this->dpjp_id);
        }

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
     * pencarian yang ditampilkan pada dialog
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition('isbatal = false');
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * untuk memfilter hasil cetak
     * @return \CActiveDataProvider
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
    * memfilter dialog, yang digunakan pada transaksi uji kompatibilitas
    * @return \CActiveDataProvider
    */
   public function searchDialogForUjiKompatibilitas()
   {
       // Warning: Please modify the following code to remove attributes that
       // should not be searched.

       $criteria=$this->criteriaSearch();
       $criteria->join = " JOIN ujidarahpasien_t uji ON (uji.permintaandarah_id = t.permintaandarah_id) AND uji.metodedarah_id = '".Params::METODE_DARAH_ID_SLIDE_TEST."' "
                       . " LEFT JOIN ujidarahpasien_t ujitube ON (ujitube.permintaandarah_id = t.permintaandarah_id) AND ujitube.metodedarah_id = '".Params::METODE_DARAH_ID_TUBE_TEST."'"
                       . " LEFT JOIN ujikompatibilitas_t komp ON komp.ujidarahpasien_id = ujitube.ujidarahpasien_id ";
       $criteria->addCondition(" komp.ujikompatibilitas_id is null ");
       $criteria->addCondition('isbatal = false');

       $criteria->limit=10;

       return new CActiveDataProvider($this, array(
               'criteria'=>$criteria,
       ));
    }       
}
