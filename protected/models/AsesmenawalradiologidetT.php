<?php

/**
 * This is the model class for table "asesmenawalradiologidet_t".
 *
 * The followings are the available columns in table 'asesmenawalradiologidet_t':
 * @property integer $asesmenawalradiologidet_id
 * @property integer $asesmenawalradiologi_id
 * @property string $indikatorasesmen
 * @property string $hasilindikator
 *
 * The followings are the available model relations:
 * @property AsesmenawalradiologiT $asesmenawalradiologi
 */
class AsesmenawalradiologidetT extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'asesmenawalradiologidet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmenawalradiologi_id', 'numerical', 'integerOnly'=>true),
            array('indikatorasesmen, hasilindikator', 'length', 'max'=>200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('asesmenawalradiologidet_id, asesmenawalradiologi_id, indikatorasesmen, hasilindikator', 'safe', 'on'=>'search'),
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
            'asesmenawalradiologi' => array(self::BELONGS_TO, 'AsesmenawalradiologiT', 'asesmenawalradiologi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'asesmenawalradiologidet_id' => 'Asesmenawalradiologidet',
            'asesmenawalradiologi_id' => 'Asesmenawalradiologi',
            'indikatorasesmen' => 'Indikatorasesmen',
            'hasilindikator' => 'Hasilindikator',
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

        $criteria->compare('asesmenawalradiologidet_id',$this->asesmenawalradiologidet_id);
        $criteria->compare('asesmenawalradiologi_id',$this->asesmenawalradiologi_id);
        $criteria->compare('indikatorasesmen',$this->indikatorasesmen,true);
        $criteria->compare('hasilindikator',$this->hasilindikator,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AsesmenawalradiologidetT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}