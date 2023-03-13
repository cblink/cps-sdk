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
        return $this->request('xt.entry.json',[
            'refpid' => $promotionId,
            'variableMap' => json_encode([
                'url' => $url,
            ])
        ]);
    }

    /**
     * 查询订单列表
     *
     * @param string $startTime 开始时间 Y-m-d
     * @param string $endTime   结束时间 Y-m-d
     * @param        $queryType 1:按照创建时间查询，2:按照订单付款时间查询。3:按照订单结算时间查询
     * @param        $pageNo    页码
     * @param        $pageSize  每页条数
     *
     * @return array
     */
    public function getOrderList(string $startTime, string $endTime, $queryType = 1, $pageNo = 1, $pageSize = 20)
    {
        return $this->request('report.getTbkOrderDetails.json', [
            'startTime' => $startTime,
            'endTime' => $endTime,
            'queryType' => $queryType,
            'jumpType' => 0,
            'pageNo' => $pageNo,
            'pageSize' => $pageSize,
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
        $urlParams = http_build_query($this->getPublicParams($method) + $params);

        $response = $client->get($this->getUri() . $method . '?' . $urlParams, [
            'headers' => [
                'Cookie' => $this->getCookies(),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}