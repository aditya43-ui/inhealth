<?php

/**
 * This is the model class for table "tandabuktibayar_t".
 *
 * The followings are the available columns in table 'tandabuktibayar_t':
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property integer $pembatalanuangmuka_id
 * @property integer $bayaruangmuka_id
 * @property integer $closingkasir_id
 * @property integer $returpenerimaanumum_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $returbayarpelayanan_id
 * @property integer $shift_id
 * @property integer $nourutkasir
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property string $alamat_bkm
 * @property string $sebagaipembayaran_bkm
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $keterangan_pembayaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $isprint
 * @property integer $pembayarankapitasidetail_id
 * @property integer $bank_id
 *
 * The followings are the available model relations:
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property ReturpenerimaanumumT[] $returpenerimaanumumTs
 * @property PinjampegdetT[] $pinjampegdetTs
 * @property PenerimaanumumT[] $penerimaanumumTs
 * @property PembatalanuangmukaT[] $pembatalanuangmukaTs
 * @property ReturbayarpelayananT[] $returbayarpelayananTs
 * @property PembayarankapitasidetailT $pembayarankapitasidetail
 * @property BayaruangmukaT $bayaruangmuka
 * @property ClosingkasirT $closingkasir
 * @property PembatalanuangmukaT $pembatalanuangmuka
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property ReturbayarpelayananT $returbayarpelayanan
 * @property ReturpenerimaanumumT $returpenerimaanumum
 * @property RuanganM $ruangan
 * @property ShiftM $shift
 * @property BankM $bank
 * @property PengajuanklaimdetailT[] $pengajuanklaimdetailTs
 * @property PembklaimdetalT[] $pembklaimdetalTs
 * @property BayarangsuranpelayananT[] $bayarangsuranpelayananTs
 */
class TandabuktibayarT extends CActiveRecord {

    public $denganrekening, $jmlpembulatanasuransi, $pembayaran;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TandabuktibayarT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tandabuktibayar_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, shift_id, nourutkasir, nobuktibayar, tglbuktibayar, carapembayaran, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('ruangan_id, pembatalanuangmuka_id, bayaruangmuka_id, closingkasir_id, returpenerimaanumum_id, pembayaranpelayanan_id, returbayarpelayanan_id, shift_id, nourutkasir, pembayarankapitasidetail_id, bank_id', 'numerical', 'integerOnly' => true),
            array('jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian', 'numerical'),
            array('nobuktibayar, carapembayaran, dengankartu, norekpenerima', 'length', 'max' => 50),
            array('bankkartu, nokartu, nostrukkartu, darinama_bkm, sebagaipembayaran_bkm, namapengirim', 'length', 'max' => 100),
            array('bank_nama, bank_nominal, update_time, update_loginpemakai_id, isprint, ispakekartu,keterangan_pembayaran, alamatpengirim', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bank_nama, bank_nominal, tandabuktibayar_id, ruangan_id, pembatalanuangmuka_id, bayaruangmuka_id, closingkasir_id, returpenerimaanumum_id, pembayaranpelayanan_id, returbayarpelayanan_id, shift_id, nourutkasir, nobuktibayar, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, alamat_bkm, sebagaipembayaran_bkm, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, keterangan_pembayaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isprint, pembayarankapitasidetail_id, bank_id, ispakekartu, namapengirim, alamatpengirim, norekpenerima', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'tandabuktibayar_id'),
            'returpenerimaanumumTs' => array(self::HAS_MANY, 'ReturpenerimaanumumT', 'tandabuktibayar_id'),
            'pinjampegdetTs' => array(self::HAS_MANY, 'PinjampegdetT', 'tandabuktibayar_id'),
            'penerimaanumumTs' => array(self::HAS_MANY, 'PenerimaanumumT', 'tandabuktibayar_id'),
            'pembatalanuangmukaTs' => array(self::HAS_MANY, 'PembatalanuangmukaT', 'tandabuktibayar_id'),
            'returbayarpelayananTs' => array(self::HAS_MANY, 'ReturbayarpelayananT', 'tandabuktibayar_id'),
            'pembayarankapitasidetail' => array(self::BELONGS_TO, 'PembayarankapitasidetailT', 'pembayarankapitasidetail_id'),
            'bayaruangmuka' => array(self::BELONGS_TO, 'BayaruangmukaT', 'bayaruangmuka_id'),
            'closingkasir' => array(self::BELONGS_TO, 'ClosingkasirT', 'closingkasir_id'),
            'pembatalanuangmuka' => array(self::BELONGS_TO, 'PembatalanuangmukaT', 'pembatalanuangmuka_id'),
            'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
            'returbayarpelayanan' => array(self::BELONGS_TO, 'ReturbayarpelayananT', 'returbayarpelayanan_id'),
            'returpenerimaanumum' => array(self::BELONGS_TO, 'ReturpenerimaanumumT', 'returpenerimaanumum_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
            'bank' => array(self::BELONGS_TO, 'BankM', 'bank_id'),
            'pengajuanklaimdetailTs' => array(self::HAS_MANY, 'PengajuanklaimdetailT', 'tandabuktibayar_id'),
            'pembklaimdetalTs' => array(self::HAS_MANY, 'PembklaimdetalT', 'tandabuktibayar_id'),
            'bayarangsuranpelayananTs' => array(self::HAS_MANY, 'BayarangsuranpelayananT', 'tandabuktibayar_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tandabuktibayar_id' => 'Tandabuktibayar',
            'ruangan_id' => 'Ruangan',
            'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
            'bayaruangmuka_id' => 'Bayaruangmuka',
            'closingkasir_id' => 'Closingkasir',
            'returpenerimaanumum_id' => 'Returpenerimaaketerangan_pembayaran',
            'nourutkasir' => 'No Urut Kasir',
            'nobuktibayar' => 'No. Bukti Bayar',
            'tglbuktibayar' => 'Tanggal Bukti Bayar',
            'carapembayaran' => 'Cara Pembayaran',
            'dengankartu' => 'Dengan Kartu',
            'bankkartu' => 'Bank Kartu',
            'nokartu' => 'No Kartu',
            'nostrukkartu' => 'No Struk Kartu',
            'darinama_bkm' => 'Dari Nama',
            'alamat_bkm' => 'Alamat',
            'sebagaipembayaran_bkm' => 'Sebagai Pembayaran',
            'jmlpembulatan' => 'Jumlah Pembulatan',
            'jmlpembayaran' => 'Jumlah Pembayaran',
            'biayaadministrasi' => 'Biaya Administrasi',
            'biayamaterai' => 'Biaya Materai',
            'uangditerima' => 'Uang Diterima',
            'uangkembalian' => 'Uang Kembalian',
            'keterangan_pembayaran' => 'Keterangan Pembayaran',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'isprint' => 'Isprint',
            'pembayarankapitasidetail_id' => 'Pembayarankapitasidetail',
            'bank_id' => 'Bank',
            'ispakekartu' => 'Menggunakan Kartu',
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

        $criteria->compare('tandabuktibayar_id', $this->tandabuktibayar_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('pembatalanuangmuka_id', $this->pembatalanuangmuka_id);
        $criteria->compare('bayaruangmuka_id', $this->bayaruangmuka_id);
        $criteria->compare('closingkasir_id', $this->closingkasir_id);
        $criteria->compare('returpenerimaanumum_id', $this->returpenerimaanumum_id);
        $criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
        $criteria->compare('returbayarpelayanan_id', $this->returbayarpelayanan_id);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('nourutkasir', $this->nourutkasir);
        $criteria->compare('nobuktibayar', $this->nobuktibayar, true);
        $criteria->compare('tglbuktibayar', $this->tglbuktibayar, true);
        $criteria->compare('carapembayaran', $this->carapembayaran, true);
        $criteria->compare('dengankartu', $this->dengankartu, true);
        $criteria->compare('bankkartu', $this->bankkartu, true);
        $criteria->compare('nokartu', $this->nokartu, true);
        $criteria->compare('nostrukkartu', $this->nostrukkartu, true);
        $criteria->compare('darinama_bkm', $this->darinama_bkm, true);
        $criteria->compare('alamat_bkm', $this->alamat_bkm, true);
        $criteria->compare('sebagaipembayaran_bkm', $this->sebagaipembayaran_bkm, true);
        $criteria->compare('jmlpembulatan', $this->jmlpembulatan);
        $criteria->compare('jmlpembayaran', $this->jmlpembayaran);
        $criteria->compare('biayaadministrasi', $this->biayaadministrasi);
        $criteria->compare('biayamaterai', $this->biayamaterai);
        $criteria->compare('uangditerima', $this->uangditerima);
        $criteria->compare('uangkembalian', $this->uangkembalian);
        $criteria->compare('keterangan_pembayaran', $this->keterangan_pembayaran);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan', $this->create_ruangan, true);
        $criteria->compare('isprint', $this->isprint);
        $criteria->compare('pembayarankapitasidetail_id', $this->pembayarankapitasidetail_id);
        $criteria->compare('bank_id', $this->bank_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getRuanganNama($pembayaranpelayanan_id) {
        $cek = PembayaranpelayananT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
        $data = '';

        if ($cek === null):
            $data = '-';
        else:
            foreach ($cek as $cekA)
                $data = $cekA['ruanganpelakhir_id'];
        endif;

        $getR_id = RuanganM::model()->findAllByAttributes(array('ruangan_id' => $data));
        if ($getR_id === null):
            $data1 = '-';
        else:
            foreach ($getR_id as $ruangan_nama)
                $data1 = $ruangan_nama['ruangan_nama'];
        endif;



        return $data1;
    }

    public function getRuanganNamaDariUangMuka($bayaruangmuka_id) {
        $cek = BayaruangmukaT::model()->findAllByAttributes(array('bayaruangmuka_id' => $bayaruangmuka_id));
        $data = '';

        if ($cek === null):
            $data = '-';
        else:
            foreach ($cek as $cekA)
                $data = $cekA['ruangan_id'];
        endif;

        $getR_id = RuanganM::model()->findAllByAttributes(array('ruangan_id' => $data));
        if ($getR_id === null):
            $data1 = '-';
        else:
            foreach ($getR_id as $ruangan_nama)
                $data1 = $ruangan_nama['ruangan_nama'];
        endif;



        return $data1;
    }

}
