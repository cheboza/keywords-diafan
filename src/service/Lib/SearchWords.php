<?php

namespace Diafanfh\Keywords\Lib;

class SearchWords
{
    /**
     * Выделение уникальных слов из текста
     */
    public function getUniqueStemWords(string $text): array
    {
        $processor = new LinguaStemRuNew();

        $this->filter_search_word( $text );

        $matchesArray = explode(' ', $text);

        foreach ($matchesArray as $key => $value) {
            if(mb_strlen($value, 'UTF-8') < 3) {
                unset ($matchesArray[$key]);
            }
        }

        $matchesArray = array_flip(array_flip($matchesArray));

        $words = [];

        foreach ($matchesArray as $word) {
            $words[] = $processor->stem_word($word);
        }

        return array_unique($words);
    }

    /**
     * Функция обрабатывает поисковую фразу, убирая и заменяя символы
     * не нужные для поиска
     *
     * @param $text string строка поиска
     *
     * @return void
     */
    public function filter_search_word(string &$text): void
    {
        $text = mb_strtolower(strip_tags($text), 'UTF-8');

        if (strlen($text) > 100000) {
            $text = substr($text, 0, 100000);
        }

        $text = str_replace(array('&nbsp;', '«', '»'), array(' ', '"', '"'), $text);
        $text = html_entity_decode($text);
        $text = preg_replace('/\s+|[\.,:;\"\'\/\\!\?\(\)\-]/', ' ', $text);
        $text = preg_replace('/[^a-zабвгдеёжзийклмнопрстуфхцчшщъыьэюя0-9 ]+/', '', $text);
    }
}
