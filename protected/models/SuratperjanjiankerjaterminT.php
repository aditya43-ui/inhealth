<?php

/**
 * This is the model class for table "suratperjanjiankerjatermin_t".
 * @author Aida Rahmawati <aidarahamawati@.com>
 * @package application.models
 * @subpackage model
 * The followings are the available columns in table 'suratperjanjiankerjatermin_t':
 * @property integer $suratperjanjiankerjatermin_id
 * @property integer $suratperjanjiankerja_id
 * @property string $terminke
 * @property double $jumlah_persen
 * @property double $jumlah_harga
 * @property integer $urutan
 * @property string $termintanggal_awal
 * @property string $termintanggal_akhir
 *
 * The followings are the available model relations:
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class SuratperjanjiankerjaterminT extends CActiveRecord {

    public $jumlah_termin;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SuratperjanjiankerjaterminT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'suratperjanjiankerjatermin_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('suratperjanjiankerja_id, terminke, jumlah_persen, jumlah_harga', 'required'),
            array('suratperjanjiankerja_id, urutan', 'numerical', 'integerOnly' => true),
            array('jumlah_persen, jumlah_harga', 'numerical'),
            array('terminke', 'length', 'max' => 5),
            array('termintanggal_awal, termintanggal_akhir', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('suratperjanjiankerjatermin_id, suratperjanjiankerja_id, terminke, jumlah_persen, jumlah_harga, urutan, termintanggal_awal, termintanggal_akhir', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'suratperjanjiankerjatermin_id' => 'Suratperjanjiankerjatermin',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'terminke' => 'Terminke',
            'jumlah_persen' => 'Jumlah Persen',
            'jumlah_harga' => 'Jumlah Harga',
            'urutan' => 'Urutan',
            'termintanggal_awal' => 'Termintanggal Awal',
            'termintanggal_akhir' => 'Termintanggal Akhir',
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

        $criteria->compare('suratperjanjiankerjatermin_id', $this->suratperjanjiankerjatermin_id);
        $criteria->compare('suratperjanjiankerja_id', $this->suratperjanjiankerja_id);
        $criteria->compare('terminke', $this->terminke, true);
        $criteria->compare('jumlah_persen', $this->jumlah_persen);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('urutan', $this->urutan);
        $criteria->compare('termintanggal_awal', $this->termintanggal_awal, true);
        $criteria->compare('termintanggal_akhir', $this->termintanggal_akhir, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Menyusun List Termin
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @return string
     */
    public function getListTermin($suratperjanjiankerja_id) {
        $data = $this->findAll('suratperjanjiankerja_id = ' . $suratperjanjiankerja_id);
        $res = array();

        foreach ($data as $item) {
            $res[$item->terminke] = $item->terminke . " - " . $item->jumlah_persen . " - Rp" . number_format($item->jumlah_harga, 2, ',', '.');
        }

        return $res;
    }

}
