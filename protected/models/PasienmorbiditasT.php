<?php

/**
 * This is the model class for table "pasienmorbiditas_t".
 *
 * The followings are the available columns in table 'pasienmorbiditas_t': 
 * controller utama pemeriksaa fisik
 * 
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 *  
 * @property integer $pasienmorbiditas_id
 * @property integer $kamarruangan_id
 * @property integer $kelompokdiagnosa_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $jenisin_id
 * @property integer $sebabdiagnosa_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $kelompokumur_id
 * @property integer $penyebabluarcedera_id
 * @property integer $diagnosa_id
 * @property integer $jenisketunaan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $golonganumur_id
 * @property integer $morfologineoplasma_id
 * @property integer $sebabin_id
 * @property integer $diagnosaicdix_id
 * @property string $tglmorbiditas
 * @property string $kasusdiagnosa
 * @property integer $umur_0_28hr
 * @property integer $umur_28hr_1thn
 * @property integer $umur_1_4thn
 * @property integer $umur_5_14thn
 * @property integer $umur_15_24thn
 * @property integer $umur_25_44thn
 * @property integer $umur_45_64thn
 * @property integer $umur_65
 * @property boolean $infeksinosokomial
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienmorbiditasT extends CActiveRecord
{
        public $diagnosa_kode,$diagnosa_nama,$diagnosa_namalainnya, $diagnosa_nama1;
        public $kelompokdiagnosa_nama, $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmorbiditasT the static model class
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
		return 'pasienmorbiditas_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokdiagnosa_id, ruangan_id, pasien_id, pendaftaran_id, pegawai_id, kelompokumur_id, diagnosa_id, jeniskasuspenyakit_id, golonganumur_id, tglmorbiditas', 'required'),
			array('kamarruangan_id, kelompokdiagnosa_id, ruangan_id, pasienadmisi_id, pasien_id, jenisin_id, sebabdiagnosa_id, pendaftaran_id, pegawai_id, kelompokumur_id, penyebabluarcedera_id, diagnosa_id, jenisketunaan_id, jeniskasuspenyakit_id, golonganumur_id, morfologineoplasma_id, sebabin_id, diagnosaicdix_id, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65,  pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, pegawaipenghapusankemenkes', 'numerical', 'integerOnly'=>true),
			array('kasusdiagnosa', 'length', 'max'=>20),
			array('pasienicd9cm_id, infeksinosokomial, update_time, update_loginpemakai_id, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman, tglpenghapusankemenkes', 'safe'),
			array('statusdiagnosapasien', 'length', 'max'=>100),
			array('ket_diagnosa', 'safe'),
			array('pasienicd9cm_id, infeksinosokomial, update_time, update_loginpemakai_id, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman, tglpenghapusankemenkes,statusdiagnosapasien,keterangan', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmorbiditas_id, kamarruangan_id, kelompokdiagnosa_id, ruangan_id, pasienadmisi_id, pasien_id, jenisin_id, sebabdiagnosa_id, pendaftaran_id, pegawai_id, kelompokumur_id, penyebabluarcedera_id, diagnosa_id, jenisketunaan_id, jeniskasuspenyakit_id, golonganumur_id, morfologineoplasma_id, sebabin_id, diagnosaicdix_id, tglmorbiditas, kasusdiagnosa, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, infeksinosokomial, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpengiriminkemenkes, tglubahpengirimankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman, tglpenghapusankemenkes, pegawaipenghapusankemenkes, statusdiagnosapasien,asesmen_awal_medis_id', 'safe', 'on'=>'search'),
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
			'diagnosa'=>array(self::BELONGS_TO,  'DiagnosaM', 'diagnosa_id'),
			'diagnosam'=>array(self::BELONGS_TO,  'DiagnosaM', 'diagnosa_id'),
			'kelompokdiagnosa'=>array(self::BELONGS_TO,  'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
			'diagnosatindakan'=>array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'diagnosatindakanm'=>array(self::BELONGS_TO, 'DiagnosatindakanM', 'diagnosatindakan_id'),
			'sebabdiagnosa'=>array(self::BELONGS_TO,  'SebabdiagnosaM', 'sebabdiagnosa_id'),
			'pendaftaran'=>array(self::BELONGS_TO,  'PendaftaranT', 'pendaftaran_id'),
			'pegawai'=>array(self::BELONGS_TO,  'PegawaiM', 'pegawai_id'),
			'ruangan'=>array(self::BELONGS_TO,  'RuanganM', 'ruangan_id'),
			'ppds'=>array(self::BELONGS_TO,  'PpdsM', 'ppds_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'kamarruangan_id' => 'Kamarruangan',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'ruangan_id' => 'Ruangan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'jenisin_id' => 'Jenisin',
			'sebabdiagnosa_id' => 'Sebab Diagnosa',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter',
			'kelompokumur_id' => 'Kelompokumur',
			'penyebabluarcedera_id' => 'Penyebabluarcedera',
			'diagnosa_id' => 'Diagnosa',
			'jenisketunaan_id' => 'Jenisketunaan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'golonganumur_id' => 'Golonganumur',
			'morfologineoplasma_id' => 'Morfologineoplasma',
			'sebabin_id' => 'Sebabin',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'tglmorbiditas' => 'Tanggal Diagnosis',
			'kasusdiagnosa' => 'Kasus Diagnosa',
			'umur_0_28hr' => 'Umur 0 28hr',
			'umur_28hr_1thn' => 'Umur 28hr 1thn',
			'umur_1_4thn' => 'Umur 1 4thn',
			'umur_5_14thn' => 'Umur 5 14thn',
			'umur_15_24thn' => 'Umur 15 24thn',
			'umur_25_44thn' => 'Umur 25 44thn',
			'umur_45_64thn' => 'Umur 45 64thn',
			'umur_65' => 'Umur 65',
			'infeksinosokomial' => 'Infeksinosokomial',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'statusdiagnosapasien' => 'Status Diagnosa',
			'ket_diagnosa' => 'Keteragan Diagnosa'
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

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('LOWER(statusdiagnosapasien)',strtolower($this->statusdiagnosapasien),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('LOWER(statusdiagnosapasien)',strtolower($this->statusdiagnosapasien),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave()
        {
            // convert to storage format
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
            }
            return parent::beforeSave();
        }
        
        // protected function afterFind(){
        //     foreach($this->metadata->tableSchema->columns as $columnName => $column){

        //         if (!strlen($this->$columnName)) continue;

        //         if ($column->dbType == 'date'){                         
        //                 $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
        //                 }elseif ($column->dbType == 'timestamp without time zone'){
        //                         $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
        //                 }
        //     }
        //     return true;
        // }
        
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
         public function searchDiagnosa($data,$pagination=array())
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisin_id',$this->jenisin_id);
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('penyebabluarcedera_id',$this->penyebabluarcedera_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('jenisketunaan_id',$this->jenisketunaan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('morfologineoplasma_id',$this->morfologineoplasma_id);
		$criteria->compare('sebabin_id',$this->sebabin_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('LOWER(statusdiagnosapasien)',strtolower($this->statusdiagnosapasien),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('infeksinosokomial',$this->infeksinosokomial);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->condition = 'pendaftaran_id ='.$data;
//		$criteria->compare('LOWER(hasilpemeriksaan)',strtolower($this->hasilpemeriksaan),true);
//		$criteria->compare('LOWER(nilairujukan)',strtolower($this->nilairujukan),true);
//		$criteria->compare('LOWER(hasilpemeriksaan_satuan)',strtolower($this->hasilpemeriksaan_satuan),true);
//		$criteria->compare('LOWER(hasilpemeriksaan_metode)',strtolower($this->hasilpemeriksaan_metode),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>$pagination,
		));
	}
        
        public function cekSoapi(){
            $data = [];
            if (!empty($this->pendaftaran_id)){
                $daftar = PendaftaranT::model()->findByPk($this->pendaftaran_id);
                $daftarsebelum = PendaftaranT::model()->find(" pasien_id = ".$daftar->pasien_id." AND  pendaftaran_id != ".$daftar->pendaftaran_id." AND ruangan_id = ".$daftar->ruangan_id);
                if (!empty($daftarsebelum)){                    
                    $cri = new CDbCriteria;
                    $cri->addInCondition("LOWER(statusdiagnosapasien)", [
                        'akut','kronis'
                    ]);
                    $cri->addCondition(" pendaftaran_id = ".$daftarsebelum->pendaftaran_id);
                    $cri->addCondition("kelompokdiagnosa_id = ".Params::KELOMPOKDIAGNOSA_UTAMA." ");
                    $cri->order = " create_time DESC ";
                    $morbi = self::model()->find($cri);

                    if (!empty($morbi)){                    
                        $crianam = new CDbCriteria;
                        $crianam->addCondition(" pendaftaran_id = ".$daftarsebelum->pendaftaran_id);
                        if ( ($morbi->statusdiagnosapasien == 'akut')  ){
                            $crianam->addCondition(" (DATE(tglanamnesis) + interval '30 days') >= '".date('Y-m-d')."' ");
                        }else if ( ($morbi->statusdiagnosapasien == 'kronis') ){
                            $crianam->addCondition(" (DATE(tglanamnesis) + interval '90 days') >= '".date('Y-m-d')."' ");
                        }

                        $anam = AnamnesaT::model()->find($crianam);

                        if (!empty($anam)){
                            $data['soap_subjective'] = 'Keluhan Utama : '.$anam->keluhanutama.'<br/>'.
                                                 'Keluhan Tambahan : '.$anam->keluhantambahan;                        
                        }
                    }

                    $fisik = PemeriksaanfisikT::model()->find(" pendaftaran_id =  ".$daftarsebelum->pendaftaran_id." ORDER BY create_time DESC ");
                    if (!empty($fisik)){
                        $data['soap_objective'] = 'Tekanan Datah : '.$fisik->tekanandarah.' mmHg<br/>'.
                                            'Nadi : '.$fisik->detaknadi.' x/menit<br/>'.
                                            'Detak jantung : '.$fisik->denyutjantung.'<br/>'.
                                            'Suhu Tubuh : '.$fisik->suhutubuh.' C<br/>'.
                                            'Pernapasan : '.$fisik->pernapasan.' x/menit<br/>'.
                                            'SPO2 : '.$fisik->tandavital_spo2.' %';
                    }

                    $assesment_utama = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$daftarsebelum->pendaftaran_id." AND kelompokdiagnosa_id = ".Params::KELOMPOKDIAGNOSA_UTAMA." ORDER BY create_time DESC ");
                    $assesment_sekunder = PasienmorbiditasT::model()->find(" pendaftaran_id = ".$daftarsebelum->pendaftaran_id." AND  kelompokdiagnosa_id != ".Params::KELOMPOKDIAGNOSA_UTAMA." ORDER BY create_time DESC ");

                    if (!empty($assesment_utama) || !empty($assesment_sekunder)){
                        $data['soap_asesmen'] = 'Diagnosa Utama : '.(!empty($assesment_utama)?$assesment_utama->diagnosa->diagnosa_nama:'').'<br/>'. 
                                                'Diagnosa Sekunder : '.(!empty($assesment_sekunder)?$assesment_sekunder->diagnosa->diagnosa_nama:'');
                    }
                }
            }
            
            return $data;
        }

	public function searchRiwayatDiagnosa(){
		$criteria = new CDbCriteria;

		if (!empty($this->pasien_id)) {
			$criteria->addCondition("pasien_id = " . $this->pasien_id);
		}
		// $criteria->addCondition("kelompokdiagnosa_id = " . Params::KELOMPOKDIAGNOSA_UTAMA);

		$criteria->order = 'create_time desc'; 

		return new CActiveDataProvider(new PasienmorbiditasR(), array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 5,),
		));
	}


	public function searchRiwayatDiagnosaPasien($pasien_id=null){
		$criteria = new CDbCriteria;

		if (!empty($pasien_id)) {
			$criteria->addCondition("pasien_id = " . $pasien_id);
		}
		$criteria->addCondition("kelompokdiagnosa_id = " . Params::KELOMPOKDIAGNOSA_UTAMA);

		$criteria->order = 'create_time desc'; 

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 5,),
		));
	}

	public function loadPasienMorbiditas(){
		$mod = get_called_class();
		$load = [];
		if (!empty($this->pendaftaran_id)){
			$cri = new CDbCriteria;
			$cri->select = " t.*, diag.diagnosa_kode, diag.diagnosa_nama, diag.diagnosa_namalainnya ";
			$cri->join = " JOIN diagnosa_m diag ON diag.diagnosa_id = t.diagnosa_id ";
			$cri->addCondition(" pendaftaran_id = ".$this->pendaftaran_id." AND diagnosaicdix_id IS NULL ");
			$load = $mod::model()->findAll($cri);
			
			foreach($load as $key => $val){
				$load[$key]->diagnosa_kode = $val->diagnosa_kode;
				$load[$key]->diagnosa_nama = $val->diagnosa_nama;
				$load[$key]->diagnosa_namalainnya = $val->diagnosa_namalainnya;
				$load[$key]->pegawai_nama = $val->pegawai->namaLengkap;
			}
		}
		return $load;
	}
}