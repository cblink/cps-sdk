<?php
namespace Cblink\CpsSdk\Client;

use Cblink\CpsSdk\BaseApiClient;
use GuzzleHttp\Client;

/**
 * @link https://union.meituan.com/single/helpCenter?id=42
 */
class MeituanApiClient extends BaseApiClient
{
    /**
     * 自助取链接口
     *
     * @param string $actId 活动id
     * @param string $sid  推广位id
     * @param int $linkType 链接类型 H5(1, "h5链接"),DEEPLINK(2, "Deeplink-美团APP"),MID(3, "中间页唤起-美团APP"),WECHAT(4, "微信小程序-美团小程序"),GROUP_WORD(5, "团口令"),YOUXUAN_DEEPLINK(6, "Deeplink-优选APP"),YOUXUAN_MIDDLEPAGE(7, "中间页唤起-优选APP"),YOUXUAN_WXAPP(8, "微信小程序-优选小程序"),PINHAOFAN_WXAPP(9, "微信小程序-拼好饭小程序"),
     * @param array $params
     *
     * @return array
     */
    public function generateLink($actId, $sid, $linkType, array $params = [])
    {
        return $this->request('generateLink', array_merge(
            [
                'actId' => $actId,
                'sid' => $sid,
                'linkType' => $linkType,
            ],
            $params
        ));
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
            'appkey' => $this->getAppKey(),
        ];
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
        return md5($stringToBeSigned);
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

        $response = $client->get($this->getUri() .'/' . $method, ['query' => $this->getParamsWithSign($method, $params)]);
        $response = $response->getBody()->getContents();

        return json_decode($response, true);
    }
}