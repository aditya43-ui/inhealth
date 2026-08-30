<?php

/**
 * This is the model class for table "bapembelianlangsung_t".
 *
 * @author Tantowi J <tantowijaya@com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'bapembelianlangsung_t':
 * @property integer $bapembelianlangsung_id
 * @property integer $suratperjanjiankerja_id
 * @property string $bapembelianlangsung_nomor
 * @property string $bapembelianlangsung_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegpihakkesatu_id
 * @property string $pihakkesatu_jabatan
 * @property integer $pegpihakkedua_id
 * @property string $pihakkedua_jabatan
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $total_harga
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BapembelianlangsungdetT[] $bapembelianlangsungdetTs
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property PegawaiM $pegpihakkedua
 * @property PegawaiM $pegpihakkesatu
 */
class BapembelianlangsungT extends CActiveRecord {

    public $dasar, $nomor;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapembelianlangsungT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bapembelianlangsung_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_beritaacara,suratperjanjiankerja_id, bapembelianlangsung_nomor, bapembelianlangsung_tanggal, jumlah_harga, jumlah_pajak, total_harga, create_time, create_loginpemakai_id, create_ruangan, pegpihakkesatu_id, pegpihakkedua_id', 'required'),
            array('suratperjanjiankerja_id, pegpihakkesatu_id, pegpihakkedua_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('jumlah_harga, jumlah_pajak, total_harga', 'numerical'),
            array('bapembelianlangsung_nomor, nomor_beritaacara', 'length', 'max' => 50),
            array('pihakkesatu_jabatan, pihakkedua_jabatan', 'length', 'max' => 100),
            array('nomor_urut, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bapembelianlangsung_id, suratperjanjiankerja_id, bapembelianlangsung_nomor, bapembelianlangsung_tanggal, nomor_beritaacara, pegpihakkesatu_id, pihakkesatu_jabatan, pegpihakkedua_id, pihakkedua_jabatan, jumlah_harga, jumlah_pajak, total_harga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bapembelianlangsungdetTs' => array(self::HAS_MANY, 'BapembelianlangsungdetT', 'bapembelianlangsung_id'),
            'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
            'pegpihakkedua' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkedua_id'),
            'pegpihakkesatu' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkesatu_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bapembelianlangsung_id' => 'Bapembelianlangsung',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'bapembelianlangsung_nomor' => 'Nomor Transaksi',
            'bapembelianlangsung_tanggal' => 'Tanggal Pembuatan BA',
            'nomor_beritaacara' => 'Nomor BA',
            'pegpihakkesatu_id' => 'Nama Pegawai',
            'pihakkesatu_jabatan' => 'Jabatan',
            'pegpihakkedua_id' => 'Nama Pegawai',
            'pihakkedua_jabatan' => 'Jabatan',
            'jumlah_harga' => 'Jumlah Harga',
            'jumlah_pajak' => 'Jumlah Pajak',
            'total_harga' => 'Total Harga',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
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

        if (!empty($this->bapembelianlangsung_id)) {
            $criteria->addCondition('bapembelianlangsung_id = ' . $this->bapembelianlangsung_id);
        }
        if (!empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('suratperjanjiankerja_id = ' . $this->suratperjanjiankerja_id);
        }
        $criteria->compare('LOWER(bapembelianlangsung_nomor)', strtolower($this->bapembelianlangsung_nomor), true);
        $criteria->compare('LOWER(bapembelianlangsung_tanggal)', strtolower($this->bapembelianlangsung_tanggal), true);
        $criteria->compare('LOWER(nomor_beritaacara)', strtolower($this->nomor_beritaacara), true);
        if (!empty($this->pegpihakkesatu_id)) {
            $criteria->addCondition('pegpihakkesatu_id = ' . $this->pegpihakkesatu_id);
        }
        $criteria->compare('LOWER(pihakkesatu_jabatan)', strtolower($this->pihakkesatu_jabatan), true);
        if (!empty($this->pegpihakkedua_id)) {
            $criteria->addCondition('pegpihakkedua_id = ' . $this->pegpihakkedua_id);
        }
        $criteria->compare('LOWER(pihakkedua_jabatan)', strtolower($this->pihakkedua_jabatan), true);
        $criteria->compare('jumlah_harga', $this->jumlah_harga);
        $criteria->compare('jumlah_pajak', $this->jumlah_pajak);
        $criteria->compare('total_harga', $this->total_harga);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
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
