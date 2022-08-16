<?php

namespace codeseasy\projecthandler;

class ProjectHandler
{
    function init($domain)
    {
        if ($domain = $this->get_domain($domain)) {
            return $this->getData($domain);
        } else {
            header('location: https://www.codeseasy.com');
        }
        return false;
    }

    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = $pieces['host'] ?? $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }

    function getData($domain)
    {
        $url = "https://verify.codeseasy.com/domain/" . $domain;
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_USERAGENT => "spider",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => true
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $err_msg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['err_msg'] = $err_msg;
        $header['content'] = $content;
        return $content;
    }
}