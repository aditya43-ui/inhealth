<?php

/**
 * This is the model class for table "kelompokpegawai_m".
 *
 * The followings are the available columns in table 'kelompokpegawai_m':
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $kelompokpegawai_namalainnya
 * @property string $kelompokpegawai_fungsi
 * @property boolean $kelompokpegawai_aktif
 */
class KelompokpegawaiM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokpegawaiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kelompokpegawai_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kelompokpegawai_nama, kelompokpegawai_aktif', 'required'),
            array('kelompokpegawai_nama, kelompokpegawai_namalainnya', 'length', 'max' => 30),
            array('kelompokpegawai_fungsi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kelompokpegawai_id, kelompokpegawai_nama, kelompokpegawai_namalainnya, kelompokpegawai_fungsi, kelompokpegawai_aktif', 'safe', 'on' => 'search'),
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
            'kelompokpegawai_id' => 'ID',
            'kelompokpegawai_nama' => 'Kelompok Pegawai',
            'kelompokpegawai_namalainnya' => 'Nama Lain',
            'kelompokpegawai_fungsi' => 'Fungsi',
            'kelompokpegawai_aktif' => 'Aktif',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('LOWER(kelompokpegawai_nama)', strtolower($this->kelompokpegawai_nama), true);
        $criteria->compare('LOWER(kelompokpegawai_namalainnya)', strtolower($this->kelompokpegawai_namalainnya), true);
        $criteria->compare('LOWER(kelompokpegawai_fungsi)', strtolower($this->kelompokpegawai_fungsi), true);
        $criteria->compare('kelompokpegawai_aktif', isset($this->kelompokpegawai_aktif) ? $this->kelompokpegawai_aktif : true);
//                $criteria->addCondition('kelompokpegawai_aktif is true');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('LOWER(kelompokpegawai_nama)', strtolower($this->kelompokpegawai_nama), true);
        $criteria->compare('LOWER(kelompokpegawai_namalainnya)', strtolower($this->kelompokpegawai_namalainnya), true);
        $criteria->compare('LOWER(kelompokpegawai_fungsi)', strtolower($this->kelompokpegawai_fungsi), true);
        $criteria->compare('kelompokpegawai_aktif', isset($this->kelompokpegawai_aktif) ? $this->kelompokpegawai_aktif : true);

//        	$criteria->compare('kelompokpegawai_aktif',$this->kelompokpegawai_aktif);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function beforeSave() {
        $this->kelompokpegawai_nama = ucwords(strtolower($this->kelompokpegawai_nama));
        $this->kelompokpegawai_namalainnya = strtoupper($this->kelompokpegawai_namalainnya);
        return parent::beforeSave();
    }
	
	public function getNonDokter(){
		
		$cri = new CDbCriteria();
		$id = array(
			//Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP
		);
		$cri->addNotInCondition("kelompokpegawai_id", $id);
		$cri->addCondition(" kelompokpegawai_aktif = TRUE ");
		$cri->order = " kelompokpegawai_nama ASC ";
		
		$model = $this->model()->findAll($cri);
		
		return $model;
		
	}

}
