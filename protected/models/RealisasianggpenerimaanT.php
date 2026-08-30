<?php

/**
 * This is the model class for table "realisasianggpenerimaan_t".
 *
 * The followings are the available columns in table 'realisasianggpenerimaan_t':
 * @property integer $realisasianggpenerimaan_id
 * @property integer $tandabuktibayar_id
 * @property integer $renanggaranpenerimaandet_id
 * @property integer $renanggpenerimaan_id
 * @property string $tglrealisasianggpen
 * @property string $norealisasianggpen
 * @property double $nilaipenerimaan
 * @property double $realisasipenerimaan
 * @property integer $berapaxpenerimaan
 * @property integer $penerimaanke
 * @property integer $peg_mengetahui_id
 * @property integer $peg_menyetujui_id
 * @property string $carapembayaran
 * @property string $nostruk_trf
 * @property string $tgltransfer
 * @property string $namabank_trf
 * @property string $norek_trf
 * @property string $atasnama_trf
 * @property string $nocek
 * @property string $tglcek
 * @property string $atasnama_cek
 * @property string $namabank_cek
 * @property string $utkkeperluan_cek
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RealisasianggpenerimaanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasianggpenerimaanT the static model class
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
		return 'realisasianggpenerimaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglrealisasianggpen, norealisasianggpen, nilaipenerimaan, realisasipenerimaan, berapaxpenerimaan, penerimaanke, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tandabuktibayar_id, renanggaranpenerimaandet_id, renanggpenerimaan_id, berapaxpenerimaan, penerimaanke, peg_mengetahui_id, peg_menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilaipenerimaan, realisasipenerimaan', 'numerical'),
			array('norealisasianggpen', 'length', 'max'=>20),
			array('carapembayaran', 'length', 'max'=>30),
			array('nostruk_trf, namabank_trf, atasnama_trf, nocek, atasnama_cek, namabank_cek', 'length', 'max'=>100),
			array('norek_trf', 'length', 'max'=>50),
			array('utkkeperluan_cek', 'length', 'max'=>200),
			array('tgltransfer, tglcek, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasianggpenerimaan_id, tandabuktibayar_id, renanggaranpenerimaandet_id, renanggpenerimaan_id, tglrealisasianggpen, norealisasianggpen, nilaipenerimaan, realisasipenerimaan, berapaxpenerimaan, penerimaanke, peg_mengetahui_id, peg_menyetujui_id, carapembayaran, nostruk_trf, tgltransfer, namabank_trf, norek_trf, atasnama_trf, nocek, tglcek, atasnama_cek, namabank_cek, utkkeperluan_cek, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'renanggpenerimaan'=>array(self::BELONGS_TO,'RenanggpenerimaanT','renanggpenerimaan_id'),
			'renanggaranpenerimaandet'=>array(self::BELONGS_TO,'RenanggaranpenerimaandetT','renanggaranpenerimaandet_id'),
			'konfiganggaran' => array(self::BELONGS_TO, 'KonfiganggaranK', 'konfiganggaran_id'),
			'sumberanggaran' => array(self::BELONGS_TO, 'SumberanggaranM', 'sumberanggaran_id'),
			'mengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'peg_mengetahui_id'),
			'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'peg_menyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasianggpenerimaan_id' => 'Realisasianggpenerimaan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'renanggaranpenerimaandet_id' => 'Renanggaranpenerimaandet',
			'renanggpenerimaan_id' => 'Renanggpenerimaan',
			'tglrealisasianggpen' => 'Tglrealisasianggpen',
			'nilaipenerimaan' => 'Nilai Penerimaan',
			'realisasipenerimaan' => 'Realisasi Penerimaan',
			'norealisasianggpen' => 'No. Penerimaan',
			'berapaxpenerimaan' => 'Berapaxpenerimaan',
			'penerimaanke' => 'Penerimaanke',
			'peg_mengetahui_id' => 'Pegawai Mengetahui',
			'peg_menyetujui_id' => 'Pegawai Menyetujui',
			'carapembayaran' => 'Carapembayaran',
			'nostruk_trf' => 'No. Struk',
			'tgltransfer' => 'Tanggal Transfer',
			'namabank_trf' => 'Bank',
			'norek_trf' => 'No. Rekening',
			'atasnama_trf' => 'Atas Nama',
			'nocek' => 'No. Cek',
			'tglcek' => 'Tanggal Cek',
			'atasnama_cek' => 'Atas Nama',
			'namabank_cek' => 'Bank',
			'utkkeperluan_cek' => 'Untuk Keperluan',
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

		if(!empty($this->realisasianggpenerimaan_id)){
			$criteria->addCondition('realisasianggpenerimaan_id = '.$this->realisasianggpenerimaan_id);
		}
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		if(!empty($this->renanggaranpenerimaandet_id)){
			$criteria->addCondition('renanggaranpenerimaandet_id = '.$this->renanggaranpenerimaandet_id);
		}
		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		$criteria->compare('LOWER(tglrealisasianggpen)',strtolower($this->tglrealisasianggpen),true);
		$criteria->compare('LOWER(norealisasianggpen)',strtolower($this->norealisasianggpen),true);
		$criteria->compare('nilaipenerimaan',$this->nilaipenerimaan);
		$criteria->compare('realisasipenerimaan',$this->realisasipenerimaan);
		if(!empty($this->berapaxpenerimaan)){
			$criteria->addCondition('berapaxpenerimaan = '.$this->berapaxpenerimaan);
		}
		if(!empty($this->penerimaanke)){
			$criteria->addCondition('penerimaanke = '.$this->penerimaanke);
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition('peg_mengetahui_id = '.$this->peg_mengetahui_id);
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition('peg_menyetujui_id = '.$this->peg_menyetujui_id);
		}
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(nostruk_trf)',strtolower($this->nostruk_trf),true);
		$criteria->compare('LOWER(tgltransfer)',strtolower($this->tgltransfer),true);
		$criteria->compare('LOWER(namabank_trf)',strtolower($this->namabank_trf),true);
		$criteria->compare('LOWER(norek_trf)',strtolower($this->norek_trf),true);
		$criteria->compare('LOWER(atasnama_trf)',strtolower($this->atasnama_trf),true);
		$criteria->compare('LOWER(nocek)',strtolower($this->nocek),true);
		$criteria->compare('LOWER(tglcek)',strtolower($this->tglcek),true);
		$criteria->compare('LOWER(atasnama_cek)',strtolower($this->atasnama_cek),true);
		$criteria->compare('LOWER(namabank_cek)',strtolower($this->namabank_cek),true);
		$criteria->compare('LOWER(utkkeperluan_cek)',strtolower($this->utkkeperluan_cek),true);
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