<?php

/**
 * This is the model class for table "asesmengizi_t".
 *
 * The followings are the available columns in table 'asesmengizi_t':
 * @property integer $asesmengizi_id
 * @property string $tgl_konsultasi
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $kelaspelayanan_id
 * @property string $diagnosa
 * @property integer $ahligizi_id
 * @property integer $frekuensi_makan
 * @property integer $frekuensi_selingan
 * @property boolean $alergi_makanan
 * @property string $alergi_makanan_jenis
 * @property boolean $pantangan_makanan
 * @property string $pantangan_makanan_jenis
 * @property string $antropometri
 * @property string $biokimia
 * @property string $klinik_fisik
 * @property string $riwayat_gizi_penyakit
 * @property string $diagnosis_gizi
 * @property string $intervensi_gizi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property RuanganM $ruangan
 * @property KelaspelayananM $kelaspelayanan
 * @property PegawaiM $ahligizi
 * @property AsesmengizidetT[] $asesmengizidetTs
 */
class AsesmengiziT extends CActiveRecord
{
    public $ahligizi_nama;
    public $ananakpjgbdn;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmengiziT the static model class
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
        return 'asesmengizi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tgl_konsultasi, ahligizi_id, create_time, create_loginpemakai_id', 'required'),
            array('pendaftaran_id, pasien_id, ruangan_id, kelaspelayanan_id, ahligizi_id, frekuensi_makan, frekuensi_selingan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('kebiasaan_makan_penyakit, diagnosa, alergi_makanan, alergi_makanan_jenis, pantangan_makanan, pantangan_makanan_jenis, antropometri, biokimia, klinik_fisik, riwayat_gizi_penyakit, diagnosis_gizi, intervensi_gizi, update_time, monitoringevaluasi_gizi, andewasabb, andewasatb, andewasatl, andewasabbi,andewasatbest, andewasalla, andewasaimt, andewasallap, isgizideburuk, isgizidekurang, isgizidenormal, isgizidelebih, isgizideobesitas, ananakbb, ananaktb, ananaklla, ananakbbi, ananakbbip, ananakbbu, ananakbbuu, ananaktbu,ananaktbuu,ananakbbtb,ananakbbtbb, ananakllau, ananakllauu, isgizianburuk, isgiziankurang, isgiziannormal, isgizianlebih, isgizianobesitas, isbiokimianormal,isbiokimiabermasalah,biokim, isfisklinormal, isfisklibermasalah, fisklinik, isalergiada, isalergitidak, alergi, ispolamakanteratur, ispolamakantidak, polamakan, issusunanmakanseimbang, issusunanmakantidak, susunanmakan, isasidiberikan, isasitidak, asi, lainlain, isnmkurang, isnmbaik, iskelsulit,iskelsulitmengunyah, iskelmual,iskelmuntah,iskellainlain,isjdoral,isjdenteral,isjdparenteral,jdoral,jdenteral,jdparenteral,isrpdoral,isrpdlewatpipa,rptpriwayatpenyakit,rptpdiagnosismedis,andestatus_gizi,ananakstatus_gizi,ananakpjgbdn, ananakpjgbdnu,ananakutb', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kebiasaan_makan_penyakit, asesmengizi_id, tgl_konsultasi, pendaftaran_id, pasien_id, ruangan_id, kelaspelayanan_id, diagnosa, ahligizi_id, frekuensi_makan, frekuensi_selingan, alergi_makanan, alergi_makanan_jenis, pantangan_makanan, pantangan_makanan_jenis, antropometri, biokimia, klinik_fisik, riwayat_gizi_penyakit, diagnosis_gizi, intervensi_gizi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, monitoringevaluasi_gizi, andewasabb, andewasatb, andewasatl, andewasabbi,andewasatbest, andewasalla, andewasaimt, andewasallap, isgizideburuk, isgizidekurang, isgizidenormal, isgizidelebih, isgizideobesitas, ananakbb, ananaktb, ananaklla, ananakbbi, ananakbbip, ananakbbu, ananakbbuu, ananaktbu,ananaktbuu,ananakbbtb,ananakbbtbb, ananakllau, ananakllauu, isgizianburuk, isgiziankurang, isgiziannormal, isgizianlebih, isgizianobesitas, isbiokimianormal,isbiokimiabermasalah,biokim, isfisklinormal, isfisklibermasalah, fisklinik, isalergiada, isalergitidak, alergi, ispolamakanteratur, ispolamakantidak, polamakan, issusunanmakanseimbang, issusunanmakantidak, susunanmakan, isasidiberikan, isasitidak, asi, lainlain, isnmkurang, isnmbaik, iskelsulit,iskelsulitmengunyah, iskelmual,iskelmuntah,iskellainlain,isjdoral,isjdenteral,isjdparenteral,jdoral,jdenteral,jdparenteral,isrpdoral,isrpdlewatpipa,rptpriwayatpenyakit,rptpdiagnosismedis', 'safe', 'on' => 'search'),
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
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
            'ahligizi' => array(self::BELONGS_TO, 'PegawaiM', 'ahligizi_id'),
            'asesmengizidetTs' => array(self::HAS_MANY, 'AsesmengizidetT', 'asesmengizi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'asesmengizi_id' => 'Asesmengizi',
            'tgl_konsultasi' => 'Tgl. Konsultasi',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'ruangan_id' => 'Ruangan',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'diagnosa' => 'Diagnosa',
            'ahligizi_id' => 'Ahli Gizi',
            'frekuensi_makan' => 'Frekuensi Makan',
            'frekuensi_selingan' => 'Frekuensi Selingan',
            'alergi_makanan' => 'Alergi Makanan',
            'alergi_makanan_jenis' => 'Alergi Makanan Jenis',
            'pantangan_makanan' => 'Pantangan Makanan',
            'pantangan_makanan_jenis' => 'Pantangan Makanan Jenis',
            'antropometri' => 'Antropometri',
            'biokimia' => 'Biokimia',
            'klinik_fisik' => 'Klinik Fisik',
            'riwayat_gizi_penyakit' => 'Riwayat Gizi Penyakit',
            'diagnosis_gizi' => 'Diagnosis Gizi',
            'intervensi_gizi' => 'Intervensi Gizi',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'kebiasaan_makan_penyakit' => 'Kebiasaan Makanan Berkaitan dengan Penyakit',
            'monitoringevaluasi_gizi' => 'Monitoring Evaluasi Gizi',
            // dewasa
            'andewasabb' => 'Berat Badan',
            'andewasatb' => 'Tinggi Badan',
            'andewasatl' => 'Tinggi Lutut',
            'andewasatbest' => 'Tinggi Badan (Est)',
            'andewasabbi' => 'Berat Badan Ideal',
            'andewasalla' => 'Lingkar Lengan Atas',
            'andewasaimt' => 'IMT',
            'andewasallap' => '% LiLA',
            'isgizideburuk' => 'Buruk',
            'isgizidekurang' => 'Kurang',
            'isgizidenormal' => 'Normal',
            'isgizidelebih' => 'Lebih',
            'isgizideobesitas' => 'Obesitas',
            // anak
            'ananakbb' => 'Berat Badan',
            'ananaktb' => 'Tinggi Badan',
            'ananaklla' => 'LiLA',
            'ananakbbi' => 'BBI',
            'ananakbbip' => '% BBI',
            'ananakbbu' => 'Berat Badan/Umur',
            'ananakpjgbdn' => 'Panjang Badan',
            'ananakpjgbdnu' => 'Panjang Badan/U',
            'ananakutb' => 'Usia Tinggi badan',
            'ananakbbuu' => '/',
            'ananaktbu' => 'Tinggi Badan/Umur',
            'ananaktbuu' => '/',
            'ananakbbtb' => 'BB/TB',
            'ananakbbtbb' => '/',
            'ananakllau' => 'LiLA/U',
            'ananakllauu' => '/',
            'ananakket' => 'Keterangan',
            'ananakimtu' => 'IMT/U',
            'isgizianburuk' => 'Buruk',
            'isgiziankurang' => 'Kurang',
            'isgiziannormal'=> 'Normal',
            'isgizianlebih' => 'Lebih',
            'isgizianobesitas' => 'Obesitas',
            // biokimia
            'isbiokimianormal' => 'Normal',
            'isbiokimiabermasalah' => 'Bermasalah',
            'biokim' => 'Text BioKimia',
            // fisik-klinik 
            'isfisklinormal' => 'Normal',
            'isfisklibermasalah' => 'Bermasalah',
            'fisklinik' => 'Text Fisik Klinik',
            // riwayat gizi 
            'isalergiada' => 'Ada',
            'isalergitidak' => 'Tidak',
            'alergi' => 'Alergi',
            'ispolamakanteratur' => 'Teratur',
            'ispolamakantidak' => 'Tidak Teratur',
            'polamakan' => 'Pola Makan',
            'issusunanmakanseimbang' => 'seimbang',
            'issusunanmakantidak' => 'Tidak Seimbang',
            'susunanmakan' => 'Text Susunan Makan',
            'isasidiberikan' => 'Diberikan',
            'isasitidak' => 'Tidak Diberikan',
            'asi' => 'Text Asi',
            'lainlain' => 'Lain - Lain',
            'isnmbaik' => 'Baik',
            'isnmkurang' => 'Kurang',
            'iskelsulit' => 'Sulit',
            'iskelsulitmengunyah' => 'Sulit Mengunyah',
            'iskelmual' => 'Mual',
            'iskelmuntah' => 'Muntah',
            'iskellainlain' => 'Lain-lain',
            'isjdoral' => 'Oral',
            'isjdenteral' => 'Enternal',
            'isjdparenteral' => 'Parenteral',
            'jdoral' => 'Text Oral',
            'jdenteral' => 'Text Enternal',
            'jdparenteral' => 'Text Parenteral',
            'isrpdoral' => 'Oral',
            'isrpdlewatpipa' => 'Lewat Pipa',
            // riwayat-personal-terkait-penyakit
            'rptpriwayatpenyakit' => 'Riwayat Penyakit',
            'rptpdiagnosismedis' => 'Diagnosis Medis',
            'andestatus_gizi' => 'Status Gizi',
            'ananakstatus_gizi' => 'Status Gizi',
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

        $criteria->compare('asesmengizi_id', $this->asesmengizi_id);
        $criteria->compare('tgl_konsultasi', $this->tgl_konsultasi, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('diagnosa', $this->diagnosa, true);
        $criteria->compare('ahligizi_id', $this->ahligizi_id);
        $criteria->compare('frekuensi_makan', $this->frekuensi_makan);
        $criteria->compare('frekuensi_selingan', $this->frekuensi_selingan);
        $criteria->compare('alergi_makanan', $this->alergi_makanan);
        $criteria->compare('alergi_makanan_jenis', $this->alergi_makanan_jenis, true);
        $criteria->compare('pantangan_makanan', $this->pantangan_makanan);
        $criteria->compare('pantangan_makanan_jenis', $this->pantangan_makanan_jenis, true);
        $criteria->compare('antropometri', $this->antropometri, true);
        $criteria->compare('biokimia', $this->biokimia, true);
        $criteria->compare('klinik_fisik', $this->klinik_fisik, true);
        $criteria->compare('riwayat_gizi_penyakit', $this->riwayat_gizi_penyakit, true);
        $criteria->compare('diagnosis_gizi', $this->diagnosis_gizi, true);
        $criteria->compare('intervensi_gizi', $this->intervensi_gizi, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('monitoringevaluasi_gizi', $this->monitoringevaluasi_gizi, true);
        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAhliGiziItems()
    {
        return PegawairuanganV::model()->findAllByAttributes(array('jabatan_id' =>  Params::JABATAN_ID_AHLI_GIZI, 'pegawai_aktif' => true, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'nama_pegawai ASC'));
        //return DokterV::model()->findAll();
    }
}
