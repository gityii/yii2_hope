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
    }
}