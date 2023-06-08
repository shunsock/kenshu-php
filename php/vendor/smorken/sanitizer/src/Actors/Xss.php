<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 6/21/16
 * Time: 11:38 AM
 */

namespace Smorken\Sanitizer\Actors;

/**
 * Class Xss
 *
 * @package Smorken\Actor\Sanitizers
 *
 * Borrowed from Drupal 8's Xss::filter
 * @url https://github.com/drupal/drupal/blob/8.2.x/core/lib/Drupal/Component/Utility/Xss.php
 * @license GPL v3
 */
class Xss extends Base
{

    /**
     * The list of HTML tags allowed by filterAdmin().
     *
     * @var array
     *
     * @see \Drupal\Component\Utility\Xss::filterAdmin()
     */
    protected $adminTags = [
        'a',
        'abbr',
        'acronym',
        'address',
        'article',
        'aside',
        'b',
        'bdi',
        'bdo',
        'big',
        'blockquote',
        'br',
        'caption',
        'cite',
        'code',
        'col',
        'colgroup',
        'command',
        'dd',
        'del',
        'details',
        'dfn',
        'div',
        'dl',
        'dt',
        'em',
        'figcaption',
        'figure',
        'footer',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'header',
        'hgroup',
        'hr',
        'i',
        'img',
        'ins',
        'kbd',
        'li',
        'mark',
        'menu',
        'meter',
        'nav',
        'ol',
        'output',
        'p',
        'pre',
        'progress',
        'q',
        'rp',
        'rt',
        'ruby',
        's',
        'samp',
        'section',
        'small',
        'span',
        'strong',
        'sub',
        'summary',
        'sup',
        'table',
        'tbody',
        'td',
        'tfoot',
        'th',
        'thead',
        'time',
        'tr',
        'tt',
        'u',
        'ul',
        'var',
        'wbr',
    ];
    /**
     * The default list of HTML tags allowed by filter().
     *
     * @var array
     *
     * @see \Drupal\Component\Utility\Xss::filter()
     */
    protected $htmlTags = [
        'a',
        'b',
        'cite',
        'blockquote',
        'br',
        'code',
        'dl',
        'dt',
        'dd',
        'em',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'i',
        'li',
        'ol',
        'p',
        'section',
        'small',
        'span',
        'strong',
        'sub',
        'summary',
        'sup',
        'table',
        'tbody',
        'td',
        'tfoot',
        'th',
        'thead',
        'tr',
        'ul',
    ];

    public function checkPlain($text)
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function decodeEntities($text)
    {
        return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    }

    public static function filter($string, array $html_tags = null)
    {
        $xss = new static();
        return $xss->xss($string, $html_tags);
    }

    public static function filterAdmin($string)
    {
        $xss = new static();
        return $xss->xssAdmin($string);
    }

    public function filterBadProtocol($string)
    {
        $string = $this->decodeEntities($string);
        return $this->checkPlain($this->stripDangerousProtocols($string));
    }

    public function stripDangerousProtocols($uri)
    {
        $allowed_protocols = array_flip(['http', 'https']);

        // Iteratively remove any invalid protocol found.
        do {
            $before = $uri;
            $colonpos = strpos($uri, ':');
            if ($colonpos > 0) {

                // We found a colon, possibly a protocol. Verify.
                $protocol = substr($uri, 0, $colonpos);

                // If a colon is preceded by a slash, question mark or hash, it cannot
                // possibly be part of the URL scheme. This must be a relative URL, which
                // inherits the (safe) protocol of the base document.
                if (preg_match('![/?#]!', $protocol)) {
                    break;
                }

                // Check if this is a disallowed protocol. Per RFC2616, section 3.2.3
                // (URI Comparison) scheme comparison must be case-insensitive.
                if (!isset($allowed_protocols[strtolower($protocol)])) {
                    $uri = substr($uri, $colonpos + 1);
                }
            }
        } while ($before !== $uri);

        return $uri;
    }

    public function validateUtf8($text)
    {
        if ($text === '') {
            return true;
        }
        // With the PCRE_UTF8 modifier 'u', preg_match() fails silently on strings
        // containing invalid UTF-8 byte sequences. It does not reject character
        // codes above U+10FFFF (represented by 4 or more octets), though.
        return (preg_match('/^./us', $text) === 1);
    }

    public function xss($string, array $html_tags = null)
    {
        if (is_null($html_tags)) {
            $html_tags = $this->htmlTags;
        }
        // Only operate on valid UTF-8 strings. This is necessary to prevent cross
        // site scripting issues on Internet Explorer 6.
        if (!$this->validateUtf8($string)) {
            return '';
        }
        // Remove NULL characters (ignored by some browsers).
        $string = str_replace(chr(0), '', $string);
        // Remove Netscape 4 JS entities.
        $string = preg_replace('%&\\s*\\{[^}]*(\\}\\s*;?|$)%', '', $string);
        // Defuse all HTML entities.
        $string = str_replace('&', '&amp;', $string);
        // Change back only well-formed entities in our whitelist:
        // Decimal numeric entities.
        $string = preg_replace('/&amp;#([0-9]+;)/', '&#\\1', $string);
        // Hexadecimal numeric entities.
        $string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\\1', $string);
        // Named entities.
        $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\\1', $string);
        $html_tags = array_flip($html_tags);
        $splitter = function ($matches) use ($html_tags) {
            return $this->split($matches[1], $html_tags);
        };
        // Strip any tags that are not in the whitelist.
        return preg_replace_callback('%
          (
          <(?=[^a-zA-Z!/])  # a lone <
          |                 # or
          <!--.*?-->        # a comment
          |                 # or
          <[^>]*(>|$)       # a string that starts with a <, up until the > or the end of the string
          |                 # or
          >                 # just a >
          )%x', $splitter, $string);
    }

    /**
     * Applies a very permissive XSS/HTML filter for admin-only use.
     *
     * Use only for fields where it is impractical to use the
     * whole filter system, but where some (mainly inline) mark-up
     * is desired (so check_plain() is not acceptable).
     *
     * Allows all tags that can be used inside an HTML body, save
     * for scripts and styles.
     *
     * @param  string  $string
     *   The string to apply the filter to.
     *
     * @return string
     *   The filtered string.
     */
    public function xssAdmin($string)
    {
        return $this->xss($string, $this->adminTags);
    }

    /**
     * Processes a string of HTML attributes.
     *
     * @param  string  $attributes
     *   The html attribute to process.
     *
     * @return string
     *   Cleaned up version of the HTML attributes.
     */
    protected function attributes($attributes)
    {
        $attributes_array = [];
        $mode = 0;
        $attribute_name = '';
        $skip = false;
        $skip_protocol_filtering = false;
        while (strlen($attributes) !== 0) {
            // Was the last operation successful?
            $working = 0;
            switch ($mode) {
                case 0:
                    // Attribute name, href for instance.
                    if (preg_match('/^([-a-zA-Z][-a-zA-Z0-9]*)/', $attributes, $match)) {
                        $attribute_name = strtolower($match[1]);
                        $skip = $attribute_name == 'style' || substr($attribute_name, 0, 2) == 'on';
                        // Values for attributes of type URI should be filtered for
                        // potentially malicious protocols (for example, an href-attribute
                        // starting with "javascript:"). However, for some non-URI
                        // attributes performing this filtering causes valid and safe data
                        // to be mangled. We prevent this by skipping protocol filtering on
                        // such attributes.
                        // @see \Drupal\Component\Utility\$this->filterBadProtocol()
                        // @see http://www.w3.org/TR/html4/index/attributes.html
                        $skip_protocol_filtering = substr($attribute_name, 0, 5) === 'data-' ||
                            in_array($attribute_name, [
                                'title',
                                'alt',
                                'rel',
                                'property',
                            ]);
                        $working = $mode = 1;
                        $attributes = preg_replace('/^[-a-zA-Z][-a-zA-Z0-9]*/', '', $attributes);
                    }
                    break;
                case 1:
                    // Equals sign or valueless ("selected").
                    if (preg_match('/^\\s*=\\s*/', $attributes)) {
                        $working = 1;
                        $mode = 2;
                        $attributes = preg_replace('/^\\s*=\\s*/', '', $attributes);
                        break;
                    }
                    if (preg_match('/^\\s+/', $attributes)) {
                        $working = 1;
                        $mode = 0;
                        if (!$skip) {
                            $attributes_array[] = $attribute_name;
                        }
                        $attributes = preg_replace('/^\\s+/', '', $attributes);
                    }
                    break;
                case 2:
                    // Attribute value, a URL after href= for instance.
                    if (preg_match('/^"([^"]*)"(\\s+|$)/', $attributes, $match)) {
                        $thisval = $skip_protocol_filtering ? $match[1] : $this->filterBadProtocol($match[1]);
                        if (!$skip) {
                            $attributes_array[] = "{$attribute_name}=\"{$thisval}\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attributes = preg_replace('/^"[^"]*"(\\s+|$)/', '', $attributes);
                        break;
                    }
                    if (preg_match("/^'([^']*)'(\\s+|\$)/", $attributes, $match)) {
                        $thisval = $skip_protocol_filtering ? $match[1] : $this->filterBadProtocol($match[1]);
                        if (!$skip) {
                            $attributes_array[] = "{$attribute_name}='{$thisval}'";
                        }
                        $working = 1;
                        $mode = 0;
                        $attributes = preg_replace("/^'[^']*'(\\s+|\$)/", '', $attributes);
                        break;
                    }
                    if (preg_match("%^([^\\s\"']+)(\\s+|\$)%", $attributes, $match)) {
                        $thisval = $skip_protocol_filtering ? $match[1] : $this->filterBadProtocol($match[1]);
                        if (!$skip) {
                            $attributes_array[] = "{$attribute_name}=\"{$thisval}\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attributes = preg_replace("%^[^\\s\"']+(\\s+|\$)%", '', $attributes);
                    }
                    break;
            }
            if ($working === 0) {
                // Not well formed; remove and try again.
                $attributes = preg_replace('/
                  ^
                  (
                  "[^"]*("|$)     # - a string that starts with a double quote, up until the next double quote or the end of the string
                  |               # or
                  \'[^\']*(\'|$)| # - a string that starts with a quote, up until the next quote or the end of the string
                  |               # or
                  \\S              # - a non-whitespace character
                  )*              # any number of the above three
                  \\s*             # any number of whitespaces
                  /x', '', $attributes);
                $mode = 0;
            }
        }
        // The attribute list ends with a valueless attribute like "selected".
        if ($mode === 1 && !$skip) {
            $attributes_array[] = $attribute_name;
        }
        return $attributes_array;
    }

    /**
     * Whether this element needs to be removed altogether.
     *
     * @param $html_tags
     *   The list of HTML tags.
     * @param $elem
     *   The name of the HTML element.
     *
     * @return bool
     *   TRUE if this element needs to be removed.
     */
    protected function needsRemoval($html_tags, $elem)
    {
        return !isset($html_tags[strtolower($elem)]);
    }

    /**
     * Processes an HTML tag.
     *
     * @param  string  $string
     *   The HTML tag to process.
     * @param  array  $html_tags
     *   An array where the keys are the allowed tags and the values are not
     *   used.
     * @return string
     *   If the element isn't allowed, an empty string. Otherwise, the cleaned up
     *   version of the HTML element.
     */
    protected function split($string, $html_tags)
    {
        if (substr($string, 0, 1) !== '<') {
            // We matched a lone ">" character.
            return '&gt;';
        } elseif (strlen($string) === 1) {
            // We matched a lone "<" character.
            return '&lt;';
        }
        if (!preg_match('%^<\\s*(/\\s*)?([a-zA-Z0-9\\-]+)\\s*([^>]*)>?|(<!--.*?-->)$%', $string, $matches)) {
            // Seriously malformed.
            return '';
        }
        $slash = trim($matches[1]);
        $elem = &$matches[2];
        $attrlist = &$matches[3];
        $comment = &$matches[4];
        if ($comment) {
            $elem = '!--';
        }
        // When in whitelist mode, an element is disallowed when not listed.
        if ($this->needsRemoval($html_tags, $elem)) {
            return '';
        }
        if ($comment) {
            return $comment;
        }
        if ($slash !== '') {
            return "</{$elem}>";
        }
        // Is there a closing XHTML slash at the end of the attributes?
        $attrlist = preg_replace('%(\\s?)/\\s*$%', '\\1', $attrlist, -1, $count);
        $xhtml_slash = $count ? ' /' : '';
        // Clean up attributes.
        $attr2 = implode(' ', $this->attributes($attrlist));
        $attr2 = preg_replace('/[<>]/', '', $attr2);
        $attr2 = strlen($attr2) ? ' '.$attr2 : '';
        return "<{$elem}{$attr2}{$xhtml_slash}>";
    }
}
