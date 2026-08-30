<?php

/**
 * This is the model class for table "saldorekeningrasio_v".
 *
 * The followings are the available columns in table 'saldorekeningrasio_v':
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property double $beban
 * @property double $aktiva
 * @property double $aktivalancar
 * @property double $persediaan
 * @property double $aktivatetap
 * @property double $akumulasipenyusutanaktivatetap
 * @property double $bebanpenyusutandanamortisasi
 * @property double $ekuitas
 * @property double $kasdansetarakas
 * @property double $kewajiban
 * @property double $investasilancar
 * @property double $laba
 * @property double $rugi
 * @property double $pendapatan
 * @property double $piutang
 */
class SaldorekeningrasioV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaldorekeningrasioV the static model class
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
		return 'saldorekeningrasio_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id', 'numerical', 'integerOnly'=>true),
			array('beban, aktiva, aktivalancar, persediaan, aktivatetap, akumulasipenyusutanaktivatetap, bebanpenyusutandanamortisasi, ekuitas, kasdansetarakas, kewajiban, investasilancar, laba, rugi, pendapatan, piutang', 'numerical'),
			array('perideawal, sampaidgn', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekperiod_id, perideawal, sampaidgn, beban, aktiva, aktivalancar, persediaan, aktivatetap, akumulasipenyusutanaktivatetap, bebanpenyusutandanamortisasi, ekuitas, kasdansetarakas, kewajiban, investasilancar, laba, rugi, pendapatan, piutang', 'safe', 'on'=>'search'),
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
			'rekperiod_id' => 'Rekperiod',
			'perideawal' => 'Perideawal',
			'sampaidgn' => 'Sampaidgn',
			'beban' => 'Beban',
			'aktiva' => 'Aktiva',
			'aktivalancar' => 'Aktivalancar',
			'persediaan' => 'Persediaan',
			'aktivatetap' => 'Aktivatetap',
			'akumulasipenyusutanaktivatetap' => 'Akumulasipenyusutanaktivatetap',
			'bebanpenyusutandanamortisasi' => 'Bebanpenyusutandanamortisasi',
			'ekuitas' => 'Ekuitas',
			'kasdansetarakas' => 'Kasdansetarakas',
			'kewajiban' => 'Kewajiban',
			'investasilancar' => 'Investasilancar',
			'laba' => 'Laba',
			'rugi' => 'Rugi',
			'pendapatan' => 'Pendapatan',
			'piutang' => 'Piutang',
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

		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('beban',$this->beban);
		$criteria->compare('aktiva',$this->aktiva);
		$criteria->compare('aktivalancar',$this->aktivalancar);
		$criteria->compare('persediaan',$this->persediaan);
		$criteria->compare('aktivatetap',$this->aktivatetap);
		$criteria->compare('akumulasipenyusutanaktivatetap',$this->akumulasipenyusutanaktivatetap);
		$criteria->compare('bebanpenyusutandanamortisasi',$this->bebanpenyusutandanamortisasi);
		$criteria->compare('ekuitas',$this->ekuitas);
		$criteria->compare('kasdansetarakas',$this->kasdansetarakas);
		$criteria->compare('kewajiban',$this->kewajiban);
		$criteria->compare('investasilancar',$this->investasilancar);
		$criteria->compare('laba',$this->laba);
		$criteria->compare('rugi',$this->rugi);
		$criteria->compare('pendapatan',$this->pendapatan);
		$criteria->compare('piutang',$this->piutang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('beban',$this->beban);
		$criteria->compare('aktiva',$this->aktiva);
		$criteria->compare('aktivalancar',$this->aktivalancar);
		$criteria->compare('persediaan',$this->persediaan);
		$criteria->compare('aktivatetap',$this->aktivatetap);
		$criteria->compare('akumulasipenyusutanaktivatetap',$this->akumulasipenyusutanaktivatetap);
		$criteria->compare('bebanpenyusutandanamortisasi',$this->bebanpenyusutandanamortisasi);
		$criteria->compare('ekuitas',$this->ekuitas);
		$criteria->compare('kasdansetarakas',$this->kasdansetarakas);
		$criteria->compare('kewajiban',$this->kewajiban);
		$criteria->compare('investasilancar',$this->investasilancar);
		$criteria->compare('laba',$this->laba);
		$criteria->compare('rugi',$this->rugi);
		$criteria->compare('pendapatan',$this->pendapatan);
		$criteria->compare('piutang',$this->piutang);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}