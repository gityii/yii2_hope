<?php
/**
 * Created by PhpStorm.
 * User: v_ransu
 * Date: 2017/10/25
 * Time: 17:37
 */

use yii\helpers\Html;
?>


 <p>You have entered the following information:</p>

 <ul>
     <li><label>Name</label>: <?= Html::encode($model->username) ?></li>
     <li><label>Email</label>: <?= Html::encode($model->password) ?></li>
 </ul>
