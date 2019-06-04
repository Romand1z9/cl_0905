@extends(env('THEME').'.layouts.app')

@section('navigation')
    {!! $navigation !!}
@endsection


@section('content')
    {!! $content !!}
@endsection


@section('bar')
    {!!  $left_bar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection

