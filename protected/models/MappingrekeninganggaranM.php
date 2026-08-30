<?php

/**
 * This is the model class for table "mappingrekeninganggaran_m".
 *
 * @author  Andyka <andykaputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'mappingrekeninganggaran_m':
 * @property integer $mappingrekeninganggaran_id
 * @property integer $periodeanggaran_id
 * @property string $jenis_usulan
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_nama
 * @property integer $rekeningrba4_id
 * @property string $kode_rekeningrba4
 * @property string $nama_rekeningrba4
 * @property integer $rekeninganggaran5_id
 * @property string $rekeninganggaran5_kode
 * @property string $nama_rekeninganggaran5
 * @property boolean $is_biayalangsung
 * @property boolean $is_biayaalokasi
 * @property boolean $is_aktif
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $update_time
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $koderba
 * @property string $kodeanggaran
 */
class MappingrekeninganggaranM extends CActiveRecord
{
        public $subprogramkerja_nama, $subprogramkerja_kode, $subprogramkerja_id, 
           $programkerja_id, $programkerja_kode, $programkerja_nama, 
           $kegiatanprogram_kode, $subkegiatanprogram_kode; 
        public $default;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MappingrekeninganggaranM the static model class
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
		return 'mappingrekeninganggaran_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('rekeninganggaran5_kode, create_time, create_loginpemakai_id, create_ruangan', 'required'),
                array('periodeanggaran_id, kegiatanprogram_id, subkegiatanprogram_id, rekeningrba4_id, rekeninganggaran5_id', 'numerical', 'integerOnly'=>true),
                array('jenis_usulan, koderba, kodeanggaran', 'length', 'max'=>50),
                array('kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>200),
                array('kode_rekeningrba4, nama_rekeningrba4, rekeninganggaran5_kode', 'length', 'max'=>100),
                ['nama_rekeninganggaran5', 'length', 'max'=>350],
                array('is_biayalangsung, is_biayaalokasi, is_aktif, update_time, update_loginpemakai_id', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('mappingrekeninganggaran_id, periodeanggaran_id, jenis_usulan, kegiatanprogram_id, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_nama, rekeningrba4_id, kode_rekeningrba4, nama_rekeningrba4, rekeninganggaran5_id, rekeninganggaran5_kode, nama_rekeninganggaran5, is_biayalangsung, is_biayaalokasi, is_aktif, create_time, create_loginpemakai_id, update_time, update_loginpemakai_id, create_ruangan, koderba, kodeanggaran', 'safe', 'on'=>'search'),
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
			'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
			'rekeningrba4' => array(self::BELONGS_TO, 'Rekeningrba4M', 'rekeningrba4_id'),
			'rekeninganggaran5' => array(self::BELONGS_TO, 'Rekeninganggaran5M', 'rekeninganggaran5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mappingrekeninganggaran_id' => 'Mapping Rekening Anggaran',
			'periodeanggaran_id' => 'Periode Anggaran',
			'jenis_usulan' => 'Jenis Usulan',
			'kegiatanprogram_id' => 'Kegiatan Program',
			'kegiatanprogram_nama' => 'Kegiatan Program',
			'subkegiatanprogram_id' => 'Sub Kegiatan Program',
			'subkegiatanprogram_nama' => 'Sub Kegiatan Program',
			'rekeningrba4_id' => 'Rekening RBA 4',
			'kode_rekeningrba4' => 'Kode Rekening RBA ',
			'nama_rekeningrba4' => 'Nama Rekening RBA ',
			'rekeninganggaran5_id' => 'Rekening Anggaran 5',
			'rekeninganggaran5_kode' => 'Kode Rek. Anggaran ',
			'nama_rekeninganggaran5' => 'Nama Rek. Anggaran ',
			'is_biayalangsung' => 'Biaya Langsung',
			'is_biayaalokasi' => 'Biaya Alokasi',
			'is_aktif' => 'Status',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_time' => 'Update Time',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'koderba' => 'Kode Rekening RBA',
                        'kodeanggaran' => 'Kode Rekening Anggaran',
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

		$criteria->compare('mappingrekeninganggaran_id',$this->mappingrekeninganggaran_id);
		$criteria->compare('periodeanggaran_id',$this->periodeanggaran_id);
		$criteria->compare('jenis_usulan',$this->jenis_usulan,true);
		$criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
                $criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
                $criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('rekeningrba4_id',$this->rekeningrba4_id);
		$criteria->compare('kode_rekeningrba4',$this->kode_rekeningrba4,true);
                $criteria->compare('LOWER(nama_rekeningrba4)',strtolower($this->nama_rekeningrba4),true);
		$criteria->compare('rekeninganggaran5_id',$this->rekeninganggaran5_id);
		$criteria->compare('rekeninganggaran5_kode',$this->rekeninganggaran5_kode,true);
                $criteria->compare('LOWER(nama_rekeninganggaran5)',strtolower($this->nama_rekeninganggaran5),true);
		$criteria->compare('is_biayalangsung',$this->is_biayalangsung);
		$criteria->compare('is_biayaalokasi',$this->is_biayaalokasi);
                $criteria->compare('is_aktif',isset($this->is_aktif)?$this->is_aktif:true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
                $criteria->compare('koderba',$this->koderba,true);
                $criteria->compare('kodeanggaran',$this->kodeanggaran,true);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Pencarian dialog 
         * @return \CActiveDataProvider
         */
        public function searchDialogRek5(){
            $criteria = new CDbCriteria();
            $criteria->group = "
                                t.kodeanggaran,
                                t.nama_rekeninganggaran5 ,
                                t.rekeninganggaran5_id";
            $criteria->select = $criteria->group;
            $criteria->join = "LEFT JOIN kegiatanprogram_m ON kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                                LEFT JOIN subprogramkerja_m ON subprogramkerja_m.subprogramkerja_id = kegiatanprogram_m.subprogramkerja_id
                                LEFT JOIN subkegiatanprogram_m ON subkegiatanprogram_m.subkegiatanprogram_id = t.subkegiatanprogram_id
                                LEFT JOIN programkerja_m ON programkerja_m.programkerja_id = subprogramkerja_m.programkerja_id";
            $criteria->compare('LOWER(t.subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);            
            $criteria->compare('LOWER(t.nama_rekeninganggaran5)', strtolower($this->nama_rekeninganggaran5), true);
            $criteria->compare('LOWER(t.kodeanggaran)', strtolower($this->kodeanggaran), true);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        /**
         * Pencarian dialog 
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
            $criteria = new CDbCriteria();
            $criteria->select = "t.periodeanggaran_id,
                                t.kodeanggaran,
                                t.nama_rekeninganggaran5,
                                programkerja_m.programkerja_id,
                                programkerja_m.programkerja_kode,
                                programkerja_m.programkerja_nama,
                                subprogramkerja_m.subprogramkerja_id,
                                subprogramkerja_m.subprogramkerja_kode,
                                subprogramkerja_m.subprogramkerja_nama,
                                t.kegiatanprogram_id,
                                kegiatanprogram_m.kegiatanprogram_kode,
                                t.kegiatanprogram_nama,
                                t.subkegiatanprogram_id,
                                subkegiatanprogram_m.subkegiatanprogram_kode, 
                                t.subkegiatanprogram_nama";
            $criteria->join = "LEFT JOIN kegiatanprogram_m ON kegiatanprogram_m.kegiatanprogram_id = t.kegiatanprogram_id
                                LEFT JOIN subprogramkerja_m ON subprogramkerja_m.subprogramkerja_id = kegiatanprogram_m.subprogramkerja_id
                                LEFT JOIN subkegiatanprogram_m ON subkegiatanprogram_m.subkegiatanprogram_id = t.subkegiatanprogram_id
                                LEFT JOIN programkerja_m ON programkerja_m.programkerja_id = subprogramkerja_m.programkerja_id";
            $criteria->compare('LOWER(t.subkegiatanprogram_nama)', strtolower($this->subkegiatanprogram_nama), true);            
            $criteria->compare('LOWER(t.nama_rekeninganggaran5)', strtolower($this->nama_rekeninganggaran5), true);
            $criteria->compare('LOWER(t.kodeanggaran)', strtolower($this->kodeanggaran), true);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}