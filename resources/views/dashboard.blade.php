@extends('layouts.user_type.auth')

@section('content')

@endsection

@push('dashboard')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#successMessage').fadeOut('slow');
                $('#errorMessage').fadeOut('slow');
                $('#warningMessage').fadeOut('slow');
                $('#infoMessage').fadeOut('slow');
                $('#errorMessages').fadeOut('slow');
            }, 1000);
        });
    </script>
@endpush

