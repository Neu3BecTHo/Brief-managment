<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Briefs;
use app\models\Statuses;

class BriefController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays available briefs page.
     *
     * @return string
     */
    public function actionAvailable()
    {
        $availableBriefs = Briefs::find()
            ->where(['status_id' => Statuses::findOne(['title' => 'Доступен'])->id ?? 1])
            ->with(['user', 'status'])
            ->all();

        return $this->render('available', [
            'availableBriefs' => $availableBriefs,
        ]);
    }

    /**
     * Displays completed briefs page.
     *
     * @return string
     */
    public function actionCompleted()
    {
        $completedBriefs = Briefs::find()
            ->where(['status_id' => Statuses::findOne(['title' => 'Заполнен'])->id ?? 2])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->with(['user', 'status'])
            ->all();

        return $this->render('completed', [
            'completedBriefs' => $completedBriefs,
        ]);
    }
}
