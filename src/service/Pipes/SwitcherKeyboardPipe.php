<?php

namespace Diafanfh\Keywords\Pipes;

class SwitcherKeyboardPipe extends AbstractPipe
{
    protected $converter = array(
        'f' => 'а',	',' => 'б',	'd' => 'в',	'u' => 'г',	'l' => 'д',	't' => 'е',	'`' => 'ё',
        ';' => 'ж',	'p' => 'з',	'b' => 'и',	'q' => 'й',	'r' => 'к',	'k' => 'л',	'v' => 'м',
        'y' => 'н',	'j' => 'о',	'g' => 'п',	'h' => 'р',	'c' => 'с',	'n' => 'т',	'e' => 'у',
        'a' => 'ф',	'[' => 'х',	'w' => 'ц',	'x' => 'ч',	'i' => 'ш',	'o' => 'щ',	'm' => 'ь',
        's' => 'ы',	']' => 'ъ',	"'" => "э",	'.' => 'ю',	'z' => 'я',

        'F' => 'А',	'<' => 'Б',	'D' => 'В',	'U' => 'Г',	'L' => 'Д',	'T' => 'Е',	'~' => 'Ё',
        ':' => 'Ж',	'P' => 'З',	'B' => 'И',	'Q' => 'Й',	'R' => 'К',	'K' => 'Л',	'V' => 'М',
        'Y' => 'Н',	'J' => 'О',	'G' => 'П',	'H' => 'Р',	'C' => 'С',	'N' => 'Т',	'E' => 'У',
        'A' => 'Ф',	'{' => 'Х',	'W' => 'Ц',	'X' => 'Ч',	'I' => 'Ш',	'O' => 'Щ',	'M' => 'Ь',
        'S' => 'Ы',	'}' => 'Ъ',	'"' => 'Э',	'>' => 'Ю',	'Z' => 'Я',

        '@' => '"',	'#' => '№',	'$' => ';',	'^' => ':',	'&' => '?',	'/' => '.',	'?' => ',',
    );

    /**
     * @param string $wordHandle
     * @return string|null
     */
    public function switching(string $wordHandle):?string
    {
        $firstChar = mb_substr($wordHandle, 0, 1);
        $handledWord = '';
        if(!empty($this->converter[$firstChar]))
        {
            $handledWord = strtr($wordHandle, $this->converter);
        } else if(in_array($firstChar, $this->converter)) {
            $handledWord = strtr($wordHandle, array_flip($this->converter));
        }
        return $handledWord;
    }
}
