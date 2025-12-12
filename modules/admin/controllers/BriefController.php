<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\BriefAnswers;
use app\models\BriefQuestions;
use app\models\Briefs;
use app\models\Statuses;
use app\models\TypeFields;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class BriefController extends Controller
{
    public function actionIndex()
    {
        $briefs = Briefs::find()
            ->with(['user', 'status', 'briefQuestions'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'briefs' => $briefs,
        ]);
    }
    public function actionView($id)
    {
        $brief = $this->findModel($id);

        return $this->render('view', [
            'brief' => $brief,
        ]);
    }

    public function actionCreate()
    {
        $brief = new Briefs();
        $brief->user_id = Yii::$app->user->id;
        $brief->status_id = 1;

        if ($brief->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($brief->save()) {
                    $questions = Yii::$app->request->post('questions', []);
                    $this->saveQuestions($brief->id, $questions);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Бриф успешно создан.');
                    return $this->redirect(['view', 'id' => $brief->id]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ошибка при создании брифа: ' . $e->getMessage());
            }
        }

        return $this->render('create', [
            'brief' => $brief,
            'statuses' => Statuses::find()->select(['title', 'id'])->indexBy('id')->column(),
            'typeFields' => TypeFields::getTypesDropdown(),
        ]);
    }

    public function actionUpdate($id)
    {
        $brief = $this->findModel($id);

        if ($brief->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                Yii::$app->db->createCommand()->update('{{%briefs}}', [
                    'status_id' => (int)$brief->status_id,
                    'title' => $brief->title,
                    'description' => $brief->description,
                ], ['id' => $brief->id])->execute();

                BriefQuestions::deleteAll(['brief_id' => $brief->id]);

                $questions = Yii::$app->request->post('questions', []);
                $this->saveQuestions($brief->id, $questions);

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Бриф успешно обновлён.');
                return $this->redirect(['view', 'id' => $brief->id]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ошибка при обновлении: ' . $e->getMessage());
            }
        }

        return $this->render('update', [
            'brief' => $brief,
            'statuses' => Statuses::find()->select(['title', 'id'])->indexBy('id')->column(),
            'typeFields' => TypeFields::find()->select(['title', 'id'])->indexBy('id')->column(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Бриф удалён.');

        return $this->redirect(['index']);
    }

    public function actionResponses($id)
    {
        $brief = $this->findModel($id);

        $answers = BriefAnswers::find()
            ->joinWith(['briefQuestion', 'user'])
            ->where(['{{%brief_questions}}.brief_id' => $brief->id])
            ->orderBy(['{{%brief_answers}}.created_at' => SORT_DESC])
            ->all();

        $userAnswers = [];
        foreach ($answers as $answer) {
            $userId = $answer->user_id;
            if (!isset($userAnswers[$userId])) {
                $userAnswers[$userId] = [
                    'user' => $answer->user,
                    'answers' => [],
                    'created_at' => $answer->created_at,
                ];
            }
            $userAnswers[$userId]['answers'][] = $answer;
        }

        return $this->render('responses', [
            'brief' => $brief,
            'userAnswers' => $userAnswers,
        ]);
    }

    public function actionResponseView($id, $user_id)
    {
        $brief = $this->findModel($id);
        $user = \app\models\User::findOne($user_id);

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $answers = BriefAnswers::find()
            ->joinWith('briefQuestion')
            ->where([
                'user_id' => $user_id,
                '{{%brief_questions}}.brief_id' => $brief->id
            ])
            ->all();

        if (empty($answers)) {
            throw new NotFoundHttpException('Ответов от этого пользователя нет');
        }

        return $this->render('response-view', [
            'brief' => $brief,
            'user' => $user,
            'answers' => $answers,
        ]);
    }

    protected function saveQuestions($briefId, $questions)
    {
        if (empty($questions)) {
            return;
        }

        foreach ($questions as $index => $questionData) {
            if (empty($questionData['question']) || empty($questionData['type_field_id'])) {
                continue;
            }

            $question = new BriefQuestions();
            $question->brief_id = $briefId;
            $question->question = $questionData['question'];
            $question->type_field_id = (int)$questionData['type_field_id'];
            $question->is_required = isset($questionData['is_required']) ? 1 : 0;
            $question->sort_order = (int)$index;

            $raw = $questionData['options'] ?? '';
            $options = array_filter(array_map('trim', explode(',', $raw)));
            if (!empty($options)) {
                $question->setOptionsArray($options);
            }

            if (!$question->save()) {
                throw new \Exception('Ошибка сохранения вопроса: ' . Json::encode($question->errors));
            }
        }
    }

    public function actionSendPdf($id, $response_user_id = null)
    {
        $brief = $this->findModel($id);

        if ($response_user_id) {
            $targetUser = \app\models\User::findOne($response_user_id);
        } else {
            $targetUser = $brief->user;
        }

        if (!$targetUser) {
            throw new NotFoundHttpException('Целевой пользователь не найден.');
        }

            $request = Yii::$app->request;
            $email = $request->post('email') ?: Yii::$app->user->identity->email;

        if (!$email) {
            Yii::$app->session->setFlash('error', 'Email получателя не найден.');
            return $this->redirect($request->referrer);
        }

        try {
            $html = $this->renderPartial('_brief-pdf', [
                'brief' => $brief,
                'targetUser' => $targetUser,
            ]);

            $mpdf = new \Mpdf\Mpdf(['tempDir' => Yii::getAlias('@runtime/pdf'), 'default_font' => 'dejavusans']);
            $mpdf->WriteHTML($html);

            Yii::$app->mailer->compose()
            ->setFrom([$_ENV['SMTP_EMAIL'] => 'Админка Брифов'])
            ->setTo($email)
            ->setSubject('Отчет по брифу: ' . $brief->title)
            ->attachContent($mpdf->Output('', 'S'), [
                'fileName' => 'Brief-report-user' . $targetUser->id . '.pdf',
                'contentType' => 'application/pdf'
            ])
            ->send();

            Yii::$app->session->setFlash('success', 'Отчет по ответам ' . $targetUser->username . ' отправлен на: ' . Html::encode($email));
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Ошибка отправки: ' . $e->getMessage());
        }

        return $this->redirect($request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Briefs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Бриф не найден.');
    }
}
