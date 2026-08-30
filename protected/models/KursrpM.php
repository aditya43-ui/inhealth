<?php

/**
 * This is the model class for table "kursrp_m".
 *
 * The followings are the available columns in table 'kursrp_m':
 * @property integer $kursrp_id
 * @property integer $matauang_id
 * @property string $tglkursrp
 * @property double $nilai
 * @property double $rupiah
 * @property boolean $kursrp_aktif
 */
class KursrpM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KursrpM the static model class
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
		return 'kursrp_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglkursrp, nilai, rupiah', 'required'),
			array('matauang_id', 'numerical', 'integerOnly'=>true),
			//array('nilai, rupiah', 'numerical'),
			array('kursrp_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kursrp_id, matauang_id, tglkursrp, nilai, rupiah, kursrp_aktif', 'safe', 'on'=>'search'),
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
                    'matauang'=>array(self::BELONGS_TO,'MatauangM','matauang_id'),
			      
		);
		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kursrp_id' => 'ID Kurs Rp',
			'matauang_id' => 'Mata Uang',
			'tglkursrp' => 'Tanggal Kurs Rp',
			'nilai' => 'Nilai',
			'rupiah' => 'Rupiah',
			'kursrp_aktif' => 'Kurs Rp Aktif',
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

		$criteria->compare('kursrp_id',$this->kursrp_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		//$criteria->compare('matauang',$this->matauang);
		$criteria->compare('LOWER(tglkursrp)',strtolower($this->tglkursrp),true);
		$criteria->compare('nilai',$this->nilai);
		$criteria->compare('rupiah',$this->rupiah);
		$criteria->compare('kursrp_aktif',isset($this->kursrp_aktif)?$this->kursrp_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kursrp_id',$this->kursrp_id);
		$criteria->compare('matauang_id',$this->matauang_id);
//		if(!empty($this->matauang)){
//		   $criteria->addCondition("matauang = ".$this->matauang);
//		}
		$criteria->compare('date(tglkursrp)', MyFormatter::formatDateTimeForDb($this->tglkursrp));
		$criteria->compare('nilai', str_replace('.','',$this->nilai));
		$criteria->compare('rupiah',str_replace('.','',$this->rupiah));
		$criteria->compare('kursrp_aktif',isset($this->kursrp_aktif)?$this->kursrp_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function items()
        {
            $models = self::model()->findAll(
                array(
                    'condition'=>'kursrp_aktif = true',
                    'order'=>'nilai',
                )
            );
            $result = array();
            foreach($models as $model){
                $result[$model->kursrp_id] = $model->nilai;
            }
            return $result;
        }

        public function getMataUangItems()
   		{
   			   return MatauangM::model()->findAll('matauang_aktif=true ORDER BY matauang');
			  
   		}
		
		public function getNilaiRupiah(){
			return $this->nilai.' - '.$this->rupiah;
		}
}