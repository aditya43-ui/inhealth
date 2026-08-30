<?php

/**
 * This is the model class for table "kegiatanprogram_m".
 *
 * The followings are the available columns in table 'kegiatanprogram_m':
 * @property integer $kegiatanprogram_id
 * @property integer $subprogramkerja_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property string $kegiatanprogram_namalain
 * @property string $kegiatanprogram_ket
 * @property boolean $kegiatanprogram_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KegiatanprogramM extends CActiveRecord
{
        public $kdrekening5;
        public $nmrekening5;
        public $subprogramkerja_nama, $programkerja_kode, $programkerja_nama, $subprogramkerja_kode;
        public $subpogramkerja_id;
        public $default;
        public $tahunanggaran_id, $jenisusulan;
        public $campur;
        public $programkerja_id;
        public $periodeanggaran_id;
        public $subkegiatanprogram_aktif;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanprogramM the static model class
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
		return 'kegiatanprogram_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subprogramkerja_id, kegiatanprogram_kode, kegiatanprogram_nama, kegiatanprogram_namalain, kegiatanprogram_aktif, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('subprogramkerja_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kegiatanprogram_kode', 'length', 'max'=>5),
			array('kegiatanprogram_nama, kegiatanprogram_namalain', 'length', 'max'=>500),
			array('kegiatanprogram_ket, rekening5_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanprogram_id, subprogramkerja_id, kegiatanprogram_kode, kegiatanprogram_nama, kegiatanprogram_namalain, kegiatanprogram_ket, kegiatanprogram_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'subprogramkerja' => array(self::BELONGS_TO, 'SubprogramkerjaM', 'subprogramkerja_id'),
                    'rekening' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'subprogramkerja_id' => 'Subprogramkerja',
			'kegiatanprogram_kode' => 'Kode',
			'kegiatanprogram_nama' => 'Kegiatan Program',
			'kegiatanprogram_namalain' => 'Nama Lain',
			'kegiatanprogram_ket' => 'Keterangan',
			'kegiatanprogram_aktif' => 'Aktif',
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

		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('t.kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('t.subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(t.kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(t.kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(t.kegiatanprogram_namalain)',strtolower($this->kegiatanprogram_namalain),true);
		$criteria->compare('LOWER(t.kegiatanprogram_ket)',strtolower($this->kegiatanprogram_ket),true);
		$criteria->compare('t.kegiatanprogram_aktif',$this->kegiatanprogram_aktif);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
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
            $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
            $criteria->compare("LOWER(r5.kdrekening5)",strtolower($this->kdrekening5),true);
            $criteria->compare("LOWER(r5.nmrekening5)",strtolower($this->nmrekening5),true);
            if (!empty($this->default)){
                $criteria->addCondition(" t.kegiatanprogram_id is null ");
            }
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * 
         * @return \CActiveDataProvider
         */
        public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria();
            $criteria->group = "
                    t.kegiatanprogram_id,
                    t.subprogramkerja_id,
                    t.kegiatanprogram_kode,
                    t.kegiatanprogram_nama,
                    t.kegiatanprogram_namalain,
                    t.kegiatanprogram_ket,
                    r5.rekening5_id, 
                    r5.nmrekening5, 
                    r5.kdrekening5, 
                    subkerja.subprogramkerja_nama, 
                    t.subprogramkerja_id, 
                    subkerja.subprogramkerja_kode, 
                    kerja.programkerja_id, 
                    kerja.programkerja_nama, 
                    kerja.programkerja_kode";
            $criteria->select = $criteria->group;
            $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id "
                            . " LEFT JOIN subprogramkerja_m subkerja ON subkerja.subprogramkerja_id = t.subprogramkerja_id "
                            . " LEFT JOIN programkerja_m kerja ON kerja.programkerja_id = subkerja.programkerja_id "
                            . " LEFT JOIN subsubkegiatan_m subsubkeg ON subsubkeg.kegiatanprogram_id = t.kegiatanprogram_id "
                            . " LEFT JOIN subkegiatanprogram_m subkeg ON subkeg.subsubkegiatan_id = subsubkeg.subsubkegiatan_id ";
            $criteria->compare("LOWER(r5.kdrekening5)",strtolower($this->kdrekening5),true);
            $criteria->compare("LOWER(r5.nmrekening5)",strtolower($this->nmrekening5),true);
                
            if (!empty($this->subkegiatanprogram_aktif)){
                $criteria->addCondition(" subkeg.subkegiatanprogram_aktif::text = '".$this->subkegiatanprogram_aktif."' ");
            }
            
            if ($this->campur == 'campur'){
                $criteria->addCondition(" LOWER(subkerja.subprogramkerja_nama) ilike '%".$this->kegiatanprogram_nama."%' OR LOWER(kerja.programkerja_nama) ilike '%".$this->kegiatanprogram_nama."%' OR LOWER(t.kegiatanprogram_nama) ilike '%".$this->kegiatanprogram_nama."%' ");
            }else{            
                $criteria->compare("LOWER(subkerja.subprogramkerja_nama)",strtolower($this->subprogramkerja_nama),true);
                $criteria->compare("LOWER(kerja.programkerja_nama)",strtolower($this->programkerja_nama),true);           
                $criteria->compare("LOWER(t.kegiatanprogram_nama)",strtolower($this->kegiatanprogram_nama),true);            
            }
            if (!empty($this->default)){
                $criteria->addCondition(" t.kegiatanprogram_id is null ");
            }
            if (!empty($this->subprogramkerja_id)){
                $criteria->addCondition(" subkerja.subprogramkerja_id  = ".$this->subprogramkerja_id." AND subprogramkerja_aktif = TRUE ");
            }
            if (!empty($this->programkerja_id)){
                $criteria->addCondition(" kerja.programkerja_id  = ".$this->programkerja_id." AND kerja.programkerja_aktif = TRUE ");
            }
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * 
         * @return \CActiveDataProvider
         */
        public function searchDialogRekRUP()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria();
            $criteria->select="t.*,r5.rekening5_id, r5.nmrekening5, r5.kdrekening5, subkerja.subprogramkerja_nama, t.subprogramkerja_id, subkerja.subprogramkerja_kode, kerja.programkerja_nama, kerja.programkerja_kode";
            $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id "
                            . " LEFT JOIN subprogramkerja_m subkerja ON subkerja.subprogramkerja_id = t.subprogramkerja_id "
                            . " LEFT JOIN programkerja_m kerja ON kerja.programkerja_id = subkerja.programkerja_id ";
            $criteria->compare("LOWER(r5.kdrekening5)",strtolower($this->kdrekening5),true);
            $criteria->compare("LOWER(r5.nmrekening5)",strtolower($this->nmrekening5),true);
                
            if ($this->campur == 'campur'){
                $criteria->addCondition(" LOWER(subkerja.subprogramkerja_nama) ilike '%".$this->kegiatanprogram_nama."%' OR LOWER(kerja.programkerja_nama) ilike '%".$this->kegiatanprogram_nama."%' OR LOWER(t.kegiatanprogram_nama) ilike '%".$this->kegiatanprogram_nama."%' ");
            }else{            
                $criteria->compare("LOWER(subkerja.subprogramkerja_nama)",strtolower($this->subprogramkerja_nama),true);
                $criteria->compare("LOWER(kerja.programkerja_nama)",strtolower($this->programkerja_nama),true);            
            }
            if (!empty($this->default)){
                $criteria->addCondition(" t.kegiatanprogram_id is null ");
            }
            if (!empty($this->subprogramkerja_id)){
                $criteria->addCondition(" subkerja.subprogramkerja_id  = ".$this->subprogramkerja_id." AND subprogramkerja_aktif = TRUE ");
            }
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        /**
         * Load data untuk dicetak
         * @return \CActiveDataProvider
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
         * Pencarian kegiatan berdasarkan tahun anggaran
         * @return \CActiveDataProvider
         */
        public function searchKegiatanByTahunAnggaran()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            
            $criteria->select = 't.kegiatanprogram_id,
                                t.kegiatanprogram_nama, 
                                t.kegiatanprogram_kode, 
                                program.programkerja_nama, 
                                program.programkerja_kode, 
                                sub.subprogramkerja_nama, 
                                sub.subprogramkerja_kode, 
                                periodeanggaran_k.tahunanggaran, 
                                mappingrekeninganggaran_m.kegiatanprogram_id, 
                                mappingrekeninganggaran_m.periodeanggaran_id';
            $criteria->join = "JOIN mappingrekeninganggaran_m ON mappingrekeninganggaran_m.kegiatanprogram_id = t.kegiatanprogram_id "
                            . "JOIN periodeanggaran_k ON mappingrekeninganggaran_m.periodeanggaran_id = periodeanggaran_k.periodeanggaran_id "
                            . "JOIN subprogramkerja_m sub ON sub.subprogramkerja_id = t.subprogramkerja_id "
                            . "JOIN programkerja_m program ON sub.programkerja_id = program.programkerja_id";
            $criteria->group = 't.kegiatanprogram_id,
                                t.kegiatanprogram_nama, 
                                t.kegiatanprogram_kode, 
                                program.programkerja_nama, 
                                program.programkerja_kode, 
                                sub.subprogramkerja_nama, 
                                sub.subprogramkerja_kode, 
                                periodeanggaran_k.tahunanggaran, 
                                mappingrekeninganggaran_m.kegiatanprogram_id, 
                                mappingrekeninganggaran_m.periodeanggaran_id';
            if(!empty($this->tahunanggaran_id)){
                $criteria->addCondition('mappingrekeninganggaran_m.periodeanggaran_id = '.$this->tahunanggaran_id);
            }
            if(!empty($this->jenisusulan)){
                $criteria->addCondition("mappingrekeninganggaran_m.jenis_usulan = '".$this->jenisusulan."'");
            }
            if (!empty($this->default)){
                $criteria->addCondition("t.kegiatanprogram_id is null");
            }
            $criteria->addCondition("t.kegiatanprogram_aktif is true");
            $criteria->compare("LOWER(t.kegiatanprogram_nama)",strtolower($this->kegiatanprogram_nama),true);
            
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Pencarian semua kegiatan kegiatan 
         * @return \CActiveDataProvider
         */
        public function searchAllKegiatan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            
            $criteria->select = 't.kegiatanprogram_id,
                                t.kegiatanprogram_nama, 
                                t.kegiatanprogram_kode, 
                                program.programkerja_nama, 
                                program.programkerja_kode, 
                                sub.subprogramkerja_nama, 
                                sub.subprogramkerja_kode';
            $criteria->join = "JOIN subprogramkerja_m sub ON sub.subprogramkerja_id = t.subprogramkerja_id "
                            . "JOIN programkerja_m program ON sub.programkerja_id = program.programkerja_id";
            $criteria->group = 't.kegiatanprogram_id,
                                t.kegiatanprogram_nama, 
                                t.kegiatanprogram_kode, 
                                program.programkerja_nama, 
                                program.programkerja_kode, 
                                sub.subprogramkerja_nama, 
                                sub.subprogramkerja_kode';
            $criteria->addCondition("t.kegiatanprogram_aktif is true");
            $criteria->compare("LOWER(t.kegiatanprogram_nama)",strtolower($this->kegiatanprogram_nama),true);
            
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}