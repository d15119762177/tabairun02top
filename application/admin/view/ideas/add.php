{include file="common/header.php"}
<!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">创建广告创意</h2>
                       
                        <form action="{:url('Ideas/doadd')}" method="post" class="form-horizontal" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-md-2 control-label">广告主ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="{$Request.cookie.advertiser_id}" type="text" readonly="">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-2 control-label">广告计划</label>
                            <div class="col-sm-10">
                              <select class="form-control tg_type" name="ad_id" onchange="tgmds()">
                                {volist name="data" id="vo"}
                                <option value="{$vo.pid}">{$vo.name}</option>/
                                {/volist}
                              </select>
                            </div>
                          </div>
                          <script>
                                function tgmds(){
                                  var pid = $('.tg_type').val();
                                   $.get("{:url('Ajax/get_landing_type')}",{pid:pid},function(data){
                                        //alert('Ajax从服务器端返回来的值是：'+data);
                                        if(data!='error'){
                                          console.log(data);
                                        //$('.title_f').html(data.ideas_type_name);
                                        $('#zhi').html(data.type_name);
                                        $('#zhi').val(data.type);
                                        $('.tgmm').show();

                                        }
                                     });
                                }
                          </script>

                          <div class="form-group tgmm" style="display: none;" >
                            <label class="col-sm-2 control-label">广告推广目的</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="ad_id">
                                <option value="" id="zhi"></option>/
                              </select>
                            </div>
                          </div>

                          
                        <!--   <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">投放位置</label>
                            <div class="col-md-10">
                              <input id="example-email" name="inventory_type" class="form-control" placeholder="" type="text">
                            </div>
                          </div> -->




                          <div class="form-group">
                            <label class="col-sm-2 control-label" >投放位置</label>
                            <div class="col-sm-10">
                             <select name="inventory_type" id="tfwz" onchange="tf()" value="" style="margin: 0px;padding: 0px;float: left;height: 34px;">
                            <option id="ys" value="1" selected>优选广告位</option>
                            <option id="zys" value="2">按媒体指定位置</option>
                            <option id="zys" value="3">按场景指定位置</option>
                          </select></div>
                          <div class="app" style="margin-left:18.5%;margin-top: 2.5%;display:none;">
                          	<table>
                          		<th>APP名称</th>
                          		<tr>
                          			<td><input type="checkbox" name="app_name[0]" value="jrtt" title="今日头条" lay-skin="primary" checked>今日头条</td>
								</tr><tr>
                          			<td><input type="checkbox" name="app_name[1]" value="xgsp" title="西瓜视频" lay-skin="primary"> 西瓜视频</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[2]" value="hssp" title="火山小视频" lay-skin="primary" > 火山小视频</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[3]" value="dy" title="抖音" lay-skin="primary" > 抖音</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[4]" value="csj" title="穿山甲" lay-skin="primary" > 穿山甲</td>
                          		</tr>
                          	</table>
                            </div>
                          <div class="changjing" style="margin-left:18.5%;margin-top: 2.5%;display:none;">
                          	<table>
                          		<th>位置选择</th>
                          		<tr>
                          			<td><input type="checkbox" name="place[0]" title="沉浸式竖版视频场景" lay-skin="primary" checked>沉浸式竖版视频场景</td>
								</tr><tr>
                          			<td><input type="checkbox" name="place[1]" title="信息流场景" lay-skin="primary"> 信息流场景</td>
								</tr><tr>
									<td><input type="checkbox" name="place[2]" title="视频后贴和尾帧场景" lay-skin="primary" > 视频后贴和尾帧场景</td>
								</tr>
                          	</table>
                            </div>

                        </div>


							<script>
                            // function sel(){
                            //   //alert($("#aab").val());
                            //    if($("#aab").val()=='0571'){
                            //  // alert('aa')
                            //   $('.y_cont').attr('placeholder',' 请输入预算，不少于200元，不超过9999999.99元');
                            //  }
                            // if($("#aab").val()=='010'){
                            //   $('.y_cont').attr('placeholder',' 请输入预算，不少于100元，不超过9999999.99元');
                            //    }
                            // }
                            //removeAttr() 方法从被选元素中移除属性。
                            function tf(){
                            	if($('#tfwz').val()=='2'){
                            		$('.changjing').hide();
                            		$('.app').show();
                            	}
                            	if($('#tfwz').val()=='3'){
                            		$('.app').hide();
                            		$('.changjing').show();
                            	}
                            	if($('#tfwz').val()=='1'){
                            		$('.app').hide();
                            		$('.changjing').hide();
                            	}
                            }
                          </script>



                            <div class="form-group">
                            <label class="col-sm-2 control-label">创意分类</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="third_industry_id" style="width: 20%;float: left;" id="yiji" onchange="id_type()">
                                {volist name="industry_data" id="vo"}
                                <option value="{$vo.industry_id}">{$vo.industry_name}</option>
                                {/volist}
                              </select> 
                              <select class="form-control" name="third_industry_id" style="width: 20%;float: left;display: none;" id="second_industry" onchange="second_data()">
                                  <!-- <option value="3">3</option> -->
                              </select>
                              <select class="form-control" name="third_industry_id" style="width: 20%;float: left;display: none;" id="third_industry">
                                 <!--  <option value="3">3</option> -->
                                  
                              </select>
                            </div>
                          </div>
                            <script>
                              function fl(){
                                $('#ii').show();
                              }
                            </script>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" >创意标签</label>
                            <div class="col-sm-10">
                         <!-- <input type="submit" style="margin: 0px;padding: 0px;float: left;height: 34px;border-right: 0px;width: 60px;">  -->
                         <a href="javascript:;" style="margin: 0px;padding: 0px;float: left;height: 34px;width: 80px;background-color: rgb(95,184,150);text-align: center;line-height: 34px;color: white;border-right: 0px;border-color: rgb(169,169,169);" onclick="add_type()">添加标签</a>
                          <input class="bq_type" type="text" name="title"   placeholder=" 最多20个标签，每个不超10字
" autocomplete="off" class="y_cont" style="margin:0px;padding: 0px;float: left;height: 34px;width: 50%;" >     
                            </div>

                            <div id="tag" style="margin-left:18.5%;margin-top: 3%;width: 40%;" value="标签" name="tag">
                            <p>已选标签：</p>
                            <!-- <table style="" class="table table-hover" id="tb">
                            	<tr>
                            		<td>已选标签</td>
                            	</tr> -->
                            
                            <!-- </table> -->
                            {volist name="tag_data" id="vo"}
                            <font name="bq1" value="1111111111">{$vo.name}<input type="hidden" name="ad_keywords[{$vo.id}]" value="{$vo.id}"></font>
                            {/volist}
                        </div>
                          </div>
                          <script>
                          function add_type(){
                            	 var name = $('.bq_type').val();
                                $.get("{:url('Ajax/index')}",{name:name},function(data){
                                        //alert('Ajax从服务器端返回来的值是：'+data);
                                        console.log(data);
                                        if(data == 'success'){
                                         $('#tag').append(`<font >`+ name +`</font>`);
                                        }
                                     });
                            	var a = $("#tb").find("tr").length;
                            	console.log(a);
                             }

                          </script>

                        <!--   <div class="form-group">
                            <label class="col-md-2 control-label">投放时间</label>
                            <div class="col-md-10">
                               <input type="text" placeholder=" YY/mm/dd/ H:i:s" style="width: 35%;height:34px;margin-right: 0px;padding-right: 0px;" name="stat_time" class="layui-input1" id="test1"> &nbsp;&nbsp;-&nbsp;&nbsp;
                                <input type="text" placeholder="  YY/mm/dd/ H:i:s" style="width: 35%;height:34px;" name="end_time" class="layui-input1" id="test2">
                            </div>
                          </div> -->

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
                            <label class="col-sm-2 control-label">添加创意类型</label>
                            <div class="col-sm-10">
                              <select class="form-control con" onchange="id_con()" name="creative_material_mode">
                                {volist name="ideas_type" id="vo"}
                                <option value="{$vo.id}">{$vo.ideas_type_name}</option>
                                {/volist}
                              </select>
                            </div>
                            <!-- 图片/视频 -->
                            <div style="width: 80%;height: 300px;margin-left: 18.3%" >
                            <table style="" class="table-responsive table" id="tb">
                            	<tr>
                            		<td class="title_f">创意类型</td>
                            	</tr>
                            	<tr>
                            		<td style="width: 100px;">
                            			创意标题  
                            		</td>
                            		<td><input type="text" class="form-control" name="title_list"></td>
                            	</tr>
                            	<tr>
                            		<td>
                            			创意内容
                            		</td>
                            		<td><input type="file" name="file"></td>
                            	</tr>

                            </table>
                            </div>
						

                          </div>

							<script>
								function id_con(){
									var id = $('.con').val();
                  //console.log(id);
                    $.get("{:url('Ajax/ideas_type')}",{id:id},function(data){
                                        //alert('Ajax从服务器端返回来的值是：'+data);
                                        console.log(data);
                                        if(data!='error'){
                                        $('.title_f').html(data.ideas_type_name);
                                        }
                                     });
									
								}
							</script>
						<div class="form-group">
                            <label class="col-md-2 control-label" for="example-email" >来源</label>
                            <div class="col-md-10">
                              <input id="example-email" name="source" class="form-control" placeholder="" type="text">
                            </div>
                          </div>
                          
                       


                          <div class="form-group m-b-0" id="an" >
                           <input type="submit" class="layui-btn layui-btn-danger" onclick="history.go(-1)" value="返回" style="float: right;margin-right: 12px;background-color:#aaa">
                            <div class="col-sm-offset-3 col-sm-9" style="margin-left:16.5%;">
                              <input type="submit" class="btn btn-primary" name="goon" value="继续添加">
                              <input type="submit" class="btn btn-primary" name="yes" value="确认">

                            </div>
                        </div>
                          
                        </form>
                   </div>
                  </div>
              </div>
              <script>
                  function id_type(){ //获取二级行业
                    var id = $('#yiji').val();
                    //alert(y_id)
                    $.get("{:url('Ajax/get_industry_second')}",{id:id},function(data){
                                        //alert('Ajax从服务器端返回来的值是：'+data);
                                        //console.log(data);
                                        if(data!='error'){
                                          //console.log(data);
                                          $("#second_industry").empty();
                                          $("#third_industry").empty();
                                          for(i = 0; i < data.length; i++) {
                                            var id = data[i]['industry_id'];
                                            var name = data[i]['industry_name'];
                                                    
                                                    $('#second_industry').append("<option value="+id+">"+name+"</option>");
                                                    $('#second_industry').show();
                                            } 
                                        }
                                     });
                  }
                  function second_data(){ //获取三级行业
                    var id = $('#second_industry').val();
                     $.get("{:url('Ajax/get_industry_third')}",{id:id},function(data){
                                        //alert('Ajax从服务器端返回来的值是：'+data);
                                        //console.log(data);
                                        if(data!='error'){
                                          //console.log(data);
                                          $("#third_industry").empty();
                                          for(i = 0; i < data.length; i++) {
                                            var id = data[i]['industry_id'];
                                            var name = data[i]['industry_name'];
                                                    
                                                    $('#third_industry').append("<option value="+id+">"+name+"</option>");
                                                    $('#third_industry').show();
                                            } 
                                        }
                                     });
                  }
              </script>
             <!--End row-->
{include file="common/foot.php"}