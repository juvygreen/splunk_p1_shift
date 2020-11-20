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
					
					
					<div class="tab-pane fade active in" id="tab-cloud">
						
						<ul id="demo5" class="nav nav-tabs nav-simple">
							<li class="active">
								<a href="#tab-cloud-emea" data-toggle="tab">EMEA</a>
							</li>
							<li class="">
								<a href="#tab-cloud-amer" data-toggle="tab">AMER</a>
							</li>
							<li class="">
								<a href="#tab-cloud-apac" data-toggle="tab">APAC</a>
							</li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab-cloud-emea">
								<div class="col-md-12" style="margin-top: 10px;">				
									<div class="widget" style="margin-left: -15px;">
										<div class="widget-header" id="jg-td-peach">
											<h2><strong>AMER P1 Cloud Shift A   |  AST 10am - 1pm | UK 2pm - 5pm | EST 9am - 12pm | CST 8am - 11am | PST 6am - 9am | HKT 10pm - 1am |</strong></h2>
											<div class="additional-btn">
												<a href="#" class="reload"><i class="icon-ccw-1"></i></a>
											</div>
										</div>
										<div class="widget-content">
											<div class="table-responsive">
												<table data-sortable class="table table-hover">
													<thead>
														<tr>
															<th id="jg-th-light-silver">Engineer</th>
															<th id="jg-th-light-silver">Phone Number</th>
															<th id="jg-th-light-silver">Status</th>
															<th id="jg-th-light-silver">Unavailable (Date/Reason)</th>
															<th id="jg-th-light-silver">Month Total</th>
															<th id="jg-th-light-silver">Missed Calls</th>
															<!--
															<th id="jg-th-light-silver">Week of <input id="jg-input-narrow" type="text" class="datepicker-input" data-mask="99/99/9999" placeholder="<?= $splunk_date["spldate"] ?>"></th>
															-->
															<th id="jg-th-light-silver">Week of
															<select id="p1_date">
																   <?php foreach($weeks as $key => $val) : ?>
																		<?php if ($val->date == $splunk_date["date"]): ?>
																			<option value="<?= $val->date ?>" selected><?= $val->spldate ?></option>
																		<?php else: ?>
																			<option value="<?= $val->date ?>"><?= $val->spldate ?></option>
																		<?php endif; ?>
																   <?php endforeach ?>
																</select>
															</th>
															
															<th id="jg-th-light-silver">Action</th>
														</tr>
													</thead>
													
													<tbody>
														<tr>
															<td id="shift_engr1"><strong>John Doe</strong></td>
															<td><a href="dialpad:+15555555555|1"><span id="shift_phone1" style="color:blue;"><span class="glyphicon glyphicon-earphone"></span> +1 (555) 555-5555</span></a></td>
															<td><input id="shift_status1" onChange="doShift(1);" type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" checked /></td>
															<td><span id="shift_msg1"></span></td>
															<td></td>
															<td></td>
															<td></td>
															<td>
																	
																	<select id="shift_action1">
																	<option>-- Select</option>
																	<option>Answered Call</option>
																	<option>Missed Call</option>
																	<option>Reset</option>
																	</select>
																
																	
																	<!--
																	<div class="btn-group">
																		<button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
																		  <i class="fa fa-cog"></i> Action <span class="caret"></span>
																		</button>
																		
																		<ul class="dropdown-menu info" role="menu">
																		  <li><a href="#">Answered Call</a></li>
																		  <li><a href="#">Missed Call</a></li>
																		  <li><a href="#">Reset</a></li>
																	  </ul>
																	</div>
																	-->
															</td>
														</tr>
														<tr>
															<td id="shift_engr2"><strong>John Doe</strong></td>
															<td><a href="dialpad:+15555555555|1"><span id="shift_phone2" style="color:blue;"><span class="glyphicon glyphicon-earphone"></span> +1 (555) 555-5555</span></a></td>
															<td><input id="shift_status2" onChange="doShift(2);" type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" checked /></td>
															<td><span id="shift_msg2"></span></td>
															<td></td>
															<td></td>
															<td></td>
															<td>
																	<select id="shift_action2">
																	<option>-- Select</option>
																	<option>Answered Call</option>
																	<option>Missed Call</option>
																	</select>
															</td>
														<tr>
															<td id="shift_engr3"><strong>John Doe</strong></td>
															<td><a href="dialpad:+15555555555|1"><span id="shift_phone3" style="color:blue;"><span class="glyphicon glyphicon-earphone"></span> +1 (555) 555-5555</span></a></td>
															<td><input id="shift_status3" onChange="doShift(3);" type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" checked /></td>
															<td><span id="shift_msg3"></span></td>
															<td></td>
															<td></td>
															<td></td>
															<td>
																	<select id="shift_action3">
																	<option>-- Select</option>
																	<option>Answered Call</option>
																	<option>Missed Call</option>
																	</select>
															</td>
														</tr>
														
														
														<!--
														<tr>
															<td>10</td><td><input type="checkbox" class="rows-check"></td><td><strong>Rusmanto</strong></td>
															<td>Bandung, Indonesia</td>
															<td><span class="label label-success">Active</span></td>
														</tr>
														-->
													</tbody>
												</table>
											</div>
										</div> <!-- widget-content -->
									</div> <!-- widget -->
								</div>
							
							
							</div> <!-- / .tab-pane -->
							
							
							<div class="tab-pane fade" id="tab-cloud-amer">
								<span>Under Construction</span>
							</div> <!-- / .tab-pane -->
							
							<div class="tab-pane fade" id="tab-cloud-apac">
								<span>Under Construction</span>
							</div> <!-- / .tab-pane -->
							
							
						</div> <!-- / .tab-content -->
					
					
					</div> <!-- end tab-cloud -->
					
					
						
					<div class="tab-pane fade" id="tab-onprem">
						<span>Under Construction</span>
						
						
					</div>
					
					<div class="tab-pane fade" id="tab-phantom">
						<!-- <div class="col-md-12">	-->
							
							<ul id="demo5" class="nav nav-tabs nav-simple">
								<li class="active">
									<a href="#tab-phantom-emea" data-toggle="tab">EMEA</a>
								</li>
								<li class="">
									<a href="#tab-phantom-amer" data-toggle="tab">AMER</a>
								</li>
								<li class="">
									<a href="#tab-phantom-apac" data-toggle="tab">APAC</a>
								</li>
							</ul>
							
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab-phantom-emea">
									<div class="col-md-12" style="margin-top: 10px;">				
										<div class="widget" style="margin-left: -15px;">
											<div class="widget-header" id="jg-td-peach">
												<h2><strong>AMER P1 Cloud Shift A   |  AST 10am - 1pm | UK 2pm - 5pm | EST 9am - 12pm | CST 8am - 11am | PST 6am - 9am | HKT 10pm - 1am |</strong></h2>
												<div class="additional-btn">
													<a href="#" class="reload"><i class="icon-ccw-1"></i></a>
												</div>
											</div>
											<div class="widget-content">
												
											</div>
										</div>
									</div>
								
								
								</div> <!-- / .tab-pane -->
								
								
								<div class="tab-pane fade" id="tab-phantom-amer">
									<span>Under Construction</span>
								</div> <!-- / .tab-pane -->
								
								<div class="tab-pane fade" id="tab-phantom-apac">
									<span>Under Construction</span>
								</div> <!-- / .tab-pane -->
								
								
							</div> <!-- / .tab-content -->
								
								
						<!-- </div>-->
					</div>
					
					<div class="tab-pane fade" id="tab-uba">
						<div class="col-md-12">	
							<span>Under Construction</span>
						</div>
					</div>
					
					<div class="tab-pane fade" id="tab-premium-cloud">
						<div class="col-md-12">	
							<span>Under Construction</span>
						</div>
					</div>
					
					<div class="tab-pane fade" id="tab-premium-onprem">
						<div class="col-md-12">	
							<span>Under Construction</span>
						</div>
					</div>
					
					<div class="tab-pane fade" id="tab-weekend-call">
						<div class="col-md-12">	
							<span>Under Construction</span>
							<div class="panel-group accordion-toggle" id="accordiondemo3">
								<div class="panel panel-lightblue-2">
									<div class="panel-heading">
									  <h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordiondemo3" href="#accordion7">
										  EMEA
										</a>
									  </h4>
									</div>
									<div id="accordion7" class="panel-collapse collapse in">
									  <div class="panel-body">
										<div class="col-md-12">				
											<div class="widget">
												<div class="widget-header" id="jg-td-peach">
													<h2><strong>AMER P1 Cloud Shift A   |  AST 10am - 1pm | UK 2pm - 5pm | EST 9am - 12pm | CST 8am - 11am | PST 6am - 9am | HKT 10pm - 1am |</strong></h2>
													<div class="additional-btn">
														<a href="#" class="reload"><i class="icon-ccw-1"></i></a>
													</div>
												</div>
												<div class="widget-content">
													
												</div>
											</div>
										</div>
									  </div>
									</div>
								</div>
							  <div class="panel panel-lightblue-2">
								<div class="panel-heading">
								  <h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordiondemo3" href="#accordion8">
									  AMER
									</a>
								  </h4>
								</div>
								<div id="accordion8" class="panel-collapse collapse">
								  <div class="panel-body">
									Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								  </div>
								</div>
							  </div>
							  <div class="panel panel-lightblue-2">
								<div class="panel-heading">
								  <h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordiondemo3" href="#accordion9">
									  APAC
									</a>
								  </h4>
								</div>
								<div id="accordion9" class="panel-collapse collapse">
								  <div class="panel-body">
									Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								  </div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				
					
					
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
	