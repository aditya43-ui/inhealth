<?php

/**
 * This is the model class for table "informasirenkebbahanmakanan_v".
 *
 * The followings are the available columns in table 'informasirenkebbahanmakanan_v':
 * @property integer $renkebbahanmakanan_id
 * @property string $renkebbahanmakanan_tgl
 * @property integer $ro_bahanmakanan_bulan
 * @property string $namabahanmakanan
 * @property string $satuanbahan
 * @property integer $jmlpermintaandet
 * @property double $harga_barangdet
 * @property integer $stokakhir_bahanmakanan
 * @property integer $minstok_bahanmakanan
 * @property integer $makstok_bahanmakanan
 * @property integer $pegmengetahui_id
 * @property integer $pegmenyetujui_id
 * @property string $renkebbahanmakanan_no
 */
class InformasirenkebbahanmakananV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir, $pegmenyetujui_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirenkebbahanmakananV the static model class
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
		return 'informasirenkebbahanmakanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renkebbahanmakanan_id, ro_bahanmakanan_bulan, jmlpermintaandet, stokakhir_bahanmakanan, minstok_bahanmakanan, makstok_bahanmakanan, pegmengetahui_id, pegmenyetujui_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('harga_barangdet', 'numerical'),
			array('namabahanmakanan, sumberdana_nama', 'length', 'max'=>100),
			array('satuanbahan, renkebbahanmakanan_no', 'length', 'max'=>50),
			array('renkebbahanmakanan_tgl, sumberdana_id, sumberdana_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbahanmakanan_id, renkebbahanmakanan_tgl, ro_bahanmakanan_bulan, namabahanmakanan, satuanbahan, jmlpermintaandet, harga_barangdet, stokakhir_bahanmakanan, minstok_bahanmakanan, makstok_bahanmakanan, pegmengetahui_id, pegmenyetujui_id, renkebbahanmakanan_no, sumberdana_id, sumberdana_nama', 'safe', 'on'=>'search'),
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
			'renkebbahanmakanan_id' => 'Rencana Kebutuhan Bahan Makanan',
			'renkebbahanmakanan_tgl' => 'Tgl. Rencana',
			'ro_bahanmakanan_bulan' => 'Recomended Order (RO)',
			'namabahanmakanan' => 'Nama Bahan Makanan',
			'satuanbahan' => 'Satuan',
			'jmlpermintaandet' => 'Jumlah',
			'harga_barangdet' => 'Harga',
			'stokakhir_bahanmakanan' => 'Stok Akhir',
			'minstok_bahanmakanan' => 'Stok Minimal',
			'makstok_bahanmakanan' => 'Stok Maksimal',
			'pegmengetahui_id' => 'Pegawai Gizi',
			'pegmenyetujui_id' => 'Kepala Instalasi Gizi',
			'renkebbahanmakanan_no' => 'No. Rencana',
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

		$criteria->compare('renkebbahanmakanan_id',$this->renkebbahanmakanan_id);
		$criteria->compare('renkebbahanmakanan_tgl',$this->renkebbahanmakanan_tgl,true);
		$criteria->compare('ro_bahanmakanan_bulan',$this->ro_bahanmakanan_bulan);
		$criteria->compare('namabahanmakanan',$this->namabahanmakanan,true);
		$criteria->compare('satuanbahan',$this->satuanbahan,true);
		$criteria->compare('jmlpermintaandet',$this->jmlpermintaandet);
		$criteria->compare('harga_barangdet',$this->harga_barangdet);
		$criteria->compare('stokakhir_bahanmakanan',$this->stokakhir_bahanmakanan);
		$criteria->compare('minstok_bahanmakanan',$this->minstok_bahanmakanan);
		$criteria->compare('makstok_bahanmakanan',$this->makstok_bahanmakanan);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('pegmenyetujui_id',$this->pegmenyetujui_id);
		$criteria->compare('renkebbahanmakanan_no',$this->renkebbahanmakanan_no,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('DATE(t.renkebbahanmakanan_tgl)',$this->tgl_awal,$this->tgl_akhir,true);
		}
                
                if (!empty($this->renkebbarang_tgl)){
                    $criteria->addBetweenCondition('t.renkebbahanmakanan_tgl',$this->renkebbahanmakanan_tgl,$this->renkebbahanmakanan_tgl);
                }
                
		$criteria->compare('LOWER(t.renkebbahanmakanan_no)',strtolower($this->renkebbahanmakanan_no),true);
		//$criteria->distinct="renkebbarang_no,renkebbarang_tgl,renkebbarang_id";
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('t.pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenyetujui_id)){
			$criteria->addCondition('t.pegmenyetujui_id = '.$this->pegmenyetujui_id);
		}
		
                if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
                
		$criteria->group="t.tglmenyetujui, t.renkebbahanmakanan_no,t.renkebbahanmakanan_tgl,t.ro_bahanmakanan_bulan,t.pegmengetahui_id,t.pegmenyetujui_id,t.renkebbahanmakanan_id,t.sumberdana_nama";
		$criteria->order = "t.renkebbahanmakanan_tgl DESC";
		$criteria->select = $criteria->group;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchDialogUntukPermintaan() {
        $prov = $this->searchInformasi();
        $prov->criteria->join = 'left join pengajuanbahanmkn_t p on p.renkebbahanmakanan_id = t.renkebbahanmakanan_id';
        $prov->criteria->addCondition('p.renkebbahanmakanan_id is null');
        $prov->criteria->addCondition('t.tglmenyetujui is not null');
        
        return $prov;
    }
    
    public static function pegawaimengetahui($pegmengetahui_id){
		$pegawaimengetahui = PegawaiM::model()->findBypk($pegmengetahui_id);
		return isset($pegawaimengetahui->nama_pegawai) ? $pegawaimengetahui->gelardepan.' '.$pegawaimengetahui->nama_pegawai : "";
	}

	public static function pegawaimenyetujui($pegmenyetujui_id){
		$pegawaimenyetujui = PegawaiM::model()->findBypk($pegmenyetujui_id);
		return isset($pegawaimenyetujui->nama_pegawai) ? $pegawaimenyetujui->gelardepan.' '.$pegawaimenyetujui->nama_pegawai : "";
	}
}