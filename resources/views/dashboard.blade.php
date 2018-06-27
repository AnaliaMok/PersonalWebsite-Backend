@extends('layouts.app')

@section('content')
<h2>This is the dashboard</h2>
{{-- <ul>
  @foreach($works as $work)
    <li>{{ $work['title'] }}  {{ $work['date'] }}</li>
  @endforeach
</ul> --}}
<div class="table">
  <ul class="table__row table__row--equal-half table__header">
    <li class="table__cell table__cell--header">Name</li>
    <li class="table__cell table__cell--header">Published On</li>
  </ul>
  @foreach($works as $work)
    <ul class="table__row table__row--equal-half">
      <li class="table__cell"><a href="{{ $work['slug'] }}">{{ $work['title'] }}</a></li>
      <li class="table__cell"><a href="{{ $work['slug'] }}">@php echo date_format(date_create($work['date']), 'F d, Y'); @endphp</a></li>
    </ul>
  @endforeach
</div>
@endsection