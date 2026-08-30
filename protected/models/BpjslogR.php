<?php

/**
 * This is the model class for table "bpjslog_r".
 *
 * The followings are the available columns in table 'bpjslog_r':
 * @property integer $bpjslog_id
 * @property integer $code
 * @property string $pesan
 * @property string $tgl_log
 * @property integer $loginpemakai_id
 */
class BpjslogR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BpjslogR the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bpjslog_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('pesan, tgl_log', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bpjslog_id, code, pesan, tgl_log, loginpemakai_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bpjslog_id' => 'Bpjslog',
            'code' => 'Code',
            'pesan' => 'Pesan',
            'tgl_log' => 'Tgl. Log',
            'loginpemakai_id' => 'Loginpemakai',
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

        $criteria = new CDbCriteria;

        $criteria->compare('bpjslog_id', $this->bpjslog_id);
        $criteria->compare('code', $this->code);
        $criteria->compare('pesan', $this->pesan, true);
        $criteria->compare('tgl_log', $this->tgl_log, true);
        $criteria->compare('loginpemakai_id', $this->loginpemakai_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
