<?php

/**
 * This is the model class for table "penjadwalandetail_t".
 *
 * The followings are the available columns in table 'penjadwalandetail_t':
 * @property integer $penjadwalandetail_id
 * @property integer $harilibur_id
 * @property integer $shift_id
 * @property integer $pertukaranjadwaldet_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $penjadwalan_id
 * @property string $tgljadwalpegawai
 */
class PenjadwalandetailT extends CActiveRecord
{
	public $kelompokpegawai_nama;
	public $tglmerah;
	public $asalshift_id;
	public $asalshift_nama;
	public $asalshift_awal;
	public $asalshift_akhir;
	public $asalruangan_id;
	public $asalruangan_nama;
	public $shift_jamawal;
	public $shift_jamakhir;
	public $instalasi_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjadwalandetailT the static model class
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
		return 'penjadwalandetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, pegawai_id, penjadwalan_id, tgljadwalpegawai', 'required'),
			array('harilibur_id, shift_id, pertukaranjadwaldet_id, pegawai_id, ruangan_id, penjadwalan_id', 'numerical', 'integerOnly'=>true),
			array('kelompokpegawai_id, jamkerjamasuk, jamkerjapulang','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penjadwalandetail_id, harilibur_id, shift_id, pertukaranjadwaldet_id, pegawai_id, ruangan_id, penjadwalan_id, tgljadwalpegawai', 'safe', 'on'=>'search'),
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
			'shift'=>array(self::BELONGS_TO,'ShiftM','shift_id'),
			'penjadwalan'=>array(self::BELONGS_TO,'PenjadwalanT','penjadwalan_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjadwalandetail_id' => 'Penjadwalan Detail',
			'harilibur_id' => 'Hari Libut',
			'shift_id' => 'Shift',
			'pertukaranjadwaldet_id' => 'Pertukaran Jadwal',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'penjadwalan_id' => 'Penjadwalan',
			'tgljadwalpegawai' => 'Tanggal Jadwal Pegawai',
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

		if(!empty($this->penjadwalandetail_id)){
			$criteria->addCondition('penjadwalandetail_id = '.$this->penjadwalandetail_id);
		}
		if(!empty($this->harilibur_id)){
			$criteria->addCondition('harilibur_id = '.$this->harilibur_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->pertukaranjadwaldet_id)){
			$criteria->addCondition('pertukaranjadwaldet_id = '.$this->pertukaranjadwaldet_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->penjadwalan_id)){
			$criteria->addCondition('penjadwalan_id = '.$this->penjadwalan_id);
		}
		$criteria->compare('LOWER(tgljadwalpegawai)',strtolower($this->tgljadwalpegawai),true);

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
        
        public function cekPenjadwalan($pegawai_id, $tanggal)
        {
            $format = new MyFormatter();
            $tgl = $format->formatDateTimeForDb(date('Y-m-d', strtotime($tanggal)));
            $cek = $this->find("pegawai_id = '$pegawai_id' AND tgljadwalpegawai = '$tanggal' ");
            
            if (count((array)$cek)>0){
                return $cek->shift_id;
            }else{
                return 0;
            }
                
        }
}