 <?php

/**
 * This is the model class for table "invpersparepart_m".
 *
 * The followings are the available columns in table 'invpersparepart_m':
 * @property integer $invpersparepart_id
 * @property integer $invperalatan_id
 * @property integer $barang_id
 * @property string $invpersparepart_jenis
 * @property string $invpersparepart_satuan
 * @property integer $invpersparepart_jml
 * @property string $invpersparepart_fungsi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $invsparepart_gbr
 *
 * The followings are the available model relations:
 * @property BarangM $barang
 */
class InvpersparepartM extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvpersparepartM the static model class
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
        return 'invpersparepart_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invperalatan_id, barang_id, invpersparepart_satuan, invpersparepart_jml, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('invperalatan_id, barang_id, invpersparepart_jml, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
            array('invpersparepart_jenis, invpersparepart_satuan', 'length', 'max'=>50),
            array('invpersparepart_fungsi', 'length', 'max'=>255),
            array('invsparepart_gbr', 'length', 'max'=>500),
            array('update_time, invpersparepart_jenis, invsparepart_gbr', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('invpersparepart_id, invperalatan_id, barang_id, invpersparepart_jenis, invpersparepart_satuan, invpersparepart_jml, invpersparepart_fungsi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, invsparepart_gbr', 'safe', 'on'=>'search'),
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
            'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'invpersparepart_id' => 'Invpersparepart',
            'invperalatan_id' => 'Invperalatan',
            'barang_id' => 'Perbekalan',
            'invpersparepart_jenis' => 'Jenis',
            'invpersparepart_satuan' => 'Satuan',
            'invpersparepart_jml' => 'Jml Kebutuhan',
            'invpersparepart_fungsi' => 'Fungsi',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'invsparepart_gbr' => 'Invsparepart Gbr',
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

        $criteria->compare('invpersparepart_id',$this->invpersparepart_id);
        $criteria->compare('invperalatan_id',$this->invperalatan_id);
        $criteria->compare('barang_id',$this->barang_id);
        $criteria->compare('invpersparepart_jenis',$this->invpersparepart_jenis,true);
        $criteria->compare('invpersparepart_satuan',$this->invpersparepart_satuan,true);
        $criteria->compare('invpersparepart_jml',$this->invpersparepart_jml);
        $criteria->compare('invpersparepart_fungsi',$this->invpersparepart_fungsi,true);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        $criteria->compare('create_ruangan',$this->create_ruangan);
        $criteria->compare('invsparepart_gbr',$this->invsparepart_gbr,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
} 