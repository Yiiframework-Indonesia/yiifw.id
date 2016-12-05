<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\component\Icon;
?>
<div class="about-area">

        <span class="badge badge-primary pull-right">
            <a href="<?= Url::to(['update-profile']) ?>" style="color: #fff">
                <?=new Icon('edit')?> edit profile
            </a>
        </span>

    <h4><?= $model->fullname ?></h4>

    <div class="table-responsive">
        <table class="table about-table">
            <tbody>
                <tr>
                    <th><?= $model->user->getAttributeLabel('username')?></th>
                    <td><?= Html::encode($model->username) ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('birth_day')?></th>
                    <td> <?= Yii::$app->formatter->asDate($model->birth_day, 'php:d F Y') ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('gender')?></th>
                    <td><?= $model->gender ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('address')?></th>
                    <td><?= Html::encode($model->address) ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('email')?></th>
                    <td><?= Html::mailto($model->email, $model->email, ['target' => '_blank']) ?>
                        <?php if (Yii::$app->user->id == $model->user_id): ?>
                            <span class="badge badge-primary">
                                <a href="<?= Url::to(['update-user-email']) ?>" style="color: #fff">
                                    <?=new Icon('edit')?> edit account login
                                </a>
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>