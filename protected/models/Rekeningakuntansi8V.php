<?php

/**
 * This is the model class for table "rekeningakuntansi8_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi8_v':
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
 * @property integer $rekening5_id
 * @property string $koderekening5
 * @property string $namarekening5
 * @property string $rekening5_nb
 * @property integer $kelompokrekening5_id
 * @property integer $rekening6_id
 * @property string $koderekening6
 * @property string $namarekening6
 * @property string $rekening6_nb
 * @property integer $kelompokrekening6_id
 * @property integer $rekening7_id
 * @property string $koderekening7
 * @property string $namarekening7
 * @property string $rekening7_nb
 * @property integer $kelompokrekening7_id
 * @property integer $rekeninglast_id
 * @property string $koderekeninglast
 * @property string $namarekeninglast
 * @property string $rekeninglast_nb
 * @property integer $kelompokrekeninglast_id
 */
class Rekeningakuntansi8V extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rekeningakuntansi8_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening1_id, kelompokrekening1_id, rekening2_id, kelompokrekening2_id, rekening3_id, kelompokrekening3_id, rekening4_id, kelompokrekening4_id, rekening5_id, kelompokrekening5_id, rekening6_id, kelompokrekening6_id, rekening7_id, kelompokrekening7_id, rekeninglast_id, kelompokrekeninglast_id', 'numerical', 'integerOnly'=>true),
			array('koderekening1, koderekening2, koderekening3, koderekening4, koderekening5, koderekening6, koderekening7, koderekeninglast', 'length', 'max'=>20),
			array('namarekening1, namarekening2, namarekening3, namarekening4, namarekening5, namarekening6, namarekening7, namarekeninglast', 'length', 'max'=>500),
			array('rekening1_nb, rekening2_nb, rekening3_nb, rekening4_nb, rekening5_nb, rekening6_nb, rekening7_nb, rekeninglast_nb', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rekening1_id, koderekening1, namarekening1, rekening1_nb, kelompokrekening1_id, rekening2_id, koderekening2, namarekening2, rekening2_nb, kelompokrekening2_id, rekening3_id, koderekening3, namarekening3, rekening3_nb, kelompokrekening3_id, rekening4_id, koderekening4, namarekening4, rekening4_nb, kelompokrekening4_id, rekening5_id, koderekening5, namarekening5, rekening5_nb, kelompokrekening5_id, rekening6_id, koderekening6, namarekening6, rekening6_nb, kelompokrekening6_id, rekening7_id, koderekening7, namarekening7, rekening7_nb, kelompokrekening7_id, rekeninglast_id, koderekeninglast, namarekeninglast, rekeninglast_nb, kelompokrekeninglast_id', 'safe', 'on'=>'search'),
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
			'rekening5_id' => 'Rekening5',
			'koderekening5' => 'Koderekening5',
			'namarekening5' => 'Namarekening5',
			'rekening5_nb' => 'Rekening5 Nb',
			'kelompokrekening5_id' => 'Kelompokrekening5',
			'rekening6_id' => 'Rekening6',
			'koderekening6' => 'Koderekening6',
			'namarekening6' => 'Namarekening6',
			'rekening6_nb' => 'Rekening6 Nb',
			'kelompokrekening6_id' => 'Kelompokrekening6',
			'rekening7_id' => 'Rekening7',
			'koderekening7' => 'Koderekening7',
			'namarekening7' => 'Namarekening7',
			'rekening7_nb' => 'Rekening7 Nb',
			'kelompokrekening7_id' => 'Kelompokrekening7',
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
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('koderekening5',$this->koderekening5,true);
		$criteria->compare('namarekening5',$this->namarekening5,true);
		$criteria->compare('rekening5_nb',$this->rekening5_nb,true);
		$criteria->compare('kelompokrekening5_id',$this->kelompokrekening5_id);
		$criteria->compare('rekening6_id',$this->rekening6_id);
		$criteria->compare('koderekening6',$this->koderekening6,true);
		$criteria->compare('namarekening6',$this->namarekening6,true);
		$criteria->compare('rekening6_nb',$this->rekening6_nb,true);
		$criteria->compare('kelompokrekening6_id',$this->kelompokrekening6_id);
		$criteria->compare('rekening7_id',$this->rekening7_id);
		$criteria->compare('koderekening7',$this->koderekening7,true);
		$criteria->compare('namarekening7',$this->namarekening7,true);
		$criteria->compare('rekening7_nb',$this->rekening7_nb,true);
		$criteria->compare('kelompokrekening7_id',$this->kelompokrekening7_id);
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
	 * @return Rekeningakuntansi8V the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
