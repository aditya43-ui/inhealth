<?php

/**
 * This is the model class for table "mcu_pemeriksaankandungan_t".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'mcu_pemeriksaankandungan_t':
 * @property integer $checkup_kandungan_id
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $anamnesis
 * @property boolean $suami_ya
 * @property boolean $suami_tidak
 * @property integer $lama_pernikahan
 * @property integer $berapakali_pernikahan
 * @property string $haid
 * @property string $tgl_haid_terakhir
 * @property integer $siklus_haid
 * @property string $periode_siklus_haid
 * @property integer $menarehe_umur
 * @property integer $lama_haid
 * @property string $banyak_haid
 * @property string $haid_sakit
 * @property string $warna_haid
 * @property string $bau_haid
 * @property string $fluor
 * @property integer $berapa_lama
 * @property string $warna_fluor
 * @property string $banyak_fluor
 * @property string $bau_fluor
 * @property integer $jumlah_anak
 * @property integer $jumlah_anak_hidup
 * @property integer $jumlah_anak_mati
 * @property integer $umur_anak_kecil
 * @property string $partus
 * @property string $abortus
 * @property boolean $kb_positif
 * @property boolean $kb_negatif
 * @property string $kb_keterangan
 * @property string $nama_penyakit_lama
 * @property string $anamnesia_keluarga
 * @property string $status_lokalis
 * @property string $abdomen
 * @property string $genitalis
 * @property string $diagnosis
 * @property integer $dokterpemeriksa_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class McuPemeriksaankandunganT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return McuPemeriksaankandunganT the static model class
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
        return 'mcu_pemeriksaankandungan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pendaftaran_id, pasien_id, lama_pernikahan, berapakali_pernikahan, siklus_haid, menarehe_umur, lama_haid, berapa_lama, jumlah_anak, jumlah_anak_hidup, jumlah_anak_mati, umur_anak_kecil, dokterpemeriksa_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('periode_siklus_haid, fluor', 'length', 'max' => 10),
            array('banyak_haid, haid_sakit, warna_haid, warna_fluor, banyak_fluor', 'length', 'max' => 30),
            array('bau_haid, bau_fluor', 'length', 'max' => 20),
            array('partus, abortus', 'length', 'max' => 100),
            array('kb_keterangan', 'length', 'max' => 15),
            array('tgl_pemeriksaan, anamnesis, suami_ya, suami_tidak, haid, tgl_haid_terakhir, kb_positif, kb_negatif, nama_penyakit_lama, anamnesia_keluarga, status_lokalis, abdomen, genitalis, diagnosis, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('checkup_kandungan_id, tgl_pemeriksaan, pendaftaran_id, pasien_id, anamnesis, suami_ya, suami_tidak, lama_pernikahan, berapakali_pernikahan, haid, tgl_haid_terakhir, siklus_haid, periode_siklus_haid, menarehe_umur, lama_haid, banyak_haid, haid_sakit, warna_haid, bau_haid, fluor, berapa_lama, warna_fluor, banyak_fluor, bau_fluor, jumlah_anak, jumlah_anak_hidup, jumlah_anak_mati, umur_anak_kecil, partus, abortus, kb_positif, kb_negatif, kb_keterangan, nama_penyakit_lama, anamnesia_keluarga, status_lokalis, abdomen, genitalis, diagnosis, dokterpemeriksa_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'dokterpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'checkup_kandungan_id' => 'Checkup Kandungan',
            'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'anamnesis' => 'Anamnesis',
            'suami_ya' => 'Suami Ya',
            'suami_tidak' => 'Suami Tidak',
            'lama_pernikahan' => 'Lama Pernikahan',
            'berapakali_pernikahan' => 'Berapakali Pernikahan',
            'haid' => 'Haid',
            'tgl_haid_terakhir' => 'Tgl. Haid Terakhir',
            'siklus_haid' => 'Siklus Haid',
            'periode_siklus_haid' => 'Periode Siklus Haid',
            'menarehe_umur' => 'Menarehe Umur',
            'lama_haid' => 'Lama Haid',
            'banyak_haid' => ' ',
            'haid_sakit' => 'Haid Sakit',
            'warna_haid' => 'Warna Haid',
            'bau_haid' => 'Aroma Berbau',
            'fluor' => 'Fluor',
            'berapa_lama' => 'Berapa Lama',
            'warna_fluor' => 'Warna Fluor',
            'banyak_fluor' => 'Jumlah Fluor',
            'bau_fluor' => 'Aroma Fluor',
            'jumlah_anak' => 'Jumlah Anak',
            'jumlah_anak_hidup' => 'Jumlah Anak Hidup',
            'jumlah_anak_mati' => 'Jumlah Anak Mati',
            'umur_anak_kecil' => 'Umur Anak Kecil',
            'partus' => 'Partus',
            'abortus' => 'Abortus',
            'kb_positif' => 'Kb Positif',
            'kb_negatif' => 'Kb Negatif',
            'kb_keterangan' => 'Kb Keterangan',
            'nama_penyakit_lama' => 'Nama Penyakit Lama',
            'anamnesia_keluarga' => 'Anamnesia Keluarga',
            'status_lokalis' => 'Status Lokalis',
            'abdomen' => 'Abdomen',
            'genitalis' => 'Genitalis',
            'diagnosis' => 'Diagnosis',
            'dokterpemeriksa_id' => 'Dokterpemeriksa',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->checkup_kandungan_id)) {
            $criteria->addCondition('checkup_kandungan_id = ' . $this->checkup_kandungan_id);
        }
        $criteria->compare('LOWER(tgl_pemeriksaan)', strtolower($this->tgl_pemeriksaan), true);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        $criteria->compare('LOWER(anamnesis)', strtolower($this->anamnesis), true);
        $criteria->compare('suami_ya', $this->suami_ya);
        $criteria->compare('suami_tidak', $this->suami_tidak);
        if (!empty($this->lama_pernikahan)) {
            $criteria->addCondition('lama_pernikahan = ' . $this->lama_pernikahan);
        }
        if (!empty($this->berapakali_pernikahan)) {
            $criteria->addCondition('berapakali_pernikahan = ' . $this->berapakali_pernikahan);
        }
        $criteria->compare('LOWER(haid)', strtolower($this->haid), true);
        $criteria->compare('LOWER(tgl_haid_terakhir)', strtolower($this->tgl_haid_terakhir), true);
        if (!empty($this->siklus_haid)) {
            $criteria->addCondition('siklus_haid = ' . $this->siklus_haid);
        }
        $criteria->compare('LOWER(periode_siklus_haid)', strtolower($this->periode_siklus_haid), true);
        if (!empty($this->menarehe_umur)) {
            $criteria->addCondition('menarehe_umur = ' . $this->menarehe_umur);
        }
        if (!empty($this->lama_haid)) {
            $criteria->addCondition('lama_haid = ' . $this->lama_haid);
        }
        $criteria->compare('LOWER(banyak_haid)', strtolower($this->banyak_haid), true);
        $criteria->compare('LOWER(haid_sakit)', strtolower($this->haid_sakit), true);
        $criteria->compare('LOWER(warna_haid)', strtolower($this->warna_haid), true);
        $criteria->compare('LOWER(bau_haid)', strtolower($this->bau_haid), true);
        $criteria->compare('LOWER(fluor)', strtolower($this->fluor), true);
        if (!empty($this->berapa_lama)) {
            $criteria->addCondition('berapa_lama = ' . $this->berapa_lama);
        }
        $criteria->compare('LOWER(warna_fluor)', strtolower($this->warna_fluor), true);
        $criteria->compare('LOWER(banyak_fluor)', strtolower($this->banyak_fluor), true);
        $criteria->compare('LOWER(bau_fluor)', strtolower($this->bau_fluor), true);
        if (!empty($this->jumlah_anak)) {
            $criteria->addCondition('jumlah_anak = ' . $this->jumlah_anak);
        }
        if (!empty($this->jumlah_anak_hidup)) {
            $criteria->addCondition('jumlah_anak_hidup = ' . $this->jumlah_anak_hidup);
        }
        if (!empty($this->jumlah_anak_mati)) {
            $criteria->addCondition('jumlah_anak_mati = ' . $this->jumlah_anak_mati);
        }
        if (!empty($this->umur_anak_kecil)) {
            $criteria->addCondition('umur_anak_kecil = ' . $this->umur_anak_kecil);
        }
        $criteria->compare('LOWER(partus)', strtolower($this->partus), true);
        $criteria->compare('LOWER(abortus)', strtolower($this->abortus), true);
        $criteria->compare('kb_positif', $this->kb_positif);
        $criteria->compare('kb_negatif', $this->kb_negatif);
        $criteria->compare('LOWER(kb_keterangan)', strtolower($this->kb_keterangan), true);
        $criteria->compare('LOWER(nama_penyakit_lama)', strtolower($this->nama_penyakit_lama), true);
        $criteria->compare('LOWER(anamnesia_keluarga)', strtolower($this->anamnesia_keluarga), true);
        $criteria->compare('LOWER(status_lokalis)', strtolower($this->status_lokalis), true);
        $criteria->compare('LOWER(abdomen)', strtolower($this->abdomen), true);
        $criteria->compare('LOWER(genitalis)', strtolower($this->genitalis), true);
        $criteria->compare('LOWER(diagnosis)', strtolower($this->diagnosis), true);
        if (!empty($this->dokterpemeriksa_id)) {
            $criteria->addCondition('dokterpemeriksa_id = ' . $this->dokterpemeriksa_id);
        }
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
        }

        return $criteria;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
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
    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
}
