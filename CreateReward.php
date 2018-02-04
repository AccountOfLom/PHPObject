<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lom <shalinglom@gmail.com>
// +----------------------------------------------------------------------
// | CreateTime: 2018/2/4 3:25
// +----------------------------------------------------------------------

/**
 * 拼手气红包算法
 * 参考文章：
 * 微信红包的随机算法是怎样实现的？ https://www.zhihu.com/question/22625187/answer/85530416
 * 算法规则：
 * 红包依次分配
 * 每一个红包的额度为（红包总额 - 已分配额）/ 剩余应发数 * 1~20%
 * 最后一个红包为（总金额 - 已分配所有金额）
 * 每个红包至少0.01元
 */
class CreateReward
{
    public $totalAmount = 0;        //红包总金额
    public $quantity = 0;           //红包个数
    public $rewardMoney = [];       //红包集

    public function __construct($totalAmount, $quantity)
    {
        $this->totalAmount = $totalAmount;
        $this->quantity = $quantity;
    }

    /**
     *生成红包
     * @return array  rewardMoney     红包数据集
     */
    public function randomMoney()
    {
        $rewardMoney = [];
        if ($this->quantity / 100 == $this->totalAmount) {
            for ($i = 0; $i <= $this->quantity - 1; $i ++) {
                $rewardMoney[$i] = 0.01;
            }
        } else {
            $rewardMoney = [];                 //接收分配好的红包
            $constant = $this->totalAmount;          //红包总额  （元）
            $surplus = $this->totalAmount * 100;     //剩余金额  （分）
            $paid = 0;                         //已分配出去的金额

            for ($i = 0; $i <= $this->quantity - 1; $i ++) {
                //随机当前份额： 1~20%
                $range = rand(1, 200);
                if ($i == ($this->quantity - 1)) {
                    //最后一个红包，总金额 - 已分配金额
                    //float 有时数值算不准，会多出 0.0000000000001 ，直接省略
                    $tempData = (float) sprintf("%.2f", ($constant - $paid));
                    $rewardMoney[$i] = $tempData && $tempData > 0.01 ? $tempData : 0.01;
                    break;
                }
                //当前分配金额  = （当前剩余金额 / 当前未分配红包数）* 随机百分比（1~20%），
                //单位（元）
                $tempData = (float) (sprintf("%.2f", floor($surplus / ($this->quantity - $i) * $range / 100)) / 100);
                $rewardMoney[$i] = $tempData && $tempData > 0.01 ? $tempData : 0.01;
                $paid += $rewardMoney[$i];
                //当前剩余金额 单位 （分）
                $surplus -= $rewardMoney[$i] * 100;
            }
            //打乱元素排序
            //        shuffle($rewardMoney);
        }
        $this->rewardMoney = $rewardMoney;
        return true;
    }
}
