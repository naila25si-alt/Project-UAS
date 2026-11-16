@extends('layouts.app')

@section('title', 'New Booking | LabInvent : Podcast')

@section('content')
<h1 class="page-title">New Booking - Podcast Studio</h1>

@if ($errors->any())
    <div class="alert">{{ $errors->first() }}</div>
@endif
@if (session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('booking.store') }}">
    @csrf

    {{-- 1. PILIH STUDIO --}}
    <h2>1. Select a Studio</h2>
    <div class="studio-grid">
        @foreach ($studios as $studio)
            <label class="studio-card">
                <input type="radio" name="studio" value="{{ $studio['id'] }}"
                       {{ old('studio', 'A') === $studio['id'] ? 'checked' : '' }}>
                <div class="studio-body">
                    {{-- Ganti .studio-img dengan <img src="{{ asset('images/studio-a.jpg') }}"> bila foto sudah ada --}}
                    <div class="studio-img" style="background: {{ $studio['color'] }}"></div>
                    <strong>{{ $studio['name'] }}</strong>
                    <small>Capacity : {{ $studio['capacity'] }}</small>
                    <small>Features: {{ $studio['features'] }}</small>
                </div>
            </label>
        @endforeach
    </div>

    {{-- 2. TANGGAL & JAM --}}
    <h2>2. Date &amp; Time</h2>
    <div class="row">
        <div class="field">
            <label for="start_date">Start Date &amp; Time</label>
            <div class="inline">
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}" required>
                <input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
            </div>
        </div>
        <div class="field">
            <label for="end_date">End Date &amp; Time</label>
            <div class="inline">
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', now()->toDateString()) }}" required>
                <input type="time" name="end_time" value="{{ old('end_time', '13:00') }}" required>
            </div>
        </div>
    </div>

    {{-- 3. DETAIL --}}
    <h2>3. Booking Details</h2>
    <div class="field">
        <label for="purpose">Purpose / Description</label>
        <input type="text" id="purpose" name="purpose" class="wide" placeholder="e.g., Interview" value="{{ old('purpose') }}" required>
    </div>

    <div class="field">
        <label for="participants">Number of Participants</label>
        <div class="inline">
            <select id="participants" name="participants">
                @for ($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}" {{ (int) old('participants', 2) === $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <button type="button" class="btn-outline">Add Participants</button>
        </div>
    </div>

    {{-- 4. ALAT --}}
    <h2>4. Equipment</h2>
    <div class="equipment">
        @foreach ($equipments as $item)
            <label class="check">
                <input type="checkbox" name="equipment[]" value="{{ $item }}"
                       {{ in_array($item, old('equipment', [])) ? 'checked' : '' }}>
                {{ $item }}
            </label>
        @endforeach
        <button type="button" class="btn-dark">Add More</button>
    </div>

    {{-- TOMBOL --}}
    <div class="actions">
        <a href="{{ route('dashboard') }}" class="btn-back">Back</a>
        <button type="submit" class="btn-primary">Review Booking</button>
    </div>
</form>
@endsection
