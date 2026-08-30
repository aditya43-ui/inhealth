<?php

/**
 * This is the model class for table "suratperjanjiankerjarincian_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'suratperjanjiankerjarincian_t':
 * @property integer $suratperjanjiankerjarincian_id
 * @property integer $dokumenpelaksanaananggarandet_id
 * @property integer $suratperjanjiankerja_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $barang_nama
 * @property string $barang_satuan
 * @property double $barang_jumlah
 * @property double $barang_harga
 * @property double $barang_total
 * @property double $pajak_jumlah
 * @property double $pajak_persen
 *
 * The followings are the available model relations:
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property DokumenpelaksanaananggarandetT $dokumenpelaksanaananggarandet
 */
class SuratperjanjiankerjarincianT extends CActiveRecord {


    public $hasil_uji, $keterangan_uji, $kodeanggaran, $default, $rincian_serapan, $sisa_pagu, $sisa_volume, $jumlah_awal, $volume_awal, $sebelum_pajak;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SuratperjanjiankerjarincianT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'suratperjanjiankerjarincian_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('suratperjanjiankerja_id, barang_nama, barang_satuan, barang_jumlah, barang_harga, barang_total, pajak_jumlah, pajak_persen', 'required'),
            array('dokumenpelaksanaananggarandet_id, suratperjanjiankerja_id, barang_id', 'numerical', 'integerOnly' => true),
            array('ongkos_kirim, barang_jumlah, barang_harga, barang_total, pajak_jumlah, pajak_persen', 'numerical'),
            array('jenis_barang', 'length', 'max' => 50),
            array('barang_satuan', 'length', 'max' => 100),
            array('barang_nama, nama_dpa, merk, obatalkes_id', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('suratperjanjiankerjarincian_id, dokumenpelaksanaananggarandet_id, suratperjanjiankerja_id, barang_id, jenis_barang, barang_nama, barang_satuan, barang_jumlah, barang_harga, barang_total, pajak_jumlah, pajak_persen', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
            'dokumenpelaksanaananggarandet' => array(self::BELONGS_TO, 'DokumenpelaksanaananggarandetT', 'dokumenpelaksanaananggarandet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'suratperjanjiankerjarincian_id' => 'Suratperjanjiankerjarincian',
            'dokumenpelaksanaananggarandet_id' => 'Dokumenpelaksanaananggarandet',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'barang_id' => 'Barang',
            'jenis_barang' => 'Jenis Barang',
            'barang_nama' => 'Barang Nama',
            'barang_satuan' => 'Barang Satuan',
            'barang_jumlah' => 'Barang Jumlah',
            'barang_harga' => 'Barang Harga',
            'barang_total' => 'Barang Total',
            'pajak_jumlah' => 'Pajak Jumlah',
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

        $criteria->compare('suratperjanjiankerjarincian_id', $this->suratperjanjiankerjarincian_id);
        $criteria->compare('dokumenpelaksanaananggarandet_id', $this->dokumenpelaksanaananggarandet_id);
        $criteria->compare('suratperjanjiankerja_id', $this->suratperjanjiankerja_id);
        $criteria->compare('barang_id', $this->barang_id);
        $criteria->compare('jenis_barang', $this->jenis_barang, true);
        $criteria->compare('barang_nama', $this->barang_nama, true);
        $criteria->compare('barang_satuan', $this->barang_satuan, true);
        $criteria->compare('barang_jumlah', $this->barang_jumlah);
        $criteria->compare('barang_harga', $this->barang_harga);
        $criteria->compare('barang_total', $this->barang_total);
        $criteria->compare('pajak_jumlah', $this->pajak_jumlah);
        $criteria->compare('pajak_persen', $this->pajak_persen);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load dialog verifikasi
     * @return \CActiveDataProvider
     */
    public function searchDialogVerifikasi() {
        $criteria = new CDbCriteria;
        $criteria->join = "join suratperjanjiankerja_t spk on t.suratperjanjiankerja_id = spk.suratperjanjiankerja_id 
                           join mappingrekeninganggaran_m mapping on spk.mappingrekeninganggaran_id = mapping.mappingrekeninganggaran_id 
                           join dokumenpelaksanaananggarandet_t dok on t.dokumenpelaksanaananggarandet_id = dok.dokumenpelaksanaananggarandet_id ";
        $criteria->select = "t.dokumenpelaksanaananggarandet_id, 
                            t.suratperjanjiankerjarincian_id, 
                            t.barang_nama, 
                            t.barang_jumlah, 
                            t.barang_total,
                            barang_harga, 
                            (SELECT 
                                sum(jumlah) as rincian_serapan
                                FROM rincianrba_t r
                                where r.dokumenpelaksanaananggarandet_id = t.dokumenpelaksanaananggarandet_id
                                group by dokumenpelaksanaananggarandet_id),
                            mapping.rekeninganggaran5_id, 
                            mapping.mappingrekeninganggaran_id, 
                            mapping.kodeanggaran";
        
        if (empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('t.suratperjanjiankerja_id is null ');
        } else {
            $criteria->addCondition('t.suratperjanjiankerja_id = '.$this->suratperjanjiankerja_id);
        }

        $criteria->compare('lower(mapping.kodeanggaran)', strtolower($this->kodeanggaran), true);
        $criteria->compare('lower(t.barang_nama)', strtolower($this->barang_nama), true);
        $criteria->addCondition("((SELECT 
                                dok.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) > 0 or (SELECT 
                                dok.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) is null )");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
