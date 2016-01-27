<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

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
        $acceptedTypes = ['category', 'product', 'folder', 'content'];

        $objectType = $this->getView();

        if (in_array($objectType, $acceptedTypes)) {
            $event->add($this->render('open_graph.html', ['view_value' => $objectType]));
        }
    }

    public function openGraphSharingButtons(HookRenderEvent $event)
    {
        $acceptedTypes = ['category', 'product', 'folder', 'content'];

        $objectType = $this->getView();

        if (in_array($objectType, $acceptedTypes)) {
            $event->add($this->render('open_graph_sharing_button.html', ['view_value' => $objectType]));
        }
    }

    public function onMainStylesheet(HookRenderEvent $event)
    {
        $event->add($this->addCSS("assets/css/styles.css"));
    }

    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render("module_configuration.html"));
    }
}
