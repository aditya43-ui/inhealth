<?php
/**
 * This is the model class for table "obatalkesfarmasi_v".
 *
 * The followings are the available columns in table 'obatalkesfarmasi_v':
 * @property integer $obatalkes_id
 * @property integer $lokasigudang_id
 * @property string $lokasigudang_nama
 * @property integer $therapiobat_id
 * @property string $therapiobat_nama
 * @property integer $pbf_id
 * @property string $pbf_kode
 * @property string $pbf_nama
 * @property integer $generik_id
 * @property string $generik_nama
 * @property integer $satuanbesar_id
 * @property string $satuanbesar_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property double $harganetto
 * @property double $hargajual
 * @property double $discount
 * @property string $tglkadaluarsa
 * @property integer $minimalstok
 * @property string $formularium
 * @property boolean $discountinue
 * @property boolean $obatalkes_aktif
 * @property boolean $obatalkes_farmasi
 * @property string $obatalkes_barcode
 * @property double $ppn_persen
 * @property string $activedate
 * @property boolean $mintransaksi
 * @property string $obatalkes_namalain
 * @property double $margin
 * @property double $gp_persen
 * @property double $hargaaverage
 * @property double $hargamaksimum
 * @property double $hargaminimum
 * @property string $image_obat
 * @property string $noregister
 * @property string $nobatch
 * @property double $marginresep
 * @property double $jasadokter
 * @property double $hjaresep
 * @property double $marginnonresep
 * @property double $hjanonresep
 * @property double $hpp
 * @property string $jnskelompok
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_namalain
 * @property boolean $jenisobatalkes_farmasi
 * @property boolean $jenisobatalkes_aktif
 * @property integer $subjenis_id
 * @property string $subjenis_kode
 * @property string $subjenis_nama
 * @property string $subjenis_namalainnya
 * @property boolean $subjenis_farmasi
 * @property boolean $subjenis_aktif
 */
class ObatalkesfarmasiV extends CActiveRecord
{
	//JANGAN MENAMBAH PUBLIC VARIABEL TANPA IZIN
	public $satuankecilNama;
	public $sumberdanaNama;
	public $satuanbesarNama;
	public $generikNama;
	public $pbfNama;
	public $lokasigudangNama;
	public $therapiobatNama;
	public $formObatAlkesDetail = false;
	public $tglkadaluarsa_akhir, $tglkadaluarsa_awal;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesfarmasiV the static model class
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
		return 'obatalkesfarmasi_v';
	}

	/**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('obatalkes_id, lokasigudang_id, therapiobat_id, pbf_id, generik_id, satuanbesar_id, satuankecil_id, sumberdana_id, jenisobatalkes_id, kemasanbesar, kekuatan, minimalstok, subjenis_id', 'numerical', 'integerOnly'=>true),
            array('harganetto, hargajual, discount, ppn_persen, margin, gp_persen, hargaaverage, hargamaksimum, hargaminimum, marginresep, jasadokter, hjaresep, marginnonresep, hjanonresep, hpp', 'numerical'),
            array('lokasigudang_nama, therapiobat_nama, pbf_nama, generik_nama, noregister, subjenis_nama, subjenis_namalainnya', 'length', 'max'=>100),
            array('pbf_kode, obatalkes_kadarobat, satuankekuatan, jnskelompok', 'length', 'max'=>20),
            array('satuanbesar_nama, satuankecil_nama, sumberdana_nama, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori, formularium, obatalkes_namalain, nobatch, jenisobatalkes_namalain', 'length', 'max'=>50),
            array('obatalkes_kode, obatalkes_nama, obatalkes_barcode, image_obat', 'length', 'max'=>200),
            array('jenisobatalkes_kode, subjenis_kode', 'length', 'max'=>10),
            array('tglkadaluarsa, discountinue, obatalkes_aktif, obatalkes_farmasi, activedate, mintransaksi, jenisobatalkes_farmasi, jenisobatalkes_aktif, subjenis_farmasi, subjenis_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('obatalkes_id, lokasigudang_id, lokasigudang_nama, therapiobat_id, therapiobat_nama, pbf_id, pbf_kode, pbf_nama, generik_id, generik_nama, satuanbesar_id, satuanbesar_nama, satuankecil_id, satuankecil_nama, sumberdana_id, sumberdana_nama, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kemasanbesar, kekuatan, satuankekuatan, harganetto, hargajual, discount, tglkadaluarsa, minimalstok, formularium, discountinue, obatalkes_aktif, obatalkes_farmasi, obatalkes_barcode, ppn_persen, activedate, mintransaksi, obatalkes_namalain, margin, gp_persen, hargaaverage, hargamaksimum, hargaminimum, image_obat, noregister, nobatch, marginresep, jasadokter, hjaresep, marginnonresep, hjanonresep, hpp, jnskelompok, jenisobatalkes_kode, jenisobatalkes_namalain, jenisobatalkes_farmasi, jenisobatalkes_aktif, subjenis_id, subjenis_kode, subjenis_nama, subjenis_namalainnya, subjenis_farmasi, subjenis_aktif', 'safe', 'on'=>'search'),
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
                                    'lokasigudang'=>array(self::BELONGS_TO, 'LokasigudangM','lokasigudang_id'),
                                    'therapiobat'=>array(self::BELONGS_TO, 'TherapiobatM','therapiobat_id'),
                                    'pbf'=>array(self::BELONGS_TO, 'PbfM','pbf_id'),
                                    'generik'=>array(self::BELONGS_TO, 'GenerikM','generik_id'),
                                    'satuanbesar'=>array(self::BELONGS_TO, 'SatuanbesarM','satuanbesar_id'),
                                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM','sumberdana_id'),
                                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM','satuankecil_id'),
                                    'jenisobatalkes'=>array(self::BELONGS_TO, 'JenisobatalkesM','jenisobatalkes_id'),
                                    'detailobat'=>array(self::HAS_MANY,  'ObatalkesdetailM', 'obatalkes_id'),
                                    'subjenis'=>array(self::BELONGS_TO, 'SubjenisM','subjenis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkes_id' => 'ID',
			'lokasigudang_id' => 'Lokasi Gudang',
			'therapiobat_id' => 'Terapi Obat',
			'pbf_id' => 'PBF',
			'generik_id' => 'Generik',
			'satuanbesar_id' => 'Satuan Besar',
			'sumberdana_id' => 'Sumber Dana',
			'satuankecil_id' => 'Satuan Kecil', 
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'obatalkes_kode' => 'Kode',
			'obatalkes_nama' => ' Nama',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'kemasanbesar' => 'Kemasan Besar',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuan Kekuatan',
			'harganetto' => 'Harga Netto',
			'hargajual' => 'Harga Jual',
			'discount' => 'Keringanan',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'tglkadaluarsa_akhir' => 'Sampai Dengan',
			'minimalstok' => 'Stok Minimal',
			'formularium' => 'Formularium',
			'discountinue' => 'Discountinue',
			'obatalkes_aktif' => 'Aktif',
			'satuankecilNama' => 'Satuan Kecil',
			'sumberdanaNama' => 'Sumber Dana',

			'lokasigudangNama'=>'Lokasi Gudang',
			'satuanbesarNama'=>'Satuan Besar',

			'rakobat_id'=>'Rak Obat',
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

		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('lokasigudang_id',$this->lokasigudang_id);
		$criteria->compare('LOWER(lokasigudang_nama)',strtolower($this->lokasigudang_nama),true);
		//$criteria->compare('therapiobat_id',$this->therapiobat_id);
		//$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('generik_id',$this->generik_id);
		$criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		//$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('obatalkes_aktif',$this->obatalkes_aktif);
		$criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
//		$criteria->compare('movingavarage',$this->movingavarage);	// Tidak tersedia di tabel view tsb
//		$criteria->compare('hargamaks',$this->hargamaks);			// Tidak tersedia di tabel view tsb
//		$criteria->compare('hargamin',$this->hargamin);				// Tidak tersedia di tabel view tsb

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('lokasigudang_id',$this->lokasigudang_id);
		$criteria->compare('LOWER(lokasigudang_nama)',strtolower($this->lokasigudang_nama),true);
		$criteria->compare('therapiobat_id',$this->therapiobat_id);
		$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('generik_id',$this->generik_id);
		$criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('obatalkes_aktif',$this->obatalkes_aktif);
		$criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('ppn_persen',$this->ppn_persen);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('gp_persen',$this->gp_persen);
//		$criteria->compare('movingavarage',$this->movingavarage);	// Tidak tersedia di tabel view tsb
//		$criteria->compare('hargamaks',$this->hargamaks);			// Tidak tersedia di tabel view tsb
//		$criteria->compare('hargamin',$this->hargamin);				// Tidak tersedia di tabel view tsb
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function searchGudangFarmasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('sumberdana','satuankecil', 'satuanbesar');
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.lokasigudang_id',$this->lokasigudang_id);
                $criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',  strtolower($this->lokasigudangNama));
		$criteria->compare('t.therapiobat_id',$this->therapiobat_id);
                $criteria->compare('LOWER(therapiobat.therapiobat_nama)',  strtolower($this->therapiobatNama));
		$criteria->compare('t.generik_id',$this->generik_id);
		$criteria->compare('t.satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',  strtolower($this->satuanbesarNama));
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('t.satuankecil_id',$this->satuankecil_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('obatalkes_aktif',$this->obatalkes_aktif);
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
//         public function beforeSave() {         
//            if($this->tglkadaluarsa===null || trim($this->tglkadaluarsa)==''){
//	        $this->setAttribute('tglkadaluarsa', null);
//            }
//            return parent::beforeSave();
//        }
//
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
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
        
        public function getLokasiGudangItems()
        {
            return LokasigudangM::model()->findAll(array('order'=>'lokasigudang_nama'));
        
        }
        
        public function getTherapiObatItems()
        {
            return TherapiobatM::model()->findAll(array('order'=>'therapiobat_nama'));
        }
        
        public function getPbfItems()
        {
            return PbfM::model()->findAll(array('order'=>'pbf_nama'));
        }
        
        public function getGenerikItems()
        {
            return GenerikM::model()->findAll(array('order'=>'generik_nama'));
        }
        
        public function getSatuanBesarItems()
        {
            return SatuanbesarM::model()->findAll(array('order'=>'satuanbesar_nama'));
        }
        
        public function getSatuanKecilItems()
        {
            return GFSatuanKecilM::model()->findAll('satuankecil_aktif=TRUE ORDER BY satuankecil_nama');
        }
        
        public function getJenisObatAlkesItems()
        {
            return JenisobatalkesM::model()->findAll('jenisobatalkes_aktif=TRUE ORDER BY jenisobatalkes_nama');
        }
        
         public function getSumberDanaItems()
        {
            return SumberdanaM::model()->findAll('sumberdana_aktif=TRUE ORDER BY sumberdana_nama');            
        }
        
        public function showKomposisi($detailObat)
        {
            //$tmp = '<div class="raw">';
            $tmp = '';
            foreach ($detailObat as $obat) {
                $tmp = $tmp.$obat->komposisi.'';
            }
            //$tmp = $tmp.'</div>';
            return $tmp;

        }
}