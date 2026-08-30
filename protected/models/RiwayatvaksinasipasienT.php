<?php

/**
 * This is the model class for table "riwayatvaksinasipasien_t".
 *
 * The followings are the available columns in table 'riwayatvaksinasipasien_t':
 * @property integer $riwayatvaksinasipasien_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $vaksin_id
 * @property integer $daftarvaksin_id
 * @property string $vaksinasi_tanggal
 * @property integer $vaksinasi_ke
 * @property string $no_batch
 * @property string $vaksinasi_lokasimenerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 */
class RiwayatvaksinasipasienT extends CActiveRecord {

    public $jenisvaksin_id;
    public $vaksin_id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'riwayatvaksinasipasien_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, pendaftaran_id, vaksin_id, daftarvaksin_id, vaksinasi_tanggal, vaksinasi_ke, vaksinasi_lokasimenerima, create_time, create_loginpemakai_id', 'required'),
            array('pasien_id, pendaftaran_id, vaksin_id, daftarvaksin_id, vaksinasi_ke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('no_batch', 'length', 'max' => 50),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('riwayatvaksinasipasien_id, pasien_id, pendaftaran_id, vaksin_id, daftarvaksin_id, vaksinasi_tanggal, vaksinasi_ke, no_batch, vaksinasi_lokasimenerima, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'daftarvaksin' => array(self::BELONGS_TO, 'DaftarvaksinM', 'daftarvaksin_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'riwayatvaksinasipasien_id' => 'Riwayatvaksinasipasien',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'vaksin_id' => 'Vaksin',
            'daftarvaksin_id' => 'Daftarvaksin',
            'vaksinasi_tanggal' => 'Vaksinasi Tanggal',
            'vaksinasi_ke' => 'Vaksinasi Ke',
            'no_batch' => 'No Batch',
            'vaksinasi_lokasimenerima' => 'Vaksinasi Lokasimenerima',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('riwayatvaksinasipasien_id', $this->riwayatvaksinasipasien_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('vaksin_id', $this->vaksin_id);
        $criteria->compare('daftarvaksin_id', $this->daftarvaksin_id);
        $criteria->compare('vaksinasi_tanggal', $this->vaksinasi_tanggal, true);
        $criteria->compare('vaksinasi_ke', $this->vaksinasi_ke);
        $criteria->compare('no_batch', $this->no_batch, true);
        $criteria->compare('vaksinasi_lokasimenerima', $this->vaksinasi_lokasimenerima, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RiwayatvaksinasipasienT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
    public static function simpanRiwayat($pendaftaran_id, $pasien_id, $post) {
        
        $ok = true;
        $riwayat_id = array();
        
        // var_dump($post); die;
        
        foreach ($post as $item) {
            if (isset($item['riwayatvaksinasipasien_id']) && !empty($item['riwayatvaksinasipasien_id'])) {
                // $riwayat_id[] = $item['riwayatvaksinasipasien_id'];
                
                $model = self::model()->findByPk($item['riwayatvaksinasipasien_id']);
            } else {
                $model = new RiwayatvaksinasipasienT;
            }
            
            $model->attributes = $item;
            $model->vaksinasi_tanggal = MyFormatter::formatDateTimeForDB($model->vaksinasi_tanggal);
            
            if ($model->isNewRecord) {
                $model->pasien_id = $pasien_id;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->create_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            
            $model->update_time = date('Y-m-d');
            $model->update_loginpemakai_id = Yii::app()->user->id;
            
            if ($model->save()) {
                $ok = true;
                $riwayat_id[] = $model->riwayatvaksinasipasien_id;
            } else {
                $ok = false;
            }
            
            // var_dump($ok, $model->attributes);
        }
        
        // die;
        
        // hapus file Riwayat
        $cr = new CDbCriteria;
        $cr->compare('pasien_id', $pasien_id);
        $cr->addNotInCondition('riwayatvaksinasipasien_id', $riwayat_id);
        self::model()->deleteAll($cr);
        
        // var_dump($ok, $pendaftaran_id, $pasien_id, $post); die;
        
        return $ok;
    }

}
