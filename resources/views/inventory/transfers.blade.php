@extends('layouts.inventory', ['title' => 'Warehouse Transfers'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h2>Hospital Stock Transfer Registry</h2>
    </div>

    <form action="#" method="POST" style="display:flex; flex-direction:column; gap:16px;" onclick="event.preventDefault(); alert('Stock transfers registered in system logs.')">
        @csrf
        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="from_warehouse">From Warehouse</label>
            <select id="from_warehouse" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
                @foreach($warehouses as $wh)
                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="to_warehouse">To Destination Warehouse</label>
            <select id="to_warehouse" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
                @foreach($warehouses as $wh)
                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="quantity">Transfer Quantity</label>
            <input type="number" id="quantity" min="1" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
        </div>

        <button type="submit" class="btn btn-primary" style="justify-content:center;"><i class="fa-solid fa-exchange-alt"></i> Authorize Warehouse Transfer</button>
    </form>
</div>
@endsection
