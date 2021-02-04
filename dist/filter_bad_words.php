<?php

class ObsceneCensorRus {
    public static $log;
    public static $logEx;

    private static $LT_P = 'пПnPp';
    private static $LT_I = 'иИiI1u';
    private static $LT_E = 'еЕeE';
    private static $LT_D = 'дДdD';
    private static $LT_Z = 'зЗ3zZ3';
    private static $LT_M = 'мМmM';
    private static $LT_U = 'уУyYuU';
    private static $LT_O = 'оОoO0';
    private static $LT_L = 'лЛlL';
    private static $LT_S = 'сСcCsS';
    private static $LT_A = 'аАaA';
    private static $LT_N = 'нНhH';
    private static $LT_G = 'гГgG';
    private static $LT_CH = 'чЧ4';
    private static $LT_K = 'кКkK';
    private static $LT_C = 'цЦcC';
    private static $LT_R = 'рРpPrR';
    private static $LT_H = 'хХxXhH';
    private static $LT_YI = 'йЙy';
    private static $LT_YA = 'яЯ';
    private static $LT_YO = 'ёЁ';
    private static $LT_YU = 'юЮ';
    private static $LT_B = 'бБ6bB';
    private static $LT_T = 'тТtT';
    private static $LT_HS = 'ъЪ';
    private static $LT_SS = 'ьЬ';
    private static $LT_Y = 'ыЫ';


    public static $exceptions = array(
        'команд',
        'рубл',
        'премь',
        'оскорб',
        'краснояр',
        'бояр',
        'ноябр',
        'карьер',
        'мандат',
        'употр',
        'плох',
        'интер',
        'веер',
        'фаер',
        'феер',
        'hyundai',
        'тату',
        'браконь',
        'roup',
        'сараф',
        'держ',
        'слаб',
        'ридер',
        'истреб',
        'потреб',
        'коридор',
        'sound',
        'дерг',
        'подоб',
        'коррид',
        'дубл',
        'курьер',
        'экст',
        'try',
        'enter',
        'oun',
        'aube',
        'ibarg',
        '16',
        'kres',
        'глуб',
        'ebay',
        'eeb',
        'shuy',
        'ансам',
        'cayenne',
        'ain',
        'oin',
        'тряс',
        'ubu',
        'uen',
        'uip',
        'oup',
        'кораб',
        'боеп',
        'деепр',
        'хульс',
        'een',
        'ee6',
        'ein',
        'сугуб',
        'карб',
        'гроб',
        'лить',
        'рсук',
        'влюб',
        'хулио',
        'ляп',
        'граб',
        'ибог',
        'вело',
        'ебэ',
        'перв',
        'eep',
        'dying',
        'laun',
        'чаепитие',
    );

    public static function getFiltered($text, $charset = 'UTF-8') {
        self::filterText($text, $charset);
        return $text;
    }

    public static function isAllowed($text, $charset = 'UTF-8') {
        $original = $text;
        self::filterText($text, $charset);
        return $original === $text;
    }

    public static function filterText(&$text, $charset = 'UTF-8')
    {
        $utf8 = 'UTF-8';

        if ($charset !== $utf8) {
            $text = iconv($charset, $utf8, $text);
        }

        preg_match_all('/
\b\d*(
	\w*[' . self::$LT_P . '][' . self::$LT_I . self::$LT_E . '][' . self::$LT_Z . '][' . self::$LT_D . ']\w* # пизда
|
	(?:[^' . self::$LT_I . self::$LT_U . '\s]+|' . self::$LT_N . self::$LT_I . ')?(?<!стра)[' . self::$LT_H . '][' . self::$LT_U . '][' . self::$LT_YI . self::$LT_E . self::$LT_YA . self::$LT_YO . self::$LT_I . self::$LT_L . self::$LT_YU . '](?!иг)\w* # хуй; не пускает "подстрахуй", "хулиган"
|
	\w*[' . self::$LT_B . '][' . self::$LT_L . '](?:
		[' . self::$LT_YA . ']+[' . self::$LT_D . self::$LT_T . ']?
		|
		[' . self::$LT_I . ']+[' . self::$LT_D . self::$LT_T . ']+
		|
		[' . self::$LT_I . ']+[' . self::$LT_A . ']+
	)(?!х)\w* # бля, блядь; не пускает "бляха"
|
	(?:
		\w*[' . self::$LT_YI . self::$LT_U . self::$LT_E . self::$LT_A . self::$LT_O . self::$LT_HS . self::$LT_SS . self::$LT_Y . self::$LT_YA . '][' . self::$LT_E . self::$LT_YO . self::$LT_YA . self::$LT_I . '][' . self::$LT_B . self::$LT_P . '](?!ы\b|ол)\w* # не пускает "еёбы", "наиболее", "наибольшее"...
		|
		[' . self::$LT_E . self::$LT_YO . '][' . self::$LT_B . ']\w*
		|
		[' . self::$LT_I . '][' . /*self::$LT_P .*/ self::$LT_B . '][' . self::$LT_A . ']\w+
		|
		[' . self::$LT_YI . '][' . self::$LT_O . '][' . self::$LT_B . self::$LT_P . ']\w*
	) # ебать
|
	\w*[' . self::$LT_S . '][' . self::$LT_C . ']?[' . self::$LT_U . ']+(?:
		[' . self::$LT_CH . ']*[' . self::$LT_K . ']+
		|
		[' . self::$LT_CH . ']+[' . self::$LT_K . ']*
	)[' . self::$LT_A . self::$LT_O . ']\w* # сука
|
	\w*(?:
		[' . self::$LT_P . '][' . self::$LT_I . self::$LT_E . '][' . self::$LT_D . '][' . self::$LT_A . self::$LT_O . self::$LT_E/* . self::$LT_I*/ . ']?[' . self::$LT_R . '](?!о)\w* # не пускает "Педро"
		|
		[' . self::$LT_P . '][' . self::$LT_E . '][' . self::$LT_D . '][' . self::$LT_E . self::$LT_I . ']?[' . self::$LT_G . self::$LT_K . ']
	) # пидарас
|
	\w*[' . self::$LT_Z . '][' . self::$LT_A . self::$LT_O . '][' . self::$LT_L . '][' . self::$LT_U . '][' . self::$LT_P . ']\w* # залупа
|
	\w*[' . self::$LT_M . '][' . self::$LT_A . '][' . self::$LT_N . '][' . self::$LT_D . '][' . self::$LT_A . self::$LT_O . ']\w* # манда
)\b
/xu', $text, $m);


        $c = count($m[1]);

        /*
        $exclusion=array('хлеба','наиболее');
        $m[1]=array_diff($m[1],$exclusion);
        */

        if ($c > 0) {
            for ($i = 0; $i < $c; $i++) {
                $word = $m[1][$i];
                $word = mb_strtolower($word, $utf8);

                foreach (self::$exceptions as $x) {
                    if (mb_strpos($word, $x) !== false) {
                        if (is_array(self::$logEx)) {
                            $t = &self::$logEx[$m[1][$i]];
                            ++$t;
                        }
                        $word = false;
                        unset($m[1][$i]);
                        break;
                    }
                }

                if ($word) {
                    $m[1][$i] = str_replace(array(' ', ',', ';', '.', '!', '-', '?', "\t", "\n"), '', $m[1][$i]);
                }
            }

            $m[1] = array_unique($m[1]);

            //var_dump($m[1]);
            $asterisks = array();
            foreach ($m[1] as $word) {
                if (is_array(self::$log)) {
                    $t = &self::$log[$word];
                    ++$t;
                }
                $asterisks []= str_repeat('*', mb_strlen($word, $utf8));
            }

            $text = str_replace($m[1], $asterisks, $text);

            if ($charset !== $utf8) {
                $text = iconv($utf8, $charset, $text);
            }

            return true;
        } else {
            if ($charset !== $utf8) {
                $text = iconv($utf8, $charset, $text);
            }

            return false;
        }
    }

}

//var_dump("-----------------------------------------------------");

$text = base64_decode($argv[1]);

if( strlen(trim($text)) == 0 )
{
    exit("");
}


ObsceneCensorRus::filterText( $text );

//$pattern = "\w{0,5}[хx]([хx\s\!@#\$%\^&*+-\|\/]{0,6})[уy]([уy\s\!@#\$%\^&*+-\|\/]{0,6})[ёiлeеюийя]\w{0,7}|\w{0,6}[пp]([пp\s\!@#\$%\^&*+-\|\/]{0,6})[iие]([iие\s\!@#\$%\^&*+-\|\/]{0,6})[3зс]([3зс\s\!@#\$%\^&*+-\|\/]{0,6})[дd]\w{0,10}|[сcs][уy]([уy\!@#\$%\^&*+-\|\/]{0,6})[4чkк]\w{1,3}|\w{0,4}[bб]([bб\s\!@#\$%\^&*+-\|\/]{0,6})[lл]([lл\s\!@#\$%\^&*+-\|\/]{0,6})[yя]\w{0,10}|\w{0,8}[её][bб][лске@eыиаa][наи@йвл]\w{0,8}|\w{0,4}[еe]([еe\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[uу]([uу\s\!@#\$%\^&*+-\|\/]{0,6})[н4ч]\w{0,4}|\w{0,4}[еeё]([еeё\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[нn]([нn\s\!@#\$%\^&*+-\|\/]{0,6})[уy]\w{0,4}|\w{0,4}[еe]([еe\s\!@#\$%\^&*+-\|\/]{0,6})[бb]([бb\s\!@#\$%\^&*+-\|\/]{0,6})[оoаa@]([оoаa@\s\!@#\$%\^&*+-\|\/]{0,6})[тnнt]\w{0,4}|\w{0,10}[ё]([ё\!@#\$%\^&*+-\|\/]{0,6})[б]\w{0,6}|\w{0,4}[pп]([pп\s\!@#\$%\^&*+-\|\/]{0,6})[иeеi]([иeеi\s\!@#\$%\^&*+-\|\/]{0,6})[дd]([дd\s\!@#\$%\^&*+-\|\/]{0,6})[oоаa@еeиi]([oоаa@еeиi\s\!@#\$%\^&*+-\|\/]{0,6})[рr]\w{0,12}";

//$text = mb_eregi_replace($pattern, '***', $text);

$text = preg_replace('/\b6ля\b/ui', '***', $text);
$text = preg_replace('/\b6лядь\b/ui', '***', $text);
$text = preg_replace('/\b6лять\b/ui', '***', $text);
$text = preg_replace('/\bb3ъeб\b/ui', '***', $text);
$text = preg_replace('/\bcock\b/ui', '***', $text);
$text = preg_replace('/\bcunt\b/ui', '***', $text);
$text = preg_replace('/\be6aль\b/ui', '***', $text);
$text = preg_replace('/\bebal\b/ui', '***', $text);
$text = preg_replace('/\beblan\b/ui', '***', $text);
$text = preg_replace('/\beбaл\b/ui', '***', $text);
$text = preg_replace('/\beбaть\b/ui', '***', $text);
$text = preg_replace('/\beбyч\b/ui', '***', $text);
$text = preg_replace('/\beбать\b/ui', '***', $text);
$text = preg_replace('/\beбёт\b/ui', '***', $text);
$text = preg_replace('/\beблантий\b/ui', '***', $text);
$text = preg_replace('/\bfuck\b/ui', '***', $text);
$text = preg_replace('/\bfucker\b/ui', '***', $text);
$text = preg_replace('/\bfucking\b/ui', '***', $text);
$text = preg_replace('/\bxyёв\b/ui', '***', $text);
$text = preg_replace('/\bxyй\b/ui', '***', $text);
$text = preg_replace('/\bxyя\b/ui', '***', $text);
$text = preg_replace('/\bxуе\b/ui', '***', $text);
$text = preg_replace('/\bxуй\b/ui', '***', $text);
$text = preg_replace('/\bx[у]+й\b/ui', '***', $text);
$text = preg_replace('/\bxую\b/ui', '***', $text);
$text = preg_replace('/\bzaeb\b/ui', '***', $text);
$text = preg_replace('/\bzaebal\b/ui', '***', $text);
$text = preg_replace('/\bzaebali\b/ui', '***', $text);
$text = preg_replace('/\bzaebat\b/ui', '***', $text);
$text = preg_replace('/\bархипиздрит\b/ui', '***', $text);
$text = preg_replace('/\bахуел\b/ui', '***', $text);
$text = preg_replace('/\bахуеть\b/ui', '***', $text);
$text = preg_replace('/\bбздение\b/ui', '***', $text);
$text = preg_replace('/\bбздеть\b/ui', '***', $text);
$text = preg_replace('/\bбздех\b/ui', '***', $text);
$text = preg_replace('/\bбздецы\b/ui', '***', $text);
$text = preg_replace('/\bбздит\b/ui', '***', $text);
$text = preg_replace('/\bбздицы\b/ui', '***', $text);
$text = preg_replace('/\bбздло\b/ui', '***', $text);
$text = preg_replace('/\bбзднуть\b/ui', '***', $text);
$text = preg_replace('/\bбздун\b/ui', '***', $text);
$text = preg_replace('/\bбздунья\b/ui', '***', $text);
$text = preg_replace('/\bбздюха\b/ui', '***', $text);
$text = preg_replace('/\bбздюшка\b/ui', '***', $text);
$text = preg_replace('/\bбздюшко\b/ui', '***', $text);
$text = preg_replace('/\bбля\b/ui', '***', $text);
$text = preg_replace('/\bблябу\b/ui', '***', $text);
$text = preg_replace('/\bблябуду\b/ui', '***', $text);
$text = preg_replace('/\bбляд\b/ui', '***', $text);
$text = preg_replace('/\bбляди\b/ui', '***', $text);
$text = preg_replace('/\bблядина\b/ui', '***', $text);
$text = preg_replace('/\bблядище\b/ui', '***', $text);
$text = preg_replace('/\bблядки\b/ui', '***', $text);
$text = preg_replace('/\bблядовать\b/ui', '***', $text);
$text = preg_replace('/\bблядство\b/ui', '***', $text);
$text = preg_replace('/\bблядун\b/ui', '***', $text);
$text = preg_replace('/\bблядуны\b/ui', '***', $text);
$text = preg_replace('/\bблядунья\b/ui', '***', $text);
$text = preg_replace('/\bблядь\b/ui', '***', $text);
$text = preg_replace('/\bблядюга\b/ui', '***', $text);
$text = preg_replace('/\bблять\b/ui', '***', $text);
$text = preg_replace('/\bвафел\b/ui', '***', $text);
$text = preg_replace('/\bвафлёр\b/ui', '***', $text);
$text = preg_replace('/\bвзъебка\b/ui', '***', $text);
$text = preg_replace('/\bвзьебка\b/ui', '***', $text);
$text = preg_replace('/\bвзьебывать\b/ui', '***', $text);
$text = preg_replace('/\bвъеб\b/ui', '***', $text);
$text = preg_replace('/\bвъебался\b/ui', '***', $text);
$text = preg_replace('/\bвъебенн\b/ui', '***', $text);
$text = preg_replace('/\bвъебусь\b/ui', '***', $text);
$text = preg_replace('/\bвъебывать\b/ui', '***', $text);
$text = preg_replace('/\bвыблядок\b/ui', '***', $text);
$text = preg_replace('/\bвыблядыш\b/ui', '***', $text);
$text = preg_replace('/\bвыеб\b/ui', '***', $text);
$text = preg_replace('/\bвыебать\b/ui', '***', $text);
$text = preg_replace('/\bвыебен\b/ui', '***', $text);
$text = preg_replace('/\bвыебнулся\b/ui', '***', $text);
$text = preg_replace('/\bвыебон\b/ui', '***', $text);
$text = preg_replace('/\bвыебываться\b/ui', '***', $text);
$text = preg_replace('/\bвыпердеть\b/ui', '***', $text);
$text = preg_replace('/\bвысраться\b/ui', '***', $text);
$text = preg_replace('/\bвыссаться\b/ui', '***', $text);
$text = preg_replace('/\bвьебен\b/ui', '***', $text);
$text = preg_replace('/\bгавно\b/ui', '***', $text);
$text = preg_replace('/\bгавнюк\b/ui', '***', $text);
$text = preg_replace('/\bгавнючка\b/ui', '***', $text);
$text = preg_replace('/\bгамно\b/ui', '***', $text);
$text = preg_replace('/\bгандон\b/ui', '***', $text);
$text = preg_replace('/\bгнид\b/ui', '***', $text);
$text = preg_replace('/\bгнида\b/ui', '***', $text);
$text = preg_replace('/\bгниды\b/ui', '***', $text);
$text = preg_replace('/\bговенка\b/ui', '***', $text);
$text = preg_replace('/\bговенный\b/ui', '***', $text);
$text = preg_replace('/\bговешка\b/ui', '***', $text);
$text = preg_replace('/\bговназия\b/ui', '***', $text);
$text = preg_replace('/\bговнецо\b/ui', '***', $text);
$text = preg_replace('/\bговнище\b/ui', '***', $text);
$text = preg_replace('/\bговно\b/ui', '***', $text);
$text = preg_replace('/\bговноед\b/ui', '***', $text);
$text = preg_replace('/\bговнолинк\b/ui', '***', $text);
$text = preg_replace('/\bговночист\b/ui', '***', $text);
$text = preg_replace('/\bговнюк\b/ui', '***', $text);
$text = preg_replace('/\bговнюха\b/ui', '***', $text);
$text = preg_replace('/\bговнядина\b/ui', '***', $text);
$text = preg_replace('/\bговняк\b/ui', '***', $text);
$text = preg_replace('/\bговняный\b/ui', '***', $text);
$text = preg_replace('/\bговнять\b/ui', '***', $text);
$text = preg_replace('/\bгондон\b/ui', '***', $text);
$text = preg_replace('/\bдоебываться\b/ui', '***', $text);
$text = preg_replace('/\bдолбоеб\b/ui', '***', $text);
$text = preg_replace('/\bдолбоёб\b/ui', '***', $text);
$text = preg_replace('/\bдолбоящер\b/ui', '***', $text);
$text = preg_replace('/\bдрисня\b/ui', '***', $text);
$text = preg_replace('/\bдрист\b/ui', '***', $text);
$text = preg_replace('/\bдристануть\b/ui', '***', $text);
$text = preg_replace('/\bдристать\b/ui', '***', $text);
$text = preg_replace('/\bдристун\b/ui', '***', $text);
$text = preg_replace('/\bдристуха\b/ui', '***', $text);
$text = preg_replace('/\bдрочелло\b/ui', '***', $text);
$text = preg_replace('/\bдрочена\b/ui', '***', $text);
$text = preg_replace('/\bдрочила\b/ui', '***', $text);
$text = preg_replace('/\bдрочилка\b/ui', '***', $text);
$text = preg_replace('/\bдрочистый\b/ui', '***', $text);
$text = preg_replace('/\bдрочить\b/ui', '***', $text);
$text = preg_replace('/\bдрочка\b/ui', '***', $text);
$text = preg_replace('/\bдрочун\b/ui', '***', $text);
$text = preg_replace('/\bе6ал\b/ui', '***', $text);
$text = preg_replace('/\bе6ут\b/ui', '***', $text);
$text = preg_replace('/\bебтвоюмать\b/ui', '***', $text);
$text = preg_replace('/\bёбтвоюмать\b/ui', '***', $text);
$text = preg_replace('/\bёбaн\b/ui', '***', $text);
$text = preg_replace('/\bебaть\b/ui', '***', $text);
$text = preg_replace('/\bебyч\b/ui', '***', $text);
$text = preg_replace('/\bебал\b/ui', '***', $text);
$text = preg_replace('/\bебало\b/ui', '***', $text);
$text = preg_replace('/\bебальник\b/ui', '***', $text);
$text = preg_replace('/\bебан\b/ui', '***', $text);
$text = preg_replace('/\bебанамать\b/ui', '***', $text);
$text = preg_replace('/\bебанат\b/ui', '***', $text);
$text = preg_replace('/\bебаная\b/ui', '***', $text);
$text = preg_replace('/\bёбаная\b/ui', '***', $text);
$text = preg_replace('/\bебанический\b/ui', '***', $text);
$text = preg_replace('/\bебанный\b/ui', '***', $text);
$text = preg_replace('/\bебанныйврот\b/ui', '***', $text);
$text = preg_replace('/\bебаное\b/ui', '***', $text);
$text = preg_replace('/\bебануть\b/ui', '***', $text);
$text = preg_replace('/\bебануться\b/ui', '***', $text);
$text = preg_replace('/\bёбаную\b/ui', '***', $text);
$text = preg_replace('/\bебаный\b/ui', '***', $text);
$text = preg_replace('/\bебанько\b/ui', '***', $text);
$text = preg_replace('/\bебарь\b/ui', '***', $text);
$text = preg_replace('/\bебат\b/ui', '***', $text);
$text = preg_replace('/\bёбат\b/ui', '***', $text);
$text = preg_replace('/\bебатория\b/ui', '***', $text);
$text = preg_replace('/\bебать\b/ui', '***', $text);
$text = preg_replace('/\bебать-копать\b/ui', '***', $text);
$text = preg_replace('/\bебаться\b/ui', '***', $text);
$text = preg_replace('/\bебашить\b/ui', '***', $text);
$text = preg_replace('/\bебёна\b/ui', '***', $text);
$text = preg_replace('/\bебет\b/ui', '***', $text);
$text = preg_replace('/\bебёт\b/ui', '***', $text);
$text = preg_replace('/\bебец\b/ui', '***', $text);
$text = preg_replace('/\bебик\b/ui', '***', $text);
$text = preg_replace('/\bебин\b/ui', '***', $text);
$text = preg_replace('/\bебись\b/ui', '***', $text);
$text = preg_replace('/\bебическая\b/ui', '***', $text);
$text = preg_replace('/\bебки\b/ui', '***', $text);
$text = preg_replace('/\bебла\b/ui', '***', $text);
$text = preg_replace('/\bеблан\b/ui', '***', $text);
$text = preg_replace('/\bебливый\b/ui', '***', $text);
$text = preg_replace('/\bеблище\b/ui', '***', $text);
$text = preg_replace('/\bебло\b/ui', '***', $text);
$text = preg_replace('/\bеблыст\b/ui', '***', $text);
$text = preg_replace('/\bебля\b/ui', '***', $text);
$text = preg_replace('/\bёбн\b/ui', '***', $text);
$text = preg_replace('/\bебнуть\b/ui', '***', $text);
$text = preg_replace('/\bебнуться\b/ui', '***', $text);
$text = preg_replace('/\bебня\b/ui', '***', $text);
$text = preg_replace('/\bебошить\b/ui', '***', $text);
$text = preg_replace('/\bебская\b/ui', '***', $text);
$text = preg_replace('/\bебский\b/ui', '***', $text);
$text = preg_replace('/\bебтвоюмать\b/ui', '***', $text);
$text = preg_replace('/\bебун\b/ui', '***', $text);
$text = preg_replace('/\bебут\b/ui', '***', $text);
$text = preg_replace('/\bебуч\b/ui', '***', $text);
$text = preg_replace('/\bебуче\b/ui', '***', $text);
$text = preg_replace('/\bебучее\b/ui', '***', $text);
$text = preg_replace('/\bебучий\b/ui', '***', $text);
$text = preg_replace('/\bебучим\b/ui', '***', $text);
$text = preg_replace('/\bебущ\b/ui', '***', $text);
$text = preg_replace('/\bебырь\b/ui', '***', $text);
$text = preg_replace('/\bелда\b/ui', '***', $text);
$text = preg_replace('/\bелдак\b/ui', '***', $text);
$text = preg_replace('/\bелдачить\b/ui', '***', $text);
$text = preg_replace('/\bжопа\b/ui', '***', $text);
$text = preg_replace('/\bжопу\b/ui', '***', $text);
$text = preg_replace('/\bзаговнять\b/ui', '***', $text);
$text = preg_replace('/\bзадрачивать\b/ui', '***', $text);
$text = preg_replace('/\bзадристать\b/ui', '***', $text);
$text = preg_replace('/\bзадрота\b/ui', '***', $text);
$text = preg_replace('/\bзае6\b/ui', '***', $text);
$text = preg_replace('/\bзаё6\b/ui', '***', $text);
$text = preg_replace('/\bзаеб\b/ui', '***', $text);
$text = preg_replace('/\bзаёб\b/ui', '***', $text);
$text = preg_replace('/\bзаеба\b/ui', '***', $text);
$text = preg_replace('/\bзаебал\b/ui', '***', $text);
$text = preg_replace('/\bзаебанец\b/ui', '***', $text);
$text = preg_replace('/\bзаебастая\b/ui', '***', $text);
$text = preg_replace('/\bзаебастый\b/ui', '***', $text);
$text = preg_replace('/\bзаебать\b/ui', '***', $text);
$text = preg_replace('/\bзаебаться\b/ui', '***', $text);
$text = preg_replace('/\bзаебашить\b/ui', '***', $text);
$text = preg_replace('/\bзаебистое\b/ui', '***', $text);
$text = preg_replace('/\bзаёбистое\b/ui', '***', $text);
$text = preg_replace('/\bзаебистые\b/ui', '***', $text);
$text = preg_replace('/\bзаёбистые\b/ui', '***', $text);
$text = preg_replace('/\bзаебистый\b/ui', '***', $text);
$text = preg_replace('/\bзаёбистый\b/ui', '***', $text);
$text = preg_replace('/\bзаебись\b/ui', '***', $text);
$text = preg_replace('/\bзаебошить\b/ui', '***', $text);
$text = preg_replace('/\bзаебываться\b/ui', '***', $text);
$text = preg_replace('/\bзалуп\b/ui', '***', $text);
$text = preg_replace('/\bзалупа\b/ui', '***', $text);
$text = preg_replace('/\bзалупаться\b/ui', '***', $text);
$text = preg_replace('/\bзалупить\b/ui', '***', $text);
$text = preg_replace('/\bзалупиться\b/ui', '***', $text);
$text = preg_replace('/\bзамудохаться\b/ui', '***', $text);
$text = preg_replace('/\bзапиздячить\b/ui', '***', $text);
$text = preg_replace('/\bзасерать\b/ui', '***', $text);
$text = preg_replace('/\bзасерун\b/ui', '***', $text);
$text = preg_replace('/\bзасеря\b/ui', '***', $text);
$text = preg_replace('/\bзасирать\b/ui', '***', $text);
$text = preg_replace('/\bзасрун\b/ui', '***', $text);
$text = preg_replace('/\bзахуячить\b/ui', '***', $text);
$text = preg_replace('/\bзаябестая\b/ui', '***', $text);
$text = preg_replace('/\bзлоеб\b/ui', '***', $text);
$text = preg_replace('/\bзлоебучая\b/ui', '***', $text);
$text = preg_replace('/\bзлоебучее\b/ui', '***', $text);
$text = preg_replace('/\bзлоебучий\b/ui', '***', $text);
$text = preg_replace('/\bибанамат\b/ui', '***', $text);
$text = preg_replace('/\bибонех\b/ui', '***', $text);
$text = preg_replace('/\bизговнять\b/ui', '***', $text);
$text = preg_replace('/\bизговняться\b/ui', '***', $text);
$text = preg_replace('/\bизъебнуться\b/ui', '***', $text);
$text = preg_replace('/\bипать\b/ui', '***', $text);
$text = preg_replace('/\bипаться\b/ui', '***', $text);
$text = preg_replace('/\bипаццо\b/ui', '***', $text);
$text = preg_replace('/\bКакдвапальцаобоссать\b/ui', '***', $text);
$text = preg_replace('/\bконча\b/ui', '***', $text);
$text = preg_replace('/\bкурва\b/ui', '***', $text);
$text = preg_replace('/\bкурвятник\b/ui', '***', $text);
$text = preg_replace('/\bлох\b/ui', '***', $text);
$text = preg_replace('/\bлошарa\b/ui', '***', $text);
$text = preg_replace('/\bлошара\b/ui', '***', $text);
$text = preg_replace('/\bлошары\b/ui', '***', $text);
$text = preg_replace('/\bлошок\b/ui', '***', $text);
$text = preg_replace('/\bлярва\b/ui', '***', $text);
$text = preg_replace('/\bмалафья\b/ui', '***', $text);
$text = preg_replace('/\bманда\b/ui', '***', $text);
$text = preg_replace('/\bмандавошек\b/ui', '***', $text);
$text = preg_replace('/\bмандавошка\b/ui', '***', $text);
$text = preg_replace('/\bмандавошки\b/ui', '***', $text);
$text = preg_replace('/\bмандей\b/ui', '***', $text);
$text = preg_replace('/\bмандень\b/ui', '***', $text);
$text = preg_replace('/\bмандеть\b/ui', '***', $text);
$text = preg_replace('/\bмандища\b/ui', '***', $text);
$text = preg_replace('/\bмандой\b/ui', '***', $text);
$text = preg_replace('/\bманду\b/ui', '***', $text);
$text = preg_replace('/\bмандюк\b/ui', '***', $text);
$text = preg_replace('/\bминет\b/ui', '***', $text);
$text = preg_replace('/\bминетчик\b/ui', '***', $text);
$text = preg_replace('/\bминетчица\b/ui', '***', $text);
$text = preg_replace('/\bмлять\b/ui', '***', $text);
$text = preg_replace('/\bмокрощелка\b/ui', '***', $text);
$text = preg_replace('/\bмокрощёлка\b/ui', '***', $text);
$text = preg_replace('/\bмразь\b/ui', '***', $text);
$text = preg_replace('/\bмудak\b/ui', '***', $text);
$text = preg_replace('/\bмудaк\b/ui', '***', $text);
$text = preg_replace('/\bмудаг\b/ui', '***', $text);
$text = preg_replace('/\bмудак\b/ui', '***', $text);
$text = preg_replace('/\bмуде\b/ui', '***', $text);
$text = preg_replace('/\bмудель\b/ui', '***', $text);
$text = preg_replace('/\bмудеть\b/ui', '***', $text);
$text = preg_replace('/\bмуди\b/ui', '***', $text);
$text = preg_replace('/\bмудил\b/ui', '***', $text);
$text = preg_replace('/\bмудила\b/ui', '***', $text);
$text = preg_replace('/\bмудистый\b/ui', '***', $text);
$text = preg_replace('/\bмудня\b/ui', '***', $text);
$text = preg_replace('/\bмудоеб\b/ui', '***', $text);
$text = preg_replace('/\bмудозвон\b/ui', '***', $text);
$text = preg_replace('/\bмудоклюй\b/ui', '***', $text);
$text = preg_replace('/\bнахер\b/ui', '***', $text);
$text = preg_replace('/\bнахуй\b/ui', '***', $text);
$text = preg_replace('/\bнабздел\b/ui', '***', $text);
$text = preg_replace('/\bнабздеть\b/ui', '***', $text);
$text = preg_replace('/\bнаговнять\b/ui', '***', $text);
$text = preg_replace('/\bнадристать\b/ui', '***', $text);
$text = preg_replace('/\bнадрочить\b/ui', '***', $text);
$text = preg_replace('/\bнаебать\b/ui', '***', $text);
$text = preg_replace('/\bнаебет\b/ui', '***', $text);
$text = preg_replace('/\bнаебнуть\b/ui', '***', $text);
$text = preg_replace('/\bнаебнуться\b/ui', '***', $text);
$text = preg_replace('/\bнаебывать\b/ui', '***', $text);
$text = preg_replace('/\bнапиздел\b/ui', '***', $text);
$text = preg_replace('/\bнапиздели\b/ui', '***', $text);
$text = preg_replace('/\bнапиздело\b/ui', '***', $text);
$text = preg_replace('/\bнапиздили\b/ui', '***', $text);
$text = preg_replace('/\bнасрать\b/ui', '***', $text);
$text = preg_replace('/\bнастопиздить\b/ui', '***', $text);
$text = preg_replace('/\bнахер\b/ui', '***', $text);
$text = preg_replace('/\bнахрен\b/ui', '***', $text);
$text = preg_replace('/\bнахуй\b/ui', '***', $text);
$text = preg_replace('/\bнахуйник\b/ui', '***', $text);
$text = preg_replace('/\bнеебет\b/ui', '***', $text);
$text = preg_replace('/\bнеебёт\b/ui', '***', $text);
$text = preg_replace('/\bневротебучий\b/ui', '***', $text);
$text = preg_replace('/\bневъебенно\b/ui', '***', $text);
$text = preg_replace('/\bнехира\b/ui', '***', $text);
$text = preg_replace('/\bнехрен\b/ui', '***', $text);
$text = preg_replace('/\bНехуй\b/ui', '***', $text);
$text = preg_replace('/\bнехуйственно\b/ui', '***', $text);
$text = preg_replace('/\bниибацо\b/ui', '***', $text);
$text = preg_replace('/\bниипацца\b/ui', '***', $text);
$text = preg_replace('/\bниипаццо\b/ui', '***', $text);
$text = preg_replace('/\bниипет\b/ui', '***', $text);
$text = preg_replace('/\bникуя\b/ui', '***', $text);
$text = preg_replace('/\bнихера\b/ui', '***', $text);
$text = preg_replace('/\bнихуя\b/ui', '***', $text);
$text = preg_replace('/\bобдристаться\b/ui', '***', $text);
$text = preg_replace('/\bобосранец\b/ui', '***', $text);
$text = preg_replace('/\bобосрать\b/ui', '***', $text);
$text = preg_replace('/\bобосцать\b/ui', '***', $text);
$text = preg_replace('/\bобосцаться\b/ui', '***', $text);
$text = preg_replace('/\bобсирать\b/ui', '***', $text);
$text = preg_replace('/\bобъебос\b/ui', '***', $text);
$text = preg_replace('/\bобьебатьобьебос\b/ui', '***', $text);
$text = preg_replace('/\bоднохуйственно\b/ui', '***', $text);
$text = preg_replace('/\bопездал\b/ui', '***', $text);
$text = preg_replace('/\bопизде\b/ui', '***', $text);
$text = preg_replace('/\bопизденивающе\b/ui', '***', $text);
$text = preg_replace('/\bостоебенить\b/ui', '***', $text);
$text = preg_replace('/\bостопиздеть\b/ui', '***', $text);
$text = preg_replace('/\bотмудохать\b/ui', '***', $text);
$text = preg_replace('/\bотпиздить\b/ui', '***', $text);
$text = preg_replace('/\bотпиздячить\b/ui', '***', $text);
$text = preg_replace('/\bотпороть\b/ui', '***', $text);
$text = preg_replace('/\bотъебись\b/ui', '***', $text);
$text = preg_replace('/\bохуевательский\b/ui', '***', $text);
$text = preg_replace('/\bохуевать\b/ui', '***', $text);
$text = preg_replace('/\bохуевающий\b/ui', '***', $text);
$text = preg_replace('/\bохуел\b/ui', '***', $text);
$text = preg_replace('/\bохуенно\b/ui', '***', $text);
$text = preg_replace('/\bохуеньчик\b/ui', '***', $text);
$text = preg_replace('/\bохуеть\b/ui', '***', $text);
$text = preg_replace('/\bохуительно\b/ui', '***', $text);
$text = preg_replace('/\bохуительный\b/ui', '***', $text);
$text = preg_replace('/\bохуяньчик\b/ui', '***', $text);
$text = preg_replace('/\bохуячивать\b/ui', '***', $text);
$text = preg_replace('/\bохуячить\b/ui', '***', $text);
$text = preg_replace('/\bочкун\b/ui', '***', $text);
$text = preg_replace('/\bпадла\b/ui', '***', $text);
$text = preg_replace('/\bпадонки\b/ui', '***', $text);
$text = preg_replace('/\bпадонок\b/ui', '***', $text);
$text = preg_replace('/\bпаскуда\b/ui', '***', $text);
$text = preg_replace('/\bпедерас\b/ui', '***', $text);
$text = preg_replace('/\bпедик\b/ui', '***', $text);
$text = preg_replace('/\bпедрик\b/ui', '***', $text);
$text = preg_replace('/\bпедрила\b/ui', '***', $text);
$text = preg_replace('/\bпедрилло\b/ui', '***', $text);
$text = preg_replace('/\bпедрило\b/ui', '***', $text);
$text = preg_replace('/\bпедрилы\b/ui', '***', $text);
$text = preg_replace('/\bпездень\b/ui', '***', $text);
$text = preg_replace('/\bпездит\b/ui', '***', $text);
$text = preg_replace('/\bпездишь\b/ui', '***', $text);
$text = preg_replace('/\bпездо\b/ui', '***', $text);
$text = preg_replace('/\bпездят\b/ui', '***', $text);
$text = preg_replace('/\bпердануть\b/ui', '***', $text);
$text = preg_replace('/\bпердеж\b/ui', '***', $text);
$text = preg_replace('/\bпердение\b/ui', '***', $text);
$text = preg_replace('/\bпердеть\b/ui', '***', $text);
$text = preg_replace('/\bпердильник\b/ui', '***', $text);
$text = preg_replace('/\bперднуть\b/ui', '***', $text);
$text = preg_replace('/\bпёрднуть\b/ui', '***', $text);
$text = preg_replace('/\bпердун\b/ui', '***', $text);
$text = preg_replace('/\bпердунец\b/ui', '***', $text);
$text = preg_replace('/\bпердунина\b/ui', '***', $text);
$text = preg_replace('/\bпердунья\b/ui', '***', $text);
$text = preg_replace('/\bпердуха\b/ui', '***', $text);
$text = preg_replace('/\bпердь\b/ui', '***', $text);
$text = preg_replace('/\bпереёбок\b/ui', '***', $text);
$text = preg_replace('/\bпернуть\b/ui', '***', $text);
$text = preg_replace('/\bпёрнуть\b/ui', '***', $text);
$text = preg_replace('/\bпи3д\b/ui', '***', $text);
$text = preg_replace('/\bпи3де\b/ui', '***', $text);
$text = preg_replace('/\bпи3ду\b/ui', '***', $text);
$text = preg_replace('/\bпиzдец\b/ui', '***', $text);
$text = preg_replace('/\bпидар\b/ui', '***', $text);
$text = preg_replace('/\bпидарaс\b/ui', '***', $text);
$text = preg_replace('/\bпидарас\b/ui', '***', $text);
$text = preg_replace('/\bпидарасы\b/ui', '***', $text);
$text = preg_replace('/\bпидары\b/ui', '***', $text);
$text = preg_replace('/\bпидор\b/ui', '***', $text);
$text = preg_replace('/\bпидорасы\b/ui', '***', $text);
$text = preg_replace('/\bпидорка\b/ui', '***', $text);
$text = preg_replace('/\bпидорок\b/ui', '***', $text);
$text = preg_replace('/\bпидоры\b/ui', '***', $text);
$text = preg_replace('/\bпидрас\b/ui', '***', $text);
$text = preg_replace('/\bпизда\b/ui', '***', $text);
$text = preg_replace('/\bпиздануть\b/ui', '***', $text);
$text = preg_replace('/\bпиздануться\b/ui', '***', $text);
$text = preg_replace('/\bпиздарваньчик\b/ui', '***', $text);
$text = preg_replace('/\bпиздато\b/ui', '***', $text);
$text = preg_replace('/\bпиздатое\b/ui', '***', $text);
$text = preg_replace('/\bпиздатый\b/ui', '***', $text);
$text = preg_replace('/\bпизденка\b/ui', '***', $text);
$text = preg_replace('/\bпизденыш\b/ui', '***', $text);
$text = preg_replace('/\bпиздёныш\b/ui', '***', $text);
$text = preg_replace('/\bпиздеть\b/ui', '***', $text);
$text = preg_replace('/\bпиздец\b/ui', '***', $text);
$text = preg_replace('/\bпиздит\b/ui', '***', $text);
$text = preg_replace('/\bпиздить\b/ui', '***', $text);
$text = preg_replace('/\bпиздиться\b/ui', '***', $text);
$text = preg_replace('/\bпиздишь\b/ui', '***', $text);
$text = preg_replace('/\bпиздища\b/ui', '***', $text);
$text = preg_replace('/\bпиздище\b/ui', '***', $text);
$text = preg_replace('/\bпиздобол\b/ui', '***', $text);
$text = preg_replace('/\bпиздоболы\b/ui', '***', $text);
$text = preg_replace('/\bпиздобратия\b/ui', '***', $text);
$text = preg_replace('/\bпиздоватая\b/ui', '***', $text);
$text = preg_replace('/\bпиздоватый\b/ui', '***', $text);
$text = preg_replace('/\bпиздолиз\b/ui', '***', $text);
$text = preg_replace('/\bпиздонутые\b/ui', '***', $text);
$text = preg_replace('/\bпиздорванец\b/ui', '***', $text);
$text = preg_replace('/\bпиздорванка\b/ui', '***', $text);
$text = preg_replace('/\bпиздострадатель\b/ui', '***', $text);
$text = preg_replace('/\bпизду\b/ui', '***', $text);
$text = preg_replace('/\bпиздуй\b/ui', '***', $text);
$text = preg_replace('/\bпиздун\b/ui', '***', $text);
$text = preg_replace('/\bпиздунья\b/ui', '***', $text);
$text = preg_replace('/\bпизды\b/ui', '***', $text);
$text = preg_replace('/\bпиздюга\b/ui', '***', $text);
$text = preg_replace('/\bпиздюк\b/ui', '***', $text);
$text = preg_replace('/\bпиздюлина\b/ui', '***', $text);
$text = preg_replace('/\bпиздюля\b/ui', '***', $text);
$text = preg_replace('/\bпиздят\b/ui', '***', $text);
$text = preg_replace('/\bпиздячить\b/ui', '***', $text);
$text = preg_replace('/\bписбшки\b/ui', '***', $text);
$text = preg_replace('/\bписька\b/ui', '***', $text);
$text = preg_replace('/\bписькострадатель\b/ui', '***', $text);
$text = preg_replace('/\bписюн\b/ui', '***', $text);
$text = preg_replace('/\bписюшка\b/ui', '***', $text);
$text = preg_replace('/\bпохуй\b/ui', '***', $text);
$text = preg_replace('/\bпохую\b/ui', '***', $text);
$text = preg_replace('/\bподговнять\b/ui', '***', $text);
$text = preg_replace('/\bподонки\b/ui', '***', $text);
$text = preg_replace('/\bподонок\b/ui', '***', $text);
$text = preg_replace('/\bподъебнуть\b/ui', '***', $text);
$text = preg_replace('/\bподъебнуться\b/ui', '***', $text);
$text = preg_replace('/\bпоебать\b/ui', '***', $text);
$text = preg_replace('/\bпоебень\b/ui', '***', $text);
$text = preg_replace('/\bпоёбываает\b/ui', '***', $text);
$text = preg_replace('/\bпоскуда\b/ui', '***', $text);
$text = preg_replace('/\bпосрать\b/ui', '***', $text);
$text = preg_replace('/\bпотаскуха\b/ui', '***', $text);
$text = preg_replace('/\bпотаскушка\b/ui', '***', $text);
$text = preg_replace('/\bпохер\b/ui', '***', $text);
$text = preg_replace('/\bпохерил\b/ui', '***', $text);
$text = preg_replace('/\bпохерила\b/ui', '***', $text);
$text = preg_replace('/\bпохерили\b/ui', '***', $text);
$text = preg_replace('/\bпохеру\b/ui', '***', $text);
$text = preg_replace('/\bпохрен\b/ui', '***', $text);
$text = preg_replace('/\bпохрену\b/ui', '***', $text);
$text = preg_replace('/\bпохуй\b/ui', '***', $text);
$text = preg_replace('/\bпохуист\b/ui', '***', $text);
$text = preg_replace('/\bпохуистка\b/ui', '***', $text);
$text = preg_replace('/\bпохую\b/ui', '***', $text);
$text = preg_replace('/\bпридурок\b/ui', '***', $text);
$text = preg_replace('/\bприебаться\b/ui', '***', $text);
$text = preg_replace('/\bприпиздень\b/ui', '***', $text);
$text = preg_replace('/\bприпизднутый\b/ui', '***', $text);
$text = preg_replace('/\bприпиздюлина\b/ui', '***', $text);
$text = preg_replace('/\bпробзделся\b/ui', '***', $text);
$text = preg_replace('/\bпроблядь\b/ui', '***', $text);
$text = preg_replace('/\bпроеб\b/ui', '***', $text);
$text = preg_replace('/\bпроебанка\b/ui', '***', $text);
$text = preg_replace('/\bпроебать\b/ui', '***', $text);
$text = preg_replace('/\bпромандеть\b/ui', '***', $text);
$text = preg_replace('/\bпромудеть\b/ui', '***', $text);
$text = preg_replace('/\bпропизделся\b/ui', '***', $text);
$text = preg_replace('/\bпропиздеть\b/ui', '***', $text);
$text = preg_replace('/\bпропиздячить\b/ui', '***', $text);
$text = preg_replace('/\bраздолбай\b/ui', '***', $text);
$text = preg_replace('/\bразхуячить\b/ui', '***', $text);
$text = preg_replace('/\bразъеб\b/ui', '***', $text);
$text = preg_replace('/\bразъеба\b/ui', '***', $text);
$text = preg_replace('/\bразъебай\b/ui', '***', $text);
$text = preg_replace('/\bразъебать\b/ui', '***', $text);
$text = preg_replace('/\bраспиздай\b/ui', '***', $text);
$text = preg_replace('/\bраспиздеться\b/ui', '***', $text);
$text = preg_replace('/\bраспиздяй\b/ui', '***', $text);
$text = preg_replace('/\bраспиздяйство\b/ui', '***', $text);
$text = preg_replace('/\bраспроеть\b/ui', '***', $text);
$text = preg_replace('/\bсволота\b/ui', '***', $text);
$text = preg_replace('/\bсволочь\b/ui', '***', $text);
$text = preg_replace('/\bсговнять\b/ui', '***', $text);
$text = preg_replace('/\bсекель\b/ui', '***', $text);
$text = preg_replace('/\bсерун\b/ui', '***', $text);
$text = preg_replace('/\bсерька\b/ui', '***', $text);
$text = preg_replace('/\bсестроеб\b/ui', '***', $text);
$text = preg_replace('/\bсикель\b/ui', '***', $text);
$text = preg_replace('/\bсила\b/ui', '***', $text);
$text = preg_replace('/\bсирать\b/ui', '***', $text);
$text = preg_replace('/\bсирывать\b/ui', '***', $text);
$text = preg_replace('/\bсоси\b/ui', '***', $text);
$text = preg_replace('/\bспиздел\b/ui', '***', $text);
$text = preg_replace('/\bспиздеть\b/ui', '***', $text);
$text = preg_replace('/\bспиздил\b/ui', '***', $text);
$text = preg_replace('/\bспиздила\b/ui', '***', $text);
$text = preg_replace('/\bспиздили\b/ui', '***', $text);
$text = preg_replace('/\bспиздит\b/ui', '***', $text);
$text = preg_replace('/\bспиздить\b/ui', '***', $text);
$text = preg_replace('/\bсрака\b/ui', '***', $text);
$text = preg_replace('/\bсраку\b/ui', '***', $text);
$text = preg_replace('/\bсраный\b/ui', '***', $text);
$text = preg_replace('/\bсранье\b/ui', '***', $text);
$text = preg_replace('/\bсрать\b/ui', '***', $text);
$text = preg_replace('/\bсрун\b/ui', '***', $text);
$text = preg_replace('/\bссака\b/ui', '***', $text);
$text = preg_replace('/\bссышь\b/ui', '***', $text);
$text = preg_replace('/\bстерва\b/ui', '***', $text);
$text = preg_replace('/\bстрахопиздище\b/ui', '***', $text);
$text = preg_replace('/\bсука\b/ui', '***', $text);
$text = preg_replace('/\bсуки\b/ui', '***', $text);
$text = preg_replace('/\bсуходрочка\b/ui', '***', $text);
$text = preg_replace('/\bсучара\b/ui', '***', $text);
$text = preg_replace('/\bсучий\b/ui', '***', $text);
$text = preg_replace('/\bсучка\b/ui', '***', $text);
$text = preg_replace('/\bсучко\b/ui', '***', $text);
$text = preg_replace('/\bсучонок\b/ui', '***', $text);
$text = preg_replace('/\bсучье\b/ui', '***', $text);
$text = preg_replace('/\bсцание\b/ui', '***', $text);
$text = preg_replace('/\bсцать\b/ui', '***', $text);
$text = preg_replace('/\bсцука\b/ui', '***', $text);
$text = preg_replace('/\bсцуки\b/ui', '***', $text);
$text = preg_replace('/\bсцуконах\b/ui', '***', $text);
$text = preg_replace('/\bсцуль\b/ui', '***', $text);
$text = preg_replace('/\bсцыха\b/ui', '***', $text);
$text = preg_replace('/\bсцышь\b/ui', '***', $text);
$text = preg_replace('/\bсъебаться\b/ui', '***', $text);
$text = preg_replace('/\bсыкун\b/ui', '***', $text);
$text = preg_replace('/\bтрахае6\b/ui', '***', $text);
$text = preg_replace('/\bтрахаеб\b/ui', '***', $text);
$text = preg_replace('/\bтрахаёб\b/ui', '***', $text);
$text = preg_replace('/\bтрахатель\b/ui', '***', $text);
$text = preg_replace('/\bублюдок\b/ui', '***', $text);
$text = preg_replace('/\bуебать\b/ui', '***', $text);
$text = preg_replace('/\bуёбища\b/ui', '***', $text);
$text = preg_replace('/\bуебище\b/ui', '***', $text);
$text = preg_replace('/\bуёбище\b/ui', '***', $text);
$text = preg_replace('/\bуебищное\b/ui', '***', $text);
$text = preg_replace('/\bуёбищное\b/ui', '***', $text);
$text = preg_replace('/\bуебк\b/ui', '***', $text);
$text = preg_replace('/\bуебки\b/ui', '***', $text);
$text = preg_replace('/\bуёбки\b/ui', '***', $text);
$text = preg_replace('/\bуебок\b/ui', '***', $text);
$text = preg_replace('/\bуёбок\b/ui', '***', $text);
$text = preg_replace('/\bурюк\b/ui', '***', $text);
$text = preg_replace('/\bусраться\b/ui', '***', $text);
$text = preg_replace('/\bушлепок\b/ui', '***', $text);
$text = preg_replace('/\bх_у_я_р_а\b/ui', '***', $text);
$text = preg_replace('/\bхyё\b/ui', '***', $text);
$text = preg_replace('/\bхyй\b/ui', '***', $text);
$text = preg_replace('/\bхyйня\b/ui', '***', $text);
$text = preg_replace('/\bхамло\b/ui', '***', $text);
$text = preg_replace('/\bхер\b/ui', '***', $text);
$text = preg_replace('/\bхерня\b/ui', '***', $text);
$text = preg_replace('/\bхеровато\b/ui', '***', $text);
$text = preg_replace('/\bхеровина\b/ui', '***', $text);
$text = preg_replace('/\bхеровый\b/ui', '***', $text);
$text = preg_replace('/\bхитровыебанный\b/ui', '***', $text);
$text = preg_replace('/\bхитрожопый\b/ui', '***', $text);
$text = preg_replace('/\bхуeм\b/ui', '***', $text);
$text = preg_replace('/\bхуе\b/ui', '***', $text);
$text = preg_replace('/\bхуё\b/ui', '***', $text);
$text = preg_replace('/\bхуевато\b/ui', '***', $text);
$text = preg_replace('/\bхуёвенький\b/ui', '***', $text);
$text = preg_replace('/\bхуевина\b/ui', '***', $text);
$text = preg_replace('/\bхуево\b/ui', '***', $text);
$text = preg_replace('/\bхуевый\b/ui', '***', $text);
$text = preg_replace('/\bхуёвый\b/ui', '***', $text);
$text = preg_replace('/\bхуек\b/ui', '***', $text);
$text = preg_replace('/\bхуёк\b/ui', '***', $text);
$text = preg_replace('/\bхуел\b/ui', '***', $text);
$text = preg_replace('/\bхуем\b/ui', '***', $text);
$text = preg_replace('/\bхуенч\b/ui', '***', $text);
$text = preg_replace('/\bхуеныш\b/ui', '***', $text);
$text = preg_replace('/\bхуенький\b/ui', '***', $text);
$text = preg_replace('/\bхуеплет\b/ui', '***', $text);
$text = preg_replace('/\bхуеплёт\b/ui', '***', $text);
$text = preg_replace('/\bхуепромышленник\b/ui', '***', $text);
$text = preg_replace('/\bхуерик\b/ui', '***', $text);
$text = preg_replace('/\bхуерыло\b/ui', '***', $text);
$text = preg_replace('/\bхуесос\b/ui', '***', $text);
$text = preg_replace('/\bхуесоска\b/ui', '***', $text);
$text = preg_replace('/\bхуета\b/ui', '***', $text);
$text = preg_replace('/\bхуетень\b/ui', '***', $text);
$text = preg_replace('/\bхуею\b/ui', '***', $text);
$text = preg_replace('/\bхуи\b/ui', '***', $text);
$text = preg_replace('/\bхуй\b/ui', '***', $text);
$text = preg_replace('/\bх[у]+[й]+[!]*?\b/ui', '***', $text);
$text = preg_replace('/\bхуйком\b/ui', '***', $text);
$text = preg_replace('/\bхуйло\b/ui', '***', $text);
$text = preg_replace('/\bхуйня\b/ui', '***', $text);
$text = preg_replace('/\bхуйрик\b/ui', '***', $text);
$text = preg_replace('/\bхуище\b/ui', '***', $text);
$text = preg_replace('/\bхуля\b/ui', '***', $text);
$text = preg_replace('/\bхую\b/ui', '***', $text);
$text = preg_replace('/\bхуюл\b/ui', '***', $text);
$text = preg_replace('/\bхуя\b/ui', '***', $text);
$text = preg_replace('/\bхуяк\b/ui', '***', $text);
$text = preg_replace('/\bхуякать\b/ui', '***', $text);
$text = preg_replace('/\bхуякнуть\b/ui', '***', $text);
$text = preg_replace('/\bхуяра\b/ui', '***', $text);
$text = preg_replace('/\bхуясе\b/ui', '***', $text);
$text = preg_replace('/\bхуячить\b/ui', '***', $text);
$text = preg_replace('/\bцелка\b/ui', '***', $text);
$text = preg_replace('/\bчмо\b/ui', '***', $text);
$text = preg_replace('/\bчмошник\b/ui', '***', $text);
$text = preg_replace('/\bчмырь\b/ui', '***', $text);
$text = preg_replace('/\bшалава\b/ui', '***', $text);
$text = preg_replace('/\bшалавой\b/ui', '***', $text);
$text = preg_replace('/\bшараёбиться\b/ui', '***', $text);
$text = preg_replace('/\bшлюха\b/ui', '***', $text);
$text = preg_replace('/\bшлюхой\b/ui', '***', $text);
$text = preg_replace('/\bшлюшка\b/ui', '***', $text);

echo $text;


