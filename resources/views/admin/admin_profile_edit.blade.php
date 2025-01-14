@extends('admin.admin_master') <!-- prin comenzile astea avem acces la tot css -->
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="container-full">
<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Admin Profile Edit</h4>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">
					<form method="post" action="{{ route('admin.profile.store')}}" enctype="multipart/form-data">
                    @csrf
					  <div class="row">
						<div class="col-12">	
                            
                        
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
								<h5>Admin Name: <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="text" name="name" class="form-control" required="" value="{{$editData->name}}">
                                </div>
							</div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
								<h5>Admin E-mail Info: <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="email" name="email" class="form-control" value="{{$editData->email}}">
                                </div>
							</div>
                            </div>
                        </div>
						
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
								<h5>Profile Image: <span class="text-danger">*</span></h5>
								<div class="controls">
									<input type="file" name="profile_photo_path" class="form-control" required="" id="image"> </div>
							</div>
                        </div>
                       
                        
                            <div class="col-md-6">
                               <img id="showImage" src="{{(!empty($adminData->profile_photo_path))?
                                url('upload/admin_images/'.$adminData->profile_photo_path):url('upload/no_image.jpg')}}" alt="User Avatar" style="
                                width:100px; height:100px;">
                            </div>
                        </div>
                        <div class="text-xs-right">
                                <button type="submit" class="btn btn-rounded btn-primary mb-5">Update</button>
                        </div>

		</section>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result) //cu aceasta functie vom afisa in dreapta imaginea pe care am selectato pentru update
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection