<?php

/**
 * This is the model class for table "buktikaskeluarkop_t".
 *
 * The followings are the available columns in table 'buktikaskeluarkop_t':
 * @property integer $buktikaskeluarkop_id
 * @property integer $jenistransaksi_id
 * @property string $tgl_bkk
 * @property string $no_bkk
 * @property string $cara_kas_keluar
 * @property string $melaluibank
 * @property string $denganrekening
 * @property string $atasnamarekening
 * @property string $namapenerima
 * @property string $alamatpenerima
 * @property string $untuk_pengeluaran
 * @property double $jmlkaskeluar
 * @property double $biayaadministrasi
 * @property double $biayaamaterai
 * @property string $keterangan_bkk
 * @property string $bkk_create_time
 * @property string $bkk_update_time
 * @property string $bkk_create_login
 * @property string $bkk_update_login
 * @property string $prepareddate
 * @property integer $preparedby
 * @property integer $reviewedby
 * @property string $revieweddate
 * @property integer $approvedby
 * @property string $approveddate
 *
 * The followings are the available model relations:
 * @property JenistransaksiM $jenistransaksi
 * @property JmlangsuranT[] $jmlangsuranTs
 * @property PengambilansimpananT[] $pengambilansimpananTs
 * @property PermohonanpenangguhanT[] $permohonanpenangguhanTs
 * @property PotonganasuransiT[] $potonganasuransiTs
 */
class BuktikaskeluarkopT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BuktikaskeluarkopT the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'buktikaskeluarkop_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenistransaksi_id, tgl_bkk, no_bkk, namapenerima, untuk_pengeluaran, bkk_create_time, bkk_create_login', 'required'),
            array('jenistransaksi_id, preparedby, reviewedby, approvedby', 'numerical', 'integerOnly' => true),
            array('jmlkaskeluar, biayaadministrasi, biayaamaterai', 'numerical'),
            array('no_bkk, cara_kas_keluar', 'length', 'max' => 50),
            array('melaluibank, denganrekening, atasnamarekening, namapenerima, bkk_create_login, bkk_update_login', 'length', 'max' => 100),
            array('untuk_pengeluaran', 'length', 'max' => 200),
            array('alamatpenerima, keterangan_bkk, bkk_update_time, prepareddate, revieweddate, approveddate', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('buktikaskeluarkop_id, jenistransaksi_id, tgl_bkk, no_bkk, cara_kas_keluar, melaluibank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, untuk_pengeluaran, jmlkaskeluar, biayaadministrasi, biayaamaterai, keterangan_bkk, bkk_create_time, bkk_update_time, bkk_create_login, bkk_update_login, prepareddate, preparedby, reviewedby, revieweddate, approvedby, approveddate', 'safe', 'on' => 'search'),
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
            'jenistransaksi' => array(self::BELONGS_TO, 'JenistransaksiM', 'jenistransaksi_id'),
            'jmlangsuranTs' => array(self::HAS_MANY, 'JmlangsuranT', 'buktikaskeluarkop_id'),
            'pengambilansimpananTs' => array(self::HAS_MANY, 'PengambilansimpananT', 'buktikaskeluarkop_id'),
            'permohonanpenangguhanTs' => array(self::HAS_MANY, 'PermohonanpenangguhanT', 'buktikaskeluarkop_id'),
            'potonganasuransiTs' => array(self::HAS_MANY, 'PotonganasuransiT', 'buktikaskeluarkop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'buktikaskeluarkop_id' => 'Bukti Kas Keluar Kop',
            'jenistransaksi_id' => 'Jenis Transaksi',
            'tgl_bkk' => 'Tgl. BKK',
            'no_bkk' => 'No. BKK',
            'cara_kas_keluar' => 'Cara Kas Keluar',
            'melaluibank' => 'Melalui Bank',
            'denganrekening' => 'Dengan Rekening',
            'atasnamarekening' => 'Atas Nama Rekening',
            'namapenerima' => 'Nama Penerima',
            'alamatpenerima' => 'Alamat Penerima',
            'untuk_pengeluaran' => 'Untuk Pengeluaran',
            'jmlkaskeluar' => 'Jumlah Kas Keluar',
            'biayaadministrasi' => 'Biaya Administrasi',
            'biayaamaterai' => 'Biaya Meterai',
            'keterangan_bkk' => 'Keterangan BKK',
            'bkk_create_time' => 'Waktu Create BKK',
            'bkk_update_time' => 'Waktu Update BKK',
            'bkk_create_login' => 'Create Login BKK',
            'bkk_update_login' => 'Update Login BKK',
            'preparedby' => 'Dibuat',
            'prepareddate' => 'Tanggal Buat',
            'reviewedby' => 'Diperiksa Oleh',
            'revieweddate' => 'Tanggal Review',
            'approvedby' => 'Disetujui Oleh',
            'approveddate' => 'Tanggal Disetujui',
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

        $criteria = new CDbCriteria;

        $criteria->compare('buktikaskeluarkop_id', $this->buktikaskeluarkop_id);
        $criteria->compare('jenistransaksi_id', $this->jenistransaksi_id);
        $criteria->compare('tgl_bkk', $this->tgl_bkk, true);
        $criteria->compare('no_bkk', $this->no_bkk, true);
        $criteria->compare('cara_kas_keluar', $this->cara_kas_keluar, true);
        $criteria->compare('melaluibank', $this->melaluibank, true);
        $criteria->compare('denganrekening', $this->denganrekening, true);
        $criteria->compare('atasnamarekening', $this->atasnamarekening, true);
        $criteria->compare('namapenerima', $this->namapenerima, true);
        $criteria->compare('alamatpenerima', $this->alamatpenerima, true);
        $criteria->compare('untuk_pengeluaran', $this->untuk_pengeluaran, true);
        $criteria->compare('jmlkaskeluar', $this->jmlkaskeluar);
        $criteria->compare('biayaadministrasi', $this->biayaadministrasi);
        $criteria->compare('biayaamaterai', $this->biayaamaterai);
        $criteria->compare('keterangan_bkk', $this->keterangan_bkk, true);
        $criteria->compare('bkk_create_time', $this->bkk_create_time, true);
        $criteria->compare('bkk_update_time', $this->bkk_update_time, true);
        $criteria->compare('bkk_create_login', $this->bkk_create_login, true);
        $criteria->compare('bkk_update_login', $this->bkk_update_login, true);
        $criteria->compare('prepareddate', $this->prepareddate, true);
        $criteria->compare('preparedby', $this->preparedby);
        $criteria->compare('reviewedby', $this->reviewedby);
        $criteria->compare('revieweddate', $this->revieweddate, true);
        $criteria->compare('approvedby', $this->approvedby);
        $criteria->compare('approveddate', $this->approveddate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
