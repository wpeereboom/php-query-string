<?php
namespace PhpQueryString;

class UrlParameterReplacer
{

    /**
     * @var string
     */
    protected $content;

    /**
     * @var UrlParameter[]
     */
    protected $params;

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $domain
     */
    public function setParam($name, $value, $domain)
    {
        $param = new UrlParameter($name, $value, $domain);
        $this->params[] = $param;
    }

    public function getReplacedContent()
    {
        foreach ($this->params as $param) {
            $parameterAddOn = $param->getName() . '=' . urlencode($param->getValue());
            $domain = $param->getDomain();
            $this->content = preg_replace_callback(
                '/(<a[^>]href=(?:"|\')*)([^\'"]*)((?:"|\')[^>]*>[^>]*<\/a>)/',
                function ($m) use ($parameterAddOn, $domain) {
                    $link = rtrim($m[2], "? \t\r\n\x0B\0");
                    if(!strpos($link, $domain)) {
                        return $m[1] . $link . $m[3];
                    }
                    if (strpos($link, '?') === false) {
                        $link .= '?';
                    } else {
                        $link .= '&';
                    }
                    $link .= $parameterAddOn;
                    return $m[1] . $link . $m[3];
                },
                $this->content);
        }

        return $this->content;
    }
}
