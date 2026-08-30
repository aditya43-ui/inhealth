<?php

/**
 * This is the model class for table "jnspengeluaranrek_m".
 *
 * The followings are the available columns in table 'jnspengeluaranrek_m':
 * @property integer $jnspengeluaranrek_id
 * @property integer $rekening1_id
 * @property integer $jenispengeluaran_id
 * @property integer $rekening3_id
 * @property integer $rekening5_id
 * @property integer $rekening2_id
 * @property integer $rekening4_id
 * @property string $saldonormal
 */
class JnspengeluaranrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnspengeluaranrekM the static model class
	 */
        public $jnsNama, $rekDebit, $rekKredit, $jenispengeluaran_kode, $jenispengeluaran_namalain, $jenispengeluaran_nama, $jenispengeluaran_aktif,$rekening_debit, $rekeningKredit;
		public $kdrekening5, $nmrekening5;
		
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jnspengeluaranrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, saldonormal', 'required'),
			array('rekening1_id, jenispengeluaran_id, rekening3_id, rekening5_id, rekening2_id, rekening4_id', 'numerical', 'integerOnly'=>true),
			array('saldonormal', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnspengeluaranrek_id, jenispengeluaran_kode, rekening_debit, rekeningKredit, jenispengeluaran_nama, jenispengeluaran_namalain, jnsNama, rekDebit, rekKredit, rekening1_id, jenispengeluaran_id, rekening3_id, rekening5_id, rekening2_id, rekening4_id, saldonormal', 'safe', 'on'=>'search'),
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
                    'rekeningdebit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'rekeningkredit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'jenispengeluaran'=>array(self::BELONGS_TO,'JenispengeluaranM','jenispengeluaran_id'),
					'rekening4'=>array(self::BELONGS_TO,'Rekening4M','rekening4_id'),
                    'rekening3'=>array(self::BELONGS_TO,'Rekening3M','rekening3_id'),
                    'rekening2'=>array(self::BELONGS_TO,'Rekening2M','rekening2_id'),
                    'rekening1'=>array(self::BELONGS_TO,'Rekening1M','rekening1_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnspengeluaranrek_id' => 'ID Pengeluaran Rek',
			'rekening1_id' => 'Rekening 1',
			'jenispengeluaran_id' => 'Jenis Pengeluaran',
			'rekening3_id' => 'Rekening 3',
			'rekening5_id' => 'Rekening 5',
			'rekening2_id' => 'Rekening 2',
			'rekening4_id' => 'Rekening 4',
			'saldonormal' => 'Saldo Normal',
			'jenispengeluaran_kode'=>'Kode',
			'jenispengeluaran_nama'=>'Nama',
			'jenispengeluaran_namalain'=>'Nama Lain',
			'jenispengeluaran_aktif'=>'Aktif',
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

		$criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}