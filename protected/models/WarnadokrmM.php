<?php

/**
 * This is the model class for table "warnadokrm_m".
 *
 * The followings are the available columns in table 'warnadokrm_m':
 * @property integer $warnadokrm_id
 * @property string $warnadokrm_namawarna
 * @property string $warnadokrm_kodewarna
 * @property string $warnadokrm_fungsi
 * @property boolean $warnadokrm_aktif
 */
class WarnadokrmM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WarnadokrmM the static model class
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
		return 'warnadokrm_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warnadokrm_namawarna, warnadokrm_fungsi', 'required'),
			array('warnadokrm_namawarna, warnadokrm_kodewarna', 'length', 'max'=>20),
			array('warnadokrm_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('warnadokrm_id, warnadokrm_namawarna, warnadokrm_kodewarna, warnadokrm_fungsi, warnadokrm_aktif', 'safe', 'on'=>'search'),
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
			'warnadokrm_id' => 'Warna Dokumen',
			'warnadokrm_namawarna' => 'Nama Warna',
			'warnadokrm_kodewarna' => 'Kode Warna',
			'warnadokrm_fungsi' => 'Fungsi',
			'warnadokrm_aktif' => 'Aktif',
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

		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('LOWER(warnadokrm_kodewarna)',strtolower($this->warnadokrm_kodewarna),true);
		$criteria->compare('LOWER(warnadokrm_fungsi)',strtolower($this->warnadokrm_fungsi),true);
		$criteria->compare('warnadokrm_aktif',isset($this->warnadokrm_aktif)?$this->warnadokrm_aktif:true);                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('LOWER(warnadokrm_kodewarna)',strtolower($this->warnadokrm_kodewarna),true);
		$criteria->compare('LOWER(warnadokrm_fungsi)',strtolower($this->warnadokrm_fungsi),true);
		$criteria->compare('warnadokrm_aktif',isset($this->warnadokrm_aktif)?$this->warnadokrm_aktif:true);                
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getKodeWarna(){
            $model = $this->findAllByAttributes(array('warnadokrm_aktif'=>true),array('order'=>'warnadokrm_namawarna ASC'));
            $data = array();
            foreach($model as $row){
                $data[] = $row->warnadokrm_kodewarna;
            }
            return $data;
        }
        
        public function getKodeWarnaId($id){
            $model = $this->findByPK($id);
            
            if (isset($model)){
                return $model->warnadokrm_kodewarna;
            }else{
                return '';
            }
            
        }
}