<?php

/**
 * This is the model class for table "bapemeriksaanpekerjaandet_t".
 * 
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'bapemeriksaanpekerjaandet_t':
 * @property integer $bapemeriksaanpekerjaandet_id
 * @property integer $bapemeriksaanpekerjaan_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $nama_barang
 * @property string $satuan_barang
 * @property double $jumlah_barang
 * @property string $spesifikasi_barang
 * @property boolean $hasil_pemeriksaan
 * @property string $keterangan_pemeriksaan
 * @property string $keterangan_uji
 *
 * The followings are the available model relations:
 * @property BapemeriksaanpekerjaanT $bapemeriksaanpekerjaan
 */
class BapemeriksaanpekerjaandetT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapemeriksaanpekerjaandetT the static model class
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
        return 'bapemeriksaanpekerjaandet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama_barang, satuan_barang, jumlah_barang', 'required'),
            array('bapemeriksaanpekerjaan_id, barang_id', 'numerical', 'integerOnly'=>true),
            array('jumlah_barang, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'numerical'),
            array('jenis_barang', 'length', 'max'=>100),
            array('nama_barang, keterangan_pemeriksaan, keterangan_uji', 'length', 'max'=>300),
            array('satuan_barang', 'length', 'max'=>50),
            array('spesifikasi_barang', 'length', 'max'=>200),
            array('hasil_pemeriksaan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bapemeriksaanpekerjaandet_id, bapemeriksaanpekerjaan_id, barang_id, jenis_barang, nama_barang, satuan_barang, jumlah_barang, spesifikasi_barang, hasil_pemeriksaan, keterangan_pemeriksaan, keterangan_uji, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bapemeriksaanpekerjaan' => array(self::BELONGS_TO, 'BapemeriksaanpekerjaanT', 'bapemeriksaanpekerjaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bapemeriksaanpekerjaandet_id' => 'Bapemeriksaanpekerjaandet',
            'bapemeriksaanpekerjaan_id' => 'Bapemeriksaanpekerjaan',
            'barang_id' => 'Barang',
            'jenis_barang' => 'Jenis Barang',
            'nama_barang' => 'Nama Barang',
            'satuan_barang' => 'Satuan Barang',
            'jumlah_barang' => 'Jumlah Barang',
            'spesifikasi_barang' => 'Spesifikasi Barang',
            'hasil_pemeriksaan' => 'Hasil Pemeriksaan',
            'keterangan_pemeriksaan' => 'Keterangan Pemeriksaan',
            'keterangan_uji' => 'Keterangan Uji',
            'harga_satuan' => 'Harga Satuan',
            'jumlah_harga' => 'Jumlah Harga',
            'jumlah_pajak' => 'Jumlah Pajak',
            'pajak_persen' => 'Pajak Persen',
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

        if (!empty($this->bapemeriksaanpekerjaandet_id)) {
            $criteria->addCondition('bapemeriksaanpekerjaandet_id = ' . $this->bapemeriksaanpekerjaandet_id);
        }
        if (!empty($this->bapemeriksaanpekerjaan_id)) {
            $criteria->addCondition('bapemeriksaanpekerjaan_id = ' . $this->bapemeriksaanpekerjaan_id);
        }
        if (!empty($this->barang_id)) {
            $criteria->addCondition('barang_id = ' . $this->barang_id);
        }
        $criteria->compare('LOWER(jenis_barang)', strtolower($this->jenis_barang), true);
        $criteria->compare('LOWER(nama_barang)', strtolower($this->nama_barang), true);
        $criteria->compare('LOWER(satuan_barang)', strtolower($this->satuan_barang), true);
        $criteria->compare('jumlah_barang', $this->jumlah_barang);
        $criteria->compare('LOWER(spesifikasi_barang)', strtolower($this->spesifikasi_barang), true);
        $criteria->compare('hasil_pemeriksaan', $this->hasil_pemeriksaan);
        $criteria->compare('LOWER(keterangan_pemeriksaan)', strtolower($this->keterangan_pemeriksaan), true);
        $criteria->compare('LOWER(keterangan_uji)', strtolower($this->keterangan_uji), true);

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

}
