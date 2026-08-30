<?php

/**
 * This is the model class for table "bahanmakanan_m".
 *
 * The followings are the available columns in table 'bahanmakanan_m':
 * @property integer $bahanmakanan_id
 * @property integer $golbahanmakanan_id
 * @property string $sumberdanabhn
 * @property string $jenisbahanmakanan
 * @property string $kelbahanmakanan
 * @property string $namabahanmakanan
 * @property double $jmlpersediaan
 * @property string $satuanbahan
 * @property double $harganettobahan
 * @property double $hargajualbahan
 * @property double $discount
 * @property string $tglkadaluarsabahan
 * @property integer $jmlminimal
 * @property integer $jmldlmkemasan
 * 
 * The followings are the available model relations:
 * @property PengajuanbahandetailT[] $pengajuanbahandetailTs
 * @property StokbahanmakananT[] $stokbahanmakananTs
 * @property TerimabahandetailT[] $terimabahandetailTs
 * @property AnamesadietT[] $anamesadietTs
 * @property GolbahanmakananM $golbahanmakanan
 * @property BahanMenuDietM[] $bahanmenudietMs
 * @property ZatbahanmakanM[] $zatbahanmakanMs
 */
class BahanmakananM extends CActiveRecord {

    public $golbahanmakanan_nama, $qtystok;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BahanmakananM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bahanmakanan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('golbahanmakanan_id, jenisbahanmakanan, kelbahanmakanan, namabahanmakanan, harganettobahan, hargajualbahan, discount', 'required'),
            // array('golbahanmakanan_id, jenisbahanmakanan, kelbahanmakanan, namabahanmakanan, harganettobahan, hargajualbahan, discount, tglkadaluarsabahan', 'required'),
            array('golbahanmakanan_id, jmlminimal, jmldlmkemasan', 'numerical', 'integerOnly' => true),
            array('jmlpersediaan, harganettobahan, hargajualbahan, discount, hpp', 'numerical'),
            array('sumberdanabhn, jenisbahanmakanan, kelbahanmakanan, satuanbahan', 'length', 'max' => 50),
            array('namabahanmakanan', 'length', 'max' => 100),
            array('tglkadaluarsabahan, bahanmakanan_aktif, ket_spesifikasibahanmakanan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bahanmakanan_id, golbahanmakanan_id, sumberdanabhn, jenisbahanmakanan, kelbahanmakanan, namabahanmakanan, jmlpersediaan, satuanbahan, harganettobahan, hargajualbahan, discount, tglkadaluarsabahan, jmlminimal, jmldlmkemasan, ket_spesifikasibahanmakanan, hpp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pengajuanbahandetailTs' => array(self::HAS_MANY, 'PengajuanbahandetailT', 'bahanmakanan_id'),
            'stokbahanmakananTs' => array(self::HAS_MANY, 'StokbahanmakananT', 'bahanmakanan_id'),
            'terimabahandetailTs' => array(self::HAS_MANY, 'TerimabahandetailT', 'bahanmakanan_id'),
            'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'bahanmakanan_id'),
            'golbahanmakanan' => array(self::BELONGS_TO, 'GolbahanmakananM', 'golbahanmakanan_id'),
            'bahanmenudietMs' => array(self::HAS_MANY, 'BahanMenuDietM', 'bahanmakanan_id'),
            'zatbahanmakanMs' => array(self::HAS_MANY, 'ZatbahanmakanM', 'bahanmakanan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bahanmakanan_id' => 'Bahan Makanan',
            'golbahanmakanan_id' => 'Golongan Bahan Makanan',
            'sumberdanabhn' => 'Sumber Dana Bahan',
            'jenisbahanmakanan' => 'Jenis Bahan Makanan',
            'kelbahanmakanan' => 'Kelompok Bahan Makanan',
            'namabahanmakanan' => 'Nama Bahan Makanan',
            'jmlpersediaan' => 'Jumlah Persediaan',
            'satuanbahan' => 'Satuan Bahan',
            'harganettobahan' => 'Harga Netto Bahan',
            'hargajualbahan' => 'Harga Jual Bahan',
            'discount' => 'Keringanan',
            'tglkadaluarsabahan' => 'Tanggal Kedaluwarsa Bahan',
            'jmlminimal' => 'Jumlah Minimal',
            'jmldlmkemasan' => 'Jumlah dalam Kemasan',
            'bahanmakanan_aktif' => 'Aktif',
            'ket_spesifikasibahanmakanan' => 'Spesifikasi Bahan Makanan',
            
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if (!empty($this->jmlpersediaan)) {
            if (!empty($this->bahanmakanan_id)) {
                //$criteria->addCondition(" (SELECT sum(qty_masuk-qty_keluar) as totalstok FROM stokbahanmakanan_t)::text  ilike '%".$this->jmlpersediaan."%' ");
            }
        }
        $criteria->compare('bahanmakanan_id', $this->bahanmakanan_id);
        $criteria->compare('golbahanmakanan_id', $this->golbahanmakanan_id);
        $criteria->compare('LOWER(sumberdanabhn)', strtolower($this->sumberdanabhn), true);
        $criteria->compare('LOWER(jenisbahanmakanan)', strtolower($this->jenisbahanmakanan), true);
        $criteria->compare('LOWER(kelbahanmakanan)', strtolower($this->kelbahanmakanan), true);
        $criteria->compare('LOWER(namabahanmakanan)', strtolower($this->namabahanmakanan), true);
        $criteria->compare('jmlpersediaan', $this->jmlpersediaan);
        $criteria->compare('LOWER(satuanbahan)', strtolower($this->satuanbahan), true);
        $criteria->compare('harganettobahan', $this->harganettobahan);
        $criteria->compare('hargajualbahan', $this->hargajualbahan);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('LOWER(tglkadaluarsabahan)', strtolower($this->tglkadaluarsabahan), true);
        $criteria->compare('jmlminimal', $this->jmlminimal);
        $criteria->compare('jmldlmkemasan', $this->jmldlmkemasan);
        $criteria->compare('bahanmakanan_aktif', isset($this->bahanmakanan_aktif) ? $this->bahanmakanan_aktif : true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('bahanmakanan_id', $this->bahanmakanan_id);
        $criteria->compare('golbahanmakanan_id', $this->golbahanmakanan_id);
        $criteria->compare('LOWER(sumberdanabhn)', strtolower($this->sumberdanabhn), true);
        $criteria->compare('LOWER(jenisbahanmakanan)', strtolower($this->jenisbahanmakanan), true);
        $criteria->compare('LOWER(kelbahanmakanan)', strtolower($this->kelbahanmakanan), true);
        $criteria->compare('LOWER(namabahanmakanan)', strtolower($this->namabahanmakanan), true);
        $criteria->compare('jmlpersediaan', $this->jmlpersediaan);
        $criteria->compare('LOWER(satuanbahan)', strtolower($this->satuanbahan), true);
        $criteria->compare('harganettobahan', $this->harganettobahan);
        $criteria->compare('hargajualbahan', $this->hargajualbahan);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('LOWER(tglkadaluarsabahan)', strtolower($this->tglkadaluarsabahan), true);
        $criteria->compare('jmlminimal', $this->jmlminimal);
        $criteria->compare('jmldlmkemasan', $this->jmldlmkemasan);
        $criteria->compare('bahanmakanan_aktif', isset($this->bahanmakanan_aktif) ? $this->bahanmakanan_aktif : true);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
//                $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function getJenisBahanMakananItems() {
        return LookupM::model()->findAll("lookup_type='jenisbahanmakanan' AND lookup_aktif = TRUE ORDER BY lookup_name");
    }

    public function getKelBahanMakananItems() {
        return LookupM::model()->findAll("lookup_type='kelompokbahanmakanan' AND lookup_aktif = TRUE ORDER BY lookup_name");
    }

    public function getSumberDanaItems() {
        return LookupM::model()->findAll("lookup_type='sumberdanabahan' AND lookup_aktif = TRUE ORDER BY lookup_name");
    }

    public function getJmlDlmKemasanItems() {
        return LookupM::model()->findAll("lookup_type='jmldlmkemasan' AND lookup_aktif = TRUE ORDER BY lookup_name");
    }

    public function getSatuanBahanMakananItems() {
        return LookupM::model()->findAll("lookup_type='satuanbahanmakanan' AND lookup_aktif = TRUE ORDER BY lookup_name");
    }

    public function getGolBahanMakananItems() {
        return GolbahanmakananM::model()->findAll('golbahanmakanan_aktif=TRUE ORDER BY golbahanmakanan_nama');
    }

    public function getStokBahanMakanan() {
        $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar FROM stokbahanmakanan_t WHERE bahanmakanan_id = " . $this->bahanmakanan_id . " ORDER BY tgltransaksi";
        $stoks = Yii::app()->db->createCommand($sql)->queryAll();
        $selesai = false;
        $hasil = true;
        $out = 0;
        $in = 0;

            if (count((array)$stoks) == 0){
            $hasil = false;
        }
        foreach ($stoks as $i => $stok) {
            $in += $stok['qty_masuk'];
            $out += $stok['qty_keluar'];
        }
        $selisih = $in - $out;

        return $selisih;

        }
}
