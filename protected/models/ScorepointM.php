<?php

/**
 * This is the model class for table "scorepoint_m".
 *
 * The followings are the available columns in table 'scorepoint_m':
 * @property integer $scorepoint_id
 * @property integer $apachescore_id
 * @property string $point_nama
 * @property double $point_minimal
 * @property double $point_maksimal
 * @property string $point_sign
 * @property double $point_score
 * @property string $point_desc
 */
class ScorepointM extends CActiveRecord
{
        public $max_point;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScorepointM the static model class
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
        return 'scorepoint_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('apachescore_id, point_nama, point_score', 'required'),
            array('apachescore_id', 'numerical', 'integerOnly'=>true),
            array('point_minimal, point_maksimal, point_score', 'numerical'),
            array('point_nama, point_desc', 'length', 'max'=>100),
            array('point_sign', 'length', 'max'=>2),
            array('point_arf', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('scorepoint_id, apachescore_id, point_nama, point_minimal, point_maksimal, point_sign, point_score, point_desc, point_arf', 'safe', 'on'=>'search'),
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
            'scorepoint_id' => 'Scorepoint',
            'apachescore_id' => 'Apachescore',
            'point_nama' => 'Point Nama',
            'point_minimal' => 'Point Minimal',
            'point_maksimal' => 'Point Maksimal',
            'point_sign' => 'Point Sign',
            'point_score' => 'Point Score',
            'point_desc' => 'Point Desc',
            'point_arf' => 'Point Arf',
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

        $criteria->compare('scorepoint_id',$this->scorepoint_id);
        $criteria->compare('apachescore_id',$this->apachescore_id);
        $criteria->compare('LOWER(point_nama)',strtolower($this->point_nama),true);
        $criteria->compare('point_minimal',$this->point_minimal);
        $criteria->compare('point_maksimal',$this->point_maksimal);
        $criteria->compare('LOWER(point_sign)',strtolower($this->point_sign),true);
        $criteria->compare('point_score',$this->point_score);
        $criteria->compare('LOWER(point_desc)',strtolower($this->point_desc),true);
        $criteria->compare('point_arf',$this->point_arf);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('scorepoint_id',$this->scorepoint_id);
        $criteria->compare('apachescore_id',$this->apachescore_id);
        $criteria->compare('LOWER(point_nama)',strtolower($this->point_nama),true);
        $criteria->compare('point_minimal',$this->point_minimal);
        $criteria->compare('point_maksimal',$this->point_maksimal);
        $criteria->compare('LOWER(point_sign)',strtolower($this->point_sign),true);
        $criteria->compare('point_score',$this->point_score);
        $criteria->compare('LOWER(point_desc)',strtolower($this->point_desc),true);
        $criteria->compare('point_arf',$this->point_arf);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}