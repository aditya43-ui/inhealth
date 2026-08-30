<?php

/**
 * This is the model class for table "pertukaranjadwaldet_t".
 *
 * The followings are the available columns in table 'pertukaranjadwaldet_t':
 * @property integer $pertukaranjadwaldet_id
 * @property integer $shift_id
 * @property integer $pertukaranjadwal_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $tglpertukaranjadwal
 * @property string $alasanpertukaran
 * @property string $ketranganpertukaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PertukaranjadwaldetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PertukaranjadwaldetT the static model class
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
		return 'pertukaranjadwaldet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, pegawai_id, tglpertukaranjadwal, alasanpertukaran, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('shift_id, pertukaranjadwal_id, pegawai_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('alasanpertukaran', 'length', 'max'=>200),
			array('ketranganpertukaran, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pertukaranjadwaldet_id, shift_id, pertukaranjadwal_id, pegawai_id, ruangan_id, tglpertukaranjadwal, alasanpertukaran, ketranganpertukaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'shift'=>array(self::BELONGS_TO,'ShiftM','shift_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'pertukaranjadwal'=>array(self::BELONGS_TO,'PertukaranjadwalT','pertukaranjadwal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pertukaranjadwaldet_id' => 'Pertukaran Jadwal Detail',
			'shift_id' => 'Shift',
			'pertukaranjadwal_id' => 'Pertukaran Jadwal',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'tglpertukaranjadwal' => 'Tanggal Pertukaran Jadwal',
			'alasanpertukaran' => 'Alasan Pertukaran',
			'ketranganpertukaran' => 'Keterangan',
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

		if(!empty($this->pertukaranjadwaldet_id)){
			$criteria->addCondition('pertukaranjadwaldet_id = '.$this->pertukaranjadwaldet_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pertukaranjadwal_id)){
			$criteria->addCondition('pertukaranjadwal_id = '.$this->pertukaranjadwal_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglpertukaranjadwal)',strtolower($this->tglpertukaranjadwal),true);
		$criteria->compare('LOWER(alasanpertukaran)',strtolower($this->alasanpertukaran),true);
		$criteria->compare('LOWER(ketranganpertukaran)',strtolower($this->ketranganpertukaran),true);
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
        
        public function cekPertukaran($pegawai_id, $tanggal)
        {
            $format = new MyFormatter();
            $tgl = $format->formatDateTimeForDb(date('Y-m-d', strtotime($tanggal)));
            $cek = $this->find("pegawai_id = '$pegawai_id' AND tglpertukaranjadwal =  '$tgl' ");
            
            if (count((array)$cek)>0){
                return $cek->shift_id;
            }else{
                return 0;
            }
        }
}