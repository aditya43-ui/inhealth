<?php

/**
 * This is the model class for table "pelayananrek_m".
 *
 * The followings are the available columns in table 'pelayananrek_m':
 * @property integer $pelayananrek_id
 * @property integer $rekening4_id
 * @property integer $rekening5_id
 * @property integer $ruangan_id
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property integer $daftartindakan_id
 * @property integer $rekening2_id
 * @property string $saldonormal
 * @property string $jnspelayanan
 * @property integer $komponentarif_id
 *
 * The followings are the available model relations:
 * @property DaftartindakanM $daftartindakan
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 * @property RuanganM $ruangan
 */
class PelayananrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelayananrekM the static model class
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
		return 'pelayananrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, daftartindakan_id, saldonormal, jnspelayanan', 'required'),
			array('rekening4_id, rekening5_id, ruangan_id, rekening3_id, rekening1_id, rekening2_id', 'numerical', 'integerOnly'=>true),
			array('saldonormal', 'length', 'max'=>10),
			array('jnspelayanan', 'length', 'max'=>20),
			array('debitkredit, ispelayanan, ispembayaran, isretur, ishutang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelayananrek_id, rekening4_id, rekening5_id, ruangan_id, ruanganNama, daftartindakan_id, daftartindakan_nama, rekening3_id, rekening1_id, rekening2_id, saldonormal, jnspelayanan', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pelayananrek_id' => 'Pelayananrek',
			'rekening4_id' => 'Rekening4',
			'rekening5_id' => 'Rekening5',
			'ruangan_id' => 'Ruangan',
			'rekening3_id' => 'Rekening3',
			'rekening1_id' => 'Rekening1',
			'rekening2_id' => 'Rekening2',
			'saldonormal' => 'Saldo Normal',
			'jnspelayanan' => 'Jenis Pelayanan',
                        'rekeningdebit_id' => 'Rekening Debit',
                        'rekeningkredit_id' => 'Rekening Kredit',
			'ispelayanan' => 'Pelayanan',
			'ispembayaran' => 'Pembayaran',
			'isretur' => 'Retur',
			'ishutang' => 'Hutang,'
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

		$criteria->compare('pelayananrek_id',$this->pelayananrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
                $criteria->select = "t.ruangan_id,t.jnspelayanan,t.daftartindakan_id,ruangan_m.ruangan_nama";
                $criteria->join = "JOIN ruangan_m ON t.ruangan_id=ruangan_m.ruangan_id";
                $criteria->group = "t.ruangan_id,t.jnspelayanan,t.daftartindakan_id,ruangan_m.ruangan_nama";
                $criteria->order = 't.ruangan_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pelayananrek_id',$this->pelayananrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

    public function searchPelayanan()
    {
         
        $criteria=new CDbCriteria;
        $criteria->select = 'ruangan_id, daftartindakan_id, jnspelayanan';
		$criteria->compare('pelayananrek_id',$this->pelayananrek_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
        $criteria->group = 'ruangan_id, daftartindakan_id, jnspelayanan';
                // 	exit;
        if(isset($this->ruanganNama))
        {
            $criteria_satu = new CDbCriteria;
            
            $criteria_satu->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->ruanganNama),true); 
            
            $record = TindakanruanganM::model()->with("ruangan")->findAll($criteria_satu);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->ruangan_id;
            }
            if(count((array)$data)>0){
            	$condition = 'ruangan_id IN ('. implode(',', $data) .')';
           		$criteria->addCondition($condition);	
            } 
           
        }

        if(isset($this->daftartindakan_nama))
        {
            $criteria_satu = new CDbCriteria;
            
                $criteria_satu->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($this->daftartindakan_nama),true); 
            
            $record = TindakanruanganM::model()->with("daftartindakan")->findAll($criteria_satu);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->daftartindakan_id;
            }
            if(count((array)$data)>0){
	           $condition = 'daftartindakan_id IN ('. implode(',', $data) .')';
	           $criteria->addCondition($condition);
	        }
        }

        // var_dump($this->rekDebit);
        // exit;
        if(isset($this->rekDebit)){

            $debit = "D";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekDebit),true);
            $criteria_satu->compare('LOWER(saldonormal)',strtolower($debit),true);
            
            $record = PelayananrekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->daftartindakan_id;
            }
            if(count((array)$data)>0){
                   $condition = 'daftartindakan_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }
                
        if(isset($this->rekKredit)){

            $debit = "K";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekKredit),true);
            $criteria_satu->compare('LOWER(saldonormal)',strtolower($debit),true);
            
            $record = PelayananrekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->daftartindakan_id;
            }
            if(count((array)$data)>0){
                   $condition = 'daftartindakan_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}