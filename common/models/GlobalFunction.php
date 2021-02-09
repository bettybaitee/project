<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

class GlobalFunction {
    public static function konfRujukan_getOpenReport($flag)
    {
        $count = KonfRujukan::find()
            ->where('rujukanFlag = :rujukanFlag AND rujukanDefault IS NULL AND rujukanDeleted IS NULL')
            ->params([':rujukanFlag' => $flag])
            ->count();

        if($count == 0) {
            $model = new KonfRujukan();
            $model->rujukanFlag = $flag;
            $model->rujukanNama = 'Generated on '.date('d/m/Y');
            $model->rujukanCreated = time();
            $model->save();
        }
        else {
            $model = KonfRujukan::find()
                ->where('rujukanFlag = :rujukanFlag AND rujukanDefault IS NULL AND rujukanDeleted IS NULL')
                ->params([':rujukanFlag' => $flag])
                ->one();

            $model->rujukanModified = time();
            $model->save();
        }

        return $model;
    }

    public static function konfRujukan_getRujukanByName($nama, $flag)
    {
        $rujukan = KonfRujukan::find()
            ->where([
                'rujukanNama' => $nama,
                'rujukanFlag' => $flag
            ])
            ->one();

        if ($rujukan)
            return $rujukan->id;
        else
            return NULL;
    }

    public static function konfRujukan_getRujukanWithDefault($flag, $default)
    {
        $rujukan = KonfRujukan::find()
            ->where([
                'rujukanDefault' => $default,
                'rujukanFlag' => $flag
            ])
            ->one();

        if ($rujukan)
            return $rujukan->id;
        else
            return NULL;
    }

    public static function konfStruktur_getAllWarrant($program, $countWarrant)
    {
        if($countWarrant == true) {
            $model = ViewKonfStruktur::find()
                ->groupBy('strCode')
                ->where('(prgId = :prgId  AND (strEnd IS NULL OR strEnd >= CURDATE())) AND strDeleted IS NULL AND strCode != ""')
                ->params([':prgId' => $program])
                ->all();

            foreach($model as $data) {
                $string = '';
                $pengisian = 0;

                foreach($data->konfStrukturdetails as $allGrade)
                    $string .= GlobalFunction::konfStrukturgred_getGradeById($allGrade->gredId, true).'/';

                $string = substr($string, 0, -1);
                $count = KonfStruktur::find()
                    ->where('(prgId = :prgId  AND (strEnd IS NULL OR strEnd >= CURDATE())) AND strDeleted IS NULL AND strCode = :strCode')
                    ->params([
                        ':prgId' => $program,
                        ':strCode' => $data->strCode
                    ])
                    ->all();

                foreach($count as $warrantInfo) {
                    $checkPengisian = GlobalFunction::profilPengisian_getPengisianWaranHolder($warrantInfo->strRef);

                    if($checkPengisian != null)
                        $pengisian++;
                }

                $data->pengisian = $pengisian;
                $data->applicableGrade = $string;
                $data->waran = sizeof($count);
            }
        }
        else {
            $model = ViewKonfStruktur::find()
                ->where('(prgId = :prgId  AND (strEnd IS NULL OR strEnd >= CURDATE())) AND strDeleted IS NULL AND strCode != ""')
                ->params([':prgId' => $program])
                ->all();

            foreach($model as $data) {
                $pegawai = GlobalFunction::profilPengisian_getPengisianWaranHolder($data->strRef);

                if($pegawai) 
                    $data->holder = $pegawai->id;
            }
        }

        return $model;
    }

    #MIS:TODO Set as private
    public static function konfStruktur_getDivisionStructure($allWarrant, $structures, $profile)
    {
        foreach($structures as $structure) {
            foreach($structure->konfStrukturdetails as $konfStrukturdetails) {
                if($profile->pengisianPenyandang == null) {
                    if($konfStrukturdetails->gredId == $profile->pengisianGred) {
                        if(GlobalFunction::profilPengisian_getValidFromPengisian($structure->strRef)) {
                            if($structure->strDeleted == null) {
                                $allWarrant[$structure->prg->prgName][$structure->strRef] = $structure->strAbv2.' - '.$structure->strTitle.' '.$structure->strCode;
                                break;
                            }
                        }
                    }
                }
                else {
                    if(($konfStrukturdetails->gredId == $profile->pengisianGred) OR ($konfStrukturdetails->gredId == $profile->pengisianPenyandang)) {
                        if(GlobalFunction::profilPengisian_getValidFromPengisian($structure->strRef)) {
                            if($structure->strDeleted == null) {
                                $allWarrant[$structure->prg->prgName][$structure->strRef] = $structure->strAbv2.' - '.$structure->strTitle.' '.$structure->strCode;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $allWarrant;
    }

    public static function konfStruktur_getPengisianAbv($waran)
    {
        $return = '';
        $model = KonfStruktur::find()
            ->where('strRef = :strRef')
            ->params([':strRef' => $waran])
            ->one();

        if($model->strAbv2 != $model->strAbv)
            $return = $model->strAbv2;
        else
            $return = $model->strAbv;

        if($return == null)
            $return = $model->strCode;

        return $return;
    }

    #MIS:TODO Set as private
    public static function konfStruktur_getStructure($prgId)
    {
        $structures = KonfStruktur::find()
            ->where('
                prgId = :prgId
                AND (
                    strEnd IS NULL
                    OR strEnd >= CURDATE()
                )
            ')
            ->params([
                ':prgId' => $prgId
            ])
            ->orderBy('strTitle')
            ->all();

        return $structures;
    }

    public static function konfStruktur_getWarrantTitle($waran)
    {
        $model = KonfStruktur::find()
            ->where(['strRef' => $waran])
            ->one();

        if(!$model)
            return null;
        else
            return $model->strTitle;
    }

    public static function konfStrukturGred_getAllGrade($filter = false)
    {
        if ($filter)
            $addFilter = ' AND skimFlag != 2';
        else
            $addFilter = '';

        $array = [];

        $model = KonfStrukturskim::find()
            ->where('skimDeleted IS NULL'.$addFilter)
            ->orderBy('skimCode')
            ->all();

        foreach ($model as $data) {
            if (sizeof($data->konfStrukturgreds) > 0) {
                $gradeList = KonfStrukturgred::find()
                    ->where('gredDeleted IS NULL AND gredSkim = '.$data->id)
                    ->orderBy('gred DESC, gred2 DESC')
                    ->all();

                foreach ($gradeList as $gred)
                    $array[$data->skimName][$gred->id] = $data->skimCode.$gred->gred.$gred->gred2.($gred->gredServis0 == null ? '' : ' - '.$gred->gredServis0->rujukanNama);
            }
        }

        return $array;
    }

    public static function konfStrukturgred_getGradeById($id, $full = false)
    {
        $model = KonfStrukturgred::findOne($id);

        if(!$full)
            $string = $model->gredSkim0->skimCode.$model->gred.$model->gred2.($model->gredServis0 == null ? '' : ' - '.$model->gredServis0->rujukanNama);
        else
            $string = $model->gredSkim0->skimCode.$model->gred.$model->gred2;

        return $string;
    }

    public static function konfStrukturgred_getGradeByIdFiltered($id, $full = false)
    {
        $model = KonfStrukturgred::findOne($id);

        if(!$full)
            $string = $model->gredSkim0->skimCode.$model->gred.($model->gredServis0 == null ? '' : ' - '.$model->gredServis0->rujukanNama);
        else
            $string = $model->gredSkim0->skimCode.$model->gred;

        return $string;
    }

    public static function konfStrukturref_generateRef($length)
    {
        $str = Yii::$app->security->generateRandomString($length);
        $model = KonfStrukturref::find()
            ->where(['strRef' => $str])
            ->one();

        if ($model != null)
            $str = GlobalFunction::konfStrukturref_generateRef($length);

        return $str;
    }

    public static function profil_getAllUsers($filtered = false)
    {
        $model = Profil::find()
            ->joinWith('profilAccount')
            ->where('status = 10')
            ->all();

        foreach ($model as $data) {
            $bahagian = $pk = '';
            $pengisian = GlobalFunction::profilPengisian_getCurrentBahagian($data->id);

            if(isset($pengisian->pengisianBahagian0->prgAbv))
                $bahagian = '['.$pengisian->pengisianBahagian0->prgAbv.'] ';

            if(Yii::$app->params['dev'])
                $pk = '['.$data->id.'] ';

            if(!$filtered)
                $array[$data->id] = $bahagian.$pk.GlobalFunction::profil_getFullProfileName($data->id);
            else {
                if($bahagian != '')
                    $array[$data->id] = $bahagian.$pk.GlobalFunction::profil_getFullProfileName($data->id);
            }
        }

        return $array;
    }

    public static function profil_getAllUsersDivision($filtered = false)
    {
        $array = [];

        $model = Profil::find()
            ->joinWith('profilAccount')
            ->where('status = 10')
            ->all();

        foreach ($model as $data) {
            $bahagian = $pk = '';
            $pengisian = GlobalFunction::profilPengisian_getCurrentBahagian($data->id);

            if($pengisian !== null) {
                if($filtered === $pengisian->pengisianBahagian) {
                    $array[$data->id] = $bahagian.$pk.GlobalFunction::profil_getFullProfileName($data->id);
                }
            }
        }

        return $array;
    }

    public static function profil_getAllUsersForSSO()
    {
        $model = Profil::find()
            ->where('profilSso IS NULL')
            ->joinWith('profilAccount')
            ->all();

        $array[0] = 'Skip';

        foreach ($model as $data)
            $array[$data->id] = $data->profilAccount->username.' - '.GlobalFunction::profil_getFullProfileName($data->id);

        return $array;
    }

    public static function profil_getFullProfileName($id)
    {
        $model = Profil::findOne($id);

        if($model === null)
            $fullName = null;
        else {
            $fullName = ($model->profilGelaran == NULL ? '' : $model->profilGelaran0->rujukanNama.' ');
            $fullName .= $model->profilNamaPertama.' ';
            $fullName .= ($model->profilAffix == NULL ? '' : $model->profilAffix0->rujukanNama.' ');
            $fullName .= $model->profilNamaAkhir;
        }

        return $fullName;
    }

    public static function profil_getShortProfileName($id)
    {
        $model = Profil::findOne($id);

        if($model === null)
            $fullName = null;
        else {
            $fullName = ($model->profilGelaran == NULL ? '' : $model->profilGelaran0->rujukanNama.' ');
            $fullName .= $model->profilNamaPertama;
        }

        return $fullName;
    }

    public static function profil_getMigratedCount()
    {
        $model = Profil::find()
            ->where('profilMigrated IS NULL')
            ->count();

        if($model > 0)
            return true;
        else
            return false;
    }

    public static function profilAccount_checkEmailExist($profil)
    {
        $email = $profil->profilAccount->email.'@%';

        $model = ProfilAccount::find()
            ->where('`status` = 10 AND email LIKE :email')
            ->params([':email' => $email])
            ->count();

        return $model;
    }

    public static function profilPengisian_getCurrentBahagian($user = false)
    {
        if(!$user)
            $user = Yii::$app->user->id;

        $model = ProfilPengisian::find()
            ->where(
                'pengisianProfil = '.$user
                .' AND (pengisianEnd IS NULL OR pengisianEnd >= CURDATE())'
            )
            ->one();

        if($model == null)
            return null;
        else
            return $model;
    }

    public static function profilPengisian_getPengisianWaran($waran)
    {
        $model = ProfilPengisian::find()
            ->where('pengisianWaran = "'.$waran.'" AND (pengisianEnd IS NULL OR pengisianEnd >= CURDATE())')
            ->one();

        return ($model == null ? null : GlobalFunction::profil_getFullProfileName($model->pengisianProfil));
    }

    public static function profilPengisian_getPengisianWaranHolder($waran)
    {
        $model = ProfilPengisian::find()
            ->where('pengisianWaran = "'.$waran.'" AND (pengisianEnd IS NULL OR pengisianEnd >= CURDATE())')
            ->one();

        if($model)
            $holder = Profil::findOne($model->pengisianProfil);
        else
            $holder = null;

        return $holder;
    }

    private static function profilPengisian_getValidFromPengisian($pengisianWaran)
    {
        $model = ProfilPengisian::find()
            ->where(
                'pengisianWaran = "'.$pengisianWaran.'" '
                .'AND (pengisianEnd IS NULL OR pengisianEnd >= CURDATE())'
            )
            ->count();

        if($model > 0)
            return false;
        else
            return true;
    }

    public static function rbacBiopolicy_getAllMyPolicy()
    {
        if(!Yii::$app->user->isGuest) {
            $model = RbacBiopolicy::find()
                ->where('rbacProfil = '.Yii::$app->user->id)
                ->all();
        }
        else
            $model = null;

        return $model;
    }

    public static function rbacBiopolicy_getAuthHolder($array)
    {
        $list = [];

        foreach($array as $data) {
            $holder = GlobalFunction::rbacPolicy_getPolicyHolder($data);

            foreach($holder as $biopolicy)
                $list[$biopolicy->rbacProfil] = GlobalFunction::profil_getFullProfileName($biopolicy->rbacProfil);
        }

        return $list;
    }

    public static function rbacBiopolicy_getMyAuth($rbacId)
    {
        $rbacPolicy = GlobalFunction::rbacBiopolicy_getAllMyPolicy();
        $grant = false;

        if($rbacPolicy != null) {
            foreach ($rbacPolicy as $data) {
                if ($data->rbacPolicy0->rbacFlag == '2')
                    return true;
                else
                    $grant = ($grant || GlobalFunction::rbacPolicydetail_getRbacPolicydetail($rbacId, $data->rbacPolicy));
            }
        }

        return $grant;
    }

    #ArrayHelper
    public static function rbacMain_getFunction($policy = false)
    {
        $exist = RbacPolicydetail::find()
            ->where('rbacPolicy = '.$policy)
            ->all();

        $arrOld = ArrayHelper::map($exist, 'rbacMain', 'rbacMain');

        $model = RbacMain::find()
            ->where('rbacTitle IS NOT NULL AND rbacFlag = "1"')
            ->orderBy('rbacApps, rbacModule, rbacController, rbacAction')
            ->all();

        $arrAll = ArrayHelper::map($model, 'id', 'id');
        $test = array_diff($arrAll, $arrOld);

        foreach($test as $data) {
            $main = RbacMain::findOne($data);
            $array[$main->rbacApps][$main->id] = ($main->rbacModule == '' ? '' : $main->rbacModule.'->').$main->rbacController.': '.$main->rbacTitle;
        }

        return $array;
    }

    #ArrayHelper
    public static function rbacMain_getFunctionUnfiltered()
    {
        $model = RbacMain::find()
            ->where('rbacTitle IS NOT NULL AND rbacFlag = "1"')
            ->orderBy('rbacApps, rbacModule, rbacController, rbacAction')
            ->all();

        $test = ArrayHelper::map($model, 'id', 'id');

        foreach($test as $data) {
            $main = RbacMain::findOne($data);
            $array[$main->rbacApps][$main->id] = ($main->rbacModule == '' ? '' : $main->rbacModule.'->').$main->rbacController.': '.$main->rbacTitle;
        }

        return $array;
    }

    public static function rbacMain_getRbacCommon($type, $rbacId, $var = false, $md5 = false)
    {
        $return = [];
        $model = Yii::$app->arbac->getCurrentAction($rbacId);

        switch(strtoupper($type)) {
            case 'T':
                #$return = ($model->rbacTitle == NULL ? $model->rbacAlias : Yii::t('app', 'rbac'.$model->id));
                $return = ($model->rbacTitle == NULL ? $model->rbacAlias : $model->rbacTitle);
                break;
            case 'C':
                $return['label'] = ($model->rbacTitle == NULL ? $model->rbacAlias : Yii::t('app', 'rbac'.$model->id));

                if($md5 != false)
                    $return['url'] = [GlobalFunction::rbacMain_getRbacCommon('c2', $rbacId), $var => $md5];
                else
                    $return['url'] = [GlobalFunction::rbacMain_getRbacCommon('c2', $rbacId)];

                break;
            case 'C2':
                $return = '../'
                    .($model->rbacModule == '' ? '' : $model->rbacModule.'/')
                    .$model->rbacController
                    .'/'
                    .$model->rbacAction;
                break;
            case 'L':
                $return = Yii::$app->urlManager->createAbsoluteUrl([''], Yii::$app->params['protocol'])
                    .($model->rbacModule == '' ? '' : $model->rbacModule.'/')
                    .$model->rbacController
                    .'/'
                    .$model->rbacAction;

                    if ($md5 != false)
                        $return .= '?'.$var.'='.$md5;

                break;
            case 'AC':
                $return = '/'
                    .Yii::$app->params['webFolder']
                    .($model->rbacModule == '' ? '' : $model->rbacModule.'/')
                    .$model->rbacController
                    .'/'
                    .$model->rbacAction;

                $return = [$return];
                break;
            default:
                $return = 'Invalid arguments getRbacCommon($type, $rbacId, $var = false, $md5 = false)';
                break;
        }

        return $return;
    }

    public static function rbacMain_setCurrentAction($app)
    {
        $rbacMain = new RbacMain;
        $rbacMain->rbacApps = $app[0];
        $rbacMain->rbacModule = $app[1];
        $rbacMain->rbacController = $app[2];
        $rbacMain->rbacAction = $app[3];
        $rbacMain->rbacAlias = $app[0].' : '.$app[1].' : '.$app[2].' : '.$app[3];
        $rbacMain->rbacCreated = time();
        $rbacMain->save();
        $AllAdmin = GlobalFunction::rbacPolicy_getAllAdmin();

        foreach($AllAdmin as $data)
            GlobalFunction::rbacPolicydetail_setPolicyDetail($data->id, $rbacMain->id);
    }

    public static function rbacPolicy_getAllAdmin()
    {
        $rbacPolicy = RbacPolicy::find()
            ->where(['rbacFlag' => '2'])
            ->all();

        return $rbacPolicy;
    }

    public static function rbacPolicy_getAllPolicy($policyName = false)
    {
        if ($policyName)
            $where = ' AND rbacName LIKE "'.$policyName.'%"';
        else
            $where = '';

        $array = [];
        $model = RbacPolicy::find()
            ->where('rbacFlag != "3"'.$where)
            ->orderby('rbacAgensiAbv, rbacName')
            ->all();

        foreach ($model as $data) {
            $agency = ($data->rbacAgensiAbv == NULL ? 'MIS Application' : $data->rbacAgensiAbv);
            $array[$agency][$data->id] = $data->rbacName;
        }

        return $array;
    }

    public static function rbacPolicy_getDefaultPolicy($agency = FALSE)
    {
        if ($agency)
            $find = ' AND rbacAgensi = '.$agency;
        else
            $find = ' AND rbacAgensi IS NULL';

        $model = RbacPolicy::find()
            ->where('rbacFlag = "1"'.$find)
            ->one();

        return $model;
    }

    public static function rbacPolicy_getPolicyHolder($policy, $agency = false)
    {
        $model = RbacPolicy::find()
            ->where('rbacName = :rbacName')
            ->params(['rbacName' => $policy])
            ->one();

        return $model->rbacBiopolicies;
    }

    public static function rbacPolicydetail_getRbacPolicydetail($rbacId, $rbacPolicy)
    {
        $model = RbacPolicydetail::find()
            ->where([
                'rbacPolicy' => $rbacPolicy,
                'rbacMain' => $rbacId
            ])
            ->all();

        if ($model != null)
            return true;
        else
            return false;
    }

    public static function rbacPolicydetail_setPolicyDetail($policy, $main)
    {
        $policyDetail = new RbacPolicydetail;
        $policyDetail->rbacPolicy = $policy;
        $policyDetail->rbacMain = $main;
        $policyDetail->rbacCreated = time();
        $policyDetail->save();
    }

    public static function tbUser_arrayHelper($data)
    {
        foreach($data as $user)
            $array[$user->sUserID] = ($user->tbUserCustominfo == null ? '' : '['.$user->tbUserCustominfo->sFieldValue5.'] ').$user->sUserName;

        return $array;
    }

    #Html
    public static function web_backendMenu($app)
    {
        $menu = '<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-12">'
            .'<ul>';

        $link = '';

        if(!Yii::$app->user->isGuest) {
            if($app != 'app-backend') {
                foreach(Yii::$app->params['languages'] as $key => $value)
                    $link .= '<span class="language" id="'.$key.'">'.$value.'</span> | ';
            }

            $menu .= '<li>'.$link.'</li>';
        }

        $menu .= '<li>'
            .Html::a('<span class="icon_documents_alt" aria-hidden="true"></span>'.Yii::t('app', 'label-0014'), Yii::$app->homeUrl)
            .'</li>';

        if ($app == 'app-backend') {
            $menu .= '<li>'
            .(Yii::$app->user->isGuest ? '' : Html::a('<span class="icon_documents_alt" aria-hidden="true"></span>'.GlobalFunction::rbacMain_getRbacCommon('t', 11).' ('.Yii::$app->user->identity->myEmail.')', GlobalFunction::rbacMain_getRbacCommon('l', 11)))
            .'</li>';
        }
        else {
            $menu .= '<li>'
            .(Yii::$app->user->isGuest ? '' : Html::a('<span class="icon_documents_alt" aria-hidden="true"></span>'.Yii::t('app', 'rbac6').' ('.Yii::$app->user->identity->myEmail.')', GlobalFunction::rbacMain_getRbacCommon('l', 6)))
            .'</li>';
        }

        $menu .= '</ul>'
            .'</div>'
            .'<div class="divider-xs-megamenu-spacing"></div>';

        $model = RbacMain::find()
            ->where('rbacApps = :rbacApps AND rbacMOption = "L1" AND rbacFlag != "2"')
            ->params([
                ':rbacApps' => $app
            ])
            ->orderBy('rbacMSort')
            ->all();

        foreach ($model as $data) {
            if(GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id))) {
                $menu .= '<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-12">'
                    .'<div class="mega-menu-title">'
                    .'<span>'.Yii::t('app', 'rbac'.$data->id).'</span>'
                    .'</div>'
                    .'<ul>';

                    $subModel = RbacMain::find()
                        ->where('rbacFlag != "2" and rbacMParent = :rbacMParent AND rbacMSort <= 100')
                        ->params([
                            ':rbacMParent' => $data->id
                        ])
                        ->orderBy('rbacMSort')
                        ->all();

                    if(sizeof($subModel) > 0) {
                        foreach($subModel as $subData) {
                            if(GlobalFunction::rbacBiopolicy_getMyAuth((int)($subData->id))) {
                                $menu .= '<li>'
                                    .Html::a('<span class="icon_documents_alt" aria-hidden="true"></span>'.Yii::t('app', 'rbac'.$subData->id), GlobalFunction::rbacMain_getRbacCommon('l', (int)($subData->id)))
                                    .'</li>';
                            }
                        }
                    }

                    $subModel = RbacMain::find()
                        ->where('rbacFlag != "2" and rbacMParent = :rbacMParent AND rbacMSort > 100')
                        ->params([
                            ':rbacMParent' => $data->id
                        ])
                        ->orderBy('rbacMSort')
                        ->all();

                    $menuSub = '';

                    if(sizeof($subModel) > 0) {
                        $tempMenu = '';

                        foreach($subModel as $subData) {
                            if(GlobalFunction::rbacBiopolicy_getMyAuth((int)($subData->id))) {
                                $tempMenu .= '<li>'
                                    .Html::a('<span class="icon_documents_alt" aria-hidden="true"></span>'.Yii::t('app', 'rbac'.$subData->id), GlobalFunction::rbacMain_getRbacCommon('l', (int)($subData->id)))
                                    .'</li>';
                            }
                        }

                        if($tempMenu != '') {
                            $menuSub = '<li>'
                                .'<ul>'
                                .$tempMenu
                                .'</li>'
                                .'</ul>'
                                .'<a class="show_all_menu" href="javascript:void(0);">'
                                .'<span class="icon_plus" aria-hidden="true"></span><span>'.Yii::t('app', 'label-0015').'</span>'
                                .'</a>';
                        }
                    }

                    $menu .= ($menuSub == '' ? '' : $menuSub)
                        .'</ul>'
                        .'</div>';
            }

            $menu .= '<div class="divider-xs-megamenu-spacing"></div>';
        }

        return $menu;
    }

    public static function web_mainGetMenu($app)
    {
        $menu[] = ['label' => Yii::$app->params['appName'], 'url' => Yii::$app->homeUrl];

        if (Yii::$app->user->isGuest) {
            if ($app == 'app-backend')
                $menu[] = ['label' => GlobalFunction::rbacMain_getRbacCommon('t', 9), 'url' => GlobalFunction::rbacMain_getRbacCommon('l', 9)];
            else
                $menu[] = ['label' => GlobalFunction::rbacMain_getRbacCommon('t', 2), 'url' => GlobalFunction::rbacMain_getRbacCommon('l', 2)];
        }
        else {
            $model = RbacMain::find()
                ->where('rbacApps = :rbacApps AND rbacMOption = "L1" AND rbacFlag != "2"')
                ->params([
                    ':rbacApps' => $app
                ])
                ->orderBy('rbacMSort')
                ->all();

            foreach ($model as $data) {
                if (sizeof($data->rbacMains) == 0) {
                    if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                        $menu[] = ['label' => $data->rbacMAlias, 'url' => GlobalFunction::rbacMain_getRbacCommon('l', (int)($data->id))];
                }
                else {
                    if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                        $menu[] = ['label' => $data->rbacMAlias, 'items' => GlobalFunction::web_mainGetSubMenu($data->id)];
                }
            }

            if ($app == 'app-backend')
                $menu[] = ['label' => GlobalFunction::rbacMain_getRbacCommon('t', 11), 'url' => GlobalFunction::rbacMain_getRbacCommon('l', 11)];
            else
                $menu[] = ['label' => GlobalFunction::rbacMain_getRbacCommon('t', 6).' ('.Yii::$app->user->identity->myEmail.')', 'url' => GlobalFunction::rbacMain_getRbacCommon('l', 6)];
        }

        return $menu;
    }

    private static function web_mainGetSubMenu($parent)
    {
        $menu = [];
        $model = RbacMain::find()
            ->where('rbacFlag != "2" and rbacMParent = :rbacMParent')
            ->params([
                ':rbacMParent' => $parent
            ])
            ->orderBy('rbacMSort')
            ->all();

        foreach ($model as $data) {
            if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                $menu[] = ['label' => $data->rbacMAlias, 'url' => GlobalFunction::rbacMain_getRbacCommon('l', (int)($data->id))];
        }

        return $menu;
    }

    #Html
    public static function web_metisGetMenu()
    {
        $menu = '';
        $menu .= '<li>';
        $menu .= Html::a(Yii::$app->params['appName'], Yii::$app->homeUrl);
        $menu .= '</li>';

        $model = RbacMain::find()
            ->where('rbacApps = :rbacApps AND rbacMOption = "L1" AND rbacFlag != "2"')
            ->params([
                ':rbacApps' => 'app-frontend'
            ])
            ->orderBy('rbacMSort')
            ->all();

        foreach ($model as $data) {
            if (sizeof($data->rbacMains) == 0) {
                if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                    $menu .= '<li>'.Html::a($data->rbacMAlias, GlobalFunction::rbacMain_getRbacCommon('l', (int)($data->id))).'</li>';
            }
            else {
                if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                    $menu .= GlobalFunction::web_metisGetSubMenu($data->id);
            }
        }

        $menu .= '';
        $menu .= '<li>';
        $menu .= Html::a(GlobalFunction::rbacMain_getRbacCommon('t', 6).' ('.Yii::$app->user->identity->myemail.')', GlobalFunction::rbacMain_getRbacCommon('l', 6));
        $menu .= '</li>';
        return $menu;
    }

    #Html
    public static function web_metisGetSubMenu($parent)
    {
        $model = RbacMain::findOne($parent);
        $menu = '<li class="dropdown">';
        $menu .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
        $menu .= $model->rbacMAlias.' <b class="caret"></b>';
        $menu .= '</a>';
        $menu .= '<ul class="dropdown-menu">';

        $model = RbacMain::find()
            ->where('rbacFlag != "2" and rbacMParent = :rbacMParent')
            ->params([
                ':rbacMParent' => $parent
            ])
            ->orderBy('rbacMSort')
            ->all();

        foreach ($model as $data) {
            if (GlobalFunction::rbacBiopolicy_getMyAuth((int)($data->id)))
                $menu .= '<li>'.Html::a($data->rbacMAlias, GlobalFunction::rbacMain_getRbacCommon('l', (int)($data->id))).'</li>';
        }

        $menu .= '</ul>';
        $menu .= '</li>';
        return $menu;
    }
}
