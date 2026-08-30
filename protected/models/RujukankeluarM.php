<?php

/**
 * This is the model class for table "rujukankeluar_m".
 *
 * The followings are the available columns in table 'rujukankeluar_m':
 * @property integer $rujukankeluar_id
 * @property string $rumahsakitrujukan
 * @property string $alamatrsrujukan
 * @property string $telp_fax
 * @property boolean $rujukankeluar_aktif
 */
class RujukankeluarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RujukankeluarM the static model class
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
		return 'rujukankeluar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rumahsakitrujukan, kodeppk_dirujuk', 'required'),
			array('rumahsakitrujukan, telp_fax', 'length', 'max'=>50),
			array('alamatrsrujukan, rujukankeluar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rujukankeluar_id, rumahsakitrujukan, alamatrsrujukan, telp_fax, rujukankeluar_aktif', 'safe', 'on'=>'search'),
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
			'rujukankeluar_id' => 'ID',
			'rumahsakitrujukan' => 'Asal Rujukan',
			'alamatrsrujukan' => 'Alamat',
			'telp_fax' => 'Telepon Fax',
			'rujukankeluar_aktif' => 'Aktif',
			'kodeppk_dirujuk' => 'Kode PPK Dirujuk',
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

		$criteria->compare('rujukankeluar_id',$this->rujukankeluar_id);
		$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
		$criteria->compare('LOWER(alamatrsrujukan)',strtolower($this->alamatrsrujukan),true);
		$criteria->compare('LOWER(telp_fax)',strtolower($this->telp_fax),true);
		$criteria->compare('rujukankeluar_aktif',isset($this->rujukankeluar_aktif)?$this->rujukankeluar_aktif:true);
                //$criteria->addCondition('rujukankeluar_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rujukankeluar_id',$this->rujukankeluar_id);
		$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
		$criteria->compare('LOWER(alamatrsrujukan)',strtolower($this->alamatrsrujukan),true);
		$criteria->compare('LOWER(telp_fax)',strtolower($this->telp_fax),true);
//		$criteria->compare('rujukankeluar_aktif',$this->rujukankeluar_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}