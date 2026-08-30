 <?php

/**
 * This is the model class for table "infokirimkantongdarah_v".
 *
 * The followings are the available columns in table 'infokirimkantongdarah_v':
 * @property integer $kirimkantongdarah_id
 * @property string $tglkirimkantongdarah
 * @property string $no_kirimkantong
 * @property string $ket_kirim
 * @property boolean $isterima
 * @property integer $waktukirim_mnt
 * @property double $suhu_kirim
 * @property integer $kantongdarah_id
 * @property string $tglpencatatan
 * @property string $no_kantongdarah
 * @property integer $daftardonasi_id
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property integer $ruangankirim_id
 * @property string $ruangankirim_nama
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property integer $petugaskirim_id
 * @property string $petugaskirim_nip
 * @property string $petugaskirim_gelardepan
 * @property string $petugaskirim_nama
 * @property integer $transporter_id
 * @property string $transporter_nip
 * @property string $transporter_gelardepan
 * @property string $transporter_nama
 * @property integer $kirimkantongdet_id
 * @property integer $jeniskirim_id
 * @property string $jeniskirim_nama
 * @property string $jeniskirim_singkatan
 * @property integer $komponenkirim_id
 * @property string $komponenkirim_nama
 * @property string $komponenkirim_singkatan
 * @property string $nomorbarcode
 * @property integer $jmlkirim
 * @property integer $pegawaimonitor_id
 * @property string $pegawaimonitor_nip
 * @property string $pegawaimonitor_gelardepan
 * @property string $pegawaimonitor_nama
 * @property integer $monitoringkantong_id
 * @property string $tglmonitoring
 * @property string $jammonitoring
 * @property integer $monitoring_ke
 * @property double $suhu_monitoring
 * @property string $kosongtanpalistrik
 * @property string $kosongdenganlistrik
 * @property string $listrikdanicepack
 * @property string $mulaiisikantong
 * @property string $setelahdiisikantong
 * @property string $lepaslistrik
 * @property string $observasi15mnt
 * @property string $ket_monitoring
 * @property integer $coolboxdarah_id
 * @property integer $jml_icepack
 * @property string $coolboxdarah_nama
 * @property string $coolbox_merk
 * @property string $coolbox_jenis
 * @property string $coolbox_ukuran
 * @property integer $coolbox_jml
 * @property integer $jml_isikantong
 */
class InfokirimkantongdarahV extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfokirimkantongdarahV the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'infokirimkantongdarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kirimkantongdarah_id, waktukirim_mnt, kantongdarah_id, daftardonasi_id, pendonor_id, ruangankirim_id, ruangantujuan_id, petugaskirim_id, transporter_id, kirimkantongdet_id, jeniskirim_id, komponenkirim_id, jmlkirim, pegawaimonitor_id, monitoringkantong_id, monitoring_ke, coolboxdarah_id, jml_icepack, coolbox_jml, jml_isikantong', 'numerical', 'integerOnly'=>true),
            array('suhu_kirim, beratbadan_kg, tinggibadan_cm, suhu_monitoring', 'numerical'),
            array('no_kirimkantong, no_pendonor, no_identitas, ruangankirim_nama, ruangantujuan_nama, petugaskirim_nama, transporter_nama, pegawaimonitor_nama, coolbox_merk, coolbox_jenis, coolbox_ukuran', 'length', 'max'=>50),
            array('no_kantongdarah, nama_lengkap, tempat_lahir, notelp_pendonor, komponenkirim_nama, nomorbarcode, kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, coolboxdarah_nama', 'length', 'max'=>100),
            array('jenisidentitas, petugaskirim_nip, transporter_nip, pegawaimonitor_nip', 'length', 'max'=>30),
            array('jenis_kelamin, statusperkawinan, rhesus', 'length', 'max'=>20),
            array('alamat_lengkap, nomobile_pendonor, jeniskirim_nama', 'length', 'max'=>255),
            array('gol_darah', 'length', 'max'=>2),
            array('petugaskirim_gelardepan, transporter_gelardepan, pegawaimonitor_gelardepan', 'length', 'max'=>10),
            array('jeniskirim_singkatan, komponenkirim_singkatan', 'length', 'max'=>5),
            array('tglkirimkantongdarah, ket_kirim, isterima, tglpencatatan, tgllahir, tglmonitoring, jammonitoring, ket_monitoring', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kirimkantongdarah_id, tglkirimkantongdarah, no_kirimkantong, ket_kirim, isterima, waktukirim_mnt, suhu_kirim, kantongdarah_id, tglpencatatan, no_kantongdarah, daftardonasi_id, pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, statusperkawinan, gol_darah, rhesus, ruangankirim_id, ruangankirim_nama, ruangantujuan_id, ruangantujuan_nama, petugaskirim_id, petugaskirim_nip, petugaskirim_gelardepan, petugaskirim_nama, transporter_id, transporter_nip, transporter_gelardepan, transporter_nama, kirimkantongdet_id, jeniskirim_id, jeniskirim_nama, jeniskirim_singkatan, komponenkirim_id, komponenkirim_nama, komponenkirim_singkatan, nomorbarcode, jmlkirim, pegawaimonitor_id, pegawaimonitor_nip, pegawaimonitor_gelardepan, pegawaimonitor_nama, monitoringkantong_id, tglmonitoring, jammonitoring, monitoring_ke, suhu_monitoring, kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, ket_monitoring, coolboxdarah_id, jml_icepack, coolboxdarah_nama, coolbox_merk, coolbox_jenis, coolbox_ukuran, coolbox_jml, jml_isikantong', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'kirimkantongdarah_id' => 'Kirimkantongdarah',
            'tglkirimkantongdarah' => 'Tglkirimkantongdarah',
            'no_kirimkantong' => 'No Kirimkantong',
            'ket_kirim' => 'Ket Kirim',
            'isterima' => 'Isterima',
            'waktukirim_mnt' => 'Waktukirim Mnt',
            'suhu_kirim' => 'Suhu Kirim',
            'kantongdarah_id' => 'Kantongdarah',
            'tglpencatatan' => 'Tglpencatatan',
            'no_kantongdarah' => 'No Kantongdarah',
            'daftardonasi_id' => 'Daftardonasi',
            'pendonor_id' => 'Pendonor',
            'no_pendonor' => 'No Pendonor',
            'jenisidentitas' => 'Jenisidentitas',
            'no_identitas' => 'No Identitas',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tgllahir' => 'Tgllahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat_lengkap' => 'Alamat Lengkap',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'notelp_pendonor' => 'Notelp Pendonor',
            'nomobile_pendonor' => 'Nomobile Pendonor',
            'statusperkawinan' => 'Statusperkawinan',
            'gol_darah' => 'Gol Darah',
            'rhesus' => 'Rhesus',
            'ruangankirim_id' => 'Ruangankirim',
            'ruangankirim_nama' => 'Ruangankirim Nama',
            'ruangantujuan_id' => 'Ruangantujuan',
            'ruangantujuan_nama' => 'Ruangantujuan Nama',
            'petugaskirim_id' => 'Petugaskirim',
            'petugaskirim_nip' => 'Petugaskirim Nip',
            'petugaskirim_gelardepan' => 'Petugaskirim Gelardepan',
            'petugaskirim_nama' => 'Petugaskirim Nama',
            'transporter_id' => 'Transporter',
            'transporter_nip' => 'Transporter Nip',
            'transporter_gelardepan' => 'Transporter Gelardepan',
            'transporter_nama' => 'Transporter Nama',
            'kirimkantongdet_id' => 'Kirimkantongdet',
            'jeniskirim_id' => 'Jeniskirim',
            'jeniskirim_nama' => 'Jeniskirim Nama',
            'jeniskirim_singkatan' => 'Jeniskirim Singkatan',
            'komponenkirim_id' => 'Komponenkirim',
            'komponenkirim_nama' => 'Komponenkirim Nama',
            'komponenkirim_singkatan' => 'Komponenkirim Singkatan',
            'nomorbarcode' => 'Nomorbarcode',
            'jmlkirim' => 'Jmlkirim',
            'pegawaimonitor_id' => 'Pegawaimonitor',
            'pegawaimonitor_nip' => 'Pegawaimonitor Nip',
            'pegawaimonitor_gelardepan' => 'Pegawaimonitor Gelardepan',
            'pegawaimonitor_nama' => 'Pegawaimonitor Nama',
            'monitoringkantong_id' => 'Monitoringkantong',
            'tglmonitoring' => 'Tglmonitoring',
            'jammonitoring' => 'Jammonitoring',
            'monitoring_ke' => 'Monitoring Ke',
            'suhu_monitoring' => 'Suhu Monitoring',
            'kosongtanpalistrik' => 'Kosongtanpalistrik',
            'kosongdenganlistrik' => 'Kosongdenganlistrik',
            'listrikdanicepack' => 'Listrikdanicepack',
            'mulaiisikantong' => 'Mulaiisikantong',
            'setelahdiisikantong' => 'Setelahdiisikantong',
            'lepaslistrik' => 'Lepaslistrik',
            'observasi15mnt' => 'Observasi15mnt',
            'ket_monitoring' => 'Ket Monitoring',
            'coolboxdarah_id' => 'Coolboxdarah',
            'jml_icepack' => 'Jml Icepack',
            'coolboxdarah_nama' => 'Coolboxdarah Nama',
            'coolbox_merk' => 'Coolbox Merk',
            'coolbox_jenis' => 'Coolbox Jenis',
            'coolbox_ukuran' => 'Coolbox Ukuran',
            'coolbox_jml' => 'Coolbox Jml',
            'jml_isikantong' => 'Jml Isikantong',
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

        $criteria=new CDbCriteria;

        $criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
        $criteria->compare('tglkirimkantongdarah',$this->tglkirimkantongdarah,true);
        $criteria->compare('no_kirimkantong',$this->no_kirimkantong,true);
        $criteria->compare('ket_kirim',$this->ket_kirim,true);
        $criteria->compare('isterima',$this->isterima);
        $criteria->compare('waktukirim_mnt',$this->waktukirim_mnt);
        $criteria->compare('suhu_kirim',$this->suhu_kirim);
        $criteria->compare('kantongdarah_id',$this->kantongdarah_id);
        $criteria->compare('tglpencatatan',$this->tglpencatatan,true);
        $criteria->compare('no_kantongdarah',$this->no_kantongdarah,true);
        $criteria->compare('daftardonasi_id',$this->daftardonasi_id);
        $criteria->compare('pendonor_id',$this->pendonor_id);
        $criteria->compare('no_pendonor',$this->no_pendonor,true);
        $criteria->compare('jenisidentitas',$this->jenisidentitas,true);
        $criteria->compare('no_identitas',$this->no_identitas,true);
        $criteria->compare('nama_lengkap',$this->nama_lengkap,true);
        $criteria->compare('tempat_lahir',$this->tempat_lahir,true);
        $criteria->compare('tgllahir',$this->tgllahir,true);
        $criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
        $criteria->compare('alamat_lengkap',$this->alamat_lengkap,true);
        $criteria->compare('beratbadan_kg',$this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor',$this->notelp_pendonor,true);
        $criteria->compare('nomobile_pendonor',$this->nomobile_pendonor,true);
        $criteria->compare('statusperkawinan',$this->statusperkawinan,true);
        $criteria->compare('gol_darah',$this->gol_darah,true);
        $criteria->compare('rhesus',$this->rhesus,true);
        $criteria->compare('ruangankirim_id',$this->ruangankirim_id);
        $criteria->compare('ruangankirim_nama',$this->ruangankirim_nama,true);
        $criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
        $criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
        $criteria->compare('petugaskirim_id',$this->petugaskirim_id);
        $criteria->compare('petugaskirim_nip',$this->petugaskirim_nip,true);
        $criteria->compare('petugaskirim_gelardepan',$this->petugaskirim_gelardepan,true);
        $criteria->compare('petugaskirim_nama',$this->petugaskirim_nama,true);
        $criteria->compare('transporter_id',$this->transporter_id);
        $criteria->compare('transporter_nip',$this->transporter_nip,true);
        $criteria->compare('transporter_gelardepan',$this->transporter_gelardepan,true);
        $criteria->compare('transporter_nama',$this->transporter_nama,true);
        $criteria->compare('kirimkantongdet_id',$this->kirimkantongdet_id);
        $criteria->compare('jeniskirim_id',$this->jeniskirim_id);
        $criteria->compare('jeniskirim_nama',$this->jeniskirim_nama,true);
        $criteria->compare('jeniskirim_singkatan',$this->jeniskirim_singkatan,true);
        $criteria->compare('komponenkirim_id',$this->komponenkirim_id);
        $criteria->compare('komponenkirim_nama',$this->komponenkirim_nama,true);
        $criteria->compare('komponenkirim_singkatan',$this->komponenkirim_singkatan,true);
        $criteria->compare('nomorbarcode',$this->nomorbarcode,true);
        $criteria->compare('jmlkirim',$this->jmlkirim);
        $criteria->compare('pegawaimonitor_id',$this->pegawaimonitor_id);
        $criteria->compare('pegawaimonitor_nip',$this->pegawaimonitor_nip,true);
        $criteria->compare('pegawaimonitor_gelardepan',$this->pegawaimonitor_gelardepan,true);
        $criteria->compare('pegawaimonitor_nama',$this->pegawaimonitor_nama,true);
        $criteria->compare('monitoringkantong_id',$this->monitoringkantong_id);
        $criteria->compare('tglmonitoring',$this->tglmonitoring,true);
        $criteria->compare('jammonitoring',$this->jammonitoring,true);
        $criteria->compare('monitoring_ke',$this->monitoring_ke);
        $criteria->compare('suhu_monitoring',$this->suhu_monitoring);
        $criteria->compare('kosongtanpalistrik',$this->kosongtanpalistrik,true);
        $criteria->compare('kosongdenganlistrik',$this->kosongdenganlistrik,true);
        $criteria->compare('listrikdanicepack',$this->listrikdanicepack,true);
        $criteria->compare('mulaiisikantong',$this->mulaiisikantong,true);
        $criteria->compare('setelahdiisikantong',$this->setelahdiisikantong,true);
        $criteria->compare('lepaslistrik',$this->lepaslistrik,true);
        $criteria->compare('observasi15mnt',$this->observasi15mnt,true);
        $criteria->compare('ket_monitoring',$this->ket_monitoring,true);
        $criteria->compare('coolboxdarah_id',$this->coolboxdarah_id);
        $criteria->compare('jml_icepack',$this->jml_icepack);
        $criteria->compare('coolboxdarah_nama',$this->coolboxdarah_nama,true);
        $criteria->compare('coolbox_merk',$this->coolbox_merk,true);
        $criteria->compare('coolbox_jenis',$this->coolbox_jenis,true);
        $criteria->compare('coolbox_ukuran',$this->coolbox_ukuran,true);
        $criteria->compare('coolbox_jml',$this->coolbox_jml);
        $criteria->compare('jml_isikantong',$this->jml_isikantong);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
} 