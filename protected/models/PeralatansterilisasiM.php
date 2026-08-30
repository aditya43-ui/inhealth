<?php

/**
 * This is the model class for table "peralatansterilisasi_m".
 *
 * The followings are the available columns in table 'peralatansterilisasi_m':
 * @property integer $peralatansterilisasi_id
 * @property string $peralatansterilisasi_nama
 * @property string $peralatansterilisasi_namalain
 * @property string $peralatansterilisasi_jml
 * @property double $peralatansterilisasi_maks
 * @property boolean $peralatansterilisasi_reuse
 * @property string $peralatansterilisasi_pathgbr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BarangM[] $barangMs
 * @property LinenM[] $linenMs
 * @property ObatalkesM[] $obatalkesMs
 */
class PeralatansterilisasiM extends CActiveRecord
{
        public $barang_nama;
        public $jenisperalatan;
        public $nama;
        public $jml;
        public $map_id;
        public $item_id, $item_nama;

    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeralatansterilisasiM the static model class
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
		return 'peralatansterilisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peralatansterilisasi_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('peralatansterilisasi_maks', 'numerical'),
			array('peralatansterilisasi_nama, peralatansterilisasi_namalain, peralatansterilisasi_pathgbr', 'length', 'max'=>100),
			array('peralatansterilisasi_jml', 'length', 'max'=>10),
                    array('jenisperalatan', 'length', 'max'=>20),
			array('jenisperalatan, peralatansterilisasi_reuse, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peralatansterilisasi_id, peralatansterilisasi_nama, peralatansterilisasi_namalain, peralatansterilisasi_jml, peralatansterilisasi_maks, peralatansterilisasi_reuse, peralatansterilisasi_pathgbr, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jenisperalatan', 'safe', 'on'=>'search'),
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
			'barangMs' => array(self::MANY_MANY, 'BarangM', 'mapbarangsterilisasi_m(peralatansterilisasi_id, barang_id)'),
			'linenMs' => array(self::MANY_MANY, 'LinenM', 'maplinensterilisasi_m(peralatansterilisasi_id, linen_id)'),
			'obatalkesMs' => array(self::MANY_MANY, 'ObatalkesM', 'mapalkessterilisasi_m(peralatansterilisasi_id, obatalkes_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peralatansterilisasi_id' => 'Peralatan Sterilisasi',
			'peralatansterilisasi_nama' => 'Nama Peralatan Sterilisasi ',
			'peralatansterilisasi_namalain' => 'Nama Lain Peralatan Sterilisasi ',
			'peralatansterilisasi_jml' => 'Jumlah Peralatan Steriliasi',
                        'peralatansterilisasi_maks' => 'Maks Peralatan Sterilisasi',
			'peralatansterilisasi_reuse' => 'Peralatan Sterilisasi Reuse',
			'peralatansterilisasi_pathgbr' => 'Gambar Peralatan Sterilisasi',
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

		if(!empty($this->peralatansterilisasi_id)){
			$criteria->addCondition('peralatansterilisasi_id = '.$this->peralatansterilisasi_id);
		}
		$criteria->compare('LOWER(peralatansterilisasi_nama)',strtolower($this->peralatansterilisasi_nama),true);
		$criteria->compare('LOWER(peralatansterilisasi_namalain)',strtolower($this->peralatansterilisasi_namalain),true);
		$criteria->compare('LOWER(peralatansterilisasi_jml)',strtolower($this->peralatansterilisasi_jml),true);
		$criteria->compare('peralatansterilisasi_maks',$this->peralatansterilisasi_maks);
		$criteria->compare('peralatansterilisasi_reuse',$this->peralatansterilisasi_reuse);
		$criteria->compare('LOWER(peralatansterilisasi_pathgbr)',strtolower($this->peralatansterilisasi_pathgbr),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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
        
         public function searchDialog(){
            
            $cri = new CDbCriteria();  
            $jenispen = "t.jenisperalatan";
            $namapen = "t.peralatansterilisasi_nama";
            
            if ($this->jenisperalatan == Params::JENIS_PERALATAN_BARANG){
                $model = new MapbarangsterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan ";
                $cri->select = $cri->group;
                $cri->join =    "  JOIN barang_m b ON b.barang_id = t.barang_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(b.barang_nama)', strtolower($this->nama),true);
                $cri->addCondition(" b.barang_aktif = TRUE ");
                $jenispen = "p.jenisperalatan";
                $namapen = "p.peralatansterilisasi_nama";
            }elseif ($this->jenisperalatan == Params::JENIS_PERALATAN_LINEN){
                $model = new MaplinensterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan  ";
                $cri->select = $cri->group;
                $cri->join =    "  JOIN linen_m l ON l.linen_id = t.linen_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(l.namalinen)', strtolower($this->nama),true);
                $cri->addCondition(" l.linen_aktif = TRUE ");
                $jenispen = "p.jenisperalatan";
                 $namapen = "p.peralatansterilisasi_nama";
            }elseif ($this->jenisperalatan == Params::JENIS_PERALATAN_ALATMEDIS){
                $model = new MapalkessterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan  ";
                $cri->select = $cri->group;
                $cri->join =    "  JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(o.obatalkes_nama)', strtolower($this->nama),true);
                $cri->addCondition(" o.obatalkes_aktif = TRUE AND o.jenisobatalkes_id = 1");
                $jenispen = "p.jenisperalatan";
                 $namapen = "p.peralatansterilisasi_nama";
            }else{
                $model = $this;
            }
            
            if (!empty($this->jenisperalatan)){
                $cri->addCondition($jenispen." = '".$this->jenisperalatan."' ");
            }else{
                //$cri->addCondition(" p.jenisperalatan is ");
            }
            
            $cri->compare("LOWER(".$namapen.")",strtolower($this->peralatansterilisasi_nama),true);
            
            return new CActiveDataProvider($model, array(
                    'criteria'=>$cri,
            ));
        }
        
        
        public function searchDialogPenerimaanLangsung(){
            
            $cri = new CDbCriteria();  
            $jenispen = "t.jenisperalatan";
            if ($this->jenisperalatan == Params::JENIS_PERALATAN_BARANG){
                $model = new MapbarangsterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, b.barang_id, b.barang_nama ";
                $cri->select = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, b.barang_id as item_id, b.barang_nama as item_nama ";;
                $cri->join =    "  JOIN barang_m b ON b.barang_id = t.barang_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(b.barang_nama)', strtolower($this->nama),true);
                $cri->addCondition(" b.barang_aktif = TRUE ");
                $jenispen = "p.jenisperalatan";
            }elseif ($this->jenisperalatan == Params::JENIS_PERALATAN_LINEN){
                $model = new MaplinensterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, l.linen_id, l.namalinen ";
                $cri->select = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, l.linen_id as item_id, l.namalinen as item_nama ";
                $cri->join =    "  JOIN linen_m l ON l.linen_id = t.linen_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(l.namalinen)', strtolower($this->nama),true);
                $cri->addCondition(" l.linen_aktif = TRUE ");
                $jenispen = "p.jenisperalatan";
            }elseif ($this->jenisperalatan == Params::JENIS_PERALATAN_ALATMEDIS){
                $model = new MapalkessterilisasiM;
                $cri->group = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, o.obatalkes_id, o.obatalkes_nama ";
                $cri->select = " t.peralatansterilisasi_id, p.peralatansterilisasi_nama, p.jenisperalatan, o.obatalkes_id as item_id, o.obatalkes_nama as item_nama ";
                $cri->join =    "  JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id "
                        .       "  JOIN peralatansterilisasi_m p ON p.peralatansterilisasi_id = t.peralatansterilisasi_id ";
                $cri->compare('LOWER(o.obatalkes_nama)', strtolower($this->nama),true);
                $cri->addCondition(" o.obatalkes_aktif = TRUE ");
                $jenispen = "p.jenisperalatan";
            }else{
                $model = $this;
            }
//            echo '<pre>';
//            print_r($cri);
//            exit();
            if (!empty($this->jenisperalatan)){
//                $cri->addCondition(" p.jenisperalatan = '".$this->jenisperalatan."' ");
                $cri->addCondition($jenispen." = '".$this->jenisperalatan."' ");
                
            }else{
                //$cri->addCondition(" p.jenisperalatan is ");
            }
            
            $cri->compare("LOWER(t.peralatansterilisasi_nama)",strtolower($this->peralatansterilisasi_nama),true);
            
            //$cri->group = $cri->select;
            
            
            
            return new CActiveDataProvider($model, array(
                    'criteria'=>$cri,
            ));
        }
}