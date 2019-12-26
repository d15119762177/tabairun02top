{include file="common/header.php"}
   <!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">创建广告计划</h2>
                       
                        <form class="form-horizontal" action="{:url('doadd')}" method="post">
                          <div class="form-group">
                            <label class="col-md-2 control-label">广告主ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="{$advertiser_id}" type="text" readonly="">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-2 control-label">广告组</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="campaign_id">
                                 {volist name="data" id="vo"}
                                  <option value="{$vo.campaign_id}">{$vo.campaign_name}</option>
                                  {/volist}
                              </select>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">计划名称</label>
                            <div class="col-md-10">
                              <input id="example-email" name="name" class="form-control" placeholder="" type="text" required>
                            </div>
                          </div>

                            <div class="form-group">
                            <label class="col-sm-2 control-label">广告投放速度类型</label>
                            <div class="col-sm-10">
                              <select class="form-control dj" name="flow_control_mode"  id="" value="" >
                                <option selected value="FLOW_CONTROL_MODE_FAST">优先跑量（对应CPC的加速投放）</option>
                                <option  value="FLOW_CONTROL_MODE_SMOOTH">优先低成本（对应CPC的标准投放）</option>
                                <option  value="FLOW_CONTROL_MODE_BALANCE">均衡投放（新增字段）</option>
                               <!--  <option>2</option> -->
                              </select>
                            </div>
                          </div>  

                          <div class="form-group">
                            <label class="col-sm-2 control-label" >预算</label>
                            <div class="col-sm-10">
                             <select name="budget_mode" id="aab" value="" style="margin: 0px;padding: 0px;float: left;height: 34px;border-right: 0px;" onchange="sel()">
                            <option id="ys" value="BUDGET_MODE_INFINITE" selected>不限</option>
                            <option id="ys" value="BUDGET_MODE_DAY" selected>日预算</option>
                            <option id="zys" value="BUDGET_MODE_TOTAL">总预算</option>
                          </select>    
                          <input type="text" name="budget" required  placeholder=" 请输入预算，不少于100元，不超过9999999.99元
" autocomplete="off" class="y_cont" style="margin:0px;padding: 0px;float: left;height: 34px;width: 50%;">     
                            </div>
                          </div>
                          <script>
                            function sel(){
                              //alert($("#aab").val());
                               if($("#aab").val()=='BUDGET_MODE_TOTAL'){
                             // alert('aa')
                              $('.y_cont').attr('placeholder',' 请输入预算，不少于投放天数*100元，不超过9999999.99元');
                              $('.y_cont').attr('readonly',false);
                             }
                            if($("#aab").val()=='BUDGET_MODE_DAY'){
                              $('.y_cont').attr('placeholder',' 请输入预算，不少于100元，不超过9999999.99元');
                              $('.y_cont').attr('readonly',false);
                               }
                            if($("#aab").val()=='BUDGET_MODE_INFINITE'){
                              $('.y_cont').attr('readonly',true);
                              $('.y_cont').attr('placeholder','');
                               }
                            }


                            //removeAttr() 方法从被选元素中移除属性。
                          </script>

                          <div class="form-group">
                            <label class="col-md-2 control-label">投放时间</label>
                            <div class="col-md-10">
                               <input type="text" placeholder=" YY/mm/dd/ H:i:s" style="width: 35%;height:34px;margin-right: 0px;padding-right: 0px;" name="start_time" class="layui-input1" id="test1" required> &nbsp;&nbsp;-&nbsp;&nbsp;
                                <input type="text" placeholder="  YY/mm/dd/ H:i:s" style="width: 35%;height:34px;" name="end_time" class="layui-input1" id="test2" required>
                                 <input type="hidden"  style="width: 35%;height:34px;" name="schedule_type" class="layui-input1" value="SCHEDULE_START_END">

                            </div>
                          </div>

                          <!-- 时间插件js代码 start -->
                          <script> 
                            layui.use('laydate', function(){
                              var laydate = layui.laydate;
                              
                              //执行一个laydate实例
                              laydate.render({
                                elem: '#test1' //指定元素
                                ,type: 'datetime'
                              });
                            });
                             layui.use('laydate', function(){
                              var laydate = layui.laydate;
                              
                              //执行一个laydate实例
                              laydate.render({
                                elem: '#test2' //指定元素
                                ,type: 'datetime'
                              });
                            });
                          </script>
                           <!-- 时间插件js代码 end -->
                           


                            <div class="form-group">
                            <label class="col-sm-2 control-label">付费方式</label>
                            <div class="col-sm-10">
                              <select class="form-control dj" name="pricing"  id="path" value="" onchange="pa()">
                                <option selected value="PRICING_OCPM">按展示付费(OCPM)</option>
                                <option  value="PRICING_CPV">按转化付费(CPA)</option>
                               <!--  <option>2</option> -->
                              </select>
                            </div>
                          </div>  
                          
                          
                          <div class="form-group" id="zh" style="display: none;">
                            <label class="col-md-2 control-label">点击出价</label>
                            <div class="col-md-10">
                              <input class="form-control" name="bid" placeholder="请输入点击出价，不少于0.2元，不超过100元" type="text" style="width:40%;">
                            </div>
                          </div>

                          <div class="form-group" >
                            <label class="col-md-2 control-label">转化出价</label>
                            <div class="col-md-10">
                              <input class="form-control" name="cpa_bid" placeholder="请输入点击出价，不少于0.1元，不超过10000元" type="text" style="width:40%;" required>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-2 control-label" >投放范围</label>
                            <div class="col-md-10">
                              <input class="form-control" name="delivery_range1" placeholder="默认" type="text" style="width:6%;" readonly="" value="默认">
                              <input type="hidden" name="delivery_range" value="DEFAULT">
                            </div>
                          </div>


                          
                            <div class="form-group">
                            <label class="col-md-2 control-label">投放目标</label>
                            <div class="col-md-10">
                              <input style="height: 14px;width: 14px;line-height: 34px;" type="radio" name="target" value="zhl" title="" checked> 转化量&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input style="height: 14px;width: 14px;line-height: 34px;" type="radio" name="target" value="djl" title="" disabled=""> 点击量&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input style="height: 14px;width: 14px;line-height: 34px;" type="radio" name="target" value="zsl" title="" disabled=""> 展示量
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-2 control-label">落地页链接</label>
                            <div class="col-md-10">
                              <input class="form-control" id="url" name="external_url" value="" type="text" onchange="geturl()" required>
                            </div>
                          </div>

                          <div class="form-group" style="display: none;" id="mb">
                            <label class="col-sm-2 control-label">转化目标</label>
                            <div class="col-sm-10">
                              <select class="form-control dj" name="convert_id"  id="zhmb" value="">
                                    
                              </select>
                            </div>
                          </div>  
                        
                        <!--   <div class="form-group">
                            <label class="col-md-2 control-label">设置文章</label>
                            <div class="col-md-10">
                              <textarea class="form-control" rows="5" name="title"></textarea>
                            </div>
                          </div> -->


                          <div class="form-group m-b-0" id="an" >
                           <input type="submit" class="layui-btn layui-btn-danger" onclick="history.go(-1)" value="返回" style="float: right;margin-right: 12px;background-color:#aaa">
                            <div class="col-sm-offset-3 col-sm-9" style="margin-left:16.5%;">
                              <input type="submit" class="btn btn-primary" name="goon" value="继续添加">
                              <input type="submit" class="btn btn-primary" name="next" value="下一步">
                            </div>
                        </div>
                          
                        </form>
                   </div>
                  </div>
              </div>

              <script type="text/javascript">
                function pa(){
                 // alert($('#path').val());
                  if($('#path').val() == 'PRICING_OCPM'){
                    $('#zh').attr('disabled',true);
                  $('#zh').hide();
                }
                  if($('#path').val() == 'PRICING_CPV'){
                  $('#zh').show();
                  $('#zh').attr('disabled',false);
                }
                }
             
                function geturl(){
                  var geturl = $('#url').val();
                  //alert(url);
                  //console.log(geturl);
                 // url = '1';
                
                $.post("{:url('Plan/ajax_convert_id')}", {geturl: geturl},
                        function(data){

                          if(data.msg=="数据为空或数据出错"){
                            alert('落地页链接错误');
                            $('#mb').hide();
                          }
                          
                       // alert(data); // John
                        console.log(data); //  2pm
                        for(i = 0; i < data.length; i++) {
                          var id = data[i]['convert_id'];
                        //  alert(id)
                          var name = data[i]['name'];
                                 
                                  $('#zhmb').append("<option value="+id+">"+name+"</option>");
                                  $('#mb').show();
                          } 

                        }, "json");
                }

              </script>
             <!--End row-->
{include file="common/foot.php"}