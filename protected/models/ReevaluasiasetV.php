<?php

/**
 * This is the model class for table "reevaluasiaset_v".
 *
 * The followings are the available columns in table 'reevaluasiaset_v':
 * @property integer $reevaluasiaset_id
 * @property string $reevaluasiaset_tgl
 * @property string $reevaluasiaset_no
 * @property integer $reevaluasiasetdetail_id
 * @property integer $barang_id
 * @property integer $bidang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_namalainnya
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
 * @property integer $invtanah_id
 * @property string $invtanah_kode
 * @property string $invtanah_noregister
 * @property integer $invasetlain_id
 * @property string $invasetlain_kode
 * @property string $invasetlain_noregister
 * @property integer $invgedung_id
 * @property string $invgedung_kode
 * @property string $invgedung_noregister
 * @property integer $invperalatan_id
 * @property string $invperalatan_kode
 * @property string $invperalatan_noregister
 * @property integer $invjalan_id
 * @property string $invjalan_kode
 * @property string $invjalan_noregister
 * @property double $reevaluasiaset_umurekonomis
 * @property double $reevaluasiaset_nilaibuku
 * @property double $reevaluasiaset_hargaperolehan
 * @property double $reevaluasiaset_selisihreevaluasi
 * @property double $reevaluasiaset_totalselisih
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ReevaluasiasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReevaluasiasetV the static model class
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
		return 'reevaluasiaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reevaluasiaset_id, reevaluasiasetdetail_id, barang_id, bidang_id, barang_ekonomis_thn, barang_jmldlmkemasan, invtanah_id, invasetlain_id, invgedung_id, invperalatan_id, invjalan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, reevaluasiaset_umurekonomis, reevaluasiaset_nilaibuku, reevaluasiaset_hargaperolehan, reevaluasiaset_selisihreevaluasi, reevaluasiaset_totalselisih', 'numerical'),
			array('reevaluasiaset_no', 'length', 'max'=>25),
			array('barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, invtanah_kode, invtanah_noregister, invasetlain_kode, invasetlain_noregister, invgedung_kode, invgedung_noregister, invperalatan_kode, invperalatan_noregister, invjalan_kode, invjalan_noregister', 'length', 'max'=>50),
			array('barang_nama, barang_namalainnya', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('reevaluasiaset_tgl, barang_statusregister, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reevaluasiaset_id, reevaluasiaset_tgl, reevaluasiaset_no, reevaluasiasetdetail_id, barang_id, bidang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, invtanah_id, invtanah_kode, invtanah_noregister, invasetlain_id, invasetlain_kode, invasetlain_noregister, invgedung_id, invgedung_kode, invgedung_noregister, invperalatan_id, invperalatan_kode, invperalatan_noregister, invjalan_id, invjalan_kode, invjalan_noregister, reevaluasiaset_umurekonomis, reevaluasiaset_nilaibuku, reevaluasiaset_hargaperolehan, reevaluasiaset_selisihreevaluasi, reevaluasiaset_totalselisih, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'reevaluasiaset_id' => 'Reevaluasiaset',
			'reevaluasiaset_tgl' => 'Reevaluasiaset Tgl',
			'reevaluasiaset_no' => 'No. Re-evaluasi',
			'reevaluasiasetdetail_id' => 'Reevaluasiasetdetail',
			'barang_id' => 'Barang',
			'bidang_id' => 'Bidang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_namalainnya' => 'Barang Namalainnya',
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
			'invtanah_id' => 'Invtanah',
			'invtanah_kode' => 'Invtanah Kode',
			'invtanah_noregister' => 'Invtanah Noregister',
			'invasetlain_id' => 'Invasetlain',
			'invasetlain_kode' => 'Invasetlain Kode',
			'invasetlain_noregister' => 'Invasetlain Noregister',
			'invgedung_id' => 'Invgedung',
			'invgedung_kode' => 'Invgedung Kode',
			'invgedung_noregister' => 'Invgedung Noregister',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_kode' => 'Invperalatan Kode',
			'invperalatan_noregister' => 'Invperalatan Noregister',
			'invjalan_id' => 'Invjalan',
			'invjalan_kode' => 'Invjalan Kode',
			'invjalan_noregister' => 'Invjalan Noregister',
			'reevaluasiaset_umurekonomis' => 'Reevaluasiaset Umurekonomis',
			'reevaluasiaset_nilaibuku' => 'Reevaluasiaset Nilaibuku',
			'reevaluasiaset_hargaperolehan' => 'Reevaluasiaset Hargaperolehan',
			'reevaluasiaset_selisihreevaluasi' => 'Reevaluasiaset Selisihreevaluasi',
			'reevaluasiaset_totalselisih' => 'Reevaluasiaset Totalselisih',
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

		if(!empty($this->reevaluasiaset_id)){
			$criteria->addCondition('reevaluasiaset_id = '.$this->reevaluasiaset_id);
		}
		$criteria->compare('LOWER(reevaluasiaset_tgl)',strtolower($this->reevaluasiaset_tgl),true);
		$criteria->compare('LOWER(reevaluasiaset_no)',strtolower($this->reevaluasiaset_no),true);
		if(!empty($this->reevaluasiasetdetail_id)){
			$criteria->addCondition('reevaluasiasetdetail_id = '.$this->reevaluasiasetdetail_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
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
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('reevaluasiaset_umurekonomis',$this->reevaluasiaset_umurekonomis);
		$criteria->compare('reevaluasiaset_nilaibuku',$this->reevaluasiaset_nilaibuku);
		$criteria->compare('reevaluasiaset_hargaperolehan',$this->reevaluasiaset_hargaperolehan);
		$criteria->compare('reevaluasiaset_selisihreevaluasi',$this->reevaluasiaset_selisihreevaluasi);
		$criteria->compare('reevaluasiaset_totalselisih',$this->reevaluasiaset_totalselisih);
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