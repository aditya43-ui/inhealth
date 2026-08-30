<?php

/**
 * This is the model class for table "pengpegawaidet_t".
 *
 * The followings are the available columns in table 'pengpegawaidet_t':
 * @property integer $pengpegawaidet_t_id
 * @property integer $pengajuanpegawai_t_id
 * @property string $nourut
 * @property integer $jmlorang
 * @property string $untukkeperluan
 * @property string $keterangan
 * @property boolean $disetujui
 *
 * The followings are the available model relations:
 * @property PengajuanpegawaiT $pengajuanpegawaiT
 */
class KPPengpegawaidetT extends CActiveRecord
{
    public $jumlah;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KPPengpegawaidetT the static model class
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
        return 'pengpegawaidet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pengajuanpegawai_t_id, nourut, jmlorang', 'required'),
            array('pengajuanpegawai_t_id, jmlorang', 'numerical', 'integerOnly'=>true),
            array('nourut', 'length', 'max'=>3),
            array('untukkeperluan, keterangan, disetujui', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengpegawaidet_t_id, pengajuanpegawai_t_id, nourut, jmlorang, untukkeperluan, keterangan, disetujui', 'safe', 'on'=>'search'),
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
            'pengajuanpegawaiT' => array(self::BELONGS_TO, 'PengajuanpegawaiT', 'pengajuanpegawai_t_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pengpegawaidet_t_id' => 'Pengajuan Pegawai',
            'pengajuanpegawai_t_id' => 'Pengajuan Pegawai',
            'nourut' => 'No. Urut',
            'jmlorang' => 'Jml. Orang',
            'untukkeperluan' => 'Untuk Keperluan',
            'keterangan' => 'Keterangan',
            'disetujui' => 'Disetujui',
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

        $criteria->compare('pengpegawaidet_t_id',$this->pengpegawaidet_t_id);
        $criteria->compare('pengajuanpegawai_t_id',$this->pengajuanpegawai_t_id);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('jmlorang',$this->jmlorang);
        $criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('disetujui',$this->disetujui);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('pengpegawaidet_t_id',$this->pengpegawaidet_t_id);
        $criteria->compare('pengajuanpegawai_t_id',$this->pengajuanpegawai_t_id);
        $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
        $criteria->compare('jmlorang',$this->jmlorang);
        $criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('disetujui',$this->disetujui);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
       
}
?>
