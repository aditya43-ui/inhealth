<?php
/**
 * This is the model class for table "diagnosisaskep_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'diagnosisaskep_t':
 * @property integer $diagnosisaskep_id
 * @property integer $pengkajianaskep_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $no_diagnosisaskep
 * @property string $diagnosisaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawai
 * @property PengkajianaskepT $pengkajianaskep
 * @property RencanaaskepT[] $rencanaaskepTs
 * @property DiagnosisaskepdetT[] $diagnosisaskepdetTs
 */
class DiagnosisaskepT extends CActiveRecord
{
    public $nama_pegawai, $no_pendaftaran, $nama_pasien;
    public $ruangan_nama, $nama_lengkap, $sudahdipilih;
	

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'diagnosisaskep_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pengkajianaskep_id, pegawai_id, ruangan_id, no_diagnosisaskep, diagnosisaskep_tgl, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
            array('pengkajianaskep_id, pegawai_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('no_diagnosisaskep', 'length', 'max' => 20),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('diagnosisaskep_id, pengkajianaskep_id, pegawai_id, ruangan_id, no_diagnosisaskep, diagnosisaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pengkajianaskep' => array(self::BELONGS_TO, 'PengkajianaskepT', 'pengkajianaskep_id'),
            'rencanaaskepTs' => array(self::HAS_MANY, 'RencanaaskepT', 'diagnosisaskep_id'),
            'diagnosisaskepdetTs' => array(self::HAS_MANY, 'DiagnosisaskepdetT', 'diagnosisaskep_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'diagnosisaskep_id' => 'Diagnosisaskep',
            'pengkajianaskep_id' => 'Pengkajianaskep',
            'pegawai_id' => 'Pegawai',
            'ruangan_id' => 'Ruangan',
            'no_diagnosisaskep' => 'No. Diagnosisaskep',
            'diagnosisaskep_tgl' => 'Tanggal Diagnosa',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan_id' => 'Create Ruangan',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * 
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
                $criteria=new CDbCriteria;
                $criteria->select = " t.*, pen.no_pendaftaran, p.nama_pasien, (CASE WHEN pen.pasienadmisi_id IS NULL THEN r_pa.ruangan_nama ELSE r_pen.ruangan_nama END) as ruangan_nama, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,' ',gelar.gelarbelakang_nama) as nama_lengkap";
                $criteria->join = " LEFT JOIN pengkajianaskep_t peng ON peng.pengkajianaskep_id = t.pengkajianaskep_id "
                                . " LEFT JOIN pendaftaran_t pen ON peng.pendaftaran_id = pen.pendaftaran_id "
                                . " LEFT JOIN pasien_m p ON p.pasien_id = pen.pasien_id "
                                . " LEFT JOIN pasienadmisi_t pa ON pa.pasienadmisi_id = pen.pasienadmisi_id "
                                . " LEFT JOIN ruangan_m r_pen ON r_pen.ruangan_id = pen.ruangan_id "
                                . " LEFT JOIN ruangan_m r_pa ON r_pa.ruangan_id = pa.ruangan_id "
                                . " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
		$criteria->compare('LOWER(no_diagnosisaskep)', strtolower($this->no_diagnosisaskep),true);
                
                $criteria->addCondition(" r_pen.ruangan_nama ILIKE '%".$this->ruangan_nama."%' OR r_pa.ruangan_nama ILIKE '%".$this->ruangan_nama."%' ");
                $criteria->compare(" LOWER(peg.nama_pegawai) ", strtolower($this->nama_pegawai), true);
                if (!empty($this->diagnosisaskep_id)){
                    $criteria->addCondition(" t.diagnosisaskep_id = ".$this->diagnosisaskep_id." ");
                }
                 if (!empty($this->diagnosisaskep_tgl)) {
                    $diagnosisaskep_tgl = $this->getKonverviDateRange($this->diagnosisaskep_tgl);
                    $criteria->addBetweenCondition('DATE(diagnosisaskep_tgl)', $diagnosisaskep_tgl[0], $diagnosisaskep_tgl[1] );
        //			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->pengkajianaskep_tgl) . "'");
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>[
                            'defaultOrder'=>'diagnosisaskep_tgl DESC'
                        ]
		));
        }
        
        /**
        * Konversi tanggal
        * @param type $tgl
        * @return type
        */
       public function getKonverviDateRange($tgl) {
           $Tgl = (explode(" - ", $tgl));

           //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
           $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
           $Tgl[0] = $Tgl[0]->format('Y-m-d');
           $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
           $Tgl[1] = $Tgl[1]->format('Y-m-d');
           return array($Tgl[0], $Tgl[1]);
       }
}

