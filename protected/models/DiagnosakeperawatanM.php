<?php

/**
 * This is the model class for table "diagnosakeperawatan_m".
 *
 * The followings are the available columns in table 'diagnosakeperawatan_m':
 * @property integer $diagnosakeperawatan_id
 * @property integer $diagnosa_id
 * @property string $diagnosakeperawatan_kode
 * @property string $diagnosa_medis
 * @property string $diagnosa_keperawatan
 * @property string $diagnosa_tujuan
 * @property boolean $diagnosa_keperawatan_aktif
 */
class DiagnosakeperawatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosakeperawatanM the static model class
	 */
         public $diagnosa_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'diagnosakeperawatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
                        // NOTE: you should only define rules for those attributes that
                        // will receive user inputs.
                        return array(
                                array('diagnosa_id','required'),
                                array('diagnosa_id', 'numerical', 'integerOnly'=>true),
                                array('diagnosakeperawatan_kode', 'length', 'max'=>10),
                                array('diagnosa_medis, diagnosa_keperawatan, diagnosa_nama, diagnosa_tujuan, diagnosa_keperawatan_aktif', 'safe'),
                                // The following rule is used by search().
                                // Please remove those attributes that should not be searched.
                                array('diagnosakeperawatan_id, diagnosa_id, diagnosa_nama, diagnosakeperawatan_kode, diagnosa_medis, diagnosa_keperawatan, diagnosa_tujuan, diagnosa_keperawatan_aktif', 'safe', 'on'=>'search'),
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
                                'diagnosa'=>array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),                    
                                //'kriteriahasil'=>array(self::HAS_MANY, 'KriteriahasilM', 'kriteriahasil_id'),
                        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
                        return array(

                                'diagnosakeperawatan_id' => 'ID Diagnosa',
                                'diagnosa_id' => 'ID Diagnosa',
                                'diagnosakeperawatan_kode' => 'Kode',
                                'diagnosa_medis' => 'Diagnosa Medis',
                                'diagnosa_keperawatan' => 'Diagnosa Keperawatan',
                                'diagnosa_tujuan' => 'Tujuan',
                                'diagnosa_keperawatan_aktif' => 'Aktif',
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

                        $criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
                        // $criteria->compare('diagnosa_id',$this->diagnosa_id);
                        $criteria->compare('LOWER(diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
                        $criteria->compare('LOWER(diagnosa_medis)',strtolower($this->diagnosa_medis),true);
                        $criteria->compare('LOWER(diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
                        $criteria->compare('LOWER(diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
                        $criteria->compare('diagnosa_keperawatan_aktif',isset($this->diagnosa_keperawatan_aktif)?$this->diagnosa_keperawatan_aktif:true);
                        $criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
        //                $criteria->addCondition('diagnosa_keperawatan_aktif is true');
                        $criteria->with=array('diagnosa');
                        //$criteria->order = 'diagnosakeperawatan_id ASC';

                        return new CActiveDataProvider($this, array(
                                'criteria'=>$criteria,
                                'sort' => array(
                            'attributes' => array(
                                'diagnosa_nama' => array(
                                    'asc' => 'diagnosa.diagnosa_nama ASC',
                                    'desc' => 'diagnosa.diagnosa_nama DESC',
                                    ),
                                    '*',
                            ),
                                    )
                        ));
	}
        
        
                public function searchPrint()
                {
                        // Warning: Please modify the following code to remove attributes that
                        // should not be searched.

                        $criteria=new CDbCriteria;
                        $criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
                        $criteria->compare('diagnosa_id',$this->diagnosa_id);
                        $criteria->compare('LOWER(diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
                        $criteria->compare('LOWER(diagnosa_medis)',strtolower($this->diagnosa_medis),true);
                        $criteria->compare('LOWER(diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
                        $criteria->compare('LOWER(diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
                        $criteria->compare('diagnosa_keperawatan_aktif',isset($this->diagnosa_keperawatan_aktif)?$this->diagnosa_keperawatan_aktif:true);
                        //$criteria->compare('diagnosa_keperawatan_aktif',$this->diagnosa_keperawatan_aktif);
                        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                        $criteria->limit=-1; 

                        return new CActiveDataProvider($this, array(
                                'criteria'=>$criteria,
                                'pagination'=>false,
                        ));
                }
}