<?php

/**
 * @author Tantowi J <tantowijaya@.com>
 *
 * The followings are the available columns in table 'kamaraplicare_r':
 * @property integer $kamaraplicare_id
 * @property integer $ruangan_id
 * @property string $kodekelas_aplicare
 * @property string $koderuang_aplicare
 * @property string $namaruang_aplicare
 * @property integer $kapasitas
 * @property integer $tersedia
 * @property integer $tersediapria
 * @property integer $tersediawanita
 * @property integer $tersediapriawanita
 * @package application.models
 */
class KamaraplicareR extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KamaraplicareR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kamaraplicare_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kodekelas_aplicare, koderuang_aplicare, namaruang_aplicare, kapasitas, tersedia', 'required'),
            array('ruangan_id, kapasitas, tersedia, tersediapria, tersediawanita, tersediapriawanita', 'numerical', 'integerOnly' => true),
            array('koderuang_aplicare, kodekelas_aplicare', 'length', 'max' => 50),
            array('namaruang_aplicare', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kamaraplicare_id, ruangan_id, kodekelas_aplicare, koderuang_aplicare, namaruang_aplicare, kapasitas, tersedia, tersediapria, tersediawanita, tersediapriawanita', 'safe', 'on' => 'search'),
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
            'kamaraplicare_id' => 'Kamaraplicare',
            'ruangan_id' => 'Ruangan',
            'kodekelas_aplicare' => 'Kode Kelas Aplicare',
            'koderuang_aplicare' => 'Kode Ruangan Aplicare',
            'namaruang_aplicare' => 'Nama Ruangan Aplicare',
            'kapasitas' => 'Kapasitas',
            'tersedia' => 'Tersedia',
            'tersediapria' => 'Tersedia Pria',
            'tersediawanita' => 'Tersedia Wanita',
            'tersediapriawanita' => 'Tersedia Pria Wanita',
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

        if (!empty($this->kamaraplicare_id)) {
            $criteria->addCondition('kamaraplicare_id = ' . $this->kamaraplicare_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(kodekelas_aplicare)', strtolower($this->kodekelas_aplicare), true);
        $criteria->compare('LOWER(koderuang_aplicare)', strtolower($this->koderuang_aplicare), true);
        $criteria->compare('LOWER(namaruang_aplicare)', strtolower($this->namaruang_aplicare), true);
        if (!empty($this->kapasitas)) {
            $criteria->addCondition('kapasitas = ' . $this->kapasitas);
        }
        if (!empty($this->tersedia)) {
            $criteria->addCondition('tersedia = ' . $this->tersedia);
        }
        if (!empty($this->tersediapria)) {
            $criteria->addCondition('tersediapria = ' . $this->tersediapria);
        }
        if (!empty($this->tersediawanita)) {
            $criteria->addCondition('tersediawanita = ' . $this->tersediawanita);
        }
        if (!empty($this->tersediapriawanita)) {
            $criteria->addCondition('tersediapriawanita = ' . $this->tersediapriawanita);
        }

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

    public static function updateKamarAplicare() {
        $criteria = new CDbCriteria;
        $criteria->select = "kl.kelaspelayanan_nama,r.ruangan_nama , t.kelaspelayanan_id,t.ruangan_id";
        $criteria->join = "join ruangan_m r on t.ruangan_id= r.ruangan_id  join kelaspelayanan_m kl on kl.kelaspelayanan_id=t.kelaspelayanan_id";
        $criteria->group = 'kl.kelaspelayanan_nama,r.ruangan_nama , t.kelaspelayanan_id,t.ruangan_id';
        $criteria->order = "kl.kelaspelayanan_nama ASC ";
        $modkamar = KamarruanganM::model()->findAll($criteria);
        
        
        $bpjs = new Bpjs_Vklaim();
        $bpjs->setInit();
        $profil = ProfilrumahsakitM::model()->find();

        $jumlah = 0;
        $terisi = 0;
        $tersedia = 0;

        foreach ($modkamar as $row) {

            $criteria1 = new CDbCriteria;
            $criteria1->select = "count(kamarruangan_jmlbed) as jumlah_bed";
            $criteria1->addCondition("ruangan_id=" . $row->ruangan_id);
            $criteria1->addCondition("kamarruangan_aktif is true");
            $modjmlbed = KamarruanganM::model()->find($criteria1);
            $jumlah = $modjmlbed->jumlah_bed;

            $criteria1 = new CDbCriteria;
            $criteria1->select = "count(kamarruangan_jmlbed) as jumlah_bed";
            $criteria1->addCondition("ruangan_id=" . $row->ruangan_id);
            $criteria1->addCondition("kamarruangan_status is false");
            $criteria1->addCondition("kamarruangan_aktif is true");
            $modjmlbed = KamarruanganM::model()->find($criteria1);
            $terisi = $modjmlbed->jumlah_bed;

            $criteria1 = new CDbCriteria;
            $criteria1->select = "count(kamarruangan_jmlbed) as jumlah_bed";
            $criteria1->addCondition("ruangan_id=" . $row->ruangan_id);
            $criteria1->addCondition("kamarruangan_status is true");
            $criteria1->addCondition("kamarruangan_aktif is true");
            $modjmlbed = KamarruanganM::model()->find($criteria1);
            $tersedia = $modjmlbed->jumlah_bed;



            $kamar = KamaraplicareR::model()->findByAttributes(array(
                'ruangan_id' => $row->ruangan_id,
                //'kelaspelayanan_id'=>$row->kelaspelayanan_id
            ));

            if (!empty($kamar)) {
                $res = $bpjs->aplicaresws_updateKamar($profil->ppkpelayanan, $kamar->kodekelas_aplicare, $kamar->koderuang_aplicare,
                    $row->ruangan_nama, $jumlah, $tersedia, 0, 0, $tersedia);

                $res_data = CJSON::decode($res);
                
                if ($res_data['metadata']['code'] == 1) {
                    $kamar->namaruang_aplicare = $row->ruangan_nama;
                    $kamar->kapasitas = $jumlah;
                    $kamar->tersedia = $tersedia;
                    $kamar->tersediapria = 0;
                    $kamar->tersediawanita = 0;
                    $kamar->tersediapriawanita = $tersedia;
                    $kamar->save();
                }
                
            }
        }
    }

}
