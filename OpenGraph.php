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

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class OpenGraph extends BaseModule
{
    const DOMAIN_NAME = 'OpenGraph';

    public function postActivation(ConnectionInterface $con = null)
    {

        $database = new Database($con);

        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));

    }
}
