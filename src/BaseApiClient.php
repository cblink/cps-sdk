<?php
namespace Cblink\CpsSdk;

use GuzzleHttp\Client;

class BaseApiClient
{
    public $config;

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getUri()
    {
        return $this->config['uri'];
    }

    public function getAppSecret()
    {
        return $this->config['app_secret'];
    }

    public function getAppKey()
    {
        return $this->config['app_key'];
    }

    /**
     * 生成sign
     *
     * @param $params
     *
     * @return string
     */
    protected function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = $this->getAppSecret();
        foreach ($params as $k => $v)
        {
            if("@" != substr($v, 0, 1))
            {
                $stringToBeSigned .= "$k$v";
            }
        }

        $stringToBeSigned .= $this->getAppSecret();
        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * 获取公共参数
     *
     * @param $method
     *
     * @return array
     */
    public function getPublicParams($method)
    {
        return [
            'app_key' => $this->getAppKey(),
            'timestamp' => time(),
            'method' => $method,
        ];
    }

    /**
     * 获取加签的参数
     *
     * @param $method
     * @param $params
     *
     * @return array
     */
    public function getParamsWithSign($method, $params = [])
    {
        $params = array_merge($this->getPublicParams($method), $params);

        $params['sign'] = $this->generateSign($params);

        return $params;
    }

    public function request($method, $params = [])
    {
        $client = new Client();

        $response = $client->get($this->getUri(), ['query' => $this->getParamsWithSign($method, $params)]);
        $response = $response->getBody()->getContents();

        return json_decode($response, true);
    }
}