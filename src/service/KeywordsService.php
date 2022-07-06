<?php

namespace Diafanfh\Keywords;

use Diafanfh\Keywords\Handler\SearchWordHandler;
use Diafanfh\Keywords\Lib\SearchWords;

class KeywordsService
{
    private SearchWords $searchWordHelper;

    /**
     * @param string $request
     * @param callable $getKeyWords
     */
    public function __construct()
    {
        $this->searchWordHelper = new SearchWords();
    }


    /**
     * @param string $request
     * @param callable $getKeyWords Callback function returned array keywords form app store
     * array must have mask ["id", "keyword"]
     *
     * @return array
     */
    public function keys(string $request, callable $getKeyWords): array
    {
        $arraySearchStems = $this->searchWordHelper->getUniqueStemWords($request);
        $keys = $getKeyWords($arraySearchStems);
        $arrayDiff = array_diff($arraySearchStems, array_column($keys, 'keyword'));

        foreach ($arrayDiff as $diff) {
            $handledKey = SearchWordHandler::handle(
                function (callable $switching) use ($getKeyWords, $diff) {
                    $searchWord = $switching($diff);
                    if(!empty($searchWord))
                    {
                        $keyHandled = $this->searchWordHelper->getUniqueStemWords($searchWord);
                        $key = $getKeyWords( $keyHandled );
                        return (!empty($key) ? $key : null);
                    }
                    return null;
                }
            );
            if (!empty($handledKey)) {
                foreach ($handledKey as $hKey) {
                    $keys[] = $hKey;
                }
            } else {
                return [];
            }
        }
        return $keys;
    }


}
