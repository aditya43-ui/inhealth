<?php

/**
 * This is the model class for table "laporanmutasibarang_v".
 *
 * The followings are the available columns in table 'laporanmutasibarang_v':
 * @property integer $mutasibrg_id
 * @property string $tglmutasibrg
 * @property string $nomutasibrg
 * @property string $keterangan_mutasi
 * @property string $ruanganpengirim_id
 * @property string $ruanganpengirim_nama
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property integer $barang_id
 * @property string $barang_nama
 * @property double $qty_mutasi
 * @property string $satuanbrg
 */
class LaporanmutasibarangV extends CActiveRecord
{
    public $jns_periode;
    public $tgl_awal;
    public $tgl_akhir;
    
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    
    // charts
    public $data;
    public $jumlah;
    public $tick;
    
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmutasibarangV the static model class
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
		return 'laporanmutasibarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mutasibrg_id, ruangantujuan_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('qty_mutasi', 'numerical'),
			array('nomutasibrg, ruanganpengirim_nama, ruangantujuan_nama, satuanbrg', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('tglmutasibrg, keterangan_mutasi, ruanganpengirim_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasibrg_id, tglmutasibrg, nomutasibrg, keterangan_mutasi, ruanganpengirim_id, ruanganpengirim_nama, ruangantujuan_id, ruangantujuan_nama, barang_id, barang_nama, qty_mutasi, satuanbrg', 'safe', 'on'=>'search'),
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
			'mutasibrg_id' => 'Mutasibrg',
			'tglmutasibrg' => 'Tglmutasibrg',
			'nomutasibrg' => 'Nomutasibrg',
			'keterangan_mutasi' => 'Keterangan Mutasi',
			'ruanganpengirim_id' => 'Ruangan Kirim',
			'ruanganpengirim_nama' => 'Ruangan Kirim',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruangantujuan_nama' => 'Ruangan Tujuan',
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang',
			'qty_mutasi' => 'Jml Mutasi',
			'satuanbrg' => 'Saruan',
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

		$criteria->compare('t.mutasibrg_id',$this->mutasibrg_id);
		$criteria->compare('t.tglmutasibrg',$this->tglmutasibrg,true);
		$criteria->compare('t.nomutasibrg',$this->nomutasibrg,true);
		$criteria->compare('t.keterangan_mutasi',$this->keterangan_mutasi,true);
		$criteria->compare('t.ruanganpengirim_id',$this->ruanganpengirim_id);
		$criteria->compare('t.ruanganpengirim_nama',$this->ruanganpengirim_nama,true);
		$criteria->compare('t.ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('t.ruangantujuan_nama',$this->ruangantujuan_nama,true);
		$criteria->compare('t.barang_id',$this->barang_id);
		$criteria->compare('t.barang_nama',$this->barang_nama,true);
		$criteria->compare('t.qty_mutasi',$this->qty_mutasi);
		$criteria->compare('t.satuanbrg',$this->satuanbrg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchLaporan() {
        $prov = $this->search();
        
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $prov->criteria->addBetweenCondition('t.tglmutasibrg::date', $this->tgl_awal, $this->tgl_akhir);
        }
        
        $prov->criteria->group = 't.ruangantujuan_nama, t.barang_nama, t.satuanbrg';
        $prov->criteria->select = $prov->criteria->group.', sum(t.qty_mutasi) as qty_mutasi';
        $prov->sort->defaultOrder = 't.ruangantujuan_nama, t.barang_nama';
        
        return $prov;
    }
    
    
    public function searchPrintLaporan() {
        $prov = $this->search();
        
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $prov->criteria->addBetweenCondition('t.tglmutasibrg::date', $this->tgl_awal, $this->tgl_akhir);
        }
        
        $prov->criteria->group = 't.ruangantujuan_nama, t.barang_nama, t.satuanbrg';
        $prov->criteria->select = $prov->criteria->group.', sum(t.qty_mutasi) as qty_mutasi';
        $prov->sort->defaultOrder = 't.ruangantujuan_nama, t.barang_nama';
        $prov->pagination = false;
        
        return $prov;
    }
    
    public function searchGrafik() {
        $prov = $this->search();
        
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $prov->criteria->addBetweenCondition('t.tglmutasibrg::date', $this->tgl_awal, $this->tgl_akhir);
        }
        
        if (!empty($this->ruangantujuan_id)) {
            $prov->criteria->group = 't.barang_nama';
            $prov->criteria->select = 't.barang_nama as data, sum(t.qty_mutasi) as jumlah';
            $prov->sort->defaultOrder = 't.barang_nama';
        } else {
            $prov->criteria->group = 't.ruangantujuan_nama';
            $prov->criteria->select = 't.ruangantujuan_nama as data, sum(t.qty_mutasi) as jumlah';
            $prov->sort->defaultOrder = 't.ruangantujuan_nama';
        }
        // $prov->sort->defaultOrder = 't.ruangantujuan_nama';
        
        return $prov;
    }
}