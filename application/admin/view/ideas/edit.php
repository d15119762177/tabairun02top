{include file="common/header.php"}
<!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">������洴��</h2>
                       
                        <form action="{:url('Ideas/update')}" method="post" class="form-horizontal" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-md-2 control-label">�����ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="1111111111" type="text" readonly="">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-2 control-label">���ƻ�</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="ad_id">
                                {volist name="data" id="vo"}
                                <option value="{$vo.id}" {if condition="$data.ad_id eq $vo.id"} selected {/if}>{$vo.name}</option>
                                {/volist}
                              </select>
                            </div>
                          </div>
                          
                        <!--   <div class="form-group">
                            <label class="col-md-2 control-label" for="example-email">Ͷ��λ��</label>
                            <div class="col-md-10">
                              <input id="example-email" name="inventory_type" class="form-control" placeholder="" type="text">
                            </div>
                          </div> -->




                          <div class="form-group">
                            <label class="col-sm-2 control-label" >Ͷ��λ��</label>
                            <div class="col-sm-10">
                             <select name="inventory_type" id="tfwz" onchange="tf()" value="" style="margin: 0px;padding: 0px;float: left;height: 34px;">
                            <option id="ys" value="1"  {if condition="$data.inventory_type eq 1"} selected {/if}>��ѡ���λ</option>
                            <option id="zys" value="2" {if condition="$data.inventory_type eq 2"} selected {/if}>��ý��ָ��λ��</option>
                            <option id="zys" value="3" {if condition="$data.inventory_type eq 3"} selected {/if}>������ָ��λ��</option>
                          </select></div>
                          <div class="app" style="margin-left:18.5%;margin-top: 2.5%;display:none;">
                          	<table>
                          		<th>APP����</th>
                          		<tr>
                          			<td><input type="checkbox" name="app_name[0]" value="jrtt" title="����ͷ��" lay-skin="primary" checked>����ͷ��</td>
								</tr><tr>
                          			<td><input type="checkbox" name="app_name[1]" value="xgsp" title="������Ƶ" lay-skin="primary"> ������Ƶ</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[2]" value="hssp" title="��ɽС��Ƶ" lay-skin="primary" > ��ɽС��Ƶ</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[3]" value="dy" title="����" lay-skin="primary" > ����</td>
								</tr><tr>
									<td><input type="checkbox" name="app_name[4]" value="csj" title="��ɽ��" lay-skin="primary" > ��ɽ��</td>
                          		</tr>
                          	</table>
                            </div>
                          <div class="changjing" style="margin-left:18.5%;margin-top: 2.5%;display:none;">
                          	<table>
                          		<th>λ��ѡ��</th>
                          		<tr>
                          			<td><input type="checkbox" name="place[0]" title="����ʽ������Ƶ����" lay-skin="primary" checked>����ʽ������Ƶ����</td>
								</tr><tr>
                          			<td><input type="checkbox" name="place[1]" title="��Ϣ������" lay-skin="primary"> ��Ϣ������</td>
								</tr><tr>
									<td><input type="checkbox" name="place[2]" title="��Ƶ������β֡����" lay-skin="primary" > ��Ƶ������β֡����</td>
								</tr>
                          	</table>
                            </div>

                        </div>


							<script>
                            // function sel(){
                            //   //alert($("#aab").val());
                            //    if($("#aab").val()=='0571'){
                            //  // alert('aa')
                            //   $('.y_cont').attr('placeholder',' ������Ԥ�㣬������200Ԫ��������9999999.99Ԫ');
                            //  }
                            // if($("#aab").val()=='010'){
                            //   $('.y_cont').attr('placeholder',' ������Ԥ�㣬������100Ԫ��������9999999.99Ԫ');
                            //    }
                            // }
                            //removeAttr() �����ӱ�ѡԪ�����Ƴ����ԡ�
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
                            <label class="col-sm-2 control-label">�������</label>
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
                            <label class="col-sm-2 control-label" >�����ǩ</label>
                            <div class="col-sm-10">
                         <!-- <input type="submit" style="margin: 0px;padding: 0px;float: left;height: 34px;border-right: 0px;width: 60px;">  -->
                         <a href="javascript:;" style="margin: 0px;padding: 0px;float: left;height: 34px;width: 80px;background-color: rgb(95,184,150);text-align: center;line-height: 34px;color: white;border-right: 0px;border-color: rgb(169,169,169);" onclick="add_type()">��ӱ�ǩ</a>
                          <input class="bq_type" type="text" name="title"   placeholder=" ���20����ǩ��ÿ������10��
" autocomplete="off" class="y_cont" style="margin:0px;padding: 0px;float: left;height: 34px;width: 50%;" >     
                            </div>

                            <div id="tag" style="margin-left:18.5%;margin-top: 3%;width: 40%;" value="��ǩ" name="tag">
                            <p>��ѡ��ǩ��</p>
                            <!-- <table style="" class="table table-hover" id="tb">
                            	<tr>
                            		<td>��ѡ��ǩ</td>
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
                                        //alert('Ajax�ӷ������˷�������ֵ�ǣ�'+data);
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
                            <label class="col-md-2 control-label">Ͷ��ʱ��</label>
                            <div class="col-md-10">
                               <input type="text" placeholder=" YY/mm/dd/ H:i:s" style="width: 35%;height:34px;margin-right: 0px;padding-right: 0px;" name="stat_time" class="layui-input1" id="test1"> &nbsp;&nbsp;-&nbsp;&nbsp;
                                <input type="text" placeholder="  YY/mm/dd/ H:i:s" style="width: 35%;height:34px;" name="end_time" class="layui-input1" id="test2">
                            </div>
                          </div> -->

                          <!-- ʱ����js���� start -->
                          <script> 
                            layui.use('laydate', function(){
                              var laydate = layui.laydate;
                              
                              //ִ��һ��laydateʵ��
                              laydate.render({
                                elem: '#test1' //ָ��Ԫ��
                                ,type: 'datetime'
                              });
                            });
                             layui.use('laydate', function(){
                              var laydate = layui.laydate;
                              
                              //ִ��һ��laydateʵ��
                              laydate.render({
                                elem: '#test2' //ָ��Ԫ��
                                ,type: 'datetime'
                              });
                            });
                          </script>
                           <!-- ʱ����js���� end -->
                          <div class="form-group">
                            <label class="col-sm-2 control-label">��Ӵ�������</label>
                            <div class="col-sm-10">
                              <select class="form-control con" onchange="id_con()" name="creative_material_mode">
                                <option value="�����ͼ">�����ͼ</option>
                                <option value="��ͼ">��ͼ</option>
                                <option value="Сͼ">Сͼ</option>
                                <option value="��ͼ��ͼ">��ͼ��ͼ</option>
                                <option value="�����Ƶ">�����Ƶ</option>
                                <option value="������Ƶ">������Ƶ</option>
                              </select>
                            </div>
                            <!-- ͼƬ/��Ƶ -->
                            <div style="width: 80%;height: 300px;margin-left: 18.3%" >
                            <table style="" class="table-responsive table" id="tb">
                            	<tr>
                            		<td class="title_f">�����ͼ</td>
                            	</tr>
                            	<tr>
                            		<td style="width: 100px;">
                            			�������  
                            		</td>
                            		<td><input type="text" class="form-control" name="title_list"></td>
                            	</tr>
                            	<tr>
                            		<td>
                            			��������
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
                            <label class="col-md-2 control-label" for="example-email" >��Դ</label>
                            <div class="col-md-10">
                              <input id="example-email" name="source" class="form-control" placeholder="" type="text">
                            </div>
                          </div>
                          
                       


                          <div class="form-group m-b-0" id="an" >
                           <input type="submit" class="layui-btn layui-btn-danger" onclick="history.go(-1)" value="����" style="float: right;margin-right: 12px;background-color:#aaa">
                            <div class="col-sm-offset-3 col-sm-9" style="margin-left:16.5%;">
                              <input type="submit" class="btn btn-primary" name="goon" value="�������">
                              <input type="submit" class="btn btn-primary" name="yes" value="ȷ��">

                            </div>
                        </div>
                          
                        </form>
                   </div>
                  </div>
              </div>
             <!--End row-->
{include file="common/foot.php"}