<?php

/**
 * This is the model class for table "kelkumurhasillab_m".
 *
 * The followings are the available columns in table 'kelkumurhasillab_m':
 * @property integer $kelkumurhasillab_id
 * @property string $kelkumurhasillabnama
 * @property integer $umurminlab
 * @property integer $umurmakslab
 * @property string $satuankelumur
 * @property boolean $kelkumurhasillab_aktif
 */
class KelkumurhasillabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelkumurhasillabM the static model class
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
		return 'kelkumurhasillab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelkumurhasillabnama, umurminlab, umurmakslab, satuankelumur, hariminlab, harimakslab', 'required'),
			array('umurminlab, umurmakslab, kelkumurhasillab_urutan', 'numerical', 'integerOnly'=>true),
			array('kelkumurhasillabnama', 'length', 'max'=>50),
			array('satuankelumur', 'length', 'max'=>20),
			array('kelkumurhasillab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelkumurhasillab_id, kelkumurhasillabnama, umurminlab, umurmakslab, satuankelumur, kelkumurhasillab_aktif, kelkumurhasillab_urutan', 'safe', 'on'=>'search'),
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
			'kelkumurhasillab_id' => 'ID',
			'kelkumurhasillabnama' => 'Kelompok Umur Hasil Laboratorium',
			'umurminlab' => 'Umur Minimal Laboratorium',
			'umurmakslab' => 'Umur Maksimal Laboratorium',
			'satuankelumur' => 'Satuan Kelompok Umur',
			'kelkumurhasillab_aktif' => 'Kelompok Umur Hasil Laboratorium Aktif',
			'kelkumurhasillab_urutan' => 'Urutan',
			'hariminlab' => 'Hari Minimal Laboratorium',
			'harimakslab' => 'Hari Maksimal Laboratorium',
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

		if(!empty($this->kelkumurhasillab_id)){
			$criteria->addCondition('kelkumurhasillab_id = '.$this->kelkumurhasillab_id);
		}
		$criteria->compare('LOWER(kelkumurhasillabnama)',strtolower($this->kelkumurhasillabnama),true);
		if(!empty($this->umurminlab)){
			$criteria->addCondition('umurminlab = '.$this->umurminlab);
		}
		if(!empty($this->umurmakslab)){
			$criteria->addCondition('umurmakslab = '.$this->umurmakslab);
		}
		$criteria->compare('kelkumurhasillab_urutan',$this->kelkumurhasillab_urutan);
		$criteria->compare('LOWER(satuankelumur)',strtolower($this->satuankelumur),true);
		$criteria->compare('kelkumurhasillab_aktif',isset($this->kelkumurhasillab_aktif)?$this->kelkumurhasillab_aktif:true);
		//$criteria->order = 'kelkumurhasillab_urutan ASC';

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
		
}