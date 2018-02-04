<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        input {margin-bottom: 10px;}
    </style>
</head>
<body style="padding: 40px;">
    <div style="background-color: #f8f8f8;">
        <form action="show.php" method="post">
            红包总额：<input type="number" name="total_mount" value="<?php echo isset($formattingData) ? $formattingData->totalAmount : '';?>" placeholder="请输入"><br/>
            红包个数：<input type="number" name="quantity" value="<?php echo isset($formattingData) ? $formattingData->quantity : '';?>" placeholder="请输入"><br/>
            <input type="submit" value="计算">
        </form>
    </div>
</body>
</html>
