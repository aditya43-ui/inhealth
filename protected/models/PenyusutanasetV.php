<?php

/**
 * This is the model class for table "penyusutanaset_v".
 *
 * The followings are the available columns in table 'penyusutanaset_v':
 * @property integer $penyusutanaset_id
 * @property string $tgl_penyusutan
 * @property string $no_penyusutan
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property double $barang_harganetto
 * @property double $barang_persendiskon
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property double $barang_hargajual
 * @property integer $invgedung_id
 * @property string $invgedung_kode
 * @property string $invgedung_noregister
 * @property integer $invjalan_id
 * @property string $invjalan_kode
 * @property string $invjalan_noregister
 * @property integer $invasetlain_id
 * @property string $invasetlain_kode
 * @property string $invasetlain_noregister
 * @property integer $invtanah_id
 * @property string $invtanah_kode
 * @property string $invtanah_noregister
 * @property integer $invperalatan_id
 * @property string $invperalatan_kode
 * @property string $invperalatan_noregister
 * @property double $hargaperolehan
 * @property double $residu
 * @property double $umurekonomis
 * @property double $totalpenyusutan
 * @property integer $penyusutanasetdetail_id
 * @property integer $penyusutanaset_urutan
 * @property string $penyusutanaset_periode
 * @property double $penyusutanaset_saldo
 * @property double $penyusutanaset_persentase
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenyusutanasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyusutanasetV the static model class
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
		return 'penyusutanaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyusutanaset_id, barang_id, barang_ekonomis_thn, barang_jmldlmkemasan, invgedung_id, invjalan_id, invasetlain_id, invtanah_id, invperalatan_id, penyusutanasetdetail_id, penyusutanaset_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, hargaperolehan, residu, umurekonomis, totalpenyusutan, penyusutanaset_saldo, penyusutanaset_persentase', 'numerical'),
			array('no_penyusutan', 'length', 'max'=>25),
			array('barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, invgedung_kode, invgedung_noregister, invjalan_kode, invjalan_noregister, invasetlain_kode, invasetlain_noregister, invtanah_kode, invtanah_noregister, invperalatan_kode, invperalatan_noregister, penyusutanaset_periode', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('tgl_penyusutan, barang_statusregister, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyusutanaset_id, tgl_penyusutan, no_penyusutan, barang_id, barang_type, barang_kode, barang_nama, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, invgedung_id, invgedung_kode, invgedung_noregister, invjalan_id, invjalan_kode, invjalan_noregister, invasetlain_id, invasetlain_kode, invasetlain_noregister, invtanah_id, invtanah_kode, invtanah_noregister, invperalatan_id, invperalatan_kode, invperalatan_noregister, hargaperolehan, residu, umurekonomis, totalpenyusutan, penyusutanasetdetail_id, penyusutanaset_urutan, penyusutanaset_periode, penyusutanaset_saldo, penyusutanaset_persentase, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penyusutanaset_id' => 'Penyusutanaset',
			'tgl_penyusutan' => 'Tanggal Penyusutan',
			'no_penyusutan' => 'No Penyusutan',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_ekonomis_thn' => 'Barang Ekonomis Thn',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
			'barang_image' => 'Barang Image',
			'barang_harganetto' => 'Barang Harganetto',
			'barang_persendiskon' => 'Barang Persendiskon',
			'barang_ppn' => 'Barang Ppn',
			'barang_hpp' => 'Barang Hpp',
			'barang_hargajual' => 'Barang Hargajual',
			'invgedung_id' => 'Invgedung',
			'invgedung_kode' => 'Invgedung Kode',
			'invgedung_noregister' => 'Invgedung Noregister',
			'invjalan_id' => 'Invjalan',
			'invjalan_kode' => 'Invjalan Kode',
			'invjalan_noregister' => 'Invjalan Noregister',
			'invasetlain_id' => 'Invasetlain',
			'invasetlain_kode' => 'Invasetlain Kode',
			'invasetlain_noregister' => 'Invasetlain Noregister',
			'invtanah_id' => 'Invtanah',
			'invtanah_kode' => 'Invtanah Kode',
			'invtanah_noregister' => 'Invtanah Noregister',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_kode' => 'Invperalatan Kode',
			'invperalatan_noregister' => 'Invperalatan Noregister',
			'hargaperolehan' => 'Harga Perolehan',
			'residu' => 'Residu',
			'umurekonomis' => 'Umur Ekonomis',
			'totalpenyusutan' => 'Total Penyusutan',
			'penyusutanasetdetail_id' => 'Penyusutanasetdetail',
			'penyusutanaset_urutan' => 'Penyusutanaset Urutan',
			'penyusutanaset_periode' => 'Penyusutan Aset Periode',
			'penyusutanaset_saldo' => 'Penyusutan Aset Saldo',
			'penyusutanaset_persentase' => 'Penyusutan Aset Persentase',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->penyusutanaset_id)){
			$criteria->addCondition('penyusutanaset_id = '.$this->penyusutanaset_id);
		}
		$criteria->compare('LOWER(tgl_penyusutan)',strtolower($this->tgl_penyusutan),true);
		$criteria->compare('LOWER(no_penyusutan)',strtolower($this->no_penyusutan),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('hargaperolehan',$this->hargaperolehan);
		$criteria->compare('residu',$this->residu);
		$criteria->compare('umurekonomis',$this->umurekonomis);
		$criteria->compare('totalpenyusutan',$this->totalpenyusutan);
		if(!empty($this->penyusutanasetdetail_id)){
			$criteria->addCondition('penyusutanasetdetail_id = '.$this->penyusutanasetdetail_id);
		}
		if(!empty($this->penyusutanaset_urutan)){
			$criteria->addCondition('penyusutanaset_urutan = '.$this->penyusutanaset_urutan);
		}
		$criteria->compare('LOWER(penyusutanaset_periode)',strtolower($this->penyusutanaset_periode),true);
		$criteria->compare('penyusutanaset_saldo',$this->penyusutanaset_saldo);
		$criteria->compare('penyusutanaset_persentase',$this->penyusutanaset_persentase);
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
}