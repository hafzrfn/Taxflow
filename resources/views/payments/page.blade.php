@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Payment for {{ $payment->kode_billing }}</h2>
        <p>Amount: Rp {{ number_format($payment->jumlah_bayar,0,',','.') }}</p>
        <p>Status: <strong>{{ $payment->status }}</strong></p>

        @if(session('success'))
            <div class="bg-green-100 p-2 rounded mt-3">{{ session('success') }}</div>
        @endif

        @if($payment->status !== 'SUCCESS')
        <form method="POST" action="{{ route('payment.simulate', ['kode' => $payment->kode_billing]) }}">
            @csrf
            <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Simulate Pay (Local)</button>
        </form>
        @endif
    </div>
</div>
@endsection
