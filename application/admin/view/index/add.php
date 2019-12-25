{include file="common/header.php"}
 
<!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">Select Fields</h2>
                       
                        <form action="{:url('doadd')}" class="form-horizontal">
                          <div class="form-group">
                            <label class="col-md-2 control-label">广告主ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="{$advertiser_id}" type="text" readonly="">
                            </div>
                          </div>
                          
                        
	                     <div class="form-group">
	                            <label class="col-sm-2 control-label">推广目的</label>
	                            <div class="col-sm-10">
	                              <select class="form-control" name="landing_type">
                                  {volist name="data" id="vo"}
	                                <option value="{$vo.id}">{$vo.type_name}</option>
                                  {/volist}
	                              </select>
	                            </div>
	                          </div>
                          
                          <!-- <div class="form-group">
                            <label class="col-md-2 control-label">Disabled</label>
                            <div class="col-md-10">
                              <input class="form-control" disabled="" value="Disabled value" type="text">
                            </div>
                          </div> -->
                            
                          <div class="form-group">
                            <label class="col-sm-2 control-label">广告组名称</label>
                            <div class="col-sm-10">
                              <input class="form-control" name="name" placeholder="Helping text" type="text">
                              <span class="help-block"></span> </div>
                          </div>
                          
                           <div class="form-group">
                            <label class="col-md-2 control-label">广告预算</label>
                            <div class="col-md-10">
                            	<div class="layui-btn-group">
								  <button type="button" class="layui-btn" name="budget_mode" value="BUDGET_MODE_INFINITE" onclick="st()">不限</button>
								  <button type="button" class="layui-btn" id="zdys" name="zdys" value="" onclick="yy()">指定预算</button>
								</div>
 								<input class="form-control ys" name="budget" value="" style="display: none;margin-top: 5px;" placeholder="请输入广告组预算，不低于1000.00元，不超过9999999.99元" type="text" >
                             
                            </div> 
                            <input class="form-control" value="BUDGET_MODE_INFINITE" name="budget_mode" id="hid" type="hidden" >
                          </div>
                          
                          <div class="form-group m-b-0" id="an" >
                            <div class="col-sm-offset-3 col-sm-9" style="margin-left:16.5%;">
                            	<input type="submit" class="btn btn-primary" name="goon" value="继续添加">
                            	<input type="submit" class="btn btn-primary" name="next" value="下一步">
                            	<!-- <div class="layui-btn-group">
								  <button href="javascript:;" type="button" class="btn btn-primary" name="next" onclick="goon()">下一步</button>
								</div> -->
                              <!-- <button href="javascript:;" class="btn btn-primary" style="background-color: rgb(0,150,136);" onclick="goon()">继续添加</button> -->
                            </div>
                        </div>
                        </form>
                   </div>
                  </div>
              </div>
             <!--End row-->

             <script>
             	function yy(){
             		$('.ys').show();
             	}
             	function st(){
             		$('.ys').hide();
             	}
             	function goon(){
					window.location.href=''             		
             	}
             </script>
{include file="common/foot.php"}