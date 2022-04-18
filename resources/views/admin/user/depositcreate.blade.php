{!! Form::model($customers, ['id' => 'user_form', 'method' => 'PATCH','route' => ['user.update', $id]]) !!}
@csrf
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Add Deposit</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                     <i class="fas fa-minus"></i>
                     </button>
                  </div> 
               </div>
               <!-- /.card-header -->
               <!-- form start -->
               <div class="card-body">
                  <div class="form-group">
                     {!! Form::label('Select Customer', 'Select Customer') !!}
                     {!! Form::select('recustomer_id', $customers, $id, ['id' => 'recustomer_id', 'class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => "Select Customer",'disabled']) !!}
                  </div>
                   <div class="form-group">
                     {!! Form::label('Amount', 'Amount') !!}
                     {!! Form::text('amount','', ['id' => "amount", 'class' => 'form-control', 'placeholder' => "Enter Amount"]) !!}
                  </div>
               
                  
               </div>
                <div class="card-footer">
                  {!! Form::submit('save', ["class" => "btn btn-primary"]) !!}
                </div> 
               <!-- </form> -->
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
</section>
{!! Form::close() !!}


<!-- Main Content section end -->



