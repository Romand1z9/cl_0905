@extends(env('THEME').'.layouts.app')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('slider')
    {!! $slider !!}
@endsection

@section('content')
    {!! $portfolio !!}
@endsection

@section('sidebar')
    {!! $right_bar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection