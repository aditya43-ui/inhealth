<?php

/**
 * This is the model class for table "jenispengeluaran_m".
 *
 * The followings are the available columns in table 'jenispengeluaran_m':
 * @property integer $jenispengeluaran_id
 * @property string $jenispengeluaran_nama
 * @property string $jenispengeluaran_namalain
 * @property boolean $jenispengeluaran_aktif
 */
class JenispengeluaranM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispengeluaranM the static model class
	 */
        public $rekDebit, $rekKredit,$rekening5_id,$nmrekening5,$kdrekening5;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenispengeluaran_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_nama,jenispengeluaran_kode','required'),
			array('jenispengeluaran_nama, jenispengeluaran_namalain', 'length', 'max'=>100),
			array('jenispengeluaran_aktif, persenpph_21, persenpph_22, persenpph_23, iskiriminvoiceklaim, ispengembalianuangmuka', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispengeluaran_id, jenispengeluaran_nama, rekDebit, rekKredit, jeispengeluaran_kode, jenispengeluaran_namalain,jenispengeluaran_aktif, persenpph_21, persenpph_22, persenpph_23, iskiriminvoiceklaim, ispengembalianuangmuka', 'safe', 'on'=>'search'),
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
			'jenispengeluaran_id' => 'ID Jenis Pengeluaran',
                        'jenispengeluaran_kode'=>'Kode',
			'jenispengeluaran_nama' => 'Nama',
			'jenispengeluaran_namalain' => 'Nama Lain',
			'jenispengeluaran_aktif' => 'Aktif',
            'persenpph_21' => '% PPH 21',
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

		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',isset($this->jenispengeluaran_aktif)?$this->jenispengeluaran_aktif:true);
//                $criteria->addCondition('jenispengeluaran_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchJenisPengeluaran()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
//                $criteria->addCondition("jenispengeluaran_id not in(select jenispengeluaran_id from jnspengeluaranrek_m)");
                $criteria->addCondition('jenispengeluaran_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchJenisPengeluaranPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
//                $criteria->addCondition("jenispengeluaran_id not in(select jenispengeluaran_id from jnspengeluaranrek_m)");
                $criteria->addCondition('jenispengeluaran_aktif is true');
				$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
        
	public function searchJnsPengeluaranInRek()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
                $criteria->addCondition("jenispengeluaran_id IN(select jenispengeluaran_id from jnspengeluaranrek_m)");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}      
    
	public function searchJnsPengeluaranInDialog()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
                $criteria->compare('persenpph_21::text',strtolower($this->persenpph_21),true);
                $criteria->compare('persenpph_22::text',strtolower($this->persenpph_22),true);
                $criteria->compare('persenpph_23::text',strtolower($this->persenpph_23),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
        $criteria->addCondition("jenispengeluaran_id IN(select jenispengeluaran_id from jnspengeluaranrek_m)");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'jenispengeluaran_nama',
			),
		));
	}        
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
		
		public function searchDialog(){
			$criteria=new CDbCriteria;
			$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
			$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);		
			$criteria->addCondition(" jenispengeluaran_aktif = TRUE ");
			$criteria->limit=10; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,				
			));
		}
}
