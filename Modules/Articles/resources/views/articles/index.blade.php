@extends('panel::layouts.master')

@section('title', 'Alle artikelen')

@section('content')
  <div class="container p-2 mt-2 bg-dark rounded bg-opacity-25 shadow-lg">
    <livewire:articles::show-and-search-articles />
    <br>
  </div>
@stop
