<?php

/**
 * This is the model class for table "setorbank_t".
 *
 * The followings are the available columns in table 'setorbank_t':
 * @property integer $setorbank_id
 * @property string $nostruksetor
 * @property string $tgldisetor
 * @property string $namabank
 * @property string $atasnama
 * @property string $norekening
 * @property double $jumlahsetoran
 * @property integer $ygmenyetor_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class SetorbankT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SetorbankT the static model class
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
		return 'setorbank_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nostruksetor, tgldisetor, namabank, atasnama, norekening, jumlahsetoran, ygmenyetor_id, create_time, create_loginpemakai_id', 'required'),
			array('ygmenyetor_id', 'numerical', 'integerOnly'=>true),
			array('jumlahsetoran', 'numerical'),
			array('nostruksetor, namabank, atasnama, norekening', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setorbank_id, nostruksetor, tgldisetor, namabank, atasnama, norekening, jumlahsetoran, ygmenyetor_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'setorbank_id' => 'Setor Bank',
			'nostruksetor' => 'No. Struk Setor',
			'tgldisetor' => 'Tanggal Disetor',
			'namabank' => 'Nama Bank',
			'atasnama' => 'Atas Nama',
			'norekening' => 'No. Rekening',
			'jumlahsetoran' => 'Jumlah Setoran',
			'ygmenyetor_id' => 'Yg menyetor',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('LOWER(nostruksetor)',strtolower($this->nostruksetor),true);
		$criteria->compare('LOWER(tgldisetor)',strtolower($this->tgldisetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(atasnama)',strtolower($this->atasnama),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('jumlahsetoran',$this->jumlahsetoran);
		$criteria->compare('ygmenyetor_id',$this->ygmenyetor_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('LOWER(nostruksetor)',strtolower($this->nostruksetor),true);
		$criteria->compare('LOWER(tgldisetor)',strtolower($this->tgldisetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(atasnama)',strtolower($this->atasnama),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('jumlahsetoran',$this->jumlahsetoran);
		$criteria->compare('ygmenyetor_id',$this->ygmenyetor_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}