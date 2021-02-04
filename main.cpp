#include <iostream>
#include <memory.h>
#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <stdint.h>
#include <unistd.h>
#include <stdarg.h>

using namespace std;

char abs_exe_path[512]     = "";

static char encoding_table[] = {'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
                                'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                                'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
                                'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f',
                                'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
                                'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
                                'w', 'x', 'y', 'z', '0', '1', '2', '3',
                                '4', '5', '6', '7', '8', '9', '+', '/'};

static int mod_table[] = {0, 2, 1};

char *base64_encode(const unsigned char *data,
                    size_t input_length,
                    size_t *output_length) {

    *output_length = 4 * ((input_length + 2) / 3);

    char *encoded_data = (char*)malloc(*output_length);
    if (encoded_data == NULL) return NULL;

    for (unsigned int i = 0, j = 0; i < input_length;) {

        uint32_t octet_a = i < input_length ? (unsigned char)data[i++] : 0;
        uint32_t octet_b = i < input_length ? (unsigned char)data[i++] : 0;
        uint32_t octet_c = i < input_length ? (unsigned char)data[i++] : 0;

        uint32_t triple = (octet_a << 0x10) + (octet_b << 0x08) + octet_c;

        encoded_data[j++] = encoding_table[(triple >> 3 * 6) & 0x3F];
        encoded_data[j++] = encoding_table[(triple >> 2 * 6) & 0x3F];
        encoded_data[j++] = encoding_table[(triple >> 1 * 6) & 0x3F];
        encoded_data[j++] = encoding_table[(triple >> 0 * 6) & 0x3F];
    }

    for (int i = 0; i < mod_table[input_length % 3]; i++)
        encoded_data[*output_length - 1 - i] = '=';

    return encoded_data;
}

/// -----------------------------------------------------------------------------------------
void string_replace_all(std::string& str, const std::string& from, const std::string& to)
{
    if(from.empty())
        return;
    size_t start_pos = 0;
    while((start_pos = str.find(from, start_pos)) != std::string::npos)
    {
        str.replace(start_pos, from.length(), to);
        start_pos += to.length(); // In case 'to' contains 'from', like replacing 'x' with 'yx'
    }
}
///-------------------------------------------------------------------------------------
std::string string_format(const std::string &fmt, ...)
{
    int size = 100;
    std::string str;
    va_list ap;
    while (1)
    {
        str.resize(size);
        va_start(ap, fmt);
        int n = vsnprintf((char *)str.c_str(), size, fmt.c_str(), ap);
        va_end(ap);
        if (n > -1 && n < size)
        {
            str.resize(n);
            //printf("\nresize %d\n", n);
            return str;
        }
        if (n > -1)
            size = n + 1;
        else
            size *= 2;
    }
    return str;
}
///-------------------------------------------------------------------------------------
string filter_text_1(string _text)
{
    string result = "", tmp = "";
    
    //string_replace_all(_text, "\n", " ");

    size_t size_out;
    char *res2 = (char *)base64_encode((const unsigned char *)_text.c_str(), _text.length(), &size_out);

    tmp.append( res2, size_out );

    FILE *fp;
    char path[2048];
    string _exec_cmd = string_format("TERM=dumb /usr/bin/php -f %s/../../filter_bad_words.php \"%s\"", abs_exe_path, tmp.c_str());
    
    fp = popen(_exec_cmd.c_str(), "r");
    if (fp == NULL)
    {
        return _text;
    }

    // Read the output a line at a time - output it.
    while (fgets(path, sizeof(path)-1, fp) != NULL)  {
        result.append( path );
    }

    pclose(fp);

    return result;
}

int main(int argc, char **argv)
{
    ///---------------------------------------------------------
    char path_save[512] = "";
    char *p;
    string s;

    if(!(p = strrchr(argv[0], '/'))) {
        getcwd(abs_exe_path, sizeof(abs_exe_path));
    }
    else {
        *p = '\0';
        getcwd(path_save, sizeof(path_save));
        chdir(argv[0]);
        getcwd(abs_exe_path, sizeof(abs_exe_path));
        chdir(path_save);
    }

    string txt    = "Уайнэсджи мастер. Беру слова, хуярю тебя чайник,\n"
                    "чтоб ты знал, я не перегибаю палку, ломаю её о твой тупорылый еблальник\n"
                    "(Bitch!). Так жёстко, но у меня и так не было шансов\n"
                    "и не надо похвалы мне от каких-то стрёмных групп, педантов.\n"
                    "Вы не понимаете меня мой рэп, а я вас, ваши глупые шутки,\n"
                    "да я такой злой ублюдки! Вам устрою язву желудка, блять!\n"
                    "Они ждут помощи от меня, как же всё иначе было тут,\n"
                    "я помню всё, так жаль, но мой ответ вам (Хууууууууууууууйй!!!),\n"
                    "(ЭЙЙЙ!) я просто лью ещё больше масла в огонь...\n"
                    "(ЭЙЙЙ!)я просто ссу на ваши треки, будто водапады с гор,\n"
                    "(ЭЙЙЙ!) вам вечно не так что-то, каждый из вас больной задрот.\n"
                    "Так печально, но вы останетесь там же, а мечты покорения высот -\n"
                    "(Fuck all!) Ты не king, слоун, ты не boss, а соска, тормоз,\n"
                    "волочись со всеми в очереди, но ты ведь как всегда по жизне в жопе.\n"
                    "Хуле ты хочешь? На чужом хую далеко не уедишь, bitch!\n"
                    "Я не могу вас слушать, потому я навечно здесь, слышь!\n"

            ;
    string result = filter_text_1(txt);

    printf("%s\n", result.c_str() );

    return 0;
}
