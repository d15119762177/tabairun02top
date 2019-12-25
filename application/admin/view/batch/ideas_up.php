{include file="common/header.php"}
<div style="margin-top:2%;margin-left:2%;">
	<span style="font-size: 20px;font-weight: bold;">创意Excel导入</span>
	<br><br>
  <form action="{:url('Batch/ideasexcel')}" method="post" enctype="multipart/form-data">
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
{include file="common/foot.php"}