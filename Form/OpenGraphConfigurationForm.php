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

namespace OpenGraph\Form;

use OpenGraph\OpenGraph;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\ExecutionContextInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Model\ConfigQuery;

/**
 * Class ConfigurationForm
 * @package OpenGraph\Form
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class OpenGraphConfigurationForm extends BaseForm {

    protected function buildForm()
    {
        $form = $this->formBuilder;

        $definitions = array(
            array(
                "id" => "company_name",
                "label" => $this->trans("Your company's name")
            ),
            array(
                "id" => "author_name",
                "label" => $this->trans("The article author's name")
            ),
        );

        $twitter_definitions = array(
            array(
                "id" => "twitter_company_name",
                "label" => $this->trans("Your company's name on twitter"),
            ),
            array(
                "id" => "twitter_creator_name",
                "label" => $this->trans("The creator's name on twitter"),
            )
        );

        foreach ($twitter_definitions as $field){
            $value = ConfigQuery::read("opengraph_" . $field["id"], "");
            $form->add(
                $field["id"],
                "text",
                array(
                    "constraints" => [
                        new Callback(array(
                            "methods" => array(
                                array($this,
                                    "verifyValue")
                            )
                        ))
                    ],
                    "data"  => $value,
                    "label" => $field["label"],
                    "label_attr" => array(
                        "for" => $field["id"]
                    ),
                )
            );
        }

        foreach ($definitions as $field){
            $value = ConfigQuery::read("opengraph_" . $field["id"], "");
            $form->add(
                $field["id"],
                "text",
                array(
                    "data"  => $value,
                    "label" => $field["label"],
                    "label_attr" => array(
                        "for" => $field["id"]
                    ),
                )
            );
        }
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "opengraph";
    }

    protected function trans($str, $params = [])
    {
        return Translator::getInstance()->trans($str, $params, OpenGraph::DOMAIN_NAME);
    }

    public function verifyValue($value, ExecutionContextInterface $context)
    {
        if (!preg_match("#^@[a-zA-Z]*$#",$value)) {
            $context->addViolation($this->trans("select a valid twitter alias"));
        }
    }
} 