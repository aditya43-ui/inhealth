<?php

/**
 * This is the model class for table "penerimaanspesimen_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'penerimaanspesimen_t':
 * @property integer $penerimaanspesimen_id
 * @property integer $pengirimanspesimen_id
 * @property string $tglterimaspesimen
 * @property string $no_terimaspesimen
 * @property integer $petugasterima_id
 * @property integer $ruangan_id
 * @property string $keterangan_penerimaan
 *
 * The followings are the available model relations:
 * @property PengirimanspesimenT $pengirimanspesimen
 * @property PenerimaanspesimendetT[] $penerimaanspesimendetTs
 */
class PenerimaanspesimenT extends CActiveRecord
{
    public $ruanganterima_nama, $ruangan_nama, $nama_pegawai, $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanspesimenT the static model class
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
		return 'penerimaanspesimen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengirimanspesimen_id, petugasterima_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('no_terimaspesimen', 'length', 'max'=>50),
			array('tglterimaspesimen, keterangan_penerimaan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanspesimen_id, pengirimanspesimen_id, tglterimaspesimen, no_terimaspesimen, petugasterima_id, ruangan_id, keterangan_penerimaan', 'safe', 'on'=>'search'),
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
                    'pengirimanspesimen' => array(self::BELONGS_TO, 'PengirimanspesimenT', 'pengirimanspesimen_id'),
                    'penerimaanspesimendetTs' => array(self::HAS_MANY, 'PenerimaanspesimendetT', 'penerimaanspesimen_id'),
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'petugasterima_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanspesimen_id' => 'Penerimaanspesimen',
			'pengirimanspesimen_id' => 'Pengirimanspesimen',
			'tglterimaspesimen' => 'Tglterimaspesimen',
			'no_terimaspesimen' => 'No Terimaspesimen',
			'petugasterima_id' => 'Petugasterima',
			'ruangan_id' => 'Ruangan',
			'keterangan_penerimaan' => 'Keterangan Penerimaan',
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

		$criteria->compare('penerimaanspesimen_id',$this->penerimaanspesimen_id);
		$criteria->compare('pengirimanspesimen_id',$this->pengirimanspesimen_id);
		$criteria->compare('tglterimaspesimen',$this->tglterimaspesimen,true);
		$criteria->compare('no_terimaspesimen',$this->no_terimaspesimen,true);
		$criteria->compare('petugasterima_id',$this->petugasterima_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('keterangan_penerimaan',$this->keterangan_penerimaan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        /**
         * Load data informasi penerimaan spesimen
         * Filter berdasarahkan batalpenerimaanspesimen_id IS NULL
         * @return \CActiveDataProvider
         */
        public function searchInformasi(){
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(t.tglterimaspesimen)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->join = "LEFT JOIN pegawai_m ON t.petugasterima_id = pegawai_m.pegawai_id "
                            . "LEFT JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id ";
            $criteria->select = "t.*, pegawai_m.nama_pegawai, ruangan_m.ruangan_nama ";
            $criteria->addCondition('batalpenerimaanspesimen_id IS NULL');
            $criteria->addCondition('t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($this->nama_pegawai),true);
            $criteria->compare('penerimaanspesimen_id',$this->penerimaanspesimen_id);
            $criteria->compare('pengirimanspesimen_id',$this->pengirimanspesimen_id);
            $criteria->compare('tglterimaspesimen',$this->tglterimaspesimen,true);
            $criteria->compare('no_terimaspesimen',$this->no_terimaspesimen,true);
            $criteria->compare('petugasterima_id',$this->petugasterima_id);
            $criteria->compare('keterangan_penerimaan',$this->keterangan_penerimaan,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}