<?php

/**
 * This is the model class for table "jenistransfusi_m".
 *
 * The followings are the available columns in table 'jenistransfusi_m':
 * @property integer $jenistransfusi_id
 * @property string $jenistransfusi_nama
 * @property string $jenistransfusi_namalain
 * @property string $jenistransfusi_desc
 */
class JenistransfusiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistransfusiM the static model class
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
		return 'jenistransfusi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistransfusi_nama, jenistransfusi_namalain, jenistransfusi_desc', 'required'),
			array('jenistransfusi_nama, jenistransfusi_namalain', 'length', 'max'=>50),
			array('jenistransfusi_desc', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenistransfusi_id, jenistransfusi_nama, jenistransfusi_namalain, jenistransfusi_desc', 'safe', 'on'=>'search'),
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
			'jenistransfusi_id' => 'Jenis Transfusi',
			'jenistransfusi_nama' => 'Nama Jenis Transfusi',
			'jenistransfusi_namalain' => 'Nama Lain Jenis Transfusi',
			'jenistransfusi_desc' => 'Deskripsi Jenis Transfusi',
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

		$criteria->compare('jenistransfusi_id',$this->jenistransfusi_id);
		$criteria->compare('jenistransfusi_nama',$this->jenistransfusi_nama,true);
		$criteria->compare('jenistransfusi_namalain',$this->jenistransfusi_namalain,true);
		$criteria->compare('jenistransfusi_desc',$this->jenistransfusi_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getJenisTransfusi()
	{
		$data = array();
		$models = JenistransfusiM::model()->findAll();
		if(count((array)$models) > 0){
			foreach($models as $model)
				$data[$model->jenistransfusi_id] = strtoupper($model->jenistransfusi_nama).'&nbsp; &nbsp;';
		}else{
			$data[""] = null;
		}

		return $data;
	}
}