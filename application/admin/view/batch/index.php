{include file="common/header.php"}
<script src="/jquery-2.1.1.min.js"></script>
<div style="margin-top:2%;margin-left:2%;">
	<span style="font-size: 20px;font-weight: bold;">广告组Excel导入</span>
	<br><br>
  <form action="{:url('Batch/doexcel')}" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1">创建时间</label>
    <input type="text" class="form-control"  id="test1" placeholder="">
  </div>
  
  <div class="form-group">
    <label for="exampleInputFile">文件上传</label>
    <input type="file" id="exampleInputFile" name="excel">
    <p class="help-block">请选择excel文档类型xls后缀名的</p>
  </div>
  <button type="submit" class="btn btn-default">确定</button>
</form>
</div>
{if condition="empty($datas) neq true"}
<div style="width: 90%;margin:0 auto;margin-top: 50px;" class="ww">
<table class="table table-striped tb" id="tb">
  <tr>
    <th>编号</th>
   <th>广告主id</th>
   <th>广告组名称</th>
   <th>广告组推广目的</th>
   <th>广告组状态</th>
   <th>预算类型</th>
   <th>广告组预算</th>
   <th class="reson" >结果</th>
  </tr>
  


</table>
<!-- <a class="btn btn-success">确认上传创建</a> -->
<button class="layui-btn layui-btn-fluid" type="button" onclick="uploading()">确认上传创建</button>

</div>
{/if}
<script>
	 layui.use('laydate', function(){
         var laydate = layui.laydate;
		 //执行一个laydate实例
         laydate.render({
         elem: '#test1' //指定元素
         ,type: 'datetime'
        });
    });
</script>


{if condition="empty($datas) neq true"}
{volist name="datas" id="vo"}
<script>
  var i = 1;

$('#tb').append("<tr ><td>{$vo.id}</td><td>{$vo.advertiser_id}</td><td>{$vo.campaign_name}</td><td>{$vo.type_name}</td><td>{$vo.status_name}</td><td>{$vo.budget_mode_name}</td><td>{$vo.budget}</td><td id='sc' class="+'td'+{$vo.id}+">未上传</td></tr>");
  var i = i+1;
</script>
{/volist}
<script>
  function uploading(){
    var data = new Array();
    $.post("{:url('Ajax/losts_upload')}", { data: {$json_data} },
         function(data){
          if(data == '广告组不能重复'){
            alert(data);
            return false;
          }

          $('#sc').html("<td style='color:green;'>创建成功!</td>");

          if(data){
           // $('.reson').show();
          for(i=0;i<data.length;i++){
            var a = data[i]['message'];
            var msg = JSON.stringify(a);
            //alert('aa')
            $('.td'+data[i]['id']).html("<td style='color:red;'>数据出错 上传失败</td>");

          }
        }
          console.log(data);

    //     $(".dd").on("click",function (e) {
    //     alert(i);
    //     console.log(e);
    // })  
  //    function res(data){
  //   console.log(data);
  //   alert(data);
  // }   
    });

    
  }

  
  
</script>
<script>
  function res(data){
    msg = JSON.parse(data);
    console.log(data);
    alert(data);
    return false;
  } 
</script>
{/if}



{include file="common/foot.php"}