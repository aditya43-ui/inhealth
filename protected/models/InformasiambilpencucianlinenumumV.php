<?php

/**
 * This is the model class for table "informasiambilpencucianlinenumum_v".
 *
 * The followings are the available columns in table 'informasiambilpencucianlinenumum_v':
 * @property integer $ambilpencucianlinenumum_id
 * @property string $tglpengambilan
 * @property string $nopengambilan
 * @property integer $terimapencucianlinenumum_id
 * @property string $tglpenerimaan
 * @property string $nopenerimaan
 * @property string $namapengirim
 * @property string $namapengambil
 * @property double $berat
 * @property double $harga
 */
class InformasiambilpencucianlinenumumV extends CActiveRecord
{
    public $pengajuan, $pengambilan, $tgl_awal_pengajuan, $tgl_akhir_pengajuan, $tgl_awal_pengambilan, $tgl_akhir_pengambilan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasiambilpencucianlinenumum_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ambilpencucianlinenumum_id, terimapencucianlinenumum_id', 'numerical', 'integerOnly'=>true),
			array('berat, harga', 'numerical'),
			array('nopengambilan', 'length', 'max'=>25),
			array('nopenerimaan', 'length', 'max'=>30),
			array('namapengirim, namapengambil', 'length', 'max'=>50),
			array('tglpengambilan, tglpenerimaan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ambilpencucianlinenumum_id, tglpengambilan, nopengambilan, terimapencucianlinenumum_id, tglpenerimaan, nopenerimaan, namapengirim, namapengambil, berat, harga', 'safe', 'on'=>'search'),
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
			'ambilpencucianlinenumum_id' => 'Ambilpencucianlinenumum',
			'tglpengambilan' => 'Tglpengambilan',
			'nopengambilan' => 'Nopengambilan',
			'terimapencucianlinenumum_id' => 'Terimapencucianlinenumum',
			'tglpenerimaan' => 'Tglpenerimaan',
			'nopenerimaan' => 'Nopenerimaan',
			'namapengirim' => 'Namapengirim',
			'namapengambil' => 'Namapengambil',
			'berat' => 'Berat',
			'harga' => 'Harga',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ambilpencucianlinenumum_id',$this->ambilpencucianlinenumum_id);
		$criteria->compare('tglpengambilan',$this->tglpengambilan,true);
		$criteria->compare('nopengambilan',$this->nopengambilan,true);
		$criteria->compare('terimapencucianlinenumum_id',$this->terimapencucianlinenumum_id);
		$criteria->compare('tglpenerimaan',$this->tglpenerimaan,true);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('namapengirim',$this->namapengirim,true);
		$criteria->compare('namapengambil',$this->namapengambil,true);
		$criteria->compare('berat',$this->berat);
		$criteria->compare('harga',$this->harga);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchInformasi(){
            $criteria=new CDbCriteria;
            if ($this->pengajuan) {
                $criteria->addBetweenCondition('DATE(tglpenerimaan)', $this->tgl_awal_pengajuan, $this->tgl_akhir_pengajuan);
            }
            if ($this->pengambilan) {
                $criteria->addBetweenCondition('DATE(tglpengambilan)', $this->tgl_awal_pengambilan, $this->tgl_akhir_pengambilan);
            }
            $criteria->compare('ambilpencucianlinenumum_id',$this->ambilpencucianlinenumum_id);
            $criteria->compare('LOWER(nopengambilan)',strtolower($this->nopengambilan),true);
            $criteria->compare('terimapencucianlinenumum_id',$this->terimapencucianlinenumum_id);
            $criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
            $criteria->compare('LOWER(namapengirim)',strtolower($this->namapengirim),true);
            $criteria->compare('LOWER(namapengambil)',strtolower($this->namapengambil),true);
            $criteria->compare('berat',$this->berat);
            $criteria->compare('harga',$this->harga);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasiambilpencucianlinenumumV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
