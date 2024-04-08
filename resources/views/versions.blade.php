@extends('layouts.app')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Versions</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>

    <div>



    @if ($message = session('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
    @elseif ($message = session('error'))
    <div class="alert alert-danger">
        {{ $message }}
    </div>
    @endif

    <form action="{{ url('/updateversion') }}" method="POST">
        @csrf
        <div class="form-group">
        <label for="platform">Platform:</label>
        <select id="platform" class="form-control" name="platform" onchange="updateVersionField()"> 
            <option value="">Select OS</option>
            <option value="android">android</option>
            <option value="ios">ios</option>
        </select>
        <br>
        <label for="code">Version Code:</label>
        <input type="text" class="form-control" id="code" name="code" required>
        <br>
        <label for="name">Version Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
        <br>
        <label for="is_mandatory">Is Mandatory:</label>
        <input type="text"  class="form-control" id="is_mandatory" name="is_mandatory" required>
        <br>
        <label for="is_quarter_started">Is Quarter Started:</label>
        <input type="text"  class="form-control" id="is_quarter_started" name="is_quarter_started" required>
        <br>
        <label for="kickoff_time">Kickoff Time:</label>
        <input type="datetime-local"  class="form-control" id="kickoff_time" name="kickoff_time" >
        <br>
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </form>

    <body>
    <script>
                function updateVersionField() {
                    var platform = document.getElementById('platform').value;
                    var code = document.getElementById('code');
                    var name = document.getElementById('name');
                    var isMandatory = document.getElementById('is_mandatory');
                    var isQuarterStarted = document.getElementById('is_quarter_started');

                    var androidVersion = "{{ $androidVersion }}";
                    var iosVersion = "{{ $iosVersion }}";

                    var androidName = "{{ $androidName }}";
                    var iosName = "{{ $iosName }}";

                    var androidIsMandatory  = "{{ $androidIsMandatory }}";
                    var iosIsMandatory = "{{ $iosIsMandatory }}";

                    var androdIsQuarterStarted  = "{{ $androdIsQuarterStarted }}";
                    var iosIsQuarterStarted = "{{ $iosIsQuarterStarted }}";



                    if (platform === 'android') {
                        code.value = androidVersion;
                        name.value = androidName;
                        isMandatory.value = androidIsMandatory;
                        isQuarterStarted.value=androdIsQuarterStarted;
                    } else if (platform === 'ios') {
                        code.value = iosVersion;
                        name.value = iosName;
                        isMandatory.value = iosIsMandatory;
                        isQuarterStarted.value=iosIsQuarterStarted;
                    } else {
                        code.value = '';
                        name.value = '';
                        isMandatory.value = '';
                        isQuarterStarted.value ='';
                    }
                }



                
            </script>
      
    </body>

</main>

@endsection