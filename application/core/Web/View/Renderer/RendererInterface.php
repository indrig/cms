<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 15:51
 */

namespace Core\Web\View\Renderer;
use Core\Web\View\Model\ModelInterface;
interface RendererInterface
{
    public function render(ModelInterface $model);
}