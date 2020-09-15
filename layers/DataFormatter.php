<?php


namespace Layer\DataFormatter {

    use GlobalCommon\DataControl\CriteriaItem;
    use Layer\Messaging\Request;

    class FormatCriteriaItemList
    {

        final public function requestScraper(Request $_request): array
        {

            if (property_exists($_request->Request, 'CriteriaItemList')) {

                $criteriaList = array();

                foreach ($_request->Request->CriteriaItemList as $object) {
                    $tmpCriteriaItem = new CriteriaItem();
                    $tmpCriteriaItem->sqlPrepare($object);
                    $criteriaList[] = $tmpCriteriaItem;
                }
                return $criteriaList;

            }

        }


    }

    class StringFormatter
    {

        final public function camel2dashed(string $_string): string
        {

            // $layerStringValidation = new StringValidation();

            if ($_string === 'ID') {
                return $_string;
            }
            return strtolower(preg_replace('/([^A-Z-])([A-Z])/', '$1_$2', $_string));
            // return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $_string));
        }
    }
}
