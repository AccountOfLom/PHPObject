# 拼手气红包算法（以微信红包为蓝本）

## 参考文章：
- 微信红包的随机算法是怎样实现的？ https://www.zhihu.com/question/22625187/answer/85530416
 
## 算法规则：
- 红包依次分配
- 每一个红包的额度为（红包总额 - 已分配额）/ 剩余应发数 * 1~20%
- 最后一个红包为（总金额 - 已分配所有金额）
- 每个红包至少0.01元
