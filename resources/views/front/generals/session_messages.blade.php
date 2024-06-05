
@push('end-scripts')

<script>
@if(Session::has('success'))

toaster('success',"{{ Session::get('success') }}");
@elseif (Session::has('info'))
toaster('info',"{{ Session::get('info') }}");
@elseif(Session::has('error'))
toaster('error',"{{ Session::get('error') }}");
@endif
</script>
@endpush