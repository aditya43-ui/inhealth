<?php

/**
 * This is the model class for table "pasienpulang_t".
 *
 * The followings are the available columns in table 'pasienpulang_t':
 * @property integer $pasienpulang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpasienpulang
 * @property string $carakeluar_id
 * @property string $kondisikeluar_id
 * @property string $ruanganakhir_id
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $hariperawatan
 */
class PasienpulangT extends CActiveRecord
{
        public $pakeRujukan = false;
        public $isDead = false;
        public $isKontrol = false;
        public $tgl_meninggal = '';
        public $tgl_awal;
        public $tgl_akhir;
        public $no_pendaftaran;
        public $nama_pasien;

		
        public $nama_bin;
        public $no_rekam_medik;
        public $instalasi_nama;
        public $ruangan_nama;
        public $umur;
        public $jeniskelamin;
        public $alamat_pasien;
        public $kelurahan_nama;
        public $jeniskasuspenyakit_nama, $carakeluar_nama, $kondisikeluar_nama;
        public $rumahsakitrujukan , $alamatrsrujukan ,$telp_fax , $tgldirujuk ,$kepadayth, $dirujukkebagian, $alasandirujuk, $hasilpemeriksaan_ruj;
        public $diagnosasementara_ruj , $pengobatan_ruj, $lainlain_ruj,$catatandokterperujuk;
        public $tanggal_lahir, $jeniskasuspenyakit_id, $kelompokumur_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienpulangT the static model class
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
		return 'pasienpulang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tglpasienpulang, carakeluar_id, kondisikeluar_id, ruanganakhir_id, satuanlamarawat', 'required'),
			array('pasienadmisi_id, pendaftaran_id, pasien_id, lamarawat, hariperawatan', 'numerical', 'integerOnly'=>true),
			array('carakeluar_id, kondisikeluar_id, satuanlamarawat', 'length', 'max'=>50),
			array('penerimapasien, keterangankeluar', 'length', 'max'=>100),
			array('dokterpenerima_id, dpjp1_id, dpjp2_id, dpjp3_id,dpjp4_id,dpjp5_id, tgl_meninggal, tgl_awal, tgl_akhir, nama_bin, nama_pasien,alamatrsrujukan,telp_fax, pengobatan_ruj,catatandokterperujuk,lainlain_ruj,hasilpemeriksaan_ruj,diagnosasementara_ruj,alasandirujuk,dirujukkebagian,kepadayth,tgldirujuk,rumahsakitrujukan, jeniskasuspenyakit_nama, kelurahan_nama, alamat_pasien, jeniskelamin, instalasi_nama, no_rekam_medik, ruangan_nama, umur, no_pendaftaran, update_time, update_loginpemakai_id', 'safe'),
			
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        
			array('dokterpenerima_id, dpjp1_id, dpjp2_id, dpjp3_id, dpjp4_id, dpjp5_id, pasienpulang_id, tgl_awal, tgl_akhir, keterangankeluar, nama_bin, nama_pasien, alamatrsrujukan,telp_fax, kepadayth,lainlain_ruj,catatandokterperujuk,pengobatan_ruj,diagnosasementara_ruj,hasilpemeriksaan_ruj,alasandirujuk,dirujukkebagian,tgldirujuk,rumahsakitrujukan, jeniskasuspenyakit_nama, no_rekam_medik, kelurahan_nama, alamat_pasien, jeniskelamin, instalasi_nama, ruangan_nama, umur, no_pendaftaran,pasienadmisi_id, pendaftaran_id, pasien_id, tglpasienpulang, carakeluar_id, kondisikeluar_id, ruanganakhir_id, penerimapasien, lamarawat, satuanlamarawat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, hariperawatan', 'safe', 'on'=>'search'),
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
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
                    'carakeluar'=>array(self::BELONGS_TO, 'CarakeluarM','carakeluar_id'),
                    'kondisikeluar'=>array(self::BELONGS_TO, 'KondisiKeluarM','kondisikeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienpulang_id' => 'Pasienpulang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tglpasienpulang' => 'Tanggal Pasien Pulang',
			'carakeluar_id' => 'Cara Keluar',
			'kondisikeluar_id' => 'Kondisi Pulang',
			'ruanganakhir_id' => 'Ruangan Akhir',
			'penerimapasien' => 'Penerima Pasien',
			'lamarawat' => 'Lama Rawat',
			'satuanlamarawat' => 'Satuan Lama Rawat',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tgl_meninggal' => 'Tanggal Meninggal',
                        'keterangankeluar'=> 'Keterangan Pulang',
			'hariperawatan' => 'Hari Perawatan',
            'dokterpenerima_id'=>'Dokter Penerima',
            'dpjp1_id'=>'Dokter DPJP 1',
            'dpjp2_id'=>'Dokter DPJP 2',
            'dpjp3_id'=>'Dokter DPJP 3',
			'dpjp4_id'=>'Dokter DPJP 4',
			'dpjp5_id'=>'DOkter DPJP 5',
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

		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('kondisikeluar_id',$this->kondisikeluar_id);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('hariperawatan',$this->hariperawatan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('kondisikeluar_id',$this->kondisikeluar_id);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('hariperawatan',$this->hariperawatan);
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

        public function beforeSave() {          
            return parent::beforeSave();
        }
                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true));
        }
        
        
	public function cekSisaPembayaranUntukPulang() {
		if ($this->carakeluar_id != Params::CARAKELUAR_ID_DIPULANGKAN) return true;
		
		$tindakan = TindakanpelayananT::model()->findByAttributes(array(
			'pendaftaran_id'=>$this->pendaftaran_id
		), array(
			'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0 and tarif_satuan > 0'
		));
		
		$oa = ObatalkespasienT::model()->findByAttributes(array(
			'pendaftaran_id'=>$this->pendaftaran_id,
		), array(
			'condition'=>'oasudahbayar_id is null and qty_oa <> 0 and hargasatuan_oa > 0'
		));
		
		return (empty($tindakan) && empty($oa));

		
		
		// var_dump($this->attributes); die;
		
	}
	
	
	public function cekSisaPembayaran($pendaftaran_id) {		
		
		$tindakan = TindakanpelayananT::model()->findByAttributes(array(
			'pendaftaran_id'=>$pendaftaran_id
		), array(
			'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0'
		));
		
		$oa = ObatalkespasienT::model()->findByAttributes(array(
			'pendaftaran_id'=>$pendaftaran_id,
		), array(
			'condition'=>'oasudahbayar_id is null and qty_oa <> 0'
		));
		
		return (empty($tindakan) && empty($oa));

		
		
		// var_dump($this->attributes); die;
		
	}
}