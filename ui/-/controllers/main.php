<?php namespace ss\components\bg\ui\controllers;

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

    public function update()
    {
        $pivot = $this->pivot;
        $cat = $pivot->cat;

        $pivotData = _j($pivot->data);

        $image = $this->c('\std\images~:first', [
            'model'    => $cat,
            'instance' => $this->_masterModuleController()->_nodeId(),
            'query'    => ''
        ]);

        $this->widget(':|', 'update', [
            'mode'        => ap($pivotData, 'mode'),
            'imageSrc'    => $image ? abs_url($image->versionModel->file_path) : false,
            'imageWidth'  => $image ? $image->versionModel->width : false,
            'imageHeight' => $image ? $image->versionModel->height : false
        ]);
    }

    public function view()
    {
        $v = $this->v('|');

        $pivot = $this->pivot;
        $pivotXPack = xpack_model($pivot);

        $cat = $pivot->cat;

        $pivotData = _j($pivot->data);

        $image = $this->c('\std\images~:first', [
            'model'    => $cat,
            'instance' => $this->_masterModuleController()->_nodeId(),
            'query'    => ''
        ]);

        $this->css();

        $this->widget(':|', [
            '.payload'    => [
                'pivot' => $pivotXPack
            ],
            '.e'          => [
                'ss/cat/' . $cat->id . '/update_pivot' => 'r.update'
            ],
            '.r'          => [
                'update' => $this->_abs('>xhr:update')
            ],
            'target'      => 'body',
            'mode'        => ap($pivotData, 'mode'),
            'imageSrc'    => $image ? abs_url($image->versionModel->file_path) : false,
            'imageWidth'  => $image ? $image->versionModel->width : false,
            'imageHeight' => $image ? $image->versionModel->height : false
        ]);

        return $v;
    }
}
