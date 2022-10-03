@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Partner')

{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/ui/prism.min.css')}}">  
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">

{{-- sweetalert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 

@endsection

@section('content')

@if(auth()->user()->can('view partner')/* && $some_other_condition*/)
<section id="description" class="card">
    <div class="card-header">
        <h4 class="card-title">Dashboard Partner</h4>
    </div>
    <div class="card-body">
        <div class="card-text">
        {{-- batas table --}}
        <div class="table-responsive">
            <a href="{{ route('AddPartner') }}">
              <button type="button" class="btn btn-primary round"><i class="bx bx-plus-circle"></i> 
                Create Partner
              </button>
            </a>
            <table class="table yajra-datatable table-inverse table-hover" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Partner Name</th>
                  <th>Partner Address</th>
                  <th>Partner Number</th>
                  <th>Contact Person</th>
                  <th>Contact Person Number</th>
                  <th>First Email</th>
                  <th>Second Email</th>
                  <th>Partner Category</th>
                  <th>MOU Date</th>
                  <th>MOU Expired Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        {{-- batas table --}}
        </div>
    </div>
</section>
@else
<div class="col-xl-7 col-md-8 col-12">
    <div class="card bg-transparent shadow-none">
      <div class="card-body text-center">
        <img src="{{asset('images/pages/not-authorized.png')}}" class="img-fluid" alt="not authorized" width="400">
        <h1 class="my-2 error-title">You are not authorized!</h1>
        <p>
            You do not have permission to view this directory or page using
            the credentials that you supplied.
        </p>
        <a href="{{asset('/')}}" class="btn btn-primary round glow mt-2">BACK TO MAIN DASHBOARD</a>
      </div>
    </div>
</div>
@endif
<!--/ Description -->

<!--/ HTML Markup -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script> 
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>

<script type="text/javascript">

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

</script>

<script type="text/javascript">

 $(function () {  
    //datatable
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ShowPartner') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'pennama', name: 'pennama'},
            {data: 'penalamat', name: 'penalamat'},
            {data: 'pentlp', name: 'pentlp'},
            {data: 'pengcp', name: 'pengcp'},
            {data: 'pengcpno', name: 'pengcpno'},
            {data: 'pengemailsatu', name: 'pengemailsatu'},
            {data: 'pengemaildua', name: 'pengemaildua'},
            {data: 'katpengirimnama', name: 'katpengirimnama'},
            {data: 'pengmoudate', name: 'pengmoudate'},
            {data: 'pengmouexdate', name: 'pengmouexdate'},
            {
              data: 'action', 
              name: 'action' 
              // orderable: true, 
              // searchable: true
            },
        ]
    });


    // delete partner
    $(document).on('click', '.delPA', function () {
        var id = $(this).attr('data-id')
        Swal.fire({
          title: 'Are you sure delete this data ?',
          showCancelButton: true,
          confirmButtonText: 'Yes',
        }).then((result) => {
          if (result.isConfirmed) {
              if (id) {
                return fetch('{{route("delPA", ":id")}}'.replace(":id", id),{
                    method: 'DELETE',
                    headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).then(response => {
                    $('.yajra-datatable').DataTable().ajax.reload();
                    Swal.fire('Success!', '', 'success')
                    return response.json()
                }).catch(error => {
                    Swal.fire('Server Error', '', 'error')
                    console.log(error)
                })
            } else {
                Swal.fire('Server Error', '', 'error')
            }
          }
        })
    });
      
});
</script>
@endsection
