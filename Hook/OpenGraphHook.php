<?php

namespace OpenGraph\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/10/2015
 * Time: 09:16
 */
class OpenGraphHook extends BaseHook
{
    public function onMainHeadBottom(HookRenderEvent $event)
    {
        $event->add($this->render('open-graph.html'));
    }

    public function onModuleConf(HookRenderEvent $event)
    {
        $event->add($this->render("module-configuration.html"));
    }
}