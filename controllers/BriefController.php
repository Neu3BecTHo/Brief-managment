<?php

namespace app\controllers;

use Yii;
use app\models\BriefAnswers;
use app\models\BriefFillForm;
use app\models\Briefs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class BriefController extends Controller
{
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
     * Список доступных брифов для заполнения
     */
    public function actionAvailable()
    {
        $briefs = Briefs::find()
            ->where(['status_id' => 2])
            ->with('briefQuestions')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('available', [
            'briefs' => $briefs,
        ]);
    }

    /**
     * Форма заполнения брифа
     */
    public function actionFill($id)
    {
        $brief = $this->findModel($id);
        $model = new BriefFillForm($brief);

        $alreadyAnswered = BriefAnswers::find()
            ->joinWith('briefQuestion')
            ->where([
                '{{%brief_questions}}.brief_id' => $brief->id,
                '{{%brief_answers}}.user_id' => Yii::$app->user->id,
            ])
            ->exists();

        if ($alreadyAnswered) {
            Yii::$app->session->setFlash('info', 'Вы уже заполняли этот бриф.');
            return $this->redirect(['completed']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($model->answers as $questionId => $answer) {
                    if (is_array($answer)) {
                        $answer = implode(', ', array_filter($answer));
                    }
                    if ($answer === null || trim((string)$answer) === '') {
                        continue;
                    }

                    Yii::$app->db->createCommand()->insert('{{%brief_answers}}', [
                        'brief_question_id' => (int)$questionId,
                        'user_id' => Yii::$app->user->id,
                        'answer' => $answer,
                    ])->execute();
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Бриф успешно заполнен.');
                return $this->redirect(['completed']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении: ' . $e->getMessage());
            }
        }

        return $this->render('fill', [
            'brief' => $brief,
            'model' => $model,
        ]);
    }

    public function actionCompleted()
    {
        $userId = Yii::$app->user->id;

        $briefs = Briefs::find()
            ->innerJoin('{{%brief_questions}} q', 'q.brief_id = {{%briefs}}.id')
            ->innerJoin('{{%brief_answers}} a', 'a.brief_question_id = q.id')
            ->where(['a.user_id' => $userId])
            ->groupBy('{{%briefs}}.id')
            ->orderBy(['{{%briefs}}.created_at' => SORT_DESC])
            ->all();

        return $this->render('completed', [
            'briefs' => $briefs,
        ]);
    }
    public function actionView($id)
    {
        $brief = $this->findModel($id);
        $userId = Yii::$app->user->id;

        $answers = BriefAnswers::find()
            ->alias('a')
            ->joinWith(['briefQuestion q'])
            ->where([
                'q.brief_id' => $brief->id,
                'a.user_id' => $userId
            ])
            ->all();

        if (empty($answers)) {
            Yii::$app->session->setFlash('warning', 'Вы еще не заполняли этот бриф.');
            return $this->redirect(['available']);
        }

        return $this->render('view', [
            'brief' => $brief,
            'answers' => $answers,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Briefs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Бриф не найден.');
    }
}
