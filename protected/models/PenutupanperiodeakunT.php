<?php

/**
 * This is the model class for table "penutupanperiodeakun_t".
 *
 * The followings are the available columns in table 'penutupanperiodeakun_t':
 * @property integer $penutupanperiodeakun_id
 * @property integer $rekperiod_id
 * @property integer $periodeposting_id
 * @property double $saldodebit
 * @property double $saldokredit
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property RekperiodM $rekperiod
 * @property PeriodepostingM $periodeposting
 */
class PenutupanperiodeakunT extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenutupanperiodeakunT the static model class
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
		return 'penutupanperiodeakun_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id, periodeposting_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rekperiod_id, periodeposting_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			array('tgl_awal, tgl_akhir, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, penutupanperiodeakun_id, rekperiod_id, periodeposting_id, saldodebit, saldokredit, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'rekperiod' => array(self::BELONGS_TO, 'RekperiodM', 'rekperiod_id'),
			'periodeposting' => array(self::BELONGS_TO, 'PeriodepostingM', 'periodeposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penutupanperiodeakun_id' => 'Penutupanperiodeakun',
			'rekperiod_id' => 'Rekperiod',
			'periodeposting_id' => 'Periodeposting',
			'saldodebit' => 'Saldodebit',
			'saldokredit' => 'Saldokredit',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'nopenutupan' => 'No Penutupan',
                    
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

		$criteria->compare('penutupanperiodeakun_id',$this->penutupanperiodeakun_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('periodeposting_id',$this->periodeposting_id);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(tglpenutupan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nopenutupan)', strtolower($this->nopenutupan),true);
        if(!empty($this->rekperiod_id)){
            $criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
        }
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
     public function searchPrintInformasi() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(tglpenutupan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nopenutupan)', strtolower($this->nopenutupan),true);
        if(!empty($this->rekperiod_id)){
            $criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
        }
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            'pagination'=>false
        ));
    }
}