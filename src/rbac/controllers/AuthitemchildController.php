<?php

namespace acmepy\base\rbac\controllers;

use Yii;
use acmepy\base\rbac\models\AuthItemChild;
use yii\data\ActiveDataProvider;
use acmepy\base\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthitemchildController implements the CRUD actions for AuthItemChild model.
 */
class AuthitemchildController extends Controller
{
    /**
     * Lists all AuthItemChild models.
     * @return mixed
     */
	public function actionIndex(){
		return $this->render('index', ['dataProvider' => new ActiveDataProvider(['query' => AuthItemChild::find()])]);
    }
	
	public function actionExport($type){
		return $this->export($type, new ActiveDataProvider(['query' => AuthItemChild::find()]));
    }

    /**
     * Displays a single AuthItemChild model.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($parent, $child)
    {
        return $this->render('view', [
            'model' => $this->findModel($parent, $child),
        ]);
    }

    /**
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemChild();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItemChild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($parent, $child)
    {
        $model = $this->findModel($parent, $child);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($parent, $child)
    {
        $this->findModel($parent, $child)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $parent
     * @param string $child
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	//ver para cambiar $type en rule de web config (export)
	public function actionPermisos($type = 'xxx'){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return  AuthItemChild::permisos($type);
	}
}
