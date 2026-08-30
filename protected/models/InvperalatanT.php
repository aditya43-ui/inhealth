<?php

/**
 * This is the model class for table "invperalatan_t".
 *
 * The followings are the available columns in table 'invperalatan_t':
 * @property integer $invperalatan_id
 * @property integer $lokasi_id
 * @property integer $barang_id
 * @property integer $asalaset_id
 * @property integer $pemilikbarang_id
 * @property string $invperalatan_kode
 * @property string $invperalatan_noregister
 * @property string $invperalatan_namabrg
 * @property string $invperalatan_merk
 * @property string $invperalatan_ukuran
 * @property string $invperalatan_bahan
 * @property string $invperalatan_thnpembelian
 * @property string $invperalatan_tglguna
 * @property string $invperalatan_nopabrik
 * @property string $invperalatan_norangka
 * @property string $invperalatan_nomesin
 * @property string $invperalatan_nopolisi
 * @property string $invperalatan_nobpkb
 * @property double $invperalatan_harga
 * @property double $invperalatan_akumsusut
 * @property string $invperalatan_ket
 * @property string $invperalatan_kapasitasrata
 * @property boolean $invperalatan_ijinoperasional
 * @property string $invperalatan_serftkkalibrasi
 * @property integer $invperalatan_umurekonomis
 * @property string $invperalatan_keadaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $terimapersdetail_id
 * @property double $invperalatan_nilairesidu
 * @property integer $umurekonomis
 * @property string $tglpenghapusan
 * @property string $tipepenghapusan
 * @property double $hargajualaktiva
 * @property double $kerugian
 * @property double $keuntungan
 *
 * The followings are the available model relations:
 * @property TerimapersdetailT $terimapersdetail
 */
class InvperalatanT extends CActiveRecord
{
        public $jmlterima,$nopenerimaan,$kode_urut;
        public $custom, $default;
        public $sumberdana_nama;
        public $ruangan_nama, $lokasiaset_namalokasi, $lokasi_nama;
        public $lokasi_id, $ruanganaset_nama;
        public $load_belum_aset_opname;
        public $ceklis_kode, $periodeasetopname_id;
        public $barang_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvperalatanT the static model class
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
		return 'invperalatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('barang_id, pemilikbarang_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_umurekonomis, invperalatan_keadaan, create_time, create_loginpemakai_id, create_ruangan, invperalatan_tglguna', 'required'),
            array('lokasi_id, barang_id, asalaset_id, pemilikbarang_id, invperalatan_umurekonomis, terimapersdetail_id, umurekonomis', 'numerical', 'integerOnly'=>true),
            array('invperalatan_harga, invperalatan_akumsusut, invperalatan_nilairesidu, hargajualaktiva, kerugian, keuntungan', 'numerical'),
            array('invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan', 'length', 'max'=>50),
            array('invperalatan_kapasitasrata, invperalatan_serftkkalibrasi, invperalatan_namabrg, invperalatan_bahan', 'length', 'max'=>100),
            array('invperalatan_thnpembelian', 'length', 'max'=>5),
            // array('invperalatan_kapasitasrata', 'length', 'max'=>10),
            // array('invperalatan_serftkkalibrasi', 'length', 'max'=>20),
            array('tipepenghapusan', 'length', 'max'=>25),
            array('invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, update_time, update_loginpemakai_id, tglpenghapusan', 'safe'),
            ['nomor_kontrak, tanggal_perolehan, cara_perolehan, sumberdana, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, ruangan_id','safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
			array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			
            array('invperalatan_id, lokasi_id, barang_id, asalaset_id, pemilikbarang_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, terimapersdetail_id, invperalatan_nilairesidu, umurekonomis, tglpenghapusan, tipepenghapusan, hargajualaktiva, kerugian, keuntungan', 'safe', 'on'=>'search'),
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
                    'pemilik' => array(self::BELONGS_TO, 'PemilikbarangM', 'pemilikbarang_id'),
                    'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
                    'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
                    'asal'=>array(self::BELONGS_TO,'AsalasetM','asalaset_id'),
					'terimapersdetail' => array(self::BELONGS_TO, 'TerimapersdetailT', 'terimapersdetail_id'),
                     'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invperalatan_id' => 'ID ',
			'lokasi_id' => 'Lokasi',
			'barang_id' => 'Barang',
			'asalaset_id' => 'Asal Aset',
			'pemilikbarang_id' => 'Pemilik Barang',
			'invperalatan_kode' => 'Kode',
			'invperalatan_noregister' => 'No. Register',
			'invperalatan_namabrg' => ' Nama Peralatan',
			'invperalatan_merk' => 'Merk',
			'invperalatan_ukuran' => 'Ukuran',
			'invperalatan_bahan' => 'Bahan',
			'invperalatan_thnpembelian' => 'Tahun Pembelian',
			'invperalatan_tglguna' => 'Tanggal Pengunaan',
			'invperalatan_nopabrik' => 'No. Pabrik',
			'invperalatan_norangka' => 'No. Rangka',
			'invperalatan_nomesin' => 'No. Mesin',
			'invperalatan_nopolisi' => 'No. Polisi',
			'invperalatan_nobpkb' => 'No. BPKB',
			'invperalatan_harga' => 'Harga',
			'invperalatan_akumsusut' => 'Akum Susut',
			'invperalatan_ket' => 'Keterangan',
			'invperalatan_kapasitasrata' => 'Kapasitas Rata',
			'invperalatan_ijinoperasional' => 'Izin Operasional',
			'invperalatan_serftkkalibrasi' => 'Sertifikat Kalibrasi',
			'invperalatan_umurekonomis' => 'Umur Ekonomis',
			'invperalatan_keadaan' => 'Keadaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'terimapersdetail_id' => 'Terima Persediaan',
            'invperalatan_nilairesidu' => 'Nilai Residu',
            'umurekonomis' => 'Umur Ekonomis',
            'tglpenghapusan' => 'Tanggal Penghapusan',
            'tipepenghapusan' => 'Tipe Penghapusan',
            'hargajualaktiva' => 'Harga Jual Aktiva',
            'kerugian' => 'Kerugian',
            'keuntungan' => 'Keuntungan',
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

		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		$criteria->compare('invperalatan_umurekonomis',$this->invperalatan_umurekonomis);
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
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
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		$criteria->compare('invperalatan_umurekonomis',$this->invperalatan_umurekonomis);
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
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
        public function getBarangItems()
        {
            return BarangM::model()->findAll(array('order'=>'barang_nama'));
        }
                public function getPemilikItems()
        {
            return PemilikbarangM::model()->findAll(array('order'=>'pemilikbarang_nama'));
        }
        public function getAsalAsetItems()
        {
            return AsalasetM::model()->findAll(array('order'=>'asalaset_nama'));
        }
                public function getLokasiAsetItems()
        {
            return LokasiasetM::model()->findAll(array('order'=>'lokasiaset_namalokasi'));
        }
        
        /**
         * pencarian untuk inventarisasi peralatan
         * @return \CActiveDataProvider
         */
        public function searchDialogInvPeralatan() {
            $criteria=new CDbCriteria;
            $criteria->select = [
                't.*',
                'lok.lokasiaset_namalokasi'
            ];
            $criteria->join = " LEFT JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id ";
            if ($this->custom == 'not_invperalatan_id'){
                if (is_array($this->invperalatan_id)){
                    $criteria->addNotInCondition('t.invperalatan_id', $this->invperalatan_id);
                }
            }else{
                $criteria->compare('t.invperalatan_id',$this->invperalatan_id);
            }
            if (!empty($this->ruangan_id)){
                $criteria->compare('t.ruangan_id',$this->ruangan_id);
            }

            if (!empty($this->lokasi_id)){
                $criteria->compare('t.lokasi_id',$this->lokasi_id);
            }


            if (!empty($this->default)){                    
                $criteria->addCondition(" t.invperalatan_id IS  NULL ");
            }

            if ($this->load_belum_aset_opname){
                $cond = '';
                if (!empty($this->periodeasetopname_id)){
                    $criteria->join .= " LEFT JOIN asetopname_t aset ON aset.invperalatan_id = t.invperalatan_id AND aset.periodeasetopname_id = ".$this->periodeasetopname_id;
                    $criteria->addCondition(" aset.asetopname_id IS NULL ");                                
                }
            }
            
            if (!empty($this->default)){
                $criteria->addCondition(" t.invperalatan_id is null ");
            }

            $criteria->compare('t.barang_id',$this->barang_id);
            $criteria->compare('t.asalaset_id',$this->asalaset_id);
            $criteria->compare('t.pemilikbarang_id',$this->pemilikbarang_id);
            $criteria->compare('LOWER(t.invperalatan_kode)',strtolower($this->invperalatan_kode),true);
            $criteria->compare('LOWER(t.invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
            $criteria->compare('LOWER(t.invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
            $criteria->compare('LOWER(t.invperalatan_merk)',strtolower($this->invperalatan_merk),true);
            $criteria->compare('LOWER(t.invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
            $criteria->compare('LOWER(t.invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
            $criteria->compare('LOWER(t.invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
            $criteria->compare('LOWER(t.invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
            $criteria->compare('LOWER(t.invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
            $criteria->compare('LOWER(t.invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
            $criteria->compare('LOWER(t.invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
            $criteria->compare('LOWER(t.invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
            $criteria->compare('LOWER(t.invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
            $criteria->compare('t.invperalatan_harga',$this->invperalatan_harga);
            $criteria->compare('t.invperalatan_akumsusut',$this->invperalatan_akumsusut);
            $criteria->compare('LOWER(t.invperalatan_ket)',strtolower($this->invperalatan_ket),true);
            $criteria->compare('LOWER(t.invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
            $criteria->compare('t.invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
            $criteria->compare('LOWER(t.invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
            $criteria->compare('t.invperalatan_umurekonomis',$this->invperalatan_umurekonomis);
            $criteria->compare('LOWER(t.invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
            $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('LOWER(lokasiaset_namalokasi)', strtolower($this->lokasiaset_namalokasi), true);
            $criteria->compare('LOWER(peralatan_noseri)', strtolower($this->peralatan_noseri), true);
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));    
        }
        
        
        /**
         * 
         * @param type $model
         * @param type $post
         * @return type
         */
        public static function simpan_data($model,$post){
            $ok = true;
            $format = new MyFormatter();
            
            $model->attributes = $post;
            $model->tglpenghapusan = !empty($model->tglpenghapusan)?$format->formatDateTimeForDb($model->tglpenghapusan):null;            
            $model->peralatan_garansihabis = !empty($model->peralatan_garansihabis)?$format->formatDateTimeForDb($model->peralatan_garansihabis):null; 
            $model->tanggal_perolehan = !empty($model->tanggal_perolehan)?$format->formatDateTimeForDb($model->tanggal_perolehan):null; 
            
            if (empty($model->invperalatan_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');                
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }
            
            $ok &= $model->save();
            
            $data['sukses'] = $ok;
            $data['model'] = $model;
            
            return $data;
        }
        
//         HINDARI PENGGUNAAN FUNCTION INI
//         protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date'){
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }elseif ($column->dbType == 'timestamp without time zone'){
//                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }
//            }
//
//            return parent::beforeValidate ();
//        }
//        
//        HINDARI PENGGUNAAN FUNCTION INI
//        protected function beforeSave() {  
//            if($this->invperalatan_tglguna===null || trim($this->invperalatan_tglguna)==''){
//	        $this->setAttribute('invperalatan_tglguna', null);
//            }
//            return parent::beforeSave();
//        }
//             
//                
//      HINDARI PENGGUNAAN FUNCTION INI   
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
}