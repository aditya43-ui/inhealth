<?php

/**
 * This is the model class for table "kelasruangan_m".
 *
 * The followings are the available columns in table 'kelasruangan_m':
 * @property integer $ruangan_id
 * @property integer $kelaspelayanan_id
 */
class KelasruanganM extends CActiveRecord
{
        public $ruangan_nama,$kelaspelayanan_nama,$kelaspelayanan_namalainnya;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelasruanganM the static model class
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
		return 'kelasruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, kelaspelayanan_id', 'required'),
                        array('ruangan_id, kelaspelayanan_id', 'cekdata'),
			array('ruangan_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, kelaspelayanan_id, ruangan_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya', 'safe', 'on'=>'search'),
		);
	}
        
                public function cekdata($attribute, $params)
                {
                    $querydata = KelasruanganM::model()->findAllByAttributes(array('ruangan_id'=>$this->ruangan_id,'kelaspelayanan_id'=>$this->kelaspelayanan_id));
                    if (!$this->hasErrors()){
                        if (count((array)$querydata) > 0)
                        {
                            $this->addError('ruangan_id, kelaspelayanan_id',' Kelas '.$this->kelaspelayanan->kelaspelayanan_nama.' untuk poli '.$this->ruangan->ruangan_nama.' telah tersedia di database');
                            return false;
                        }
                    }
                }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                                    'kelaspelayanan'=>array(self::BELONGS_TO,'KelaspelayananM','kelaspelayanan_id'),
                                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
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
                //$criteria->with('kelaspelayanan');
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                                $sessionruangan = Yii::app()->user->ruangan_id;

		
		$criteria=new CDbCriteria;
                $criteria->with=array('ruangan','kelaspelayanan');
//                                $criteria->distinct = true;
//                                $criteria->select = array('ruangan_id','kelaspelayanan_id');
                               // $criteria->order = 'ruangan.ruangan_nama,kelaspelayanan.kelaspelayanan_nama';
                if (Yii::app()->controller->module->id =='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id',Params::RUANGAN_ID_RAD);
                }else{
                        $criteria->compare('t.ruangan_id',$sessionruangan);
                }          
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan.kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                        'sort' => array(
                            'attributes' => array(
                                'kelaspelayanan_nama' => array(
                                    'asc' => 'kelaspelayanan.kelaspelayanan_nama ASC',
                                    'desc' => 'kelaspelayanan.kelaspelayanan_nama DESC',
                                ),
                                '*',
                            )
                        )
		));
	}
        
          public function getRuanganItems()
                {
                    return RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama");
                }
                
           public function getKelasPelayananItems()
                {
                    return KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDERBY kelaspelayanan_nama");
                }      
                
//                public function primaryKey() {
//                    return 'ruangan_id';
//                }
}