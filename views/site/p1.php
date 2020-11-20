<?php

/* @var $this yii\web\View */

$this->title = 'P1 Shift';
?>
 
<!-- Begin page -->
<div id="wrapper">
	<div id="jg-div-20">
		<!-- ============================================================== -->
		<!-- Start Content here -->         			
		<!-- ============================================================== -->
		<div>
			<!-- Page Heading Start -->
			<div class="row" style="margin-right: -1px;">
				<!-- <h1>P1 Shifts</h1> -->
				<button data-modal="md-3d-slit" class="btn btn-default md-trigger pull-right"><i class="icon-user-add"></i>  Add New Manager / Engineer</button>
			</div>
			
			<div class="row" style="margin-left: 1px; margin-bottom: 10px;">
				<ul id="demo2" class="nav nav-tabs">
					<?php foreach($support_group as $key => $val) : ?>
						<?php
							$tab_class = "";
							if($val->sort == 1)
								$tab_class = "active";
						?>
						<li class="<?= $tab_class ?>">
							<a style="border: 1px solid #ccc; border-bottom-color: transparent;" href="#<?= $val->tab_name ?>" data-toggle="tab"><?= $val->name ?></a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			
			
			
			<div class="row">
				
				
					
				<div class="tab-content tab-boxed pull-right" style="width:98%;">
					
					<?php foreach($support_group as $key => $val) : ?>
					<?php
						$tab_class = "";
						$ul = "ul-".$val->tab_name;
						if($val->sort == 1)
							$tab_class = "active in";
					?>
				
					<div class="tab-pane fade <?= $tab_class ?>" id="<?= $val->tab_name ?>">
						
						<ul id="<?= $ul ?>" class="nav nav-tabs nav-simple">
						<?php foreach($region as $key_reg => $val_reg) : ?>
							<?php
								$tab_support_region = $val->tab_name."-".strtolower($val_reg->name);
								$tab_region_class = "";
								if($val_reg->sort == 1)
									$tab_region_class = "active";
								
							?>
							<li class="<?= $tab_region_class ?>">
								<a href="#<?= $tab_support_region ?>" data-toggle="tab"><?= $val_reg->name ?></a>
							</li>
						<?php endforeach ?>
						</ul>
						
						
						<div class="tab-content">
							
							<?php foreach($region as $key_reg => $val_reg) : ?>
							<?php
								$tab_support_region = $val->tab_name."-".strtolower($val_reg->name);
								$tab_region_class = "";
								if($val_reg->sort == 1)
									$tab_region_class = "active in";
								
							?>
							
							<div class="tab-pane fade <?= $tab_region_class ?>" id="<?= $tab_support_region ?>">
								<div class="col-md-12" style="margin-top: 10px;">				
									<div class="widget" style="margin-left: -15px;">
										
										<?php foreach($support_group_shift as $key_grp_shift => $val_grp_shift) : ?>
										<?php if($val_grp_shift->support_group_id == $val->id && $val_grp_shift->region_id == $val_reg->id):?>
											
											<?php $table_id = "table-".$val->tab_name.strtolower($val_reg->name).$val_grp_shift->id; ?>
											
											<div class="widget-header" id="jg-td-peach">
												
												<?php $shift_header = $val_reg->name." ".$val->name. " ".$val_grp_shift->name." | "; ?>
												<?php foreach($support_group_shift_zone as  $key_grp_shift_zone => $val_grp_shift_zone) : ?>
												<?php if($val_grp_shift->support_group_id == $val_grp_shift_zone["support_group_id"] && $val_grp_shift->region_id == $val_grp_shift_zone["region_id"] && $val_grp_shift->id == $val_grp_shift_zone["support_group_shift_id"]):?>
														<?php $shift_header .= $val_grp_shift_zone["zone_name"]." | "; ?>
												<?php endif ?>
												<?php endforeach ?>
												
												<h2><strong><?= $shift_header ?></strong></h2>
												<div class="additional-btn">
													<a href="#" class="reload"><i class="icon-ccw-1"></i></a>
												</div>
											</div>
											
											
											
											
											<div class="widget-content">
												<div class="table-responsive">
													<!-- <table data-sortable class="table table-striped table-bordered table-hover"> -->
													<table id="<?= $table_id ?>" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th id="jg-th-light-silver">Engineer</th>
																<th id="jg-th-light-silver">Phone Number</th>
																<th id="jg-th-light-silver">Status</th>
																<th id="jg-th-light-silver">Unavailable (Date/Reason)</th>
																<th id="jg-th-light-silver">Month Total</th>
																<th id="jg-th-light-silver">Week of
																<select id="p1_date">
																	   <?php foreach($weeks as $key_wks => $val_wks) : ?>
																			<?php if ($val_wks->date == $splunk_date["date"]): ?>
																				<option value="<?= $val_wks->date ?>" selected><?= $val_wks->spldate ?></option>
																			<?php else: ?>
																				<option value="<?= $val_wks->date ?>"><?= $val_wks->spldate ?></option>
																			<?php endif; ?>
																	   <?php endforeach ?>
																	</select>
																</th>
																
																<th id="jg-th-light-silver">Missed Calls</th>
																<th id="jg-th-light-silver">Action</th>
															</tr>
														</thead>
														
														<tbody>
															
															<?php $engr_count = 0; ?>
															<?php foreach($accounts as $key_acct => $val_acct) : ?>
																<?php if($val->id == $val_acct->support_group_id && $val_reg->id == $val_acct->region_id && $val_grp_shift->id == $val_acct->support_group_shift_id):?>
																	<?php $engr_count++; ?>
																<?php endif; ?>
															<?php endforeach ?>
															
															<?php foreach($accounts as $key_acct => $val_acct) : ?>
															
															<?php if($val->id == $val_acct->support_group_id && $val_reg->id == $val_acct->region_id && $val_grp_shift->id == $val_acct->support_group_shift_id):?>
															<?php
																$shift_engr = "shift_engr".$val_acct->id;
																$shift_phone = "shift_phone".$val_acct->id;
																$shift_status = "shift_status".$val_acct->id;
																$shift_sort = "shift_sort".$val_acct->id;
																$shift_msg = "shift_msg".$val_acct->id;
																$shift_action = "shift_action".$val_acct->id;
																$shift_answered = "shift_answered".$val_acct->id;
																$shift_missed = "shift_missed".$val_acct->id;
																$shift_day_abr = "shift_day_abr".$val_acct->id;
																$shift_msg_input = "shift_msg_input".$val_acct->id;
															?>
															
															<tr>
																<?php if($val_acct->status_p1 == 1):?>
																	<td>
																		<?php if ($session_isadmin == 1): ?>
																			<select id="<?= $shift_sort ?>" onChange="javascript:changeSort();">
																				<?php for($x=1; $x<=$engr_count; $x++) : ?>
																					<?php if ($val_acct->sort_rotate == $x): ?>
																						<option value="<?= $x ?>" selected><?= $x ?></option>
																					<?php else: ?>
																						<option value="<?= $x ?>"><?= $x ?></option>
																					<?php endif; ?>
																				<?php endfor ?>
																			</select>
																		<?php endif; ?>
																		<a href="<?= $val_acct->slack_url ?>" target="slack_win" id="<?= $shift_engr ?>"><strong><?= $val_acct->full_name ?></strong></a>
																	</td>
																	<td><a href="dialpad:<?= $val_acct->phone ?>|1"><span id="<?= $shift_phone ?>" style="color:blue;"><span class="glyphicon glyphicon-earphone"></span> <?= $val_acct->phone ?></span></a></td>	
																	<td><input id="<?= $shift_status ?>" onChange="doShift(<?= $val_acct->id ?>,0);" type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" checked /></td>
																	<td><span id="<?= $shift_msg ?>"><strong></strong></span></td>
																	<td><span id="<?= $shift_answered ?>"><strong><?= $total_shifts[$val_acct->id]["total_answered"] ?></strong></span></td>
																	<td><span id="<?= $shift_day_abr ?>"><strong><?= $total_shifts[$val_acct->id]["days_answered"] ?></strong></span></td>
																	<td><span id="<?= $shift_missed ?>"><strong><?= $total_shifts[$val_acct->id]["days_missed"] ?></strong></span></td>
																	<td>
																			
																			<select id="<?= $shift_action ?>" onChange="javascript: rotateAssign(<?= $val_acct->id ?>,'<?= $table_id ?>');">
																			<option value="0">-- Select</option>
																			<option value="1">Answered Call</option>
																			<option value="2">Missed Call</option>
																			<option value="3">Reset</option>
																			</select>
																	</td>
																<?php else:?>
																	<td>
																		<?php if ($session_isadmin == 1): ?>
																			<select id="<?= $shift_sort ?>" onChange="javascript:changeSort();">
																				<?php for($x=1; $x<=$engr_count; $x++) : ?>
																					<?php if ($val_acct->sort_rotate == $x): ?>
																						<option value="<?= $x ?>" selected><?= $x ?></option>
																					<?php else: ?>
																						<option value="<?= $x ?>"><?= $x ?></option>
																					<?php endif; ?>
																				<?php endfor ?>
																			</select>
																		<?php endif; ?>
																		<a style="color:red;" href="<?= $val_acct->slack_url ?>" target="slack_win" id="<?= $shift_engr ?>"><strong><?= $val_acct->full_name ?></strong></a>
																	</td>
																	<td style="color:red;"><a href="dialpad:<?= $val_acct->phone ?>|1"><span id="<?= $shift_phone ?>" style="color:red;"><span class="glyphicon glyphicon-earphone"></span><strong> <?= $val_acct->phone ?></strong></span></a></td>
																	<td><input id="<?= $shift_status ?>" onChange="doShift(<?= $val_acct->id ?>,0);" type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" /></td>
																	<!-- <td style="color:red;"><span id="<?= $shift_msg ?>"><strong><?= $val_acct->support_message ?></strong></span></td> -->
																	<td style="color:red;"><span id="<?= $shift_msg ?>"><input style="width: 100%; color:red; font-weight:bold; padding: 0px; margin-bottom: -5px;margin-top: -5px; background: transparent;border: none;" onBlur="doShift(<?= $val_acct->id ?>, 1);" type="text" class="form-control" id="<?= $shift_msg_input ?>" value="<?= $val_acct->support_message ?>" placeholder="If marking yourself unavailable, fill this field."></span></td>
																
																	<td style="color:red;"><span id="<?= $shift_answered ?>"><strong><?= $total_shifts[$val_acct->id]["total_answered"] ?></strong></span></td>
																	<td style="color:red;"><span id="<?= $shift_day_abr ?>"><strong><?= $total_shifts[$val_acct->id]["days_answered"] ?></strong></span></td>
																	<td style="color:red;"><span id="<?= $shift_missed ?>"><strong><?= $total_shifts[$val_acct->id]["days_missed"] ?></strong></span></td>
																	<td>
																			
																			<select disabled id="<?= $shift_action ?>" onChange="javascript: rotateAssign(<?= $val_acct->id ?>,'<?= $table_id ?>');">
																			<option value="0">-- Select</option>
																			<option value="1">Answered Call</option>
																			<option value="2">Missed Call</option>
																			<option value="3">Reset</option>
																			</select>
																	</td>
																<?php endif ?>
															</tr>
															<?php endif ?>
															<?php endforeach ?>
															
																												
															
															
														</tbody>
													</table>
												</div>
											</div> <!-- widget-content -->
									
										<?php endif ?>
										<?php endforeach ?>		
									</div> <!-- widget -->
								</div>
							
							
							</div> <!-- / .tab-pane region -->
							
							
							
							
							<?php endforeach ?> <!-- region loop -->
							
						</div> <!-- / .tab-content -->
					
						
					</div> <!-- end tab-suport group -->
					<?php endforeach ?><!-- support_group loop -->
					
						
									
					
					
					
				</div> <!--tab-content tab-boxed pull-right -->
				
				
			</div>				
		
						


				
		</div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

	</div>
		<!-- End right content -->
</div>
	
<!-- Modal Start -->

<div class="md-modal md-3d-slit" id="md-3d-slit">
	<div class="md-content">
		<div class="widget">
			
			<div align="center" class="widget-header transparent">
				<h2><strong>Add New Manager / Engineer</strong></h2>
				<!--
				<div class="additional-btn">
					<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
					<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
				</div>
				-->
			</div>
			<div class="widget-content padding">
				<form role="form">
				  <div class="form-group">
					<label for="input-text" class="col-sm-2 control-label" id="jg-margin-top-input">Email</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="p1_email" placeholder="Enter Email">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="input-text" class="col-sm-2 control-label" id="jg-margin-top-input">Name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="p1_name" placeholder="Enter Name">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="input-text" class="col-sm-2 control-label" id="jg-margin-top-input">Phone</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="p1_phone" placeholder="Enter Phone">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="input-text" class="col-sm-2 control-label" id="jg-margin-top-input">Slack</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="p1_slack_url" placeholder="Slack ID so that CSI can optionally DM user directly from this Web App">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label class="col-sm-2 control-label" id="jg-margin-top-input">Role</label>
					<div class="col-sm-10">
						<select class="form-control" id="p1_roles" onChange="javascript:changeRole();">
							<option value="">-- Select --</option>
						<?php foreach($roles as $key => $val) : ?>
							<option value="<?= $val->id ?>"><?= $val->name ?></option>
					    <?php endforeach ?>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label class="col-sm-2 control-label" id="jg-margin-top-input">Timezone</label>
					<div class="col-sm-10">
						<select class="form-control" id="p1_timezone">
							<option value="">-- Select --</option>
						<?php foreach($timezones as $key => $val) : ?>
							<option value="<?= $val->zone_id ?>"><?= $val->zone_name ?></option>
					    <?php endforeach ?>
						</select>
					</div>
				  </div>
				  
				  
				  <div class="form-group">
					<label class="col-sm-2 control-label" id="jg-margin-top-input">Region</label>
					<div class="col-sm-10">
						<select class="form-control" id="p1_region" onChange="javascript:retrieveShift();">
							<option value="">-- Select --</option>
						<?php foreach($region as $key => $val) : ?>
							<option value="<?= $val->id ?>"><?= $val->name ?></option>
					    <?php endforeach ?>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group" id="div_sg_engr" style="display:;">
					<label class="col-sm-2 control-label">Support Group</label>
					<div class="col-sm-10">
						<select class="form-control" id="p1_support_group_engr" onChange="javascript:retrieveShift();">
							<option value="">-- Select --</option>
						<?php foreach($support_group as $key => $val) : ?>
							<option value="<?= $val->id ?>"><?= $val->name ?></option>
					    <?php endforeach ?>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group" id="div_sg_mngr" style="display:none;">
					<label class="col-sm-2 control-label">Support Group</label>
					<div class="col-sm-10">
						<select multiple class="form-control" id="p1_support_group_mngr" name="p1_support_group_mngr[]">
						<?php foreach($support_group as $key => $val) : ?>
							<option value="<?= $val->id ?>"><?= $val->name ?></option>
					    <?php endforeach ?>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group" id="div_shift" style="display:none;">
					<label class="col-sm-2 control-label" id="jg-margin-top-input">Shift</label>
					<div class="col-sm-10">
						<select class="form-control" id="p1_support_group_shift">
						</select>
					</div>
				  </div>
				
				
				<!-- </form>-->
				
			</div>
			
			<div align="center" class="widget-content padding" id="div_p1_msg" style="display:none;">
				<p id="p1_msg"></p>
			</div>
			
			<div align="center" class="widget-content padding">
			<button class="btn btn-danger md-close">Close</button>
			<button class="btn btn-info md-reset" type="reset">Reset</button>
			<!-- <button class="btn btn-info md-reset" value="Reset">Reset</button> -->
			<button class="btn btn-success md-close" onClick="javascript:addP1Shift();">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
			</div>
			</form>
		</div>
		
	</div><!-- End div .md-content -->
</div><!-- End div .md-modal .md-3d-slit -->
		
<!-- Modal End -->
	
<!-- End of page -->
<!-- the overlay modal element -->
<div class="md-overlay"></div>
<!-- End of eoverlay modal -->
	