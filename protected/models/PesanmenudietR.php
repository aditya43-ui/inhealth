 <?php

/**
 * This is the model class for table "pesanmenudiet_r".
 *
 * The followings are the available columns in table 'pesanmenudiet_r':
 * @property integer $pesanmenudiet_riwayat_id
 * @property integer $pesanmenudiet_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $jenismakanan_id
 * @property integer $jenisdiet_id
 * @property integer $pasienadmisi_id
 * @property integer $alatmakanan_id
 * @property double $jml_pesan_porsi
 * @property string $satuanjml_urt
 * @property string $status_menu
 * @property integer $menudiet_id
 * @property integer $jeniswaktu_id
 * @property integer $menudiet_lain_id
 * @property integer $tipediet_id
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property PesanmenudietT $pesanmenudiet
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 * @property JenismakananM $jenismakanan
 * @property JenisdietM $jenisdiet
 * @property AlatmakananM $alatmakanan
 */
class PesanmenudietR extends CActiveRecord
{
    public $ruangan_nama;
    public $no_pendaftaran;
    public $umur;
    public $no_rekam_medik;
    public $nama_pasien;
    public $jeniskelamin;
    public $jenisdiet_nama;
    public $jenismakanan_nama;
    public $jeniswaktu_nama;
    public $alatmakanan_nama;
    public $menudiet_nama;
    public $kelaspelayanan_id;
    public $jenismenudiet_id, $jenismenudiet_nama;
    public $pesanmenudetail_id;
    public $tipediet_nama;
    public $jenismenudiet_lain_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PesanmenudietR the static model class
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
        return 'pesanmenudiet_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pesanmenudiet_id, pendaftaran_id, ruangan_id, pasien_id, jenisdiet_id, jml_pesan_porsi', 'required'),
            array('pesanmenudiet_id, pendaftaran_id, ruangan_id, pasien_id, jenismakanan_id, jenisdiet_id, pasienadmisi_id, alatmakanan_id, menudiet_id, jeniswaktu_id, menudiet_lain_id, tipediet_id', 'numerical', 'integerOnly'=>true),
            array('jml_pesan_porsi', 'numerical'),
            array('satuanjml_urt', 'length', 'max'=>50),
            array('status_menu', 'length', 'max'=>20),
            array('jenisdiet_id, tipediet_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pesanmenudiet_riwayat_id, pesanmenudiet_id, pendaftaran_id, ruangan_id, pasien_id, jenismakanan_id, jenisdiet_id, pasienadmisi_id, alatmakanan_id, jml_pesan_porsi, satuanjml_urt, status_menu, menudiet_id, jeniswaktu_id, menudiet_lain_id, tipediet_id, jenislauk_sayur', 'safe', 'on'=>'search'),
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
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'pesanmenudiet' => array(self::BELONGS_TO, 'PesanmenudietT', 'pesanmenudiet_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'jenismakanan' => array(self::BELONGS_TO, 'JenismakananM', 'jenismakanan_id'),
            'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
            'alatmakanan' => array(self::BELONGS_TO, 'AlatmakananM', 'alatmakanan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pesanmenudiet_riwayat_id' => 'Pesanmenudiet Riwayat',
            'pesanmenudiet_id' => 'Pesanmenudiet',
            'pendaftaran_id' => 'Pendaftaran',
            'ruangan_id' => 'Ruangan',
            'pasien_id' => 'Pasien',
            'jenismakanan_id' => 'Jenismakanan',
            'jenisdiet_id' => 'Jenisdiet',
            'pasienadmisi_id' => 'Pasienadmisi',
            'alatmakanan_id' => 'Alatmakanan',
            'jml_pesan_porsi' => 'Jml Pesan Porsi',
            'satuanjml_urt' => 'Satuanjml Urt',
            'status_menu' => 'Status Menu',
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

        $criteria->compare('pesanmenudiet_riwayat_id',$this->pesanmenudiet_riwayat_id);
        $criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
        $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
        $criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('pasien_id',$this->pasien_id);
        $criteria->compare('jenismakanan_id',$this->jenismakanan_id);
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
        $criteria->compare('alatmakanan_id',$this->alatmakanan_id);
        $criteria->compare('jml_pesan_porsi',$this->jml_pesan_porsi);
        $criteria->compare('satuanjml_urt',$this->satuanjml_urt,true);
        $criteria->compare('status_menu',$this->status_menu,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * menampilkan data riwayat pemesanan menu diet pasien
     * @return \CActiveDataProvider
     */
    public function searchRiwayat(){
        $criteria=new CDbCriteria;
        $criteria->join =  " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id";
        if(!empty($this->instalasi_id)){
            $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
        }
        $criteria->order = 'p.tgl_pendaftaran desc';   
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }
}