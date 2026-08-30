<?php

/**
 * This is the model class for table "supplier_m".
 *
 * The followings are the available columns in table 'supplier_m':
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_namalain
 * @property string $supplier_alamat
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $supplier_kodepos
 * @property string $supplier_npwp
 * @property string $supplier_website
 * @property string $supplier_email
 * @property string $supplier_cp
 * @property boolean $supplier_aktif
 */
class SupplierM extends CActiveRecord
{
        public $obatalkes_nama;
        public $supplier_jenisgizi = 'Gizi';
        public $obatAlkes;
        public $rekDebit, $rekKredit;
        public $rekening_debit, $rekening_kredit;
        public $propinsi_id, $kabupaten_id;
		public $is_pilihan;
		public $is_pilihand;
		public $is_pilihank;
        
        public $nomor_valid, $pilih;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierM the static model class
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
		return 'supplier_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_telp, supplier_kode, supplier_nama, supplier_alamat', 'required'),
                        array('supplier_kode','unique'),
			array('supplier_nama, supplier_namalain, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_cp, supplier_norekening, latitude, longitude', 'length', 'max'=>100),
			array('supplier_telp, supplier_fax, supplier_kodepos, supplier_website, supplier_email, supplier_jenis', 'length', 'max'=>50),
			array('is_pilihan, supplier_aktif, supplier_kabupaten, propinsi_id, kabupaten_id', 'safe'),	
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkes_nama, supplier_id, supplier_kode, obatAlkes, supplier_nama, supplier_namalain, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_website, supplier_email, supplier_cp, supplier_aktif, latitude, longitude, pbf_id, terminpembayaran', 'safe', 'on'=>'search'),
			array('supplier_npwp,supplier_norekening,supplier_kodepos,supplier_telp, supplier_fax, terminpembayaran', 'numerical', 'integerOnly'=>true),
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
			'supplierrek'=>array(self::HAS_MANY, 'SupplierrekM','supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'supplier_id' => 'ID',
			'supplier_kode' => 'Kode',
			'supplier_nama' => 'Nama Supplier',
			'supplier_namalain' => 'Nama Lainnya',
			'supplier_alamat' => 'Alamat',
			'supplier_propinsi' => 'Provinsi',
			'supplier_kabupaten' => 'Kabupaten',
			'supplier_telp' => 'Telp',
			'supplier_fax' => 'Fax',
			'supplier_kodepos' => 'Kode Pos',
			'supplier_npwp' => 'No. NPWP',
			'supplier_website' => 'Website',
			'supplier_email' => 'Email',
			'supplier_cp' => 'Contact Person',
                        'supplier_jenis' => 'Jenis Supplier',
                        'supplier_norekening' => 'Nomor Rekening',
			'supplier_aktif' => 'Aktif',
                        'obatalkes_nama' =>'Obat Alkes',
			'pbf_id'=>'Perusahaan Besar Farmasi',
                        'terminpembayaran'=>'Termin Pembayaran Supplier'
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

		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
		$criteria->compare('supplier_aktif',isset($this->supplier_aktif)?$this->supplier_aktif:true);
                $criteria->order='supplier_nama';   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                                $criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenisgizi),true);
		$criteria->compare('supplier_aktif',isset($this->supplier_aktif)?$this->supplier_aktif:true);
                $criteria->order='supplier_nama';   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchSupplier()
    {
    	$criteria=new CDbCriteria;

		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
        $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
        $criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenis),true);
		$criteria->compare('supplier_aktif',isset($this->supplier_aktif)?$this->supplier_aktif:true);
		$criteria->addCondition("supplier_id not in(select supplier_id from supplierrek_m)");
		// $criteria->where('supplier_id not in :supplier_id', array(':supplier_id'=>15))

        $criteria->order='supplier_nama'; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
    }    
	
	public function searchSupplierDialog()
    {
    	$criteria=new CDbCriteria;

		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
        $criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenis),false);
		$criteria->addCondition('supplier_aktif = true');

        $criteria->order='supplier_nama ASC'; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }    
	
        // select * from supplier_m where supplier_id not in (select supplier_id from supplierrek_m)
		//order by supplier_nama
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
                $criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
                $criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenisgizi),true);
		$criteria->compare('supplier_aktif',isset($this->supplier_aktif)?$this->supplier_aktif:true);
                $criteria->order='supplier_nama';   
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
        }
        
          public function beforeSave() {
            $this->supplier_namalain = strtoupper($this->supplier_namalain);
            $this->supplier_nama = ucwords(strtolower($this->supplier_nama));
            return parent::beforeSave();
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getkabupatenItems()
        {
            return KabupatenM::model()->findAll('kabupaten_aktif=TRUE ORDER BY kabupaten_nama');
        }
        
        public function getJenisSupplierItems()
        {
            return LookupM::model()->findAll("lookup_type='jenissupplier' ORDER BY lookup_name");
        }
        public static function getSupplierItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE ORDER BY supplier_nama ASC");
        }
        
        public static function getSupplierFarmasiItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='".Params::SUPPLIER_JENIS_FARMASI."' ORDER BY supplier_nama");
        }
        
        public static function getSupplierGiziItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='".Params::SUPPLIER_JENIS_GIZI."' ORDER BY supplier_nama");
        }
        
        public static function getSupplierUmumItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='".Params::SUPPLIER_JENIS_UMUM."' ORDER BY supplier_nama");
        }
                

        public function getSupplierRek()
        {
        	$attributes = array("supplier_id"=>$this->supplier_id);
        	$result = SupplierrekM::model()->findAllByAttributes($attributes);
        	$data = "";
        	foreach ($result as $value)
        	{
        		$rec = Rekening5M::model()->findBypk($value['rekening5_id']);
        		$data .= "<li>" . $rec->nmrekening5 ." (". $rec->rekening5_nb .")</li>";
        	}
        	return $data;

        }     
		
		public function searchDialog(){
			$criteria = new CDbCriteria();
			$criteria->addCondition(" supplier_aktif = TRUE ");
			$criteria->compare(" LOWER(supplier_nama) ", strtolower($this->supplier_nama), true);
			$criteria->compare(" LOWER(supplier_kode) ", strtolower($this->supplier_kode), true);
			$criteria->compare(" LOWER(supplier_jenis) ", strtolower($this->supplier_jenis), true);
			$criteria->order = " supplier_nama ASC ";
			$criteria->limit = 10;
			
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,				
			));
		}
        
        public function searchDialogSms()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->compare('t.supplier_id',$this->supplier_id);
			$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
			$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
			$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
			$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
			$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
			$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
			$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
			$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
			$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
			$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
			$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
			$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
			$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
			$criteria->compare('LOWER(supplier_cp_hp)',strtolower($this->supplier_cp_hp),true);
					$criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
			$criteria->addCondition('supplier_aktif IS TRUE');
					if($this->nomor_valid==1){
						$criteria->addCondition("length(supplier_cp_hp) >= 9 OR LEFT(supplier_cp_hp, 2) = '08' OR LEFT(supplier_cp_hp, 4) = '+628'");
					}
					$criteria->order='supplier_nama';   
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
	//                        'pagination'=>false,
			));
		}
}