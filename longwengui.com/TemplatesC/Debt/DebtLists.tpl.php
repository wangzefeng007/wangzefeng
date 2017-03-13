<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from DebtLists.htm on 2017-03-10 15:01:16
*/
?><?php include template('Header'); ?><link rel="stylesheet" href="<?php echo CssURL; ?>/debt/collection.css">
<div class="collection">
    <div class="wrap">
        <div class="filt-parm">
            <div class="line">
                <span>催收方式 :</span>
                <span class="sel" id="way_all">全部</span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="way" value="1">
                </div>
                选择律师的债权
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="way" value="2">
                </div>
                选择催收团队的债权
              </span>
            </div>
            <div class="line">
                <span>催收地区 :</span>
                <span class="sel" id="area_all">全部</span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="area" value="1001">
                </div>
                北京市
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="area" value="1002">
                </div>
                上海市
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="area" value="1003">
                </div>
                深圳市
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="area" value="1004">
                </div>
                广州市
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="area" value="1005">
                </div>
                厦门市
              </span>
                <!-- <span>其他城市<img src="/Uploads/Debt/imgs/tri_arrow_down.png" alt=""></span> -->
            </div>
            <div class="line">
                <span>催收金额 :</span>
                <span class="sel" id="money_all">全部</span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="money" value="1">
                </div>
                3万以下
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="money" value="2">
                </div>
                3万到10万
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="money" value="3">
                </div>
                10万到50万
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="money" value="4">
                </div>
                50万到100万
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="money" value="5">
                </div>
                100万以上
              </span>
            </div>
            <div class="line">
                <span>逾期时间 :</span>
                <span class="sel" id="day_all">全部</span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="day" value="1">
                </div>
                0-60天
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="day" value="2">
                </div>
                61-180天
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="day" value="3">
                </div>
                181-365天
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="day" value="4">
                </div>
                366-1095天
              </span>
                <span>
                <div class="m-checkbox">
                  <input type="checkbox" name="day" value="5">
                </div>
                1096天以上
              </span>
            </div>
            <div class="search">
                <span>债务搜索 :</span>
                <input type="text" name="" id="keyword" placeholder="请输入姓名或身份证号">
                <button type="button" id="btn_search" name="search">
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
        <div class="table" id="collection_info">
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
                <!-- <tr>
                  <td>L201702270000</td>
                  <td>张三</td>
                  <td>福建省-厦门市-思明区</td>
                  <td class="m-c">￥100000000.00</td>
                  <td>50天</td>
                  <td>2017-02-25</td>
                  <td class="sta-1">未接单</td>
                  <td class="det">查看详情>></td>
                </tr> -->
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            <div class="pagination fl-r" id="collection_page_pagination">
                <!-- <div class="b" data-id="first">首页</div>
                <div class="b" data-id="pre"><</div>
                <div class="b sel" data-id="1">1</div>
                <div class="b" data-id="2">2</div>
                <div class="b" data-id="3">3</div>
                <div class="b" data-id="4">4</div>
                <div class="b" data-id="5">5</div>
                <div class="b" data-id="next">></div> -->
            </div>
        </div>
    </div>
</div><?php include template('Footer'); ?><script src='<?php echo JsURL; ?>/debt/debtlists.js'></script>