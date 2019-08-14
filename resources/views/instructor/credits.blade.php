@extends('layouts.backend.index')
@section('content')
<style type="text/css">
    .total-credit h5{
        color: #76838f;
        display: contents;
        font-weight: 500;
    }
    .total-credit .badge
    {
        padding: .4rem .8rem;
        font-size: 1rem;
    }
</style>
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Credits</li>
  </ol>
  <h1 class="page-title">Credits</h1>
</div>

<div class="page-content">

<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <button class="btn btn-success btn-sm" data-target="#withdrawModal" data-toggle="modal" type="button"><i class="icon wb-pencil" aria-hidden="true"></i> Withdraw Request</button>

            </div>
            <div class="panel-actions total-credit">
                <h5>AVAILABLE CREDITS:</h5> 
                <span class="badge badge-danger">$ {{ Auth::user()->instructor->total_credits }}</span>
            </div>
        </div>
        
        <div class="panel-body">
          <table class="table table-hover table-striped w-full">
            <thead>
              <tr>
                <th>Sl.no</th>
                <th>User</th>
                <th>Category</th>
                <th>Course</th>
                <th>Credit</th>
                <th>Credited on</th>
              </tr>
            </thead>
            <tbody>
              @foreach($credits as $credit)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $credit->user->first_name.' '.$credit->user->last_name }}</td>
                <td>{{ $credit->course->category->name }}</td>
                <td>{{ $credit->course->course_title }}</td>
                <td>{{ $credit->credit }}</td>
                <td>{{ $credit->created_at->format('d/m/Y h:i A') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          <div class="float-right">
            {{ $credits->links() }}
          </div>
          
          
        </div>
      </div>
      <!-- End Panel Basic -->
</div>



<!-- Modal -->
<div class="modal fade" id="withdrawModal" aria-hidden="true" aria-labelledby="withdrawModal"
  role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
  <form method="POST" action="{{ route('instructor.withdraw.request') }}" id="withdrawForm">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Withdraw Request</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="form-control-label">PayPal ID <span class="required">*</span></label>
                    <input type="text" class="form-control" name="paypal_id" 
                        placeholder="PayPal ID" />
                </div>
                <div class="form-group col-md-12">
                    <label class="form-control-label">Amount <span class="required">*</span></label>
                    <input type="number" class="form-control" name="amount" 
                        placeholder="Amount" />
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- End Modal -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function()
{ 
    $("#withdrawForm").validate({
        rules: {
            paypal_id: {
                required: true,
                email: true
            },
            amount: {
                required: true,
                min: {{ Sitehelpers::get_option('settingGeneral', 'minimum_withdraw') }},
                max: {{ Auth::user()->instructor->total_credits }},
            }
        },
        messages: {
            paypal_id: {
                required: 'The PayPal ID field is required.',
                email: 'The PayPal ID should be valid email address'
            },
            amount: {
                required: 'The amount field is required.',
                min: "The minimum withdraw amount should be {{ Sitehelpers::get_option('settingGeneral', 'minimum_withdraw') }}",
                max: 'The amount should not exceed the available credits'
            }
        }
    });
});
</script>
@endsection