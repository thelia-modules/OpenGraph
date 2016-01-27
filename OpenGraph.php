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

namespace OpenGraph;

use OpenGraph\Model\Config\OpenGraphConfigValue;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Module\BaseModule;

/**
 * Class OpenGraph
 * @package OpenGraph
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class OpenGraph extends BaseModule
{
    const DOMAIN_NAME = 'opengraph';

    public function postActivation(ConnectionInterface $con = null)
    {
        self::setConfigValue(OpenGraphConfigValue::ENABLE_SHARING_BUTTONS, 0);
    }
}
