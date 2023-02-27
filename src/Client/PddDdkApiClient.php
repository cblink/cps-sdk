<?php
namespace Cblink\CpsSdk\Client;

use Cblink\CpsSdk\BaseApiClient;

class PddDdkApiClient extends BaseApiClient
{
    /*******************推广位备案相关*********************/
    /**
     * 查询已经生成的推广位信息
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.pid.query
     *
     * @param array $params
     *
     * @return $this
     */
    public function goodsPidQuery(array $params = [])
    {
        return $this->request('pdd.ddk.goods.pid.query', $params);
    }

    /**
     * 批量绑定推广位的媒体id
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.pid.mediaid.bind
     *
     * @param       $mediaId
     * @param array $pidList
     *
     * @return mixed|null
     */
    public function pidMediaIdBind($mediaId, array $pidList)
    {
        return $this->request('pdd.ddk.pid.mediaid.bind', [
            'media_id' => $mediaId,
            'pid_list' => $pidList,
        ]);
    }

    /**
     * 创建多多进宝推广位
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.pid.generate
     *
     * @param $number
     * @param array $params
     *
     * @return mixed
     */
    public function goodsPidGenerate($number, array $params = [])
    {
        return $this->request('pdd.ddk.goods.pid.generate', array_merge([
            'number' => $number,
        ], $params));
    }

    /**
     * 查询是否绑定备案
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.member.authority.query
     *
     * @param $pid
     * @param array $params
     *
     * @return $this
     */
    public function memberAuthorityQuery($pid, array $params = [])
    {
        return $this->request('pdd.ddk.member.authority.query', array_merge([
            'pid' => $pid,
        ], $params));
    }

    /*******************商品相关*********************/
    /**
     * 多多进宝商品查询
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.search
     *
     * @param array $params
     *
     * @return $this
     */
    public function goodsSearch(array $params = [])
    {
        return $this->request('pdd.ddk.goods.search', $params);
    }

    /**
     * 多多进宝商品推荐API
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.recommend.get
     *
     * @param array $params
     *
     * @return $this
     */
    public function goodsRecommendGet(array $params = [])
    {
        return $this->request('pdd.ddk.goods.recommend.get', $params);
    }

    /**
     * 多多进宝商品详情查询
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.detail
     *
     * @param array $params
     *
     * @return $this
     */
    public function goodsDetail(array $params = [])
    {
        return $this->request('pdd.ddk.goods.detail', $params);
    }

    /*******************转链相关*********************/
    /**
     * 多多进宝转链接口
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.zs.unit.url.gen
     *
     * @param $pid
     * @param $sourceUrl
     * @param array $params
     *
     * @return mixed
     */
    public function goodsZsUnitUrlGen($pid, $sourceUrl, array $params = [])
    {
        return $this->request('pdd.ddk.goods.zs.unit.url.gen', array_merge([
            'pid' => $pid,
            'source_url' => $sourceUrl,
        ], $params));
    }

    /**
     * 多多进宝推广链接生成
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.goods.promotion.url.generate
     *
     * @param       $pid
     * @param array $params
     *
     * @return mixed|null
     */
    public function goodsPromotionUrlGenerate($pid, array $params = [])
    {
        return $this->request('pdd.ddk.goods.promotion.url.generate', array_merge([
            'p_id' => $pid,
        ], $params));
    }

    /**
     * 生成营销工具推广链接
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.rp.prom.url.generate
     *
     * @param       $pidList
     * @param array $params
     *
     * @return mixed|null
     */
    public function rpPromUrlGenerate($pidList, array $params = [])
    {
        return $this->request('pdd.ddk.rp.prom.url.generate', array_merge([
            'p_id_list' => $pidList,
        ], $params));
    }

    /**
     * 生成商城-频道推广链接
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.cms.prom.url.generate
     *
     * @param       $pidList
     * @param array $params
     *
     * @return mixed|null
     */
    public function cmsPromUrlGenerate($pidList, array $params = [])
    {
        return $this->request('pdd.ddk.cms.prom.url.generate', array_merge([
            'p_id_list' => $pidList,
        ], $params));
    }

    /*******************数据相关*********************/
    /**
     * 最后更新时间段增量同步推广订单信息
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.order.list.increment.get
     *
     * @param       $startUpdateTime
     * @param       $endUpdateTime
     * @param array $params
     *
     * @return mixed|null
     */
    public function orderListIncrementGet($startUpdateTime, $endUpdateTime, array $params = [])
    {
        return $this->request('pdd.ddk.order.list.increment.get', array_merge([
            'start_update_time' => $startUpdateTime,
            'end_update_time' => $endUpdateTime,
        ], $params));
    }

    /**
     * 用时间段查询推广订单接口
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.order.list.range.get
     *
     * @param       $startTime
     * @param       $endTime
     * @param array $params
     *
     * @return mixed|null
     */
    public function orderListRangeGet($startTime, $endTime, array $params = [])
    {
        return $this->request('pdd.ddk.order.list.range.get', array_merge([
            'start_time' => $startTime,
            'end_time' => $endTime,
        ], $params));
    }

    /**
     * 查询订单详情
     *
     * @link https://open.pinduoduo.com/application/document/api?id=pdd.ddk.order.detail.get
     *
     * @param       $orderSn
     * @param array $params
     *
     * @return mixed|null
     */
    public function orderDetailGet($orderSn, array $params = [])
    {
        return $this->request('pdd.ddk.order.detail.get', array_merge([
            'order_sn' => $orderSn,
        ], $params));
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
            'client_id' => $this->getAppKey(),
            'timestamp' => time(),
            'type' => $method,
        ];
    }

    public function request($method, $params = [])
    {
        $response = parent::request($method, $params);

        return array_shift($response);
    }
}