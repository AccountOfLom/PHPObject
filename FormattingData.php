<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 黎小龙 <shalinglom@gmail.com>
// +----------------------------------------------------------------------
// | CreateTime: 2018/2/4 3:41
// +----------------------------------------------------------------------

/*
 * 红包数据看板
 */
class FormattingData
{
    public $rewardMoney = [];         //红包数据集
    public $totalAmount = 0;          //红包总额
    public $quantity = 0;             //红包总数
    public $Gaussian = [];            //正态分布数据
    public $percentTotal = [];        //红包额占比统计数据
    public $max = 0;                  //最大红包金额
    public $min = 0;                  //最小红包金额
    public $total = 0;                //校验分配后红包总金额

    public function __construct($rewardMoney, $totalAmount, $quantity)
    {
        $this->rewardMoney = $rewardMoney;
        $this->totalAmount = $totalAmount;
        $this->quantity = $quantity;
        $this->formattingAction();
    }

    /**
     * 格式化红包数据
     * 属性赋值
     * @return bool
     */
    public function formattingAction()
    {
        //统计占总额各百分比段的红包数
        foreach ($this->rewardMoney as $k => $v) {
            $percent = (int) floor($v / $this->totalAmount * 100);
            if (array_key_exists($percent, $this->percentTotal)) {
                $this->percentTotal[$percent] += 1;
            } else {
                $this->percentTotal[$percent] = 1;
            }
        }
        ksort($this->percentTotal);

        $Gaussian = $this->rewardMoney;
        rsort($Gaussian);
        $this->min = $Gaussian[count($Gaussian) - 1];
        $this->max = $Gaussian[0];

        foreach ($this->rewardMoney as $v) {
            $this->total += $v;
        }

        //正态分布
        foreach($Gaussian as $k => $value)
        {
            $t = $k % 2;
            if (!$t) {
                $this->Gaussian[] = $value;
            } else {
                array_unshift($this->Gaussian, $value);
            }
        }
        return true;
    }
}
