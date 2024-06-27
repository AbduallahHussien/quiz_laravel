<link rel="stylesheet" href="{{ URL::asset('resources/frontend/global/toastr/toastr.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('resources/frontend/default/css/jquery.webui-popover.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('resources/frontend/default/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('resources/') }}" />
<link rel="stylesheet" href="{{ URL::asset('resources/') }}" />

<script src="{{ URL::asset('resources/frontend/default/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/popper.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/slick.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/jquery.webui-popover.min.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/default/js/main.js') }}"></script>
<script src="{{ URL::asset('resources/frontend/global/toastr/toastr.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>

<script src="{{ URL::asset('resources/') }}"></script>
<script src="{{ URL::asset('resources/') }}"></script>

@if (session('flash_message') != "")

<script type="text/javascript">
	toastr.success('{{session("flash_message")}}');
</script>

@endif

@if (session('error_message') != "")

<script type="text/javascript">
	toastr.error('{{session("error_message")}}');
</script>

@endif

@if (session('info_message') != "")

<script type="text/javascript">
	toastr.info('{{session("info_message")}}');
</script>

@endif
