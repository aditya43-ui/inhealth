<?php

/**
 * This is the model class for table "informasipencucianlinenumum_v".
 *
 * The followings are the available columns in table 'informasipencucianlinenumum_v':
 * @property integer $pencucianlinenumum_id
 * @property integer $terimapencucianlinenumum_id
 * @property string $tglpencucian
 * @property string $tglpenerimaan
 * @property string $nopencucian
 * @property string $nopenerimaan
 * @property string $namapengirim
 * @property string $mesinpencucian_nama
 * @property string $keterangan
 */
class InformasipencucianlinenumumV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
        public $pilihTanggal;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipencucianlinenumum_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pencucianlinenumum_id, terimapencucianlinenumum_id', 'numerical', 'integerOnly'=>true),
			array('nopencucian, mesinpencucian_nama', 'length', 'max'=>25),
			array('nopenerimaan', 'length', 'max'=>30),
			array('namapengirim', 'length', 'max'=>50),
			array('tglpencucian, tglpenerimaan, keterangan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pencucianlinenumum_id, terimapencucianlinenumum_id, tglpencucian, tglpenerimaan, nopencucian, nopenerimaan, namapengirim, mesinpencucian_nama, keterangan', 'safe', 'on'=>'search'),
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
			'pencucianlinenumum_id' => 'Pencucianlinenumum',
			'terimapencucianlinenumum_id' => 'Terimapencucianlinenumum',
			'tglpencucian' => 'Tglpencucian',
			'tglpenerimaan' => 'Tglpenerimaan',
			'nopencucian' => 'No Pencucian',
			'nopenerimaan' => 'No Penerimaan',
			'namapengirim' => 'Nama Pengirim',
			'mesinpencucian_nama' => 'Mesin Pencucian',
			'keterangan' => 'Keterangan',
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

                if (!empty($this->pilihTanggal)){
                    if (!empty($this->tgl_masuk) && !empty($this->tgl_keluar)){
                        if ($this->pilihTanggal == 'penerimaan'){
                            $criteria->addBetweenCondition("DATE(tglpenerimaan)", $this->tgl_awal, $this->tgl_akhir);
                        }elseif ($this->pilihTanggal == 'pencucian'){
                            $criteria->addBetweenCondition("DATE(tglpencucian)", $this->tgl_awal, $this->tgl_akhir);
                        }
                    }
                }
		
		$criteria->compare('LOWER(nopencucian)', strtolower($this->nopencucian), true);
		$criteria->compare('LOWER(nopenerimaan)', strtolower($this->nopenerimaan), true);
		$criteria->compare('LOWER(namapengirim)', strtolower($this->namapengirim), true);
		$criteria->compare('LOWER(mesinpencucian_nama)', strtolower($this->mesinpencucian_nama));		
                $criteria->limit  = 10;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasipencucianlinenumumV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
