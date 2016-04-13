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

    protected $domain;

    public function setContent($content, $domain)
    {
        $this->content = $content;
        $this->domain = $domain;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $param = new UrlParameter($name, $value);
        $this->params[] = $param;
    }

    public function getReplacedContent()
    {
        $parameterAddOn = [];

        foreach ($this->params as $param) {
            $parameterAddOn[] = $param->getName() . '=' . urlencode($param->getValue());
        }

        $reg_exUrl = "/([\"|\']http[s]?:\/\/?" . $this->domain . "\S*[\"|\'])/";
        if (preg_match_all($reg_exUrl, $this->content, $urls)) {
            foreach($urls[0] as $url) {
                $newUrl = str_replace('\'', '', $url);
                $newUrl = str_replace('"', '', $newUrl);

                $newUrl .= (strpos($newUrl, '?')) ? '&' : '?';
                $newUrl .= implode('&', $parameterAddOn);

                $this->content = str_replace($url, '"' . $newUrl . '"', $this->content);
            }
        }

        return $this->content;
    }
}
