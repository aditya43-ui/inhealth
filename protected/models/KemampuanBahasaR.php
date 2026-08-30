 <?php

/**
 * This is the model class for table "kemampuanbahasa_r".
 *
 * The followings are the available columns in table 'kemampuanbahasa_r':
 * @property integer $kemampuanbahasa_id
 * @property integer $pelamar_id
 * @property string $bahasa
 * @property string $mengerti
 * @property string $berbicara
 * @property string $menulis
 *
 * The followings are the available model relations:
 * @property PelamarT $pelamar
 */
class KemampuanBahasaR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KemampuanBahasaR the static model class
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
        return 'kemampuanbahasa_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pelamar_id, bahasa, mengerti, berbicara, menulis', 'required'),
            array('pelamar_id', 'numerical', 'integerOnly'=>true),
            array('bahasa', 'length', 'max'=>100),
            array('mengerti, berbicara, menulis', 'length', 'max'=>20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kemampuanbahasa_id, pelamar_id, bahasa, mengerti, berbicara, menulis', 'safe', 'on'=>'search'),
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
            'pelamar' => array(self::BELONGS_TO, 'PelamarT', 'pelamar_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'kemampuanbahasa_id' => 'Kemampuanbahasa',
            'pelamar_id' => 'Pelamar',
            'bahasa' => 'Bahasa',
            'mengerti' => 'Mengerti',
            'berbicara' => 'Berbicara',
            'menulis' => 'Menulis',
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

        $criteria->compare('kemampuanbahasa_id',$this->kemampuanbahasa_id);
        $criteria->compare('pelamar_id',$this->pelamar_id);
        $criteria->compare('LOWER(bahasa)',strtolower($this->bahasa),true);
        $criteria->compare('LOWER(mengerti)',strtolower($this->mengerti),true);
        $criteria->compare('LOWER(berbicara)',strtolower($this->berbicara),true);
        $criteria->compare('LOWER(menulis)',strtolower($this->menulis),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('kemampuanbahasa_id',$this->kemampuanbahasa_id);
        $criteria->compare('pelamar_id',$this->pelamar_id);
        $criteria->compare('LOWER(bahasa)',strtolower($this->bahasa),true);
        $criteria->compare('LOWER(mengerti)',strtolower($this->mengerti),true);
        $criteria->compare('LOWER(berbicara)',strtolower($this->berbicara),true);
        $criteria->compare('LOWER(menulis)',strtolower($this->menulis),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
} 
?>
