<?php

/**
 * This is the model class for table "laporankaskeluarkop_v".
 *
 * The followings are the available columns in table 'laporankaskeluarkop_v':
 * @property integer $buktikaskeluarkop_id
 * @property integer $jenistransaksi_id
 * @property string $namatransaksi
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
 * @property string $prepareddate
 * @property integer $preparedby
 * @property integer $reviewedby
 * @property string $revieweddate
 * @property integer $approvedby
 * @property string $approveddate
 */
class LaporankaskeluarkopV extends CActiveRecord
{
    public $jns_periode;
    public $tgl_awal, $bln_awal, $thn_awal;
    public $tgl_akhir, $bln_akhir, $thn_akhir;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporankaskeluarkopV the static model class
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
        return 'laporankaskeluarkop_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('buktikaskeluarkop_id, jenistransaksi_id, preparedby, reviewedby, approvedby', 'numerical', 'integerOnly' => true),
            array('jmlkaskeluar, biayaadministrasi, biayaamaterai', 'numerical'),
            array('namatransaksi, untuk_pengeluaran', 'length', 'max' => 200),
            array('no_bkk, cara_kas_keluar', 'length', 'max' => 50),
            array('melaluibank, denganrekening, atasnamarekening, namapenerima', 'length', 'max' => 100),
            array('tgl_bkk, alamatpenerima, keterangan_bkk, bkk_create_time, bkk_update_time, prepareddate, revieweddate, approveddate', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('buktikaskeluarkop_id, jenistransaksi_id, namatransaksi, tgl_bkk, no_bkk, cara_kas_keluar, melaluibank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, untuk_pengeluaran, jmlkaskeluar, biayaadministrasi, biayaamaterai, keterangan_bkk, bkk_create_time, bkk_update_time, prepareddate, preparedby, reviewedby, revieweddate, approvedby, approveddate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'buktikaskeluarkop_id' => 'Bukti Kas Keluar Kop',
            'jenistransaksi_id' => 'Jenis Transaksi',
            'namatransaksi' => 'Nama Transaksi',
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
            'prepareddate' => 'Tanggal Persiapan',
            'preparedby' => 'Dibuat Oleh',
            'reviewedby' => 'Direview Oleh',
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
        $criteria->compare('namatransaksi', $this->namatransaksi, true);
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

    public function getTotBA($provider)
    {
        $prov = clone $provider;
        $prov->pagination = false;
        $total = 0;
        foreach ($prov->data as $item) {
            $total += $item->biayaadministrasi;
        }
        return $total;
    }

    public function getTotBM($provider)
    {
        $prov = clone $provider;
        $prov->pagination = false;
        $total = 0;
        foreach ($prov->data as $item) {
            $total += $item->biayaamaterai;
        }
        return $total;
    }

    public function getTotJKM($provider)
    {
        $prov = clone $provider;
        $prov->pagination = false;
        $total = 0;
        foreach ($prov->data as $item) {
            $total += ($item->jmlkaskeluar - $item->biayaadministrasi - $item->biayaamaterai);
        }
        return $total;
    }
}
