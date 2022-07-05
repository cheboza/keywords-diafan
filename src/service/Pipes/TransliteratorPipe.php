<?php

namespace Diafanfh\Keywords\Pipes;

class TransliteratorPipe extends AbstractPipe
{
    public function switching(string $wordHandle):?string
    {
        // по первому сиволу определяем язык, потом транслицируем
        $firstChar = mb_substr($wordHandle, 0, 1);
        $handledWord = '';
        if(preg_match('/^[а-яё]+$/iu', $firstChar))
        {
            $handledWord = $this->ruToEn($wordHandle);
        } elseif (preg_match('/^[a-z]+$/iu', $firstChar)) {
            $handledWord = $this->enToRu($wordHandle);
        }
        return $handledWord;
    }

    private function enToRu($string)
    {
        $ru = array(
            "Щ", "Ш", "Ч", "Ц", "Ю", "Я", "Ж", "А", "Б", "В",
            "Г", "Д", "Е", "Ё", "З", "И", "Й", "К", "Л", "М", "Н",
            "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ь", "Ы", "Ъ",
            "Э", "Є", "Ї", "І",
            "щ", "ш", "ч", "ц", "ю", "я", "ж", "а", "б", "в",
            "г", "д", "е", "ё", "з", "и", "й", "к", "л", "м", "н",
            "о", "п", "р", "с", "т", "у", "ф", "х", "ь", "ы", "ъ",
            "э", "є", "ї", "і"
        );
        $en = array(
            "Shch", "Sh", "Ch", "C", "Yu", "Ya", "J", "A", "B", "V",
            "G", "D", "E", "E", "Z", "I", "y", "K", "L", "M", "N",
            "O", "P", "R", "S", "T", "U", "F", "H", "",
            "Y", "", "E", "E", "Yi", "I",
            "shch", "sh", "ch", "c", "Yu", "Ya", "j", "a", "b", "v",
            "g", "d", "e", "e", "z", "i", "y", "k", "l", "m", "n",
            "o", "p", "r", "s", "t", "u", "f", "h",
            "", "y", "", "e", "e", "yi", "i"
        );
        $string = str_replace($en, $ru, $string);
        return str_replace("_", " ", $string);
    }

    private function ruToEn($source)
    {
        $ru = [
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
        ];
        $en = [
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Shch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya',
            'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j', 'ck', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', 'y', 'y', 'y', 'e', 'yu', 'ya'
        ];
        return str_replace($ru, $en, $source);
    }
}
