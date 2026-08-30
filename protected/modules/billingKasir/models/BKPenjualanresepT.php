<?php

class BKPenjualanresepT extends PenjualanresepT
{
        public $tgl_awal, $tgl_akhir,$tgl_awall, $tgl_akhirl, $no_identitas_pasien, $nama_pasien,$ceklis = false;
        
        /**
         * untuk handling grid view attribute no faktur dan tanda bukti bayar id pada module biling kasir informasi penjualan resep bebas / luar
         * @var string
         */
        public $noFaktur,$tandaBuktiBayar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalbayarsupplierT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'reseptur'=>array(self::BELONGS_TO, 'ResepturT', 'reseptur_id'),
                    'detailresep'=>array(self::HAS_MANY, 'ResepturdetailT', array('reseptur_id'=>'reseptur_id'), 'through'=>'reseptur'),
                    'obatalkes'=>array(self::HAS_MANY, 'ObatalkesM', array('obatalkes_id','obatalkes_id'), 'through'=>'detailresep'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'obatalkespasien'=>array(self::HAS_MANY, 'ObatalkespasienT', array('penjualanresep_id'=>'penjualanresep_id')),
		);
	}
        
        /**
         * handling untuk informasi penjualan bebas / luar di informasi biling kasir
         * @return \CActiveDataProvider
         */
        public function searchPenjualanBebasLuar(){
            $criteria = new CDbCriteria();
            if($this->ceklis ==1)
            {
                $criteria->addBetweenCondition('DATE(pasien.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
            }
            else{
                if(!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {     
                
                    $criteria->addBetweenCondition('DATE(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
                }
            }
            $criteria->with = array('obatalkespasien','pasien');
            //$criteria->addBetweenCondition('DATE(tglpenjualan)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('noresep',$this->noresep);
            $criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
            // $criteria->compare('jenispenjualan','PENJUALAN RESEP', false, 'AND not');
            $criteria->addCondition('t.noresep is not null');
            $criteria->compare('pasien.no_identitas_pasien', $this->no_identitas_pasien);
		    $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
           
            // $criteria->join = 'JOIN '
            
            return new CActiveDataProvider($this, array('criteria'=>$criteria));
        }
        
        /**
         * handling no faktur relasi penjualan resep di pakai d informasi penjualan bebas luar module biling kasir
         * @return string
         */
        public function getNoFaktur(){
            $criteria = new CDbCriteria();
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);					
			}
            $criteria->addCondition('oasudahbayar_id is null');
            $jumlahObatAlkesPasien = ObatalkespasienT::model()->count($criteria);
            if (!(boolean)$jumlahObatAlkesPasien){
                $noFaktur = ObatalkespasienT::model()->findByAttributes(array('penjualanresep_id'=>$this->penjualanresep_id))->oasudahbayar->pembayaranpelayanan;
                $this->tandaBuktiBayar = $noFaktur->tandabuktibayar_id;
                return $noFaktur->nopembayaran;
            }
        }
        /**
         * handling no BKM relasi penjualan resep di pakai d informasi penjualan bebas luar module biling kasir
         * @return string
         */
        public function getNoBkm(){
            return TandabuktibayarT::model()->findByPk($this->tandaBuktiBayar)->nobuktibayar;
        }
        
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, carabayar_id, ruangan_id, pasien_id, tglpenjualan, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'required'),
			array('reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, lamapelayanan', 'numerical', 'integerOnly'=>true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'numerical'),
			array('jenispenjualan, instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
			array('noresep', 'length', 'max'=>50),
			array('tglresep, update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('tgl_awal, tgl_akhir, create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, penjualanresep_id, reseptur_id, pasienadmisi_id, penjamin_id, carabayar_id, pendaftaran_id, ruangan_id, pegawai_id, kelaspelayanan_id, pasien_id, tglpenjualan, jenispenjualan, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}
}