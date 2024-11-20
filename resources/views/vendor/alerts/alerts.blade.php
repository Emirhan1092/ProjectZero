@if(session('success'))
    <div id="successMessage" class="alert alert-success" role="alert">
        <strong>{{ session('alert_message') }}</strong> <strong>{{ session('success') }}</strong>
    </div>
@endif

@if(session('error'))
    <div id="errorMessage" class="alert alert-danger" role="alert">
        <strong>Hata!</strong> {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div id="warningMessage" class="alert alert-warning" role="alert">
        <strong>Uyarı!</strong> {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div id="infoMessage" class="alert alert-info" role="alert">
        <strong>Bilgi!</strong> {{ session('info') }}
    </div>
@endif

@if($errors->any())
    <div id="errorMessages" class="alert alert-danger" role="alert">
        <strong>Hatalar:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
