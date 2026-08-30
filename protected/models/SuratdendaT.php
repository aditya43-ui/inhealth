<?php

/**
 * This is the model class for table "suratdenda_t".
 *
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'suratdenda_t':
 * @property integer $suratdenda_id
 * @property integer $suratperjanjiankerja_id
 * @property string $suratdenda_tanggal
 * @property string $suratdenda_nomor
 * @property string $nomor_dokumen
 * @property integer $supplier_id
 * @property string $terminke
 * @property double $termin_persen
 * @property string $tangga_keterlambatan
 * @property integer $ketuapphp_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SuratdendadetT[] $suratdendadetTs
 * @property SupplierM $supplier
 * @property PegawaiM $ketuapphp
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class SuratdendaT extends CActiveRecord
{
        public $supplier_nama;
        public $termindari;
        public $tanggal_awal, $tanggal_akhir;
        public $supplier_alamat;
        public $ketuapphp_nama;
        public $namapekerjaan;
        public $nama_lengkap;
        public $persiapanpengadaan_id;
        public $total_termin;
        public $termin_ke;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratdendaT the static model class
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
		return 'suratdenda_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suratdenda_tanggal, suratdenda_nomor, supplier_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, supplier_id, ketuapphp_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('termin_persen', 'numerical'),
			array('suratdenda_nomor, nomor_dokumen', 'length', 'max'=>50),
			array('terminke', 'length', 'max'=>5),
			array('tanggal_keterlambatan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratdenda_id, suratperjanjiankerja_id, suratdenda_tanggal, suratdenda_nomor, nomor_dokumen, supplier_id, terminke, termin_persen, tangga_keterlambatan, ketuapphp_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'suratdendadetTs' => array(self::HAS_MANY, 'SuratdendadetT', 'suratdenda_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'ketuapphp' => array(self::BELONGS_TO, 'PegawaiM', 'ketuapphp_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratdenda_id' => 'Suratdenda',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'suratdenda_tanggal' => 'Tanggal Surat',
			'suratdenda_nomor' => 'Nomor Transaksi',
			'nomor_dokumen' => 'Nomor Surat Denda',
			'supplier_id' => 'Penyedia',
			'terminke' => 'Terminke',
			'termin_persen' => 'Termin Persen',
			'tanggal_keterlambatan' => 'Tanggal Keterlambatan',
			'ketuapphp_id' => 'Ketuapphp',
                        'ketuapphp_nama' => 'Ketua PPHP/PJPHP',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tanggal_awal' => 'Tanggal Awal Pekerjaan',
                        'tanggal_akhir' => 'Tanggal Akhir Pekerjaan',
                        'supplier_nama' => 'Penyedia',
                        'supplier_alamat' => 'Alamat',
                        'nama_lengkap'=>'PPHP'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('suratdenda_id',$this->suratdenda_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('suratdenda_tanggal',$this->suratdenda_tanggal,true);
		$criteria->compare('suratdenda_nomor',$this->suratdenda_nomor,true);
		$criteria->compare('nomor_dokumen',$this->nomor_dokumen,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('terminke',$this->terminke,true);
		$criteria->compare('termin_persen',$this->termin_persen);
		$criteria->compare('tangga_keterlambatan',$this->tangga_keterlambatan,true);
		$criteria->compare('ketuapphp_id',$this->ketuapphp_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchRiwayat(){
            
            $cri = new CDbCriteria();
            $cri->select = " t.*, surat.namapekerjaan, s.supplier_nama, CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelar.gelarbelakang_nama) as nama_lengkap, surat.persiapanpengadaan_id ";
            $cri->join =  " JOIN suratperjanjiankerja_t surat ON surat.suratperjanjiankerja_id = t.suratperjanjiankerja_id "
                        . " JOIN supplier_m s ON s.supplier_id = t.supplier_id "
                        . " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.ketuapphp_id "
                        . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
            $cri->addCondition(" t.suratperjanjiankerja_id =".$this->suratperjanjiankerja_id);
            $cri->order = "terminke ASC";
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$cri,
            ));
        }
}