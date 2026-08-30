<?php

/**
 * This is the model class for table "stokobatalkes_t".
 *
 * The followings are the available columns in table 'stokobatalkes_t':
 * 
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 * 
 * @property integer $stokobatalkes_id
 * @property integer $ruangan_id
 * @property integer $penerimaandetail_id
 * @property integer $terimamutasidetail_id
 * @property integer $returresepdet_id
 * @property integer $returdetail_id
 * @property integer $mutasioadetail_id
 * @property integer $obatalkespasien_id
 * @property integer $pemusnahanoadet_id
 * @property integer $stokopnamedet_id
 * @property integer $obatalkes_id
 * @property string $tglkadaluarsa
 * @property string $nobatch
 * @property string $tglstok_in
 * @property string $tglstok_out
 * @property double $qtystok_in
 * @property double $qtystok_out
 * @property double $harganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $persenppn
 * @property double $persenpph
 * @property double $persenmargin
 * @property double $jmlmargin
 * @property boolean $stokoa_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $stokobatalkesasal_id
 * @property integer $satuankecil_id
 * @property string $tglterima
 *
 * The followings are the available model relations:
 * @property MutasioadetailT $mutasioadetail
 * @property ObatalkesM $obatalkes
 * @property ObatalkespasienT $obatalkespasien
 * @property PemusnahanoadetailT $pemusnahanoadet
 * @property PenerimaandetailT $penerimaandetail
 * @property ReturresepdetT $returresepdet
 * @property RuanganM $ruangan
 * @property SatuankecilM $satuankecil
 * @property StokobatalkesT $stokobatalkesasal
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property StokopnamedetT $stokopnamedet
 * @property TerimamutasidetailT $terimamutasidetail
 * @property ReturdetailT $returdetail
 */
class StokobatalkesT extends CActiveRecord
{
	public $qtystok; //jumlah stok tersedia
	public $qtystok_terpakai; //jumlah stok yg terpakai
	public $hpp; //harga netto + ppn + pph = HPP
	public $hargajual; //harga HPP + margin
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokobatalkesT the static model class
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
		return 'stokobatalkes_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, obatalkes_id, tglkadaluarsa, create_time, create_loginpemakai_id, create_ruangan, satuankecil_id, tglterima', 'required'),
			array('ruangan_id, penerimaandetail_id, terimamutasidetail_id, returresepdet_id, returdetail_id, mutasioadetail_id, obatalkespasien_id, pemusnahanoadet_id, stokopnamedet_id, obatalkes_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, stokobatalkesasal_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('qtystok_in, qtystok_out, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin', 'numerical'),
			array('nobatch', 'length', 'max'=>50),
			array('sumberdana_id, tglstok_in, tglstok_out, stokoa_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokobatalkes_id, ruangan_id, penerimaandetail_id, terimamutasidetail_id, returresepdet_id, returdetail_id, mutasioadetail_id, obatalkespasien_id, pemusnahanoadet_id, stokopnamedet_id, obatalkes_id, tglkadaluarsa, nobatch, tglstok_in, tglstok_out, qtystok_in, qtystok_out, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin, stokoa_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, stokobatalkesasal_id, satuankecil_id, tglterima', 'safe', 'on'=>'search'),
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
			'mutasioadetail' => array(self::BELONGS_TO, 'MutasioadetailT', 'mutasioadetail_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'obatalkespasien' => array(self::BELONGS_TO, 'ObatalkespasienT', 'obatalkespasien_id'),
			'pemusnahanoadet' => array(self::BELONGS_TO, 'PemusnahanoadetailT', 'pemusnahanoadet_id'),
			'penerimaandetail' => array(self::BELONGS_TO, 'PenerimaandetailT', 'penerimaandetail_id'),
			'retpendetail' => array(self::BELONGS_TO, 'ReturdetailT', 'returdetail_id'),
			'returresepdet' => array(self::BELONGS_TO, 'ReturresepdetT', 'returresepdet_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'stokobatalkesasal' => array(self::BELONGS_TO, 'StokobatalkesT', 'stokobatalkesasal_id'),
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'stokobatalkesasal_id'),
			'stokopnamedet' => array(self::BELONGS_TO, 'StokopnamedetT', 'stokopnamedet_id'),
			'terimamutasidetail' => array(self::BELONGS_TO, 'TerimamutasidetailT', 'terimamutasidetail_id'),
			'returdetail' => array(self::BELONGS_TO, 'ReturdetailT', 'returdetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stokobatalkes_id' => 'Stokobatalkes',
			'ruangan_id' => 'Ruangan',
			'penerimaandetail_id' => 'Penerimaandetail',
			'terimamutasidetail_id' => 'Terimamutasidetail',
			'returresepdet_id' => 'Returresepdet',
			'returdetail_id' => 'Returdetail',
			'mutasioadetail_id' => 'Mutasioadetail',
			'obatalkespasien_id' => 'Obatalkespasien',
			'pemusnahanoadet_id' => 'Pemusnahanoadet',
			'stokopnamedet_id' => 'Stokopnamedet',
			'obatalkes_id' => 'Obatalkes',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'nobatch' => 'Nobatch',
			'tglstok_in' => 'Tglstok In',
			'tglstok_out' => 'Tglstok Out',
			'qtystok_in' => 'Qtystok In',
			'qtystok_out' => 'Qtystok Out',
			'harganetto' => 'Harganetto',
			'persendiscount' => 'Persen Keringanan',
			'jmldiscount' => 'Jumlah Keringanan',
			'persenppn' => 'Persenppn',
			'persenpph' => 'Persenpph',
			'persenmargin' => 'Persenmargin',
			'jmlmargin' => 'Jmlmargin',
			'stokoa_aktif' => 'Stokoa Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'stokobatalkesasal_id' => 'Stokobatalkesasal',
			'satuankecil_id' => 'Satuankecil',
			'tglterima' => 'Tglterima',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penerimaandetail_id',$this->penerimaandetail_id);
		$criteria->compare('terimamutasidetail_id',$this->terimamutasidetail_id);
		$criteria->compare('returresepdet_id',$this->returresepdet_id);
		$criteria->compare('returdetail_id',$this->returdetail_id);
		$criteria->compare('mutasioadetail_id',$this->mutasioadetail_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('pemusnahanoadet_id',$this->pemusnahanoadet_id);
		$criteria->compare('stokopnamedet_id',$this->stokopnamedet_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('persenmargin',$this->persenmargin);
		$criteria->compare('jmlmargin',$this->jmlmargin);
		$criteria->compare('stokoa_aktif',$this->stokoa_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->stokobatalkesasal_id)){
			$criteria->addCondition('stokobatalkesasal_id = '.$this->stokobatalkesasal_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		/**
         * menampilkan jumlah stok terakhir
         */
        public static function getJumlahStok($obatalkes_id, $ruangan_id = null, $sumberdana_id = null){
            $criteria = new CDbCriteria();
            $criteria->select = "sum(qtystok_in) AS qtystok_in, sum(qtystok_out) AS qtystok_out";
            //$criteria->addCondition('stokoa_aktif IS TRUE');            
            if(!empty($ruangan_id)){
                    $criteria->addCondition("ruangan_id = ".$ruangan_id);
            }
//            RSPMC-1012
//            penambahan sumberdana_id, karena dibedakan dengan sumber dana.
            if(!empty($sumberdana_id)){
		$criteria->addCondition("sumberdana_id = ".$sumberdana_id);
            }
            
            $criteria->addCondition('obatalkes_id = '.$obatalkes_id);
//            if (!empty($tglkadaluarsa)){
//                $criteria->addCondition("tglkadaluarsa = '".$tglkadaluarsa."' ");
//            }
            $criteria->group = "obatalkes_id, ruangan_id";            
            $model = InfostokobatalkesruanganV::model()->find($criteria);
            $qtystok_in = (!empty($model->qtystok_in)? $model->qtystok_in:0);
            $qtystok_out = (!empty($model->qtystok_out)? $model->qtystok_out:0);

            return ($qtystok_in - $qtystok_out);
            // if(isset($model->qtystok)){
            //     return $model->qtystok;
            // }else{
            //     return 0;
            // }
        }
		/**
         * menampilkan jumlah stok terakhir
		 * berdasarkan stokobatalkes_id
         */
        public static function getJumlahStokBatch($stokobatalkes_id){
            $criteria = new CDbCriteria();
            $criteria->addCondition('stokoa_aktif IS TRUE');
            $criteria->addCondition('stokobatalkes_id = '.$stokobatalkes_id);
            $criteria->addCondition('stokobatalkesasal_id = '.$stokobatalkes_id,"OR");
            $criteria->group = "obatalkes_id, nobatch";
            $criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok";
            $model = StokobatalkesT::model()->find($criteria);
            if(isset($model->qtystok)){
                return $model->qtystok;
            }else{
                return 0;
            }
        }
        /**
         * menampilkan data stokobatalkes_t (PENYESUAIAN)
         * @param int $obatalkes_id
         * @param int $qty (jumlah yg akan dikeluarkan)
         * @param int $ruangan_id (stok ruangan / jika null maka mnenggunakan stok sembarang ruangan)
         * @return array StokobatalkesT (jika stok tidak mencukupi return = null)
         * - MIN(stokobatalkes_id) untuk menampilkan stokobatalkes_id penerimaan (dari supplier) atau stokopname
         */
        public static function getStokObatAlkesAktif($obatalkes_id, $qty, $ruangan_id=null, $sumberdana_id=null){
            $metodeantrian = Yii::app()->user->getState('metodeantrian');
            $stok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id, $sumberdana_id);
            if($qty <= $stok){
                $criteria = new CDbCriteria();
                // $criteria->addCondition('t.stokoa_aktif IS TRUE');
                $criteria->addCondition('t.obatalkes_id = '.$obatalkes_id);
                $criteria->compare('t.ruangan_id',$ruangan_id);
                if(!empty($sumberdana_id)){
                    $criteria->addCondition('t.sumberdana_id = '.$sumberdana_id);
                }
                $criteria->group = 't.tglterima, t.satuankecil_id, t.tglstok_in, t.obatalkes_id, t.tglkadaluarsa, t.ruangan_id, t.harganetto, t.persendiscount, t.jmldiscount, t.persenppn, t.persenpph, t.persenmargin, t.jmlmargin, t.nobatch';
                $criteria->select = $criteria->group.', MIN(t.stokobatalkes_id) AS stokobatalkes_id, MIN(t.stokobatalkesasal_id) AS stokobatalkesasal_id, SUM(qtystok_in) AS qtystok_in,  SUM(qtystok_out) AS qtystok_out, SUM(qtystok_in-qtystok_out) AS qtystok';
                //ACUAN FIFO / LIFO = tglterima (dari supplier) bukan tglstok_in (KHUSUS TARAKAN)
                if($metodeantrian == Params::METODEANTRIAN_FIFO){
                    $criteria->order = "t.tglterima ASC, t.tglstok_in ASC";
                }else if($metodeantrian == Params::METODEANTRIAN_FEFO){
                    $criteria->order = "t.tglkadaluarsa ASC, t.tglterima ASC, t.tglstok_in ASC";
                }else if($metodeantrian == Params::METODEANTRIAN_LIFO){
                    $criteria->order = "t.tglterima DESC, t.tglstok_in DESC";
                }
                $models = StokobatalkesT::model()->findAll($criteria);
                $qtysisa = 0;
                $end = false;
                //menentukan stokobatalkes yg akan digunakan
                $modStokOaTerpakais = array();
                if(count((array)$models) > 0){
                    foreach($models AS $i => $model){
                        if(($model->qtystok_in - $model->qtystok_out) > 0){
                            if($qtysisa > 0){ //jika ada sisa
                                $qty = $qtysisa;
                            }

                            $selisih = $model->qtystok_in - ($model->qtystok_out + $qty);

                            if($selisih == 0){ //Jika selisih 0
                                $model->qtystok_terpakai = $qty;
                                $qtysisa = 0;
                                $end = true;
                            }else{
                                if($selisih > 0){ //jika selisih positif
                                    $model->qtystok_terpakai = $qty;
                                    $end = true;
                                }else{ //jika selisih negatif
                                    $model->qtystok_terpakai = $model->qtystok;
                                    $qtysisa = abs($selisih);
                                }
                            }

                            $modStokOaTerpakais[$i] = $model;
                            $modStokOaTerpakais[$i]->qtystok_terpakai = $model->qtystok_terpakai;
                            if($end) break;
                        }
                    }
                }
                
                if(count((array)$modStokOaTerpakais) > 0){
                    return $modStokOaTerpakais;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
		/**
		 * kosongkan dahulu semua id transaksi karna harus diisi salah satu
		 * RND-8085
		 */
		public function unsetIdTransaksi(){
			$this->stokobatalkes_id = null;
			$this->penerimaandetail_id = null;
			$this->terimamutasidetail_id = null;
			$this->returresepdet_id = null;
			$this->returdetail_id = null;
			$this->mutasioadetail_id = null;
			$this->obatalkespasien_id = null;
			$this->pemusnahanoadet_id = null;
			$this->stokopnamedet_id = null;
			$this->pemakaianobatdetail_id = null;
		}
        // /
        // public function getHPP(){
        //     $hpp = $this->harganetto - ($this->harganetto * $this->persendiscount / 100); //di persendiscount dan jmldiscount HARUS salahsatu
        //     if ($this->persenppn > 0){
        //         $hpp = ($hpp + ($hpp * ($this->persenppn/100)));
        //     }
        //     if($this->persenpph > 0){
        //         $hpp = ($hpp + ($hpp * ($this->persenpph/100)));
        //     }
        //     return $hpp;
        // }
        
        /**
         * menampilkan harga netto apotek
         * @return type
         */
        public function getHPP(){
            $hpp = $this->harganetto - ($this->harganetto * $this->persendiscount / 100); //di persendiscount dan jmldiscount HARUS salahsatu
            if ($this->persenppn > 0){
                $hpp = ($hpp + ($hpp * ($this->persenppn/100)));
            }
            if($this->persenpph > 0){
                $hpp = ($hpp + ($hpp * ($this->persenpph/100)));
            }
            return $hpp;
        }
        
        /**
         * menampilkan harga jual satuan
         * @return type
         */
        public function getHargaJualSatuan(){
			$hargajual = 0;
			if(Yii::app()->user->getState('hargaygdigunakan') == Params::HARGAYGDIGUNAKAN_PENYESUAIAN){
				if($this->persenmargin > 0){
					$hargajual = ($this->HPP + ($this->HPP * ($this->persenmargin / 100)));
				}else{
					$hargajual = $this->HPP + $this->jmlmargin;
				}
			}else{
				$modObat = ObatalkesM::model()->findByPk($this->obatalkes_id);
				if(Yii::app()->user->getState('hargaygdigunakan') == Params::HARGAYGDIGUNAKAN_MAX){
					$hargajual = $modObat->hargamaksimum;
				}else if(Yii::app()->user->getState('hargaygdigunakan') == Params::HARGAYGDIGUNAKAN_MIN){
					$hargajual = $modObat->hargaminimum;
				}else if(Yii::app()->user->getState('hargaygdigunakan') == Params::HARGAYGDIGUNAKAN_AVG){
					$hargajual = $modObat->hargaaverage;
				}else if(Yii::app()->user->getState('hargaygdigunakan') == Params::HARGAYGDIGUNAKAN_TERAKHIR){
					$hargajual = $modObat->hargajual;
				}
			}
            return $hargajual;
        }
		
		/**
         * menampilkan harga jual satuan
         * @return type
         */
        public function getHargaJualSatuanSesuaiTransaksi(){
			$hargajual = 0;
			
			if($this->persenmargin > 0){
				$hargajual = ($this->HPP + ($this->HPP * ($this->persenmargin / 100)));
			}else{
				$hargajual = $this->HPP + $this->jmlmargin;
			}
			
            return $hargajual;
        }
		
        /**
         * menampilkan stokoa_aktif berdasarkan stokobatalkesasal_id (in - out)
         * @return true or false
         */
        public function setStokOaAktifBerdasarkanStok(){
            $return = true;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $criteria = new CDbCriteria();
            $criteria->condition = "(stokobatalkes_id = ".$this->stokobatalkesasal_id." OR stokobatalkesasal_id = ".$this->stokobatalkesasal_id.") AND ruangan_id = ".$ruangan_id;
            $criteria->select = "MIN(stokobatalkes_id), SUM(qtystok_in - qtystok_out) AS qtystok";
            $qtystokout = self::model()->find($criteria)->qtystok;
            
            if($qtystokout <= 0){ //stok habis
                $return = self::model()->updateByPk($this->stokobatalkesasal_id, array('stokoa_aktif'=>0));
                $return &= self::model()->updateAll(array('stokoa_aktif'=>0), 'stokobatalkesasal_id = '.$this->stokobatalkesasal_id);
            }
            return $return;
        }
        /**
         * memvalidasi stok (in-out)
         */
        public function validateStok(){
            $criteria = new CDbCriteria();
            $criteria->group = "obatalkes_id";
            $criteria->select = $criteria->group.", MIN(stokobatalkes_id) AS stokobatalkes_id, SUM(qtystok_in) AS qtystok_in, SUM(qtystok_out) AS qtystok_out, SUM(qtystok_in-qtystok_out) AS qtystok";
            $criteria->condition = "(stokobatalkes_id = ".$this->stokobatalkesasal_id." OR stokobatalkesasal_id = ".$this->stokobatalkesasal_id.") AND ruangan_id = ".$this->ruangan_id;
            $modStok = self::model()->find($criteria);
            
            if($modStok->qtystok < 0){ //jika minus
                return false;
            }else{
                return true;
            }
        }
        /**
         * menampilkan jumlah stok berdasarkan obatalkes_id
         */
        public static function getJumlahStokOaTersimpan($obatalkespasien_id){
            $criteria = new CDbCriteria();
            $criteria->addCondition('stokoa_aktif IS TRUE');
            $criteria->addCondition('obatalkespasien_id = '.$obatalkespasien_id);
            $model = self::model()->find($criteria);
            if(isset($model->stokobatalkesasal_id)){
                $criteria2 = new CDbCriteria();
                $criteria2->condition = 'stokobatalkes_id = '.$model->stokobatalkesasal_id.""
                        . " OR stokobatalkesasal_id = ".$model->stokobatalkesasal_id."";
                $criteria2->select = "sum(qtystok_in - qtystok_out) as qtystok";
                $criteria2->group = 'obatalkes_id';
                $stok = self::model()->find($criteria2);
                
                return $stok->qtystok;
                
            }else{
                return 0;
            }
        }
		
        /**
         * menampilkan jumlah stok berdasarkan pemakaianobatdetail_id
         */
        public static function getJumlahStokOaPemakaianTersimpan($pemakaianobatdetail_id){
            $criteria = new CDbCriteria();
            $criteria->addCondition('stokoa_aktif IS TRUE');
            $criteria->addCondition('pemakaianobatdetail_id = '.$pemakaianobatdetail_id);
            $model = self::model()->find($criteria);
            if(isset($model->stokobatalkesasal_id)){
                $criteria2 = new CDbCriteria();
                $criteria2->condition = 'stokobatalkes_id = '.$model->stokobatalkesasal_id.""
                        . " OR stokobatalkesasal_id = ".$model->stokobatalkesasal_id."";
                $criteria2->select = "sum(qtystok_in - qtystok_out) as qtystok";
                $criteria2->group = 'obatalkes_id';
                $stok = self::model()->find($criteria2);
                
                return $stok->qtystok;
                
            }else{
                return 0;
            }
        }
		
		/**
         * menampilkan jumlah stok terakhir
         */
        public static function getTanggalKadaluarsaBerdasarkanStok($obatalkes_id, $ruangan_id = null, $qty_jual = null){
			$group = '';
			$data = array();
			
            $criteria = new CDbCriteria();
            $criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok, tglkadaluarsa ";
            
            if(!empty($ruangan_id)){
                    $criteria->addCondition("ruangan_id = ".$ruangan_id);
					$group .= ', ruangan_id ';
            }
			
            $criteria->addCondition('obatalkes_id = '.$obatalkes_id);
            			
			$criteria->group = "obatalkes_id, tglkadaluarsa".$group;            
			$criteria->order = " tglkadaluarsa ASC ";
            $model = InfostokobatalkesruanganV::model()->findAll($criteria);
			
			if (count((array)$model)>0){
				$qty = $qty_jual;
				foreach ($model as $det){					
					if ($det->qtystok > 0 ){						
						if ($det->qtystok <= $qty){
							$qty = $qty - $det->qtystok;								
						}else{
							$qty = $qty;
						}
						
						if ($qty >= 0){
							$data[] = array( 
								'tglkadaluarsa' => $det->tglkadaluarsa,
								'stok' => $det->qtystok,
								'out'=>$qty
								);
						}
						
					//	goto loncat;
					}
				}
			}
			
			//loncat:
            
			return $data;
        }
		
		/**
         * menampilkan jumlah stok terakhir
         */
        public static function getTanggalKadaluarsaStok($obatalkes_id, $ruangan_id = null){
			$group = '';
			$data = '';
			
            $criteria = new CDbCriteria();
            $criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok, tglkadaluarsa ";
           
            if(!empty($ruangan_id)){
                    $criteria->addCondition("ruangan_id = ".$ruangan_id);
					$group .= ', ruangan_id ';
            }
			
            $criteria->addCondition('obatalkes_id = '.$obatalkes_id);
            			
			$criteria->group = "obatalkes_id, tglkadaluarsa".$group;            
			$criteria->order = " tglkadaluarsa ASC ";
            $model = InfostokobatalkesruanganV::model()->findAll($criteria);
			
			if (count((array)$model)>0){				
				foreach ($model as $det){
					if ($det->qtystok > 0 ){		
						if ($det->tglkadaluarsa >= date('Y-m-d') ){
							$data = $det->tglkadaluarsa;																		
							goto loncat;							
						}else{
							
						}
					}
				}
			}
			loncat:
                
            if (empty($data)) {
                $oa = ObatalkesM::model()->findByPk($obatalkes_id);
                $data = $oa->tglkadaluarsa;
            }
            
			return $data;
        }
		
		/**
         * menampilkan jumlah stok terakhir
         */
        public static function getTanggalKadaluarsaPrev($obatalkes_id, $ruangan_id = null){
			$group = '';
			$data = '';
			
            $criteria = new CDbCriteria();
            $criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok, tglkadaluarsa ";
            
            if(!empty($ruangan_id)){
                    $criteria->addCondition("ruangan_id = ".$ruangan_id);
					$group .= ', ruangan_id ';
            }
			
            $criteria->addCondition('obatalkes_id = '.$obatalkes_id);
            			
			$criteria->group = "obatalkes_id, tglkadaluarsa".$group;            
			$criteria->order = " tglkadaluarsa ASC ";
            $model = InfostokobatalkesruanganV::model()->findAll($criteria);
			
			if (count((array)$model)>0){				
				foreach ($model as $det){
					if ($det->qtystok > 0 ){		
						if ($det->tglkadaluarsa >= date('Y-m-d') ){
							
							
						}else{
							$data = MyFormatter::formatDateTimeForUser($det->tglkadaluarsa);
							goto loncat;		
						}
					}
				}
			}
			loncat:
            
			return $data;
        }
        
    public static function notifStokOALewatMinimalRuangan($obatalkes_id, $ruangan_id) {
        $oa = ObatalkesM::model()->findByPk($obatalkes_id);
        $stok = self::getJumlahStok($obatalkes_id, $ruangan_id);
        
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        
        if (!empty($oa->minimalstok) && $stok <= $oa->minimalstok) {
            $judul = "Stok Obat sudah melewati Stok Minimal";
            $isi = $oa->obatalkes_nama." - ".$stok." ".$oa->satuankecil->satuankecil_nama;
            
            CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$ruangan->instalasi_id, 'ruangan_id'=>$ruangan->ruangan_id, 'modul_id'=>$ruangan->modul_id),                   
            ));
        }
    }
}