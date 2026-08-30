 <?php

/**
 * This is the model class for table "racikandetail_m".
 *
 * The followings are the available columns in table 'racikandetail_m':
 * @property integer $racikandetail_id
 * @property integer $racikan_id
 * @property integer $qtymin
 * @property integer $qtymaks
 * @property double $tarifservice
 *
 * The followings are the available model relations:
 * @property RacikanM $racikan
 */
class RacikandetailM extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RacikandetailM the static model class
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
        return 'racikandetail_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('racikan_id, qtymin, qtymaks, tarifservice', 'required'),
            array('racikan_id, qtymin, qtymaks', 'numerical', 'integerOnly'=>true),
            array('tarifservice', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('racikandetail_id, racikan_id, qtymin, qtymaks, tarifservice', 'safe', 'on'=>'search'),
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
            'racikan' => array(self::BELONGS_TO, 'RacikanM', 'racikan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'racikandetail_id' => 'Racikandetail',
            'racikan_id' => 'Racikan',
            'qtymin' => 'Qtymin',
            'qtymaks' => 'Qtymaks',
            'tarifservice' => 'Tarifservice',
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

        $criteria->compare('racikandetail_id',$this->racikandetail_id);
        $criteria->compare('racikan_id',$this->racikan_id);
        $criteria->compare('qtymin',$this->qtymin);
        $criteria->compare('qtymaks',$this->qtymaks);
        $criteria->compare('tarifservice',$this->tarifservice);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('racikandetail_id',$this->racikandetail_id);
        $criteria->compare('racikan_id',$this->racikan_id);
        $criteria->compare('qtymin',$this->qtymin);
        $criteria->compare('qtymaks',$this->qtymaks);
        $criteria->compare('tarifservice',$this->tarifservice);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
} 
?>
