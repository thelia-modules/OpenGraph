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
        $object_type = $this->getView();

        if ( $object_type == 'category' || $object_type == 'product' || $object_type == 'folder' || $object_type == 'content') {

            $event
                ->add($this->render('open_graph.html', [$object_type]));
        }
    }

    public function onModuleConf(HookRenderEvent $event)
    {
        $event->add($this->render("module_configuration.html"));
    }
}