<?php

/**
 * This is the model class for table "pengirimanspesimen_t".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'pengirimanspesimen_t':
 * @property integer $pengirimanspesimen_id
 * @property string $tglkirimspesimen
 * @property string $no_kirimspesimen
 * @property integer $ruangan_id
 * @property integer $petugaskirim_id
 * @property string $keterangan_pengiriman
 */
class PengirimanspesimenT extends CActiveRecord {

    public $ruangankirim_nama, $instalasi_id, $instalasikirim_nama, $petugaskirim_nama,
            $tgl_akhir, $tgl_awal, $count_kirim, $count_terima, $batalpenerimaanspesimen_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengirimanspesimenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengirimanspesimen_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, petugaskirim_id, ruangantujuan_id', 'numerical', 'integerOnly' => true),
            array('no_kirimspesimen', 'length', 'max' => 50),
            array('tglkirimspesimen, keterangan_pengiriman', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengirimanspesimen_id, tglkirimspesimen, no_kirimspesimen, ruangan_id, petugaskirim_id, keterangan_pengiriman, ruangantujuan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'penerimaanspesimenTs' => array(self::HAS_MANY, 'PenerimaanspesimenT', 'pengirimanspesimen_id'),
            'pengirimanspesimendetTs' => array(self::HAS_MANY, 'PengirimanspesimendetT', 'pengirimanspesimen_id'),
            'ruanganasal' => array(self::HAS_ONE, 'RuanganM', 'ruangan_id'),
            'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
            'petugaskirim' => array(self::BELONGS_TO, 'PegawaiM', 'petugaskirim_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pengirimanspesimen_id' => 'Pengirimanspesimen',
            'tglkirimspesimen' => 'Tglkirimspesimen',
            'no_kirimspesimen' => 'No Kirimspesimen',
            'ruangan_id' => 'Ruangan',
            'petugaskirim_id' => 'Petugaskirim',
            'keterangan_pengiriman' => 'Keterangan Pengiriman',
            'ruangantujuan_id' => 'Ruangantujuan',
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

        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('tglkirimspesimen', $this->tglkirimspesimen, true);
        $criteria->compare('no_kirimspesimen', $this->no_kirimspesimen, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('petugaskirim_id', $this->petugaskirim_id);
        $criteria->compare('keterangan_pengiriman', $this->keterangan_pengiriman, true);
        $criteria->compare('ruangantujuan_id', $this->ruangantujuan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load data informasi pengiriman spesimen
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return \CActiveDataProvider
     */
    public function searchInformasi(){
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.batalpengiriman_id IS NULL');
        $criteria->addBetweenCondition('DATE(t.tglkirimspesimen)', $this->tgl_awal, $this->tgl_akhir);

        $criteria->select = 'DISTINCT on (t.pengirimanspesimen_id) t.*, peg.nama_pegawai AS petugaskirim_nama,'
                            . '(SELECT 
                                    count(sub_kirim.pengirimanspesimen_id) as count_kirim
                                    from pengirimanspesimendet_t as sub_kirim
                                    where sub_kirim.pengirimanspesimen_id = t.pengirimanspesimen_id
                                ),
                                (SELECT 
                                    count(sub_terima.penerimaanspesimendet_id) as count_terima
                                    from pengirimanspesimendet_t as sub_terima
                                    where sub_terima.pengirimanspesimen_id = t.pengirimanspesimen_id
                                ), 
                                penerimaanspesimen_t.penerimaanspesimen_id,
                                penerimaanspesimen_t.batalpenerimaanspesimen_id ';
        if (!empty($this->pengirimanspesimen_status)) {
            if ($this->pengirimanspesimen_status == 'Sudah Diterima') {
                $criteria->addCondition("isterima IS true");
            } else {
                $criteria->addCondition("isterima IS false");
            }           
        }
        
        $criteria->join = 'LEFT JOIN pegawai_m as peg ON t.petugaskirim_id = peg.pegawai_id '
                        . 'LEFT JOIN penerimaanspesimen_t ON t.pengirimanspesimen_id = penerimaanspesimen_t.pengirimanspesimen_id';
        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('tglkirimspesimen', $this->tglkirimspesimen, true);
        $criteria->compare('no_kirimspesimen', $this->no_kirimspesimen, true);
        $criteria->compare('petugaskirim_id', $this->petugaskirim_id);
        $criteria->compare('keterangan_pengiriman', $this->keterangan_pengiriman, true);
        $criteria->compare('LOWER(peg.nama_pegawai)',strtolower($this->petugaskirim_nama),true);
        $criteria->compare('ruangantujuan_id', $this->ruangantujuan_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load data dialog penrimaan spesimen
     * @return \CActiveDataProvider
     */
    public function searchDialogPenerimaan(){
        $criteria = new CDbCriteria;
        $criteria->join = 'LEFT JOIN pengirimanspesimendet_t ON pengirimanspesimendet_t.pengirimanspesimen_id = t.pengirimanspesimen_id';
        $criteria->addCondition('t.batalpengiriman_id IS NULL');
        $criteria->addCondition('pengirimanspesimendet_t.penerimaanspesimendet_id IS NULL');
//        $criteria->addCondition('t.isterima IS FALSE');
        $criteria->compare('no_kirimspesimen', $this->no_kirimspesimen, true);
        $criteria->compare('tglkirimspesimen', $this->tglkirimspesimen, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
