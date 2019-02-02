<?php namespace ss\components\bg\cp\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    private function triggerUpdate($pivot)
    {
        $this->c('^ui~:update', [
            'pivot' => $pivot
        ]);
    }

    public function reload()
    {
        $this->c('<:reload', [], true);
    }

    public function setMode()
    {
        if ($pivot = $this->unxpackModel('pivot')) {
            ss()->cats->apComponentPivotData($pivot, 'mode', $this->data('value'));

            $this->triggerUpdate($pivot);

            $this->reload();
        }
    }
}
