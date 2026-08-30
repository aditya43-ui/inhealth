<?php

/**
 * This is the model class for table "rencanaumumpengadaandet_t".
 *
 * The followings are the available columns in table 'rencanaumumpengadaandet_t':
 * 
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Aoda Rahmawati <aidarahmawati@.com>
 * @category model 
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * 
 * @property integer $rencanaumumpengadaandet_id
 * @property integer $rencanaumumpengadaan_id
 * @property string $rencanaumumpengadaandet_nama
 * @property string $rencanaumumpengadaandet_satuan
 * @property double $rencanaumumpengadaandet_volume
 * @property double $rencanaumumpengadaandet_harga
 * @property double $rencanaumumpengadaandet_pajak
 * @property double $rencanaumumpengadaandet_jumlah
 *
 * The followings are the available model relations:
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 */
class RencanaumumpengadaandetT extends CActiveRecord {

    public $jumlah, $harga, $sisapagu_pengadaan, $serapan;
    public $rencanaumumpengadaandet_volumeawal, $status;
    public $rencanaumumpengadaandet_estimasiawal;
    public $rencanaumumpengadaandet_persenpajakawal;
    public $rencanaumumpengadaandet_totalawal;
    public $rencanaumumpengadaandet_jumlahawal;
    public $persenawal, $volumeawal, $hargaawal;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RencanaumumpengadaandetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rencanaumumpengadaandet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rencanaumumpengadaan_id', 'numerical', 'integerOnly' => true),
            array('rencanaumumpengadaandet_volume, rencanaumumpengadaandet_harga, rencanaumumpengadaandet_pajak, rencanaumumpengadaandet_jumlah', 'numerical'),
            array('rencanaumumpengadaandet_satuan', 'length', 'max' => 50),
            array('dokumenpelaksanaananggarandet_id,rencanaumumpengadaandet_jmlpajak, jenis_barang, barang_id, rencanaumumpengadaandet_nama, paketpekerjaan_id, persenawal, volumeawal, hargaawal, rencanaumumpengadaandet_jumlahawal, pajak_persen', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rencanaumumpengadaandet_id, rencanaumumpengadaan_id, rencanaumumpengadaandet_nama, rencanaumumpengadaandet_satuan, rencanaumumpengadaandet_volume, rencanaumumpengadaandet_harga, rencanaumumpengadaandet_pajak, rencanaumumpengadaandet_jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
            'dokumenpelaksanaananggarandet' => array(self::BELONGS_TO, 'DokumenpelaksanaananggarandetT', 'dokumenpelaksanaananggarandet_id'),
            'paketpekerjaan' => array(self::BELONGS_TO, 'PaketpekerjaanT', 'paketpekerjaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rencanaumumpengadaandet_id' => 'Rencanaumumpengadaandet',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'rencanaumumpengadaandet_nama' => 'Rencanaumumpengadaandet Nama',
            'rencanaumumpengadaandet_satuan' => 'Rencanaumumpengadaandet Satuan',
            'rencanaumumpengadaandet_volume' => 'Rencanaumumpengadaandet Volume',
            'rencanaumumpengadaandet_harga' => 'Rencanaumumpengadaandet Harga',
            'rencanaumumpengadaandet_pajak' => 'Rencanaumumpengadaandet Pajak',
            'rencanaumumpengadaandet_jumlah' => 'Rencanaumumpengadaandet Jumlah',
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

        $criteria->compare('rencanaumumpengadaandet_id', $this->rencanaumumpengadaandet_id);
        $criteria->compare('rencanaumumpengadaan_id', $this->rencanaumumpengadaan_id);
        $criteria->compare('rencanaumumpengadaandet_nama', $this->rencanaumumpengadaandet_nama, true);
        $criteria->compare('rencanaumumpengadaandet_satuan', $this->rencanaumumpengadaandet_satuan, true);
        $criteria->compare('rencanaumumpengadaandet_volume', $this->rencanaumumpengadaandet_volume);
        $criteria->compare('rencanaumumpengadaandet_harga', $this->rencanaumumpengadaandet_harga);
        $criteria->compare('rencanaumumpengadaandet_pajak', $this->rencanaumumpengadaandet_pajak);
        $criteria->compare('rencanaumumpengadaandet_jumlah', $this->rencanaumumpengadaandet_jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Cari sisa pagu 
     * @param type $rencanaumumpengadaan_id
     * @param type $dokumenpelaksanaananggarandet_id
     * @return type
     */
    public function cariSisaPagu($rencanaumumpengadaan_id, $dokumenpelaksanaananggarandet_id){
        $sql = "select 
                dpadet_t.jumlah,
                (SELECT 
                    sum(rencanaumumpengadaandet_jumlah) as serapan
                    FROM rencanaumumpengadaandet_t rup_det 
                    join rencanaumumpengadaan_t rup on rup.rencanaumumpengadaan_id = rup_det.rencanaumumpengadaan_id
                    where rup_det.dokumenpelaksanaananggarandet_id = dpadet_t.dokumenpelaksanaananggarandet_id 
                    and rup.rencanaumumpengadaan_status NOT LIKE 'Dibatalkan' and rencanaumumpengadaandet_id != ".$rencanaumumpengadaan_id."
                group by dokumenpelaksanaananggarandet_id),
                (SELECT 
                    (dpadet_t.jumlah - sum(rencanaumumpengadaandet_jumlah)) as sisapagu_pengadaan
                    FROM rencanaumumpengadaandet_t rup_det 
                    join rencanaumumpengadaan_t rup on rup.rencanaumumpengadaan_id = rup_det.rencanaumumpengadaan_id
                    where rup_det.dokumenpelaksanaananggarandet_id = dpadet_t.dokumenpelaksanaananggarandet_id 
                    and rup.rencanaumumpengadaan_status NOT LIKE 'Dibatalkan' and rencanaumumpengadaandet_id != ".$rencanaumumpengadaan_id."
                group by dokumenpelaksanaananggarandet_id)
                from dokumenpelaksanaananggarandet_t dpadet_t
                where dpadet_t.dokumenpelaksanaananggarandet_id = ".$dokumenpelaksanaananggarandet_id;
        $modSisa = Yii::app()->db->createCommand($sql)->queryRow();
        
        $serapan = !empty($modSisa['serapan']) ? $modSisa['serapan'] : 0;
        $hitung = $modSisa['jumlah'] - $serapan;

        return $hitung;
    }
}
