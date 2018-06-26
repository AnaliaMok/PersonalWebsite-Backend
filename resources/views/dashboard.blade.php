@extends('layouts.app')

@section('content')
<h2>This is the dashboard</h2>
<ul>
  @foreach($works as $work)
    <li>{{ $work['name'] }}: {{ $work['date'] }}</li>
  @endforeach
</ul>
@endsection