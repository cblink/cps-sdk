<?php
namespace Cblink\CpsSdk\Client;

use Cblink\CpsSdk\BaseApiClient;
use GuzzleHttp\Client;

class TbkWebApiClient extends BaseApiClient
{
    /*******************转链相关*********************/
    /**
     * web转链
     *
     * @param string $promotionId 推广位id
     * @param string $url 需要转链的商品链接
     *
     * @return array
     */
    public function getShortLink(string $promotionId, string $url)
    {
        return $this->request($promotionId,[
            'url' => $url,
        ]);
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
            'floorId' => '61446',
            'refpid' => $method,
        ];
    }

    /**
     * cookies需要保留thor参数
     * @return mixed
     */
    public function getCookies()
    {
        return $this->config['cookies'];
    }

    /**
     * @param $method
     * @param $params
     *
     * @return array
     */
    public function request($method, $params = [])
    {
        $client = new Client();

        //转换为url参数
        $urlParams = http_build_query($this->getPublicParams($method) + ['variableMap' => json_encode($params)]);

        $response = $client->get($this->getUri() . '?' . $urlParams, [
            'headers' => [
                'Cookie' => $this->getCookies(),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}