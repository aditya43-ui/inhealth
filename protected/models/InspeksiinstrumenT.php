<?php

/**
 * This is the model class for table "inspeksiinstrumen_t".
 *
 * The followings are the available columns in table 'inspeksiinstrumen_t':
 * @property integer $inspeksiinstrumen_id
 * @property integer $pembersihan_id
 * @property string $ins_kebersihan
 * @property string $kebersihan_ket
 * @property string $ins_perubahanpermukaan
 * @property string $ins_lubrikasi
 * @property string $lubrikasi_ket
 * @property string $ins_fungsionalitas
 * @property string $fungsionalitas_ket
 * @property string $tindaklanjut
 * @property string $tindaklanjut_ket
 * @property integer $petugasinsp_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembersihanT $pembersihan
 */
class InspeksiinstrumenT extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    public $no_pembersihan, $tgl_pembersihan, $jenisperalatan, $barang_nama, $jml;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InspeksiinstrumenT the static model class
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
		return 'inspeksiinstrumen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembersihan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pembersihan_id, petugasinsp_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('ins_kebersihan', 'length', 'max'=>300),
			array('ins_perubahanpermukaan, ins_lubrikasi, ins_fungsionalitas', 'length', 'max'=>255),
			array('tindaklanjut', 'length', 'max'=>50),
			array('tgl_awal, tgl_akhir, perubahanpermukaan_ket, kebersihan_ket, lubrikasi_ket, fungsionalitas_ket, tindaklanjut_ket, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, no_pembersihan, barang_nama, tindaklanjut, inspeksiinstrumen_id, pembersihan_id, ins_kebersihan, kebersihan_ket, ins_perubahanpermukaan, ins_lubrikasi, lubrikasi_ket, ins_fungsionalitas, fungsionalitas_ket, tindaklanjut, tindaklanjut_ket, petugasinsp_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembersihan' => array(self::BELONGS_TO, 'PembersihanT', 'pembersihan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inspeksiinstrumen_id' => 'Inspeksiinstrumen',
			'pembersihan_id' => 'Pembersihan',
			'ins_kebersihan' => 'Kebersihan & sisa residu',
			'kebersihan_ket' => 'Kebersihan Ket',
			'ins_perubahanpermukaan' => 'Perubahan Permukaan',
			'ins_lubrikasi' => 'Lubrikasi',
			'lubrikasi_ket' => 'Lubrikasi Ket',
			'ins_fungsionalitas' => 'Fungsionalitas',
			'fungsionalitas_ket' => 'Fungsionalitas Ket',
			'tindaklanjut' => 'Tindaklanjut',
			'tindaklanjut_ket' => 'Tindaklanjut Ket',
			'petugasinsp_id' => 'Petugasinsp',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->inspeksiinstrumen_id)){
			$criteria->addCondition('t.inspeksiinstrumen_id = '.$this->inspeksiinstrumen_id);
		}
		if(!empty($this->pembersihan_id)){
			$criteria->addCondition('t.pembersihan_id = '.$this->pembersihan_id);
		}
		$criteria->compare('LOWER(t.ins_kebersihan)',strtolower($this->ins_kebersihan),true);
		$criteria->compare('LOWER(t.kebersihan_ket)',strtolower($this->kebersihan_ket),true);
		$criteria->compare('LOWER(t.ins_perubahanpermukaan)',strtolower($this->ins_perubahanpermukaan),true);
		$criteria->compare('LOWER(t.ins_lubrikasi)',strtolower($this->ins_lubrikasi),true);
		$criteria->compare('LOWER(t.lubrikasi_ket)',strtolower($this->lubrikasi_ket),true);
		$criteria->compare('LOWER(t.ins_fungsionalitas)',strtolower($this->ins_fungsionalitas),true);
		$criteria->compare('LOWER(t.fungsionalitas_ket)',strtolower($this->fungsionalitas_ket),true);
		$criteria->compare('LOWER(t.tindaklanjut)',strtolower($this->tindaklanjut),true);
		$criteria->compare('LOWER(t.tindaklanjut_ket)',strtolower($this->tindaklanjut_ket),true);
		if(!empty($this->petugasinsp_id)){
			$criteria->addCondition('t.petugasinsp_id = '.$this->petugasinsp_id);
		}
		$criteria->compare('LOWERt(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('t.update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}

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
        
        public function searchInformasi() {
            $prov = $this->search();
            
            
            $prov->criteria->addBetweenCondition('t.create_time::date', $this->tgl_awal, $this->tgl_akhir);
            
            $prov->criteria->compare("lower(p.no_pembersihan)", strtolower($this->no_pembersihan), true);
            $prov->criteria->compare("lower(ps.jenisperalatan)", strtolower($this->jenisperalatan), true);
            $prov->criteria->compare("lower(b.barang_nama)", strtolower($this->barang_nama), true);
            $prov->criteria->compare("lower(t.tindaklanjut)", strtolower($this->tindaklanjut), true);
            
            $prov->criteria->join = "join pembersihan_t p on p.pembersihan_id = t.pembersihan_id "
                    . "join dekontaminasi_t d on d.dekontaminasi_id = p.dekontaminasi_id "
                    . "join dekontaminasidetail_t dd on dd.dekontaminasi_id = d.dekontaminasi_id "
                    . "join penerimaansterilisasidet_t sd on sd.penerimaansterilisasidet_id = dd.penerimaansterilisasidet_id "
                    . "join peralatansterilisasi_m ps on ps.peralatansterilisasi_id = sd.peralatansterilisasi_id "
                    . "join barang_m b on b.barang_id = dd.barang_id";
            $prov->criteria->select = "t.*, p.tgl_pembersihan, p.no_pembersihan, ps.jenisperalatan, b.barang_nama, dd.dekontaminasidetail_jml as jml";
            
            return $prov;
        }
}