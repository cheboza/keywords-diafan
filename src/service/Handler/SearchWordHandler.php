<?php
namespace Diafanfh\Keywords\Handler;

use Diafanfh\Keywords\Pipes\SwitcherKeyboardPipe;
use Diafanfh\Keywords\Pipes\TransliteratorPipe;
use Illuminate\Pipeline\Pipeline;

class SearchWordHandler
{
    private static function getPipes(){
        return [
            new SwitcherKeyboardPipe(),
            new TransliteratorPipe()
        ];
    }

    /**
     * @param mixed $wordHandle
     * @return array
     */
    public static function handle($wordHandle)
    {
        $pipeline = new Pipeline();
        return $pipeline
            ->send($wordHandle) // Данные, которые мы хотим пропустить через обработчики
            ->through(self::getPipes()) // Коллекция обработчиков
            ->then(function () {
                return []; // Возвращаются данные, пройденные через цепочку
            });
    }
}
