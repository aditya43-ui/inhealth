<?php
/**
 * This is the model class for table "kriteriahasil_daftar_m".
 *
 * The followings are the available columns in table 'kriteriahasil_daftar_m':
 * @property integer $kriteriahasil_daftar_id
 * @property string $kriteriahasil_daftar_nama
 * @property string $kriteriahasil_daftar_namalain
 * @property boolean $kriteriahasil_daftar_aktif
 */
class KriteriahasilDaftarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KriteriahasilDaftarM the static model class
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
		return 'kriteriahasil_daftar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('kriteriahasil_daftar_nama','required'),
			array('kriteriahasil_daftar_nama, kriteriahasil_daftar_namalain, kriteriahasil_daftar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kriteriahasil_daftar_id, kriteriahasil_daftar_nama, kriteriahasil_daftar_namalain, kriteriahasil_daftar_aktif', 'safe', 'on'=>'search'),
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
			'kriteriahasil_daftar_id' => 'ID',
			'kriteriahasil_daftar_nama' => 'Nama Kriteria Hasil',
			'kriteriahasil_daftar_namalain' => 'Nama Lain Kriteria Hasil',
			'kriteriahasil_daftar_aktif' => 'Aktif',
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

		$criteria->compare('kriteriahasil_daftar_id',$this->kriteriahasil_daftar_id);
		$criteria->compare('LOWER(kriteriahasil_daftar_nama)', strtolower($this->kriteriahasil_daftar_nama),true);
		$criteria->compare('LOWER(kriteriahasil_daftar_namalain)', strtolower($this->kriteriahasil_daftar_namalain),true);
		$criteria->compare('kriteriahasil_daftar_aktif',isset($this->kriteriahasil_daftar_aktif)?$this->kriteriahasil_daftar_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kriteriahasil_daftar_id',$this->kriteriahasil_daftar_id);
		$criteria->compare('LOWER(kriteriahasil_daftar_nama)', strtolower($this->kriteriahasil_daftar_nama),true);
		$criteria->compare('LOWER(kriteriahasil_daftar_namalain)', strtolower($this->kriteriahasil_daftar_namalain),true);
		$criteria->compare('kriteriahasil_daftar_aktif',isset($this->kriteriahasil_daftar_aktif)?$this->kriteriahasil_daftar_aktif:true);

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false    
		));
	}
        
        public function searchDialog(){
            $criteria=new CDbCriteria;
            
            $criteria->compare('LOWER(kriteriahasil_daftar_nama)', strtolower($this->kriteriahasil_daftar_nama),true);
            $criteria->compare('LOWER(kriteriahasil_daftar_namalain)', strtolower($this->kriteriahasil_daftar_namalain),true);
            $criteria->addCondition(" kriteriahasil_daftar_aktif = TRUE ");
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,                   
            ));
        }
}