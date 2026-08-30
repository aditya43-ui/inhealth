<?php

/**
 * This is the model class for table "rekeningakuntansi5_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi5_v':
 * @property integer $rekening1_id
 * @property string $koderekening1
 * @property string $namarekening1
 * @property string $rekening1_nb
 * @property integer $kelompokrekening1_id
 * @property integer $rekening2_id
 * @property string $koderekening2
 * @property string $namarekening2
 * @property string $rekening2_nb
 * @property integer $kelompokrekening2_id
 * @property integer $rekening3_id
 * @property string $koderekening3
 * @property string $namarekening3
 * @property string $rekening3_nb
 * @property integer $kelompokrekening3_id
 * @property integer $rekening4_id
 * @property string $koderekening4
 * @property string $namarekening4
 * @property string $rekening4_nb
 * @property integer $kelompokrekening4_id
 * @property integer $rekeninglast_id
 * @property string $koderekeninglast
 * @property string $namarekeninglast
 * @property string $rekeninglast_nb
 * @property integer $kelompokrekeninglast_id
 */
class Rekeningakuntansi5V extends CActiveRecord
{
	public $rekening5_id, $namarekening5,$rekening6_id, $namarekening6,$rekening7_id, $namarekening7,$rekening8_id, $namarekening8;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rekeningakuntansi5_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening1_id, kelompokrekening1_id, rekening2_id, kelompokrekening2_id, rekening3_id, kelompokrekening3_id, rekening4_id, kelompokrekening4_id, rekeninglast_id, kelompokrekeninglast_id', 'numerical', 'integerOnly'=>true),
			array('koderekening1, koderekening2, koderekening3, koderekening4, koderekeninglast', 'length', 'max'=>20),
			array('namarekening1, namarekening2, namarekening3, namarekening4, namarekeninglast', 'length', 'max'=>500),
			array('rekening1_nb, rekening2_nb, rekening3_nb, rekening4_nb, rekeninglast_nb', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rekening1_id, koderekening1, namarekening1, rekening1_nb, kelompokrekening1_id, rekening2_id, koderekening2, namarekening2, rekening2_nb, kelompokrekening2_id, rekening3_id, koderekening3, namarekening3, rekening3_nb, kelompokrekening3_id, rekening4_id, koderekening4, namarekening4, rekening4_nb, kelompokrekening4_id, rekeninglast_id, koderekeninglast, namarekeninglast, rekeninglast_nb, kelompokrekeninglast_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekening1_id' => 'Rekening1',
			'koderekening1' => 'Koderekening1',
			'namarekening1' => 'Namarekening1',
			'rekening1_nb' => 'Rekening1 Nb',
			'kelompokrekening1_id' => 'Kelompokrekening1',
			'rekening2_id' => 'Rekening2',
			'koderekening2' => 'Koderekening2',
			'namarekening2' => 'Namarekening2',
			'rekening2_nb' => 'Rekening2 Nb',
			'kelompokrekening2_id' => 'Kelompokrekening2',
			'rekening3_id' => 'Rekening3',
			'koderekening3' => 'Koderekening3',
			'namarekening3' => 'Namarekening3',
			'rekening3_nb' => 'Rekening3 Nb',
			'kelompokrekening3_id' => 'Kelompokrekening3',
			'rekening4_id' => 'Rekening4',
			'koderekening4' => 'Koderekening4',
			'namarekening4' => 'Namarekening4',
			'rekening4_nb' => 'Rekening4 Nb',
			'kelompokrekening4_id' => 'Kelompokrekening4',
			'rekeninglast_id' => 'Rekeninglast',
			'koderekeninglast' => 'Koderekeninglast',
			'namarekeninglast' => 'Namarekeninglast',
			'rekeninglast_nb' => 'Rekeninglast Nb',
			'kelompokrekeninglast_id' => 'Kelompokrekeninglast',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('koderekening1',$this->koderekening1,true);
		$criteria->compare('namarekening1',$this->namarekening1,true);
		$criteria->compare('rekening1_nb',$this->rekening1_nb,true);
		$criteria->compare('kelompokrekening1_id',$this->kelompokrekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('koderekening2',$this->koderekening2,true);
		$criteria->compare('namarekening2',$this->namarekening2,true);
		$criteria->compare('rekening2_nb',$this->rekening2_nb,true);
		$criteria->compare('kelompokrekening2_id',$this->kelompokrekening2_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('koderekening3',$this->koderekening3,true);
		$criteria->compare('namarekening3',$this->namarekening3,true);
		$criteria->compare('rekening3_nb',$this->rekening3_nb,true);
		$criteria->compare('kelompokrekening3_id',$this->kelompokrekening3_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('koderekening4',$this->koderekening4,true);
		$criteria->compare('namarekening4',$this->namarekening4,true);
		$criteria->compare('rekening4_nb',$this->rekening4_nb,true);
		$criteria->compare('kelompokrekening4_id',$this->kelompokrekening4_id);
		$criteria->compare('rekeninglast_id',$this->rekeninglast_id);
		$criteria->compare('koderekeninglast',$this->koderekeninglast,true);
		$criteria->compare('namarekeninglast',$this->namarekeninglast,true);
		$criteria->compare('rekeninglast_nb',$this->rekeninglast_nb,true);
		$criteria->compare('kelompokrekeninglast_id',$this->kelompokrekeninglast_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rekeningakuntansi5V the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchDialogAccount()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}

		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}

		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}

		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}

		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}

		if(!empty($this->rekening6_id)){
			$criteria->addCondition('rekening6_id = '.$this->rekening6_id);
		}

		if(!empty($this->rekening7_id)){
			$criteria->addCondition('rekening7_id = '.$this->rekening7_id);
		}

		if(!empty($this->rekening8_id)){
			$criteria->addCondition('rekening8_id = '.$this->rekening8_id);
		}

		if(!empty($this->kelompokrekeninglast_id)){
			$criteria->addCondition('kelompokrekeninglast_id = '.$this->kelompokrekeninglast_id);
		}

		$criteria->compare('lower(koderekeninglast)',strtolower($this->koderekeninglast),true);
		$criteria->compare('lower(namarekeninglast)',strtolower($this->namarekeninglast),true);
		$criteria->compare('rekeninglast_nb',$this->rekeninglast_nb,false);
		
		$orderby = "koderekening1,koderekening2,koderekening3,koderekening4";
		if(!empty(Yii::app()->user->getState('levelrekeninglast'))){
			if(Yii::app()->user->getState('levelrekeninglast') == 6){
				$orderby = "koderekening1,koderekening2,koderekening3,koderekening4,koderekening5";
				$model = new Rekeningakuntansi6V();
			}else if(Yii::app()->user->getState('levelrekeninglast') == 7){
				$orderby = "koderekening1,koderekening2,koderekening3,koderekening4,koderekening5,koderekening6";
				$model = new Rekeningakuntansi7V();
			}else if(Yii::app()->user->getState('levelrekeninglast') == 8){
				$orderby = "koderekening1,koderekening2,koderekening3,koderekening4,koderekening5,koderekening6,koderekening7";
				$model = new Rekeningakuntansi8V();
			}else{
				$model = $this;
			}
		}else{
			 
			$model = $this;
		}
		$criteria->order = $orderby.',koderekeninglast';

		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
		));
	}
	
}
