<?php

/**
 * This is the model class for table "resepturdetail_t".
 *
 * The followings are the available columns in table 'resepturdetail_t':
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 * @property integer $resepturdetail_id
 * @property integer $sumberdana_id
 * @property integer $obatalkes_id
 * @property integer $reseptur_id
 * @property integer $satuankecil_id
 * @property integer $racikan_id
 * @property string $r
 * @property integer $rke
 * @property integer $permintaan_reseptur
 * @property integer $jmlkemasan_reseptur
 * @property integer $kekuatan_reseptur
 * @property string $satuankekuatan
 * @property double $qty_reseptur
 * @property double $hargasatuan_reseptur
 * @property string $signa_reseptur
 * @property double $harganetto_reseptur
 * @property double $hargajual_reseptur
 * @property string $etiket
 */
class ResepturdetailT extends CActiveRecord
{
	public $pendaftaran_id;
	public $tglkadaluarsa;
	public $tglkadalprev;
    public $ket_penggunaan;
	public $therapiobat_id, $therapiobat_nama;
	public $formulariumobat_id;
    public $jumlahppn, $totalbiayaadministrasi, $total_embalase, $satuan_permintaandosis, $temp_permintaan_dosis;
	public $jumlah;
        public $listJadwal, $racikan_nama, $satuankecil_nama;
        public $subjenis_nama, $jumlahpermintaan_obatracikan, $obatalkes_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResepturdetailT the static model class
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
		return 'resepturdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberdana_id, obatalkes_id, reseptur_id, racikan_id, qty_reseptur, harganetto_reseptur, hargajual_reseptur', 'required'),
			array('sumberdana_id, obatalkes_id, reseptur_id, satuankecil_id, racikan_id, rke, formulaobatkronis_id, permintaandosis_pembilang, permintaandosis_penyebut','numerical', 'integerOnly'=>true),
			array('qty_reseptur, hargasatuan_reseptur, harganetto_reseptur, hargajual_reseptur, jmlkemasan_reseptur, kekuatan_reseptur, persenppnjual, jumlahppn, persdiskon, jumlahdiskon, biayaadministrasi, totalbiayaadministrasi, total_embalase', 'numerical'),
			array('r', 'length', 'max'=>2),
			array('satuankekuatan', 'length', 'max'=>20),
			array('signa_reseptur', 'length', 'max'=>30),
			array('etiket, obatlain_nama', 'length', 'max'=>500),
                        array('is_stop, tanggal_stop, pegawai_stop, frekuensi, dosis, resepturketerangan, ket_penggunaan, is_obatkronis, obatlain_nama, st_fornas','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatlain_nama,resepturdetail_id, sumberdana_id, obatalkes_id, reseptur_id, satuankecil_id, racikan_id, r, rke, permintaan_reseptur, jmlkemasan_reseptur, kekuatan_reseptur, satuankekuatan, qty_reseptur, hargasatuan_reseptur, signa_reseptur, harganetto_reseptur, hargajual_reseptur, etiket, persenppnjual, jumlahppn, persdiskon, jumlahdiskon, biayaadministrasi, totalbiayaadministrasi, formulaobatkronis_id, is_obatkronis, total_embalase, permintaandosis_pembilang, permintaandosis_penyebut, is_permitaandosispecahan, obatlain_nama', 'safe', 'on'=>'search'),
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
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
                    'sumberdana'=>array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
                    'satuankecil'=>array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
                    'reseptur'=>array(self::BELONGS_TO, 'ResepturT', 'reseptur_id'),
                    'racikan'=>array(self::BELONGS_TO, 'RacikanM', 'racikan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resepturdetail_id' => 'Resepturdetail',
			'sumberdana_id' => 'Sumberdana',
			'obatalkes_id' => 'Obatalkes',
			'reseptur_id' => 'Reseptur',
			'satuankecil_id' => 'Satuankecil',
			'racikan_id' => 'Racikan',
			'r' => 'R',
			'rke' => 'Rke',
			'permintaan_reseptur' => 'Permintaan Reseptur',
			'jmlkemasan_reseptur' => 'Jmlkemasan Reseptur',
			'kekuatan_reseptur' => 'Kekuatan Reseptur',
			'satuankekuatan' => 'Satuankekuatan',
			'qty_reseptur' => 'Jumlah Reseptur',
			'hargasatuan_reseptur' => 'Hargasatuan Reseptur',
			'signa_reseptur' => 'Signa Reseptur',
			'harganetto_reseptur' => 'Harganetto Reseptur',
			'hargajual_reseptur' => 'Hargajual Reseptur',
			'etiket' => 'Etiket',
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

		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('harganetto_reseptur',$this->harganetto_reseptur);
		$criteria->compare('hargajual_reseptur',$this->hargajual_reseptur);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('resepturdetail_id',$this->resepturdetail_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('permintaan_reseptur',$this->permintaan_reseptur);
		$criteria->compare('jmlkemasan_reseptur',$this->jmlkemasan_reseptur);
		$criteria->compare('kekuatan_reseptur',$this->kekuatan_reseptur);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('qty_reseptur',$this->qty_reseptur);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('LOWER(signa_reseptur)',strtolower($this->signa_reseptur),true);
		$criteria->compare('harganetto_reseptur',$this->harganetto_reseptur);
		$criteria->compare('hargajual_reseptur',$this->hargajual_reseptur);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

    public function getHargaSatuanBerdasarkanInstalasi($ruangan_id = null) {
        $oa = ObatalkesM::model()->findByPk($this->obatalkes_id);

        $hargajual = $oa->hargajual;

        if (empty($ruangan_id)) {
            return $hargajual;
        }
        $ruangan = RuanganM::model()->findByPk($ruangan_id);

         if (empty($ruangan)) {
            return $hargajual;
        }

        $instalasi = $ruangan->instalasi_id;

        $konfig = KonfigfarmasiK::model()->find();
        if (in_array($instalasi, array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_REHAB, Params::INSTALASI_ID_HD))) {
            if (!empty($konfig) && !empty($konfig->rj_persjualppn)) {
                $hargajual += $hargajual * $konfig->rj_persjualppn / 100;
            }
        } else if (in_array($instalasi, array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF))) {
            if (!empty($konfig) && !empty($konfig->ri_persjualppn)) {
                $hargajual += $hargajual * $konfig->ri_persjualppn / 100;
            }
        } else if (in_array($instalasi, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) {
            if (!empty($konfig) && !empty($konfig->rd_persjualppn)) {
                $hargajual += $hargajual * $konfig->rd_persjualppn / 100;
            }
        }

        return $hargajual;
    }

	public static function getJmlRaciakan($reseptur_id)
	{
		$criteria = new CDbCriteria();
		$criteria->select = '(count(distinct(rke))) as jumlah';
		$criteria->addCondition("racikan_id = " . Params::RACIKAN_ID_RACIKAN);
		$criteria->addCondition("reseptur_id = " . $reseptur_id);

		return self::model()->find($criteria)->jumlah;
	}
}
