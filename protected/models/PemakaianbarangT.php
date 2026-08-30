<?php

/**
 * This is the model class for table "pemakaianbarang_t".
 *
 * The followings are the available columns in table 'pemakaianbarang_t':
 * @property integer $pemakaianbarang_id
 * @property integer $pindahkamar_id
 * @property integer $ruangan_id
 * @property string $tglpemakaianbrg
 * @property string $nopemakaianbrg
 * @property string $untukkeperluan
 * @property string $keteranganpakai
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PemakaianbrgdetailT[] $pemakaianbrgdetailTs
 * @property PindahkamarT $pindahkamar
 * @property RuanganM $ruangan
 */
class PemakaianbarangT extends CActiveRecord
{
    public $tglAwal;
    public $tglAkhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianbarangT the static model class
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
		return 'pemakaianbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, tglpemakaianbrg, nopemakaianbrg, untukkeperluan, create_time, create_loginpemakai_id, create_ruangan, pegawai_id', 'required'),
			array('ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopemakaianbrg', 'length', 'max'=>20),
			array('untukkeperluan', 'length', 'max'=>500),
			array('keteranganpakai, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianbarang_id, ruangan_id, tglpemakaianbrg, nopemakaianbrg, untukkeperluan, keteranganpakai, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemakaianbrgdetail' => array(self::HAS_MANY, 'PemakaianbrgdetailT', 'pemakaianbarang_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                        'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianbarang_id' => 'Pemakaian Barang',
			'ruangan_id' => 'Ruangan',
			'tglpemakaianbrg' => 'Tanggal Pemakaian Barang',
			'nopemakaianbrg' => 'No. Pemakaian Barang',
			'untukkeperluan' => 'Untuk Keperluan',
			'keteranganpakai' => 'Keterangan Pakai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'pegawai_id' => 'Pegawai Mengetahui',
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

		$criteria->compare('pemakaianbarang_id',$this->pemakaianbarang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tglpemakaianbrg',$this->tglpemakaianbrg,true);
		$criteria->compare('nopemakaianbrg',$this->nopemakaianbrg,true);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('keteranganpakai',$this->keteranganpakai,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}