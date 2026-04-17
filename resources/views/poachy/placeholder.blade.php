@extends('layouts.poachy')

@section('content')
<section class="page">
    <div class="card coming">
        <div>
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
            <button class="btn-alt">Coming Soon</button>
        </div>
    </div>
</section>
@endsection
