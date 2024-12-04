@extends('layouts.user_type.auth')
@section('css')
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f3f4f6;
        }

        .title, .title2, .title3 {
            font-size: 4rem;
            font-weight: bold;
            color: black;
            text-align: center;
            text-shadow: 2px 4px 6px rgba(0, 0, 0, 0.3);
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 4px solid black;
            animation: typing 3s steps(30, end), blink 0.5s step-end infinite, hideLine 3s forwards;
            margin: 10px 0;
        }

        .title2, .title3 {
            margin-left: 2px;
            padding: 2px;
        }

        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        @keyframes blink {
            from {
                border-color: black;
            }
            to {
                border-color: transparent;
            }
        }

        @keyframes hideLine {
            to {
                border-right: 0;
            }
        }
    </style>
    @endsection
@section('content')
    <body>
    <div class="title mt-10"> Welcome </div>
    <div class="title2"> to the </div>
    <div class="title3">  Car Part Management System</div>

    </body>
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

