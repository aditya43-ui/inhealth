<?php

/**
 * This is the model class for table "draftasesmentriase_t".
 *
 * The followings are the available columns in table 'draftasesmentriase_t':
 * @property integer $draftasesmentriase_id
 * @property string $namapasien
 * @property integer $asesmentriase_id
 *
 * The followings are the available model relations:
 * @property AsesmentriaseT $asesmentriase
 */
class DraftasesmentriaseT extends CActiveRecord
{
        public $default;
        public $tglasesmentriase;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'draftasesmentriase_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmentriase_id, namapasien', 'required'),
			array('asesmentriase_id', 'numerical', 'integerOnly'=>true),
			array('namapasien', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('draftasesmentriase_id, namapasien, asesmentriase_id', 'safe', 'on'=>'search'),
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
			'asesmentriase' => array(self::BELONGS_TO, 'AsesmentriaseT', 'asesmentriase_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'draftasesmentriase_id' => 'Draftasesmentriase',
			'namapasien' => 'Nama Pasien',
			'asesmentriase_id' => 'Asesmentriase',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->compare('draftasesmentriase_id',$this->draftasesmentriase_id);
                $criteria->compare('namapasien',$this->namapasien,true);
                $criteria->compare('asesmentriase_id',$this->asesmentriase_id);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DraftasesmentriaseT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * 
         * @param type $model
         * @param type $post
         * @return type
         */
        public static function simpanData($model, $post){
            
            $format = new MyFormatter();
            $ok  = true;
            $pesan = '';
            
            $model->attributes = $post;
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'draft asesmen triase '.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'sukses' => $ok,
                'model' => $model,
                'pesan' => $pesan
            ];
        }
        
        public function searchDaftarTriase()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = " t.*, at.tglasesmentriase ";
                $criteria->join = " JOIN asesmentriase_t at ON at.asesmentriase_id = t.asesmentriase_id AND at.pendaftaran_id IS NULL ";
                if (!empty($this->default)){
                    $criteria->addCondition(" draftasesmentriase_id IS NULL ");
                }                               
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
