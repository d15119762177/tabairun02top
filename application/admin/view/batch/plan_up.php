{include file="common/header.php"}
<div style="margin-top:2%;margin-left:2%;">
	<span style="font-size: 20px;font-weight: bold;">广告计划Excel导入</span>
	<br><br>
  <form action="{:url('Batch/planexcel')}" method="post" enctype="multipart/form-data">
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
  <!-- <th>学号</th>
 <th>名字</th>
 <th>年龄</th>
 <th>班级</th> -->
 
  


</table>
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
$('#tb').append("<tr><td>{$vo.0}</td><td>{$vo.1}</td><td>{$vo.2}</td><td>{$vo.3}</td><td>{$vo.4}</td><td>{$vo.5}</td></tr>");
</script>
{/volist}
{/if}
{include file="common/foot.php"}