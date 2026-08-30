<?php

/**
 * This is the model class for table "subkegiatanprogram_m".
 *
 * The followings are the available columns in table 'subkegiatanprogram_m':
 * @property integer $subkegiatanprogram_id
 * @property integer $kegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 * @property string $subkegiatanprogram_namalain
 * @property string $subkegiatanprogram_ket
 * @property integer $rekeningdebit_id
 * @property integer $rekeningkredit_id
 * @property boolean $subkegiatanprogram_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SubkegiatanprogramM extends CActiveRecord
{
        public $default;
        public $programkerja_id, $programkerja_nama;
        public $subprogramkerja_id, $subprogramkerja_nama, $rekeningdebit_nama, $rekeningdebit_id;
        public $kegiatanprogram_nama;        
        public $nmrekening5;
        public $rekeninganggaran5_kode, $rekening5debit_nama, $rekeninganggaran4_kode, $rekeninganggaran3_kode, $rekeninganggaran2_kode, $rekeninganggaran1_kode;
        public $kodeanggaran;
        public $mappingrekeninganggaran_id;
        public $nama_rekeninganggaran5;
        public $periodeanggaran_id;
        public $subsubkegiatan_kode, $subsubkegiatan_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubkegiatanprogramM the static model class
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
		return 'subkegiatanprogram_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanprogram_id, subkegiatanprogram_nama, subkegiatanprogram_namalain, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kegiatanprogram_id, rekeningdebit_id, rekeningkredit_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('subkegiatanprogram_kode', 'length', 'max'=>5),
			array('subkegiatanprogram_nama, subkegiatanprogram_namalain', 'length', 'max'=>500),
			array('subsubkegiatan_id, subkegiatanprogram_ket, subkegiatanprogram_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subkegiatanprogram_id, kegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama, subkegiatanprogram_namalain, subkegiatanprogram_ket, rekeningdebit_id, rekeningkredit_id, subkegiatanprogram_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'kegiatanprogram' => array(self::BELONGS_TO, 'KegiatanprogramM', 'kegiatanprogram_id'),
                    'rekeningdebit' => array(self::BELONGS_TO, 'Rekening5M', 'rekeningdebit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subkegiatanprogram_id' => 'ID Sub Kegiatan Program',
			'kegiatanprogram_id' => 'ID Kegiatan Program',
			'subkegiatanprogram_kode' => 'Kode',
			'subkegiatanprogram_nama' => 'Nama Sub Kegiatan',
			'subkegiatanprogram_namalain' => 'Nama Lain',
			'subkegiatanprogram_ket' => 'Keterangan',
			'rekeningdebit_id' => 'Rekeningdebit',
			'rekeningkredit_id' => 'Rekeningkredit',
			'subkegiatanprogram_aktif' => 'Aktif',
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

		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
                
                if (!empty($this->default)){
                    $criteria->addCondition("subkegiatanprogram_id is null");
                }
                
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_namalain)',strtolower($this->subkegiatanprogram_namalain),true);
		$criteria->compare('LOWER(subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
		if(!empty($this->rekeningdebit_id)){
			$criteria->addCondition('rekeningdebit_id = '.$this->rekeningdebit_id);
		}
		if(!empty($this->rekeningkredit_id)){
			$criteria->addCondition('rekeningkredit_id = '.$this->rekeningkredit_id);
		}
		$criteria->compare('subkegiatanprogram_aktif',$this->subkegiatanprogram_aktif);
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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchDialog(){
            
            $cri = new CDbCriteria();
            $cri->select = " t.subkegiatanprogram_id, t.*, kp.kegiatanprogram_id, kp.kegiatanprogram_nama, "
                    . "spk.subprogramkerja_nama, spk.subprogramkerja_id, "
                    . "pk.programkerja_id, pk.programkerja_nama, "
                    . "r5.rekeninganggaran5_kode, r4.rekeninganggaran4_kode, r3.rekeninganggaran3_kode, r2.rekeninganggaran2_kode, r1.rekeninganggaran1_kode, maprek.kodeanggaran, maprek.mappingrekeninganggaran_id, maprek.nama_rekeninganggaran5 ";
            $cri->join =  " JOIN kegiatanprogram_m kp ON kp.kegiatanprogram_id = t.kegiatanprogram_id "
                        . " JOIN subprogramkerja_m spk ON spk.subprogramkerja_id = kp.subprogramkerja_id  "
                        . " JOIN programkerja_m pk ON pk.programkerja_id = spk.programkerja_id "
                        . " LEFT JOIN mappingrekeninganggaran_m maprek ON maprek.subkegiatanprogram_id = t.subkegiatanprogram_id "
                        . " LEFT JOIN rekeninganggaran5_m r5 ON r5.rekeninganggaran5_id = maprek.rekeninganggaran5_id "
                        . " LEFT JOIN rekeninganggaran4_m r4 ON r4.rekeninganggaran4_id = r5.rekeninganggaran4_id "
                        . " LEFT JOIN rekeninganggaran3_m r3 ON r3.rekeninganggaran3_id = r4.rekeninganggaran3_id "
                        . " LEFT JOIN rekeninganggaran2_m r2 ON r2.rekeninganggaran2_id = r3.rekeninganggaran2_id "
                        . " LEFT JOIN rekeninganggaran1_m r1 ON r1.rekeninganggaran1_id = r2.rekeninganggaran1_id ";
            if (!empty($this->default)){
                $cri->addCondition(" t.subkegiatanprogram_id is null ");
            }            
            if (!empty($this->kegiatanprogram_id)){
                $cri->addCondition(" t.kegiatanprogram_id = ".$this->kegiatanprogram_id." ");
            }
            if (!empty($this->subprogramkerja_id)){
                $cri->addCondition(" spk.subprogramkerja_id = ".$this->subprogramkerja_id." ");
            }
            if (!empty($this->periodeanggaran_id)){
                $cri->addCondition(" maprek.periodeanggaran_id = ".$this->periodeanggaran_id." ");
            }
            $cri->compare("LOWER(pk.programkerja_nama)", strtolower($this->programkerja_nama),true);
            $cri->compare("LOWER(spk.subprogramkerja_nama)", strtolower($this->subprogramkerja_nama),true);
            $cri->compare("LOWER(r5.rekeninganggaran5_kode)", strtolower($this->rekeninganggaran5_kode),true);
            $cri->compare("LOWER(r4.rekeninganggaran4_kode)", strtolower($this->rekeninganggaran4_kode),true);
            $cri->compare("LOWER(r3.rekeninganggaran3_kode)", strtolower($this->rekeninganggaran3_kode),true);
            $cri->compare("LOWER(r2.rekeninganggaran2_kode)", strtolower($this->rekeninganggaran2_kode),true);
            $cri->compare("LOWER(r1.rekeninganggaran1_kode)", strtolower($this->rekeninganggaran1_kode),true);
            $cri->compare("LOWER(t.subkegiatanprogram_nama)", strtolower($this->subkegiatanprogram_nama),true);
            $cri->compare("LOWER(t.subkegiatanprogram_kode)", strtolower($this->subkegiatanprogram_kode),true);
            $cri->compare("LOWER(maprek.kodeanggaran)", strtolower($this->kodeanggaran),true);
            $cri->compare("LOWER(maprek.nama_rekeninganggaran5)", strtolower($this->nama_rekeninganggaran5),true);
            
            $cri->addCondition(" t.subkegiatanprogram_aktif = TRUE ");
            
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$cri,
                    'sort' => array(
                        'defaultOrder' => 't.subkegiatanprogram_nama ASC'
                    )
            ));
        }
        
        /**
         * Filter Sub Kegiatan berdasarkan kegiatan program yang dipilih
         * @author Andyka Putra <andykaputra@.com>
         * @return \CActiveDataProvider
         */
        public function searchDialogKegiatan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->compare('LOWER(k.kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
                $criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
                $criteria->compare('LOWER(pro.programkerja_nama)',strtolower($this->programkerja_nama),true);
                
                if(!empty($this->subsubkegiatan_id)){
                    $criteria->addCondition("t.subsubkegiatan_id =".$this->subsubkegiatan_id); 
                }
                if (!empty($this->default)){                    
                    $criteria->addCondition("t.subkegiatanprogram_id is null"); 
                }
                $criteria->select = 't.*, t.subkegiatanprogram_id, t.kegiatanprogram_id, k.kegiatanprogram_nama, pro.programkerja_nama';
                $criteria->join = ' LEFT JOIN kegiatanprogram_m as k ON t.kegiatanprogram_id = k.kegiatanprogram_id '
                                . ' LEFT JOIN subprogramkerja_m as subpro ON subpro.subprogramkerja_id = k.subprogramkerja_id '
                                . ' LEFT JOIN programkerja_m as pro ON pro.programkerja_id = subpro.programkerja_id ';
                $criteria->group = $criteria->select; 
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchMaster() {
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.subkegiatanprogram_id, t.subkegiatanprogram_kode, t.subkegiatanprogram_nama, t.subkegiatanprogram_ket, t.subkegiatanprogram_aktif, t.rekeningdebit_id,  '
                . 'spk.subprogramkerja_id, spk.subprogramkerja_kode, spk.subprogramkerja_nama, '
                . 'kp.kegiatanprogram_id, kp.kegiatanprogram_kode, kp.kegiatanprogram_nama, '
                . 'pk.programkerja_id, pk.programkerja_kode, pk.programkerja_nama, sub.subsubkegiatan_nama, sub.subsubkegiatan_kode, sub.subsubkegiatan_id, '
                . 'rek.nmrekening5';
        $criteria->addCondition('pk.programkerja_aktif = TRUE AND spk.subprogramkerja_aktif = TRUE AND kp.kegiatanprogram_aktif ');//AND t.subkegiatanprogram_aktif = TRUE
        $criteria->join = ' JOIN subsubkegiatan_m sub ON sub.subsubkegiatan_id = t.subsubkegiatan_id  '
                . '         JOIN kegiatanprogram_m kp ON sub.kegiatanprogram_id = kp.kegiatanprogram_id '
                        . ' JOIN subprogramkerja_m spk ON spk.subprogramkerja_id = kp.subprogramkerja_id  '
                        . ' JOIN programkerja_m pk ON pk.programkerja_id = spk.programkerja_id '
                        . ' LEFT JOIN rekening5_m rek ON rek.rekening5_id = t.rekeningdebit_id ';
        $criteria->order = 't.subkegiatanprogram_id ASC';
        if(!empty($this->programkerja_id)){
                $criteria->addCondition('pk.programkerja_id = '.$this->programkerja_id);
        }
        $criteria->compare('LOWER(pk.programkerja_kode)',strtolower($this->programkerja_kode),true);
        $criteria->compare('LOWER(pk.programkerja_nama)',strtolower($this->programkerja_nama),true);

        if(!empty($this->programkerja_nourut)){
                $criteria->addCondition('pk.programkerja_nourut = '.$this->programkerja_nourut);
        }
        if(!empty($this->subprogramkerja_id)){
                $criteria->addCondition('spk.subprogramkerja_id = '.$this->subprogramkerja_id);
        }
        $criteria->compare('LOWER(spk.subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
        $criteria->compare('LOWER(spk.subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
        if(!empty($this->subprogramkerja_nourut)){
                $criteria->addCondition('spk.subprogramkerja_nourut = '.$this->subprogramkerja_nourut);
        }
        if(!empty($this->kegiatanprogram_id)){
                $criteria->addCondition('kp.kegiatanprogram_id = '.$this->kegiatanprogram_id);
        }
        $criteria->compare('LOWER(kp.kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
        $criteria->compare('LOWER(kp.kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
        if(!empty($this->kegiatanprogram_nourut)){
                $criteria->addCondition('kp.kegiatanprogram_nourut = '.$this->kegiatanprogram_nourut);
        }
        if(!empty($this->subkegiatanprogram_id)){
                $criteria->addCondition('t.subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
        }
        $criteria->compare('LOWER(t.subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
	$criteria->compare('LOWER(t.subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
        $criteria->compare('LOWER(t.subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
        if(!empty($this->rekeningdebit_id)){
                $criteria->addCondition('t.rekeningdebit_id = '.$this->rekeningdebit_id);
        }
//        $criteria->compare('LOWER(t.rekeningdebit_id)',strtolower($this->rekeningdebit_id),true);
        $criteria->compare('t.subkegiatanprogram_aktif',isset($this->subkegiatanprogram_aktif)?$this->subkegiatanprogram_aktif:true);

        if(!empty($this->subkegiatanprogram_nourut)){
			$criteria->addCondition('t.subkegiatanprogram_nourut = '.$this->subkegiatanprogram_nourut);
		}
	$criteria->compare('LOWER(rek.nmrekening5)',strtolower($this->nmrekening5),true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		)); 
    }
}