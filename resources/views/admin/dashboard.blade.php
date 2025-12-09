@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-12">
            <x-admin.ecommerce-metrics :productCount="$productCount" :pendingOrderCount="$pendingOrderCount"
                :customerCount="$customerCount" />
            <x-admin.monthly-sale />
        </div>
        <div class="col-span-12 xl:col-span-12">
            <x-admin.recent-orders :orders="$recentOrders" :customerCount="$customerCount"
                :productCount="$productCount" />
        </div>
    </div>
@endsection
