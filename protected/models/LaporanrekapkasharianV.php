<?php

/**
 * This is the model class for table "laporanrekapkasharian_v".
 *
 * The followings are the available columns in table 'laporanrekapkasharian_v':
 * @property integer $tandabuktibayar_id
 * @property boolean $is_bkm
 * @property boolean $is_bkk
 * @property string $tanggal
 * @property string $no_bkm
 * @property string $no_bkk
 * @property string $no_bukti
 * @property string $keterangan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property double $debit
 * @property double $kredit
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property string $namadepan_pasien
 * @property string $nama_pasien
 * @property double $jmlpendapatan
 * @property double $jmlpiutang
 * @property double $jmleksespasien
 * @property double $jmlnontunai
 */
class LaporanrekapkasharianV extends CActiveRecord
{
	public $jns_periode;
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $trf_total;
	public $setorbank_id;
	public $totaldata;
	public $closingkasir_id;
	
	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekapkasharianV the static model class
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
		return 'laporanrekapkasharian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandabuktibayar_id, pegawai_id, ruangan_id, instalasi_id, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('debit, kredit, jmlpendapatan, jmlpiutang, jmleksespasien, jmlnontunai', 'numerical'),
			array('nama_pegawai', 'length', 'max'=>50),
			array('is_bkm, is_bkk, tanggal, no_bkm, no_bkk, no_bukti, keterangan, ruangan_nama, instalasi_nama, carabayar_nama, namadepan_pasien, nama_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tandabuktibayar_id, is_bkm, is_bkk, tanggal, no_bkm, no_bkk, no_bukti, keterangan, pegawai_id, nama_pegawai, debit, kredit, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, carabayar_id, carabayar_nama, namadepan_pasien, nama_pasien, jmlpendapatan, jmlpiutang, jmleksespasien, jmlnontunai', 'safe', 'on'=>'search'),
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
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'is_bkm' => 'Is Bkm',
			'is_bkk' => 'Is Bkk',
			'tanggal' => 'Tanggal',
			'no_bkm' => 'No. Bkm',
			'no_bkk' => 'No. BKK',
			'no_bukti' => 'No. Bukti',
			'keterangan' => 'Keterangan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'debit' => 'Debit',
			'kredit' => 'Kredit',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'namadepan_pasien' => 'Namadepan Pasien',
			'nama_pasien' => 'Nama Pasien',
			'jmlpendapatan' => 'Jmlpendapatan',
			'jmlpiutang' => 'Jmlpiutang',
			'jmleksespasien' => 'Jmleksespasien',
			'jmlnontunai' => 'Jmlnontunai',
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

		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('is_bkm',$this->is_bkm);
		$criteria->compare('is_bkk',$this->is_bkk);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('no_bkm',$this->no_bkm,true);
		$criteria->compare('no_bkk',$this->no_bkk,true);
		$criteria->compare('no_bukti',$this->no_bukti,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('kredit',$this->kredit);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('namadepan_pasien',$this->namadepan_pasien,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jmlpendapatan',$this->jmlpendapatan);
		$criteria->compare('jmlpiutang',$this->jmlpiutang);
		$criteria->compare('jmleksespasien',$this->jmleksespasien);
		$criteria->compare('jmlnontunai',$this->jmlnontunai);
		$criteria->limit  = 20;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getSaldoAwalClosing(){
		$cri = 	new CDbCriteria();
		$cri->select = " t.nilaiclosingtrans, sbd.setorbank_id ";
		$cri->join =	" LEFT JOIN	rinciansetoranbdhara_t rsb ON rsb.closingkasir_id = t.closingkasir_id "
					.	" LEFT JOIN	setoranbdhara_t sbd ON sbd.setoranbdhara_id = rsb.setoranbdhara_id "
					.	" LEFT JOIN setorbank_t sb ON sb.setorbank_id = sbd.setorbank_id ";  
		//$cri->addCondition(" sbd.setorbank_id IS NULL ");
		$cri->addCondition(" DATE(tglclosingkasir) = '".date('Y-m-d', strtotime($this->tgl_awal.' -1 days'))."' ");
		$cri->order = " tglclosingkasir DESC ";
				
		$getSaldo = ClosingkasirT::model()->find($cri);
		
		if (count((array)$getSaldo)>0){
			if (!empty($getSaldo->setorbank_id)){
				return 0;
			}else{
				return $getSaldo->nilaiclosingtrans;
			}
		}else{
			return 0;
		}		
	}
	
	public function getRekapClosing($instalasi='',$carabayar='',$jenis=''){
		$cri = 	new CDbCriteria();
		
		if ($jenis == 'pendapatan'){
			$cri->select = " sum(jmlpendapatan) as totaldata ";				
		}elseif ($jenis == 'ekses'){
			$cri->select = " sum(jmleksespasien) as totaldata ";				
		}elseif ($jenis == 'piutang'){
			$cri->select = " sum(jmlpiutang) as totaldata ";				
		}elseif ($jenis == 'tunai'){
			$cri->select = " sum(jmlnontunai) as totaldata ";				
		}
		if (is_array($instalasi)){
			$cri->addInCondition(" instalasi_id ",$instalasi);
		}
		if (!empty($carabayar)){
		
			$cri->addInCondition(" carabayar_id ",$carabayar);		
		}
		$cri->addBetweenCondition(" tanggal ", $this->tgl_awal, $this->tgl_akhir);
				
		$getSaldo = self::model()->find($cri);
						
		if (!empty($getSaldo->totaldata)){			
			return $getSaldo->totaldata;
		}else{
			return 0;
		}		
	}
	
	public function getKeteranganEkses($carabayar=''){
		$cri = 	new CDbCriteria();
				
		$cri->select = " sum(jmleksespasien) as totaldata, nama_pasien ";						
		$cri->group = " nama_pasien ";		
		if (!empty($carabayar)){
			$cri->addInCondition(" carabayar_id ",$carabayar);		
		}
		$cri->addBetweenCondition(" tanggal ", $this->tgl_awal, $this->tgl_akhir);
				
		$getSaldo = self::model()->findAll($cri);
						
		if (count((array)$getSaldo)){			
			$tr = '';
			foreach($getSaldo as $ket){
				if ($ket->totaldata != 0){
					$tr .= "<tr><td style='width:50%'>".$ket->nama_pasien."</td><td style='text-align:right'>". MyFormatter::formatNumberForPrint($ket->totaldata)."</td></tr>";
				}
			}			
			return $tr;
		}else{
			return '';
		}		
	}
		
	public function getRekapUangPelayanan(){
		$cri = 	new CDbCriteria();
		$cri->select = " closingkasir_id ";
		$cri->join =	" JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id ";  
		$cri->addCondition(" is_bkm = true AND tbb.closingkasir_id IS NOT NULL ");
		$cri->addBetweenCondition(" DATE(tanggal) ", $this->tgl_awal, $this->tgl_akhir);
		$cri->group = $cri->select;
		$getClosingKasirId = self::model()->findAll($cri);
		$closingkasir_id = array();
		
		if (count((array)$getClosingKasirId)>0){
			foreach ($getClosingKasirId as $id){
				$closingkasir_id[] = $id->closingkasir_id;
			}
		}
		
		$criRin = new CDbCriteria();
		$criRin->addInCondition('closingkasir_id', $closingkasir_id);
		$rincian = RincianclosingT::model()->findAll($criRin);
		
		$dtUang = array();
		if (count((array)$rincian)>0){			
			$dtUang['total']  = 0;
			foreach($rincian as $ket){					
				if (isset($dtUang[$ket->nilaiuang])){
					$dtUang[$ket->nilaiuang] = array(
						  'banyaknya' => $dtUang[$ket->nilaiuang]['banyaknya']+$ket->banyakuang,
						  'jumlahnya' => $dtUang[$ket->nilaiuang]['jumlahnya']+$ket->jumlahuang,
						  'nilaiuang' => $ket->nilaiuang
						//'jumlahnya' => 'asdasds'
						);
				}else{										
					$dtUang[$ket->nilaiuang] = array(
						  'banyaknya' => $ket->banyakuang,
						  'jumlahnya' => $ket->jumlahuang,
						  'nilaiuang' => $ket->nilaiuang
						);
				}
				
				$dtUang['total'] += $ket->jumlahuang;
			}	
			//var_dump($dtUang['total']);
			$dtUang['total'] = '<b>'.MyFormatter::formatNumberForPrint($dtUang['total']).'</b>';
			
			//var_dump($dtUang);
			//return $dtUang;
		}else{
			$nilaiuang = LookupM::model()->findAllByAttributes(array('lookup_type'=> Params::LOOKUPTYPE_NILAI_UANG, 'lookup_aktif'=>true),array('order'=>'lookup_urutan ASC'));
			
			foreach ($nilaiuang as $nilai){
				$dtUang[$nilai->lookup_value] = array(
					'banyaknya' => 0,
					'jumlahnya' => 0,
					'nilaiuang' => 0,
				);
			}
			$dtUang['total'] = '<b>0</b>';
		//	var_dump($dtUang);
			//return $dtUang;
		}						
		
		//var_dump($dtUang);
		return $dtUang;
	}
	
}