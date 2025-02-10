@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 20px;">
    <div style="background: white; padding: 10px; border: 2px solid #ddd; border-radius: 10px; display: inline-block; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
        {!! QrCode::size(200)->margin(2)->generate($kode_barang) !!}
    </div>
    <p style="margin-top: 10px; font-size: 16px; font-weight: bold; color: #333;">Kode: {{ $kode_barang }}</p>
</div>
