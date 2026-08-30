<?php

/**
 * This is the model class for table "pengambilanobat_triagedet_t".
 *
 * The followings are the available columns in table 'pengambilanobat_triagedet_t':
 * @property integer $pengambilanobat_triagedet_id
 * @property string $tgl_resep
 * @property string $noresep_triage
 * @property integer $petugasfarmasi_id
 * @property integer $petugasigd_id
 * @property integer $obatalkes_id
 * @property integer $jumlah
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 */
class PengambilanobatTriagedetT extends CActiveRecord
{
	public $nobed_triage, $petugasfarmasi_nama, $petugasigd_nama, $obatalkes_nama, 
	$petugas_pengambil_obat, $nama_pasien, $hargasatuan_reseptur, $sumberdana_id, $stfornas;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengambilanobat_triagedet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_resep, noresep_triage, petugasfarmasi_id, petugasigd_id, obatalkes_id, jumlah, create_time', 'required'),
			array('petugasfarmasi_id, petugasigd_id, obatalkes_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('noresep_triage', 'length', 'max'=>50),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pengambilanobat_triagedet_id, tgl_resep, noresep_triage, petugasfarmasi_id, petugasigd_id, obatalkes_id, jumlah, keterangan, create_time, update_time', 'safe', 'on'=>'search'),
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
			'pengambilanobat_triagedet_id' => 'Pengambilanobat Triagedet',
			'pengambilanobat_triage_id' => 'Pengambilan obat',
			'tgl_resep' => 'Tgl Resep',
			'noresep_triage' => 'Noresep Triage',
			'petugasfarmasi_id' => 'Petugasfarmasi',
			'petugasigd_id' => 'Petugasigd',
			'obatalkes_id' => 'Obatalkes',
			'jumlah' => 'Jumlah',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('pengambilanobat_triagedet_id',$this->pengambilanobat_triagedet_id);
		$criteria->compare('tgl_resep',$this->tgl_resep,true);
		$criteria->compare('noresep_triage',$this->noresep_triage,true);
		$criteria->compare('petugasfarmasi_id',$this->petugasfarmasi_id);
		$criteria->compare('petugasigd_id',$this->petugasigd_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PengambilanobatTriagedetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
