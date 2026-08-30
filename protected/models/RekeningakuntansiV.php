<?php

/**
 * This is the model class for table "rekeningakuntansi_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $rekeninglast_nb
 * @property integer $kelompokrek1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $rekening2_nb
 * @property integer $kelompokrek2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $rekening3_nb
 * @property integer $kelompokrek3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $rekening4_nb
 * @property integer $kelompokrek4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $rekening5_nb
 * @property integer $kelompokrek5
 * @property integer $rekening6_id
 * @property string $kdrekening6
 * @property string $nmrekening6
 * @property string $rekening6_nb
 * @property integer $kelompokrek6
 * @property integer $rekening7_id
 * @property string $kdrekening7
 * @property string $nmrekening7
 * @property string $rekening7_nb
 * @property integer $kelompokrek7
 * @property integer $rekening8_id
 * @property string $kdrekening8
 * @property string $nmrekening8
 * @property string $rekening8_nb
 * @property integer $kelompokrek8
 * @property integer $rekening9_id
 * @property string $kdrekening9
 * @property string $nmrekening9
 * @property string $rekening9_nb
 * @property integer $kelompokrek9
 * @property integer $rekening10_id
 * @property string $kdrekening10
 * @property string $nmrekening10
 * @property string $rekening10_nb
 * @property integer $kelompokrek10
 */
class RekeningakuntansiV extends CActiveRecord
{
	public $kelompokrek,$struktur_nb, $koderekeningkel, $saldodebit, $saldokredit, $periodeposting_id, $nourutrek;
	public $rek_column;
        public $tr_class;
        public $saldonormal;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekeningakuntansiV the static model class
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
		return 'rekeningakuntansi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening1_id, kelompokrek1, rekening2_id, kelompokrek2, rekening3_id, kelompokrek3, rekening4_id, kelompokrek4, rekening5_id, kelompokrek5, rekening6_id, kelompokrek6, rekening7_id, kelompokrek7, rekening8_id, kelompokrek8, rekening9_id, kelompokrek9, rekening10_id, kelompokrek10, rekeninglast_id, kelrekeninglast_id, tiperekeninglast_nb', 'numerical', 'integerOnly'=>true),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5, kdrekening6, kdrekening7, kdrekening8, kdrekening9, kdrekening10, kdrekeninglast', 'length', 'max'=>20),
			array('nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, nmrekening6, nmrekening7, nmrekening8, nmrekening9, nmrekening10, nmrekeninglast', 'length', 'max'=>500),
			array('rekening1_nb, rekening2_nb, rekening3_nb, rekening4_nb, rekening5_nb, rekening6_nb, rekening7_nb, rekening8_nb, rekening9_nb, rekening10_nb, rekeninglast_nb', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening1_id, kdrekening1, nmrekening1, rekening1_nb, kelompokrek1, rekening2_id, kdrekening2, nmrekening2, rekening2_nb, kelompokrek2, rekening3_id, kdrekening3, nmrekening3, rekening3_nb, kelompokrek3, rekening4_id, kdrekening4, nmrekening4, rekening4_nb, kelompokrek4, rekening5_id, kdrekening5, nmrekening5, rekening5_nb, kelompokrek5, rekening6_id, kdrekening6, nmrekening6, rekening6_nb, kelompokrek6, rekening7_id, kdrekening7, nmrekening7, rekening7_nb, kelompokrek7, rekening8_id, kdrekening8, nmrekening8, rekening8_nb, kelompokrek8, rekening9_id, kdrekening9, nmrekening9, rekening9_nb, kelompokrek9, rekening10_id, kdrekening10, nmrekening10, rekening10_nb, kelompokrek10,rekeninglast_id, kelrekeninglast_id, kdrekeninglast, nmrekeninglast, rekeninglast_nb, tiperekeninglast_nb', 'safe', 'on'=>'search'),
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
			'kdrekening1' => 'Level 1',
			'nmrekening1' => 'Level 1',
			'rekeninglast_nb' => 'Rekening1 Nb',
			'kelompokrek1' => 'Kelompokrek1',
			'rekening2_id' => 'Rekening2',
			'kdrekening2' => 'Level 2',
			'nmrekening2' => 'Level 2',
			'rekening2_nb' => 'Rekening2 Nb',
			'kelompokrek2' => 'Kelompokrek2',
			'rekening3_id' => 'Rekening3',
			'kdrekening3' => 'Level 3',
			'nmrekening3' => 'Level 3',
			'rekening3_nb' => 'Rekening3 Nb',
			'kelompokrek3' => 'Kelompokrek3',
			'rekening4_id' => 'Rekening4',
			'kdrekening4' => 'Level 4',
			'nmrekening4' => 'Level 4',
			'rekening4_nb' => 'Rekening4 Nb',
			'kelompokrek4' => 'Kelompokrek4',
			'rekening5_id' => 'Rekening5',
			'kdrekening5' => 'Level 5',
			'nmrekening5' => 'Level 5',
			'rekening5_nb' => 'Rekening5 Nb',
			'kelompokrek5' => 'Kelompokrek5',
			'rekening6_id' => 'Rekening6',
			'kdrekening6' => 'Level 6',
			'nmrekening6' => 'Level 6',
			'rekening6_nb' => 'Rekening6 Nb',
			'kelompokrek6' => 'Kelompokrek6',
			'rekening7_id' => 'Rekening7',
			'kdrekening7' => 'Level 7',
			'nmrekening7' => 'Level 7',
			'rekening7_nb' => 'Rekening7 Nb',
			'kelompokrek7' => 'Kelompokrek7',
			'rekening8_id' => 'Rekening8',
			'kdrekening8' => 'Level 8',
			'nmrekening8' => 'Level 8',
			'rekening8_nb' => 'Rekening8 Nb',
			'kelompokrek8' => 'Kelompokrek8',
			'rekening9_id' => 'Rekening9',
			'kdrekening9' => 'Level 9',
			'nmrekening9' => 'Level 9',
			'rekening9_nb' => 'Rekening9 Nb',
			'kelompokrek9' => 'Kelompokrek9',
			'rekening10_id' => 'Rekening10',
			'kdrekening10' => 'Level 10',
			'nmrekening10' => 'Level 10',
			'rekening10_nb' => 'Rekening10 Nb',
			'kelompokrek10' => 'Kelompokrek10',
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

		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('kdrekening1',$this->kdrekening1,true);
		$criteria->compare('nmrekening1',$this->nmrekening1,true);
		$criteria->compare('rekeninglast_nb',$this->rekeninglast_nb,true);
		// $criteria->compare('kelompokrek1',$this->kelompokrek1);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('kdrekening2',$this->kdrekening2,true);
		$criteria->compare('nmrekening2',$this->nmrekening2,true);
		$criteria->compare('rekening2_nb',$this->rekening2_nb,true);
		// $criteria->compare('kelompokrek2',$this->kelompokrek2);/
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('kdrekening3',$this->kdrekening3,true);
		$criteria->compare('nmrekening3',$this->nmrekening3,true);
		$criteria->compare('rekening3_nb',$this->rekening3_nb,true);
		// $criteria->compare('kelompokrek3',$this->kelompokrek3);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('kdrekening4',$this->kdrekening4,true);
		$criteria->compare('nmrekening4',$this->nmrekening4,true);
		$criteria->compare('rekening4_nb',$this->rekening4_nb,true);
		// $criteria->compare('kelompokrek4',$this->kelompokrek4);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('kdrekening5',$this->kdrekening5,true);
		$criteria->compare('nmrekening5',$this->nmrekening5,true);
		$criteria->compare('rekening5_nb',$this->rekening5_nb,true);
		// $criteria->compare('kelompokrek5',$this->kelompokrek5);
		$criteria->compare('rekening6_id',$this->rekening6_id);
		$criteria->compare('kdrekening6',$this->kdrekening6,true);
		$criteria->compare('nmrekening6',$this->nmrekening6,true);
		$criteria->compare('rekening6_nb',$this->rekening6_nb,true);
		// $criteria->compare('kelompokrek6',$this->kelompokrek6);
		$criteria->compare('rekening7_id',$this->rekening7_id);
		$criteria->compare('kdrekening7',$this->kdrekening7,true);
		$criteria->compare('nmrekening7',$this->nmrekening7,true);
		$criteria->compare('rekening7_nb',$this->rekening7_nb,true);
		// $criteria->compare('kelompokrek7',$this->kelompokrek7);
		$criteria->compare('rekening8_id',$this->rekening8_id);
		$criteria->compare('kdrekening8',$this->kdrekening8,true);
		$criteria->compare('nmrekening8',$this->nmrekening8,true);
		$criteria->compare('rekening8_nb',$this->rekening8_nb,true);
		// $criteria->compare('kelompokrek8',$this->kelompokrek8);
		$criteria->compare('rekening9_id',$this->rekening9_id);
		$criteria->compare('kdrekening9',$this->kdrekening9,true);
		$criteria->compare('nmrekening9',$this->nmrekening9,true);
		$criteria->compare('rekening9_nb',$this->rekening9_nb,true);
		// $criteria->compare('kelompokrek9',$this->kelompokrek9);
		$criteria->compare('rekening10_id',$this->rekening10_id);
		$criteria->compare('kdrekening10',$this->kdrekening10,true);
		$criteria->compare('nmrekening10',$this->nmrekening10,true);
		$criteria->compare('rekening10_nb',$this->rekening10_nb,true);
		// $criteria->compare('kelompokrek10',$this->kelompokrek10);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected  function searchCriteria(){
		$criteria=new CDbCriteria;
        if($this->rekeninglast_nb){
            $criteria->compare('rekeninglast_nb',$this->rekeninglast_nb);
        }

		if($this->kelrekeninglast_id){
            $criteria->addCondition('kelrekeninglast_id ='.$this->kelrekeninglast_id);
        }
		if($this->rekeninglast_id){
            $criteria->addCondition('rekeninglast_id ='.$this->rekeninglast_id);
        }
		if($this->kdrekeninglast){
            $criteria->compare('kdrekeninglast',$this->kdrekeninglast, true);
        }
	
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1), true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2), true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3), true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4), true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(nmrekening6)',strtolower($this->nmrekening6), true);
		$criteria->compare('LOWER(nmrekening7)',strtolower($this->nmrekening7), true);
		$criteria->compare('LOWER(nmrekening8)',strtolower($this->nmrekening8), true);
		$criteria->compare('LOWER(nmrekening9)',strtolower($this->nmrekening9), true);
		$criteria->compare('LOWER(nmrekening10)',strtolower($this->nmrekening10), true);
		$criteria->compare('LOWER(nmrekeninglast)',strtolower($this->nmrekeninglast), true);

		return $criteria;
	}
    public function searchAccounts(){
        $criteria= $this->searchCriteria();
		$criteria->order = 'kelrekeninglast_id';
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
	public function searchDialogAccount(){
		$criteria= $this->searchCriteria();
		$criteria->order = 'kelrekeninglast_id';

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function searchDebit(){
        $criteria= $this->searchCriteria();
		$criteria->order = 'kelrekeninglast_id';

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    public function searchKredit(){
		$criteria= $this->searchCriteria();
		$criteria->order = 'kelrekeninglast_id';

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));	
    }
    
}
