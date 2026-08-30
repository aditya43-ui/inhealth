<?php

/**
 * This is the model class for table "inacbg_t".
 *
 * The followings are the available columns in table 'inacbg_t':
 * @property integer $inacbg_id
 * @property integer $sep_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $pasienpulang_id
 * @property integer $pendaftaran_id
 * @property string $inacbg_tgl
 * @property string $inacbg_deskripsi
 * @property string $kodeinacbg
 * @property string $inacbg_nosep
 * @property double $tarifgruper
 * @property double $totaltarif
 * @property string $drug_deskripsi
 * @property string $drug_kode
 * @property double $drug_tarif
 * @property string $investigation_deskripsi
 * @property string $investigation_kode
 * @property double $investigation_tarif
 * @property string $procedure_deskripsi
 * @property string $procedure_kode
 * @property double $procedure_tarif
 * @property string $prosthesis_deskripsi
 * @property string $prosthesis_kode
 * @property double $prosthesis_tarif
 * @property string $subccute_deskripsi
 * @property string $subccute_kode
 * @property double $subccute_tarif
 * @property integer $ruanganakhir_id
 * @property integer $pegfinalisasi_id
 * @property string $tglfinalisasi
 * @property boolean $statusfinalisasi
 * @property string $ketfinalisasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InacbgT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InacbgT the static model class
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
		return 'inacbg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sep_id, pasien_id, pendaftaran_id, inacbg_tgl, kodeinacbg, inacbg_nosep, tarifgruper, totaltarif, ruanganakhir_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('sep_id, pasienadmisi_id, pasien_id, pasienpulang_id, pendaftaran_id, ruanganakhir_id, pegfinalisasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tarifgruper, totaltarif, drug_tarif, investigation_tarif, procedure_tarif, prosthesis_tarif, subccute_tarif', 'numerical'),
			array('kodeinacbg, drug_kode, investigation_kode, procedure_kode, prosthesis_kode, subccute_kode', 'length', 'max'=>50),
			array('inacbg_nosep', 'length', 'max'=>100),
			array('inacbg_deskripsi, drug_deskripsi, investigation_deskripsi, procedure_deskripsi, prosthesis_deskripsi, subccute_deskripsi, tglfinalisasi, statusfinalisasi, ketfinalisasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inacbg_id, sep_id, pasienadmisi_id, pasien_id, pasienpulang_id, pendaftaran_id, inacbg_tgl, inacbg_deskripsi, kodeinacbg, inacbg_nosep, tarifgruper, totaltarif, drug_deskripsi, drug_kode, drug_tarif, investigation_deskripsi, investigation_kode, investigation_tarif, procedure_deskripsi, procedure_kode, procedure_tarif, prosthesis_deskripsi, prosthesis_kode, prosthesis_tarif, subccute_deskripsi, subccute_kode, subccute_tarif, ruanganakhir_id, pegfinalisasi_id, tglfinalisasi, statusfinalisasi, ketfinalisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inacbg_id' => 'Inacbg',
			'sep_id' => 'Sep',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'pasienpulang_id' => 'Pasienpulang',
			'pendaftaran_id' => 'Pendaftaran',
			'inacbg_tgl' => 'Inacbg Tgl',
			'inacbg_deskripsi' => 'Inacbg Deskripsi',
			'kodeinacbg' => 'Kodeinacbg',
			'inacbg_nosep' => 'Inacbg Nosep',
			'tarifgruper' => 'Tarifgruper',
			'totaltarif' => 'Totaltarif',
			'drug_deskripsi' => 'Drug Deskripsi',
			'drug_kode' => 'Drug Kode',
			'drug_tarif' => 'Drug Tarif',
			'investigation_deskripsi' => 'Investigation Deskripsi',
			'investigation_kode' => 'Investigation Kode',
			'investigation_tarif' => 'Investigation Tarif',
			'procedure_deskripsi' => 'Procedure Deskripsi',
			'procedure_kode' => 'Procedure Kode',
			'procedure_tarif' => 'Procedure Tarif',
			'prosthesis_deskripsi' => 'Prosthesis Deskripsi',
			'prosthesis_kode' => 'Prosthesis Kode',
			'prosthesis_tarif' => 'Prosthesis Tarif',
			'subccute_deskripsi' => 'Subccute Deskripsi',
			'subccute_kode' => 'Subccute Kode',
			'subccute_tarif' => 'Subccute Tarif',
			'ruanganakhir_id' => 'Ruanganakhir',
			'pegfinalisasi_id' => 'Pegfinalisasi',
			'tglfinalisasi' => 'Tglfinalisasi',
			'statusfinalisasi' => 'Statusfinalisasi',
			'ketfinalisasi' => 'Ketfinalisasi',
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

		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition('pasienpulang_id = '.$this->pasienpulang_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(inacbg_tgl)',strtolower($this->inacbg_tgl),true);
		$criteria->compare('LOWER(inacbg_deskripsi)',strtolower($this->inacbg_deskripsi),true);
		$criteria->compare('LOWER(kodeinacbg)',strtolower($this->kodeinacbg),true);
		$criteria->compare('LOWER(inacbg_nosep)',strtolower($this->inacbg_nosep),true);
		$criteria->compare('tarifgruper',$this->tarifgruper);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('LOWER(drug_deskripsi)',strtolower($this->drug_deskripsi),true);
		$criteria->compare('LOWER(drug_kode)',strtolower($this->drug_kode),true);
		$criteria->compare('drug_tarif',$this->drug_tarif);
		$criteria->compare('LOWER(investigation_deskripsi)',strtolower($this->investigation_deskripsi),true);
		$criteria->compare('LOWER(investigation_kode)',strtolower($this->investigation_kode),true);
		$criteria->compare('investigation_tarif',$this->investigation_tarif);
		$criteria->compare('LOWER(procedure_deskripsi)',strtolower($this->procedure_deskripsi),true);
		$criteria->compare('LOWER(procedure_kode)',strtolower($this->procedure_kode),true);
		$criteria->compare('procedure_tarif',$this->procedure_tarif);
		$criteria->compare('LOWER(prosthesis_deskripsi)',strtolower($this->prosthesis_deskripsi),true);
		$criteria->compare('LOWER(prosthesis_kode)',strtolower($this->prosthesis_kode),true);
		$criteria->compare('prosthesis_tarif',$this->prosthesis_tarif);
		$criteria->compare('LOWER(subccute_deskripsi)',strtolower($this->subccute_deskripsi),true);
		$criteria->compare('LOWER(subccute_kode)',strtolower($this->subccute_kode),true);
		$criteria->compare('subccute_tarif',$this->subccute_tarif);
		if(!empty($this->ruanganakhir_id)){
			$criteria->addCondition('ruanganakhir_id = '.$this->ruanganakhir_id);
		}
		if(!empty($this->pegfinalisasi_id)){
			$criteria->addCondition('pegfinalisasi_id = '.$this->pegfinalisasi_id);
		}
		$criteria->compare('LOWER(tglfinalisasi)',strtolower($this->tglfinalisasi),true);
		$criteria->compare('statusfinalisasi',$this->statusfinalisasi);
		$criteria->compare('LOWER(ketfinalisasi)',strtolower($this->ketfinalisasi),true);
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