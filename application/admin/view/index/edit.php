{include file="common/header.php"}
 
<!--Start row-->
             <div class="row">
                 <div class="col-md-12">
                   <div class="white-box">
                     <h2 class="header-title">Select Fields</h2>
                       
                        <form action="{:url('update')}" class="form-horizontal">
                          <div class="form-group">
                            <label class="col-md-2 control-label">广告主ID</label>
                            <div class="col-md-10">
                              <input class="form-control" name="advertiser_id" value="{$data.advertiser_id}" type="text" readonly="">
                              <input type="hidden" name="id" value="{$data.id}">
                            </div>
                          </div>
                          
                        
	                     <div class="form-group">
	                            <label class="col-sm-2 control-label">推广目的</label>
	                            <div class="col-sm-10">
	                              <select class="form-control" name="landing_type">
	                                <option value="1" {if condition="$data.landing_type eq 1"} selected {/if}>1--应用推广</option>
	                                <option value="2" {if condition="$data.landing_type eq 2"} selected {/if}>2--销售线索收集</option>
	                                <option value="3" {if condition="$data.landing_type eq 3"} selected {/if}>3--抖音号推广</option>
	                                <option value="4" {if condition="$data.landing_type eq 4"} selected {/if}>4--门店推广</option>
	                                <option value="5" {if condition="$data.landing_type eq 5"} selected {/if}>5--产品目录推广</option>
	                                <option value="6" {if condition="$data.landing_type eq 6"} selected {/if}>6--电商店铺推广</option>
	                                <option value="7" {if condition="$data.landing_type eq 7"} selected {/if}>7--头条文章推广</option>
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
                              <input class="form-control" name="campaign_name" placeholder="Helping text" value="{$data.campaign_name}" type="text">
                              <input type="hidden" name="modify_time" value="{$data.modify_time}">
                              <input type="hidden" name="campaign_id" value="{$data.campaign_id}">
                              <input type="hidden" name="budget_mode" value="{$data.budget_mode}">
                              <span class="help-block"></span> </div>
                          </div>
                          
                           <div class="form-group">
                            <label class="col-md-2 control-label">广告预算</label>
                            <div class="col-md-10">
                            	<div class="layui-btn-group">
								  <button type="button" class="layui-btn" name="bx" value="bx" onclick="st()">不限</button>
								  <button type="button" class="layui-btn" id="zdys" name="zdys" value="" onclick="yy()">指定预算</button>
								</div>
 								<input class="form-control ys" name="budget" value="{$data.budget}" style="display: none;margin-top: 5px;" placeholder="请输入广告组预算，不低于1000.00元，不超过9999999.99元" type="text" >
                             
                            </div> 
                            <input class="form-control" value="1" name="bx" id="hid" type="hidden" >
                          </div>
                          
                          <div class="form-group m-b-0" id="an" >
                            <div class="col-sm-offset-3 col-sm-9" style="margin-left:16.5%;">
                            	<input type="submit" class="btn btn-primary" name="goon" value="修改">
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