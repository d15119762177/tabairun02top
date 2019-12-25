{include file="common/header.php"}
<!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">创建广告创意</h2>
                       
                        <form action="{:url('Ideas/update')}" method="post" class="form-horizontal" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-md-2 control-label">广告主ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="1111111111" type="text" readonly="">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-2 control-label">广告计划</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="ad_id">
                                {volist name="data" id="vo"}
                                <option value="{$vo.id}" {if condition="$data.ad_id eq $vo.id"} selected {/if}>{$vo.name}</option>
                                {/volist}
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
                            <option id="ys" value="1"  {if condition="$data.inventory_type eq 1"} selected {/if}>优选广告位</option>
                            <option id="zys" value="2" {if condition="$data.inventory_type eq 2"} selected {/if}>按媒体指定位置</option>
                            <option id="zys" value="3" {if condition="$data.inventory_type eq 3"} selected {/if}>按场景指定位置</option>
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
                              <select class="form-control" name="third_industry_id">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>
                            </div>
                          </div>

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
                                <option value="大幅横图">大幅横图</option>
                                <option value="组图">组图</option>
                                <option value="小图">小图</option>
                                <option value="大图竖图">大图竖图</option>
                                <option value="横版视频">横版视频</option>
                                <option value="竖版视频">竖版视频</option>
                              </select>
                            </div>
                            <!-- 图片/视频 -->
                            <div style="width: 80%;height: 300px;margin-left: 18.3%" >
                            <table style="" class="table-responsive table" id="tb">
                            	<tr>
                            		<td class="title_f">大幅横图</td>
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
									var name = $('.con').val();
									$('.title_f').html(name);
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
             <!--End row-->
{include file="common/foot.php"}