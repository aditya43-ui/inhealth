<?php

/**
 * This is the model class for table "sumberdana_m".
 *
 * The followings are the available columns in table 'sumberdana_m':
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property string $sumberdana_namalainnya
 * @property boolean $sumberdana_aktif
 */
class SumberdanaM extends CActiveRecord
{
        public $rekening_debit, $rekening_kredit, $rekDebit, $rekKredit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumberdanaM the static model class
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
		return 'sumberdana_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberdana_nama', 'required'),
			array('sumberdana_nama, sumberdana_namalainnya', 'length', 'max'=>50),
			array('sumberdana_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sumberdana_id, sumberdana_nama, sumberdana_namalainnya, sumberdana_aktif', 'safe', 'on'=>'search'),
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
			'sumberdanarek'=>array(self::HAS_MANY, 'SumberdanarekM','sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sumberdana_id' => 'ID',
			'sumberdana_nama' => 'Nama',
			'sumberdana_namalainnya' => 'Nama Lainnya',
			'sumberdana_aktif' => 'Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(sumberdana_namalainnya)',strtolower($this->sumberdana_namalainnya),true);
		$criteria->compare('sumberdana_aktif',isset($this->sumberdana_aktif)?$this->sumberdana_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchSumberdana()
    {
    	$criteria=new CDbCriteria;

		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(sumberdana_namalainnya)',strtolower($this->sumberdana_namalainnya),true);
		$criteria->compare('sumberdana_aktif',$this->sumberdana_aktif);
		$criteria->addCondition("sumberdana_id not in(select sumberdana_id from sumberdanarek_m)");

        $criteria->order='sumberdana_nama'; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
    } 
    
    public function searchSumberdanaPrint()
    {
    	$criteria=new CDbCriteria;

		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(sumberdana_namalainnya)',strtolower($this->sumberdana_namalainnya),true);
		$criteria->compare('sumberdana_aktif',$this->sumberdana_aktif);
		$criteria->addCondition("sumberdana_id not in(select sumberdana_id from sumberdanarek_m)");

        $criteria->order='sumberdana_nama'; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
    } 

        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(sumberdana_namalainnya)',strtolower($this->sumberdana_namalainnya),true);
		$criteria->compare('sumberdana_aktif',isset($this->sumberdana_aktif)?$this->sumberdana_aktif:true);
                $criteria->order='sumberdana_nama';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
          public function beforeSave() {
            $this->sumberdana_namalainnya = strtoupper($this->sumberdana_namalainnya);
            $this->sumberdana_nama = ucwords(strtolower($this->sumberdana_nama));
            return parent::beforeSave();
        }

    public function getSumberdanaItems()
    {
        return SumberdanaM::model()->findAll("sumberdana_aktif=TRUE ORDER BY sumberdana_nama");
    }

    public function getSumberdanaRek()
    {
    	$attributes = array("sumberdana_id"=>$this->sumberdana_id);
    	$result = SumberdanarekM::model()->findAllByAttributes($attributes);
    	$data = "";
    	foreach ($result as $value)
    	{
    		$rec = Rekening5M::model()->findBypk($value['rekening5_id']);
    		$data .= "<li>" . $rec->nmrekening5 ." (". $rec->rekening5_nb .")</li>";
    	}
    	return $data;
				
    }
	
	public function searchDialog()
    {
    	$criteria=new CDbCriteria;

		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);				
		$criteria->addCondition(" sumberdana_aktif = TRUE ");
        $criteria->order='sumberdana_nama ASC'; 
		$criteria->limit = 10;
			
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,			
		));
    } 
}