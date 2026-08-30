<?php

/**
 * This is the model class for table "resepturokdet_t".
 *
 * The followings are the available columns in table 'resepturokdet_t':
 * @property integer $resepturokdet_id
 * @property integer $resepturok_id
 * @property integer $obatalkes_id
 * @property integer $jumlah
 * @property boolean $validasi
 * @property string $keterangan
 * @property integer $sumberdana_id
 * @property integer $hargasatuan_reseptur
 * @property boolean $st_fornas
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 */
class ResepturokdetT extends CActiveRecord
{
	public $nama_pasien, $noresep_ok, $petugasfarmasi_nama, $obatalkes_nama, $petugasfarmasi_id, $tglresep_ok;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resepturokdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resepturok_id, obatalkes_id', 'required'),
			array('resepturok_id, obatalkes_id, sumberdana_id, create_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('validasi, keterangan, st_fornas, update_time, hargasatuan_reseptur, paket_obat, jumlah', 'safe'),

			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resepturokdet_id, resepturok_id, obatalkes_id, jumlah, validasi, keterangan, sumberdana_id, hargasatuan_reseptur, st_fornas, create_time, update_time, create_loginpemakai_id, create_ruangan, paket_obat', 'safe', 'on'=>'search'),
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
			'reseptur'=>array(self::BELONGS_TO, 'ResepturokT', 'resepturok_id'),
			'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resepturokdet_id' => 'Resepturokdet',
			'resepturok_id' => 'Resepturok',
			'obatalkes_id' => 'Obatalkes',
			'jumlah' => 'Jumlah',
			'validasi' => 'Validasi',
			'keterangan' => 'Keterangan',
			'sumberdana_id' => 'Sumberdana',
			'hargasatuan_reseptur' => 'Hargasatuan Reseptur',
			'st_fornas' => 'St Fornas',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'paket_obat' => 'Paket Obat'
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

		$criteria->compare('resepturokdet_id',$this->resepturokdet_id);
		$criteria->compare('resepturok_id',$this->resepturok_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('validasi',$this->validasi);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('st_fornas',$this->st_fornas);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchReseptur()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.resepturokdet_id',$this->resepturokdet_id);
		$criteria->compare('t.resepturok_id',$this->resepturok_id);
		$criteria->compare('t.obatalkes_id',$this->obatalkes_id);
		$criteria->compare('t.jumlah',$this->jumlah);
		$criteria->compare('t.validasi',$this->validasi);
		$criteria->compare('t.keterangan',$this->keterangan,true);
		$criteria->compare('t.sumberdana_id',$this->sumberdana_id);
		$criteria->compare('t.hargasatuan_reseptur',$this->hargasatuan_reseptur);
		$criteria->compare('t.st_fornas',$this->st_fornas);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);

		$criteria->join = " JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id 
							JOIN resepturok_t rs ON rs.resepturok_id = t.resepturok_id and penjualanresep_id is null";
		$criteria->compare('LOWER(o.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->order = '(CASE WHEN t.validasi = false THEN 0 ELSE 1 END)';



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResepturokdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
