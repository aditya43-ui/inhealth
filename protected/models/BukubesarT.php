<?php

/**
 * This is the model class for table "bukubesar_t".
 *
 * The followings are the available columns in table 'bukubesar_t':
 * @property integer $bukubesar_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening2_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $tglbukubesar
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property double $saldoakhirberjalan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $no_referensi
 * @property integer $periodeposting_id
 *
 * The followings are the available model relations:
 * @property LaporanlabarugidetailR[] $laporanlabarugidetailRs
 * @property JurnalrekeningT[] $jurnalrekeningTs
 * @property JurnalpostingT[] $jurnalpostingTs
 * @property LaporanperubahanmodaldetailR[] $laporanperubahanmodaldetailRs
 * @property PeriodepostingM $periodeposting
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 */
class BukubesarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BukubesarT the static model class
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
		return 'bukubesar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglbukubesar, uraiantransaksi, create_time, create_loginpemakai_id, create_ruangan, rekening5_id', 'required'),
			array('rekening3_id, rekening4_id, rekening2_id, rekening5_id, rekening1_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, periodeposting_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit, saldoakhirberjalan', 'numerical'),
			array('uraiantransaksi', 'length', 'max'=>200),
			array('no_referensi', 'length', 'max'=>10),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bukubesar_id, rekening3_id, rekening4_id, rekening2_id, rekening5_id, rekening1_id, tglbukubesar, uraiantransaksi, saldodebit, saldokredit, saldoakhirberjalan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_referensi, periodeposting_id', 'safe', 'on'=>'search'),
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
			'laporanlabarugidetailRs' => array(self::HAS_MANY, 'LaporanlabarugidetailR', 'bukubesar_id'),
			'jurnalrekeningTs' => array(self::HAS_MANY, 'JurnalrekeningT', 'bukubesar_id'),
			'jurnalpostingTs' => array(self::HAS_MANY, 'JurnalpostingT', 'bukubesar_id'),
			'laporanperubahanmodaldetailRs' => array(self::HAS_MANY, 'LaporanperubahanmodaldetailR', 'bukubesar_id'),
			'periodeposting' => array(self::BELONGS_TO, 'PeriodepostingM', 'periodeposting_id'),
			'rekening1' => array(self::BELONGS_TO, 'Rekening1M', 'rekening1_id'),
			'rekening2' => array(self::BELONGS_TO, 'Rekening2M', 'rekening2_id'),
			'rekening3' => array(self::BELONGS_TO, 'Rekening3M', 'rekening3_id'),
			'rekening4' => array(self::BELONGS_TO, 'Rekening4M', 'rekening4_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'jurnalpos' => array(self::BELONGS_TO, 'JurnalpostingT', 'jurnalposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bukubesar_id' => 'Bukubesar',
			'rekening3_id' => 'Rekening3',
			'rekening4_id' => 'Rekening4',
			'rekening2_id' => 'Rekening2',
			'rekening5_id' => 'Rekening5',
			'rekening1_id' => 'Rekening1',
			'tglbukubesar' => 'Tglbukubesar',
			'uraiantransaksi' => 'Uraiantransaksi',
			'saldodebit' => 'Saldodebit',
			'saldokredit' => 'Saldokredit',
			'saldoakhirberjalan' => 'Saldoakhirberjalan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_referensi' => 'No Referensi',
			'periodeposting_id' => 'Periodeposting',
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

		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(tglbukubesar)',strtolower($this->tglbukubesar),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
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
		$criteria->compare('LOWER(no_referensi)',strtolower($this->no_referensi),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
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
}