<?php

namespace OpenGraph\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class OpenGraphHook
 * @package OpenGraph\Hook
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class OpenGraphHook extends BaseHook
{
    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $event->add($this->render('open_graph.html'));
    }

    public function onModuleConf(HookRenderEvent $event)
    {
        $event->add($this->render("module_configuration.html"));
    }
}