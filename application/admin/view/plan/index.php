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
                    <h2 class="header-title">广告计划</h2>
                     <div class="table-responsive">
                         <table class="table table-bordered layui-form">
                          <form class="" action="">
                          <thead>
                            <tr>
                              <th style="width:100px;"></th>
                              <th>ID</th>
                              <th>广告计划名称</th>
                              <th>广告组名称</th>
                              <th>计划操作状态</th>
                              <th>计划状态</th>
                              <th>审核不通过原因</th>
                              <th>投放时间段</th>
                              <th>预算</th>
                              <th>付费方式</th>
                              <th>点击出价</th>
                              <th>转化出价</th>
                              <th>投放范围</th>
                              <th>落地页链接</th>
                              <th>操作</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            {if condition="empty($data) neq true"}
                            {volist name="data" id="vo"}
                            <tr>
                              <td style=""  >
                               <!-- <input type="checkbox" name="zzz" lay-skin="switch" lay-text="开启|关闭"> -->
                                <input type="checkbox" {if condition="$vo.opt_status eq 'AD_STATUS_ENABLE'"} checked {/if} name="anniu" lay-skin="switch" lay-text="开启|关闭"  lay-filter="filter" value="{$vo.pid}">
                                <!-- <input type="checkbox" onchange="du()"> -->
                              </td>
                              <td >{$vo.pid}</td>
                              <td title="{$vo.name}" onclick="look(res=`{$vo.name}`)">{$vo.name}</td>
                              <td title="{$vo.advertising_name}" onclick="look(res=`{$vo.advertising_name}`)">{$vo.advertising_name}</td>
                              {if condition="$vo.opt_status eq 'AD_STATUS_ENABLE'"}
                              <td >开启</td>
                              {/if}
                              {if condition="$vo.opt_status eq 'AD_STATUS_DISABLE' || $vo.opt_status eq ''"}
                              <td >暂停</td>
                              {/if}
                              <td>{$vo.status}</td>
                              <td title="{$vo.audit_reject_reason}" onclick="look(res=`{$vo.audit_reject_reason}`)" class="reason">{$vo.audit_reject_reason}</td>
                              <td title="{$vo.start_time} - {$vo.end_time}">{$vo.start_time} - {$vo.end_time}</td>
                              <td >{$vo.budget}</td>
                              <td >{$vo.pricing}</td>
                               <td >{$vo.bid}</td>
                               <td >{$vo.cpa_bid}</td>
                              <td >{$vo.delivery_range}</td>
                              <td title="{$vo.external_url}" onclick="look(res=`{$vo.external_url}`)" class="url">{$vo.external_url}</td>
                              <td>
                                <a href="{:url('Plan/edit',['campaign_id'=>$vo.campaign_id,'pid'=>$vo.pid])}">修改</a>
                                <a href="javascript:;" onclick="del()">删除</a>
                                <a href="javascript:;" onclick="del()">批量删除</a>
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
                             <a href="javascript:;" class="btn btn-success" style="float: left;margin-top: 15%;margin-left: 23%" onclick="ex()">按错了</a>
                             <a href="{:url('Plan/del',['id'=>$vo.id])}" class="btn btn-danger" style="float: right;margin-top: 15%;margin-right: 27%">确定</a>
                             </div>
                          {/volist}
                          {/if}
                           </tbody>
                          </form>
                        </table>
                       <!-- 页码 start -->
                        <div style="height: 35px;background-color:white;width: 100%;line-height: 35px;font-size: 15px;">
                            <form action="{:url('Plan/index')}"> <span>第<b class="page">{$page}</b>页</span>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('Plan/index',['page_num'=>$page,'page'=>'last'])}" onclick="last_page()">上一页</a>&nbsp;&nbsp;&nbsp;
                            <a href="{:url('Plan/index',['page_num'=>$page,'page'=>'next','count'=>$count])}" onclick="next_page()">下一页</a>&nbsp;&nbsp;
                           跳转
                           &nbsp;<input type="text" style="height: 20px;width: 40px;" name="input_page">&nbsp;页
                           <span style="float: right;">统计一共 <b>{$sum}</b> 条数据</span>
                         </form>
                        </div>
                        <!--  页码 end -->
                     </div>
                      
                              <div class="hei" style="position: fixed;top: 0px;left: 0px;bottom: 0px;right: 0px;width: 100%;height: 100%;background-color: black;opacity: 0.5;display:none;"></div>
                 </div>
                  
                 </div>
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
                 </div>
               <!-- End responsive Table-->        
          
 
<!-- <script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});
</script>
			   <script>
            function dd(){
              var a = $('.kg').val();
              console.log(a);
              alert(a);
            }
         </script> -->

         <script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
form.on('switch(filter)', function(data){
 // alert('aaa');
  console.log(data);
  var status = data.elem.checked;
  var advertiser_id = $('#adv').val();
  var pid = data.value;
  pid = parseInt(pid);
  if(status){
    
    //var campaign_ids = array(data.value);
    alert('已开启');
    $.ajax({
        type: "POST",
        url: "{:url('Ajax/update_plan_status')}",
        data: {
          "advertiser_id": advertiser_id,
          "pid": [pid],
          "opt_status":'enable'
        },
        dataType: "JSON",
        success: function(result) {
          console.log(result);
          //alert('已开启');
        }
      });

    
  }else{
    $.ajax({
        type: "POST",
        url: "{:url('Ajax/update_plan_status')}",
        data: {
          "advertiser_id": advertiser_id,
          "pid": [pid],
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
    alert('已暂停')
  }
});
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});


</script>
		

{include file="common/foot.php"}



   

