<?php

namespace api\controllers;

use common\helper\Helper;
use common\helper\ErrorCode;


class SiteController extends BaseController
{
    public function actionError()
    {
        return Helper::showJsonError(ErrorCode::NOT_FOUND_ERR);
    }

}
