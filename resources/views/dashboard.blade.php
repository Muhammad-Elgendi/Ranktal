@extends('layouts.main')
@section('direction',in_array(app()->getLocale(),config('app.rtl')) ? "rtl" : "ltr")
@section('title', __('dashboard'))

@section('styles','')


@section('content','')


@section('scripts','')


@section('user-image',url('/img/user.png'))


@section('user-type',__('pro-plan'))