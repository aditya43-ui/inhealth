<?php

/**
 * This is the model class for table "baserahterimadet_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'baserahterimadet_t':
 * @property integer $baserahterimadet_id
 * @property integer $baserahterima_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $nama_barang
 * @property string $satuan_barang
 * @property double $jumlah_barang
 * @property string $spesifikasi_barang
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $pajak_persen
 *
 * The followings are the available model relations:
 * @property BaserahterimaT $baserahterimadet
 */
class BaserahterimadetT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BaserahterimadetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'baserahterimadet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('baserahterima_id, nama_barang, satuan_barang, jumlah_barang', 'required'),
            array('baserahterima_id, barang_id', 'numerical', 'integerOnly' => true),
            array('jumlah_barang, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'numerical'),
            array('jenis_barang', 'length', 'max' => 100),
            array('nama_barang', 'length', 'max' => 300),
            array('satuan_barang', 'length', 'max' => 50),
            array('spesifikasi_barang', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('baserahterimadet_id, baserahterima_id, barang_id, jenis_barang, nama_barang, satuan_barang, jumlah_barang, spesifikasi_barang, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'baserahterimadet' => array(self::BELONGS_TO, 'BaserahterimaT', 'baserahterimadet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'baserahterimadet_id' => 'Baserahterimadet',
            'baserahterima_id' => 'Baserahterima',
            'barang_id' => 'Barang',
            'jenis_barang' => 'Jenis Barang',
            'nama_barang' => 'Nama Barang',
            'satuan_barang' => 'Satuan Barang',
            'jumlah_barang' => 'Jumlah Barang',
            'spesifikasi_barang' => 'Spesifikasi Barang',
            'harga_satuan' => 'Harga Satuan',
            'jumlah_harga' => 'Jumlah Harga',
            'jumlah_pajak' => 'Jumlah Pajak',
            'pajak_persen' => 'Pajak Persen',
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

        $criteria->compare('baserahterimadet_id', $this->baserahterimadet_id);
        $criteria->compare('baserahterima_id', $this->baserahterima_id);
        $criteria->compare('barang_id', $this->barang_id);
        $criteria->compare('jenis_barang', $this->jenis_barang, true);
        $criteria->compare('nama_barang', $this->nama_barang, true);
        $criteria->compare('satuan_barang', $this->satuan_barang, true);
        $criteria->compare('jumlah_barang', $this->jumlah_barang);
        $criteria->compare('spesifikasi_barang', $this->spesifikasi_barang, true);
        $criteria->compare('harga_satuan', $this->harga_satuan);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('jumlah_pajak', $this->jumlah_pajak);
        $criteria->compare('pajak_persen', $this->pajak_persen);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}