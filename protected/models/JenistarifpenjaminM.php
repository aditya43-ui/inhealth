<?php

/**
 * This is the model class for table "jenistarifpenjamin_m".
 *
 * The followings are the available columns in table 'jenistarifpenjamin_m':
 * @property integer $jenistarif_id
 * @property integer $penjamin_id
 *
 * The followings are the available model relations:
 * @property JenistarifM $jenistarif
 * @property PenjaminpasienM $penjamin
 */
class JenistarifpenjaminM extends CActiveRecord
{
    public $jenistarif_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistarifpenjaminM the static model class
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
		return 'jenistarifpenjamin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistarif_id, penjamin_id', 'required'),
			array('jenistarif_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenistarif_id, penjamin_id', 'safe', 'on'=>'search'),
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
			'jenistarif' => array(self::BELONGS_TO, 'JenistarifM', 'jenistarif_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenistarif_id' => 'Jenistarif',
			'penjamin_id' => 'Penjamin',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);

		return $criteria;
	}
        
        
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }


    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    
     public function getDataCaraBayarItems($jenistarif_id)
    {
         $criteria = new CDbCriteria();         
         $criteria->join =  ' JOIN penjaminpasien_m p ON p.carabayar_id = t.carabayar_id '
                        .   ' JOIN jenistarifpenjamin_m j ON j.penjamin_id = p.penjamin_id ';
         $criteria->addCondition('j.jenistarif_id = '.$jenistarif_id);
         $criteria->order = 't.carabayar_nama';
                  
         return CarabayarM::model()->findAll($criteria);
         
         
    }
}