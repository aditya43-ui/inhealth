<?php

/**
 * This is the model class for table "formulariumobat_m".
 *
 * The followings are the available columns in table 'formulariumobat_m':
 * @property integer $carabayar_id
 * @property integer $obatalkes_id
 */
class FormulariumobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormulariumobatM the static model class
	 */
	public $carabayar_nama, $penjamin_nama, $obatalkes_nama;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'formulariumobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id', 'required'),
			array('formulariumobat_id, obatalkes_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('jenisformularium', 'length', 'max'=>100),
			array('is_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formulariumobat_id, obatalkes_id, carabayar_id, penjamin_id, jenisformularium, is_aktif', 'safe', 'on'=>'search'),

			array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
			'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM','penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkes_id' => 'Nama Obat dan Alkes',
			'jenisformularium' => 'Jenis Formularium',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'is_aktif' => 'Aktif',
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
		
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(jenisformularium)',strtolower($this->jenisformularium),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
        $criteria->compare('is_aktif', isset($this->is_aktif) ? $this->is_aktif : true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function criteriaSearch()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(jenisformularium)',strtolower($this->jenisformularium),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
        $criteria->compare('is_aktif', isset($this->is_aktif) ? $this->is_aktif : true);
		$criteria->order = 'carabayar_id, obatalkes_id';

		return $criteria;
	}
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function getJeniskasuspenyakitItems()
	{
		return JeniskasuspenyakitM::model()->findAll();
	}
	
	public function getObatalkesItems()
	{
		return ObatalkesM::model()->findAll();
	}
}