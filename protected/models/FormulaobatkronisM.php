<?php

/**
 * This is the model class for table "formulaobatkronis_m".
 *
 * The followings are the available columns in table 'formulaobatkronis_m':
 * @property integer $formulaobatkronis_id
 * @property integer $jumlahobat
 * @property integer $jumlahobat_minimal
 * @property integer $jumlahobat_maksimal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $is_aktif
 */
class FormulaobatkronisM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FormulaobatkronisM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'formulaobatkronis_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, create_loginpemakai_id, create_ruangan, jumlahobat', 'required'),
            array('create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('jumlahobat, jumlahobat_minimal, jumlahobat_maksimal', 'numerical'),
            array('is_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('formulaobatkronis_id, jumlahobat, jumlahobat_minimal, jumlahobat_maksimal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, is_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'formulaobatkronis_id' => 'Formula Obat Kronis',
            'jumlahobat' => 'Jumlah Obat',
            'jumlahobat_minimal' => "Jumlah Obat Minimal(Ina-CBG's)",
            'jumlahobat_maksimal' => 'Jumlah Obat Maksimal(fee for service',
            'is_aktif' => 'Aktif',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        // $criteria->compare('formulaobatkronis_id', $this->formulaobatkronis_id);
        if(!empty($this->formulaobatkronis_id)){
			$criteria->addCondition('formulaobatkronis_id = '.$this->formulaobatkronis_id);
		}
        $criteria->compare('jumlahobat', $this->jumlahobat);
        $criteria->compare('jumlahobat_minimal', $this->jumlahobat_minimal);
        $criteria->compare('jumlahobat_maksimal', $this->jumlahobat_maksimal);
        $criteria->compare('is_aktif', $this->is_aktif);
        if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
        
        return $criteria;
    }

    public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            // $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

    public static function getDropdown() {
        $query = self::model()->findAll(['condition' => 'is_aktif = true']);
        $data = [];

        foreach ($query as $value) {
            $key = $value['formulaobatkronis_id'];
            $data[$key] = $value['jumlahobat_minimal'] . ' / ' . $value['jumlahobat_maksimal'];
        }

        return $data;
    }

    public function getJumlahMinMax(){
        return $this->jumlahobat_minimal . ' / '. $this->jumlahobat_maksimal;
    }
}
