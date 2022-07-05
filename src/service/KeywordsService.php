<?php

namespace Diafanfh\Keywords;

use Diafanfh\Keywords\Handler\SearchWordHandler;
use Diafanfh\Keywords\Lib\SearchWords;

class KeywordsService
{
    private string $request;
    private SearchWords $searchWordHelper;

    /**
     * @param string $request
     * @param callable $getKeyWords
     */
    public function __construct(string $request)
    {
        $this->request = $request;
        $this->searchWordHelper = new SearchWords();
    }

    /**
     * Start search
     *
     * @param string $request
     * @return array
     */
    public function keys(callable $getKeyWords)
    {
        $arraySearchStems = $this->searchWordHelper->getUniqueStemWords($this->request);
        $keys = $getKeyWords($arraySearchStems);
        $arrayDiff = array_diff($arraySearchStems, $keys);

        foreach ($arrayDiff as $diff) {
            $handledKey = SearchWordHandler::handle(
                function (callable $switching) use ($getKeyWords, $diff) {
                    $searchWord = $switching($diff);
                    if(!empty($searchWord))
                    {
                        $keyHandled = $this->searchWordHelper->getUniqueStemWords($searchWord);
                        $key = $getKeyWords($keyHandled);
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
