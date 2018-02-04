<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lom <shalinglom@gmail.com>
// +----------------------------------------------------------------------
// | CreateTime: 2018/2/4 4:10
// +----------------------------------------------------------------------

$totalAmount = isset($_POST['total_mount']) ? $_POST['total_mount'] : 0;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;

if (!$totalAmount || !$quantity || $quantity < 1 || $quantity * 0.01 > $totalAmount) {
    die('<h3>数据输入错误！红包个数至少为1且红包总金额数不小于 红包个数 * 0.01</h3>');
} else {
    require ('CreateReward.php');
    require ('FormattingData.php');
    //生成红包
    $reward = new CreateReward($totalAmount, $quantity);
    //红包数据看板
    $formattingData = new FormattingData($reward->randomMoney(), $totalAmount, $quantity);
}
require ('index.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        table {
            border:1px solid black;
            width:80%;
            height:300px;
        }
        .left {
            width:150px;
            border: 1px solid #f4f4f4;
            text-align: center;
        }
        .right {
            width:auto;
            border: 1px solid #f4f4f4;
        }
        hr {
            float: left;
            height:3px;
            border:none;
            border-top:3px solid #FC2;
        }

    </style>
</head>

<body style="padding: 40px;">

    <p>总金额： <?php echo $formattingData->total;?></p>
    <p>最小额：<?php echo $formattingData->min;?></p>
    <p>最大额：<?php echo $formattingData->max;?></p>
    <table style="height:<?php echo count($formattingData->percentTotal) * 50;?>px;">
        <tr>
            <td class="left">占总额的百分比</td>
            <td>红包个数</td>
        </tr>
        <?php foreach ($formattingData->percentTotal as $k => $v){ ?>
            <tr>
                <td class="left"><?php $kk = $k ? $k : '>0'; echo $kk . '~' . ($k + 1) . '%';?></td>
                <td class="right">
                    <div class="show_total" >
                        <hr style='width:<?php echo $v / $formattingData->quantity * 80;?>%;'>
                        <span><?php echo $v;?></span>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br/>
    <table>
        <tr>
            <td class="left">红包顺序</td>
            <td>红包金额</td>
        </tr>
        <?php foreach ($formattingData->rewardMoney as $k => $v){ ?>
            <?php if ($v !== 0) {?>
                <tr>
                    <td class="left"><?php echo ($k + 1);?></td>
                    <td class="right">
                        <div class="show_total" >
                            <hr style='width:<?php echo $v / $formattingData->max * 90;?>%;'>
                            <span><?php echo $v;?></span>
                        </div>
                    </td>
                </tr>
            <?php }?>
        <?php } ?>
    </table>
    <br/>
    <p>正态分布</p>
    <table>
        <tr>
            <td></td>
            <td>红包金额</td>
        </tr>
        <?php foreach ($formattingData->Gaussian as $key => $val){ ?>
            <tr>
                <td class='left'><?php echo $key +1;?></td>
                <td class="right">
                    <hr style='width:<?php echo $val / $formattingData->max * 90;?>%;'>
                    <span><?php echo $val;?></span>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
