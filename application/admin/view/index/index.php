{include file="common/header.php"}

        <a href="{:url('Index/add')}" class="layui-btn" style="margin-left:15px;">创建广告组</a>
        <a href="{:url('Plan/add')}" class="layui-btn" style="margin-left:15px;">创建广告计划</a>
        <a href="{:url('Ideas/add')}" class="layui-btn" style="margin-left:15px;">创建广告创意</a>
				
                  <!-- Start responsive Table-->
                <div class="col-md-12">

                 <div class="white-box"> <form action="">
				<input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" style="width: 30%;">
        <input type="hidden" value="{$Request.cookie.advertiser_id}" id="adv">
				<!-- <input type="button" value="广告组搜索" class="layui-btn layui-btn-primary" style=""> -->
				</form><br>
                    <h2 class="header-title">广告组</h2>
                     <div class="table-responsive layui-form">
                      <form class="layui-form" action="">
                         <table class="table table-bordered">
                          <thead>
  
                            <tr>
                              <th style="width:100px;" onclick="losts_up_status()" class="initial_status">更新状态</th>
                             <!--  <th style="width:100px;display: none;" onclick="choice()" class="all_choice"><span class="layui-btn">全选</span></th> -->
                              <th>ID</th>
                              <td>广告主ID</td>
                              <th>广告组名称</th>
                              <th>推广目的</th>
                            <!--   <th>状态</th> -->
                              <th>创建时间</th>
                              <th>修改时间</th>
                              <th>广告组预算</th>
                              <th>预算类型</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            {if condition="empty($data) neq true"}
                            {volist name="data" id="vo"}
                            <tr>
                              <td style=""  class="one">
                               <!-- <input type="checkbox" name="zzz" lay-skin="switch" lay-text="开启|关闭"> -->
                                <input type="checkbox" {if condition="$vo.status eq 'CAMPAIGN_STATUS_ENABLE'"} checked {/if} name="anniu" lay-skin="switch" lay-text="开启|关闭"  lay-filter="filter" value="{$vo.campaign_id}">
                                <!-- <input type="checkbox" onchange="du()"> -->
                              </td>
                              <td style="display: none;"  class="secound">
                               <input type="checkbox" name="" title="已选" lay-skin="" lay-filter="all" id="all_status">
                              <!--   <input type="checkbox" name="anniu" lay-skin="switch" lay-text="开启|关闭"  lay-filter="filter" value="{$vo.campaign_id}"> -->
                                <!-- <input type="checkbox" onchange="du()"> -->
                              </td>
                              <td>{$vo.campaign_id}</td>
                              <td>{$vo.advertiser_id}</td>
                              <td>{$vo.campaign_name}</td>
                              <td>{$vo.landing_type}</td>

                            <!--   {if condition="$vo.status eq 'CAMPAIGN_STATUS_ENABLE'"}
                              <td>启用</td>
                              {/if}
                              {if condition="$vo.status eq 'CAMPAIGN_STATUS_DISABLE'"}
                              <td>暂停</td>
                              {/if}
                              {if condition="$vo.status eq 'CAMPAIGN_STATUS_DELETE'"}
                              <td>删除</td>
                              {/if}
                              {if condition="$vo.status eq 'CAMPAIGN_STATUS_ALL'"}
                              <td>所有包含已删除</td>
                              {/if}
                              {if condition="$vo.status eq 'CAMPAIGN_STATUS_NOT_DELETE'"}
                              <td>所有不包含已删除</td>
                              {/if} -->

                              <td>{$vo.campaign_modify_time}</td>
                              <td>{$vo.campaign_create_time}</td>

                              <td>{$vo.budget}</td>
                              {if condition="$vo.budget_mode eq 'BUDGET_MODE_INFINITE'"}
                              <td>不限</td>
                              {/if}
                              {if condition="$vo.budget_mode eq 'BUDGET_MODE_DAY'"}
                              <td>日预算</td>
                              {/if}
                              {if condition="$vo.budget_mode eq 'BUDGET_MODE_TOTAL'"}
                              <td>总预算</td>
                              {/if}
                              <td>
                                <a href="{:url('Index/edit',['id'=>$vo.id])}">修改</a>
                                <a href="javascript:;" onclick="del()">删除</a>
                              </td>
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
                             <a href="{:url('Index/del',['id'=>$vo.id])}" class="btn btn-danger" style="float: right;margin-top: 15%;margin-right: 27%">确定</a>
                             </div>
                          {/volist}
                          {/if}
                           </tbody>
                          

                            
                          <script>
                              function del(){
                                //alert('确定删除吗？');
                                $('.tk').show();
                                $('.hei').show();
                              }
                              function du(){
                                alert('aa');
                              }
                          </script>
                        </table>
                         </form>
                        <!-- 页码 start -->
                        <div style="height: 35px;background-color:white;width: 100%;line-height: 35px;font-size: 15px;">
                            <form action="{:url('Index/index')}"> <span>第<b class="page">{$page}</b>页</span>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('Index/index',['page_num'=>$page,'page'=>'last'])}" onclick="last_page()">上一页</a>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('Index/index',['page_num'=>$page,'page'=>'next','count'=>$count])}" onclick="next_page()">下一页</a>&nbsp;&nbsp;
                           跳转
                           &nbsp;<input type="text" style="height: 20px;width: 40px;" name="input_page">&nbsp;页
                           <span style="float: right;">统计一共 <b>{$sum}</b> 条数据</span>
                         </form>
                        </div>
                        <!--  页码 end -->
                     </div>
                 </div>
                 <div class="hei" style="position: fixed;top: 0px;left: 0px;bottom: 0px;right: 0px;width: 100%;height: 100%;background-color: #eee;opacity: 0.7;display:none;"></div>
                 </div>
               <!-- End responsive Table-->        
          
			   <script>
            function ex(){
              $('.tk').hide();
              $('.hei').hide();
            }
            // function last_page(){
            //   var num = $('.page').html();
            //   console.log(num);
            //   $.get("{:url('Ajax/last_page')}",{num:num},function(data){
            //       //alert('Ajax从服务器端返回来的值是：'+data);
            //     console.log(data);
            //        for(i in data.data) //data.data指的是数组，数组里是8个对象，i为数组的索引
            //        {
            //           var tr;
            //           tr='<td>'+data.data[i].id+'</td>'+'<td>'+data.data[i].startTime+'</td>'+'<td>'+data.data[i].is_true+'</td>'+'<td>'+data.data[i].device+'</td>'
            //           $("#tabletest").append('<tr>'+tr+'</tr>')
            //          }
            //  });

            // }
         </script>
		
<script>
  // var content=getCookie("advertiser_id")；
  //    alert(content);
    // $.ajax({
    //     type: "POST",
    //     url: "https://ad.oceanengine.com/open_api/2/campaign/update/status/",
    //     data: {
    //       advertiser_id: $("#username").val(),
    //       password: $("#password").val()
    //     },
    //     dataType: "JSON",
    //     success: function(result) {}
    //   });
</script>
 
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
form.on('switch(filter)', function(data){
 // alert('aaa');
  console.log(data);
  var status = data.elem.checked;
  var advertiser_id = $('#adv').val();
  var campaign_id = data.value;
  campaign_id = parseInt(campaign_id);
  if(status){
    
    //var campaign_ids = array(data.value);
    alert(advertiser_id);
    $.ajax({
        type: "POST",
        url: "{:url('Ajax/update_status')}",
        data: {
          "advertiser_id": advertiser_id,
          "campaign_ids": [campaign_id],
          "opt_status":'enable'
        },
        dataType: "JSON",
        success: function(result) {
          console.log(result);
          alert('开启');
        }
      });

    
  }else{
    $.ajax({
        type: "POST",
        url: "{:url('Ajax/update_status')}",
        data: {
          "advertiser_id": advertiser_id,
          "campaign_ids": [campaign_id],
          "opt_status":'disable',
        },
        dataType: "JSON",
        success: function(res) {
          console.log(res);
          var data = JSON.parse(res);

          console.log(data);
        //  alert(res.code);
        //  alert('开启');
        }
      });
    alert('关闭')
  }
});
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });

  form.on('checkbox(all)', function(data){
    console.log(data);

  });

  

});
function losts_up_status(){
  $('.one').hide();
  $('.secound').show();
 // $('.initial_status').hide();
  //$('.all_choice').show();
}

</script>
{include file="common/foot.php"}



   

