<?php

/**
 * This is the model class for table "uraianpenumum_t".
 *
 * The followings are the available columns in table 'uraianpenumum_t':
 * @property integer $uploadfile_id
 * @property integer $edukasipkrs_id
 * @property string $namafile
 * @property double $filepath
 */
class UploadedukasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UploadedukasiT the static model class
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
		return 'uploadedukasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('edukasipkrs_id, namafile, filepath', 'required'),
			array('edukasipkrs_id', 'numerical', 'integerOnly'=>true),
			array('namafile, filepath', 'length', 'max'=>200),
			array('upload_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uploadfile_id, edukasipkrs_id, namafile, filepath, upload_time', 'safe', 'on'=>'search'),
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
			'edukasipkrs'=>array(self::BELONGS_TO, 'EdukasipkrsT', 'edukasipkrs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uploadfile_id' => 'Upload ID',
			'edukasipkrs_id' => 'Edukasi ID',
			'namafile' => 'Nama File',
			'filepath' => 'File Path',
			'upload_time' => 'Upload Time',
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

		$criteria->compare('uploadfile_id',$this->uploadfile_id);
		$criteria->compare('edukasipkrs_id',$this->edukasipkrs_id);
		$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
		$criteria->compare('filepath',$this->filepath);
		$criteria->compare('upload_time',$this->upload_time, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('uploadfile_id',$this->uploadfile_id);
			$criteria->compare('edukasipkrs_id',$this->edukasipkrs_id);
			$criteria->compare('LOWER(namafile)',strtolower($this->namafile),true);
			$criteria->compare('filepath',$this->filepath);
			$criteria->compare('upload_time',$this->upload_time, true);

			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
        }
}