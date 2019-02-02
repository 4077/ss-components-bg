<?php namespace ss\components\bg\cp\controllers;

class Main extends \Controller
{
    private $pivot;

    public function __create()
    {
        if ($this->pivot = $this->unpackModel('pivot')) {
            $this->instance_($this->pivot->id);
        } else {
            $this->lock();
        }
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $pivot = $this->pivot;
        $pivotXPack = xpack_model($pivot);

        $cat = $pivot->cat;

        $pivotData = _j($pivot->data);

        $v->assign([
                       'MODE_SWITCHER' => $this->c('\std\ui\switcher~:view', [
                           'path'    => $this->_p('>xhr:setMode'),
                           'data'    => [
                               'pivot' => $pivotXPack,
                           ],
                           'value'   => ap($pivotData, 'mode'),
                           'class'   => 'mode_switcher',
                           'classes' => [

                           ],
                           'buttons' => [
                               [
                                   'value' => 'static',
                                   'label' => 'статический',
                                   'class' => 'static'
                               ],
                               [
                                   'value' => 'fixed',
                                   'label' => 'фиксированный',
                                   'class' => 'fixed'
                               ],
                               [
                                   'value' => 'parallax',
                                   'label' => 'параллакс',
                                   'class' => 'parallax'
                               ]
                           ]
                       ]),
                       'IMAGES'        => $this->c('\std\images\ui~:view|ss/components/bg', [
                           'imageable' => pack_model($cat),
                           'instance'  => $this->_masterModuleController()->_nodeId(),
                           'dev_info'  => false,
                           'href'      => [
                               'enabled' => true
                           ],
                           'callbacks' => [
                               'update' => $this->_abs('>app:imagesUpdate', [
                                   'pivot' => $pivotXPack
                               ])
                           ]
                       ])
                   ]);

        $this->css();

        return $v;
    }
}
