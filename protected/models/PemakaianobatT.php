<?php

/**
 * This is the model class for table "pemakaianobat_t".
 *
 * The followings are the available columns in table 'pemakaianobat_t':
 * @property integer $pemakaianobat_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $tglpemakaianobat
 * @property string $nopemakaian_obat
 * @property string $untukkeperluan_obat
 * @property string $ket_pemakaianobat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemakaianobatT extends CActiveRecord
{
        public $tglAwal;
        public $tglAkhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianobatT the static model class
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
		return 'pemakaianobat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, ruangan_id, tglpemakaianobat, nopemakaian_obat, untukkeperluan_obat, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopemakaian_obat', 'length', 'max'=>20),
			array('untukkeperluan_obat', 'length', 'max'=>200),
			array('ket_pemakaianobat, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianobat_id, pegawai_id, ruangan_id, tglpemakaianobat, nopemakaian_obat, untukkeperluan_obat, ket_pemakaianobat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianobat_id' => 'Pemakaian Obat',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'tglpemakaianobat' => 'Tgl. Pemakaian Obat',
			'nopemakaian_obat' => 'No. Pemakaian Obat',
			'untukkeperluan_obat' => 'Untuk Keperluan',
			'ket_pemakaianobat' => 'Keterangan Pemakaian Obat',
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

		if(!empty($this->pemakaianobat_id)){
			$criteria->addCondition('pemakaianobat_id = '.$this->pemakaianobat_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglpemakaianobat)',strtolower($this->tglpemakaianobat),true);
		$criteria->compare('LOWER(nopemakaian_obat)',strtolower($this->nopemakaian_obat),true);
		$criteria->compare('LOWER(untukkeperluan_obat)',strtolower($this->untukkeperluan_obat),true);
		$criteria->compare('LOWER(ket_pemakaianobat)',strtolower($this->ket_pemakaianobat),true);
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
            // $criteria->limit=10;

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
        
        public function searchPemakaian() {
            $criteria=$this->criteriaSearch();
            if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
                $criteria->addBetweenCondition('tglpemakaianobat::date', $this->tglAwal, $this->tglAkhir);
            }
            $criteria->compare('create_ruangan', $this->create_ruangan);
            // $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}