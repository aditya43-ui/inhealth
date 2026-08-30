<?php

/**
 * This is the model class for table "laporanpemesananbarang_v".
 *
 * The followings are the available columns in table 'laporanpemesananbarang_v':
 * @property integer $pesanbarang_id
 * @property integer $mutasibrg_id
 * @property string $nopemesanan
 * @property string $tglpesanbarang
 * @property string $tglmintadikirim
 * @property integer $ruanganpemesan_id
 * @property string $ruanganpemesan_nama
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property integer $pegpemesan_id
 * @property string $pegpemesan_nama
 * @property integer $pegmengetahui_id
 * @property string $pegmengetahui_nama
 * @property integer $barang_id
 * @property string $barang_nama
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_satuan
 * @property integer $jenisbarang_id
 * @property string $jenisbarang_nama
 * @property double $qty_pesan
 * @property string $satuanbarang
 */
class LaporanpemesananbarangV extends CActiveRecord
{
    public $jns_periode;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $tgl_awal, $tgl_akhir;
    
    public $status_mutasi;
    
    public $data, $jumlah;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemesananbarangV the static model class
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
		return 'laporanpemesananbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesanbarang_id, mutasibrg_id, ruanganpemesan_id, ruangantujuan_id, pegpemesan_id, pegmengetahui_id, barang_id, jenisbarang_id', 'numerical', 'integerOnly'=>true),
			array('qty_pesan', 'numerical'),
			array('nopemesanan, ruanganpemesan_nama, ruangantujuan_nama, pegpemesan_nama, pegmengetahui_nama, barang_type, barang_kode, barang_satuan, jenisbarang_nama, satuanbarang', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('tglpesanbarang, tglmintadikirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanbarang_id, mutasibrg_id, nopemesanan, tglpesanbarang, tglmintadikirim, ruanganpemesan_id, ruanganpemesan_nama, ruangantujuan_id, ruangantujuan_nama, pegpemesan_id, pegpemesan_nama, pegmengetahui_id, pegmengetahui_nama, barang_id, barang_nama, barang_type, barang_kode, barang_satuan, jenisbarang_id, jenisbarang_nama, qty_pesan, satuanbarang', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanbarang_id' => 'Pesanbarang',
			'mutasibrg_id' => 'Mutasibrg',
			'nopemesanan' => 'No. Pemesanan',
			'tglpesanbarang' => 'Tgl. Pemesanan',
			'tglmintadikirim' => 'Tglmintadikirim',
			'ruanganpemesan_id' => 'Ruangan Pemesan',
			'ruanganpemesan_nama' => 'Ruangan Pemesan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruangantujuan_nama' => 'Ruangan Tujuan',
			'pegpemesan_id' => 'Pegpemesan',
			'pegpemesan_nama' => 'Pegpemesan Nama',
			'pegmengetahui_id' => 'Pegmengetahui',
			'pegmengetahui_nama' => 'Pegmengetahui Nama',
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_satuan' => 'Barang Satuan',
			'jenisbarang_id' => 'Jenisbarang',
			'jenisbarang_nama' => 'Jenisbarang Nama',
			'qty_pesan' => 'Qty Pesan',
			'satuanbarang' => 'Satuan',
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

		$criteria->compare('pesanbarang_id',$this->pesanbarang_id);
		$criteria->compare('mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('nopemesanan',$this->nopemesanan,true);
		$criteria->compare('tglpesanbarang',$this->tglpesanbarang,true);
		$criteria->compare('tglmintadikirim',$this->tglmintadikirim,true);
		$criteria->compare('ruanganpemesan_id',$this->ruanganpemesan_id);
		$criteria->compare('ruanganpemesan_nama',$this->ruanganpemesan_nama,true);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
		$criteria->compare('pegpemesan_id',$this->pegpemesan_id);
		$criteria->compare('pegpemesan_nama',$this->pegpemesan_nama,true);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('pegmengetahui_nama',$this->pegmengetahui_nama,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('lower(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);
		$criteria->compare('qty_pesan',$this->qty_pesan);
		$criteria->compare('satuanbarang',$this->satuanbarang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    public function searchLaporan() {
        $prov = $this->search();
        
        $prov->criteria->addBetweenCondition('tglpesanbarang::date', $this->tgl_awal, $this->tgl_akhir);
        
        if ($this->status_mutasi == 1) {
            $prov->criteria->addCondition('mutasibrg_id is null');
        }
        if ($this->status_mutasi == 2) {
            $prov->criteria->addCondition('mutasibrg_id is not null');
        }
        
        $prov->sort->defaultOrder = 'ruanganpemesan_nama, ruangantujuan_nama, nopemesanan';
        $prov->sort->attributes = array(
            'nopemesanan'=>array(
                'asc'=>'ruanganpemesan_nama, nopemesanan',
                'desc'=>'ruanganpemesan_nama, nopemesanan desc'
            ),
            'tglpemesanan'=>array(
                'asc'=>'ruanganpemesan_nama, tglpemesanan',
                'desc'=>'ruanganpemesan_nama, tglpemesanan desc'
            ),
            'barang_nama'=>array(
                'asc'=>'ruanganpemesan_nama, barang_nama',
                'desc'=>'ruanganpemesan_nama, barang_nama desc'
            ),
            'satuanbarang'=>array(
                'asc'=>'ruanganpemesan_nama, satuanbarang',
                'desc'=>'ruanganpemesan_nama, satuanbarang desc'
            ),
            'qty_pesan'=>array(
                'asc'=>'ruanganpemesan_nama, qty_pesan',
                'desc'=>'ruanganpemesan_nama, qty_pesan desc'
            ),
            '*',
        );
        
        
        return $prov;
    }
    
    
    public function searchPrintLaporan() {
        $prov = $this->searchLaporan();
        
        $prov->pagination = false;
        
        
        return $prov;
    }
    
    
    public function searchGrafik()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

        
            $prov = $this->searchPrintLaporan();

            $prov->criteria->select = 'sum(t.qty_pesan) as jumlah,  t.barang_nama as data';
            $prov->criteria->group = 't.barang_nama';
            $prov->sort = false;
            $prov->criteria->order = 'sum(t.qty_pesan) desc';
            $prov->criteria->limit = 10;
            // $criteria->criteria->group = 't.tglperencanaan, t.noperencnaan, t.rencanakebfarmasi_id,obatalkes_m.obatalkes_nama';

            // var_dump($prov->criteria); die;
            
            return $prov;
    }
}