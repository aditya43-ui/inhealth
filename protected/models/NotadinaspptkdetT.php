<?php

/**
 * This is the model class for table "notadinaspptkdet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'notadinaspptkdet_t':
 * @property integer $notadinaspptkdet_id
 * @property integer $notadinaspptk_id
 * @property string $notadinaspptkdet_tanggal
 * @property string $notadinaspptkdet_uraian
 * @property string $notadinaspptkdet_jenisbarang
 * @property integer $barang_id
 * @property double $jumlah_harga
 * @property double $jumlah_pph22
 * @property double $jumlah_diterima
 * @property string $notadinaspptkdet_ket
 *
 * The followings are the available model relations:
 * @property NotadinaspptkT $notadinaspptk
 */
class NotadinaspptkdetT extends CActiveRecord {

    public $sisapagu_pengadaan, $jumlah_awal, $sisavolume_pengadaan, $suratperjanjiankerja_id, $selisih, $sisapagu_pengadaan_baru, $volume_awal, $volume_baru, $kodeanggaran, $subkegiatanprogram_id; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DokumenpelaksanaananggarandetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notadinaspptkdet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notadinaspptkdet_uraian, jumlah_diterima', 'required'),
            array('notadinaspptk_id, barang_id', 'numerical', 'integerOnly' => true),
            array('jumlah_harga, jumlah_pph22, jumlah_diterima', 'numerical'),
            array('notadinaspptkdet_ket', 'length', 'max' => 300),
            array('notadinaspptkdet_jenisbarang', 'length', 'max' => 100),
            array('notadinaspptkdet_uraian, pagu, serapan, sisa, dokumenpelaksanaananggarandet_id, harga_satuan, pajak_persen, barang_satuan, barang_volume, notadinaspptkdet_tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('notadinaspptkdet_id, notadinaspptk_id, notadinaspptkdet_tanggal, notadinaspptkdet_uraian, notadinaspptkdet_jenisbarang, barang_id, jumlah_harga, jumlah_pph22, jumlah_diterima, notadinaspptkdet_ket', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'notadinaspptk' => array(self::BELONGS_TO, 'NotadinaspptkT', 'notadinaspptk_id'),
            'dokumenpelaksanaananggarandet' => array(self::BELONGS_TO, 'DokumenpelaksanaananggarandetT', 'dokumenpelaksanaananggarandet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'notadinaspptkdet_id' => 'Notadinaspptkdet',
            'notadinaspptk_id' => 'Notadinaspptk',
            'notadinaspptkdet_tanggal' => 'Notadinaspptkdet Tanggal',
            'notadinaspptkdet_uraian' => 'Notadinaspptkdet Uraian',
            'notadinaspptkdet_jenisbarang' => 'Notadinaspptkdet Jenisbarang',
            'barang_id' => 'Barang',
            'jumlah_harga' => 'Jumlah Harga',
            'jumlah_pph22' => 'Jumlah Pph22',
            'jumlah_diterima' => 'Jumlah Diterima',
            'notadinaspptkdet_ket' => 'Notadinaspptkdet Ket',
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

        $criteria->compare('notadinaspptkdet_id', $this->notadinaspptkdet_id);
        $criteria->compare('notadinaspptk_id', $this->notadinaspptk_id);
        $criteria->compare('notadinaspptkdet_tanggal', $this->notadinaspptkdet_tanggal, true);
        $criteria->compare('notadinaspptkdet_uraian', $this->notadinaspptkdet_uraian, true);
        $criteria->compare('notadinaspptkdet_jenisbarang', $this->notadinaspptkdet_jenisbarang, true);
        $criteria->compare('barang_id', $this->barang_id);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('jumlah_pph22', $this->jumlah_pph22);
        $criteria->compare('jumlah_diterima', $this->jumlah_diterima);
        $criteria->compare('notadinaspptkdet_ket', $this->notadinaspptkdet_ket, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchDialogVerifikasi(){
        $criteria = new CDbCriteria();
        $criteria->join = "join dokumenpelaksanaananggarandet_t dok on t.dokumenpelaksanaananggarandet_id = dok.dokumenpelaksanaananggarandet_id 
                           join notadinaspptk_t nota on t.notadinaspptk_id = nota.notadinaspptk_id 
                           join mappingrekeninganggaran_m mapping on nota.mappingrekeninganggaran_id = mapping.mappingrekeninganggaran_id ";
        $criteria->select = "t.dokumenpelaksanaananggarandet_id, 
                            t.notadinaspptkdet_id, 
                            t.notadinaspptkdet_uraian, 
                            t.barang_volume, 
                            t.jumlah_diterima,
                            t.harga_satuan, 
                            mapping.rekeninganggaran5_id, 
                            mapping.mappingrekeninganggaran_id, 
                            mapping.kodeanggaran";
        if (empty($this->notadinaspptk_id)) {
            $criteria->addCondition('t.notadinaspptk_id is null ');
        } else {
            $criteria->addCondition('t.notadinaspptk_id = '.$this->notadinaspptk_id);
        }
        $criteria->addCondition("
                                ((SELECT 
                                dok.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) > 0 OR
                                (SELECT 
                                dok.jumlah - sum(jumlah) as sisa
                                FROM rincianrba_t 
                                where t.dokumenpelaksanaananggarandet_id = rincianrba_t.dokumenpelaksanaananggarandet_id 
                                group by dokumenpelaksanaananggarandet_id) is null)");

        $criteria->compare('lower(mapping.kodeanggaran)', strtolower($this->kodeanggaran), true);
        $criteria->compare('lower(t.notadinaspptkdet_uraian)', strtolower($this->notadinaspptkdet_uraian), true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
