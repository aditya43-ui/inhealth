<?php

/**
 * This is the model class for table "bed_triage_m".
 *
 * The followings are the available columns in table 'bed_triage_m':
 * @property integer $bed_triage_id
 * @property string $no_bed
 * @property string $keterangan
 * @property boolean $is_aktif
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property NotriagePasienT[] $notriagePasienTs
 */

class BedTriageM extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bed_triage_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('no_bed, create_time, create_loginpemakai_id', 'required'),
            array('create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('no_bed', 'length', 'max' => 10),
            array('keterangan, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('bed_triage_id, no_bed, keterangan, is_aktif, create_time, create_loginpemakai_id, update_time, update_loginpemakai_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'notriagePasienTs' => array(self::HAS_MANY, 'NotriagePasienT', 'bed_triage_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bed_triage_id' => 'Bed Triage',
            'no_bed' => 'No Bed',
            'keterangan' => 'Keterangan',
            'is_aktif' => 'Is Aktif',
            'create_time' => 'Create Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_time' => 'Update Time',
            'update_loginpemakai_id' => 'Update Loginpemakai',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('bed_triage_id', $this->bed_triage_id);
        $criteria->compare('no_bed', $this->no_bed, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('is_aktif', $this->is_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchBedTriage() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('bed_triage_id', $this->bed_triage_id);
        $criteria->compare('keterangan', $this->keterangan, true);

//        if (!empty($this->is_aktif)) {
//
//            $aktif = $this->is_aktif == 1 ? "true" : "false";
//
//            $criteria->addCondition('is_aktif = ' . $aktif);
//        }

        if (!empty($this->no_bed)) {

            $criteria->addSearchCondition('no_bed', $this->no_bed, true, 'ILIKE');
        }

        $criteria->compare('is_aktif', $this->is_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getBedTriageInUse()
    {
        $masukkamar = NotriagePasienT::model()->find("no_bed_triage = '".$this->no_bed."' and create_time::date = current_date ORDER BY create_time DESC");
           
            
        if(!empty($masukkamar)){
            return $this->no_bed. ' - ' . $this->keterangan_use ?? '';	
        }else{
            return $this->no_bed.' - ' . 'TERSEDIA';		
        }
        
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BedTriageM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
