@extends('layouts.app')

@section('content')

<main class="app-content col-12 col-md-9 col-lg-10 px-md-4 ms-auto">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Versions</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>

    <div class="card-glass">
        @if ($message = session('success'))
        <div class="alert alert-success mb-3">
            {{ $message }}
        </div>
        @elseif ($message = session('error'))
        <div class="alert alert-danger mb-3">
            {{ $message }}
        </div>
        @endif

        <form action="{{ url('/updateversion') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="platform">Platform:</label>
                <select id="platform" class="form-control" name="platform" onchange="updateVersionField()">
                    <option value="">Select OS</option>
                    <option value="android">android</option>
                    <option value="ios">ios</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="code">Version Code:</label>
                <input type="text" class="form-control" id="code" name="code">
            </div>
            <div class="col-md-6">
                <label for="name">Version Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="col-md-6">
                <label for="is_mandatory">Is Mandatory:</label>
                <input type="text" class="form-control" id="is_mandatory" name="is_mandatory">
            </div>
            <div class="col-md-6">
                <label for="is_quarter_started">Is Quarter Started:</label>
                <input type="text" class="form-control" id="is_quarter_started" name="is_quarter_started">
            </div>
            <div class="col-md-6">
                <label for="is_round16_completed">Is Round 16 Completed:</label>
                <input type="text" class="form-control" id="is_round16_completed" name="is_round16_completed">
            </div>
            <div class="col-md-6">
                <label for="eu_start_date">EURO CUP Start Date:</label>
                <input type="text" class="form-control" id="eu_start_date" name="eu_start_date">
            </div>
            <div class="col-md-6">
                <label for="eu_end_date">EURO CUP End Date:</label>
                <input type="text" class="form-control" id="eu_end_date" name="eu_end_date">
            </div>
            <div class="col-md-6">
                <label for="winner">Winner</label>
                <input type="text" class="form-control" id="winner" name="winner">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary mb-1">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function updateVersionField() {
            var platform = document.getElementById('platform').value;
            var code = document.getElementById('code');
            var name = document.getElementById('name');
            var isMandatory = document.getElementById('is_mandatory');
            var isQuarterStarted = document.getElementById('is_quarter_started');
            var isRound16Completed = document.getElementById('is_round16_completed');
            var winner = document.getElementById('winner');
            var eu_start_date = document.getElementById('eu_start_date');
            var eu_end_date = document.getElementById('eu_end_date');

            var androidVersion = "{{ $androidVersion }}";
            var iosVersion = "{{ $iosVersion }}";

            var androidName = "{{ $androidName }}";
            var iosName = "{{ $iosName }}";

            var androidIsMandatory = "{{ $androidIsMandatory }}";
            var iosIsMandatory = "{{ $iosIsMandatory }}";

            var androdIsQuarterStarted = "{{ $androdIsQuarterStarted }}";
            var iosIsQuarterStarted = "{{ $iosIsQuarterStarted }}";

            var androidisRound16Completed = "{{ $androdisRound16Completed }}";
            var iosisRound16Completed = "{{ $iosisRound16Completed }}";

            var androidWinner = "{{ $androidWinner }}";
            var iosWinner = "{{ $iosWinner }}";

            var android_eu_start_date = "{{ $androdEuroStartDate }}";
            var ios_eu_start_date = "{{ $iosEuroStartDate }}";

            var android_eu_end_date = "{{ $androdEuroEndDate }}";
            var ios_eu_end_date = "{{ $iosEuroEndDate }}";

            if (platform === 'android') {
                code.value = androidVersion;
                name.value = androidName;
                isMandatory.value = androidIsMandatory;
                isQuarterStarted.value = androdIsQuarterStarted;
                isRound16Completed.value = androidisRound16Completed;
                winner.value = androidWinner;
                eu_start_date.value=android_eu_start_date;
                eu_end_date.value=android_eu_end_date ;

            } else if (platform === 'ios') {
                code.value = iosVersion;
                name.value = iosName;
                isMandatory.value = iosIsMandatory;
                isQuarterStarted.value = iosIsQuarterStarted;
                isRound16Completed.value = iosisRound16Completed;
                winner.value = iosWinner;
                eu_start_date.value=ios_eu_start_date;
                eu_end_date.value=ios_eu_end_date ;

            } else {
                code.value = '';
                name.value = '';
                isMandatory.value = '';
                isQuarterStarted.value = '';
                isRound16Completed.value = '';
                winner.value = '';
                eu_start_date.value='';
                eu_end_date.value='';

            }
        }
    </script>

</main>

@endsection
