<?php

namespace OpenGraph\Loop;

use OpenGraph\Model\OpengraphDataQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class DataLoop extends BaseLoop implements PropelSearchLoopInterface
{

    /**
     * @param \Thelia\Core\Template\Element\LoopResult $loopResult
     *
     * @return \Thelia\Core\Template\Element\LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \OpenGraph\Model\OpenGraphData $data */
        foreach ($loopResult->getResultDataCollection() as $data) {
            $loopResultRow = new LoopResultRow($data);

            $loopResultRow
                ->set("ID", $data->getId())
                ->set("COMPANY_NAME", $data->getCompanyName())
                ->set("TWITTER_COMPANY_NAME", $data->getTwitterCompanyName())
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    /**
     * Definition of loop arguments
     *
     * example :
     *
     * public function getArgDefinitions()
     * {
     *  return new ArgumentCollection(
     *
     *       Argument::createIntListTypeArgument('id'),
     *           new Argument(
     *           'ref',
     *           new TypeCollection(
     *               new Type\AlphaNumStringListType()
     *           )
     *       ),
     *       Argument::createIntListTypeArgument('category'),
     *       Argument::createBooleanTypeArgument('new'),
     *       ...
     *   );
     * }
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(

            Argument::createIntTypeArgument('id')

        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = OpengraphDataQuery::create();

        if(null != $dataId = $this->getId())
        {
            $search->filterById($dataId);
        }

        return $search;
    }
}