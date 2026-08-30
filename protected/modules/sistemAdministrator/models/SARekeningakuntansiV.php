<?php

/**
 * This is the model class for table "rekeningakuntansi_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $nmrekeninglain1
 * @property string $rekening1_nb
 * @property boolean $rekening1_aktif
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $nmrekeninglain2
 * @property string $rekening2_nb
 * @property boolean $rekening2_aktif
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $nmrekeninglain3
 * @property string $rekening3_nb
 * @property boolean $rekening3_aktif
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $nmrekeninglain4
 * @property string $rekening4_nb
 * @property boolean $rekening4_aktif
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $nmrekeninglain5
 * @property string $rekening5_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rekening5_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property boolean $kelrekening_aktif
 */
class SARekeningakuntansiV extends RekeningakuntansiV {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RekeningakuntansiV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rekeningakuntansi_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek, kelrekening_id', 'numerical', 'integerOnly' => true),
            array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max' => 5),
            array('nmrekening1, nmrekeninglain1, namakelrekening', 'length', 'max' => 100),
            array('rekening5_nb', 'length', 'max' => 1),
            array('nmrekening2, nmrekeninglain2', 'length', 'max' => 200),
            array('nmrekening3, nmrekeninglain3', 'length', 'max' => 300),
            array('nmrekening4, nmrekeninglain4', 'length', 'max' => 400),
            array('nmrekening5, nmrekeninglain5', 'length', 'max' => 500),
            array('kelompokrek', 'length', 'max' => 20),
            array('koderekeningkel', 'length', 'max' => 50),
            array('rekening1_aktif, rekening2_aktif, rekening3_aktif, rekening4_aktif, keterangan, rekening5_aktif, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelrekening_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rekening1_id, kdrekening1, nmrekening1, nmrekeninglain1, rekening1_aktif, rekening2_id, kdrekening2, nmrekening2, nmrekeninglain2, rekening2_aktif, rekening3_id, kdrekening3, nmrekening3, nmrekeninglain3, rekening3_aktif, rekening4_id, kdrekening4, nmrekening4, nmrekeninglain4, rekening4_aktif, rekening5_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, keterangan, nourutrek, rekening5_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelrekening_id, koderekeningkel, namakelrekening, kelrekening_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rekening1_id' => 'Rekening1',
            'kdrekening1' => 'Kdrekening1',
            'nmrekening1' => 'Nmrekening1',
            'nmrekeninglain1' => 'Nmrekeninglain1',
            'rekening1_aktif' => 'Rekening1 Aktif',
            'rekening2_id' => 'Rekening2',
            'kdrekening2' => 'Kdrekening2',
            'nmrekening2' => 'Nmrekening2',
            'nmrekeninglain2' => 'Nmrekeninglain2',
            'rekening2_aktif' => 'Rekening2 Aktif',
            'rekening3_id' => 'Rekening3',
            'kdrekening3' => 'Kdrekening3',
            'nmrekening3' => 'Nmrekening3',
            'nmrekeninglain3' => 'Nmrekeninglain3',
            'rekening3_aktif' => 'Rekening3 Aktif',
            'rekening4_id' => 'Rekening4',
            'kdrekening4' => 'Kdrekening4',
            'nmrekening4' => 'Nmrekening4',
            'nmrekeninglain4' => 'Nmrekeninglain4',
            'rekening4_aktif' => 'Rekening4 Aktif',
            'rekening5_id' => 'Rekening5',
            'kdrekening5' => 'Kdrekening5',
            'nmrekening5' => 'Nmrekening5',
            'nmrekeninglain5' => 'Nmrekeninglain5',
            'rekening5_nb' => 'Rekening5 Nb',
            'keterangan' => 'Keterangan',
            'nourutrek' => 'Nourutrek',
            'rekening5_aktif' => 'Rekening5 Aktif',
            'kelompokrek' => 'Kelompokrek',
            'sak' => 'Sak',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'kelrekening_id' => 'Kelrekening',
            'koderekeningkel' => 'Koderekeningkel',
            'namakelrekening' => 'Namakelrekening',
            'kelrekening_aktif' => 'Kelrekening Aktif',
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

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition('t.rekening1_id = ' . $this->rekening1_id);
        }
        $criteria->compare('LOWER(t.kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(t.nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(t.nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
        $criteria->compare('t.rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition('t.rekening2_id = ' . $this->rekening2_id);
        }
        $criteria->compare('LOWER(t.kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(t.nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(t.nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
        $criteria->compare('t.rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition('t.rekening3_id = ' . $this->rekening3_id);
        }
        $criteria->compare('LOWER(t.kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(t.nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(t.nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
        $criteria->compare('t.rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition('t.rekening4_id = ' . $this->rekening4_id);
        }
        $criteria->compare('LOWER(t.kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(t.nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(t.nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
        $criteria->compare('t.rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition('t.rekening5_id = ' . $this->rekening5_id);
        }
        $criteria->compare('LOWER(t.kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(t.nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(t.nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
        $criteria->compare('LOWER(t.rekening5_nb)', strtolower($this->rekening5_nb), true);
        $criteria->compare('LOWER(t.keterangan)', strtolower($this->keterangan), true);
        if (!empty($this->nourutrek)) {
            $criteria->addCondition('t.nourutrek = ' . $this->nourutrek);
        }
        $criteria->compare('t.rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(t.kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('t.sak', $this->sak);
        $criteria->compare('LOWER(t.create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(t.update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(t.create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(t.update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(t.create_ruangan)', strtolower($this->create_ruangan), true);
        if (!empty($this->kelrekening_id)) {
            $criteria->addCondition('t.kelrekening_id = ' . $this->kelrekening_id);
        }
        $criteria->compare('LOWER(t.koderekeningkel)', strtolower($this->koderekeningkel), true);
        $criteria->compare('LOWER(t.namakelrekening)', strtolower($this->namakelrekening), true);
        $criteria->compare('t.kelrekening_aktif', $this->kelrekening_aktif);
        
        $criteria->join = 'join rekening1_m r1 on r1.rekening1_id = t.rekening1_id';
        $criteria->compare('r1.kelrekening_id', $this->kelrekening_id);

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

    public function searchDebit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'D'");

        // $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'kdrekening5',
            ),
        ));
    }
    
    public function searchKredit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'K'");

        // $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'kdrekening5',
            ),
        ));
    }

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
