<?php

/**
 * This is the model class for table "spesimen_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * 
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'spesimen_t':
 * @property integer $spesimen_id
 * @property integer $penilaian_kelayakan_spesimen_id
 * @property integer $samplelab_id
 * @property integer $tindakanpelayanan_id
 * @property string $no_spesimen
 * @property string $waktu_pengambilan_spesimen
 * @property string $status
 * @property string $kualitas_spesimen
 * @property string $alasan
 *
 * The followings are the available model relations:
 * @property PenialianKelayakanSpesimenT $penilaianKelayakanSpesimen
 * @property TindakanpelayananT $tindakanpelayanan
 */
class SpesimenT extends CActiveRecord {

    public $pemeriksaanlab_nama, $samplelab_nama, $daftartindakan_nama, $statusspesimen, $create_time;
    public $no_rekam_medik, $nama_pasien, $ruangan_asal, $jenis_spesimen, $jenis_pemeriksaan;
    public $ruangan_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpesimenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'spesimen_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('spesimen_id', 'required'),
            array('spesimen_id, penilaian_kelayakan_spesimen_id, samplelab_id, tindakanpelayanan_id', 'numerical', 'integerOnly' => true),
            array('no_spesimen, status, kualitas_spesimen', 'length', 'max' => 100),
            array('waktu_pengambilan_spesimen, alasan, pemeriksaanlab_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('spesimen_id, penilaian_kelayakan_spesimen_id, samplelab_id, tindakanpelayanan_id, no_spesimen, waktu_pengambilan_spesimen, status, kualitas_spesimen, alasan, pemeriksaanlab_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'penilaianKelayakanSpesimen' => array(self::BELONGS_TO, 'PenialianKelayakanSpesimenT', 'penilaian_kelayakan_spesimen_id'),
            'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
            'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'spesimen_id' => 'Spesimen ID',
            'penilaian_kelayakan_spesimen_id' => 'Penilaian Kelayakan Spesimen',
            'samplelab_id' => 'Samplelab',
            'tindakanpelayanan_id' => 'Tindakanpelayanan',
            'no_spesimen' => 'No Spesimen',
            'waktu_pengambilan_spesimen' => 'Waktu Pengambilan Spesimen',
            'status' => 'Status',
            'kualitas_spesimen' => 'Kualitas Spesimen',
            'alasan' => 'Alasan',
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

        if (!empty($this->spesimen_id)) {
            $criteria->addCondition('spesimen_id = ' . $this->spesimen_id);
        }
        if (!empty($this->penilaian_kelayakan_spesimen_id)) {
            $criteria->addCondition('penilaian_kelayakan_spesimen_id = ' . $this->penilaian_kelayakan_spesimen_id);
        }
        if (!empty($this->samplelab_id)) {
            $criteria->addCondition('samplelab_id = ' . $this->samplelab_id);
        }
        if (!empty($this->tindakanpelayanan_id)) {
            $criteria->addCondition('tindakanpelayanan_id = ' . $this->tindakanpelayanan_id);
        }
        $criteria->compare('LOWER(no_spesimen)', strtolower($this->no_spesimen), true);
        $criteria->compare('LOWER(waktu_pengambilan_spesimen)', strtolower($this->waktu_pengambilan_spesimen), true);
        $criteria->compare('LOWER(status)', strtolower($this->status), true);
        $criteria->compare('LOWER(kualitas_spesimen)', strtolower($this->kualitas_spesimen), true);
        $criteria->compare('LOWER(alasan)', strtolower($this->alasan), true);

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
     * Pencarian dialog pada pengiriman spesimen
     * @author Andyka Putra <andykaputra@.com>
     */
    public function searchDialog() {
        
        //Mencari spesimen yang dibatalkan
        $criteria = new CDbCriteria;
        $criteria->addCondition('batalpengiriman_id IS NOT NULL');
        $criteria->addCondition('isterima IS FALSE');
//        $criteria->join = "LEFT JOIN spesimen_t ON "
        $cekSpesimen = PengirimanspesimenT::model()->findAll($criteria);
        $pengirimanspesimen_id = array();

        foreach ($cekSpesimen as $val):
            $pengirimanspesimen_id[] = $val->pengirimanspesimen_id;
        endforeach;
        
        //Spesimen_id yang ada di pengirimanspesimendet_t berarti udah dikirim
        //Kriteria kedua ini menghilangkan pengirimanspesimen_id di pengirimanspesimendet_t, agar spesimen yang dibatalkan dapat ditampilkan kembali
        $criteria2 = new CDbCriteria;
        $criteria2->addNotInCondition('pengirimanspesimen_id',$pengirimanspesimen_id);
        
        $cekPengiriman = PengirimanspesimendetT::model()->findAll($criteria2);
        $spesimen = array();

        foreach ($cekPengiriman as $value):
            $spesimen[] = $value->spesimen_id;
        endforeach;
        
        //Pencarian spesimen yang tidak ada di pengirimanspesimendet_t
        $criteria3 = new CDbCriteria;
        $criteria3->addNotInCondition('t.spesimen_id',$spesimen);
        $criteria3->addCondition('t.tindakanpelayanan_id IS NOT NULL');
        $criteria3->select = "t.*, pasien.nama_pasien, pasien.no_rekam_medik, daftar.daftartindakan_nama, sampel.samplelab_nama, ruangan.ruangan_nama";
        $criteria3->join = 'LEFT JOIN penialian_kelayakan_spesimen_t p ON t.penilaian_kelayakan_spesimen_id = p.penilaian_kelayakan_spesimen_id '
                            . 'LEFT JOIN pasienmasukpenunjang_t penunjang on p.pasienmasukpenunjang_id = penunjang.pasienmasukpenunjang_id '
                            . 'LEFT JOIN ruangan_m ruangan on ruangan.ruangan_id = penunjang.ruanganasal_id '
                            . 'LEFT JOIN pasien_m pasien on pasien.pasien_id = penunjang.pasien_id '
                            . 'LEFT JOIN tindakanpelayanan_t tindakan on t.tindakanpelayanan_id = tindakan.tindakanpelayanan_id '
                            . 'LEFT JOIN daftartindakan_m daftar on daftar.daftartindakan_id = tindakan.daftartindakan_id '
                            . 'LEFT JOIN samplelab_m sampel on sampel.samplelab_id = t.samplelab_id ';
        $criteria3->addCondition('p.pasienmasukpenunjang_id IS NOT NULL');
        $criteria3->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria3->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria3->compare('LOWER(t.no_spesimen)', strtolower($this->no_spesimen), true);
        $criteria3->compare('LOWER(daftar.daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria3->compare('LOWER(sampel.samplelab_nama)', strtolower($this->samplelab_nama), true);
        $criteria3->compare('LOWER(t.status)', strtolower($this->status), true);
        $criteria3->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria3->order = "t.waktu_pengambilan_spesimen desc, t.spesimen_id asc";
        if(!empty($this->waktu_pengambilan_spesimen)){
            $pengkajianaskep_tgl = $this->getKonverviDateRange($this->waktu_pengambilan_spesimen);
            $criteria3->addBetweenCondition('DATE(t.waktu_pengambilan_spesimen)', $pengkajianaskep_tgl[0]." 00:00:00", $pengkajianaskep_tgl[1]." 23:59:59");
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria3,
        ));
    }
    
    /**
     * Konversi tanggal
     * @param type $tgl
     * @return type
     */
    public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dari widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
}
