<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from DebtLists.htm on 2017-03-08 19:13:48
*/
?><?php include template('Header'); ?><div class="collection">
    <div class="wrap">
        <div class="filt-parm">
            <div class="line">
                <span>催收方式 :</span>
                <span class="sel">全部</span>
                <span>选择律师的债权</span>
                <span>选择催收团队的债权</span>
            </div>
            <div class="line">
                <span>催收地区 :</span>
                <span class="sel">全部</span>
                <span>北京市</span>
                <span>上海市</span>
                <span>深圳市</span>
                <span>广州市</span>
                <span>厦门市</span>
                <span>其他城市<img src="/Uploads/Debt/imgs/tri_arrow_down.png" alt=""></span>
            </div>
            <div class="line">
                <span>催收金额 :</span>
                <span class="sel">全部</span>
                <span>3万以下</span>
                <span>3万到10万</span>
                <span>10万到50万</span>
                <span>50万到100万</span>
                <span>100万以上</span>
            </div>
            <div class="line">
                <span>逾期时间 :</span>
                <span class="sel">全部</span>
                <span>0-60天</span>
                <span>61-180天</span>
                <span>181-365天</span>
                <span>366-1095天</span>
                <span>1096天以上</span>
            </div>
            <div class="search">
                <span>债务搜索 :</span>
                <input type="text" name="" placeholder="请输入姓名或身份证号">
                <button type="button" name="search">
                    搜索
                </button>
                <div class="pub-wrap">
                    <img src="/Uploads/Debt/imgs/edit.png" alt="">
                    <button type="button" name="pub">
                        发布债务
                    </button>
                </div>
            </div>
        </div>
        <div class="table">
            <div class="t">催收列表分类 :</div>
            <table>
                <thead>
                <tr>
                    <th>债务编号</th>
                    <th>债务人名称</th>
                    <th>债务地区</th>
                    <th>债务金额</th>
                    <th>逾期时间</th>
                    <th>发布时间</th>
                    <th>当前状态</th>
                    <th>查看债务</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>L201702270000</td>
                    <td>张三</td>
                    <td>福建省-厦门市-思明区</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-1">未接单</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张4</td>
                    <td>福建省-厦门市-未知</td>
                    <td class="m-c">￥10000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-2">催收中</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张5</td>
                    <td>福建省-厦门市-思明区</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-3">已曝光</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张6</td>
                    <td>福建省-厦门市-思明区</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-3">已完成</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张7</td>
                    <td>福建省-厦门市-思明区</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-3">已完成</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张8</td>
                    <td>福建省-厦门市-未知</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-3">已完成</td>
                    <td class="det">查看详情>></td>
                </tr>
                <tr>
                    <td>L201702270000</td>
                    <td>张9</td>
                    <td>福建省-厦门市-思明区</td>
                    <td class="m-c">￥100000000.00</td>
                    <td>50天</td>
                    <td>2017-02-25</td>
                    <td class="sta-3">已完成</td>
                    <td class="det">查看详情>></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            <div class="pagination fl-r">
                <div class="b">首页</div>
                <div class="b"><</div>
                <div class="b sel">1</div>
                <div class="b">2</div>
                <div class="b">3</div>
                <div class="b">4</div>
                <div class="b">5</div>
                <div class="b">></div>
            </div>
        </div>
    </div>
</div><?php include template('Footer'); ?>