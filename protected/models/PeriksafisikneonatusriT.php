<?php

/**
 * This is the model class for table "periksafisikneonatusri_t".
 *
 * The followings are the available columns in table 'periksafisikneonatusri_t':
 * @property integer $periksafisikneonatusri_id
 * @property integer $asesmenawalkeperawatan_id
 * @property string $kepala_kesimetrisan
 * @property boolean $kepala_iscephalhematoma
 * @property boolean $kepala_iscaputsuccedanium
 * @property boolean $kepala_isanencephali
 * @property boolean $kepala_ismicrocephali
 * @property boolean $kepala_ishydrocephali
 * @property boolean $kepala_islainnya
 * @property string $kepala_lainnyaket
 * @property string $ubunubunbesar_status
 * @property string $ubunubunbesar_ket
 * @property string $mata_status
 * @property string $mata_ket
 * @property boolean $tht_isnormal
 * @property boolean $tht_isnch
 * @property boolean $tht_iscianosis
 * @property boolean $tht_islainnya
 * @property string $tht_lainnyaket
 * @property boolean $mulut_isnormal
 * @property boolean $mulut_islabioschzis
 * @property boolean $mulut_islabiognatopalatoschizis
 * @property boolean $mulut_islainnya
 * @property string $mulut_lainnyaket
 * @property string $mulut_mukosa
 * @property string $mulut_mukosalainnya
 * @property string $thorax_status
 * @property string $thorax_lainnya
 * @property boolean $abdomen_isnormal
 * @property boolean $abdomen_isdistensi
 * @property boolean $abdomen_isomphalocele
 * @property boolean $abdomen_isbisingusus
 * @property boolean $abdomen_islainnya
 * @property string $abdomen_lainnyaket
 * @property boolean $punggung_isnormal
 * @property boolean $punggung_isspina_bifida
 * @property boolean $punggung_isgibus
 * @property boolean $punggung_islainnya
 * @property boolean $punggung_lainnyaket
 * @property boolean $genitalia_iskelainan
 * @property string $genitalia_kelainanket
 * @property boolean $genitalia_ishermaprodit
 * @property boolean $genitalia_islainnya
 * @property string $genitalia_lainnyaket
 * @property string $anus_isada
 * @property string $ekstremitas_simetris
 * @property boolean $ekstremitas_islainnya
 * @property string $ekstremitas_islainnyaket
 * @property string $kulit_turgor
 * @property boolean $kulit_ismarmorata
 * @property boolean $kulit_issianosis
 * @property boolean $kulit_ispendarahan
 * @property boolean $kulit_ishematoma
 * @property boolean $kulit_issklerema
 * @property boolean $kulit_islainnya
 * @property string $kulit_lainnyaket
 * @property boolean $reflek_ismoro
 * @property string $reflek_moroket
 * @property boolean $reflek_israsping
 * @property string $reflek_raspingket
 * @property boolean $reflek_issucking
 * @property string $reflek_suckingket
 * @property boolean $reflek_isrooting
 * @property string $reflek_rootingket
 * @property boolean $reflek_isstepping
 * @property string $reflek_steppingket
 * @property boolean $reflek_isswallowing
 * @property string $reflek_swallowingket
 * @property boolean $reflek_isbabinski
 * @property string $reflek_babinskiket
 * @property boolean $reflek_isglabela
 * @property string $reflek_glabelaket
 * @property boolean $reflek_istonickneck
 * @property string $reflek_tonickneckket
 * @property boolean $reflek_islainnya
 * @property string $reflek_lainnyaket
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class PeriksafisikneonatusriT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksafisikneonatusriT the static model class
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
		return 'periksafisikneonatusri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenawalkeperawatan_id, create_loginpemakai', 'required'),
			array('asesmenawalkeperawatan_id, create_petugaspengisi_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kepala_kesimetrisan, anus_isada, ekstremitas_simetris', 'length', 'max'=>20),
			array('ubunubunbesar_status, mata_status', 'length', 'max'=>50),
			array('thorax_status, kulit_turgor, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('kepala_iscephalhematoma, kepala_iscaputsuccedanium, kepala_isanencephali, kepala_ismicrocephali, kepala_ishydrocephali, kepala_islainnya, kepala_lainnyaket, ubunubunbesar_ket, mata_ket, tht_isnormal, tht_isnch, tht_iscianosis, tht_islainnya, tht_lainnyaket, mulut_isnormal, mulut_islabioschzis, mulut_islabiognatopalatoschizis, mulut_islainnya, mulut_lainnyaket, mulut_mukosa, mulut_mukosalainnya, thorax_lainnya, abdomen_isnormal, abdomen_isdistensi, abdomen_isomphalocele, abdomen_isbisingusus, abdomen_islainnya, abdomen_lainnyaket, punggung_isnormal, punggung_isspina_bifida, punggung_isgibus, punggung_islainnya, punggung_lainnyaket, genitalia_iskelainan, genitalia_kelainanket, genitalia_ishermaprodit, genitalia_islainnya, genitalia_lainnyaket, ekstremitas_islainnya, ekstremitas_islainnyaket, kulit_ismarmorata, kulit_issianosis, kulit_ispendarahan, kulit_ishematoma, kulit_issklerema, kulit_islainnya, kulit_lainnyaket, reflek_ismoro, reflek_moroket, reflek_israsping, reflek_raspingket, reflek_issucking, reflek_suckingket, reflek_isrooting, reflek_rootingket, reflek_isstepping, reflek_steppingket, reflek_isswallowing, reflek_swallowingket, reflek_isbabinski, reflek_babinskiket, reflek_isglabela, reflek_glabelaket, reflek_istonickneck, reflek_tonickneckket, reflek_islainnya, reflek_lainnyaket, create_time, update_time, tht_issekret', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksafisikneonatusri_id, asesmenawalkeperawatan_id, kepala_kesimetrisan, kepala_iscephalhematoma, kepala_iscaputsuccedanium, kepala_isanencephali, kepala_ismicrocephali, kepala_ishydrocephali, kepala_islainnya, kepala_lainnyaket, ubunubunbesar_status, ubunubunbesar_ket, mata_status, mata_ket, tht_isnormal, tht_isnch, tht_iscianosis, tht_islainnya, tht_lainnyaket, mulut_isnormal, mulut_islabioschzis, mulut_islabiognatopalatoschizis, mulut_islainnya, mulut_lainnyaket, mulut_mukosa, mulut_mukosalainnya, thorax_status, thorax_lainnya, abdomen_isnormal, abdomen_isdistensi, abdomen_isomphalocele, abdomen_isbisingusus, abdomen_islainnya, abdomen_lainnyaket, punggung_isnormal, punggung_isspina_bifida, punggung_isgibus, punggung_islainnya, punggung_lainnyaket, genitalia_iskelainan, genitalia_kelainanket, genitalia_ishermaprodit, genitalia_islainnya, genitalia_lainnyaket, anus_isada, ekstremitas_simetris, ekstremitas_islainnya, ekstremitas_islainnyaket, kulit_turgor, kulit_ismarmorata, kulit_issianosis, kulit_ispendarahan, kulit_ishematoma, kulit_issklerema, kulit_islainnya, kulit_lainnyaket, reflek_ismoro, reflek_moroket, reflek_israsping, reflek_raspingket, reflek_issucking, reflek_suckingket, reflek_isrooting, reflek_rootingket, reflek_isstepping, reflek_steppingket, reflek_isswallowing, reflek_swallowingket, reflek_isbabinski, reflek_babinskiket, reflek_isglabela, reflek_glabelaket, reflek_istonickneck, reflek_tonickneckket, reflek_islainnya, reflek_lainnyaket, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan, tht_issekret', 'safe', 'on'=>'search'),
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
			'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksafisikneonatusri_id' => 'Periksafisikneonatusri',
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'kepala_kesimetrisan' => 'Kepala Kesimetrisan',
			'kepala_iscephalhematoma' => 'Kepala Iscephalhematoma',
			'kepala_iscaputsuccedanium' => 'Kepala Iscaputsuccedanium',
			'kepala_isanencephali' => 'Kepala Isanencephali',
			'kepala_ismicrocephali' => 'Kepala Ismicrocephali',
			'kepala_ishydrocephali' => 'Kepala Ishydrocephali',
			'kepala_islainnya' => 'Kepala Islainnya',
			'kepala_lainnyaket' => 'Kepala Lainnyaket',
			'ubunubunbesar_status' => 'Ubunubunbesar Status',
			'ubunubunbesar_ket' => 'Ubunubunbesar Ket',
			'mata_status' => 'Mata Status',
			'mata_ket' => 'Mata Ket',
			'tht_isnormal' => 'Tht Isnormal',
			'tht_isnch' => 'Tht Isnch',
			'tht_iscianosis' => 'Tht Iscianosis',
			'tht_islainnya' => 'Tht Islainnya',
			'tht_lainnyaket' => 'Tht Lainnyaket',
			'mulut_isnormal' => 'Mulut Isnormal',
			'mulut_islabioschzis' => 'Mulut Islabioschzis',
			'mulut_islabiognatopalatoschizis' => 'Mulut Islabiognatopalatoschizis',
			'mulut_islainnya' => 'Mulut Islainnya',
			'mulut_lainnyaket' => 'Mulut Lainnyaket',
			'mulut_mukosa' => 'Mulut Mukosa',
			'mulut_mukosalainnya' => 'Mulut Mukosalainnya',
			'thorax_status' => 'Thorax Status',
			'thorax_lainnya' => 'Thorax Lainnya',
			'abdomen_isnormal' => 'Abdomen Isnormal',
			'abdomen_isdistensi' => 'Abdomen Isdistensi',
			'abdomen_isomphalocele' => 'Abdomen Isomphalocele',
			'abdomen_isbisingusus' => 'Abdomen Isbisingusus',
			'abdomen_islainnya' => 'Abdomen Islainnya',
			'abdomen_lainnyaket' => 'Abdomen Lainnyaket',
			'punggung_isnormal' => 'Punggung Isnormal',
			'punggung_isspina_bifida' => 'Punggung Isspina Bifida',
			'punggung_isgibus' => 'Punggung Isgibus',
			'punggung_islainnya' => 'Punggung Islainnya',
			'punggung_lainnyaket' => 'Punggung Lainnyaket',
			'genitalia_iskelainan' => 'Genitalia Iskelainan',
			'genitalia_kelainanket' => 'Genitalia Kelainanket',
			'genitalia_ishermaprodit' => 'Genitalia Ishermaprodit',
			'genitalia_islainnya' => 'Genitalia Islainnya',
			'genitalia_lainnyaket' => 'Genitalia Lainnyaket',
			'anus_isada' => 'Anus Isada',
			'ekstremitas_simetris' => 'Ekstremitas Simetris',
			'ekstremitas_islainnya' => 'Ekstremitas Islainnya',
			'ekstremitas_islainnyaket' => 'Ekstremitas Islainnyaket',
			'kulit_turgor' => 'Kulit Turgor',
			'kulit_ismarmorata' => 'Kulit Ismarmorata',
			'kulit_issianosis' => 'Kulit Issianosis',
			'kulit_ispendarahan' => 'Kulit Ispendarahan',
			'kulit_ishematoma' => 'Kulit Ishematoma',
			'kulit_issklerema' => 'Kulit Issklerema',
			'kulit_islainnya' => 'Kulit Islainnya',
			'kulit_lainnyaket' => 'Kulit Lainnyaket',
			'reflek_ismoro' => 'Reflek Ismoro',
			'reflek_moroket' => 'Reflek Moroket',
			'reflek_israsping' => 'Reflek Israsping',
			'reflek_raspingket' => 'Reflek Raspingket',
			'reflek_issucking' => 'Reflek Issucking',
			'reflek_suckingket' => 'Reflek Suckingket',
			'reflek_isrooting' => 'Reflek Isrooting',
			'reflek_rootingket' => 'Reflek Rootingket',
			'reflek_isstepping' => 'Reflek Isstepping',
			'reflek_steppingket' => 'Reflek Steppingket',
			'reflek_isswallowing' => 'Reflek Isswallowing',
			'reflek_swallowingket' => 'Reflek Swallowingket',
			'reflek_isbabinski' => 'Reflek Isbabinski',
			'reflek_babinskiket' => 'Reflek Babinskiket',
			'reflek_isglabela' => 'Reflek Isglabela',
			'reflek_glabelaket' => 'Reflek Glabelaket',
			'reflek_istonickneck' => 'Reflek Istonickneck',
			'reflek_tonickneckket' => 'Reflek Tonickneckket',
			'reflek_islainnya' => 'Reflek Islainnya',
			'reflek_lainnyaket' => 'Reflek Lainnyaket',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('periksafisikneonatusri_id',$this->periksafisikneonatusri_id);
		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('kepala_kesimetrisan',$this->kepala_kesimetrisan,true);
		$criteria->compare('kepala_iscephalhematoma',$this->kepala_iscephalhematoma);
		$criteria->compare('kepala_iscaputsuccedanium',$this->kepala_iscaputsuccedanium);
		$criteria->compare('kepala_isanencephali',$this->kepala_isanencephali);
		$criteria->compare('kepala_ismicrocephali',$this->kepala_ismicrocephali);
		$criteria->compare('kepala_ishydrocephali',$this->kepala_ishydrocephali);
		$criteria->compare('kepala_islainnya',$this->kepala_islainnya);
		$criteria->compare('kepala_lainnyaket',$this->kepala_lainnyaket,true);
		$criteria->compare('ubunubunbesar_status',$this->ubunubunbesar_status,true);
		$criteria->compare('ubunubunbesar_ket',$this->ubunubunbesar_ket,true);
		$criteria->compare('mata_status',$this->mata_status,true);
		$criteria->compare('mata_ket',$this->mata_ket,true);
		$criteria->compare('tht_isnormal',$this->tht_isnormal);
		$criteria->compare('tht_isnch',$this->tht_isnch);
		$criteria->compare('tht_iscianosis',$this->tht_iscianosis);
		$criteria->compare('tht_islainnya',$this->tht_islainnya);
		$criteria->compare('tht_lainnyaket',$this->tht_lainnyaket,true);
		$criteria->compare('mulut_isnormal',$this->mulut_isnormal);
		$criteria->compare('mulut_islabioschzis',$this->mulut_islabioschzis);
		$criteria->compare('mulut_islabiognatopalatoschizis',$this->mulut_islabiognatopalatoschizis);
		$criteria->compare('mulut_islainnya',$this->mulut_islainnya);
		$criteria->compare('mulut_lainnyaket',$this->mulut_lainnyaket,true);
		$criteria->compare('mulut_mukosa',$this->mulut_mukosa,true);
		$criteria->compare('mulut_mukosalainnya',$this->mulut_mukosalainnya,true);
		$criteria->compare('thorax_status',$this->thorax_status,true);
		$criteria->compare('thorax_lainnya',$this->thorax_lainnya,true);
		$criteria->compare('abdomen_isnormal',$this->abdomen_isnormal);
		$criteria->compare('abdomen_isdistensi',$this->abdomen_isdistensi);
		$criteria->compare('abdomen_isomphalocele',$this->abdomen_isomphalocele);
		$criteria->compare('abdomen_isbisingusus',$this->abdomen_isbisingusus);
		$criteria->compare('abdomen_islainnya',$this->abdomen_islainnya);
		$criteria->compare('abdomen_lainnyaket',$this->abdomen_lainnyaket,true);
		$criteria->compare('punggung_isnormal',$this->punggung_isnormal);
		$criteria->compare('punggung_isspina_bifida',$this->punggung_isspina_bifida);
		$criteria->compare('punggung_isgibus',$this->punggung_isgibus);
		$criteria->compare('punggung_islainnya',$this->punggung_islainnya);
		$criteria->compare('punggung_lainnyaket',$this->punggung_lainnyaket);
		$criteria->compare('genitalia_iskelainan',$this->genitalia_iskelainan);
		$criteria->compare('genitalia_kelainanket',$this->genitalia_kelainanket,true);
		$criteria->compare('genitalia_ishermaprodit',$this->genitalia_ishermaprodit);
		$criteria->compare('genitalia_islainnya',$this->genitalia_islainnya);
		$criteria->compare('genitalia_lainnyaket',$this->genitalia_lainnyaket,true);
		$criteria->compare('anus_isada',$this->anus_isada,true);
		$criteria->compare('ekstremitas_simetris',$this->ekstremitas_simetris,true);
		$criteria->compare('ekstremitas_islainnya',$this->ekstremitas_islainnya);
		$criteria->compare('ekstremitas_islainnyaket',$this->ekstremitas_islainnyaket,true);
		$criteria->compare('kulit_turgor',$this->kulit_turgor,true);
		$criteria->compare('kulit_ismarmorata',$this->kulit_ismarmorata);
		$criteria->compare('kulit_issianosis',$this->kulit_issianosis);
		$criteria->compare('kulit_ispendarahan',$this->kulit_ispendarahan);
		$criteria->compare('kulit_ishematoma',$this->kulit_ishematoma);
		$criteria->compare('kulit_issklerema',$this->kulit_issklerema);
		$criteria->compare('kulit_islainnya',$this->kulit_islainnya);
		$criteria->compare('kulit_lainnyaket',$this->kulit_lainnyaket,true);
		$criteria->compare('reflek_ismoro',$this->reflek_ismoro);
		$criteria->compare('reflek_moroket',$this->reflek_moroket,true);
		$criteria->compare('reflek_israsping',$this->reflek_israsping);
		$criteria->compare('reflek_raspingket',$this->reflek_raspingket,true);
		$criteria->compare('reflek_issucking',$this->reflek_issucking);
		$criteria->compare('reflek_suckingket',$this->reflek_suckingket,true);
		$criteria->compare('reflek_isrooting',$this->reflek_isrooting);
		$criteria->compare('reflek_rootingket',$this->reflek_rootingket,true);
		$criteria->compare('reflek_isstepping',$this->reflek_isstepping);
		$criteria->compare('reflek_steppingket',$this->reflek_steppingket,true);
		$criteria->compare('reflek_isswallowing',$this->reflek_isswallowing);
		$criteria->compare('reflek_swallowingket',$this->reflek_swallowingket,true);
		$criteria->compare('reflek_isbabinski',$this->reflek_isbabinski);
		$criteria->compare('reflek_babinskiket',$this->reflek_babinskiket,true);
		$criteria->compare('reflek_isglabela',$this->reflek_isglabela);
		$criteria->compare('reflek_glabelaket',$this->reflek_glabelaket,true);
		$criteria->compare('reflek_istonickneck',$this->reflek_istonickneck);
		$criteria->compare('reflek_tonickneckket',$this->reflek_tonickneckket,true);
		$criteria->compare('reflek_islainnya',$this->reflek_islainnya);
		$criteria->compare('reflek_lainnyaket',$this->reflek_lainnyaket,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
