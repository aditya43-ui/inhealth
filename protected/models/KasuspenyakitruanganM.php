<?php

/**
 * This is the model class for table "kasuspenyakitruangan_m".
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'kasuspenyakitruangan_m':
 * @property integer $ruangan_id
 * @property integer $jeniskasuspenyakit_id
 */
class KasuspenyakitruanganM extends CActiveRecord {

    public $jeniskasuspenyakit_nama, $jeniskasuspenyakit_namalainnya, $ruangan_nama, $kasuspenyakit;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KasuspenyakitruanganM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kasuspenyakitruangan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, jeniskasuspenyakit_id', 'required'),
            array('ruangan_id, jeniskasuspenyakit_id', 'cekdata'),
//                                                array('ruangan_id, jeniskasuspenyakit_id', 'unique', 'on'=>'insert, create, update'),
            array('ruangan_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ruangan_id, jeniskasuspenyakit_id, ruangan_nama, jeniskasuspenyakit_nama, jeniskasuspenyakit_namalainnya', 'safe', 'on' => 'search'),
        );
    }
    /**
     * 
     * @param object $attribute digunakan menampung attribute
     * @param string $params digunakan untuk menampung param
     * @return boolean
     */
    public function cekdata($attribute, $params) {
        $querydata = KasuspenyakitruanganM::model()->findAllByAttributes(array('ruangan_id' => $this->ruangan_id, 'jeniskasuspenyakit_id' => $this->jeniskasuspenyakit_id));
        if (!$this->hasErrors()) {
            if (count((array)$querydata) > 0) {
                $this->addError('ruangan_id, jeniskasuspenyakit_id', ' Kasus ' . $this->jeniskasuspenyakit->jeniskasuspenyakit_nama . ' untuk poli ' . $this->ruangan->ruangan_nama . ' telah tersedia di database');
                return false;
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ruangan_id' => 'Ruangan',
            'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
            'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
            'jeniskasuspenyakit_namalainnya' => 'Nama Lainnya',
            'instalasi_nama' => 'Instalasi',
            'ruangan_nama' => 'Ruangan',
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
        $criteria->with = array('ruangan', 'jeniskasuspenyakit');
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_namalainnya)', strtolower($this->jeniskasuspenyakit_namalainnya), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * digunakan untuk search tabel
     */
    public function searchTabel() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $sessionruangan = Yii::app()->user->ruangan_id;
        $criteria = new CDbCriteria;
        $criteria->with = array('ruangan', 'jeniskasuspenyakit');
        $criteria->order = 't.ruangan_id';
        if (Yii::app()->controller->module->id == 'sistemAdministrator') {
            $criteria->addCondition('ruangan.instalasi_id = ' . Params::INSTALASI_ID_LAB);
        } else {
            $criteria->compare('t.ruangan_id', $sessionruangan);
        }
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_namalainnya)', strtolower($this->jeniskasuspenyakit_namalainnya), true);
        //$criteria->order = 't.ruangan_id ASC';	

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'jeniskasuspenyakit_nama' => array(
                        'asc' => 'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                        'desc' => 'jeniskasuspenyakit.jeniskasuspenyakit_nama DESC'
                    ),
                    'jeniskasuspenyakit_id' => array(
                        'asc' => 'jeniskasuspenyakit.jeniskasuspenyakit_id ASC',
                        'desc' => 'jeniskasuspenyakit.jeniskasuspenyakit_id DESC'
                    ),
                    'jeniskasuspenyakit_namalainnya' => array(
                        'asc' => 'jeniskasuspenyakit.jeniskasuspenyakit_namalainnya ASC',
                        'desc' => 'jeniskasuspenyakit.jeniskasuspenyakit_namalainnya DESC'
                    )
                )
            )
        ));
    }
    
    /**
     * digunakan untuk search print
     * @return \CActiveDataProvider mengirim kriteria pencarian
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $sessionruangan = Yii::app()->user->ruangan_id;
        $criteria = new CDbCriteria;
        $criteria->with = array('ruangan', 'jeniskasuspenyakit');
        $criteria->order = 't.ruangan_id';
        if (Yii::app()->controller->module->id == 'sistemAdministrator') {
            $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        } else {
            $criteria->compare('t.ruangan_id', $sessionruangan);
        }
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_namalainnya)', strtolower($this->jeniskasuspenyakit_namalainnya), true);
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Mengambil daftar semua kabupaten
     * @return CActiveDataProvider 
     */
    public function getRuanganItems() {
        return RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC");
    }
    
    /**
     * digunakan untuk get jenis kasus penyakit
     * @return object mengembalikan data sesuai kriteria pencarian
     */
    public function getJenisKasusPenyakitItems() {
        return JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC");
    }

}
