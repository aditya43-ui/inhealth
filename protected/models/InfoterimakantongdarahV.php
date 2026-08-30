<?php

/**
 * This is the model class for table "infoterimakantongdarah_v".
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package application.models
 * 
 * The followings are the available columns in table 'infoterimakantongdarah_v':
 * @property integer $terimakantongdarah_id
 * @property string $tglterimakantong
 * @property string $no_terimakantong
 * @property double $suhu_terima
 * @property integer $ruanganterima_id
 * @property string $ruanganterima_nama
 * @property integer $pegawaiterima_id
 * @property string $pegawaiterima_nip
 * @property string $pegawaiterima_gelardepan
 * @property string $pegawaiterima_nama
 * @property integer $terimakantongdet_id
 * @property integer $jenisterima_id
 * @property string $jenisterima_nama
 * @property string $jenisterima_singkatan
 * @property integer $komponenterima_id
 * @property string $komponenterima_nama
 * @property string $komponenterima_singkatan
 * @property string $nobarcodekantong
 * @property integer $jmlterima
 * @property integer $kirimkantongdarah_id
 * @property string $tglkirimkantongdarah
 * @property string $no_kirimkantong
 * @property string $ket_kirim
 * @property boolean $isterima
 * @property integer $waktukirim_mnt
 * @property double $suhu_kirim
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
class InfoterimakantongdarahV extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoterimakantongdarahV the static model class
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
		return 'infoterimakantongdarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimakantongdarah_id, ruanganterima_id, pegawaiterima_id, terimakantongdet_id, jenisterima_id, komponenterima_id, jmlterima, kirimkantongdarah_id, waktukirim_mnt, ruangankirim_id, ruangantujuan_id, petugaskirim_id, transporter_id, kirimkantongdet_id, jeniskirim_id, komponenkirim_id, jmlkirim, pegawaimonitor_id, monitoringkantong_id, monitoring_ke, coolboxdarah_id, jml_icepack, coolbox_jml, jml_isikantong', 'numerical', 'integerOnly'=>true),
			array('suhu_terima, suhu_kirim, suhu_monitoring', 'numerical'),
			array('no_terimakantong, ruanganterima_nama, pegawaiterima_nama, no_kirimkantong, ruangankirim_nama, ruangantujuan_nama, petugaskirim_nama, transporter_nama, pegawaimonitor_nama, coolbox_merk, coolbox_jenis, coolbox_ukuran', 'length', 'max'=>50),
			array('pegawaiterima_nip, petugaskirim_nip, transporter_nip, pegawaimonitor_nip', 'length', 'max'=>30),
			array('pegawaiterima_gelardepan, petugaskirim_gelardepan, transporter_gelardepan, pegawaimonitor_gelardepan', 'length', 'max'=>10),
			array('jenisterima_nama, nobarcodekantong, jeniskirim_nama', 'length', 'max'=>255),
			array('jenisterima_singkatan, komponenterima_singkatan, jeniskirim_singkatan, komponenkirim_singkatan', 'length', 'max'=>5),
			array('komponenterima_nama, komponenkirim_nama, nomorbarcode, kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, coolboxdarah_nama', 'length', 'max'=>100),
			array('tglterimakantong, tglkirimkantongdarah, ket_kirim, isterima, tglmonitoring, jammonitoring, ket_monitoring', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimakantongdarah_id, tglterimakantong, no_terimakantong, suhu_terima, ruanganterima_id, ruanganterima_nama, pegawaiterima_id, pegawaiterima_nip, pegawaiterima_gelardepan, pegawaiterima_nama, terimakantongdet_id, jenisterima_id, jenisterima_nama, jenisterima_singkatan, komponenterima_id, komponenterima_nama, komponenterima_singkatan, nobarcodekantong, jmlterima, kirimkantongdarah_id, tglkirimkantongdarah, no_kirimkantong, ket_kirim, isterima, waktukirim_mnt, suhu_kirim, ruangankirim_id, ruangankirim_nama, ruangantujuan_id, ruangantujuan_nama, petugaskirim_id, petugaskirim_nip, petugaskirim_gelardepan, petugaskirim_nama, transporter_id, transporter_nip, transporter_gelardepan, transporter_nama, kirimkantongdet_id, jeniskirim_id, jeniskirim_nama, jeniskirim_singkatan, komponenkirim_id, komponenkirim_nama, komponenkirim_singkatan, nomorbarcode, jmlkirim, pegawaimonitor_id, pegawaimonitor_nip, pegawaimonitor_gelardepan, pegawaimonitor_nama, monitoringkantong_id, tglmonitoring, jammonitoring, monitoring_ke, suhu_monitoring, kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, ket_monitoring, coolboxdarah_id, jml_icepack, coolboxdarah_nama, coolbox_merk, coolbox_jenis, coolbox_ukuran, coolbox_jml, jml_isikantong', 'safe', 'on'=>'search'),
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
			'terimakantongdarah_id' => 'Terimakantongdarah',
			'tglterimakantong' => 'Tgl. Penerimaan Kantong',
			'no_terimakantong' => 'No Terimakantong',
			'suhu_terima' => 'Suhu Terima',
			'ruanganterima_id' => 'Ruanganterima',
			'ruanganterima_nama' => 'Ruanganterima Nama',
			'pegawaiterima_id' => 'Nama Petugas Penerima',
			'pegawaiterima_nip' => 'Pegawaiterima Nip',
			'pegawaiterima_gelardepan' => 'Pegawaiterima Gelardepan',
			'pegawaiterima_nama' => 'Pegawaiterima Nama',
			'terimakantongdet_id' => 'Terimakantongdet',
			'jenisterima_id' => 'Jenisterima',
			'jenisterima_nama' => 'Jenis Kantong Darah',
			'jenisterima_singkatan' => 'Jenisterima Singkatan',
			'komponenterima_id' => 'Komponenterima',
			'komponenterima_nama' => 'Komponenterima Nama',
			'komponenterima_singkatan' => 'Komponenterima Singkatan',
			'nobarcodekantong' => 'No. Barkode Kantong',
			'jmlterima' => 'Jmlterima',
			'kirimkantongdarah_id' => 'Kirimkantongdarah',
			'tglkirimkantongdarah' => 'Tglkirimkantongdarah',
			'no_kirimkantong' => 'No Kirimkantong',
			'ket_kirim' => 'Ket Kirim',
			'isterima' => 'Isterima',
			'waktukirim_mnt' => 'Waktukirim Mnt',
			'suhu_kirim' => 'Suhu Kirim',
			'ruangankirim_id' => 'Ruangankirim',
			'ruangankirim_nama' => 'Ruangan Asal',
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
			'jeniskirim_nama' => 'Jenis Kantong Darah',
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

		$criteria->compare('terimakantongdarah_id',$this->terimakantongdarah_id);
		$criteria->compare('tglterimakantong',$this->tglterimakantong,true);
		$criteria->compare('no_terimakantong',$this->no_terimakantong,true);
		$criteria->compare('suhu_terima',$this->suhu_terima);
		$criteria->compare('ruanganterima_id',$this->ruanganterima_id);
		$criteria->compare('ruanganterima_nama',$this->ruanganterima_nama,true);
		$criteria->compare('pegawaiterima_id',$this->pegawaiterima_id);
		$criteria->compare('pegawaiterima_nip',$this->pegawaiterima_nip,true);
		$criteria->compare('pegawaiterima_gelardepan',$this->pegawaiterima_gelardepan,true);
		$criteria->compare('pegawaiterima_nama',$this->pegawaiterima_nama,true);
		$criteria->compare('terimakantongdet_id',$this->terimakantongdet_id);
		$criteria->compare('jenisterima_id',$this->jenisterima_id);
		$criteria->compare('jenisterima_nama',$this->jenisterima_nama,true);
		$criteria->compare('jenisterima_singkatan',$this->jenisterima_singkatan,true);
		$criteria->compare('komponenterima_id',$this->komponenterima_id);
		$criteria->compare('komponenterima_nama',$this->komponenterima_nama,true);
		$criteria->compare('komponenterima_singkatan',$this->komponenterima_singkatan,true);
		$criteria->compare('nobarcodekantong',$this->nobarcodekantong,true);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
		$criteria->compare('tglkirimkantongdarah',$this->tglkirimkantongdarah,true);
		$criteria->compare('no_kirimkantong',$this->no_kirimkantong,true);
		$criteria->compare('ket_kirim',$this->ket_kirim,true);
		$criteria->compare('isterima',$this->isterima);
		$criteria->compare('waktukirim_mnt',$this->waktukirim_mnt);
		$criteria->compare('suhu_kirim',$this->suhu_kirim);
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
    
        /**
         * digunakan untuk pencarian informasi
         * @return \CActiveDataProvider he data provider that can return the models based on the search/filter conditions.
         */
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        $criteria=new CDbCriteria();
        $criteria->select="no_kirimkantong,no_terimakantong,ruangankirim_id,suhu_terima,tglterimakantong,pegawaiterima_nama,terimakantongdarah_id";
        $criteria->group="no_kirimkantong,no_terimakantong,ruangankirim_id,suhu_terima,tglterimakantong,pegawaiterima_nama,terimakantongdarah_id";
       
		
        $criteria->addBetweenCondition(" DATE(tglterimakantong) ", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('terimakantongdarah_id',$this->terimakantongdarah_id);
		$criteria->compare('LOWER(no_kirimkantong)',strtolower($this->no_kirimkantong),true);
		$criteria->compare('ruangankirim_id',$this->ruangankirim_id);
		$criteria->compare('pegawaiterima_id',$this->pegawaiterima_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}