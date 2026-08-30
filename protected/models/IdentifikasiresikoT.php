<?php

/**
 * This is the model class for table "identifikasiresiko_t".
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category RSST-8455 Improvment Informasi Risk Register
 * @package application.models
 * The followings are the available columns in table 'identifikasiresiko_t':
 * @property integer $identifikasiresiko_id
 * @property integer $perioderiskregister_id
 * @property integer $ruangan_id
 * @property string $sumber_resiko
 * @property integer $tiperesiko_id
 * @property integer $subtiperesiko_id
 * @property string $deskripsiresiko
 * @property string $penyebabresiko
 * @property string $existing_control
 * @property integer $konsekuensi_id
 * @property integer $peluang_id
 * @property integer $detectability_id
 * @property integer $rpn_score
 * @property integer $target_rpn
 * @property integer $tingkatrisiko_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property EvaluasiidentifikasirisikoT[] $evaluasiidentifikasirisikoTs
 * @property ProgressmonevindentifikasirisikoT[] $progressmonevindentifikasirisikoTs
 */
class IdentifikasiresikoT extends CActiveRecord
{
         public $tingkatrisiko_nama,$namaunitkerja;
         public $perioderiskregister_idnya, $jenisriskmanajemennya, $ruangan_nama;
         public $deskripsiresiko;


         /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IdentifikasiresikoT the static model class
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
		return 'identifikasiresiko_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perioderiskregister_id, ruangan_id, sumber_resiko, tiperesiko_id, create_loginpemakai_id, create_ruangan', 'required'),
                        //array('jenisriskmanajemen, deskripsiresiko, dampakrisiko, penyebabresiko, konsekuensi_id, peluang_id, skor_cl, detectability_id rpn_score, tingkatrisiko_id, unitkerja_id, subtiperesiko_id, existing_control', 'required'),
			array('perioderiskregister_id, ruangan_id, tiperesiko_id, subtiperesiko_id, konsekuensi_id, peluang_id, detectability_id, rpn_score, target_rpn, tingkatrisiko_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('sumber_resiko', 'length', 'max'=>100),
			array('alasanpembatalan, jenisriskmanajemen, deskripsiresiko, dampakrisiko, penyebabresiko, unitkerja_id, skor_cl, jenisriskmanajemen, existing_control, subtiperesiko_id, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('identifikasiresiko_id, perioderiskregister_id, ruangan_id, sumber_resiko, tiperesiko_id, subtiperesiko_id, deskripsiresiko, penyebabresiko, existing_control, konsekuensi_id, peluang_id, detectability_id, rpn_score, target_rpn, tingkatrisiko_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'evaluasiidentifikasirisikoTs' => array(self::HAS_MANY, 'EvaluasiidentifikasirisikoT', 'identifikasirisiko_id'),
			'progressmonevindentifikasirisikoTs' => array(self::HAS_MANY, 'ProgressmonevindentifikasirisikoT', 'identifikasiresiko_id'),
                        'tiperesiko' => array(self::BELONGS_TO, 'TiperesikoM', 'tiperesiko_id'),
                        'subtiperesiko' => array(self::BELONGS_TO, 'SubtiperesikoM', 'subtiperesiko_id'),
                        'periode' => array(self::BELONGS_TO, 'PerioderiskregisterM', 'perioderiskregister_id'),
                        'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),

                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'identifikasiresiko_id' => 'Identifikasiresiko',
			'perioderiskregister_id' => 'Periode Manajemen Resiko',
			'ruangan_id' => 'Ruangan',
			'sumber_resiko' => 'Sumber Resiko',
			'tiperesiko_id' => 'Tipe Manajemen Resiko',
			'subtiperesiko_id' => 'Subtiperesiko',
			'deskripsiresiko' => 'Deskripsi Resiko',
			'penyebabresiko' => 'Penyebab',
			'existing_control' => 'Existing Control',
			'konsekuensi_id' => 'Konsekuensi',
			'peluang_id' => 'Peluang',
			'detectability_id' => 'Detectability / Controlability',
			'rpn_score' => 'RPN (Risk Priority Number)',
			'target_rpn' => 'Target Rpn',
			'tingkatrisiko_id' => 'Tingkat Resiko',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'skor_cl' => 'Skor',
                        'jenisriskmanajemen' => 'Jenis Risk Management',
                        'dampakrisiko' => 'Dampak Resiko',
                        'unitkerja_id' => 'Unit Kerja',                    
                        'subtiperesiko_id' => 'Sub Tipe Manajemen Resiko',
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

		$criteria->compare('identifikasiresiko_id',$this->identifikasiresiko_id);
		$criteria->compare('perioderiskregister_id',$this->perioderiskregister_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('sumber_resiko',$this->sumber_resiko,true);
		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('subtiperesiko_id',$this->subtiperesiko_id);
		$criteria->compare('deskripsiresiko',$this->deskripsiresiko,true);
		$criteria->compare('penyebabresiko',$this->penyebabresiko,true);
		$criteria->compare('existing_control',$this->existing_control,true);
		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('detectability_id',$this->detectability_id);
		$criteria->compare('rpn_score',$this->rpn_score);
		$criteria->compare('target_rpn',$this->target_rpn);
		$criteria->compare('tingkatrisiko_id',$this->tingkatrisiko_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * Load data periode risk
     * @return \PerioderiskregisterM
     */
    public function getPeriodeResikoItems()
    {
        return PerioderiskregisterM::model()->findAll('perioderiskregister_aktif=TRUE order by nama_perioderiskregister');
    }
    
    /**
     * Load data periode risk
     * @return \PerioderiskregisterM
     */
    public function getSemuaPeriodeResiko()
    {
        return PerioderiskregisterM::model()->findAll('perioderiskregister_id is not null order by nama_perioderiskregister');
    }
    /**
     * Load data tingkat resiko
     * @return \TingkatrisikoM
     */
    public function getTingkatResikoItems()
    {
        return TingkatrisikoM::model()->findAll('tingkatrisiko_aktif=TRUE order by tingkatrisiko_nama');
    }
    /**
     * Load data runagan unit kerja
     * @return \RuanganM
     */
    public function getRuanganUnitKerjaItems()
    {   
        $criteria= new CDbCriteria();
        $criteria->select="t.*,k.namaunitkerja";
        $criteria->join="left join unitkerjaruangan_m uk on t.ruangan_id=uk.ruangan_id "
                . "left join unitkerja_m k on k.unitkerja_id=uk.unitkerja_id";
        $criteria->order="t.ruangan_nama";
        $criteria->addCondition("k.unitkerja_aktif is true");
        $models= RuanganM::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->ruangan_id]= ($model->ruangan_nama." (Unit Kerja : ".$model->namaunitkerja.")");
        }

        return $data;
    }
    
    /**
     * Load data tipe sub resiko
     * @return \TiperesikoM
     */
    public function getTipeSubResikoItems()
    {   
        $criteria= new CDbCriteria();
        $criteria->select="t.*,k.subtiperesiko_nama";
        $criteria->join=" left join subtiperesiko_m k on t.tiperesiko_id=k.tiperesiko_id";
        $criteria->order="t.tiperesiko_nama";
        $models= TiperesikoM::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                $data[$model->tiperesiko_id]= ($model->tiperesiko_nama." (Sub Tipe : ".$model->subtiperesiko_nama.")");
        }

        return $data;
    }
   
    /**
     * Load data Tipe resiko
     * @return type
     */
    public function getTipeResikoItems()
    {
        return TiperesikoM::model()->findAll('tiperesiko_aktif = TRUE order by tiperesiko_nama');
    }
    
    /**
     * Load data Sub Tipe resiko
     * @return type
     */
    public function getSubTipeResikoItems($tiperesiko_id, $st='')
    {
        if ($st == 'wajib'){
            if (!empty($tiperesiko_id)){
                return SubtiperesikoM::model()->findAll(" tiperesiko_id= ".$tiperesiko_id."  AND subtiperesiko_aktif = TRUE order by subtiperesiko_nama");
            }else{
                return array();
            }
        } else{
            return SubtiperesikoM::model()->findAll('subtiperesiko_aktif = TRUE order by subtiperesiko_nama');
        }
    }
}