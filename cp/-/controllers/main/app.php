<?php namespace ss\components\bg\cp\controllers\main;

class App extends \Controller
{
    public function imagesUpdate()
    {
        if ($pivot = $this->unpackModel('pivot')) {
            $this->c('^ui~:update', [
                'pivot' => $pivot
            ]);
        }
    }
}
