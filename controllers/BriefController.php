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

    /**
     * Мои заполненные брифы
     */
    public function actionCompleted()
    {
        $userId = Yii::$app->user->id;

        $answers = BriefAnswers::find()
            ->where(['user_id' => $userId])
            ->with(['briefQuestion.brief'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $items = [];
        foreach ($answers as $answer) {
            $brief = $answer->briefQuestion->brief ?? null;
            if (!$brief) {
                continue;
            }
            $items[$brief->id]['brief'] = $brief;
            $items[$brief->id]['answers'][] = $answer;
        }

        return $this->render('completed', [
            'items' => $items,
        ]);
    }

    /**
     * Поиск модели по ID
     */
    protected function findModel($id)
    {
        if (($model = Briefs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Бриф не найден.');
    }
}