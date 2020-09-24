@if(count($errors) > 0)
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Whoops!</h4><small>Please correct these errors to continue</small>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{!! $error !!}</li>
      @endforeach
    </ul>
  </div>
@endif
@if(Session::has('success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Success</h4>
    {{ Session::get('success') }}
  </div>
@endif

@if(Session::has('error'))
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-times"></i> Whoops!<h4>
    {{ Session::get('error') }}
  </div>
@endif
