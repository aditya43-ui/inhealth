<?php

/**
 * This is the model class for table "bahasilpemeriksaanpekerjaan_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'bahasilpemeriksaanpekerjaan_t':
 * @property integer $bahasilpemeriksaanpekerjaan_id
 * @property string $bahasilpemeriksaanpekerjaan_nomor
 * @property string $bahasilpemeriksaanpekerjaan_tanggal
 * @property string $nomor_beritaacara
 * @property integer $bapemeriksaanpekerjaan_id
 * @property integer $suratperjanjiankerja_id
 * @property integer $pegpihakkesatu_id
 * @property string $jabatan_pihakkesatu
 * @property integer $supplier_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property SupplierM $supplier
 * @property PegawaiM $pegpihakkesatu
 * @property BapemeriksaanpekerjaanT $bapemeriksaanpekerjaan
 */
class BahasilpemeriksaanpekerjaanT extends CActiveRecord {

    public $nomorsurat, $nomor, $nomor_beritaacara_pemeriksaanpekerjaan, $pegpihakkesatu_nama, 
           $pegpihakkesatu_nip, $pegpihakkesatu_alamat, $dasar,
           $termin_terminke, $termin_terminjumlah, $termin_termintotal;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BahasilpemeriksaanpekerjaanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bahasilpemeriksaanpekerjaan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_beritaacara,pegpihakkesatu_id, supplier_id, bapemeriksaanpekerjaan_id, bahasilpemeriksaanpekerjaan_nomor, bahasilpemeriksaanpekerjaan_tanggal, suratperjanjiankerja_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('bapemeriksaanpekerjaan_id, suratperjanjiankerja_id, pegpihakkesatu_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('bahasilpemeriksaanpekerjaan_nomor, nomor_beritaacara', 'length', 'max' => 50),
            array('jabatan_pihakkesatu', 'length', 'max' => 100),
            array('isantidatir, nomor_urut, total_harga, total_pembayaran, termin_persen, jumlah_harga, jumlah_pajak, total_dibulatkan, pajak_persen, terminke, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bahasilpemeriksaanpekerjaan_id, bahasilpemeriksaanpekerjaan_nomor, bahasilpemeriksaanpekerjaan_tanggal, nomor_beritaacara, bapemeriksaanpekerjaan_id, suratperjanjiankerja_id, pegpihakkesatu_id, jabatan_pihakkesatu, supplier_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
            'pegpihakkesatu' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkesatu_id'),
            'bapemeriksaanpekerjaan' => array(self::BELONGS_TO, 'BapemeriksaanpekerjaanT', 'bapemeriksaanpekerjaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bahasilpemeriksaanpekerjaan_id' => 'Bahasilpemeriksaanpekerjaan',
            'bahasilpemeriksaanpekerjaan_nomor' => 'Nomor Transaksi',
            'bahasilpemeriksaanpekerjaan_tanggal' => 'Tanggal Pembuatan BA',
            'nomor_beritaacara' => 'Nomor BA',
            'bapemeriksaanpekerjaan_id' => 'Pemeriksaan Pekerjaan',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'pegpihakkesatu_id' => 'Nama Pegawai',
            'jabatan_pihakkesatu' => 'Jabatan',
            'supplier_id' => 'Penyedia',
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

        if (!empty($this->bahasilpemeriksaanpekerjaan_id)) {
            $criteria->addCondition('bahasilpemeriksaanpekerjaan_id = ' . $this->bahasilpemeriksaanpekerjaan_id);
        }
        $criteria->compare('LOWER(bahasilpemeriksaanpekerjaan_nomor)', strtolower($this->bahasilpemeriksaanpekerjaan_nomor), true);
        $criteria->compare('LOWER(bahasilpemeriksaanpekerjaan_tanggal)', strtolower($this->bahasilpemeriksaanpekerjaan_tanggal), true);
        $criteria->compare('LOWER(nomor_beritaacara)', strtolower($this->nomor_beritaacara), true);
        if (!empty($this->bapemeriksaanpekerjaan_id)) {
            $criteria->addCondition('bapemeriksaanpekerjaan_id = ' . $this->bapemeriksaanpekerjaan_id);
        }
        if (!empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('suratperjanjiankerja_id = ' . $this->suratperjanjiankerja_id);
        }
        if (!empty($this->pegpihakkesatu_id)) {
            $criteria->addCondition('pegpihakkesatu_id = ' . $this->pegpihakkesatu_id);
        }
        $criteria->compare('LOWER(jabatan_pihakkesatu)', strtolower($this->jabatan_pihakkesatu), true);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('supplier_id = ' . $this->supplier_id);
        }
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
