<?php
/**
 * This is the model class for table "kontrakkaryawan_r".
 *
 * The followings are the available columns in table 'kontrakkaryawan_r':
 * @property integer $kontrakkaryawan_id
 * @property integer $pegawai_id
 * @property string $nosuratkontrak
 * @property string $tglkontrak
 * @property integer $nourutkontrak
 * @property string $tglmulaikontrak
 * @property string $tglakhirkontrak
 * @property string $lamakontrak
 * @property string $keterangankontrak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class KPKontrakKaryawanR extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KPKontrakKaryawanR the static model class
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
        return 'kontrakkaryawan_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, nosuratkontrak, tglkontrak, nourutkontrak, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pegawai_id, nourutkontrak', 'numerical', 'integerOnly'=>true),
            array('nosuratkontrak', 'length', 'max'=>100),
            array('lamakontrak', 'length', 'max'=>30),
            array('tglmulaikontrak, tglakhirkontrak, keterangankontrak, update_time, update_loginpemakai_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kontrakkaryawan_id, pegawai_id, nosuratkontrak, tglkontrak, nourutkontrak, tglmulaikontrak, tglakhirkontrak, lamakontrak, keterangankontrak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'kontrakkaryawan_id' => 'Kontrak Pegawai',
            'pegawai_id' => 'Pegawai',
            'nosuratkontrak' => 'No. Surat Kontrak',
            'tglkontrak' => 'Tgl. Kontrak',
            'nourutkontrak' => 'No. Urut Kontrak',
            'tglmulaikontrak' => 'Tgl. Mulai Kontrak',
            'tglakhirkontrak' => 'Tgl. Akhir Kontrak',
            'lamakontrak' => 'Lama Kontrak',
            'keterangankontrak' => 'Keterangan Kontrak',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('kontrakkaryawan_id',$this->kontrakkaryawan_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(nosuratkontrak)',strtolower($this->nosuratkontrak),true);
        $criteria->compare('LOWER(tglkontrak)',strtolower($this->tglkontrak),true);
        $criteria->compare('nourutkontrak',$this->nourutkontrak);
        $criteria->compare('LOWER(tglmulaikontrak)',strtolower($this->tglmulaikontrak),true);
        $criteria->compare('LOWER(tglakhirkontrak)',strtolower($this->tglakhirkontrak),true);
        $criteria->compare('LOWER(lamakontrak)',strtolower($this->lamakontrak),true);
        $criteria->compare('LOWER(keterangankontrak)',strtolower($this->keterangankontrak),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('kontrakkaryawan_id',$this->kontrakkaryawan_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(nosuratkontrak)',strtolower($this->nosuratkontrak),true);
        $criteria->compare('LOWER(tglkontrak)',strtolower($this->tglkontrak),true);
        $criteria->compare('nourutkontrak',$this->nourutkontrak);
        $criteria->compare('LOWER(tglmulaikontrak)',strtolower($this->tglmulaikontrak),true);
        $criteria->compare('LOWER(tglakhirkontrak)',strtolower($this->tglakhirkontrak),true);
        $criteria->compare('LOWER(lamakontrak)',strtolower($this->lamakontrak),true);
        $criteria->compare('LOWER(keterangankontrak)',strtolower($this->keterangankontrak),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        
        public $nourut;
}
?>
