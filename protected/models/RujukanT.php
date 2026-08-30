 <?php

/**
 * This is the model class for table "rujukan_t".
 *
 * The followings are the available columns in table 'rujukan_t':
 * @property integer $rujukan_id
 * @property integer $asalrujukan_id
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property boolean $aktif_rujukan
 * @property integer $rujukandari_id
 *
 * The followings are the available model relations:
 * @property AsalrujukanM $asalrujukan
 * @property RujukandariM $rujukandari
 * @property PendaftaranT[] $pendaftaranTs
 */
class RujukanT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RujukanT the static model class
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
        return 'rujukan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // array('no_rujukan, nama_perujuk', 'required'),
            array('asalrujukan_id, rujukandari_id', 'numerical', 'integerOnly'=>true),
            array('no_rujukan', 'length', 'max'=>20),
            array('nama_perujuk', 'length', 'max'=>50),
            array('tanggal_rujukan, diagnosa_rujukan, aktif_rujukan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rujukan_id, asalrujukan_id, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, aktif_rujukan, rujukandari_id', 'safe', 'on'=>'search'),
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
            'asalrujukan' => array(self::BELONGS_TO, 'AsalrujukanM', 'asalrujukan_id'),
            'rujukandari' => array(self::BELONGS_TO, 'RujukandariM', 'rujukandari_id'),
            'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'rujukan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'rujukan_id' => 'Rujukan',
            'asalrujukan_id' => 'Asal Rujukan',
            'no_rujukan' => 'No. Rujukan',
            'nama_perujuk' => 'Nama Perujuk',
            'tanggal_rujukan' => 'Tanggal Rujukan',
            'diagnosa_rujukan' => 'Diagnosa Rujukan',
            'kddiagnosa_rujukan' => 'Kode Diagnosa Rujukan',
            'aktif_rujukan' => 'Aktif Rujukan',
            'rujukandari_id' => 'Rujukan Dari',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('rujukan_id',$this->rujukan_id);
        $criteria->compare('asalrujukan_id',$this->asalrujukan_id);
        $criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
        $criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
        $criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
        $criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
        $criteria->compare('aktif_rujukan',$this->aktif_rujukan);
        $criteria->compare('rujukandari_id',$this->rujukandari_id);

        return $criteria;
    }
        
        
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
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
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
} 