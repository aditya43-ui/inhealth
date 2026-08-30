<?php

/**
 * This is the model class for table "jenispenerimaan_m".
 *
 * The followings are the available columns in table 'jenispenerimaan_m':
 * @property integer $jenispenerimaan_id
 * @property string $jenispenerimaan_kode
 * @property string $jenispenerimaan_nama
 * @property string $jenispenerimaan_namalain
 * @property string $jenispenerimaan_aktif
 */
class JenispenerimaanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispenerimaanM the static model class
	 */
	public $rekDebit, $rekKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenispenerimaan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispenerimaan_kode, jenispenerimaan_nama', 'required'),
			array('jenispenerimaan_kode', 'length', 'max'=>50),
			array('jenispenerimaan_nama, jenispenerimaan_namalain', 'length', 'max'=>100),
			array('jenispenerimaan_aktif', 'length', 'max'=>10),
            array('persenpph_22, persenpph_23, jenispenerimaan_namalain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispenerimaan_id, jenispenerimaan_kode, rekDebit, rekKredit, jenispenerimaan_nama, jenispenerimaan_namalain, jenispenerimaan_aktif, persenpph_22, persenpph_23', 'safe', 'on'=>'search'),
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
			'jenispenerimaan_id' => 'ID Jenis Penerimaan',
			'jenispenerimaan_kode' => 'Kode',
			'jenispenerimaan_nama' => 'Nama',
			'jenispenerimaan_namalain' => 'Nama Lain',
			'jenispenerimaan_aktif' => 'Aktif',
            'persenpph_22' => '% PPH Final',
            'persenpph_23' => '% PPH 23',
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

		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
//                $criteria->addCondition('jenispenerimaan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchJenisPenerimaan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		$criteria->compare('jenispenerimaan_aktif', isset($this->jenispenerimaan_aktif)?$this->jenispenerimaan_aktif:true);
                // $criteria->addCondition("jenispenerimaan_id not in(select jenispenerimaan_id from jnspenerimaanrek_m)");
               // $criteria->addCondition('jenispenerimaan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 *  digunakan untuk mencetak data ke dalma bentuk printout
	 * @return \CActiveDataProvider
	 */
	public function searchJenisPenerimaanPrint()
	{
		
		$criteria=new CDbCriteria;

		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		$criteria->compare('jenispenerimaan_aktif', isset($this->jenispenerimaan_aktif)?$this->jenispenerimaan_aktif:true);
        $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchJenisPenerimaanRek()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
                //$criteria->compare('persenpph_22',$this->persenpph_22);
                $criteria->compare('persenpph_23::text',strtolower($this->persenpph_23), true);
		$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
		$criteria->addCondition("jenispenerimaan_id in(select jenispenerimaan_id from jnspenerimaanrek_m)");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchDialog(){
		$criteria=new CDbCriteria;
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);		
		$criteria->addCondition(" jenispenerimaan_aktif = TRUE ");
		$criteria->limit=10; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,				
		));
	}
}