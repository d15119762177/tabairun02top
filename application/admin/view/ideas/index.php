{include file="common/header.php"}

        <a href="{:url('Index/add')}" class="layui-btn" style="margin-left:15px;">创建广告组</a>
        <a href="{:url('Plan/add')}" class="layui-btn" style="margin-left:15px;">创建广告计划</a>
        <a href="{:url('Ideas/add')}" class="layui-btn" style="margin-left:15px;">创建广告创意</a>
        
                  <!-- Start responsive Table-->
                <div class="col-md-12">

                 <div class="white-box"> <form action="">
        <input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" style="width: 30%;">
        <!-- <input type="button" value="广告组搜索" class="layui-btn layui-btn-primary" style=""> -->
        </form><br>
                    <h2 class="header-title">广告创意</h2>
                     <div class="table-responsive">
                         <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>广告计划名称</th>
                             
                              <th>状态</th>
                              <th>素材标题</th>
                              <th>创意分类</th>
                             <!--  <th>创意标签</th> -->
                              <th>创意类型</th>
                              <th>创意标签</th>
                              <th>来源</th>
                               <!-- <th>投放位置</th> -->
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            {volist name="datas" id="vo" }
                            {if condition="empty($vo) neq true"}
                            <tr>
                              <td>{$vo.creative_id}</td>
                              <td>{$vo.plan_name}</td>
                              
                              <td>{$vo.status}</td>
                              <td onclick="look(res=`{$vo.title}`)" title="{$vo.title}">{$vo.title}</td>
                              <td>{$vo.third_industry_id}</td>
                             <!--  <td>{$vo.title}</td> -->
                              <td>{$vo.creative_material_mode}</td>
                               <td>{$vo.ad_keywords}</td>
                               <td>{$vo.source}</td>
                              <!--  {if condition="$vo.inventory_type eq 1"}
                              <td>默认</td>
                              {/if}
                              {if condition="$vo.inventory_type eq 2"}
                              <td>按媒体指定位置</td>
                              {/if}
                              {if condition="$vo.inventory_type eq 3"}
                              <td>按场景指定位置</td>
                              {/if} -->
                               <td>  <a href="{:url('Ideas/edit',['id'=>$vo.id])}">修改</a>
                                <a href="javascript:;" onclick="del()">删除</a></td>
                            </tr>

                            <div style="
                             width:300px;height: 200px;
                             background-color: rgb(255,254,255);
                             position: fixed;
                             top: 30%;left: 42%;
                             z-index: 999;
                             border-radius: 20px;
                             display:none;
                             " class="tk">
                             <p style="color: black;text-align: center;font-size: 30px;margin-top:16%; ">确认删除吗？</p>
                             <a href="javascript:;" class="btn btn-success" style="float: left;margin-top: 15%;margin-left: 23%" onclick="ex()">取消</a>
                             <a href="{:url('Ideas/del',['id'=>$vo.id])}" class="btn btn-danger" style="float: right;margin-top: 15%;margin-right: 27%">确定</a>

                             </div>
                            {/if}
                          {/volist}
                          
                           </tbody>
                          
                          
                        </table>
                             

                               <!-- 页码 start -->
                        <div style="height: 35px;background-color:white;width: 100%;line-height: 35px;font-size: 15px;">
                            <form action="{:url('Ideas/index')}"> <span>第<b class="page">{$page}</b>页</span>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('ideas/Index',['page_num'=>$page,'page'=>'last'])}" onclick="last_page()">上一页</a>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('ideas/Index',['page_num'=>$page,'page'=>'next','count'=>$count])}" onclick="next_page()">下一页</a>&nbsp;&nbsp;
                           跳转
                           &nbsp;<input type="text" style="height: 20px;width: 40px;" name="input_page">&nbsp;页
                           <span style="float: right;">统计一共 <b>{$sum}</b> 条数据</span>
                         </form>
                        </div>
                        <!--  页码 end -->
                     </div>
                      <div class="hei" style="position: fixed;top: 0px;left: 0px;bottom: 0px;right: 0px;width: 100%;height: 100%;background-color: #eee;opacity: 0.7;display:none;"></div>
                 </div>
                 </div>
                 </div>
               <!-- End responsive Table-->        
                            <script>
                              function del(){
                                //alert('确定删除吗？');
                                $('.tk').show();
                                $('.hei').show();
                              }
                               function ex(){
                                $('.tk').hide();
                                $('.hei').hide();
                              }

                               function look(title){
                                var a = title;
                                // var data = $(a).html();
                                alert(a);

                              }
                          </script>
         
    

{include file="common/foot.php"}



   

