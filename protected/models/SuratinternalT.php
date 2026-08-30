<?php

/**
 * This is the model class for table "suratinternal_t".
 *
 * The followings are the available columns in table 'suratinternal_t':
 * @property integer $suratinternal_id
 * @property string $jenissurat
 * @property string $tglsurat
 * @property string $nomorsurat
 * @property string $asalsurat
 * @property string $tujuansurat
 * @property string $perihal
 * @property string $tglmulaiberlaku
 * @property string $tglakhirberlaku
 * @property string $judul
 * @property string $tgldisposisi
 * @property string $jenisdistribusi
 * @property integer $unitkerja_penanggungjawab_id
 * @property string $dokumen
 * @property string $statussurat
 */
class SuratinternalT extends CActiveRecord
{
	public $unitkerja_penanggungjawab_nama, $tgl_awal, $tgl_akhir;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suratinternal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unitkerja_penanggungjawab_id', 'numerical', 'integerOnly'=>true),
			array('jenissurat, nomorsurat, jenisdistribusi, statussurat', 'length', 'max'=>20),
			array('tipesurat', 'length', 'max'=>50),
			array('asalsurat, tujuansurat, judul', 'length', 'max'=>100),
			array('perihal', 'length', 'max'=>300),
			array('dokumen, pihak1, pihak2', 'length', 'max'=>200),
			array('tglsurat, tglmulaiberlaku, tglakhirberlaku, tgldisposisi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suratinternal_id, jenissurat, tglsurat, nomorsurat, asalsurat, tujuansurat, perihal, tglmulaiberlaku, tglakhirberlaku, judul, tgldisposisi, jenisdistribusi, unitkerja_penanggungjawab_id, dokumen, statussurat, tipesurat, pihak1, pihak2', 'safe', 'on'=>'search'),
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
			'suratinternal_id' => 'Suratinternal',
			'jenissurat' => 'Jenissurat',
			'tglsurat' => 'Tglsurat',
			'nomorsurat' => 'Nomorsurat',
			'asalsurat' => 'Asalsurat',
			'tujuansurat' => 'Tujuansurat',
			'perihal' => 'Perihal',
			'tglmulaiberlaku' => 'Tglmulaiberlaku',
			'tglakhirberlaku' => 'Tglakhirberlaku',
			'judul' => 'Judul',
			'tgldisposisi' => 'Tgldisposisi',
			'jenisdistribusi' => 'Jenisdistribusi',
			'unitkerja_penanggungjawab_id' => 'Unitkerja Penanggungjawab',
			'dokumen' => 'Dokumen',
			'statussurat' => 'Statussurat',
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

		$criteria->compare('suratinternal_id',$this->suratinternal_id);
		$criteria->compare('jenissurat',$this->jenissurat,true);
		$criteria->compare('tglsurat',$this->tglsurat,true);
		$criteria->compare('nomorsurat',$this->nomorsurat,true);
		$criteria->compare('asalsurat',$this->asalsurat,true);
		$criteria->compare('tujuansurat',$this->tujuansurat,true);
		$criteria->compare('perihal',$this->perihal,true);
		$criteria->compare('tglmulaiberlaku',$this->tglmulaiberlaku,true);
		$criteria->compare('tglakhirberlaku',$this->tglakhirberlaku,true);
		$criteria->compare('judul',$this->judul,true);
		$criteria->compare('tgldisposisi',$this->tgldisposisi,true);
		$criteria->compare('jenisdistribusi',$this->jenisdistribusi,true);
		$criteria->compare('unitkerja_penanggungjawab_id',$this->unitkerja_penanggungjawab_id);
		$criteria->compare('dokumen',$this->dokumen,true);
		$criteria->compare('statussurat',$this->statussurat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuratinternalT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('tglsurat::date',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('jenissurat',$this->jenissurat,false);
		$criteria->compare('statussurat',$this->statussurat,false);
		$criteria->compare('lower(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('lower(asalsurat)',strtolower($this->asalsurat),true);
		$criteria->compare('lower(tujuansurat)',strtolower($this->tujuansurat),true);
		$criteria->compare('lower(perihal)',strtolower($this->perihal),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
