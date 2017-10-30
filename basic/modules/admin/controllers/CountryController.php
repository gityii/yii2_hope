<?php
/**
 * Created by PhpStorm.
 * User: v_ransu
 * Date: 2017/10/27
 * Time: 17:59
 */
namespace app\modules\admin\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\admin\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
        /*
        $query = Country::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
        */
        // 获取 country 表的所有行并以 name 排序
        $countries = Country::find()->orderBy('name')->all();

// 获取主键为 “US” 的行
        $country = Country::findOne('US');

// 输出 “United States”
        echo $country['name'];

// 修改 name 为 “U.S.A.” 并在数据库中保存更改
        $country->name = 'U.S.A.';
        $country->save();

    }
}