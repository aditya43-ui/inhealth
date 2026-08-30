<?php

/**
 * This is the model class for table "rinciantindakan_t".
 *
 * The followings are the available columns in table 'rinciantindakan_t':
 * @property integer $rinciantindakan_id
 * @property string $ds_yan
 * @property double $qty
 * @property double $tarif
 * @property string $kd_dep
 * @property string $ds_dep
 * @property double $tarif_piutang
 * @property double $tarif_selisih
 * @property double $tarif_costshare
 * @property double $tarif_subsidi
 * @property integer $id_rec
 * @property integer $piutangpribadidet_id
 * @property string $kd_yan
 * @property integer $piutangperusahaandet_id
 * @property integer $piutangbpjsdet_id
 * @property integer $uangmukapasiendet_id
 * @property integer $buktikasmasukdet_id
 * @property integer $penerimaantunaidet_id
 * @property integer $pengembalianuangmukadet_id
 * @property integer $penerimaannontunaidet_id
 *
 * The followings are the available model relations:
 * @property BkupengembalianuangmukaT[] $bkupengembalianuangmukaTs
 * @property BuktikasmasukdetT $buktikasmasukdet
 * @property PenerimaantunaidetT $penerimaantunaidet
 * @property PengembalianuangmukadetT $pengembalianuangmukadet
 * @property PiutangbpjsdetT $piutangbpjsdet
 * @property PiutangperusahaandetT $piutangperusahaandet
 * @property PiutangpribadidetT $piutangpribadidet
 * @property UangmukapasiendetT $uangmukapasiendet
 * @property PenerimaannontunaidetT $penerimaannontunaidet
 */
class RinciantindakanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciantindakanT the static model class
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
		return 'rinciantindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rec, piutangpribadidet_id, piutangperusahaandet_id, piutangbpjsdet_id, uangmukapasiendet_id, buktikasmasukdet_id, penerimaantunaidet_id, pengembalianuangmukadet_id, penerimaannontunaidet_id', 'numerical', 'integerOnly'=>true),
			array('qty, tarif, tarif_piutang, tarif_selisih, tarif_costshare, tarif_subsidi', 'numerical'),
			array('ds_yan, ds_dep', 'length', 'max'=>100),
			array('kd_dep, kd_yan', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rinciantindakan_id, ds_yan, qty, tarif, kd_dep, ds_dep, tarif_piutang, tarif_selisih, tarif_costshare, tarif_subsidi, id_rec, piutangpribadidet_id, kd_yan, piutangperusahaandet_id, piutangbpjsdet_id, uangmukapasiendet_id, buktikasmasukdet_id, penerimaantunaidet_id, pengembalianuangmukadet_id, penerimaannontunaidet_id', 'safe', 'on'=>'search'),
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
			'bkupengembalianuangmukaTs' => array(self::HAS_MANY, 'BkupengembalianuangmukaT', 'rinciantindakan_id'),
			'buktikasmasukdet' => array(self::BELONGS_TO, 'BuktikasmasukdetT', 'buktikasmasukdet_id'),
			'penerimaantunaidet' => array(self::BELONGS_TO, 'PenerimaantunaidetT', 'penerimaantunaidet_id'),
			'pengembalianuangmukadet' => array(self::BELONGS_TO, 'PengembalianuangmukadetT', 'pengembalianuangmukadet_id'),
			'piutangbpjsdet' => array(self::BELONGS_TO, 'PiutangbpjsdetT', 'piutangbpjsdet_id'),
			'piutangperusahaandet' => array(self::BELONGS_TO, 'PiutangperusahaandetT', 'piutangperusahaandet_id'),
			'piutangpribadidet' => array(self::BELONGS_TO, 'PiutangpribadidetT', 'piutangpribadidet_id'),
			'uangmukapasiendet' => array(self::BELONGS_TO, 'UangmukapasiendetT', 'uangmukapasiendet_id'),
			'penerimaannontunaidet' => array(self::BELONGS_TO, 'PenerimaannontunaidetT', 'penerimaannontunaidet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rinciantindakan_id' => 'Rinciantindakan',
			'ds_yan' => 'Ds Yan',
			'qty' => 'Qty',
			'tarif' => 'Tarif',
			'kd_dep' => 'Kd Dep',
			'ds_dep' => 'Ds Dep',
			'tarif_piutang' => 'Tarif Piutang',
			'tarif_selisih' => 'Tarif Selisih',
			'tarif_costshare' => 'Tarif Costshare',
			'tarif_subsidi' => 'Tarif Subsidi',
			'id_rec' => 'Id Rec',
			'piutangpribadidet_id' => 'Piutangpribadidet',
			'kd_yan' => 'Kd Yan',
			'piutangperusahaandet_id' => 'Piutangperusahaandet',
			'piutangbpjsdet_id' => 'Piutangbpjsdet',
			'uangmukapasiendet_id' => 'Uangmukapasiendet',
			'buktikasmasukdet_id' => 'Buktikasmasukdet',
			'penerimaantunaidet_id' => 'Penerimaantunaidet',
			'pengembalianuangmukadet_id' => 'Pengembalianuangmukadet',
			'penerimaannontunaidet_id' => 'Penerimaannontunaidet',
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

		$criteria->compare('rinciantindakan_id',$this->rinciantindakan_id);
		$criteria->compare('ds_yan',$this->ds_yan,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tarif',$this->tarif);
		$criteria->compare('kd_dep',$this->kd_dep,true);
		$criteria->compare('ds_dep',$this->ds_dep,true);
		$criteria->compare('tarif_piutang',$this->tarif_piutang);
		$criteria->compare('tarif_selisih',$this->tarif_selisih);
		$criteria->compare('tarif_costshare',$this->tarif_costshare);
		$criteria->compare('tarif_subsidi',$this->tarif_subsidi);
		$criteria->compare('id_rec',$this->id_rec);
		$criteria->compare('piutangpribadidet_id',$this->piutangpribadidet_id);
		$criteria->compare('kd_yan',$this->kd_yan,true);
		$criteria->compare('piutangperusahaandet_id',$this->piutangperusahaandet_id);
		$criteria->compare('piutangbpjsdet_id',$this->piutangbpjsdet_id);
		$criteria->compare('uangmukapasiendet_id',$this->uangmukapasiendet_id);
		$criteria->compare('buktikasmasukdet_id',$this->buktikasmasukdet_id);
		$criteria->compare('penerimaantunaidet_id',$this->penerimaantunaidet_id);
		$criteria->compare('pengembalianuangmukadet_id',$this->pengembalianuangmukadet_id);
		$criteria->compare('penerimaannontunaidet_id',$this->penerimaannontunaidet_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}