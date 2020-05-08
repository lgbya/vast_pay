<?php
namespace api\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    public $layout = true;
    public $enableCsrfValidation = false;
}