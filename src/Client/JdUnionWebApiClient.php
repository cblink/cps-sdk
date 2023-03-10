<?php
namespace Cblink\CpsSdk\Client;

use Cblink\CpsSdk\BaseApiClient;
use GuzzleHttp\Client;

class JdUnionWebApiClient extends BaseApiClient
{
    /*******************转链相关*********************/
    /**
     * web转链
     *
     * @param   string    $promotionTypeId 媒体id
     * @param   string    $promotionId    推广位id
     * @param array $params = [
     *          'wareUrl'  需要转链的商品链接,
     * ]
     *
     * @return array
     */
    public function getShortLink($promotionTypeId, $promotionId, array $params = [])
    {
        //获取链接最后的路径
        $path = parse_url($params['wareUrl'], PHP_URL_PATH);
        //获取路径中的商品id
        preg_match('/\d+/', $path, $matches);
        $materialId = $matches[0];

        return $this->request('unionPromoteLinkService',[
            'funName' => 'getCode',
            'param' => array_merge([
                'isPinGou' => 0,
                'materialId' => $materialId,
                'materialType' => 1,
                'promotionId' => $promotionId,
                'promotionType' => 3,
                'promotionTypeId' => $promotionTypeId,
                'receiveType' => 'cps',
            ], $params),
        ]);
    }

    /**
     * 查询商品
     *
     * @param $keyword 商品名或商品id
     * @param $params
     *
     * @return array
     */
    public function searchGoods($keyword, $params = [])
    {
        return $this->request('unionSearch',[
            'funName' => 'search',
            'param' => array_merge([
                'keyWord' => $keyword,
            ], $params),
        ]);
    }

    /**
     * 查询订单列表
     *
     * @param $startTime 开始时间 Y-m-d H:i:s
     * @param $endTime  结束时间 Y-m-d H:i:s
     * @param $spId 推广位id
     * @param $pageNo 页码
     * @param $pageSize 每页条数
     *
     * @return array
     */
    public function getOrderList($startTime, $endTime, $spId = '', $pageNo = 1, $pageSize = 20)
    {
        return $this->request('listOrderSku',[
            'funName' => 'listOrderSku',
            'page' => [
                'pageNo' => $pageNo,
                'pageSize' => $pageSize,
            ],
            'param' => array_merge([
                'unionRole' => 1,
                'endTime' => $endTime,
                'orderStatus' => 0,
                'unionTags' => ["0"],
                'startTime' => $startTime,
                'optType' => 1,
                'spId' => $spId,
            ]),
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
            'loginType' => 3,
            'appid' => 'unionpc',
            'functionId' => $method,
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
        $urlParams = http_build_query($this->getPublicParams($method) + ['body' => json_encode($params)]);

        $response = $client->get($this->getUri() . '?' . $urlParams, [
            'headers' => [
                'origin' => 'https://union.jd.com',
                'Cookie' => $this->getCookies(),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}