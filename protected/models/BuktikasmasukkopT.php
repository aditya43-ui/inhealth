<?php

/**
 * This is the model class for table "buktikasmasukkop_t".
 *
 * The followings are the available columns in table 'buktikasmasukkop_t':
 * @property integer $buktikasmasukkop_id
 * @property string $nobuktimasuk
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property double $jmlbayarkartu
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $keterangan_pembayaran
 * @property integer $preparedby
 * @property string $prepareddate
 * @property integer $reviewedby
 * @property string $revieweddate
 * @property integer $approvedby
 * @property string $approveddate
 * @property string $create_time
 * @property string $update_time
 * @property string $create_login
 * @property string $update_login
 */
class BuktikasmasukkopT extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'buktikasmasukkop_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenistransaksi_id, nobuktimasuk, tglbuktibayar, carapembayaran, jmlbayarkartu, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembayaran, biayamaterai, uangditerima, uangkembalian, create_time, create_login', 'required'),
            array('preparedby, reviewedby, approvedby', 'numerical', 'integerOnly' => true),
            array('jmlbayarkartu, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian', 'numerical'),
            array('nobuktimasuk, carapembayaran, dengankartu', 'length', 'max' => 50),
            array('bankkartu, nokartu, nostrukkartu, darinama_bkm, sebagaipembayaran_bkm, create_login, update_login', 'length', 'max' => 100),
            array('prepareddate, revieweddate, approveddate, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('jenistransaksi_id, buktikasmasukkop_id, nobuktimasuk, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, jmlbayarkartu, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, keterangan_pembayaran, preparedby, prepareddate, reviewedby, revieweddate, approvedby, approveddate, create_time, update_time, create_login, update_login', 'safe', 'on' => 'search'),
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
            'buktikasmasukkop_id' => 'Buktikasmasuk',
            'nobuktimasuk' => 'No. BKM',
            'tglbuktibayar' => 'Tgl. Bayar',
            'carapembayaran' => 'Cara Pembayaran',
            'jenistransaksi_id' => 'Jenis Transaksi',
            'dengankartu' => 'Dengankartu',
            'bankkartu' => 'Bank',
            'nokartu' => 'No Kartu',
            'nostrukkartu' => 'Nostrukkartu',
            'jmlbayarkartu' => 'Jmlbayarkartu',
            'darinama_bkm' => 'Dari Nama',
            'alamat_bkm' => 'Alamat',
            'sebagaipembayaran_bkm' => 'Sebagaipembayaran Bkm',
            'jmlpembayaran' => 'Jumlah Pembayaran',
            'biayaadministrasi' => 'Biaya Administrasi',
            'biayamaterai' => 'Biaya Materai',
            'uangditerima' => 'Uang Diterima',
            'uangkembalian' => 'Uang Kembalian',
            'keterangan_pembayaran' => 'Keterangan Pembayaran',
            'preparedby' => 'Dibuat',
            'prepareddate' => 'Tanggal Buat',
            'reviewedby' => 'Diperiksa Oleh',
            'revieweddate' => 'Tanggal Review',
            'approvedby' => 'Disetujui Oleh',
            'approveddate' => 'Tanggal Disetujui',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_login' => 'Create Login',
            'update_login' => 'Update Login',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->buktikasmasukkop_id)) $criteria->addCondition('buktikasmasukkop_id = ' . $this->buktikasmasukkop_id);
        //$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
        if (!empty($this->jenistransaksi_id)) $criteria->addCondition('jenistransaksi_id = ' . $this->jenistransaksi_id);
        //$criteria->compare('jenistransaksi_id',$this->jenistransaksi_id);
        $criteria->compare('nobuktimasuk', $this->nobuktimasuk, true);
        $criteria->compare('tglbuktibayar', $this->tglbuktibayar, true);
        $criteria->compare('carapembayaran', $this->carapembayaran, true);
        $criteria->compare('dengankartu', $this->dengankartu, true);
        $criteria->compare('bankkartu', $this->bankkartu, true);
        $criteria->compare('nokartu', $this->nokartu, true);
        $criteria->compare('nostrukkartu', $this->nostrukkartu, true);
        $criteria->compare('jmlbayarkartu', $this->jmlbayarkartu);
        $criteria->compare('darinama_bkm', $this->darinama_bkm, true);
        $criteria->compare('alamat_bkm', $this->alamat_bkm, true);
        $criteria->compare('sebagaipembayaran_bkm', $this->sebagaipembayaran_bkm, true);
        $criteria->compare('jmlpembayaran', $this->jmlpembayaran);
        $criteria->compare('biayaadministrasi', $this->biayaadministrasi);
        $criteria->compare('biayamaterai', $this->biayamaterai);
        $criteria->compare('uangditerima', $this->uangditerima);
        $criteria->compare('uangkembalian', $this->uangkembalian);
        $criteria->compare('keterangan_pembayaran', $this->keterangan_pembayaran);
        $criteria->compare('preparedby', $this->preparedby);
        $criteria->compare('prepareddate', $this->prepareddate, true);
        $criteria->compare('reviewedby', $this->reviewedby);
        $criteria->compare('revieweddate', $this->revieweddate, true);
        $criteria->compare('approvedby', $this->approvedby);
        $criteria->compare('approveddate', $this->approveddate, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_login', $this->create_login, true);
        $criteria->compare('update_login', $this->update_login, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BuktikasmasukT the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function generateNoBukti($tipe = null)
    {
        $date = date('Ym');
        $sql = "select count(nobuktimasuk) as urut from buktikasmasukkop_t where substr(nobuktimasuk, 1, 12) ilike '%BKM" . $date . "%'";
        $dat =  Yii::app()->db->createCommand($sql)->queryRow();

        $cnt = str_pad(($dat['urut'] + 1), 4, '0', STR_PAD_LEFT);
        return 'BKM' . $date . $cnt;
    }
}
