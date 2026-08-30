<?php

/**
 * This is the model class for table "postingfiledet_s".
 *
 * The followings are the available columns in table 'postingfiledet_s':
 * @property integer $postingfiledet_id
 * @property integer $postingfile_id
 * @property string $namafile
 * @property string $deskripsifile
 * @property string $imagefile
 */
class PostingfiledetS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostingfiledetS the static model class
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
		return 'postingfiledet_s';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('postingfile_id', 'required'),
			array('postingfile_id', 'numerical', 'integerOnly'=>true),
			array('namafile', 'length', 'max'=>200),
			array('deskripsifile, imagefile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('postingfiledet_id, postingfile_id, namafile, deskripsifile, imagefile', 'safe', 'on'=>'search'),
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
			'postingfiledet_id' => 'Postingfiledet',
			'postingfile_id' => 'Postingfile',
			'namafile' => 'Namafile',
			'deskripsifile' => 'Deskripsifile',
			'imagefile' => 'Imagefile',
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

		$criteria->compare('postingfiledet_id',$this->postingfiledet_id);
		$criteria->compare('postingfile_id',$this->postingfile_id);
		$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
		$criteria->compare('LOWER(deskripsifile)',strtolower($this->deskripsifile),true);
		$criteria->compare('LOWER(imagefile)',strtolower($this->imagefile),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('postingfiledet_id',$this->postingfiledet_id);
		$criteria->compare('postingfile_id',$this->postingfile_id);
		$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
		$criteria->compare('LOWER(deskripsifile)',strtolower($this->deskripsifile),true);
		$criteria->compare('LOWER(imagefile)',strtolower($this->imagefile),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}