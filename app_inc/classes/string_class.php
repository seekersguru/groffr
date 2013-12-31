<?php
class Playstrings {

/**
 * Purpose: count the number of words in a text
 * @param string
 * @return integer
 */
function countWords($string)
{
    // split text by ' ',\r,\n,\f,\t
    $split_array = preg_split('/\s+/',$string);
    // count matches that contain alphanumerics
    $word_count = preg_grep('/[a-zA-Z0-9\\x80-\\xff]/', $split_array);

    return count($word_count);
}

/**
 * Purpose:  convert string to lowercase
 * @param string
 * @return string
 */
function strLower($string)
{
    return strtolower($string);
}

/**
 * Purpose:  convert string to uppercase
 * @param string
 * @return string
 */
function strUpper($string)
{
    return strtoupper($string);
}


/**
 * Purpose:  simple search/replace
 * @param string
 * @param string
 * @param string
 * @return string
 */
function strfindReplace($string, $search, $replace)
{
    return str_replace($replace, $search, $string);
}

/**
 * Purpose:  Replace all repeated spaces, newlines, tabs
 * with a single space or supplied replacement string.
 * @param string
 * @param string
 * @return string
 */
function strStrip($text, $replace = ' ')
{
    return preg_replace('!\s+!', $replace, $text);
}

/**
 * Purpose:  wrap a string of text at a given length
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @return string
 */
function strWordWrap($string,$length=80,$break="<br />",$cut=false)
{
    return wordwrap($string,$length,$break,$cut);
}


/**
 * Purpose:  strip html tags from text
 * @param string
 * @param boolean
 * @return string
 */
function strStripTags($string, $replace_with_space = true)
{
    if ($replace_with_space)
        return preg_replace('!<[^>]*?>!', ' ', $string);
    else
        return strip_tags($string);
}

/**
 * Purpose:  add spaces between characters in a string
 * @param string
 * @param string
 * @return string
 */
function strSpacify($string, $spacify_char = ' ')
{
    return implode($spacify_char,
                   preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY));
}

function safeText($text = "", $allowable_tags = "<u><i><p>")
{
	if($text == "")
	return;
	
	$newText = strip_tags($text,$allowable_tags);
	return $newText;
}

function str256Char($string = "", $str_len = 256) 
  {
    if ( strlen($string) > $str_len ){
      $short_string = substr($string, 0, $str_len);
    }
    else{
      $short_string = $string;      
    }

    return $short_string."...";
  }
 
 function strBR2NL($string)
  {
	$string = str_replace("<br />","\n",$string);
    return $string;
  }
  
function strNL2BR($string)
{
	$string = str_replace("\n","<br />",$string);
	return $string;
 }
 
 /**
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function strTruncate($string, $length = 80, $etc = '...',
                                  $break_words = false, $middle = false)
{
	if ($length == 0)
        return '';

    if (strlen($string) > $length) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
        }
        if(!$middle) {
            return substr($string, 0, $length) . $etc;
        } else {
            return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
        }
    } else {
        return $string;
    }
}

/**
 * Purpose:  indent lines of text
 * @param string
 * @param integer
 * @param string
 * @return string
 */
function strIndent($string,$chars=4,$char="&nbsp;")
{
    return preg_replace('!^!m',str_repeat($char,$chars),$string);
}

/**
 * Purpose:  count the number of sentences in a text
 * @param string
 * @return integer
 */
function strCountSentences($string)
{
    // find periods with a word before but not after.
    return preg_match_all('/[^\s]\.(?!\w)/', $string, $match);
}

/**
 * Purpose:  count the number of characters in a text
 * @param string
 * @param boolean include whitespace in the character count
 * @return integer
 */
function strCountChar($string, $include_spaces = false)
{
    if ($include_spaces)
       return(strlen($string));

    return preg_match_all("/[^\s]/",$string, $match);
}

/**
 * Purpose:  count the number of paragraphs in a text
 * @param string
 * @return integer
 */
function strCountParagraphs($string)
{
    // count \r or \n characters
    return count(preg_split('/[\r\n]+/', $string));
}

} // end of class
?>