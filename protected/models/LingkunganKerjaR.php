 <?php

/**
 * This is the model class for table "lingkungankerja_r".
 *
 * The followings are the available columns in table 'lingkungankerja_r':
 * @property integer $lingkungankerja_id
 * @property integer $pelamar_id
 * @property string $nourut
 * @property string $dgnlingkungan
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PelamarT $pelamar
 */
class LingkunganKerjaR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LingkunganKerjaR the static model class
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
        return 'lingkungankerja_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pelamar_id, nourut, dgnlingkungan', 'required'),
            array('pelamar_id', 'numerical', 'integerOnly'=>true),
            array('nourut', 'length', 'max'=>3),
            array('dgnlingkungan', 'length', 'max'=>50),
            array('keterangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('lingkungankerja_id, pelamar_id, nourut, dgnlingkungan, keterangan', 'safe', 'on'=>'search'),
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
            'lingkungankerja_id' => 'Lingkungankerja',
            'pelamar_id' => 'Pelamar',
            'nourut' => 'Nourut',
            'dgnlingkungan' => 'Dgnlingkungan',
            'keterangan' => 'Keterangan',
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

        $criteria->compare('lingkungankerja_id',$this->lingkungankerja_id);
        $criteria->compare('pelamar_id',$this->pelamar_id);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(dgnlingkungan)',strtolower($this->dgnlingkungan),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('lingkungankerja_id',$this->lingkungankerja_id);
        $criteria->compare('pelamar_id',$this->pelamar_id);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('LOWER(dgnlingkungan)',strtolower($this->dgnlingkungan),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
} 
?>
