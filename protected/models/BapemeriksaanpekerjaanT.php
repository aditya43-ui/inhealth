<?php

/**
 * This is the model class for table "bapemeriksaanpekerjaan_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'bapemeriksaanpekerjaan_t':
 * @property integer $bapemeriksaanpekerjaan_id
 * @property integer $suratperjanjiankerja_id
 * @property string $bapemeriksaanpekerjaan_nomor
 * @property string $bapemeriksaanpekerjaan_tanggal
 * @property string $nomor_beritaacara
 * @property string $lokasi_pemeriksaan
 * @property integer $supplier_id
 * @property string $pa_keputusan
 * @property string $pa_nomorsk
 * @property string $pa_tanggalsk
 * @property string $pa_keptentang
 * @property string $bapemeriksaanpekerjaan_hasil
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property SupplierM $supplier
 * @property BapemeriksaanpekerjaandetT[] $bapemeriksaanpekerjaandetTs
 * @property BahasilpemeriksaanpekerjaanT[] $bahasilpemeriksaanpekerjaanTs
 */
class BapemeriksaanpekerjaanT extends CActiveRecord {
    public $dasar,$dasar2;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapemeriksaanpekerjaanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bapemeriksaanpekerjaan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('suratperjanjiankerja_id,nomor_beritaacara,bapemeriksaanpekerjaan_nomor, bapemeriksaanpekerjaan_tanggal, supplier_id, create_time, create_loginpemakai_id, create_ruangan, pa_tanggalsk, pa_nomorsk', 'required'),
            array('suratperjanjiankerja_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('bapemeriksaanpekerjaan_nomor, nomor_beritaacara, pa_nomorsk', 'length', 'max' => 50),
            array('lokasi_pemeriksaan, pa_keputusan, pa_keptentang', 'length', 'max' => 200),
            array('bapemeriksaanpekerjaan_hasil', 'length', 'max' => 100),
            array('pa_tanggalsk, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bapemeriksaanpekerjaan_id, suratperjanjiankerja_id, bapemeriksaanpekerjaan_nomor, bapemeriksaanpekerjaan_tanggal, nomor_beritaacara, lokasi_pemeriksaan, supplier_id, pa_keputusan, pa_nomorsk, pa_tanggalsk, pa_keptentang, bapemeriksaanpekerjaan_hasil, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'bapemeriksaanpekerjaandetTs' => array(self::HAS_MANY, 'BapemeriksaanpekerjaandetT', 'bapemeriksaanpekerjaan_id'),
            'bahasilpemeriksaanpekerjaanTs' => array(self::HAS_MANY, 'BahasilpemeriksaanpekerjaanT', 'bapemeriksaanpekerjaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bapemeriksaanpekerjaan_id' => 'Bapemeriksaanpekerjaan',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'bapemeriksaanpekerjaan_nomor' => 'Nomor Transaksi',
            'bapemeriksaanpekerjaan_tanggal' => 'Tanggal Pembuatan BA',
            'nomor_beritaacara' => 'Nomor BA',
            'lokasi_pemeriksaan' => 'Lokasi Pemeriksaan',
            'supplier_id' => 'Supplier',
            'pa_keputusan' => 'Keputusan PA',
            'pa_nomorsk' => 'Nomor SK',
            'pa_tanggalsk' => 'Tanggal SK',
            'pa_keptentang' => 'Keputusan Tentang',
            'bapemeriksaanpekerjaan_hasil' => 'Hasil Pemeriksaan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'terminke'=>'Termin Ke'
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

        if (!empty($this->bapemeriksaanpekerjaan_id)) {
            $criteria->addCondition('bapemeriksaanpekerjaan_id = ' . $this->bapemeriksaanpekerjaan_id);
        }
        if (!empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('suratperjanjiankerja_id = ' . $this->suratperjanjiankerja_id);
        }
        $criteria->compare('LOWER(bapemeriksaanpekerjaan_nomor)', strtolower($this->bapemeriksaanpekerjaan_nomor), true);
        $criteria->compare('LOWER(bapemeriksaanpekerjaan_tanggal)', strtolower($this->bapemeriksaanpekerjaan_tanggal), true);
        $criteria->compare('LOWER(nomor_beritaacara)', strtolower($this->nomor_beritaacara), true);
        $criteria->compare('LOWER(lokasi_pemeriksaan)', strtolower($this->lokasi_pemeriksaan), true);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('supplier_id = ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(pa_keputusan)', strtolower($this->pa_keputusan), true);
        $criteria->compare('LOWER(pa_nomorsk)', strtolower($this->pa_nomorsk), true);
        $criteria->compare('LOWER(pa_tanggalsk)', strtolower($this->pa_tanggalsk), true);
        $criteria->compare('LOWER(pa_keptentang)', strtolower($this->pa_keptentang), true);
        $criteria->compare('LOWER(bapemeriksaanpekerjaan_hasil)', strtolower($this->bapemeriksaanpekerjaan_hasil), true);
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
    
    /**
     * Load data pemeriksaan pekerjaan yang belum dibuat hasil pemeriksaan pekerjaannya 
     * @param type $suratperjanjiankerja_id
     * @return string
     */
    public function getPemeriksaanPekerjaan($suratperjanjiankerja_id) {
        $cr = new CDbCriteria();
        $cr->select = "t.*";
        $cr->addCondition('t.suratperjanjiankerja_id = '.$suratperjanjiankerja_id);
        $cr->addCondition('bapemeriksaanpekerjaan_id not in (select bapemeriksaanpekerjaan_id from bahasilpemeriksaanpekerjaan_t)');
        $data = $this->findAll($cr);
        $res = array();

        foreach ($data as $item) {
            if ($item->termin_persen == '100') {
                $res[$item->bapemeriksaanpekerjaan_id] = $item->bapemeriksaanpekerjaan_nomor." - Non Termin";
            } else {
                $res[$item->bapemeriksaanpekerjaan_id] = $item->bapemeriksaanpekerjaan_nomor." - Termin ".$item->terminke." (".$item->termin_persen." %)";
            }
                
        }

        return $res;
    }

}
