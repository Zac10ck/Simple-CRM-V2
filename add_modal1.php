<!-- Add New -->

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="HandheldFriendly" content="true">

<!-- for responsivew -->

    <div class="modal fade" id="addnew1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Add New</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="addnew1.php">
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">date:</label>
						</div>
						<div class="col-lg-10">
							<input type="date" class="form-control" name="date">
						</div>
					</div>
					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">client:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="client">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">person:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="person">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">Designation:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="desig">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">phone:</label>
						</div>
						<div class="col-lg-10">
							<input type="number" class="form-control" name="phone">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">Email:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="email">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">activity:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="activity">
						</div>
					</div>

					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">Remark:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="remark">
						</div>
					</div>






					<div style="height:100%;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">Follow Up:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="followup">
						</div>
					</div>
                </div> 
				</div>


				
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
				</form>
                </div>
				
            </div>
        </div>
    </div>
