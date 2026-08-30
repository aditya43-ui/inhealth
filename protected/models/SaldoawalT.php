<?php

/**
 * This is the model class for table "saldoawal_t".
 *
 * The followings are the available columns in table 'saldoawal_t':
 * @property integer $saldoawal_id
 * @property integer $rekening4_id
 * @property integer $rekperiod_id
 * @property integer $matauang_id
 * @property integer $rekening5_id
 * @property integer $kursrp_id
 * @property integer $rekening2_id
 * @property integer $rekening1_id
 * @property integer $rekening3_id
 * @property double $jmlanggaran
 * @property double $jmlsaldoawald
 * @property double $jmlsaldoawalk
 * @property double $jmlmutasid
 * @property double $jmlmutasik
 * @property double $jmlsaldoakhird
 * @property double $jmlsaldoakhirk
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $periodeposting_id
 *
 * The followings are the available model relations:
 * @property KursrpM $kursrp
 * @property MatauangM $matauang
 * @property Rekening4M $rekening4
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening5M $rekening5
 * @property RekperiodM $rekperiod
 */
class SaldoawalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaldoawalT the static model class
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
		return 'saldoawal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id, jmlanggaran, jmlsaldoawald, jmlsaldoawalk, jmlmutasid, jmlmutasik, jmlsaldoakhird, jmlsaldoakhirk, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rekening4_id, rekperiod_id, matauang_id, rekening5_id, kursrp_id, rekening2_id, rekening1_id, rekening3_id', 'numerical', 'integerOnly'=>true),
			array('jmlanggaran, jmlsaldoawald, jmlsaldoawalk, jmlmutasid, jmlmutasik, jmlsaldoakhird, jmlsaldoakhirk', 'numerical'),
			array('periodeposting_id, update_time, update_loginpemakai_id, unitkerja_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('saldoawal_id, rekening4_id, rekperiod_id, matauang_id, rekening5_id, kursrp_id, rekening2_id, rekening1_id, rekening3_id, jmlanggaran, jmlsaldoawald, jmlsaldoawalk, jmlmutasid, jmlmutasik, jmlsaldoakhird, jmlsaldoakhirk, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kursrp' => array(self::BELONGS_TO, 'KursrpM', 'kursrp_id'),
			'matauang' => array(self::BELONGS_TO, 'MatauangM', 'matauang_id'),
//			'rekening4' => array(self::BELONGS_TO, 'Rekening4M', 'rekening4_id'),
//			'rekening1' => array(self::BELONGS_TO, 'Rekening1M', 'rekening1_id'),
//			'rekening2' => array(self::BELONGS_TO, 'Rekening2M', 'rekening2_id'),
//			'rekening3' => array(self::BELONGS_TO, 'Rekening3M', 'rekening3_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'rekperiod' => array(self::BELONGS_TO, 'RekperiodM', 'rekperiod_id'),
			'periodeposting'=>array(self::BELONGS_TO,'PeriodepostingM','periodeposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'saldoawal_id' => 'Saldo Awal ID',
			'rekening4_id' => 'Rekening ID 4',
			'rekperiod_id' => 'Rekening Period',
			'matauang_id' => 'Mata Uang',
			'rekening5_id' => 'Rekening ID 5',
			'kursrp_id' => 'Kurs Rp',
			'rekening2_id' => 'Rekening ID 2',
			'rekening1_id' => 'Rekening ID 1',
			'rekening3_id' => 'Rekening ID 3',
			'jmlanggaran' => 'Jml Anggaran',
			'jmlsaldoawald' => 'Jml Saldo Awal Debit',
			'jmlsaldoawalk' => 'Jml Saldo Awal Kredit',
			'jmlmutasid' => 'Jml Mutasi Debit',
			'jmlmutasik' => 'Jml Mutasi Kredit',
			'jmlsaldoakhird' => 'Jml Saldo Akhir Debit',
			'jmlsaldoakhirk' => 'Jml Saldo Akhir Kredit',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'unitkerja_id' => 'Unit Kerja',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('saldoawal_id',$this->saldoawal_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('kursrp_id',$this->kursrp_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('saldoawal_id',$this->saldoawal_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('kursrp_id',$this->kursrp_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {          
            if($this->rekening3_id===null || trim($this->rekening3_id)==''){
	        $this->setAttribute('rekening3_id', null);
            }
            
            if($this->rekening4_id===null || trim($this->rekening4_id)==''){
	        $this->setAttribute('rekening4_id', null);
            }
            
            if($this->rekening5_id===null || trim($this->rekening5_id)==''){
	        $this->setAttribute('rekening5_id', null);
            }
            return parent::beforeSave();
        }      
}