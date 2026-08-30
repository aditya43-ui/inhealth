<?php

/**
 * This is the model class for table "kepuasanpasien_t".
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * RSST-2664 
 * menghilangkan mandatory kp_namapelapor, kp_noidentitasn_pelapor, kp_alamat_pelapor
 * @package application.models
 * The followings are the available columns in table 'kepuasanpasien_t':
 * @property integer $kepuasanpasien_id
 * @property integer $pasien_id
 * @property integer $layanansurvei_id
 * @property string $kepuasanpasien_tgl
 * @property integer $kp_sangattidakpuas
 * @property integer $kp_tidakpuas
 * @property integer $kp_kurangpuas
 * @property integer $kp_puas
 * @property integer $kp_sangatpuas
 * @property string $kp_platform
 * @property string $kp_iphost
 * @property string $kp_namamodul
 * @property string $kp_namaunit
 * @property string $kp_namapelapor
 * @property string $kp_noidentitasn_pelapor
 * @property string $kp_alamat_pelapor
 * @property string $kp_hp_pelapor
 * @property string $kp_deskripsi_aduan
 * @property string $kp_tindaklanjut
 * @property string $kp_tindaklanjut_tgl
 * @property string $kp_tindaklanjut_desk
 */
class KepuasanpasienT extends CActiveRecord
{
	public $nama_pasien, $no_rekam_medik, $ruangan_id, $instalasi_id, $layanansurvei;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KepuasanpasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kepuasanpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('layanansurvei_id, kategoripengaduan_id, kepuasanpasien_tgl, kp_sangatpuas, kp_hp_pelapor, kp_deskripsi_aduan', 'required', 'message' => '{attribute} Harus Diisi'),
			array('pasien_id, layanansurvei_id, kategoripengaduan_id, kp_sangattidakpuas, kp_tidakpuas, kp_kurangpuas, kp_puas, kp_sangatpuas', 'numerical', 'integerOnly'=>true),
			array('kp_iphost, kp_namamodul, kp_namaunit, kp_noidentitasn_pelapor', 'length', 'max'=>50),
			array('kp_namapelapor, kp_hp_pelapor', 'length', 'max'=>100),
			array('kp_alamat_pelapor', 'length', 'max'=>200),
			array('kp_tindaklanjut_desk, kp_tindakawal_desk', 'length', 'max'=>2000),
			array('kp_tindaklanjut', 'length', 'max'=>10),
			array('mediapengaduan', 'length', 'max'=>20),
			array('mediapengaduan, keterangankepuasan, kp_platform, kp_tindaklanjut_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kepuasanpasien_id, kategoripengaduan_id, pasien_id, layanansurvei_id, kepuasanpasien_tgl, kp_sangattidakpuas, kp_tidakpuas, kp_kurangpuas, kp_puas, kp_sangatpuas, kp_platform, kp_iphost, kp_namamodul, kp_namaunit, kp_namapelapor, kp_noidentitasn_pelapor, mediapengaduan, kp_alamat_pelapor, kp_hp_pelapor, kp_deskripsi_aduan, kp_tindaklanjut, kp_tindaklanjut_tgl, kp_tindaklanjut_desk, kp_tindakawal_desk', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kepuasanpasien_id' => 'Kepuasanpasien',
			'pasien_id' => 'Pasien',
			'layanansurvei_id' => 'Layanansurvei',
			'kepuasanpasien_tgl' => ' Tanggal Pengaduan',
			'kp_sangattidakpuas' => 'Kp Sangattidakpuas',
			'kp_tidakpuas' => 'Kp Tidakpuas',
			'kp_kurangpuas' => 'Kp Kurangpuas',
			'kp_puas' => 'Kp Puas',
			'kp_sangatpuas' => 'Kp Sangatpuas',
			'kp_platform' => 'Kp Platform',
			'kp_iphost' => 'Kp Iphost',
			'kp_namamodul' => 'Kp Namamodul',
			'kp_namaunit' => 'Kp Namaunit',
			'kp_namapelapor' => 'Nama Pelapor',
			'kp_noidentitasn_pelapor' => 'No Identitas Pelapor',
			'kp_alamat_pelapor' => 'Alamat Pelapor',
			'kp_hp_pelapor' => 'Telepon Yang Bisa Dihubungi',
			'kp_deskripsi_aduan' => 'Uraian Keluhan',
			'kp_tindaklanjut' => 'Kp Tindaklanjut',
			'kp_tindaklanjut_tgl' => 'Target Tanggal Penyelesaian',
			'kp_tindaklanjut_desk' => 'Tindakan Lanjut',
			'kp_tindakawal_desk'=>'Tindakan Awal',
			'nama_pasien'=>'Nama Pasien',
			'layanansurvei' => 'Pengaduan Laboratorium'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->kepuasanpasien_id)){
			$criteria->addCondition('kepuasanpasien_id = '.$this->kepuasanpasien_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->layanansurvei_id)){
			$criteria->addCondition('layanansurvei_id = '.$this->layanansurvei_id);
		}
		$criteria->compare('LOWER(kepuasanpasien_tgl)',strtolower($this->kepuasanpasien_tgl),true);
		if(!empty($this->kp_sangattidakpuas)){
			$criteria->addCondition('kp_sangattidakpuas = '.$this->kp_sangattidakpuas);
		}
		if(!empty($this->kp_tidakpuas)){
			$criteria->addCondition('kp_tidakpuas = '.$this->kp_tidakpuas);
		}
		if(!empty($this->kp_kurangpuas)){
			$criteria->addCondition('kp_kurangpuas = '.$this->kp_kurangpuas);
		}
		if(!empty($this->kp_puas)){
			$criteria->addCondition('kp_puas = '.$this->kp_puas);
		}
		if(!empty($this->kp_sangatpuas)){
			$criteria->addCondition('kp_sangatpuas = '.$this->kp_sangatpuas);
		}
		$criteria->compare('LOWER(kp_platform)',strtolower($this->kp_platform),true);
		$criteria->compare('LOWER(kp_iphost)',strtolower($this->kp_iphost),true);
		$criteria->compare('LOWER(kp_namamodul)',strtolower($this->kp_namamodul),true);
		$criteria->compare('LOWER(kp_namaunit)',strtolower($this->kp_namaunit),true);
		$criteria->compare('LOWER(kp_namapelapor)',strtolower($this->kp_namapelapor),true);
		$criteria->compare('LOWER(kp_noidentitasn_pelapor)',strtolower($this->kp_noidentitasn_pelapor),true);
		$criteria->compare('LOWER(kp_alamat_pelapor)',strtolower($this->kp_alamat_pelapor),true);
		$criteria->compare('LOWER(kp_hp_pelapor)',strtolower($this->kp_hp_pelapor),true);
		$criteria->compare('LOWER(kp_deskripsi_aduan)',strtolower($this->kp_deskripsi_aduan),true);
		$criteria->compare('LOWER(kp_tindaklanjut)',strtolower($this->kp_tindaklanjut),true);
		$criteria->compare('LOWER(kp_tindaklanjut_tgl)',strtolower($this->kp_tindaklanjut_tgl),true);
		$criteria->compare('LOWER(kp_tindaklanjut_desk)',strtolower($this->kp_tindaklanjut_desk),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}